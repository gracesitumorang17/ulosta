<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\SellerNewOrderNotification;

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

        // Tetapkan ongkir flat Rp 15.000, tapi gratis jika subtotal >= Rp 500.000
        $shipping = $subtotal >= 500000 ? 0 : 15000;

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

        // Tetapkan ongkir flat Rp 15.000, tapi gratis jika subtotal >= Rp 500.000
        $shipping = $subtotal >= 500000 ? 0 : 15000;

        $total = $subtotal + $shipping;

        // Resolve product ids and seller ids for items
        $resolved = collect();
        foreach ($items as $item) {
            $pid = $item->product_id;
            $product = null;
            if ($pid) {
                $product = \App\Models\Product::find($pid);
            }
            if (!$product && $item->product_name) {
                $product = \App\Models\Product::where('name', $item->product_name)->first();
                if ($product) {
                    $pid = $product->id;
                }
            }
            $resolved->push([ 'cart' => $item, 'product' => $product, 'product_id' => $pid, 'seller_id' => $product?->seller_id ]);
        }

        // Determine distinct sellers in cart
        $sellerIds = $resolved->pluck('seller_id')->filter()->unique()->values();
        if ($sellerIds->count() === 0) {
            return redirect()->route('checkout')
                ->withInput()
                ->with('error', 'Tidak dapat memproses pesanan karena penjual untuk produk di keranjang belum terdata.');
        }

        // If more than one seller, reject (marketplace: split-order required)
        if ($sellerIds->count() > 1) {
            return redirect()->route('checkout')
                ->withInput()
                ->with('error', 'Keranjang berisi produk dari beberapa penjual. Silakan pisahkan per penjual atau hapus beberapa item.');
        }

        $sellerId = $sellerIds->first();

        // All good: create order and items inside transaction
        $order = null;
        DB::transaction(function () use ($request, $subtotal, $shipping, $total, $sellerId, $resolved, &$order) {
            // Generate order number
            $orderNumber = date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

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

            foreach ($resolved as $row) {
                $item = $row['cart'];
                $pid = $row['product_id'];
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
        });

        // Clear cart
        CartItem::where('user_id', Auth::id())->delete();

        // Notify seller if available
        if ($sellerId) {
            $seller = User::find($sellerId);
            if ($seller) {
                try {
                    $seller->notify(new SellerNewOrderNotification($order));
                } catch (\Throwable $e) {
                    // ignore notification failures to not block checkout
                }
            }
        }

        // Redirect to detail pembayaran
        return redirect()->route('detail.pembayaran', ['orderId' => $order->id]);
    }

    public function detailPembayaran($orderId)
    {
        $order = \App\Models\Order::with(['items'])->findOrFail($orderId);

        // Allow access to buyer, the seller of the order, or an admin
        $me = Auth::user();
        $isBuyer = $order->user_id === $me->id;
        $isSeller = isset($order->seller_id) && $order->seller_id === $me->id;
        $isAdmin = ($me->role ?? '') === 'admin';
        if (!($isBuyer || $isSeller || $isAdmin)) {
            abort(403, 'Unauthorized access');
        }

        return view('detail_pembayaran', compact('order'));
    }

    public function instruksiPembayaran($orderId)
    {
        $order = \App\Models\Order::with(['items'])->findOrFail($orderId);

        // Allow access to buyer, the seller of the order, or an admin
        $me = Auth::user();
        $isBuyer = $order->user_id === $me->id;
        $isSeller = isset($order->seller_id) && $order->seller_id === $me->id;
        $isAdmin = ($me->role ?? '') === 'admin';
        if (!($isBuyer || $isSeller || $isAdmin)) {
            abort(403, 'Unauthorized access');
        }

        return view('instruksi_pembayaran', compact('order'));
    }

    // Tandai waktu pengajuan bukti pembayaran oleh pembeli (sebelum redirect ke WhatsApp)
    public function markProofSubmitted($orderId)
    {
        $order = \App\Models\Order::findOrFail($orderId);
        if ($order->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        $order->payment_proof_submitted_at = now();
        $order->save();
        return response()->json(['success' => true]);
    }
}
