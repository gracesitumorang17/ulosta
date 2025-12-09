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
            'metode_pembayaran' => 'required|string|in:mandiri,bca,dana,gopay,ovo,cod',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('masuk');
        }

        $items = CartItem::where('user_id', $userId)->with('product')->get();
        if ($items->isEmpty()) {
            \Log::warning('[Checkout] Keranjang kosong untuk user_id=' . $userId);
            return redirect()->route('keranjang')->with('error', 'Keranjang Anda kosong!');
        }

        // Compute shipping based on subtotal
        $subtotalAll = $items->sum(function ($item) {
            $price = (float) (optional($item->product)->price ?? $item->price ?? 0);
            return $price * (int) $item->quantity;
        });
        $shippingAll = $subtotalAll >= 500000 ? 0 : 15000;

        \DB::beginTransaction();
        try {
            // Group items by seller_id (owner of product)
            $grouped = $items->groupBy(function ($ci) {
                return optional($ci->product)->user_id ?: 0;
            });

            foreach ($grouped as $sellerId => $group) {
                if ($sellerId) {
                    $sellerExists = \App\Models\User::where('id', $sellerId)->exists();
                    if (!$sellerExists) {
                        \Log::warning('[Checkout] seller_id tidak valid: ' . $sellerId . ' -> diset null');
                        $sellerId = null;
                    }
                }
                $subtotal = 0;
                foreach ($group as $ci) {
                    $price = (float) (optional($ci->product)->price ?? $ci->price ?? 0);
                    $subtotal += $price * (int) $ci->quantity;
                }
                $shipping = $subtotal >= 500000 ? 0 : 15000;
                $tax = 0;
                $discount = 0;
                $total = $subtotal + $shipping + $tax - $discount;

                // Create order
                $order = new \App\Models\Order();
                $order->user_id = $userId;
                $order->seller_id = $sellerId ?: null;
                $order->order_number = \App\Models\Order::generateOrderNumber();
                $order->status = \App\Models\Order::STATUS_PENDING;
                $order->payment_status = \App\Models\Order::PAYMENT_PENDING;
                $order->payment_method = $request->input('metode_pembayaran');
                $order->shipping_method = 'standard';
                $order->subtotal = $subtotal;
                $order->shipping_cost = $shipping;
                $order->tax_amount = $tax;
                $order->discount_amount = $discount;
                $order->total_amount = $total;
                $order->currency = 'IDR';

                // Minimal address fill from form
                $order->shipping_first_name = $request->input('nama_lengkap');
                $order->shipping_last_name = '';
                $order->shipping_phone = $request->input('nomor_telepon');
                $order->shipping_address_1 = $request->input('alamat_lengkap');
                $order->shipping_city = $request->input('kota');
                $order->shipping_postal_code = $request->input('kode_pos');
                $order->shipping_country = 'ID';

                // Copy to billing
                $order->billing_first_name = $order->shipping_first_name;
                $order->billing_last_name = $order->shipping_last_name;
                $order->billing_phone = $order->shipping_phone;
                $order->billing_address_1 = $order->shipping_address_1;
                $order->billing_city = $order->shipping_city;
                $order->billing_postal_code = $order->shipping_postal_code;
                $order->billing_country = $order->shipping_country;

                $order->save();
                \Log::info('[Checkout] Order dibuat id=' . $order->id . ' user_id=' . $userId . ' seller_id=' . (string)$order->seller_id . ' total=' . $order->total_amount);

                // Create order items
                foreach ($group as $ci) {
                    $product = $ci->product;
                    $oi = new \App\Models\OrderItem();
                    $oi->order_id = $order->id;
                    $oi->product_id = optional($product)->id;
                    $oi->product_name = optional($product)->name ?? ($ci->name ?? 'Produk');
                    $oi->product_sku = optional($product)->sku ?? null;
                    $oi->product_image = optional($product)->image ?? null;
                    $oi->quantity = (int) $ci->quantity;
                    $oi->price = (float) (optional($product)->price ?? $ci->price ?? 0);
                    $oi->total = $oi->quantity * $oi->price;
                    $oi->save();
                }
            }

            // Clear cart after creating orders
            CartItem::where('user_id', $userId)->delete();

            \DB::commit();
            return redirect()->route('homepage')->with('success', 'Pesanan berhasil dibuat.');
        } catch (\Throwable $e) {
            \DB::rollBack();
            \Log::error('[Checkout] Gagal membuat pesanan: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Gagal membuat pesanan. Silakan coba lagi atau cek keranjang Anda.');
        }
    }
}
