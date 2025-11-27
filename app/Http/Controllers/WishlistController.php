<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->latest()->get();
        $wishlistCount = $wishlists->count();
        
        return view('wishlist', compact('wishlists', 'wishlistCount'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|string',
            'price' => 'required|string',
            'original' => 'nullable|string',
            'tag' => 'nullable|string',
        ]);

        // Check if already exists
        $existing = Wishlist::where('user_id', Auth::id())
                           ->where('product_name', $data['name'])
                           ->first();

        if ($existing) {
            // Remove from wishlist
            $existing->delete();
            
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Dihapus dari wishlist',
                'count' => Wishlist::where('user_id', Auth::id())->count()
            ]);
        } else {
            // Add to wishlist - convert price strings to decimal
            $price = (float) str_replace(['Rp', '.', ' '], '', $data['price']);
            $originalPrice = (float) str_replace(['Rp', '.', ' '], '', $data['original'] ?? '0');
            
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_name' => $data['name'],
                'product_image' => $data['image'] ?? null,
                'product_price' => $price,
                'product_original_price' => $originalPrice > 0 ? $originalPrice : null,
            ]);
            
            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Ditambahkan ke wishlist',
                'count' => Wishlist::where('user_id', Auth::id())->count()
            ]);
        }
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
                           ->where('id', $id)
                           ->first();

        if (!$wishlist) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }

        $wishlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari wishlist',
            'count' => Wishlist::where('user_id', Auth::id())->count()
        ]);
    }

    public function getCount()
    {
        $count = Wishlist::where('user_id', Auth::id())->count();
        
        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}
