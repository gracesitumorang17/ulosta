<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    // Menampilkan daftar pesanan masuk
    public function index()
    {
        $orders = Order::where('seller_id', Auth::id())
            ->with(['user', 'orderItems'])
            ->latest()
            ->get();

        return view('seller.orders.index', compact('orders'));
    }

    // Update status pesanan (Diproses, Dikirim, Selesai, Dibatalkan)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded'
        ]);

        $order = Order::findOrFail($id);
        // Authorization: only the owning seller can update
        if ($order->seller_id !== Auth::id()) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Unauthorized'], 403)
                : back()->with('error', 'Tidak diizinkan memperbarui pesanan ini.');
        }
        $order->status = $request->status;
        // Set timestamps based on status
        if ($request->status === 'shipped' && !$order->shipped_at) {
            $order->shipped_at = now();
        }
        if ($request->status === 'delivered' && !$order->delivered_at) {
            $order->delivered_at = now();
        }
        $order->save();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'status' => $order->status]);
        }
        return back()->with('success', 'Status pesanan diperbarui.');
    }

    // Detail pesanan
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        return view('seller.orders.show', compact('order'));
    }

    // Verifikasi pembayaran manual oleh penjual
    public function verifyPayment(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:accept,processing,reject',
            'note' => 'nullable|string',
            'proof_url' => 'nullable|string',
        ]);

        $order = Order::with(['orderItems.product'])->findOrFail($id);

        // Authorization: hanya penjual pemilik item dalam order
        $ownsOrder = $order->orderItems()->whereHas('product', function ($q) {
            $q->where('seller_id', Auth::id());
        })->exists();
        if (!$ownsOrder) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Unauthorized'], 403)
                : back()->with('error', 'Tidak diizinkan memverifikasi pembayaran pesanan ini.');
        }

        switch ($request->action) {
            case 'accept':
                $order->payment_status = Order::PAYMENT_PAID;
                break;
            case 'processing':
                $order->payment_status = Order::PAYMENT_PENDING;
                $order->status = Order::STATUS_PROCESSING;
                break;
            case 'reject':
                $order->payment_status = Order::PAYMENT_FAILED;
                break;
        }

        $order->payment_verified_by = Auth::id();
        $order->payment_verified_at = now();
        if ($request->filled('note')) {
            $order->payment_proof_note = $request->note;
        }
        if ($request->filled('proof_url')) {
            $order->payment_proof_url = $request->proof_url;
        }
        $order->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'payment_status' => $order->payment_status,
                'status' => $order->status,
            ]);
        }
        return back()->with('success', 'Verifikasi pembayaran tersimpan.');
    }
}
