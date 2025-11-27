<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <<<<<<< HEAD <title>Kelola Produk - UlosTa Seller</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            :root {
                --brand-red-50: #FDEAEA;
                --brand-red-300: #EFA3A3;
                --brand-red-600: #AE0808;
                --brand-red-700: #8F0606;
                --gold-500: #f5b400;
                --gold-600: #d89d00;
                --gold-700: #b48300;
            }

            /* Utility badge base (replaces @apply for CDN usage) */
            .badge {
                display: inline-flex;
                align-items: center;
                padding: 0.125rem 0.5rem;
                /* py-0.5 px-2 */
                border-radius: 9999px;
                /* rounded-full */
                font-size: 11px;
                /* text-[11px] */
                font-weight: 500;
                /* font-medium */
                line-height: 1.1;
                white-space: nowrap;
            }

            .badge-cat {
                background: #eef0f3;
                color: #555;
            }

            .badge-status-active {
                background: var(--gold-500);
                color: #222;
            }

            .badge-status-inactive {
                background: #ececec;
                color: #555;
            }

            .btn-add {
                background: var(--brand-red-600);
                color: #fff;
            }

            .btn-add:hover {
                background: var(--brand-red-700);
            }

            .table-wrap table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
            }

            .table-wrap th {
                text-align: left;
                font-size: .68rem;
                letter-spacing: .05em;
                text-transform: uppercase;
                font-weight: 600;
                padding: .75rem .9rem;
                color: #6b7280;
            }

            .table-wrap td {
                padding: .7rem .9rem;
                font-size: .75rem;
                border-top: 1px solid #e5e7eb;
                background: #fff;
            }

            .table-wrap tbody tr:hover td {
                background: #f9fafb;
            }

            .search-input {
                width: 100%;
                background: #f3f4f6;
                border: 1px solid #e5e7eb;
                border-radius: .6rem;
                padding: .65rem .9rem;
                font-size: .75rem;
            }

            .search-input:focus {
                outline: 2px solid var(--brand-red-300);
                outline-offset: 2px;
            }

            .action-icon {
                width: 1rem;
                height: 1rem;
            }

            .price-red {
                color: var(--brand-red-600);
                font-weight: 600;
            }

            /* Sinkronisasi warna merah dengan dashboard (override Tailwind default) */
            .bg-red-600 {
                background-color: var(--brand-red-600) !important;
            }

            .bg-red-700 {
                background-color: var(--brand-red-700) !important;
            }

            .text-red-600 {
                color: var(--brand-red-600) !important;
            }

            .hover\:bg-red-700:hover {
                background-color: var(--brand-red-700) !important;
            }

            .focus\:ring-red-300:focus {
                box-shadow: 0 0 0 4px rgba(239, 163, 163, .6) !important;
            }
        </style>
        <style>
            /* Page-specific override: hide profile popup to avoid covering action buttons on this page */
            header .relative [x-cloak],
            header .relative [x-show] {
                display: none !important;

                =======<title>Kelola Produk — UlosTa Seller</title><script src="https://cdn.tailwindcss.com"></script><link rel="stylesheet" href="{{ asset('css/app.css') }}"><style> :root {
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
                    color: #fff >>>>>>> e8240baaadfc9d5a21106d2dcd6591599a25a1fc
                }
        </style>
</head>

<<<<<<< HEAD <body class="min-h-screen bg-gray-50 text-gray-800">
    <!-- Navbar -->
    @include('seller.partials.navbar')

    @php
        if (!function_exists('format_rp_products')) {
            function format_rp_products($v)
            {
                return 'Rp ' . number_format($v, 0, ',', '.');
            }
        }
        $products = [
            [
                'title' => 'Ulos Ragihotang Premium',
                'slug' => 'ulos-ragihotang-premium',
                'category' => 'Pernikahan',
                'price' => 1250000,
                'stock' => 15,
                'sold' => 45,
                'status' => 'Aktif',
                'img' => asset('image/' . rawurlencode('Ulos Ragi Hotang.jpg')),
            ],
            [
                'title' => 'Ulos Bintang Maratur Klasik',
                'slug' => 'ulos-bintang-maratur-klasik',
                'category' => 'Penghormatan',
                'price' => 950000,
                'stock' => 8,
                'sold' => 38,
                'status' => 'Aktif',
                'img' => asset('image/' . rawurlencode('Ulos Bintang Maratur.jpg')),
            ],
            [
                'title' => 'Ulos Sibolong Tradisional',
                'slug' => 'ulos-sibolong-tradisional',
                'category' => 'Kematian',
                'price' => 1100000,
                'stock' => 12,
                'sold' => 32,
                'status' => 'Aktif',
                // Perbaikan: file 'Ulos Sibolang.jpg' tidak ada, gunakan nama yang benar di folder public/image
                'img' => asset('image/' . rawurlencode('Ulos Sibolang Rasta Pamontari.jpg')),
            ],
            [
                'title' => 'Ulos Ragi Hidup Eksklusif',
                'slug' => 'ulos-ragi-hidup-eksklusif',
                'category' => 'Pernikahan',
                'price' => 1350000,
                'stock' => 0,
                'sold' => 25,
                'status' => 'Nonaktif',
                'img' => asset('image/' . rawurlencode('ulos2.jpg')),
            ],
            [
                'title' => 'Ulos Mangiring Premium',
                'slug' => 'ulos-mangiring-premium',
                'category' => 'Penghormatan',
                'price' => 875000,
                'stock' => 20,
                'sold' => 18,
                'status' => 'Aktif',
                'img' => asset('image/' . rawurlencode('ulos3.jpg')),
            ],
        ];
        // Filter produk yang sudah ditandai dihapus (demo) dari session
        // Merge produk custom yang dibuat via form create
        $custom = session('custom_products', []);
        if (!empty($custom)) {
            $products = array_merge($products, array_values($custom));
        }
        $deleted = session('deleted_products', []);
        if (!empty($deleted)) {
            $products = array_values(array_filter($products, fn($p) => !in_array($p['slug'], $deleted)));
        }
    @endphp

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if (session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-md">
                {{ session('success') }}
            </div>
        @endif
        <script>
            // Patch navbar "Laporan" link to point to reports route and set active style
            (function() {
                try {
                    const laporanHref = @json(route('seller.reports.index'));
                    const header = document.querySelector('header');
                    if (!header) return;
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
                } catch (e) {}
            })();
        </script>
        <!-- Header -->
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold mb-1">Kelola Produk</h1>
                <p class="text-sm text-gray-500">{{ count($products) }} produk ditemukan</p>
            </div>
            <div class="hidden md:flex">
                <a href="{{ route('seller.products.create') }}"
                    class="btn-add inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-semibold shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                    </svg>
                    Tambah Produk
                </a>
            </div>
        </div>

        <!-- Tools Bar -->
        <div class="bg-white border border-gray-200 rounded-xl px-5 py-4 mb-6 flex items-center gap-4">
            <div class="flex-1">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 19a8 8 0 1 1 5.293-14.293A8 8 0 0 1 11 19Zm8.5 1.5L16 15" />
                    </svg>
                    <input type="text" placeholder="Cari produk..." class="search-input pl-9" />
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button"
                    class="inline-flex items-center gap-1 text-xs font-medium px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M5 9h14M9 14h6M11 19h2" />
                    </svg>
                    Status: Semua
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="table-wrap border border-gray-200 rounded-xl overflow-hidden">
            <table>
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-64">Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Terjual</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $p)
                        <tr>
                            <td class="flex items-center gap-3 min-w-0">
                                <div class="w-12 h-12 rounded-md overflow-hidden bg-gray-100 shrink-0">
                                    <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}"
                                        class="w-full h-full object-cover" />
                                </div>
                                <div class="truncate">
                                    <p class="text-sm font-medium truncate">{{ $p['title'] }}</p>
                                </div>
                            </td>
                            <td><span class="badge badge-cat">{{ $p['category'] }}</span></td>
                            <td class="price-red">{{ format_rp_products($p['price']) }}</td>
                            <td class="{{ $p['stock'] == 0 ? 'text-red-600 font-semibold' : '' }}">{{ $p['stock'] }}
                                pcs</td>
                            <td>{{ $p['sold'] }}</td>
                            <td>
                                @if ($p['status'] === 'Aktif')
                                    <span class="badge badge-status-active">Aktif</span>
                                @else
                                    <span class="badge badge-status-inactive">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end items-center gap-3 text-gray-600">
                                    <button type="button" class="hover:text-gray-900" title="Lihat">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="action-icon" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7S2 12 2 12Zm10 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                        </svg>
                                    </button>
                                    <button type="button" class="hover:text-gray-900" title="Edit">
                                        <a href="{{ route('seller.products.edit', $p['slug']) }}" class="inline-flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="action-icon" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 3.487 20.5 7.125m-3.638-3.638-9.9 9.9a4.5 4.5 0 0 0-1.17 2.12L5.25 18.75l3.244-.543a4.5 4.5 0 0 0 2.12-1.17l9.9-9.9m-3.638-3.638 3.638 3.638M6.75 12.75l4.5 4.5" />
                                            </svg>
                                        </a>
                                    </button>
                                    <form method="POST" action="{{ route('seller.products.destroy', $p['slug']) }}"
                                        class="inline-flex" onsubmit="return confirm('Hapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hover:text-red-600" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="action-icon" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 7h12M9 7V4h6v3m1 0v13H8V7" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
    =======

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
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M3 12l9-9 9 9" />
                                    <path d="M9 21V9h6v12" />
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('seller.products.index') }}"
                                class="text-red-600 flex items-center gap-2">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="3" y="4" width="7" height="7" />
                                    <rect x="14" y="4" width="7" height="7" />
                                    <rect x="14" y="15" width="7" height="7" />
                                    <rect x="3" y="15" width="7" height="7" />
                                </svg>
                                Produk
                            </a>
                            <a href="{{ route('seller.orders.index') }}"
                                class="text-gray-600 flex items-center gap-2">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M3 7h18" />
                                    <path d="M6 7V4h12v3" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12" />
                                </svg>
                                Pesanan
                            </a>
                            <a href="#" class="text-gray-600 flex items-center gap-2">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                                </svg>
                                Laporan
                            </a>
                            <a href="{{ route('home') }}" class="text-gray-600 flex items-center gap-2">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
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
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v4" />
                                <path d="M14 10l7-7" />
                                <path d="M21 15v4a2 2 0 0 1-2 2h-4" />
                                <path d="M10 14l-7 7" />
                            </svg>
                            Kembali ke Toko
                        </a>
                        <span
                            class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-100">👤</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page content -->
        <main class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <a href="{{ route('seller.dashboard') }}"
                        class="text-sm text-gray-600 inline-flex items-center gap-2">←
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
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
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
                                $base = strtolower(
                                    preg_replace('/[\s_-]+/', '', pathinfo($original, PATHINFO_FILENAME)),
                                );
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
                                class="img-thumb"
                                onerror="this.onerror=null;this.src='{{ asset('image/ulos1.jpeg') }}'">
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
                            <span
                                class="stock-badge {{ $low ? 'stock-low' : 'stock-ok' }}">{{ $p['stock'] }}</span>
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
        >>>>>>> e8240baaadfc9d5a21106d2dcd6591599a25a1fc
    </body>

</html>
