<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Kelola Produk - UlosTa Seller</title>
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
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50 text-gray-800">
    <!-- Navbar -->
    @include('seller.partials.navbar')

    @php
        if (!function_exists('format_rp_products')) {
            function format_rp_products($v)
            {
                return 'Rp ' . number_format($v, 0, ',', '.');
            }
        }
        // Ambil produk murni dari DB (tanpa demo/session) dan normalkan URL gambar
        $products = \App\Models\Product::where('seller_id', Auth::id())
            ->get()
            ->map(function ($p) {
                $slug = $p->slug ?: strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $p->name)));
                $imgRaw = $p->image;
                $img = $imgRaw
                    ? (str_starts_with($imgRaw, 'http')
                        ? $imgRaw
                        : (str_starts_with($imgRaw, '/storage/')
                            ? $imgRaw
                            : asset('storage/' . ltrim($imgRaw, '/'))))
                    : asset('image/' . rawurlencode('ulos1.jpeg'));

                return [
                    'id' => $p->id,
                    'title' => $p->name,
                    'slug' => $slug,
                    'category' => $p->category, // fungsi
                    'jenis' => $p->tag,
                    'price' => (int) $p->price,
                    'stock' => (int) $p->stock,
                    'sold' => 0,
                    'status' => $p->is_active ? 'Aktif' : 'Nonaktif',
                    'img' => $img,
                    // Detail untuk preview
                    'desc' => $p->description,
                    'material' => $p->material,
                    'size' => $p->size,
                    'weight' => $p->weight,
                    'origin' => $p->origin,
                ];
            })
            ->toArray();
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
                <div class="relative">
                    <button type="button" id="statusFilterBtn"
                        class="inline-flex items-center gap-1 text-xs font-medium px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50"
                        aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M5 9h14M9 14h6M11 19h2" />
                        </svg>
                        <span id="statusFilterLabel">Status: Semua</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="statusFilterDropdown" class="hidden absolute top-full right-0 mt-2 w-40 bg-white border border-gray-300 rounded-lg shadow-lg z-10">
                        <ul class="py-1">
                            <li><button type="button" class="status-filter-option w-full text-left px-4 py-2 hover:bg-gray-100 text-xs font-medium" data-status="Semua">Semua</button></li>
                            <li><button type="button" class="status-filter-option w-full text-left px-4 py-2 hover:bg-gray-100 text-xs font-medium" data-status="Aktif">Aktif</button></li>
                            <li><button type="button" class="status-filter-option w-full text-left px-4 py-2 hover:bg-gray-100 text-xs font-medium" data-status="Nonaktif">Nonaktif</button></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-wrap border border-gray-200 rounded-xl overflow-hidden">
            <table>
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-64">Produk</th>
                        <th>Fungsi</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Terjual</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $p)
                        <tr data-title="{{ $p['title'] }}" data-img="{{ $p['img'] }}"
                            data-category="{{ $p['category'] }}" data-jenis="{{ $p['jenis'] ?? '' }}"
                            data-price="{{ $p['price'] }}" data-stock="{{ $p['stock'] }}"
                            data-description="{{ $p['desc'] ?? '' }}" data-material="{{ $p['material'] ?? '' }}"
                            data-size="{{ $p['size'] ?? '' }}" data-weight="{{ $p['weight'] ?? '' }}"
                            data-origin="{{ $p['origin'] ?? '' }}" data-status="{{ $p['status'] }}">
                            <td class="flex items-center gap-3 min-w-0">
                                <div class="w-12 h-12 rounded-md overflow-hidden bg-gray-100 shrink-0">
                                    <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}"
                                        class="w-full h-full object-cover"
                                        onerror="this.src='{{ asset('image/ulos1.jpeg') }}'" />
                                </div>
                                <div class="truncate">
                                    <p class="text-sm font-medium truncate">{{ $p['title'] }}</p>
                                </div>
                            </td>
                            <td><span class="badge badge-cat">{{ $p['category'] }}</span></td>
                            <td><span class="badge badge-cat">{{ $p['jenis'] ?? '-' }}</span></td>
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
                                    <button type="button" class="hover:text-gray-900 js-open-preview" title="Lihat">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" class="action-icon"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="1.7">
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
    <!-- Modal Preview -->
    <div id="listPreviewModal" class="fixed inset-0 bg-black/40 z-40 hidden">
        <div class="absolute inset-0 flex items-start justify-center pt-10 px-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-5xl overflow-hidden">
                <div class="flex items-center justify-between px-5 py-3 border-b">
                    <div>
                        <h2 class="text-lg font-semibold">Preview Produk</h2>
                        <p class="text-xs text-gray-500">Tampilan seperti yang dilihat pembeli</p>
                    </div>
                    <button type="button" id="listClosePreview" class="p-2 rounded-md hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8" class="w-5 h-5 text-gray-700">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="rounded-xl overflow-hidden bg-gray-100">
                            <img id="lpImg" src="" alt="Preview Gambar"
                                class="w-full h-72 object-cover" />
                        </div>
                        <span id="lpActive"
                            class="inline-block mt-3 text-[11px] bg-yellow-100 text-yellow-800 px-3 py-1 rounded-md">Produk
                            Aktif</span>
                    </div>
                    <div>
                        <span id="lpCatBadge"
                            class="inline-block text-[11px] bg-gray-200 text-gray-700 px-3 py-1 rounded-md mb-2"></span>
                        <h3 id="lpTitle" class="text-xl font-semibold"></h3>
                        <div class="mt-2">
                            <span id="lpPrice" class="text-2xl text-red-600 font-bold"></span>
                        </div>
                        <div class="mt-4 flex items-center justify-between text-sm">
                            <span class="text-gray-500">Ketersediaan</span>
                            <span id="lpStock" class="text-green-600"></span>
                        </div>
                        <hr class="my-4" />
                        <div>
                            <h4 class="font-semibold mb-2">Deskripsi Produk</h4>
                            <p id="lpDesc" class="text-sm text-gray-700"></p>
                        </div>
                        <div class="mt-4 card">
                            <div class="card-header">Detail Produk</div>
                            <ul class="space-y-2 text-sm">
                                <li id="lpMaterialWrap" style="display:none"><strong>Bahan:</strong> <span
                                        id="lpMaterial"></span></li>
                                <li id="lpSizeWrap" style="display:none"><strong>Ukuran:</strong> <span
                                        id="lpSize"></span></li>
                                <li id="lpWeightWrap" style="display:none"><strong>Berat:</strong> <span
                                        id="lpWeight"></span></li>
                                <li id="lpOriginWrap" style="display:none"><strong>Asal Daerah:</strong> <span
                                        id="lpOrigin"></span></li>
                                <li id="lpJenisWrap" style="display:none"><strong>Jenis Ulos:</strong> <span
                                        id="lpJenis"></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function() {
            const modal = document.getElementById('listPreviewModal');
            const closeBtn = document.getElementById('listClosePreview');

            function rp(n) {
                try {
                    n = parseInt(n || 0);
                } catch (e) {
                    n = 0;
                }
                return 'Rp ' + n.toLocaleString('id-ID');
            }

            function setText(el, val) {
                if (el) el.textContent = val || '';
            }

            function setShow(el, show) {
                if (!el) return;
                el.style.display = show ? '' : 'none';
            }
            document.querySelectorAll('.js-open-preview').forEach(btn => {
                btn.addEventListener('click', () => {
                    const row = btn.closest('tr');
                    if (!row) return;
                    const title = row.dataset.title;
                    const img = row.dataset.img;
                    const cat = row.dataset.category;
                    const jenis = row.dataset.jenis;
                    const price = row.dataset.price;
                    const stock = row.dataset.stock;
                    const desc = row.dataset.description;
                    const material = row.dataset.material;
                    const size = row.dataset.size;
                    const weight = row.dataset.weight;
                    const origin = row.dataset.origin;

                    const lpImg = document.getElementById('lpImg');
                    if (lpImg) {
                        lpImg.src = img || '';
                    }
                    setText(document.getElementById('lpCatBadge'), cat);
                    setText(document.getElementById('lpTitle'), title);
                    setText(document.getElementById('lpPrice'), rp(price));
                    setText(document.getElementById('lpStock'), `Stok tersedia (${stock} pcs)`);
                    setText(document.getElementById('lpDesc'), desc);

                    setText(document.getElementById('lpMaterial'), material);
                    setShow(document.getElementById('lpMaterialWrap'), !!material);
                    setText(document.getElementById('lpSize'), size);
                    setShow(document.getElementById('lpSizeWrap'), !!size);
                    setText(document.getElementById('lpWeight'), weight ? `${weight} gram` : '');
                    setShow(document.getElementById('lpWeightWrap'), !!weight);
                    setText(document.getElementById('lpOrigin'), origin);
                    setShow(document.getElementById('lpOriginWrap'), !!origin);
                    setText(document.getElementById('lpJenis'), jenis);
                    setShow(document.getElementById('lpJenisWrap'), !!jenis);

                    modal.classList.remove('hidden');
                });
            });
            if (closeBtn) {
                closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
            }
            if (modal) {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) modal.classList.add('hidden');
                });
            }

            // Status Filter
            const statusFilterBtn = document.getElementById('statusFilterBtn');
            const statusFilterDropdown = document.getElementById('statusFilterDropdown');
            const statusFilterLabel = document.getElementById('statusFilterLabel');
            const statusFilterOptions = document.querySelectorAll('.status-filter-option');

            if (statusFilterBtn) {
                statusFilterBtn.addEventListener('click', () => {
                    statusFilterDropdown.classList.toggle('hidden');
                    statusFilterBtn.setAttribute('aria-expanded', !statusFilterDropdown.classList.contains('hidden'));
                });
            }

            statusFilterOptions.forEach(option => {
                option.addEventListener('click', () => {
                    const selectedStatus = option.dataset.status;
                    statusFilterLabel.textContent = `Status: ${selectedStatus}`;
                    statusFilterDropdown.classList.add('hidden');
                    statusFilterBtn.setAttribute('aria-expanded', 'false');

                    // Filter rows
                    const rows = document.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        const rowStatus = row.dataset.status;
                        if (selectedStatus === 'Semua' || rowStatus === selectedStatus) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('#statusFilterBtn') && !e.target.closest('#statusFilterDropdown')) {
                    statusFilterDropdown.classList.add('hidden');
                    statusFilterBtn.setAttribute('aria-expanded', 'false');
                }
            });
        })();
    </script>
</body>

</html>
