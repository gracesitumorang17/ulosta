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
        // Resolve seller id from available guards or user role
        $sellerId = Auth::id();
        // If app uses a custom guard named 'seller', try that as fallback
        try {
            if (empty($sellerId) && method_exists(Auth::guard(), 'id') && Auth::guard('seller')->check()) {
                $sellerId = Auth::guard('seller')->id();
            }
        } catch (\Throwable $e) {
            // ignore missing guard
        }
        // If still empty, try to read role from user model
        if (empty($sellerId) && Auth::check() && (Auth::user()->role ?? '') === 'seller') {
            $sellerId = Auth::user()->id;
        }

        // Query orders where:
        // 1) orders.seller_id matches, OR
        // 2) order has order_items with seller_id matching, OR
        // 3) order has order_items whose product.seller_id matches
        $orders = Order::where('seller_id', $sellerId)
            ->orWhere(function ($q) use ($sellerId) {
                $q->whereHas('orderItems', function ($subq) use ($sellerId) {
                    $subq->where('seller_id', $sellerId);
                });
            })
            ->orWhere(function ($q) use ($sellerId) {
                $q->whereHas('orderItems.product', function ($subq) use ($sellerId) {
                    $subq->where('seller_id', $sellerId);
                });
            })
            ->with(['user', 'orderItems.product'])
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

        // Load related items & products to avoid extra DB queries during authorization checks
        $order = Order::with(['orderItems.product'])->findOrFail($id);

        // Resolve current user/seller id robustly (handle custom guards)
        $userId = Auth::id();
        try {
            if (empty($userId) && method_exists(Auth::guard(), 'id') && Auth::guard('seller')->check()) {
                $userId = Auth::guard('seller')->id();
            }
        } catch (\Throwable $e) {
            // ignore missing guard
        }
        if (empty($userId) && Auth::check() && (Auth::user()->role ?? '') === 'seller') {
            $userId = Auth::user()->id;
        }

        if (empty($userId)) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'User not authenticated'], 401)
                : back()->with('error', 'Anda perlu masuk untuk melakukan aksi ini.');
        }

        // Authorization: try to determine ownership using loaded relations (in-memory checks)
        $isOwner = ($order->seller_id ?? null) == $userId;

        if (!$isOwner) {
            foreach ($order->orderItems as $item) {
                if ((int) ($item->seller_id ?? 0) === (int) $userId) {
                    $isOwner = true;
                    break;
                }
                if ($item->product && (int) (($item->product->seller_id ?? 0)) === (int) $userId) {
                    $isOwner = true;
                    break;
                }
            }
        }

        if (!$isOwner) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Unauthorized - not owner of this order'], 403)
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
