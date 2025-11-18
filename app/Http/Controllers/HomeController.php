<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get cart count for authenticated user
        $cartCount = 0;
        $wishlistCount = 0;
        
        if (Auth::check()) {
            $cartCount = Auth::user()->cartItems()->sum('quantity');
            $wishlistCount = Auth::user()->wishlists()->count();
        }

        // Get search query
        $search = $request->input('q');

        // Get products from database
        $query = Product::active();

        // Apply search filter if search query exists
        if ($search) {
            $query->search($search);
        }

        $productsData = $query->orderBy('created_at', 'desc')->get();

        // Format products for view
        $products = $productsData->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'tag' => $product->tag,
                'price' => $product->formatted_price,
                'original' => $product->formatted_original_price ?? $product->formatted_price,
                'image' => $product->image,
                'desc' => $product->description,
            ];
        })->toArray();

        return view('welcomelogin', compact('cartCount', 'wishlistCount', 'products', 'search'));
    }
}