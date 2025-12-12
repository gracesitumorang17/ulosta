<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Pesanan Saya - UlosTa</title>
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

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
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

        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">Pesanan Saya</h1>
            <p class="text-gray-600">{{ $orders->count() }} pesanan ditemukan</p>
        </div>

        <!-- Orders List -->
        <div class="space-y-4">
            @forelse($orders as $order)
                <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-3">
                                <h3 class="text-lg font-bold text-gray-900">{{ $order->order_number ?? 'ORD-' . $order->id }}</h3>
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold {{ $statusClasses[$order->status] ?? 'bg-gray-100' }}">
                                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ $order->created_at?->format('d M Y H:i') ?? '-' }}</p>
                        </div>
                        <a href="{{ route('buyer.orders.show', $order->order_number) }}" class="text-red-600 hover:text-red-700 font-medium text-sm">
                            Lihat Detail →
                        </a>
                    </div>

                    <!-- Order Items Summary -->
                    <div class="border-t border-gray-200 pt-4">
                        <div class="text-sm text-gray-600 mb-3">
                            {{ $order->orderItems?->count() ?? 0 }} item pesanan
                        </div>
                        <div class="space-y-2">
                            @foreach($order->orderItems ?? [] as $item)
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-3">
                                        @if($item->product?->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-12 h-12 object-cover rounded">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded"></div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $item->product?->name ?? 'Produk tidak tersedia' }}</p>
                                            <p class="text-gray-500">{{ $item->quantity }} x {{ format_rp($item->price ?? 0) }}</p>
                                        </div>
                                    </div>
                                    <p class="font-medium text-gray-900">{{ format_rp(($item->price ?? 0) * ($item->quantity ?? 1)) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex items-center justify-between text-lg font-bold">
                            <span>Total Pesanan</span>
                            <span class="text-red-600">{{ format_rp($order->total_amount ?? 0) }}</span>
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="text-xs text-gray-500 space-y-1">
                            @if($order->shipped_at)
                                <p>✓ Dikirim pada {{ $order->shipped_at->format('d M Y H:i') }}</p>
                            @endif
                            @if($order->delivered_at)
                                <p>✓ Diterima pada {{ $order->delivered_at->format('d M Y H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-gray-200 rounded-xl p-12 text-center">
                    <div class="text-6xl mb-4">📦</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                    <p class="text-gray-600 mb-4">Anda belum melakukan pemesanan apapun</p>
                    <a href="/" class="inline-flex items-center gap-2 px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                        ← Mulai Belanja
                    </a>
                </div>
            @endforelse
        </div>
    </main>

    <script>
        // Auto-refresh status every 10 seconds for pending orders
        setInterval(() => {
            const pendingBadges = document.querySelectorAll('[data-status="pending"]');
            if (pendingBadges.length > 0) {
                location.reload();
            }
        }, 10000);
    </script>
</body>
</html>
