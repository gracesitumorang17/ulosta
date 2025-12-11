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

        $subtotal = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Tetapkan ongkir flat Rp 15.000
        $shipping = 15000;

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
        ]);

        // Get cart items
        $items = CartItem::where('user_id', Auth::id())->get();

        if ($items->count() === 0) {
            return redirect()->route('keranjang')->with('error', 'Keranjang Anda kosong!');
        }

        // Calculate totals
        $subtotal = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Tetapkan ongkir flat Rp 15.000
        $shipping = 15000;

        $total = $subtotal + $shipping;

        // Tentukan seller untuk pesanan ini tanpa menulis ke tabel cart_items
        // 1) Coba dari product_id yang ada di keranjang
        $productIds = $items->pluck('product_id')->filter()->unique();
        $sellerId = null;
        if ($productIds->isNotEmpty()) {
            $sellerId = \App\Models\Product::whereIn('id', $productIds)
                ->pluck('seller_id')->filter()->unique()->first();
        }
        // 2) Jika product_id kosong, fallback berdasarkan nama produk di keranjang
        if (!$sellerId) {
            $names = $items->pluck('product_name')->filter()->unique();
            if ($names->isNotEmpty()) {
                $sellerId = \App\Models\Product::whereIn('name', $names)
                    ->pluck('seller_id')->filter()->unique()->first();
            }
        }
        // 3) Jika masih null, gagalkan dengan pesan yang jelas dan kembalikan input form
        if (!$sellerId) {
            return redirect()->route('checkout')
                ->withInput()
                ->with('error', 'Tidak dapat memproses pesanan karena penjual untuk produk di keranjang belum terdata.');
        }

        // Generate order number
        $orderNumber = date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        // Create order (support legacy columns like total_price/order_code)
        $order = \App\Models\Order::create([
            'user_id' => Auth::id(),
            'seller_id' => $sellerId,
            'order_number' => $orderNumber,
            'status' => 'pending',
            'payment_status' => 'pending',
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'total_amount' => $total,
            // Legacy column compatibility
            'total_price' => $total,
            'shipping_first_name' => $request->nama_lengkap,
            'shipping_phone' => $request->nomor_telepon,
            'shipping_address_1' => $request->alamat_lengkap,
            'shipping_city' => $request->kota,
            'shipping_postal_code' => $request->kode_pos,
        ]);

        // Create order items
        foreach ($items as $item) {
            // Pastikan product_id terisi untuk OrderItem jika memungkinkan
            $pid = $item->product_id;
            if (!$pid && $item->product_name) {
                $pid = optional(\App\Models\Product::where('name', $item->product_name)->first())->id;
            }
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $pid,
                'product_name' => $item->product_name,
                'product_image' => $item->image,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->price * $item->quantity,
                'total' => $item->price * $item->quantity,
            ]);
        }

        // Clear cart
        CartItem::where('user_id', Auth::id())->delete();

        // Redirect to detail pembayaran
        return redirect()->route('detail.pembayaran', ['orderId' => $order->id]);
    }

    public function detailPembayaran($orderId)
    {
        $order = \App\Models\Order::with(['items'])->findOrFail($orderId);

        // Make sure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('detail_pembayaran', compact('order'));
    }

    public function instruksiPembayaran($orderId)
    {
        $order = \App\Models\Order::with(['items'])->findOrFail($orderId);

        // Make sure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('instruksi_pembayaran', compact('order'));
    }
}
