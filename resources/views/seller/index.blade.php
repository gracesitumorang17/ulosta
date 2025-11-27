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
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-100">👤</span>
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
                        'old' => null,
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
                        'old' => 'Rp 1.100.000',
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
                        'old' => 'Rp 2.000.000',
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
                        @if (!empty($p['old']))
                            <div class="text-xs text-gray-400 line-through">{{ $p['old'] }}</div>
                        @endif
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
    </script>
</body>

</html>
