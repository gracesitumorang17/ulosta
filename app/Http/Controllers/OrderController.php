<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Daftar pesanan pembeli
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.product')
            ->latest()
            ->get();

        return view('buyer.orders.index', compact('orders'));
    }

    // Detail pesanan pembeli
    public function show($order_number)
    {
        $order = Order::where('order_number', $order_number)
            ->where('user_id', Auth::id())
            ->with('orderItems.product')
            ->firstOrFail();

        return view('buyer.orders.show', compact('order'));
    }
}
