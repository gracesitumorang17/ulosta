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
}
