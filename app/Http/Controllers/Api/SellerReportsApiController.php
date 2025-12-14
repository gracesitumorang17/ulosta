<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class SellerReportsApiController extends Controller
{
    // Ringkasan laporan: hanya delivered dan milik seller yang login
    public function summary(Request $request)
    {
        $sellerId = Auth::id();

        // Catatan: status di DB menggunakan label Indonesia ('Selesai').
        // Agar kompatibel, terima keduanya: 'delivered' dan 'Selesai'.
        $ordersQuery = Order::query()
            ->whereIn('status', ['delivered', 'Selesai'])
            ->where(function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId)
                    ->orWhereHas('orderItems', function ($subq) use ($sellerId) {
                        $subq->where('seller_id', $sellerId);
                    })
                    ->orWhereHas('orderItems.product', function ($subq) use ($sellerId) {
                        $subq->where('seller_id', $sellerId);
                    });
            });

        $totalOrders = (clone $ordersQuery)->count();
        // Gunakan total_amount jika ada, fallback ke total_price (sesuai migrasi)
        $totalRevenue = (clone $ordersQuery)
            ->sum(\DB::raw('COALESCE(total_amount, total_price, 0)'));

        // Produk terjual: jumlah quantity dari order items yang terkait order delivered milik seller
        $productsSold = OrderItem::query()
            ->whereHas('order', function ($q) use ($sellerId) {
                $q->whereIn('status', ['delivered', 'Selesai'])
                    ->where(function ($qq) use ($sellerId) {
                        $qq->where('seller_id', $sellerId)
                            ->orWhereHas('orderItems', function ($qi) use ($sellerId) {
                                $qi->where('seller_id', $sellerId);
                            })
                            ->orWhereHas('orderItems.product', function ($qi) use ($sellerId) {
                                $qi->where('seller_id', $sellerId);
                            });
                    });
            })
            ->sum('quantity');

        // Fallback cepat: jika tidak ada delivered, gunakan paid atau selain dibatalkan
        if ($totalOrders === 0) {
            $fallbackQuery = Order::query()
                ->where(function ($q) {
                    $q->where('payment_status', 'paid')
                        ->orWhereNotIn('status', ['Dibatalkan', 'cancelled']);
                })
                ->where(function ($q) use ($sellerId) {
                    $q->where('seller_id', $sellerId)
                        ->orWhereExists(function ($sub) use ($sellerId) {
                            $sub->select(\DB::raw(1))
                                ->from('order_items as oi')
                                ->whereColumn('oi.order_id', 'orders.id')
                                ->where('oi.seller_id', $sellerId);
                        });
                });

            $totalOrders = (clone $fallbackQuery)->count();
            $totalRevenue = (clone $fallbackQuery)
                ->sum(\DB::raw('COALESCE(total_amount, total_price, 0)'));
            $productsSold = OrderItem::query()
                ->whereHas('order', function ($q) use ($sellerId) {
                    $q->where(function ($qq) {
                        $qq->where('payment_status', 'paid')
                            ->orWhereNotIn('status', ['Dibatalkan', 'cancelled']);
                    });
                    $q->where(function ($qq) use ($sellerId) {
                        $qq->where('seller_id', $sellerId)
                            ->orWhereHas('orderItems', function ($qi) use ($sellerId) {
                                $qi->where('seller_id', $sellerId);
                            });
                    });
                })
                ->sum('quantity');
        }

        $avgOrder = $totalOrders > 0 ? floor($totalRevenue / $totalOrders) : 0;

        return response()->json([
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'avgOrder' => $avgOrder,
            'productsSold' => $productsSold,
        ]);
    }

    // Transaksi terbaru: delivered milik seller, urut pakai delivered_at (fallback created_at)
    public function recentOrders(Request $request)
    {
        $sellerId = Auth::id();

        $orders = Order::query()
            ->whereIn('status', ['delivered', 'Selesai'])
            ->where(function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId)
                    ->orWhereHas('orderItems', function ($subq) use ($sellerId) {
                        $subq->where('seller_id', $sellerId);
                    })
                    ->orWhereHas('orderItems.product', function ($subq) use ($sellerId) {
                        $subq->where('seller_id', $sellerId);
                    });
            })
            ->orderByDesc('delivered_at')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        if ($orders->isEmpty()) {
            // Fallback daftar transaksi: paid atau tidak dibatalkan, urut created_at
            $orders = Order::query()
                ->where(function ($q) {
                    $q->where('payment_status', 'paid')
                        ->orWhereNotIn('status', ['Dibatalkan', 'cancelled']);
                })
                ->where(function ($q) use ($sellerId) {
                    $q->where('seller_id', $sellerId)
                        ->orWhereExists(function ($sub) use ($sellerId) {
                            $sub->select(\DB::raw(1))
                                ->from('order_items as oi')
                                ->whereColumn('oi.order_id', 'orders.id')
                                ->where('oi.seller_id', $sellerId);
                        });
                })
                ->orderByDesc('created_at')
                ->limit(10)
                ->get();
        }

        $data = $orders->map(function ($o) {
            return [
                'id' => $o->order_number ?? ('ORD-' . $o->id),
                'date' => optional($o->delivered_at)->format('d M Y') ?? optional($o->created_at)->format('d M Y'),
                'customer' => method_exists($o, 'customer_name') ? $o->customer_name : ($o->customer_name ?? 'Pelanggan'),
                'total' => $o->total_amount ?? $o->total_price,
                'status' => $o->status,
            ];
        });

        return response()->json(['items' => $data]);
    }

    // Endpoint diagnostik opsional: daftar order delivered milik seller
    public function debugDelivered(Request $request)
    {
        $sellerId = Auth::id();
        $orders = Order::query()
            ->whereIn('status', ['delivered', 'Selesai'])
            ->where(function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId)
                    ->orWhereHas('orderItems', function ($subq) use ($sellerId) {
                        $subq->where('seller_id', $sellerId);
                    })
                    ->orWhereHas('orderItems.product', function ($subq) use ($sellerId) {
                        $subq->where('seller_id', $sellerId);
                    });
            })
            ->orderByDesc('delivered_at')
            ->get(['id', 'order_number', 'status', 'delivered_at', 'total_amount', 'total_price']);

        return response()->json(['delivered' => $orders]);
    }
}
