<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $items = CartItem::where('user_id', Auth::id())->get();
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
            'tag' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:255',
            'price' => 'required|string', // e.g. "Rp.800.000"
            'original' => 'nullable|string',
            'qty' => 'nullable|integer|min:1'
        ]);

        $price = (int) preg_replace('/[^0-9]/', '', $data['price']);
        $original = isset($data['original']) ? (int) preg_replace('/[^0-9]/', '', $data['original']) : null;
        $qty = $data['qty'] ?? 1;

        $item = CartItem::firstOrNew([
            'user_id' => Auth::id(),
            'product_name' => $data['name'],
        ]);
        if ($item->exists) {
            $item->quantity += $qty;
        } else {
            $item->fill([
                'tag' => $data['tag'] ?? null,
                'image' => $data['image'] ?? null,
                'price' => $price,
                'original_price' => $original,
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
        return back();
    }

    public function destroy(CartItem $item)
    {
        abort_unless($item->user_id === Auth::id(), 403);
        $item->delete();
        return back();
    }
}
