<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $items = CartItem::where('user_id', Auth::id())->get();
        
        if ($items->count() === 0) {
            return redirect()->route('keranjang')->with('error', 'Keranjang Anda kosong!');
        }

        $subtotal = $items->sum(function($item) {
            return $item->price * $item->quantity;
        });

        $shipping = 15000;
        
        // Free shipping if subtotal >= 500000
        if ($subtotal >= 500000) {
            $shipping = 0;
        }
        
        $total = $subtotal + $shipping;

        return view('pembayaran', compact('items', 'subtotal', 'shipping', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'kota' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
            'metode_pembayaran' => 'required|string|in:mandiri,bca,dana,gopay,ovo,cod',
        ]);

        // Here you would typically:
        // 1. Create order
        // 2. Create order items
        // 3. Clear cart
        // 4. Redirect to success page

        // For now, just redirect back with success message
        return redirect()->route('homepage')->with('success', 'Pesanan berhasil dibuat! Kami akan segera memproses pesanan Anda.');
    }
}
