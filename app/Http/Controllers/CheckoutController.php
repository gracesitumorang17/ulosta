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

        $shipping = 15000;
        if ($subtotal >= 500000) {
            $shipping = 0;
        }

        $total = $subtotal + $shipping;

        // Determine seller for this order
        // Previous behavior enforced 1 order = 1 seller and redirected when mixed.
        // To keep checkout smooth, proceed using the first seller if mixed; allow null if not found.
        // Ensure each cart item has seller_id; backfill from product if missing
        foreach ($items as $ci) {
            if (empty($ci->seller_id) && !empty($ci->product_id)) {
                $prod = \App\Models\Product::find($ci->product_id);
                if ($prod && !empty($prod->seller_id)) {
                    $ci->seller_id = $prod->seller_id;
                    $ci->save();
                }
            }
        }

        // Prefer seller_id persisted on cart items to avoid nulls
        $sellerIds = $items->pluck('seller_id')->filter()->unique();
        $sellerId = $sellerIds->first();
        // As a fallback, resolve from products if needed
        if (!$sellerId) {
            $productIds = $items->pluck('product_id')->filter();
            $sellerQuery = \App\Models\Product::whereIn('id', $productIds);
            $sellerIds = $sellerQuery->pluck('seller_id')->filter()->unique();
            $sellerId = $sellerIds->first();
            if (!$sellerId) {
                $firstProductWithSeller = (clone $sellerQuery)->whereNotNull('seller_id')->first();
                $sellerId = $firstProductWithSeller?->seller_id;
            }
        }
        // If still null, fail gracefully with a clear message
        if (!$sellerId) {
            return redirect()->route('checkout')->with('error', 'Tidak dapat memproses pesanan karena penjual untuk produk di keranjang belum terdata.');
        }

        // Generate order number
        $orderNumber = date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        // Create order
        $order = \App\Models\Order::create([
            'user_id' => Auth::id(),
            'seller_id' => $sellerId,
            'order_number' => $orderNumber,
            'status' => 'pending',
            'payment_status' => 'pending',
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'total_amount' => $total,
            'shipping_first_name' => $request->nama_lengkap,
            'shipping_phone' => $request->nomor_telepon,
            'shipping_address_1' => $request->alamat_lengkap,
            'shipping_city' => $request->kota,
            'shipping_postal_code' => $request->kode_pos,
        ]);

        // Create order items
        foreach ($items as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
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
