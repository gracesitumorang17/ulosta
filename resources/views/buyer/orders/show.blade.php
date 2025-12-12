<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Detail Pesanan - UlosTa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --brand-red-600: #AE0808;
            --brand-red-700: #8F0606
        }
        .bg-red-600 { background-color: var(--brand-red-600) !important }
        .hover\:bg-red-700:hover { background-color: var(--brand-red-700) !important }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="text-xl font-bold text-red-600">UlosTa</a>
                <div class="flex items-center gap-6">
                    <a href="/" class="text-sm text-gray-600 hover:text-gray-900">Beranda</a>
                    <a href="{{ route('buyer.orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">Pesanan Saya</a>
                    <div class="text-sm text-gray-600">{{ Auth::user()->name ?? 'User' }}</div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @php
            if (!function_exists('format_rp')) {
                function format_rp($v)
                {
                    return 'Rp ' . number_format($v, 0, ',', '.');
                }
            }
            $statusLabels = [
                'pending' => 'Menunggu Dikonfirmasi',
                'processing' => 'Diproses',
                'shipped' => 'Dikirim',
                'delivered' => 'Selesai',
                'cancelled' => 'Dibatalkan',
                'refunded' => 'Dikembalikan Dana'
            ];
            $statusClasses = [
                'pending' => 'bg-yellow-100 text-yellow-800',
                'processing' => 'bg-blue-100 text-blue-700',
                'shipped' => 'bg-purple-100 text-purple-700',
                'delivered' => 'bg-green-100 text-green-700',
                'cancelled' => 'bg-red-100 text-red-700',
                'refunded' => 'bg-gray-100 text-gray-700'
            ];
        @endphp

        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('buyer.orders.index') }}" class="text-sm text-gray-500 hover:underline mb-4 inline-block">← Kembali ke Pesanan Saya</a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">{{ $order->order_number ?? 'ORD-' . $order->id }}</h1>
                    <p class="text-gray-600 mt-2">{{ $order->created_at?->format('d F Y H:i') ?? '-' }}</p>
                </div>
                <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold {{ $statusClasses[$order->status] ?? 'bg-gray-100' }}">
                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6 mb-8">
            <!-- Order Items -->
            <div class="col-span-2 bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-bold mb-4">Detail Pesanan</h2>
                <div class="space-y-4">
                    @forelse($order->orderItems ?? [] as $item)
                        <div class="flex gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                            @if($item->product?->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded"></div>
                            @endif
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $item->product?->name ?? 'Produk tidak tersedia' }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $item->quantity }} x {{ format_rp($item->price ?? 0) }}</p>
                                @if($item->product?->seller)
                                    <p class="text-xs text-gray-400 mt-1">Penjual: {{ $item->product->seller->name }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">{{ format_rp(($item->price ?? 0) * ($item->quantity ?? 1)) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Tidak ada item dalam pesanan ini</p>
                    @endforelse
                </div>

                <!-- Payment Info -->
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Informasi Pembayaran</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">{{ format_rp($order->subtotal ?? 0) }}</span>
                        </div>
                        @if($order->shipping_cost)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ongkos Kirim</span>
                                <span class="font-medium">{{ format_rp($order->shipping_cost) }}</span>
                            </div>
                        @endif
                        @if($order->tax_amount)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pajak</span>
                                <span class="font-medium">{{ format_rp($order->tax_amount) }}</span>
                            </div>
                        @endif
                        @if($order->discount_amount)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Diskon</span>
                                <span class="font-medium">-{{ format_rp($order->discount_amount) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between border-t border-gray-200 pt-2 mt-2">
                            <span class="font-semibold text-gray-900">Total</span>
                            <span class="font-bold text-lg text-red-600">{{ format_rp($order->total_amount ?? 0) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Status Timeline -->
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Riwayat Status</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="text-green-600">✓</span>
                            <span class="text-gray-600">Pesanan diterima</span>
                            <span class="text-gray-400">{{ $order->created_at?->format('d M Y H:i') ?? '-' }}</span>
                        </div>
                        @if($order->status === 'processing' || in_array($order->status, ['shipped', 'delivered']))
                            <div class="flex items-center gap-2">
                                <span class="text-green-600">✓</span>
                                <span class="text-gray-600">Pesanan diproses</span>
                            </div>
                        @endif
                        @if(in_array($order->status, ['shipped', 'delivered']))
                            <div class="flex items-center gap-2">
                                <span class="text-green-600">✓</span>
                                <span class="text-gray-600">Pesanan dikirim</span>
                                <span class="text-gray-400">{{ $order->shipped_at?->format('d M Y H:i') ?? '-' }}</span>
                            </div>
                        @endif
                        @if($order->status === 'delivered')
                            <div class="flex items-center gap-2">
                                <span class="text-green-600">✓</span>
                                <span class="text-gray-600">Pesanan diterima pembeli</span>
                                <span class="text-gray-400">{{ $order->delivered_at?->format('d M Y H:i') ?? '-' }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar: Shipping & Billing -->
            <div class="space-y-6">
                <!-- Shipping Address -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-900 mb-3">Alamat Pengiriman</h3>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p class="font-medium text-gray-900">{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</p>
                        <p>{{ $order->shipping_phone }}</p>
                        <p>{{ $order->shipping_address_1 }}</p>
                        @if($order->shipping_address_2)
                            <p>{{ $order->shipping_address_2 }}</p>
                        @endif
                        <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                        <p>{{ $order->shipping_country }}</p>
                    </div>
                </div>

                <!-- Payment Status -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-900 mb-3">Status Pembayaran</h3>
                    <div class="text-sm">
                        <div class="inline-flex items-center px-3 py-1 rounded-lg font-semibold {{
                            $order->payment_status === 'paid'
                                ? 'bg-green-100 text-green-700'
                                : ($order->payment_status === 'pending'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : 'bg-red-100 text-red-700')
                        }}">
                            @if($order->payment_status === 'paid')
                                ✓ Pembayaran Lunas
                            @elseif($order->payment_status === 'pending')
                                ⏳ Menunggu Pembayaran
                            @else
                                ✕ Pembayaran Gagal
                            @endif
                        </div>
                        @if($order->payment_method)
                            <p class="text-gray-600 mt-3">
                                <span class="font-medium">Metode Pembayaran:</span><br>
                                {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Shipping Method -->
                @if($order->shipping_method)
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <h3 class="font-bold text-gray-900 mb-3">Metode Pengiriman</h3>
                        <p class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $order->shipping_method)) }}</p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script>
        // Auto-refresh page every 10 seconds if status is still pending/processing
        const status = '{{ $order->status }}';
        if (['pending', 'processing', 'shipped'].includes(status)) {
            setInterval(() => {
                location.reload();
            }, 10000);
        }
    </script>
</body>
</html>
