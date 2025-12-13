<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use ApiResponse;

    /**
     * Get user's orders
     */
    public function index(Request $request)
    {
        $orders = Order::with('items.product')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->successResponse($orders, 'Orders retrieved successfully');
    }

    /**
     * Create new order
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        // Get cart items
        $cartItems = CartItem::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return $this->errorResponse('Cart is empty');
        }

        DB::beginTransaction();

        try {
            // Calculate total
            $total = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // Create order
            $order = Order::create([
                'order_code' => 'ORD-' . time() . '-' . $request->user()->id,
                'user_id' => $request->user()->id,
                'total_price' => $total,
                'status' => 'Menunggu',
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);

                // Update product stock
                $product = $cartItem->product;
                $product->stock -= $cartItem->quantity;
                $product->save();
            }

            // Clear cart
            CartItem::where('user_id', $request->user()->id)->delete();

            DB::commit();

            $order->load('items.product');

            return $this->successResponse($order, 'Order created successfully', 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to create order: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get single order
     */
    public function show(Request $request, $id)
    {
        $order = Order::with('items.product')
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$order) {
            return $this->notFoundResponse('Order not found');
        }

        return $this->successResponse($order, 'Order retrieved successfully');
    }

    /**
     * Cancel order
     */
    public function cancel(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$order) {
            return $this->notFoundResponse('Order not found');
        }

        if ($order->status !== 'Menunggu') {
            return $this->errorResponse('Cannot cancel order with status: ' . $order->status);
        }

        DB::beginTransaction();

        try {
            // Restore product stock
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->stock += $item->quantity;
                $product->save();
            }

            $order->update(['status' => 'Dibatalkan']);

            DB::commit();

            return $this->successResponse($order, 'Order cancelled successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to cancel order: ' . $e->getMessage(), 500);
        }
    }
}
