<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    use ApiResponse;

    /**
     * Get user's wishlist
     */
    public function index(Request $request)
    {
        $wishlist = Wishlist::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        return $this->successResponse([
            'items' => $wishlist,
            'count' => $wishlist->count()
        ], 'Wishlist retrieved successfully');
    }

    /**
     * Add item to wishlist
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return $this->errorResponse('Product already in wishlist');
        }

        $product = Product::find($request->product_id);

        $wishlistItem = Wishlist::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
            'product_name' => $product->name,
            'product_image' => $product->image,
            'product_price' => $product->price,
            'product_original_price' => $product->original_price,
        ]);

        $wishlistItem->load('product');

        return $this->successResponse($wishlistItem, 'Product added to wishlist', 201);
    }

    /**
     * Remove item from wishlist
     */
    public function destroy(Request $request, $id)
    {
        $wishlistItem = Wishlist::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$wishlistItem) {
            return $this->notFoundResponse('Wishlist item not found');
        }

        $wishlistItem->delete();

        return $this->successResponse(null, 'Item removed from wishlist');
    }

    /**
     * Get wishlist count
     */
    public function count(Request $request)
    {
        $count = Wishlist::where('user_id', $request->user()->id)->count();

        return $this->successResponse(['count' => $count], 'Wishlist count retrieved successfully');
    }
}
