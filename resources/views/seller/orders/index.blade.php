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
            position: fixed;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            min-width: 180px;
            z-index: 999;
            display: none;
        }

        .action-trigger[aria-expanded="true"] .action-menu {
            display: block !important;
        }

        .action-menu ul {
            list-style: none;
            margin: 0;
            padding: 0.25rem 0;
        }

        .action-menu li {
            padding: 0.5rem 1rem;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .action-menu li:hover {
            background: #f9fafb;
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

        <div class="mb-6">
            <a href="{{ route('seller.dashboard') ?? url('/seller') }}" class="text-sm text-gray-500 hover:underline">&larr; Kembali ke Dashboard</a>
            <h1 class="text-2xl font-bold mt-3">Kelola Pesanan</h1>
            <p class="text-sm text-gray-500 mt-1">{{ count($list) }} pesanan ditemukan</p>
        </div>

        <!-- Status Filter Tabs -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex gap-3 flex-wrap">
                    @php
                        $tabColorMap = [
                            'Semua' => 'bg-white border border-gray-300',
                            'Menunggu' => 'bg-yellow-50 border border-yellow-200',
                            'Diproses' => 'bg-blue-50 border border-blue-200',
                            'Dikirim' => 'bg-purple-50 border border-purple-200',
                            'Selesai' => 'bg-green-50 border border-green-200',
                            'Dibatalkan' => 'bg-red-50 border border-red-200',
                        ];
                        $tabTextColorMap = [
                            'Semua' => 'text-gray-700',
                            'Menunggu' => 'text-yellow-700',
                            'Diproses' => 'text-blue-700',
                            'Dikirim' => 'text-purple-700',
                            'Selesai' => 'text-green-700',
                            'Dibatalkan' => 'text-red-700',
                        ];
                    @endphp
                    @foreach ($tabStatuses as $s)
                        @php $active = ($activeStatus === $s) || (!$activeStatus && $s==='Semua'); @endphp
                        <a href="{{ $s === 'Semua' ? route('seller.orders.index') : route('seller.orders.index', ['status' => $s]) }}"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all {{ $active ? $tabColorMap[$s] . ' ' . $tabTextColorMap[$s] : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                            data-tab="{{ $s }}">
                            <span>{{ $s }}</span>
                            <span class="inline-flex items-center justify-center min-w-6 px-2 py-0.5 text-xs font-bold rounded-full {{ $active ? 'bg-white' : 'bg-gray-200' }} js-tab-count" data-status="{{ $s }}">{{ $counts[$s] ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>
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
                                class="w-full pl-9 pr-3 py-3 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300 bg-gray-50" />
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
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left font-semibold px-6 py-4 text-gray-700">ID Pesanan</th>
                        <th class="text-left font-semibold px-6 py-4 text-gray-700">Pelanggan</th>
                        <th class="text-left font-semibold px-6 py-4 text-gray-700">Produk</th>
                        <th class="text-left font-semibold px-6 py-4 text-gray-700">Total</th>
                        <th class="text-left font-semibold px-6 py-4 text-gray-700">Tanggal</th>
                        <th class="text-left font-semibold px-6 py-4 text-gray-700">Status</th>
                        <th class="text-left font-semibold px-6 py-4 text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($list as $o)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $o->order_number ?? 'ORD-' . $o->id }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">
                                    {{ $o->shipping_first_name ? $o->shipping_first_name : (optional($o->user)->name ?? '—') }}
                                </div>
                                <div class="text-xs text-gray-500">{{ $o->shipping_phone ? $o->shipping_phone : (optional($o->user)->phone ?? '—') }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $o->orderItems ? $o->orderItems->count() : 0 }} item</td>
                            <td class="px-6 py-4 text-red-600 font-bold">
                                {{ format_rp((int) ($o->total_amount ?? ($o->subtotal ?? 0))) }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $o->created_at ? $o->created_at->format('Y-m-d H:i') : '—' }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusKey = $o->status;
                                    $badgeClass = $classMap[$statusKey] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold {{ $badgeClass }} js-status-badge"
                                    data-order-id="{{ $o->id }}">{{ $labelMap[$statusKey] ?? ucfirst($statusKey) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3 text-gray-600">
                                    <!-- Tombol Detail -->
                                    <a href="{{ route('seller.orders.show', $o->id) }}" class="hover:text-gray-900 transition-colors" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <!-- Dropdown Aksi -->
                                    <div class="action-trigger" aria-expanded="false" title="Aksi">
                                        <button type="button" class="p-1 hover:bg-gray-100 rounded transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>

                                        <div class="action-menu">
                                            <ul class="py-1">
                                                <!-- Terima Pesanan -->
                                                @if ($o->status === 'pending')
                                                    <li data-action="set-status" data-status="processing" class="px-4 py-2 hover:bg-gray-50 cursor-pointer text-sm flex items-center gap-2 transition-colors">
                                                        <span>✓</span> <span>Terima Pesanan</span>
                                                    </li>
                                                @endif

                                                <!-- Tandai Dikirim -->
                                                @if ($o->status === 'processing')
                                                    <li data-action="set-status" data-status="shipped" class="px-4 py-2 hover:bg-gray-50 cursor-pointer text-sm flex items-center gap-2 transition-colors">
                                                        <span>📦</span> <span>Tandai Dikirim</span>
                                                    </li>
                                                @endif

                                                <!-- Pesanan Selesai -->
                                                @if ($o->status === 'shipped')
                                                    <li data-action="set-status" data-status="delivered" class="px-4 py-2 hover:bg-gray-50 cursor-pointer text-sm flex items-center gap-2 transition-colors">
                                                        <span>✓</span> <span>Selesaikan Pesanan</span>
                                                    </li>
                                                @endif

                                                <!-- Batalkan Pesanan -->
                                                @if (!in_array($o->status, ['delivered', 'cancelled']))
                                                    <li data-action="set-status" data-status="cancelled" class="px-4 py-2 hover:bg-red-50 cursor-pointer text-sm text-red-600 flex items-center gap-2 transition-colors border-t border-gray-100">
                                                        <span>✕</span> <span>Batalkan Pesanan</span>
                                                    </li>
                                                @endif

                                                <!-- Pesan jika tidak ada aksi -->
                                                @if ($o->status === 'delivered' || $o->status === 'cancelled')
                                                    <li class="px-4 py-2 text-xs text-gray-400 italic">
                                                        Tidak ada aksi untuk pesanan ini
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Simpan ID Order untuk JS -->
                                    <input type="hidden" class="js-order-id" value="{{ $o->id }}">
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Belum ada pesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
    <script>
        // Action menu toggle
        document.addEventListener('click', (e) => {
            const trigger = e.target.closest('.action-trigger');
            const menu = e.target.closest('.action-menu');

            if (!trigger && !menu) {
                // Close all menus when clicking outside
                document.querySelectorAll('.action-trigger').forEach(t => {
                    t.setAttribute('aria-expanded', 'false');
                });
                return;
            }

            if (!trigger) return;

            // Toggle current menu
            const isOpen = trigger.getAttribute('aria-expanded') === 'true';

            // Close all other menus
            document.querySelectorAll('.action-trigger').forEach(t => {
                if (t !== trigger) {
                    t.setAttribute('aria-expanded', 'false');
                }
            });

            // Toggle current
            trigger.setAttribute('aria-expanded', !isOpen);

            // Position menu near button
            if (!isOpen) {
                setTimeout(() => positionMenu(trigger), 0);
            }
        });

        // Position dropdown menu
        function positionMenu(trigger) {
            const menu = trigger.querySelector('.action-menu');
            if (!menu) return;

            const button = trigger.querySelector('button');
            const rect = button.getBoundingClientRect();

            menu.style.top = (rect.bottom + 8) + 'px';
            menu.style.left = (rect.right - 180) + 'px';
        }

        // Close menu on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.action-trigger').forEach(t => {
                    t.setAttribute('aria-expanded', 'false');
                });
            }
        });

        // Status update mapping
        const STATUS_MAP = {
            'processing': 'pending',
            'shipped': 'processing',
            'delivered': 'shipped',
            'cancelled': 'cancelled'
        };

        const LABELS = {
            'pending': 'Menunggu',
            'processing': 'Diproses',
            'shipped': 'Dikirim',
            'delivered': 'Selesai',
            'cancelled': 'Dibatalkan'
        };

        const CLASSES = {
            'pending': 'bg-yellow-100 text-yellow-800',
            'processing': 'bg-indigo-100 text-indigo-700',
            'shipped': 'bg-purple-100 text-purple-700',
            'delivered': 'bg-green-100 text-green-700',
            'cancelled': 'bg-red-100 text-red-700'
        };

        // Handle status change
        document.addEventListener('click', async (e) => {
            const menuItem = e.target.closest('.action-menu li[data-action="set-status"]');
            if (!menuItem) return;

            const newStatus = menuItem.dataset.status;
            const row = menuItem.closest('tr');
            const orderId = row.querySelector('.js-order-id')?.value;
            const oldStatus = row.querySelector('.js-status-badge')?.textContent?.trim();

            if (!orderId) return;

            // Show loading overlay
            showLoading(true);
            const badge = row.querySelector('.js-status-badge');
            const originalBadgeText = badge?.textContent;

            try {
                // Update badge dengan loading state
                if (badge) {
                    badge.textContent = 'Memproses...';
                    badge.style.opacity = '0.6';
                }

                const response = await fetch(`/seller/orders/${orderId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: newStatus })
                });

                const data = await response.json();
                console.log('🔵 Status Update Response:', {
                    status: response.status,
                    ok: response.ok,
                    data: data,
                    orderId: orderId,
                    newStatus: newStatus
                });

                if (response.ok && data.success) {
                    const status = data.status || newStatus;
                    const newStatusLabel = LABELS[status] || status;

                    console.log('✅ Status update SUCCESS - old:', oldStatus, 'new:', newStatusLabel);

                    // Update badge langsung dengan status baru
                    if (badge) {
                        badge.textContent = newStatusLabel;
                        badge.className = `inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold js-status-badge ${CLASSES[status] || 'bg-gray-100 text-gray-700'}`;
                        badge.style.opacity = '1';
                    }

                    // Update tab counts
                    updateTabCounts(oldStatus, newStatusLabel);

                    // Show success notification
                    showNotification('Status pesanan berhasil diperbarui!', 'success');

                    // Hapus row dari tabel jika sedang filter status dan status berbeda
                    const activeStatus = new URLSearchParams(window.location.search).get('status');
                    if (activeStatus && activeStatus !== newStatusLabel && activeStatus !== 'Semua') {
                        setTimeout(() => {
                            row.style.opacity = '0';
                            row.style.transition = 'opacity 0.3s ease-out';
                            setTimeout(() => row.remove(), 300);
                        }, 500);
                    }
                } else {
                    // Restore badge text jika gagal
                    if (badge) {
                        badge.textContent = originalBadgeText;
                        badge.style.opacity = '1';
                    }
                    const errorMsg = data.message || 'Gagal memperbarui status pesanan';
                    console.error('❌ Status update FAILED:', errorMsg, data);
                    showNotification(errorMsg, 'error');
                }
            } catch (err) {
                console.error('❌ Error updating status (exception):', err);
                // Restore badge text jika error
                if (badge) {
                    badge.textContent = originalBadgeText;
                    badge.style.opacity = '1';
                }
                showNotification('Terjadi kesalahan saat memperbarui status: ' + err.message, 'error');
            } finally {
                showLoading(false);
            }

            // Close menu
            const trigger = menuItem.closest('.action-trigger');
            if (trigger) {
                trigger.setAttribute('aria-expanded', 'false');
            }
        });

        // Update tab counts
        function updateTabCounts(oldStatus, newStatus) {
            // Decrement old status count
            const oldTabCount = document.querySelector(`[data-status="${oldStatus}"]`);
            if (oldTabCount) {
                let count = parseInt(oldTabCount.textContent) || 0;
                if (count > 0) count--;
                oldTabCount.textContent = count;
            }

            // Increment new status count
            const newTabCount = document.querySelector(`[data-status="${newStatus}"]`);
            if (newTabCount) {
                let count = parseInt(newTabCount.textContent) || 0;
                count++;
                newTabCount.textContent = count;
            }

            // Update "Semua" count
            const semuaTabCount = document.querySelector(`[data-status="Semua"]`);
            if (semuaTabCount) {
                let count = parseInt(semuaTabCount.textContent) || 0;
                // Semua count tetap sama, hanya item yang bergerak antar status
                // Jadi tidak perlu update
            }
        }

        // Loading overlay function
        function showLoading(show) {
            let overlay = document.getElementById('loading-overlay');

            if (show) {
                if (!overlay) {
                    overlay = document.createElement('div');
                    overlay.id = 'loading-overlay';
                    overlay.className = 'fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-[9998]';
                    overlay.innerHTML = `
                        <div class="bg-white rounded-lg px-6 py-4 flex items-center gap-3 shadow-lg">
                            <div class="animate-spin">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                </svg>
                            </div>
                            <span class="text-gray-800 font-medium">Memperbarui status...</span>
                        </div>
                    `;
                    document.body.appendChild(overlay);
                }
            } else {
                if (overlay) {
                    overlay.remove();
                }
            }
        }

        // Simple notification function
        function showNotification(message, type = 'info') {
            // Create notification element
            const notif = document.createElement('div');
            notif.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white text-sm font-medium z-[9999] animate-pulse ${
                type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' :
                'bg-blue-500'
            }`;
            notif.textContent = message;

            document.body.appendChild(notif);

            // Remove after 3 seconds
            setTimeout(() => {
                notif.remove();
            }, 3000);
        }
    </script>
</body>

</html>
