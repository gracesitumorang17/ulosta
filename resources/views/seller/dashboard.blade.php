<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Dashboard Penjual - UlosTa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Tailwind (CDN for prototyping) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --brand-red-50: #FDEAEA;
            --brand-red-300: #EFA3A3;
            --brand-red-600: #AE0808;
            --brand-red-700: #8F0606;
            --brand-red-800: #6F0404;
        }

        .bg-red-600 {
            background-color: var(--brand-red-600) !important;
        }

        .bg-red-700 {
            background-color: var(--brand-red-700) !important;
        }

        .bg-red-800 {
            background-color: var(--brand-red-800) !important;
        }

        .text-red-600 {
            color: var(--brand-red-600) !important;
        }

        .text-red-700 {
            color: var(--brand-red-700) !important;
        }

        .hover\:bg-red-700:hover {
            background-color: var(--brand-red-700) !important;
        }

        .hover\:bg-red-800:hover {
            background-color: var(--brand-red-800) !important;
        }

        .focus\:ring-red-300:focus {
            box-shadow: 0 0 0 4px rgba(239, 163, 163, .6) !important;
        }
    </style>
</head>

<body class="antialiased bg-gray-50 text-gray-800">

    @php
        // Helper format
        if (!function_exists('format_rp')) {
            function format_rp($v)
            {
                return 'Rp ' . number_format($v, 0, ',', '.');
            }
        }
        $stats = [
            'total_products' => $totalProducts ?? 24,
            'total_orders' => $totalOrders ?? 147,
            'monthly_revenue' => $monthlyRevenue ?? 12250000,
            'total_revenue' => $totalRevenue ?? 45500000,
        ];
        $topProducts = $topProducts ?? [
            [
                'rank' => 1,
                'title' => 'Ulos Ragi Hotang',
                'sold' => 45,
                'revenue' => 56250000,
                'img' => asset('image/' . rawurlencode('Ulos Ragi Hotang.jpg')),
            ],
            [
                'rank' => 2,
                'title' => 'Ulos Bintang Maratur',
                'sold' => 38,
                'revenue' => 36000000,
                'img' => asset('image/' . rawurlencode('Ulos Bintang Maratur.jpg')),
            ],
            [
                'rank' => 3,
                'title' => 'Ulos Sibolang',
                'sold' => 32,
                'revenue' => 35200000,
                'img' => asset('image/' . rawurlencode('Ulos Sibolang.jpg')),
            ],
        ];
        $recentOrders = $recentOrders ?? [
            [
                'code' => 'ORD-2024-001',
                'customer' => 'Grace Caldera',
                'date' => '2025-01-25',
                'total' => 850000,
                'status' => 'Diproses',
            ],
            [
                'code' => 'ORD-2024-002',
                'customer' => 'Daniel S',
                'date' => '2025-01-28',
                'total' => 1500000,
                'status' => 'Selesai',
            ],
        ];
        $user = Auth::user();
    @endphp

    <!-- Navbar (partial) -->
    @include('seller.partials.navbar')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Page header with actions on the right -->
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold mb-1">Dashboard Toko</h1>
                <p class="text-sm text-gray-500">Kelola produk dan pesanan Ulos Anda</p>
            </div>
            <div class="hidden sm:flex items-center gap-3">
                <!-- Pengaturan Toko button -->
                <a href="{{ route('seller.settings') }}"
                    class="inline-flex items-center gap-2 border border-gray-300 rounded-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-red-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.4 15a1.7 1.7 0 0 0 .33 1.82l.06.06a.8.8 0 0 1-.02 1.13l-1.07 1.07a.8.8 0 0 1-1.13.02l-.06-.06A1.7 1.7 0 0 0 15 19.4a1.7 1.7 0 0 0-1 .32 1.7 1.7 0 0 0-.72 1.4v.17a.8.8 0 0 1-.8.8h-1.52a.8.8 0 0 1-.8-.8v-.17a1.7 1.7 0 0 0-.72-1.4 1.7 1.7 0 0 0-1-.33 1.7 1.7 0 0 0-1.82.33l-.06.06a.8.8 0 0 1-1.13-.02L3.3 18.01a.8.8 0 0 1-.02-1.13l.06-.06A1.7 1.7 0 0 0 3.67 15c0-.46-.17-.9-.46-1.25a1.7 1.7 0 0 0-1.39-.72H1.64a.8.8 0 0 1-.8-.8v-1.52c0-.44.36-.8.8-.8h.18c.54 0 1.06-.26 1.39-.72.29-.35.46-.79.46-1.25 0-.46-.17-.9-.46-1.25a1.7 1.7 0 0 0-1.39-.72h-.18a.8.8 0 0 1-.8-.8V6.07c0-.44.36-.8.8-.8h.18c.54 0 1.06-.26 1.39-.72l.06-.06a.8.8 0 0 1 1.13-.02l1.07 1.07c.32.32.84.32 1.13.02l.06-.06c.35-.29.79-.46 1.25-.46.46 0 .9.17 1.25.46.35.29.79.46 1.25.46.46 0 .9-.17 1.25-.46l.06-.06a.8.8 0 0 1 1.13.02l1.07 1.07a.8.8 0 0 1 .02 1.13l-.06.06c-.32.32-.32.84-.02 1.13l.06.06c.29.35.46.79.46 1.25 0 .46-.17.9-.46 1.25l-.06.06a.8.8 0 0 1 .02 1.13l-1.07 1.07a.8.8 0 0 1-1.13.02l-.06-.06A1.7 1.7 0 0 0 15 15c0 .46.17.9.46 1.25.29.35.73.54 1.25.54.46 0 .9-.17 1.25-.46Z" />
                    </svg>
                    <span>Pengaturan Toko</span>
                </a>

                <!-- Tambah Produk button -->
                <a href="{{ route('seller.products.create') }}"
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                    </svg>
                    <span>Tambah Produk</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Total Produk -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                            <!-- Cube / Box icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3 4.5 7l7.5 4 7.5-4L12 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 7v8l7.5 4 7.5-4V7" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 11v8" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-xs uppercase tracking-wide text-gray-500 mb-1">Total Produk</div>
                    <div class="text-3xl font-bold">{{ $stats['total_products'] }}</div>
                </div>
            </div>

            <!-- Total Pesanan -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                        <!-- Cart icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l3 12h10l3-8H6" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm9 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-xs uppercase tracking-wide text-gray-500 mb-1">Total Pesanan</div>
                    <div class="text-3xl font-bold">{{ $stats['total_orders'] }}</div>
                </div>
            </div>

            <!-- Pendapatan Bulan Ini -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        <!-- Dollar icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 8.5c0-2 1.8-3.5 4-3.5s4 1.12 4 3c0 1.9-1.5 2.8-4 3.2-2.5.4-4 1.3-4 3.2 0 1.88 1.8 3.1 4 3.1s4-1.5 4-3.5" />
                        </svg>
                    </div>
                    <div class="text-green-600">
                        <!-- Trend arrow -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 14 9 8l4 4 7-7" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-xs uppercase tracking-wide text-gray-500 mb-1">Pendapatan Bulan Ini</div>
                    <div class="text-xl font-bold">{{ format_rp($stats['monthly_revenue']) }}</div>
                </div>
            </div>

            <!-- Total Pendapatan -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        <!-- Dollar icon (total) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7.5c0-2 1.8-3.5 4-3.5s4 1.12 4 3c0 1.9-1.5 2.8-4 3.2-2.5.4-4 1.3-4 3.2 0 1.88 1.8 3.1 4 3.1s4-1.5 4-3.5" />
                        </svg>
                    </div>
                    <div class="text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 14 9 8l4 4 7-7" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-xs uppercase tracking-wide text-gray-500 mb-1">Total Pendapatan</div>
                    <div class="text-xl font-bold">{{ format_rp($stats['total_revenue']) }}</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Kolom Kiri: Produk Terlaris -->
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 18 9 6l4.5 6L21 3" />
                        </svg> Produk Terlaris</h2>
                </div>
                <div class="space-y-3">
                    @foreach ($topProducts as $prod)
                        <div class="flex items-center gap-4 border border-gray-200 rounded-lg p-3">
                            <div class="w-14 h-14 rounded-md overflow-hidden bg-gray-100">
                                <img src="{{ $prod['img'] }}" alt="{{ $prod['title'] }}"
                                    class="w-full h-full object-cover" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-xs w-5 h-5 flex items-center justify-center rounded-full bg-gray-200 text-gray-700">{{ $prod['rank'] }}</span>
                                    <p class="font-medium text-sm truncate">{{ $prod['title'] }}</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ $prod['sold'] }} Terjual</p>
                            </div>
                            <div class="text-sm font-semibold">{{ format_rp($prod['revenue']) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Kolom Kanan: Pesanan Terbaru -->
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h2 class="text-sm font-semibold flex items-center gap-2 mb-4"><svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 4.5h15v15h-15z" />
                    </svg> Pesanan Terbaru</h2>
                <div class="space-y-3">
                    @foreach ($recentOrders as $order)
                        <div class="border border-gray-200 rounded-lg p-3 flex items-start justify-between">
                            <div>
                                <p class="font-medium text-sm">{{ $order['code'] }}</p>
                                <p class="text-xs text-gray-500">{{ $order['customer'] }} • {{ $order['date'] }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-semibold">{{ format_rp($order['total']) }}</div>
                                <div
                                    class="text-[11px] mt-1 inline-block px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">
                                    {{ $order['status'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('seller.orders.index') }}"
                    class="mt-4 w-full inline-flex justify-center items-center border border-gray-300 rounded-md py-2 text-sm hover:bg-gray-50">Lihat
                    Semua Pesanan</a>
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
            <a href="{{ route('seller.products.index') }}"
                class="group bg-white border border-gray-200 rounded-xl p-6 flex flex-col items-center text-center hover:shadow-sm transition">
                <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-3 group-hover:scale-105 transition"
                    style="background-color: var(--brand-red-50)">
                    <!-- Cube / Box icon (red) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 4.5 7l7.5 4 7.5-4L12 3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 7v8l7.5 4 7.5-4V7" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11v8" />
                    </svg>
                </div>
                <h3 class="font-semibold text-sm mb-1">Kelola Produk</h3>
                <p class="text-xs text-gray-500">Tambah, edit, atau hapus produk ulos</p>
            </a>
            <a href="{{ route('seller.orders.index') }}"
                class="group bg-white border border-gray-200 rounded-xl p-6 flex flex-col items-center text-center hover:shadow-sm transition">
                <div
                    class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                    <!-- Shopping Cart icon (indigo) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l3 12h10l3-8H6" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm9 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                    </svg>
                </div>
                <h3 class="font-semibold text-sm mb-1">Kelola Pesanan</h3>
                <p class="text-xs text-gray-500">Proses dan pantau pesanan pelanggan</p>
            </a>
            <a href="#"
                class="group bg-white border border-gray-200 rounded-xl p-6 flex flex-col items-center text-center hover:shadow-sm transition">
                <div
                    class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 18 9 6l4.5 6L21 3" />
                    </svg>
                </div>
                <h3 class="font-semibold text-sm mb-1">Laporan Penjualan</h3>
                <p class="text-xs text-gray-500">Lihat statistik dan analisis toko</p>
            </a>
        </div>
    </main>

    <footer class="mt-16 py-8 text-center text-xs text-gray-500">
        © <span id="year"></span> UlosTa. All rights reserved.
    </footer>

    <script>
        // Simple alpine-like x-data fallback (if Alpine not installed)
        document.querySelectorAll('[x-data]').forEach(root => {
            const state = {
                open: false
            };
            root.querySelectorAll('[x-on\\:click]').forEach(el => {
                el.addEventListener('click', () => {
                    state.open = !state.open;
                    root.setAttribute('data-open', state.open);
                });
            });
            document.addEventListener('click', e => {
                if (!root.contains(e.target) && state.open) {
                    state.open = false;
                    root.setAttribute('data-open', 'false');
                }
            });
            root.querySelectorAll('[x-cloak]').forEach(el => el.style.display = 'none');
            const menu = root.querySelector('[x-cloak]');
            const observer = new MutationObserver(() => {
                if (menu && state.open) menu.style.display = 'block';
                else if (menu) menu.style.display = 'none';
            });
            observer.observe(root, {
                attributes: true
            });
        });
        const y = document.getElementById('year');
        if (y) y.textContent = new Date().getFullYear();

        // Fallback gambar: jika img gagal load gunakan placeholder sekali saja
        window.addEventListener('DOMContentLoaded', () => {
            const placeholder = @json(asset('image/ulos1.jpeg'));
            document.querySelectorAll('img').forEach(img => {
                img.addEventListener('error', function() {
                    if (this.dataset.fallbackDone) return;
                    this.dataset.fallbackDone = '1';
                    this.src = placeholder;
                });
            });

            // Sinkronkan link nav "Laporan" ke route laporan tanpa mengubah partial navbar
            try {
                const laporanHref = @json(route('seller.reports.index'));
                const header = document.querySelector('header');
                if (header) {
                    header.querySelectorAll('nav a').forEach(a => {
                        const label = a.querySelector('span');
                        if (label && label.textContent.trim() === 'Laporan') {
                            a.setAttribute('href', laporanHref);
                            const path = new URL(laporanHref, window.location.origin).pathname;
                            if (window.location.pathname === path) {
                                a.classList.remove('text-gray-700');
                                a.classList.add('text-red-600');
                            }
                        }
                    });
                }
            } catch (_) {}
        });
    </script>
</body>

</html>
