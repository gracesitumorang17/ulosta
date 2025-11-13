<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - UlosTa Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-100 fixed h-full">
            <!-- Brand -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-xl">U</span>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-lg">UlosTa</div>
                        <div class="text-gray-400 text-sm">Admin Panel</div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-900 hover:bg-gray-50">
                    Dashboard
                </a>
                <a href="{{ route('admin.verifikasi-penjual') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-900 hover:bg-gray-50">
                    Verifikasi Penjual
                </a>
                <a href="{{ route('admin.semua-penjual') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-900 hover:bg-gray-50">
                    Semua Penjual
                </a>
                <a href="{{ route('admin.penjual-tidak-aktif') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-900 hover:bg-gray-50">
                    Penjual Tidak Aktif
                </a>
                <a href="{{ route('admin.laporan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-red-600 text-white">
                    Laporan
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64">
            <!-- Header -->
            <div class="bg-white border-b border-gray-100 px-8 py-4">
                <h1 class="text-2xl font-semibold">Laporan</h1>
            </div>

            <!-- Page Content -->
            <div class="p-8">
                <!-- Page Title -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan dan Statistik</h1>
                    <p class="text-gray-500">Monitor data dan statistik platform UlosTa</p>
                </div>

                <!-- Simple Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Total Penjual Aktif -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <div class="text-sm text-gray-500 mb-2">Total Penjual Aktif</div>
                        <div class="text-3xl font-bold text-blue-600">2</div>
                    </div>

                    <!-- Total Produk -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <div class="text-sm text-gray-500 mb-2">Total Produk</div>
                        <div class="text-3xl font-bold text-purple-600">413</div>
                    </div>

                    <!-- Total Transaksi -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <div class="text-sm text-gray-500 mb-2">Total Transaksi</div>
                        <div class="text-3xl font-bold text-green-600">671</div>
                    </div>

                    <!-- Tingkat Verifikasi -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <div class="text-sm text-gray-500 mb-2">Tingkat Verifikasi</div>
                        <div class="text-3xl font-bold text-orange-600">25%</div>
                    </div>
                </div>

                <!-- Simple Status Distribution -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Status Chart (Simple) -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Distribusi Status Penjualan</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                                    <span class="text-gray-700">Terverifikasi</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-32 h-2 bg-gray-200 rounded-full">
                                        <div class="w-3/4 h-2 bg-green-500 rounded-full"></div>
                                    </div>
                                    <span class="text-sm font-medium">75%</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                                    <span class="text-gray-700">Pending</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-32 h-2 bg-gray-200 rounded-full">
                                        <div class="w-1/2 h-2 bg-yellow-500 rounded-full"></div>
                                    </div>
                                    <span class="text-sm font-medium">50%</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-4 h-4 bg-gray-400 rounded-full"></div>
                                    <span class="text-gray-700">Tidak Aktif</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-32 h-2 bg-gray-200 rounded-full">
                                        <div class="w-1/4 h-2 bg-gray-400 rounded-full"></div>
                                    </div>
                                    <span class="text-sm font-medium">25%</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                                    <span class="text-gray-700">Suspended</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-32 h-2 bg-gray-200 rounded-full">
                                        <div class="w-1/6 h-2 bg-red-500 rounded-full"></div>
                                    </div>
                                    <span class="text-sm font-medium">15%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Aktivitas Terbaru</h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Penjual baru terverifikasi</div>
                                    <div class="text-xs text-gray-500">Nabil Azmi berhasil diverifikasi</div>
                                    <div class="text-xs text-gray-400">2 jam yang lalu</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Produk baru ditambahkan</div>
                                    <div class="text-xs text-gray-500">Sarah Ahmad menambahkan 3 produk</div>
                                    <div class="text-xs text-gray-400">4 jam yang lalu</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Permintaan verifikasi</div>
                                    <div class="text-xs text-gray-500">Andi Putra mengajukan verifikasi</div>
                                    <div class="text-xs text-gray-400">6 jam yang lalu</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
