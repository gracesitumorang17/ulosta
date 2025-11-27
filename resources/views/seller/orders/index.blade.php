<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Pesanan - UlosTa Seller</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --brand-red-600: #AE0808;
            --brand-red-700: #8F0606
        }

        .bg-red-600 {
            background-color: var(--brand-red-600) !important
        }

        .hover\:bg-red-700:hover {
            background-color: var(--brand-red-700) !important
        }

        /* Dropdown action menu */
        .action-trigger {
            position: relative;
        }

        .action-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: .5rem;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: .5rem;
            box-shadow: 0 4px 18px rgba(0, 0, 0, .08);
            width: 180px;
            font-size: .75rem;
            z-index: 40;
        }

        .action-menu[hidden] {
            display: none;
        }

        .action-menu ul {
            list-style: none;
            margin: 0;
            padding: .35rem 0;
        }

        .action-menu li {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: .45rem .9rem;
            cursor: pointer;
        }

        .action-menu li:hover {
            background: #f9fafb;
        }

        .action-menu li[data-danger="true"] {
            color: var(--brand-red-600);
        }

        .action-menu li[data-danger="true"]:hover {
            background: #fef2f2;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <header class="bg-white shadow-sm border-b sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-red-600 flex items-center justify-center shadow-sm"><span
                            class="text-white font-bold text-lg">U</span></div>
                    <span class="font-semibold text-lg">UlosTa Seller</span>
                </a>
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                    <a href="{{ route('seller.dashboard') }}"
                        class="flex items-center gap-2 {{ request()->routeIs('seller.dashboard') ? 'text-red-600' : 'text-gray-700 hover:text-red-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h7v7H3V3Zm11 0h7v5h-7V3ZM3 14h7v7H3v-7Zm11-6h7v13h-7V8Z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('seller.products.index') }}"
                        class="flex items-center gap-2 {{ request()->routeIs('seller.products.*') ? 'text-red-600' : 'text-gray-700 hover:text-red-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 16.5V7.5a1 1 0 0 0-.555-.832l-8-4a1 1 0 0 0-.89 0l-8 4A1 1 0 0 0 3 7.5v9a1 1 0 0 0 .555.832l8 4a1 1 0 0 0 .89 0l8-4A1 1 0 0 0 21 16.5ZM3.5 7.75l8.5 4.25 8.5-4.25M12 12v9" />
                        </svg>
                        <span>Produk</span>
                    </a>
                    <a href="{{ route('seller.orders.index') }}"
                        class="flex items-center gap-2 {{ request()->routeIs('seller.orders.*') ? 'text-red-600' : 'text-gray-700 hover:text-red-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l3 12h10l3-8H6" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm9 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                        </svg>
                        <span>Pesanan</span>
                    </a>
                    <a href="#" class="flex items-center gap-2 text-gray-700 hover:text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 14l4-4 3 3 5-5" />
                        </svg>
                        <span>Laporan</span>
                    </a>
                </nav>
                <div class="flex items-center gap-3">
                    <a href="{{ route('homepage') }}"
                        class="hidden sm:inline-block border border-gray-300 rounded-full px-4 py-2 text-sm hover:bg-gray-100">Kembali
                        ke Toko</a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @php
            // Sample dataset (replace later with DB)
            if (!function_exists('format_rp')) {
                function format_rp($v)
                {
                    return 'Rp ' . number_format($v, 0, ',', '.');
                }
            }
            $orders = [
                [
                    'code' => 'ORD001234',
                    'customer' => 'Budi Santoso',
                    'phone' => '081234567890',
                    'items' => 1,
                    'total' => 1250000,
                    'date' => '2025-01-15 10:30',
                    'status' => 'Menunggu',
                ],
                [
                    'code' => 'ORD001235',
                    'customer' => 'Siti Nurhaliza',
                    'phone' => '082345678901',
                    'items' => 1,
                    'total' => 950000,
                    'date' => '2025-01-14 15:20',
                    'status' => 'Diproses',
                ],
                [
                    'code' => 'ORD001236',
                    'customer' => 'Ahmad Dhani',
                    'phone' => '083456789012',
                    'items' => 1,
                    'total' => 1100000,
                    'date' => '2025-01-13 09:15',
                    'status' => 'Dikirim',
                ],
                [
                    'code' => 'ORD001237',
                    'customer' => 'Dewi Lestari',
                    'phone' => '084567890123',
                    'items' => 1,
                    'total' => 2700000,
                    'date' => '2025-01-10 14:45',
                    'status' => 'Selesai',
                ],
            ];
            $statuses = ['Semua', 'Menunggu', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];
            $statusColors = [
                'Menunggu' => 'bg-yellow-100 text-yellow-800',
                'Diproses' => 'bg-indigo-100 text-indigo-700',
                'Dikirim' => 'bg-purple-100 text-purple-700',
                'Selesai' => 'bg-green-100 text-green-700',
                'Dibatalkan' => 'bg-red-100 text-red-700',
            ];
            $counts = [];
            foreach ($statuses as $s) {
                if ($s === 'Semua') {
                    $counts[$s] = count($orders);
                } else {
                    $counts[$s] = count(array_filter($orders, fn($o) => $o['status'] === $s));
                }
            }
            $activeStatus = request('status');
            $list = $orders;
            if ($activeStatus && $activeStatus !== 'Semua') {
                $list = array_values(array_filter($orders, fn($o) => $o['status'] === $activeStatus));
            }
        @endphp

        <h1 class="text-2xl font-bold mb-1">Kelola Pesanan</h1>
        <p class="text-sm text-gray-500 mb-6">{{ count($list) }} pesanan ditemukan</p>

        <!-- Status Filter Tabs -->
        <div class="bg-white border border-gray-200 rounded-xl p-4 mb-6">
            <div class="flex flex-wrap gap-6">
                @foreach ($statuses as $s)
                    @php $active = ($activeStatus === $s) || (!$activeStatus && $s==='Semua'); @endphp
                    <a href="{{ $s === 'Semua' ? route('seller.orders.index') : route('seller.orders.index', ['status' => $s]) }}"
                        class="relative flex flex-col items-center justify-center min-w-[100px] px-4 py-3 rounded-lg text-xs font-medium {{ $active ? 'bg-gray-50 border border-gray-300 shadow-sm' : 'hover:bg-gray-50' }}">
                        <span class="mb-1">{{ $s }}</span>
                        <span
                            class="inline-flex items-center justify-center w-5 h-5 text-[11px] font-semibold rounded-full bg-gray-200 text-gray-700">{{ $counts[$s] }}</span>
                        @if ($active)
                            <span class="absolute inset-0 rounded-lg ring-1 ring-gray-300 pointer-events-none"></span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Search Bar -->
        <div class="bg-white border border-gray-200 rounded-xl p-4 mb-6">
            <form method="get" class="flex items-center">
                @if ($activeStatus && $activeStatus !== 'Semua')
                    <input type="hidden" name="status" value="{{ $activeStatus }}" />
                @endif
                <div class="flex items-center w-full gap-3">
                    <div class="flex items-center gap-2 flex-1">
                        <div class="relative w-full">
                            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.5 3a7.5 7.5 0 1 1 0 15 7.5 7.5 0 0 1 0-15Zm7 12 3.5 3.5" />
                                </svg>
                            </span>
                            <input type="text" name="q" value="{{ request('q') }}"
                                placeholder="Cari pesanan atau pelanggan..."
                                class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-300" />
                        </div>
                        <button
                            class="hidden sm:inline-flex items-center px-3 py-2 text-xs font-medium bg-red-600 hover:bg-red-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-red-300"
                            type="submit">Cari</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-600">
                    <tr>
                        <th class="text-left font-semibold px-4 py-3 border-b">ID Pesanan</th>
                        <th class="text-left font-semibold px-4 py-3 border-b">Pelanggan</th>
                        <th class="text-left font-semibold px-4 py-3 border-b">Produk</th>
                        <th class="text-left font-semibold px-4 py-3 border-b">Total</th>
                        <th class="text-left font-semibold px-4 py-3 border-b">Tanggal</th>
                        <th class="text-left font-semibold px-4 py-3 border-b">Status</th>
                        <th class="text-left font-semibold px-4 py-3 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-700">
                    @forelse ($list as $o)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium">{{ $o['code'] }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium">{{ $o['customer'] }}</div>
                                <div class="text-xs text-gray-500">{{ $o['phone'] }}</div>
                            </td>
                            <td class="px-4 py-3">{{ $o['items'] }} item</td>
                            <td class="px-4 py-3 text-red-600 font-medium">{{ format_rp($o['total']) }}</td>
                            <td class="px-4 py-3">{{ $o['date'] }}</td>
                            <td class="px-4 py-3">
                                @php $sc = $statusColors[$o['status']] ?? 'bg-gray-100 text-gray-700'; @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $sc }}">{{ $o['status'] }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3 text-gray-500">
                                    <a href="#" class="hover:text-gray-700" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Zm9.5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                        </svg>
                                    </a>
                                    <button type="button" class="hover:text-gray-700 action-trigger" title="Aksi"
                                        aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm0 7a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm0 7a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Z" />
                                        </svg>
                                        <div class="action-menu" hidden role="menu" aria-label="Aksi Pesanan">
                                            <ul>
                                                <li data-action="accept" role="menuitem">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4 text-green-600" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m4.5 12.75 6 6 9-13.5" />
                                                    </svg>
                                                    Terima Pesanan
                                                </li>
                                                <li data-action="cancel" data-danger="true" role="menuitem">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18 18 6M6 6l12 12" />
                                                    </svg>
                                                    Batalkan Pesanan
                                                </li>
                                            </ul>
                                        </div>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500">Tidak ada pesanan
                                untuk status ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
    <script>
        // Action menu logic (vanilla JS)
        document.addEventListener('click', (e) => {
            const triggerBtn = e.target.closest('.action-trigger');
            // Close all if clicked outside any trigger/menu
            if (!triggerBtn) {
                document.querySelectorAll('.action-menu:not([hidden])').forEach(m => {
                    m.hidden = true;
                    const btn = m.closest('.action-trigger');
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                });
            } else {
                const menu = triggerBtn.querySelector('.action-menu');
                const isOpen = !menu.hidden;
                // close others
                document.querySelectorAll('.action-menu:not([hidden])').forEach(m => {
                    if (m !== menu) {
                        m.hidden = true;
                        const b = m.closest('.action-trigger');
                        if (b) b.setAttribute('aria-expanded', 'false');
                    }
                });
                menu.hidden = isOpen; // toggle
                triggerBtn.setAttribute('aria-expanded', menu.hidden ? 'false' : 'true');
            }
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.action-menu:not([hidden])').forEach(m => {
                    m.hidden = true;
                    const btn = m.closest('.action-trigger');
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                });
            }
        });
        // Demo handlers (show alert) - replace later with real actions
        document.addEventListener('click', e => {
            const li = e.target.closest('.action-menu li');
            if (!li) return;
            const action = li.dataset.action;
            if (action === 'accept') alert('Pesanan diterima (demo).');
            if (action === 'cancel') alert('Pesanan dibatalkan (demo).');
            // close menu after action
            const menu = li.closest('.action-menu');
            if (menu) {
                menu.hidden = true;
                const btn = menu.closest('.action-trigger');
                if (btn) btn.setAttribute('aria-expanded', 'false');
            }
        });

        // Wire up navbar "Laporan" link without changing the partial
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
            } catch (_) {}
        })();
    </script>
</body>

</html>
