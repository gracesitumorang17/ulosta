<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    public function index()
    {
        $items = CartItem::where('user_id', Auth::id())->with('product')->get();

        // Tambahkan image_url ke setiap item menggunakan setAttribute
        foreach ($items as $item) {
            $imageUrl = asset('image/Background.png');

            // Prioritas 1: Gunakan product->image_url jika ada relasi product
            if ($item->product && !empty($item->product->image)) {
                $imageUrl = $item->product->image_url;
            }
            // Prioritas 2: Gunakan raw cart item image jika ada
            elseif (!empty($item->image)) {
                // Check if it's a storage path (contains /) atau just filename
                if (strpos($item->image, '/') !== false) {
                    // Storage path like "products/20/..."
                    $imageUrl = Storage::url($item->image);
                } else {
                    // Simple filename like "Ulos Sadum.jpeg"
                    $imageUrl = asset('image/' . $item->image);
                }
            }

            // Tambahkan sebagai attribute
            $item->setAttribute('image_url', $imageUrl);
        }

        $subtotal = $items->sum(fn($i) => $i->price * $i->quantity);
        $shipping = $items->isNotEmpty() ? 25000 : 0;
        $total = $subtotal + $shipping;

        return view('keranjang', compact('items', 'subtotal', 'shipping', 'total'));
    }

    public function store(Request $request)
    {
        // Authorization handled by auth middleware; removed invalid gate call to prevent 403
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'product_id' => 'nullable|integer',
            'tag' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:255',
            'price' => 'required|string', // e.g. "Rp.800.000"
            'qty' => 'nullable|integer|min:1'
        ]);

        $price = (int) preg_replace('/[^0-9]/', '', $data['price']);
        $qty = $data['qty'] ?? 1;

        // Resolve product from DB to ensure we store storage-based image path
        $product = null;
        if (!empty($data['product_id'])) {
            $product = \App\Models\Product::find($data['product_id']);
        }
        if (!$product) {
            $product = \App\Models\Product::where('name', $data['name'])->first();
        }

        $item = CartItem::firstOrNew([
            'user_id' => Auth::id(),
            'product_name' => $data['name'],
        ]);
        if ($item->exists) {
            $item->quantity += $qty;
        } else {
            $item->fill([
                // Persist product_id for checkout seller resolution
                'product_id' => $product?->id ?? null,
                // Persist seller_id to avoid later null resolution
                'seller_id' => $product?->seller_id ?? null,
                'tag' => $product?->tag ?? ($data['tag'] ?? null),
                // Store relative storage path from product if available; avoid public/image
                'image' => $product?->image ?: null,
                // Prefer product price from DB to ensure consistency
                'price' => $product ? (int) $product->price : $price,
                'quantity' => $qty,
            ]);
        }
        $item->save();

        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke keranjang',
            'count' => CartItem::where('user_id', Auth::id())->sum('quantity')
        ]);
    }

    public function updateQty(Request $request, CartItem $item)
    {
        abort_unless($item->user_id === Auth::id(), 403);
        $data = $request->validate(['qty' => 'required|integer|min:1']);
        $item->quantity = $data['qty'];
        $item->save();
        return back()->with('success', 'Quantity berhasil diperbarui');
    }

    public function destroy(CartItem $item)
    {
        abort_unless($item->user_id === Auth::id(), 403);
        $item->delete();

        $count = CartItem::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari keranjang',
            'count' => $count
        ]);
    }

    public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Keranjang berhasil dikosongkan');
    }

    public function getCount()
    {
        $count = CartItem::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['count' => $count]);
    }
}
