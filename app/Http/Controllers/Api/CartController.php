<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    use ApiResponse;

    /**
     * Get user's cart
     */
    public function index(Request $request)
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        // Filter out items with deleted products and calculate total
        $validItems = $cartItems->filter(function ($item) {
            return $item->product !== null;
        });

        $total = $validItems->sum(function ($item) {
            // Use price from cart_items table (stored price)
            return $item->price * $item->quantity;
        });

        return $this->successResponse([
            'items' => $validItems->values(),
            'total' => $total,
            'item_count' => $validItems->count()
        ], 'Cart retrieved successfully');
    }

    /**
     * Add item to cart
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        $product = Product::find($request->product_id);

        if (!$product->is_active || $product->stock < $request->quantity) {
            return $this->errorResponse('Product not available or insufficient stock');
        }

        // Check if item already in cart
        $cartItem = CartItem::where('user_id', $request->user()->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if ($product->stock < $newQuantity) {
                return $this->errorResponse('Insufficient stock');
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            $cartItem = CartItem::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id,
                'product_name' => $product->name,
                'tag' => $product->tag,
                'image' => $product->image,
                'price' => $product->price,
                'original_price' => $product->original_price,
                'quantity' => $request->quantity,
            ]);
        }

        $cartItem->load('product');

        return $this->successResponse($cartItem, 'Product added to cart successfully', 201);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        $cartItem = CartItem::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$cartItem) {
            return $this->notFoundResponse('Cart item not found');
        }

        $product = $cartItem->product;

        if ($product->stock < $request->quantity) {
            return $this->errorResponse('Insufficient stock');
        }

        $cartItem->update(['quantity' => $request->quantity]);
        $cartItem->load('product');

        return $this->successResponse($cartItem, 'Cart updated successfully');
    }

    /**
     * Remove item from cart
     */
    public function destroy(Request $request, $id)
    {
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$cartItem) {
            return $this->notFoundResponse('Cart item not found');
        }

        $cartItem->delete();

        return $this->successResponse(null, 'Item removed from cart');
    }

    /**
     * Clear all cart items
     */
    public function clear(Request $request)
    {
        CartItem::where('user_id', $request->user()->id)->delete();

        return $this->successResponse(null, 'Cart cleared successfully');
    }

    /**
     * Get cart item count
     */
    public function count(Request $request)
    {
        $count = CartItem::where('user_id', $request->user()->id)->count();

        return $this->successResponse(['count' => $count], 'Cart count retrieved successfully');
    }
}
