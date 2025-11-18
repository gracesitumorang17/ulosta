<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard Penjual - UlosTa</title>

    <!-- Tailwind CDN (samakan dengan welcome.blade.php untuk font dan utilitas) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- load app css jika tersedia (opsional) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- head style: align with welcomelogin branding + keep dashboard styles -->
    <style>
        /* Brand color system — align with welcomelogin */
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

        .bg-red-50 {
            background-color: var(--brand-red-50) !important;
        }

        .text-red-600 {
            color: var(--brand-red-600) !important;
        }

        .border-red-700 {
            border-color: var(--brand-red-700) !important;
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

        .hover\:bg-red-50:hover {
            background-color: var(--brand-red-50) !important;
        }

        .focus\:ring-red-300:focus {
            --tw-ring-color: var(--brand-red-300) !important;
            box-shadow: 0 0 0 4px rgba(239, 163, 163, 0.6) !important;
        }

        /* Adjust body and top spacing to match sticky header height (h-16) */
        body {
            background: #fafafa;
        }

        #app {
            padding-top: 80px;
        }

        /* header ~64px + spacing */

        /* Minimal styling supaya view langsung terlihat rapi — ubah ke CSS global bila perlu */
        .seller-dashboard {
            padding: 24px;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            color: #222;
        }

        .db-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 18px;
        }

        .card {
            background: #fff;
            border: 1px solid #e6e6e6;
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.02);
        }

        .card .title {
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
        }

        .card .value {
            font-size: 28px;
            font-weight: 700;
            color: #111;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 16px;
            align-items: start;
        }

        .panel {
            background: #fff;
            border: 1px solid #e6e6e6;
            border-radius: 12px;
            padding: 14px;
        }

        .list-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border: 1px solid #f0f0f0;
            border-radius: 10px;
            margin-bottom: 8px;
        }

        .list-item img {
            width: 56px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
        }

        .meta {
            font-size: 12px;
            color: #888;
            margin-top: 6px;
        }

        .small-badge {
            background: #f3f3f3;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 12px;
        }

        .order-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-radius: 8px;
            background: #fafafa;
            margin-bottom: 8px;
        }

        .order-id {
            font-weight: 600;
            color: #222;
        }

        .order-status {
            font-size: 13px;
            padding: 6px 8px;
            border-radius: 999px;
        }

        .status-pending {
            background: #fff4f2;
            color: #d04b3a;
            border: 1px solid #ffd6d0;
        }

        .status-complete {
            background: #f2fff5;
            color: #2d9b4a;
            border: 1px solid #dff7df;
        }

        /* Primary button styling (match welcomelogin look) */
        .btn-primary {
            background: var(--brand-red-600);
            color: #fff;
            padding: 8px 14px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(174, 8, 8, 0.08);
            transition: transform .12s ease, box-shadow .12s ease, opacity .12s ease;
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 12px 30px rgba(174, 8, 8, 0.12);
            opacity: 0.98;
        }

        .btn-primary:active {
            transform: translateY(0) scale(.99);
        }

        .btn-primary:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(239, 163, 163, 0.28);
        }

        @media(max-width:900px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="antialiased text-gray-800 bg-gray-50">

    <!-- HEADER: replaced with welcomelogin-like header for consistent layout -->
    <header class="bg-white shadow-sm sticky top-0 z-40 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Left: Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-md bg-red-600 flex items-center justify-center text-white font-bold">
                            U</div>
                        <span class="text-lg font-semibold">UlosTa Seller</span>
                    </a>
                </div>

                <!-- Center: (optional) Search - hidden on small -->
                <div class="flex-1 hidden md:flex justify-center px-4 max-w-2xl">
                    <form action="#" method="GET" class="w-full">
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                                </svg>
                            </div>
                            <input name="q" type="search" placeholder="Cari produk toko Anda ..."
                                class="w-full bg-gray-100 border border-gray-200 rounded-full py-2.5 pl-10 pr-4 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-300"
                                aria-label="Cari produk" />
                        </div>
                    </form>
                </div>

                <!-- Right: Seller Navigation Links -->
                <div class="flex items-center gap-6">
                    <a href="{{ route('seller.dashboard') }}"
                        class="flex items-center gap-2 text-red-600 transition font-semibold" aria-current="page">
                        <span class="text-sm">Dashboard</span>
                    </a>

                    <a href="{{ route('seller.products.index') }}"
                        class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition">
                        <span class="text-sm font-medium">Produk</span>
                    </a>

                    <a href="{{ route('seller.orders.index') }}"
                        class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition">
                        <span class="text-sm font-medium">Pesanan</span>
                    </a>

                    <a href="#" class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition">
                        <span class="text-sm font-medium">Laporan</span>
                    </a>

                    <a href="{{ route('home') }}"
                        class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="text-sm font-medium">Toko</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Search -->
            <div id="mobile-search" class="md:hidden pb-3">
                <form action="#" method="GET">
                    <div class="relative">
                        <input name="q" type="search" placeholder="Cari produk..."
                            class="w-full border border-gray-200 rounded-full py-2.5 px-4 shadow-sm focus:outline-none" />
                    </div>
                </form>
            </div>

            <!-- Mobile Menu Panel -->
            <div id="mobile-menu" class="md:hidden hidden pb-4">
                <nav class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <a href="{{ route('seller.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50">Dashboard</a>
                    <a href="{{ route('seller.products.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50">Produk</a>
                    <a href="{{ route('seller.orders.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50">Pesanan</a>
                    <a href="#"
                        class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50">Laporan</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full text-left flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50">Keluar</button>
                    </form>
                </nav>
            </div>
        </div>
    </header>

    <div id="app">
        <div class="seller-dashboard">
            <header style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
                <div>
                    <h2 style="margin:0 0 6px 0">Dashboard Toko</h2>
                    <p style="margin:0;color:#666">Kelola produk dan pesanan Ulos Anda</p>
                </div>
                <div style="display:flex;gap:10px;align-items:center;">
                    <a href="{{ route('seller.products.create') }}" class="btn-primary" title="Tambah Produk">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true" style="flex-shrink:0;">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Tambah Produk</span>
                    </a>
                    <a href="{{ route('home') }}"
                        style="padding:8px 12px;border-radius:8px;border:1px solid #e6e6e6;text-decoration:none;color:#333">Kembali
                        ke Toko</a>
                </div>
            </header>

            <div class="db-cards">
                <div class="card">
                    <div class="title">Total Produk</div>
                    <div class="value">{{ $totalProducts ?? 24 }}</div>
                    <div class="meta">{{ $activeProducts ?? '18 aktif' }}</div>
                </div>

                <div class="card">
                    <div class="title">Total Pesanan</div>
                    <div class="value">{{ $totalOrders ?? 147 }}</div>
                    <div class="meta">{{ $pendingOrders ?? '12 Pending' }}</div>
                </div>

                <div class="card">
                    <div class="title">Pendapatan bulan ini</div>
                    <div class="value">{{ $monthRevenue ?? 'Rp 12.250.000' }}</div>
                </div>

                <div class="card">
                    <div class="title">Total Pendapatan</div>
                    <div class="value">{{ $totalRevenue ?? 'Rp 45.500.000' }}</div>
                </div>
            </div>

            <div class="grid-2">
                <!-- Produk Terlaris -->
                <div class="panel">
                    <h3 style="margin-top:0;margin-bottom:12px">Produk terlaris</h3>
                    <div>
                        @php
                            $top = $topProducts ?? [
                                [
                                    'title' => 'Ulos Ragi Hotang',
                                    'sold' => '45 Terjual',
                                    'price' => 'Rp 56.250.000',
                                    'image' => 'Ulos Ragi Hotang.jpg',
                                ],
                                [
                                    'title' => 'Ulos Bintang Maratur',
                                    'sold' => '38 Terjual',
                                    'price' => 'Rp 36.100.000',
                                    'image' => 'Ulos Bintang Maratur.jpg',
                                ],
                                [
                                    'title' => 'Ulos Sibolang Rasta Pamontari',
                                    'sold' => '32 Terjual',
                                    'price' => 'Rp 35.200.000',
                                    'image' => 'Ulos Sibolang Rasta Pamontari.jpg',
                                ],
                            ];

                            if (!function_exists('ulosta_image_url')) {
                                function ulosta_image_url($path = null)
                                {
                                    // no path -> placeholder
                                    if (!$path) {
                                        return asset('image/placeholder-ulos.jpg');
                                    }

                                    // normalize: trim quotes/spaces
                                    $path = trim($path, " \t\n\r\0\x0B\"'");

                                    // already absolute URL
                                    if (filter_var($path, FILTER_VALIDATE_URL)) {
                                        return $path;
                                    }

                                    // 1) direct match in public/image
                                    $publicCandidate = public_path('image/' . ltrim($path, '/'));
                                    if (file_exists($publicCandidate)) {
                                        return asset('image/' . ltrim($path, '/'));
                                    }

                                    // 1b) try to find by basename ignoring extension/case in public/image
                                    $imageDir = public_path('image');
                                    if (is_dir($imageDir)) {
                                        $targetBase = strtolower(pathinfo($path, PATHINFO_FILENAME));
                                        foreach (scandir($imageDir) as $f) {
                                            if ($f === '.' || $f === '..') {
                                                continue;
                                            }
                                            $base = strtolower(pathinfo($f, PATHINFO_FILENAME));
                                            if ($base === $targetBase) {
                                                return asset('image/' . rawurlencode($f));
                                            }
                                        }
                                    }

                                    // 2) direct match in public/storage (storage:link)
                                    $storageCandidate = public_path('storage/' . ltrim($path, '/'));
                                    if (file_exists($storageCandidate)) {
                                        return asset('storage/' . ltrim($path, '/'));
                                    }

                                    // fallback placeholder
                                    return asset('image/placeholder-ulos.jpg');
                                }
                            }
                        @endphp

                        @foreach ($top as $item)
                            <div class="list-item">
                                <img src="{{ ulosta_image_url($item['image'] ?? null) }}" alt="{{ $item['title'] }}"
                                    onerror="this.onerror=null; this.src='{{ asset('image/placeholder-ulos.jpg') }}'">
                                <div style="flex:1">
                                    <div style="font-weight:600">{{ $item['title'] }}</div>
                                    <div class="meta">{{ $item['sold'] }}</div>
                                </div>
                                <div style="font-weight:700">{{ $item['price'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pesanan Terbaru -->
                <div class="panel">
                    <h3 style="margin-top:0;margin-bottom:12px">Pesanan Terbaru</h3>

                    @php $orders = $recentOrders ?? [['id' => 'ORD-2024-001', 'name' => 'Grace Caldera', 'date' => '2025-01-25', 'total' => 'Rp 850.000', 'status' => 'pending'], ['id' => 'ORD-2024-002', 'name' => 'Daniel S', 'date' => '2025-01-28', 'total' => 'Rp 1.500.000', 'status' => 'complete']]; @endphp

                    @foreach ($orders as $o)
                        <div class="order-row">
                            <div>
                                <div class="order-id">{{ $o['id'] }}</div>
                                <div class="meta">{{ $o['name'] }} · {{ $o['date'] }}</div>
                            </div>
                            <div style="text-align:right">
                                <div style="font-weight:700">{{ $o['total'] }}</div>
                                <div class="meta" style="margin-top:6px;">
                                    <span
                                        class="order-status {{ $o['status'] == 'pending' ? 'status-pending' : 'status-complete' }}">
                                        {{ ucfirst($o['status']) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <a href="{{ route('seller.orders.index') }}"
                        style="display:block;text-align:center;margin-top:10px;padding:10px;border-radius:8px;border:1px solid #eee;text-decoration:none;color:#333">Lihat
                        semua pesanan</a>
                </div>
            </div>

            <!-- Shortcut Cards -->
            <div
                style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;margin-top:18px">
                <div class="card" style="text-align:center">
                    <div style="font-size:28px;color:#8b5cf6;margin-bottom:8px">📦</div>
                    <div style="font-weight:600">Kelola Produk</div>
                    <div class="meta">Tambah, edit, atau hapus produk ulos</div>
                </div>
                <div class="card" style="text-align:center">
                    <div style="font-size:28px;color:#2563eb;margin-bottom:8px">🛒</div>
                    <div style="font-weight:600">Kelola Pesanan</div>
                    <div class="meta">Proses dan pantau pesanan pelanggan</div>
                </div>
                <div class="card" style="text-align:center">
                    <div style="font-size:28px;color:#10b981;margin-bottom:8px">📈</div>
                    <div style="font-weight:600">Laporan Penjualan</div>
                    <div class="meta">Lihat statistik dan analisis toko</div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER: from welcomelogin for consistency -->
    <footer class="bg-neutral-900 text-neutral-300 mt-16">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <div>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 bg-red-600 rounded-md flex items-center justify-center font-bold text-white text-sm">
                            U</div>
                        <div class="text-white font-semibold text-lg">UlosTa</div>
                    </div>
                    <p class="mt-4 text-sm text-neutral-400">Platform jual-beli ulos asli Batak dari pengrajin lokal
                        dengan aman dan mudah.</p>
                    <div class="mt-4 flex items-center gap-3 text-neutral-400">
                        <a href="#" aria-label="Instagram" class="hover:text-white">IG</a>
                        <a href="#" aria-label="Facebook" class="hover:text-white">FB</a>
                        <a href="#" aria-label="Twitter" class="hover:text-white">X</a>
                        <a href="#" aria-label="YouTube" class="hover:text-white">YT</a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-semibold">Tentang Kami</h4>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Profil Perusahaan</a></li>
                        <li><a href="#" class="hover:text-white">Karir</a></li>
                        <li><a href="#" class="hover:text-white">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-white">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold">Kategori</h4>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Ulos Pernikahan</a></li>
                        <li><a href="#" class="hover:text-white">Ulos Kelahiran</a></li>
                        <li><a href="#" class="hover:text-white">Ulos Kematian</a></li>
                        <li><a href="#" class="hover:text-white">Ulos Lainnya</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold">Hubungi Kami</h4>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li>Email: support@ulosta.id</li>
                        <li>Telepon: +62 812-3456-7890</li>
                        <li>Alamat: Medan, Sumatera Utara</li>
                    </ul>
                </div>
            </div>

            <div
                class="mt-10 border-t border-neutral-800 pt-6 text-sm text-neutral-400 flex flex-col sm:flex-row items-center justify-between">
                <p>© <span id="year"></span> UlosTa. All rights reserved.</p>
                <div class="mt-2 sm:mt-0">Indonesia</div>
            </div>
        </div>
    </footer>

    <!-- load app js jika tersedia (opsional) -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- small scripts: profile dropdown, mobile toggle, footer year -->
    <script>
        // Profile dropdown
        (function() {
            const btn = document.getElementById('profile-btn');
            const menu = document.getElementById('profile-menu');
            if (!btn || !menu) return;
            const closeMenu = () => {
                menu.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');
            };
            const openMenu = () => {
                menu.classList.remove('hidden');
                btn.setAttribute('aria-expanded', 'true');
            };
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.contains('hidden') ? openMenu() : closeMenu();
            });
            document.addEventListener('click', () => {
                if (!menu.classList.contains('hidden')) closeMenu();
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeMenu();
            });
        })();

        // Mobile menu toggle
        (function() {
            const btn = document.getElementById('mobile-menu-btn');
            const panel = document.getElementById('mobile-menu');
            if (!btn || !panel) return;
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = panel.classList.contains('hidden');
                panel.classList.toggle('hidden');
                btn.setAttribute('aria-expanded', String(isHidden));
            });
            document.addEventListener('click', (e) => {
                if (!panel.classList.contains('hidden') && !panel.contains(e.target) && !btn.contains(e
                        .target)) {
                    panel.classList.add('hidden');
                    btn.setAttribute('aria-expanded', 'false');
                }
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !panel.classList.contains('hidden')) {
                    panel.classList.add('hidden');
                    btn.setAttribute('aria-expanded', 'false');
                }
            });
        })();

        // Footer year
        (function() {
            const y = document.getElementById('year');
            if (y) y.textContent = new Date().getFullYear();
        })();

        // HAPUS double-encoding: biarkan browser handle path dengan spasi.
        // Tambahkan fallback onerror hanya sekali.
        (function() {
            const placeholder = '{{ asset('image/ulos1.jpeg') }}'; // gunakan file yang ada
            window.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('img').forEach(img => {
                    img.addEventListener('error', function() {
                        if (this.dataset.fallbackDone) return;
                        this.dataset.fallbackDone = '1';
                        this.src = placeholder;
                    });
                });
            });
        })();
    </script>
</body>

</html>
