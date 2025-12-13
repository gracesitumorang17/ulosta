<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;

class OrdersApiController extends Controller
{
    // GET /api/v1/orders
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
        }

        $orders = Order::where('user_id', $user->id)
            ->with(['orderItems', 'orderItems.product'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($order) {
                return [
                    'order_number' => $order->order_number ?? (string)$order->id,
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'total_amount' => $order->total_amount,
                    'created_at' => $order->created_at?->toIso8601String(),
                ];
            });

        return response()->json(['success' => true, 'data' => $orders]);
    }

    // GET /api/v1/orders/{order_number}
    public function show(Request $request, string $order_number)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
        }

        $order = Order::where('order_number', $order_number)
            ->orWhere('id', $order_number)
            ->where('user_id', $user->id)
            ->with(['orderItems', 'orderItems.product'])
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'error' => 'Order not found'], 404);
        }

        $payload = [
            'order_number' => $order->order_number ?? (string)$order->id,
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'total_amount' => $order->total_amount,
            'created_at' => $order->created_at?->toIso8601String(),
            'items' => $order->orderItems->map(function ($item) {
                return [
                    'product_name' => $item->product_name ?? $item->product?->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity ?? 1,
                ];
            }),
            'payment' => [
                'bank_name' => $order->payment_bank_name,
                'bank_account_number' => $order->payment_bank_account_number,
                'bank_account_name' => $order->payment_bank_account_name,
                'destination_type' => $order->payment_destination_type,
            ],
        ];

        return response()->json(['success' => true, 'data' => $payload]);
    }
}
