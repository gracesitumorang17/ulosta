<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Laporan Penjualan - UlosTa Seller</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --brand-red-50: #FDEAEA;
            --brand-red-300: #EFA3A3;
            --brand-red-600: #AE0808;
            --brand-red-700: #8F0606;
            --brand-red-800: #6F0404;
            --gold-500: #f5b400;
        }

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

        .badge-status {
            display: inline-flex;
            align-items: center;
            padding: 0.15rem .6rem;
            font-size: 11px;
            font-weight: 600;
            border-radius: 9999px;
            background: var(--gold-500);
            color: #222;
        }

        .badge-status-pending {
            background: #eef0f3;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            text-align: left;
            font-size: .68rem;
            letter-spacing: .05em;
            text-transform: uppercase;
            font-weight: 600;
            padding: .75rem .9rem;
            color: #6b7280;
            background: #f9fafb;
        }

        td {
            padding: .7rem .9rem;
            font-size: .75rem;
            border-top: 1px solid #e5e7eb;
            background: #fff;
        }

        tbody tr:hover td {
            background: #f9fafb;
        }
    </style>
    <style>
        /* Page-specific override: hide profile dropdown popup (same as products page) */
        header .relative [x-cloak],
        header .relative [x-show] {
            display: none !important;
        }

        /* Sembunyikan seluruh konten laporan bila diperlukan */
        .hide-report-page {
            display: none !important;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50 text-gray-800">
    @include('seller.partials.navbar')
    @php
        // Nilai awal placeholder sebelum data API dimuat
        $totalRevenue = 0;
        $orderCount = 0;
        $avgOrder = 0;
        $soldProducts = 0;
        function format_rp_rep($v)
        {
            return 'Rp ' . number_format($v, 0, ',', '.');
        }
    @endphp
    <main id="report-main" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="text-2xl font-bold mb-1">Laporan Penjualan</h1>
            <p class="text-sm text-gray-500">Ringkasan performa toko dan transaksi terbaru</p>
        </div>
        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white border border-gray-200 rounded-xl p-5 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center">
                        <!-- Dollar icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v18M17 7a4 4 0 0 0-4-3H9a3 3 0 0 0 0 6h6a3 3 0 0 1 0 6H8a4 4 0 0 1-4-3" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-xs uppercase tracking-wide text-gray-500 mb-1">Total Pendapatan</div>
                    <div id="stat-totalRevenue" class="text-xl font-bold text-red-600">
                        {{ format_rp_rep($totalRevenue) }}</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center">
                        <!-- Cart icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l3 12h10l3-8H6" />
                            <circle cx="10" cy="20" r="1" />
                            <circle cx="19" cy="20" r="1" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-xs uppercase tracking-wide text-gray-500 mb-1">Total Pesanan</div>
                    <div id="stat-totalOrders" class="text-xl font-bold">{{ $orderCount }}</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center">
                        <!-- Trending up icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l6-6 4 4 7-7" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-xs uppercase tracking-wide text-gray-500 mb-1">Rata-rata Order</div>
                    <div id="stat-avgOrder" class="text-xl font-bold">{{ format_rp_rep($avgOrder) }}</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center">
                        <!-- Cube/box icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l8 4v10l-8 4-8-4V7l8-4Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7l8 4 8-4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-xs uppercase tracking-wide text-gray-500 mb-1">Produk Terjual</div>
                    <div id="stat-productsSold" class="text-xl font-bold">{{ $soldProducts }}</div>
                </div>
            </div>
        </div>
        <!-- Transaksi Terbaru -->
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h2 class="text-sm font-semibold flex items-center gap-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l3 12h10l3-8H6" />
                </svg>
                Transaksi Terbaru
            </h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="recent-body">
                        <tr>
                            <td colspan="5" class="text-center text-sm text-gray-500 py-4">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                class="mt-4 bg-gray-50 border border-gray-200 rounded-lg p-4 flex items-center justify-between text-xs">
                <div>Total <span id="order-count">{{ $orderCount }}</span> transaksi ditampilkan</div>
                <div class="flex items-center gap-4">
                    <span class="font-medium">Total Nilai</span>
                    <span class="text-red-600 font-semibold"><span
                            id="total-revenue">{{ format_rp_rep($totalRevenue) }}</span></span>
                </div>
            </div>
        </div>
    </main>
    <footer class="mt-16 py-8 text-center text-xs text-gray-500">© <span id="year"></span> UlosTa. All rights
        reserved.</footer>
    <script>
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
    <script>
        // Sembunyikan menu "Laporan" di navbar tanpa mengubah partial umum
        (function() {
            try {
                const header = document.querySelector('header');
                if (!header) return;
                header.querySelectorAll('nav a').forEach(a => {
                    const label = a.querySelector('span');
                    if (label && label.textContent.trim() === 'Laporan') {
                        a.style.display = 'none';
                    }
                });
                // Sembunyikan konten halaman laporan sepenuhnya
                const main = document.getElementById('report-main');
                if (main) main.classList.add('hide-report-page');
                // Opsional: arahkan balik ke halaman pesanan agar alur pengguna tetap lancar
                const backTo = @json(route('seller.orders.index'));
                if (backTo) window.location.replace(backTo);
            } catch (e) {}
        })();
    </script>
    <!-- Dinonaktifkan: pengambilan data laporan untuk sementara waktu -->
</body>

</html>
