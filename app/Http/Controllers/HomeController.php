<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // If authenticated, show role-specific dashboards
        if (Auth::check()) {
            $role = Auth::user()->role ?? 'buyer';
            if ($role === 'admin') {
                return view('admin.admindashboard');
            }
            if ($role === 'seller') {
                return view('seller.dashboard');
            }
        }

        // Get cart/wishlist counts safely without assuming relations exist
        $cartCount = 0;
        $wishlistCount = 0;

        if (Auth::check()) {
            $user = Auth::user();
            // If relations exist, use them; otherwise keep defaults
            if (method_exists($user, 'cartItems')) {
                try {
                    $cartCount = (int) $user->cartItems()->sum('quantity');
                } catch (\Throwable $e) {
                    $cartCount = 0;
                }
            }
            if (method_exists($user, 'wishlists')) {
                try {
                    $wishlistCount = (int) $user->wishlists()->count();
                } catch (\Throwable $e) {
                    $wishlistCount = 0;
                }
            }
        }

        // Get search query and filters
        $search = $request->input('q');
        $jenisFilter = $request->input('jenis');
        $fungsiFilter = $request->input('fungsi');

        // Get products from database
        $query = Product::active();

        // Apply search filter if search query exists
        if ($search) {
            $query->search($search);
        }

        // Filter berdasarkan jenis ulos (kolom 'tag')
        if ($jenisFilter) {
            $query->where('tag', $jenisFilter);
        }

        // Filter berdasarkan fungsi ulos (kolom 'category')
        if ($fungsiFilter) {
            $query->where('category', $fungsiFilter);
        }

        $productsData = $query->orderBy('created_at', 'desc')->get();

        // Format products for view
        $products = $productsData->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'tag' => $product->tag,
                'price' => $product->formatted_price,
                'original' => $product->formatted_original_price ?? $product->formatted_price,
                'image' => $product->image,
                'desc' => $product->description,
                'category' => $product->category ?? '',
                'function' => $product->function ?? '',
            ];
        })->toArray();

        return view('welcomelogin', compact('cartCount', 'wishlistCount', 'products', 'search', 'jenisFilter', 'fungsiFilter'));
    }
}
