<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Kelola Produk — UlosTa Seller</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        :root {
            --brand-red-600: #AE0808;
            --border: #e6e6e6;
            --text-muted: #6b7280;
        }

        /* small helpers */
        .logo-mark {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--brand-red-600);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800
        }

        .card-border {
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff
        }

        .pill {
            padding: 6px 10px;
            border-radius: 999px;
            background: #f3f3f3;
            font-size: 13px
        }

        .pill-white {
            padding: 6px 12px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid var(--border);
            font-size: 12px
        }

        .btn-red {
            background: var(--brand-red-600);
            color: #fff;
            padding: 8px 12px;
            border-radius: 8px
        }

        .table-row {
            border-bottom: 1px solid #f3f3f3;
            padding: 18px 0;
            display: flex;
            align-items: center;
            gap: 12px
        }

        .col {
            display: flex;
            align-items: center
        }

        .col.center {
            justify-content: center
        }

        .img-thumb {
            width: 72px;
            height: 56px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid var(--border)
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 1px solid #ececec;
            display: inline-flex;
            align-items: center;
            justify-content: center
        }

        .action-btn:hover {
            border-color: #d1d5db;
            background: #fafafa
        }

        .action-danger:hover {
            border-color: #fca5a5;
            background: #fff1f2
        }

        .status-badge {
            background: #111;
            color: #fff;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px
        }

        .stock-badge {
            display: inline-block;
            min-width: 36px;
            text-align: center;
            padding: 8px 10px;
            border-radius: 10px;
            font-weight: 600
        }

        .stock-ok {
            background: #f3f4f6;
            color: #111
        }

        .stock-low {
            background: var(--brand-red-600);
            color: #fff
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <!-- Header (same style as dashboard) -->
    <header class="bg-white shadow-sm sticky top-0 z-40 border-b">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-4">
                    <div class="logo-mark">U</div>
                    <div class="font-semibold">UlosTa Seller</div>

                    <nav class="hidden md:flex items-center gap-6 ml-6 text-sm">
                        <a href="{{ route('seller.dashboard') }}" class="text-gray-600 flex items-center gap-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12l9-9 9 9" />
                                <path d="M9 21V9h6v12" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('seller.products.index') }}" class="text-red-600 flex items-center gap-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="7" height="7" />
                                <rect x="14" y="4" width="7" height="7" />
                                <rect x="14" y="15" width="7" height="7" />
                                <rect x="3" y="15" width="7" height="7" />
                            </svg>
                            Produk
                        </a>
                        <a href="{{ route('seller.orders.index') }}" class="text-gray-600 flex items-center gap-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 7h18" />
                                <path d="M6 7V4h12v3" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12" />
                            </svg>
                            Pesanan
                        </a>
                        <a href="#" class="text-gray-600 flex items-center gap-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                            </svg>
                            Laporan
                        </a>
                        <a href="{{ route('home') }}" class="text-gray-600 flex items-center gap-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12l9-9 9 9" />
                                <path d="M9 21V9h6v12" />
                            </svg>
                            Toko
                        </a>
                    </nav>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}"
                        class="px-3 py-2 border rounded-md text-sm inline-flex items-center gap-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v4" />
                            <path d="M14 10l7-7" />
                            <path d="M21 15v4a2 2 0 0 1-2 2h-4" />
                            <path d="M10 14l-7 7" />
                        </svg>
                        Kembali ke Toko
                    </a>
                    
                    <!-- Profil Dropdown -->
                    <div class="relative" id="profile-dd">
                        <button id="profile-btn" type="button" aria-expanded="false" class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition focus:outline-none">
                            <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-100">👤</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Popup menu -->
                        <div id="profile-menu" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-xl ring-1 ring-black/5 overflow-hidden z-50">
                            <!-- Header dengan Gradient Merah -->
                            <div class="px-4 py-3 bg-gradient-to-r from-red-600 to-red-700">
                                <p class="text-sm font-semibold text-white">{{ Auth::user()->name ?? 'Nama Penjual' }}</p>
                                <p class="text-xs text-red-100 mt-0.5">Penjual</p>
                            </div>
                            <nav class="py-2">
                                <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <span class="text-sm font-medium">Dashboard Penjual</span>
                                </a>
                                <a href="{{ route('seller.products.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <span class="text-sm font-medium">Kelola Produk</span>
                                </a>
                                <a href="{{ route('seller.orders.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <span class="text-sm font-medium">Pesanan Masuk</span>
                                </a>
                                <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="text-sm font-medium">Profil Saya</span>
                                </a>
                                <div class="my-2 border-t border-gray-100"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span class="text-sm font-medium">Keluar</span>
                                    </button>
                                </form>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Page content -->
    <main class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <a href="{{ route('seller.dashboard') }}" class="text-sm text-gray-600 inline-flex items-center gap-2">←
                    Kembali ke dashboard</a>
                <h1 class="text-2xl font-semibold mt-4">Kelola produk</h1>
            </div>

            <a href="{{ route('seller.products.create') }}" class="btn-red inline-flex items-center gap-2">
                <span class="text-sm">+ Tambah Produk</span>
            </a>
        </div>

        <!-- Search & filter -->
        <div class="card-border p-5 mb-6">
            <div class="flex gap-4 items-center">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <path d="M21 21l-4.3-4.3" />
                            </svg>
                        </div>
                        <input type="search" placeholder="Cari produk....."
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:outline-none" />
                    </div>
                </div>
                <div class="w-56">
                    <div class="relative">
                        <select
                            class="appearance-none w-full py-3 pl-4 pr-10 rounded-lg border border-gray-200 bg-white text-sm">
                            <option>Jenis ulos</option>
                            <option>Pernikahan</option>
                            <option>Penghormatan</option>
                            <option>Kematian</option>
                        </select>
                        <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products table -->
        <div class="card-border p-6">
            <div class="mb-4 font-medium">Daftar Produk (<span id="count">3</span>)</div>

            <!-- table header -->
            <div class="flex text-sm text-gray-500 py-3 border-b border-gray-100">
                <div class="w-36">Gambar</div>
                <div class="flex-1">Nama Produk</div>
                <div class="w-40 text-center">Kategori</div>
                <div class="w-36 text-center">Harga</div>
                <div class="w-24 text-center">Stok</div>
                <div class="w-28 text-center">Status</div>
                <div class="w-24 text-center">Terjual</div>
                <div class="w-28 text-center">Aksi</div>
            </div>

            @php
                // fallback data jika tidak disuplai controller
                $products = $products ?? [
                    [
                        'image' => 'Ulos Ragi Hotang.jpg',
                        'name' => 'Ulos Ragi Hotang',
                        'desc' => 'Ulos tradisional dengan motif...',
                        'cat' => 'Pernikahan',
                        'price' => 'Rp 800.000',
                        'stock' => 25,
                        'status' => 'aktif',
                        'sold' => 100,
                    ],
                    [
                        'image' => 'Ulos Bintang Maratur.jpg',
                        'name' => 'Ulos Bintang Maratur',
                        'desc' => 'Ulos tradisional dengan motif...',
                        'cat' => 'Penghormatan',
                        'price' => 'Rp 1.000.000',
                        'stock' => 3,
                        'status' => 'aktif',
                        'sold' => 175,
                    ],
                    [
                        'image' => 'Ulos Sibolang Rasta Pamontari.jpg',
                        'name' => 'Ulos Sibolang',
                        'desc' => 'Ulos tradisional dengan motif...',
                        'cat' => 'Kematian',
                        'price' => 'Rp 1.500.000',
                        'stock' => 3,
                        'status' => 'aktif',
                        'sold' => 111,
                    ],
                ];

                if (!function_exists('ulosta_image_url')) {
                    function ulosta_image_url($path = null)
                    {
                        if (!$path) {
                            return asset('image/ulos1.jpeg');
                        }
                        $original = trim($path);
                        if (filter_var($original, FILTER_VALIDATE_URL)) {
                            return $original;
                        }
                        $img = public_path('image/' . ltrim($original, '/'));
                        if (file_exists($img)) {
                            return asset('image/' . ltrim($original, '/'));
                        }
                        $dir = public_path('image');
                        if (is_dir($dir)) {
                            $base = strtolower(preg_replace('/[\s_-]+/', '', pathinfo($original, PATHINFO_FILENAME)));
                            foreach (scandir($dir) as $f) {
                                if ($f === '.' || $f === '..') {
                                    continue;
                                }
                                $b = strtolower(preg_replace('/[\s_-]+/', '', pathinfo($f, PATHINFO_FILENAME)));
                                if ($b === $base) {
                                    return asset('image/' . $f);
                                }
                            }
                        }
                        return asset('image/ulos1.jpeg');
                    }
                }
            @endphp

            @foreach ($products as $p)
                <div class="table-row">
                    <div class="w-36">
                        <img src="{{ ulosta_image_url($p['image'] ?? null) }}" alt="{{ $p['name'] }}"
                            class="img-thumb" onerror="this.onerror=null;this.src='{{ asset('image/ulos1.jpeg') }}'">
                    </div>

                    <div class="flex-1">
                        <div class="font-semibold">{{ $p['name'] }}</div>
                        <div class="text-xs" style="color: var(--text-muted);">{{ $p['desc'] }}</div>
                    </div>

                    <div class="w-40 center">
                        <span class="pill-white">{{ $p['cat'] }}</span>
                    </div>

                    <div class="w-36 center text-sm">
                        <div class="font-semibold">{{ $p['price'] }}</div>
                    </div>

                    <div class="w-24 center">
                        @php $low = (int)($p['stock'] ?? 0) <= 3; @endphp
                        <span class="stock-badge {{ $low ? 'stock-low' : 'stock-ok' }}">{{ $p['stock'] }}</span>
                    </div>

                    <div class="w-28 center">
                        @if ($p['status'] == 'aktif')
                            <span class="status-badge">aktif</span>
                        @else
                            <span class="pill">{{ $p['status'] }}</span>
                        @endif
                    </div>

                    <div class="w-24 center text-sm">{{ $p['sold'] }}</div>

                    <div class="w-28 center">
                        <a href="#" class="action-btn mr-2" title="Edit" aria-label="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                            </svg>
                        </a>
                        <form action="#" method="POST" class="inline-block">
                            <button type="button" class="action-btn action-danger" title="Hapus"
                                aria-label="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                    <path d="M10 11v6" />
                                    <path d="M14 11v6" />
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <script>
        // update count
        document.getElementById('count').textContent = document.querySelectorAll('.table-row').length;
        
        // Profile dropdown toggle
        const profileBtn = document.getElementById('profile-btn');
        const profileMenu = document.getElementById('profile-menu');
        
        if (profileBtn && profileMenu) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isHidden = profileMenu.classList.contains('hidden');
                profileMenu.classList.toggle('hidden');
                profileBtn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
            });
            
            // Close on outside click
            document.addEventListener('click', function(e) {
                if (!profileMenu.contains(e.target) && !profileBtn.contains(e.target)) {
                    profileMenu.classList.add('hidden');
                    profileBtn.setAttribute('aria-expanded', 'false');
                }
            });
            
            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !profileMenu.classList.contains('hidden')) {
                    profileMenu.classList.add('hidden');
                    profileBtn.setAttribute('aria-expanded', 'false');
                }
            });
        }
    </script>
</body>

</html>
