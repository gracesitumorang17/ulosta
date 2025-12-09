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
    @include('seller.partials.navbar')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @php
            if (!function_exists('format_rp')) {
                function format_rp($v)
                {
                    return 'Rp ' . number_format($v, 0, ',', '.');
                }
            }
            // Backend key -> Indonesian label
            $labelMap = [
                'pending' => 'Menunggu',
                'processing' => 'Diproses',
                'shipped' => 'Dikirim',
                'delivered' => 'Selesai',
                'cancelled' => 'Dibatalkan',
            ];
            // Backend key -> badge classes
            $classMap = [
                'pending' => 'bg-yellow-100 text-yellow-800',
                'processing' => 'bg-indigo-100 text-indigo-700',
                'shipped' => 'bg-purple-100 text-purple-700',
                'delivered' => 'bg-green-100 text-green-700',
                'cancelled' => 'bg-red-100 text-red-700',
            ];
            $tabStatuses = ['Semua', 'Menunggu', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];
            // Build counts from real $orders provided by controller
            $counts = [];
            foreach ($tabStatuses as $s) {
                if ($s === 'Semua') {
                    $counts[$s] = isset($orders) ? $orders->count() : 0;
                } else {
                    $key = array_search($s, $labelMap, true);
                    $counts[$s] = isset($orders) ? $orders->where('status', $key)->count() : 0;
                }
            }
            $activeStatus = request('status');
            $list = isset($orders) ? $orders : collect();
            if ($activeStatus && $activeStatus !== 'Semua') {
                $key = array_search($activeStatus, $labelMap, true);
                if ($key) {
                    $list = $list->where('status', $key);
                }
            }
        @endphp

        <h1 class="text-2xl font-bold mb-1">Kelola Pesanan</h1>
        <p class="text-sm text-gray-500 mb-6">{{ count($list) }} pesanan ditemukan</p>

        <!-- Status Filter Tabs -->
        <div class="bg-white border border-gray-200 rounded-xl p-4 mb-6">
            <div class="flex flex-wrap gap-6">
                @foreach ($tabStatuses as $s)
                    @php $active = ($activeStatus === $s) || (!$activeStatus && $s==='Semua'); @endphp
                    <a href="{{ $s === 'Semua' ? route('seller.orders.index') : route('seller.orders.index', ['status' => $s]) }}"
                        class="relative flex flex-col items-center justify-center min-w-[100px] px-4 py-3 rounded-lg text-xs font-medium {{ $active ? 'bg-gray-50 border border-gray-300 shadow-sm' : 'hover:bg-gray-50' }}">
                        <span class="mb-1">{{ $s }}</span>
                        <span
                            class="inline-flex items-center justify-center w-5 h-5 text-[11px] font-semibold rounded-full bg-gray-200 text-gray-700">{{ $counts[$s] ?? 0 }}</span>
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
                            <td class="px-4 py-3 font-medium">{{ $o->order_number ?? 'ORD-' . $o->id }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium">{{ optional($o->user)->name ?? '—' }}</div>
                                <div class="text-xs text-gray-500">{{ optional($o->user)->phone ?? '—' }}</div>
                            </td>
                            <td class="px-4 py-3">{{ $o->orderItems ? $o->orderItems->count() : 0 }} item</td>
                            <td class="px-4 py-3 text-red-600 font-medium">
                                {{ format_rp((int) ($o->total_amount ?? ($o->subtotal ?? 0))) }}</td>
                            <td class="px-4 py-3">{{ $o->created_at ? $o->created_at->format('Y-m-d H:i') : '—' }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusKey = $o->status;
                                    $badgeClass = $classMap[$statusKey] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $badgeClass }} js-status-badge"
                                    data-order-id="{{ $o->id }}">{{ $labelMap[$statusKey] ?? ucfirst($statusKey) }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3 text-gray-500">
                                    <a href="{{ route('seller.orders.show', $o->id) }}" class="hover:text-gray-700"
                                        title="Detail">
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
                                                <li data-action="set-status" data-status="pending" role="menuitem">
                                                    Tandai Menunggu</li>
                                                <li data-action="set-status" data-status="processing" role="menuitem">
                                                    Tandai Diproses</li>
                                                <li data-action="set-status" data-status="shipped" role="menuitem">
                                                    Tandai Dikirim</li>
                                                <li data-action="set-status" data-status="delivered" role="menuitem">
                                                    Tandai Selesai</li>
                                                <li data-action="set-status" data-status="cancelled"
                                                    data-danger="true" role="menuitem">Batalkan</li>
                                            </ul>
                                        </div>
                                    </button>
                                    <input type="hidden" class="js-order-id" value="{{ $o->id }}" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500">Belum ada pesanan.
                            </td>
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
        // Status update via AJAX
        const LABELS = {
            pending: 'Menunggu',
            processing: 'Diproses',
            shipped: 'Dikirim',
            delivered: 'Selesai',
            cancelled: 'Dibatalkan'
        };
        const CLASSES = {
            pending: 'bg-yellow-100 text-yellow-800',
            processing: 'bg-indigo-100 text-indigo-700',
            shipped: 'bg-purple-100 text-purple-700',
            delivered: 'bg-green-100 text-green-700',
            cancelled: 'bg-red-100 text-red-700'
        };
        document.addEventListener('click', async e => {
            const li = e.target.closest('.action-menu li');
            if (!li) return;
            const action = li.dataset.action;
            if (action !== 'set-status') return;
            const status = li.dataset.status;
            const row = li.closest('tr');
            const idInput = row.querySelector('.js-order-id');
            const orderId = idInput ? idInput.value : null;
            if (!orderId) return;
            try {
                const res = await fetch(`/seller/orders/${orderId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status
                    })
                });
                if (res.ok) {
                    const data = await res.json();
                    const key = data.status || status;
                    const badge = row.querySelector('.js-status-badge');
                    if (badge) {
                        badge.className =
                            `inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold js-status-badge ${CLASSES[key] || 'bg-gray-100 text-gray-700'}`;
                        badge.textContent = LABELS[key] || key;
                    }
                }
            } catch (err) {}
            const menu = li.closest('.action-menu');
            if (menu) {
                menu.hidden = true;
                const btn = menu.closest('.action-trigger');
                if (btn) btn.setAttribute('aria-expanded', 'false');
            }
        });

        // Using shared navbar partial; no per-page nav patch required
    </script>
</body>

</html>
