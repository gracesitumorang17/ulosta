<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // If user is admin, redirect directly to admin dashboard
        if (Auth::check() && (Auth::user()->role ?? '') === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // For buyers and sellers (logged in users) or guests, show appropriate homepage
        // Get cart/wishlist counts for logged in users
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

        // Format products for view (from DB)
        $products = $productsData->map(function ($product) {
            // Tentukan URL gambar yang dapat diakses publik:
            // 1) Gunakan accessor image_url jika tersedia dan tidak kosong
            // 2) Jika tidak ada, gunakan Storage::url($product->image) bila pathnya ada
            // 3) Terakhir, fallback ke placeholder di public/image
            $imageUrl = null;

            try {
                $imageUrl = $product->image_url ?: null;
            } catch (\Throwable $e) {
                $imageUrl = null;
            }

            if (!$imageUrl) {
                if (!empty($product->image)) {
                    try {
                        $imageUrl = Storage::url($product->image);
                    } catch (\Throwable $e) {
                        $imageUrl = null;
                    }
                }
            }

            if (!$imageUrl) {
                $imageUrl = asset('image/placeholder.png');
            }

            return [
                'id' => $product->id,
                'name' => $product->name,
                'tag' => $product->tag,
                'price' => $product->formatted_price,
                'image' => $product->image,
                'image_url' => $imageUrl,
                'description' => $product->description,
                'desc' => $product->description,
                'category' => $product->category ?? '',
                'function' => $product->function ?? '',
            ];
        })->toArray();

        // Hapus dependensi session custom_products agar tidak terjadi duplikasi.
        // Pembeli hanya melihat data dari database (products + product_images via accessor image_url).

        // Return appropriate view based on authentication status
        if (Auth::check()) {
            // For logged in users (buyers), use welcomelogin view with cart/wishlist data
            return view('welcomelogin', compact('cartCount', 'wishlistCount', 'products', 'search', 'jenisFilter', 'fungsiFilter'));
        } else {
            // For guests, use welcome view
            return view('welcome', compact('products', 'search', 'jenisFilter', 'fungsiFilter'));
        }
    }
}
