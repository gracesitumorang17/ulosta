<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UlosTa Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Custom brand colors untuk Tailwind */
        :root {
            --brand-red: #AE0808;
        }
        
        /* Override Tailwind colors dengan brand colors */
        .bg-brand { background-color: var(--brand-red) !important; }
        .text-brand { color: var(--brand-red) !important; }
        .border-brand { border-color: var(--brand-red) !important; }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand': '#AE0808',
                        'gray': {
                            50: '#f8f9fa',
                            100: '#e9ecef',
                            400: '#6c757d',
                            900: '#212529'
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans bg-gray-50 text-gray-900 leading-normal">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="hidden lg:block w-[280px] bg-white border-r border-gray-100 py-6">
            <!-- Brand -->
            <div class="flex items-center gap-3 mb-8 px-6">
                <div class="w-12 h-12 rounded-xl bg-brand flex items-center justify-center text-white font-bold text-2xl">
                    U
                </div>
                <div class="brand-info">
                    <div class="text-2xl font-bold text-gray-900">UlosTa</div>
                    <div class="text-sm text-gray-400">Admin Panel</div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="px-6">
                <div class="mb-2">
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-brand text-white font-medium transition-all duration-200">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13z"/>
                            </svg>
                        </div>
                        Dashboard
                    </a>
                </div>
                <div class="mb-2">
                    <a href="{{ route('admin.verifikasi-penjual') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-900 hover:bg-gray-50 font-medium transition-all duration-200">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"/>
                            </svg>
                        </div>
                        Verifikasi Penjual
                    </a>
                </div>
                <div class="mb-2">
                    <a href="{{ route('admin.semua-penjual') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-900 hover:bg-gray-50 font-medium transition-all duration-200">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zM4 18v-1c0-2.66 5.33-4 8-4s8 1.34 8 4v1H4zM12 12c-2.67 0-8 1.34-8 4v1h16v-1c0-2.66-5.33-4-8-4z"/>
                                <path d="M8 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/>
                                <path d="M12.51 4.05C13.43 5.11 14 6.49 14 8c0 1.51-.57 2.89-1.49 3.95C14.47 11.7 16 10.04 16 8s-1.53-3.7-3.49-3.95z"/>
                            </svg>
                        </div>
                        Semua Penjual
                    </a>
                </div>
                <div class="mb-2">
                    <a href="{{ route('admin.penjual-tidak-aktif') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-900 hover:bg-gray-50 font-medium transition-all duration-200">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11H7v-2h10v2z"/>
                                <path d="M15 7c0-1.66-1.34-3-3-3S9 5.34 9 7s1.34 3 3 3 3-1.34 3-3zm-3 1c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z"/>
                                <path d="M18 17v1c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-1c0-1.1 1.79-2 6-2s6 .9 6 2z"/>
                            </svg>
                        </div>
                        Penjual Tidak Aktif
                    </a>
                </div>
                <div class="mb-2">
                    <a href="{{ route('admin.laporan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-900 hover:bg-gray-50 font-medium transition-all duration-200">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 3v18h18V3H3zm16 16H5V5h14v14z"/>
                                <path d="M7 7h10v2H7zm0 4h10v2H7zm0 4h7v2H7z"/>
                            </svg>
                        </div>
                        Laporan
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 bg-gray-50">
            <!-- Header -->
            <div class="bg-white border-b border-gray-100 px-4 lg:px-8 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-semibold">Dashboard Overview</h1>
                <div class="flex items-center gap-4">
                    <!-- Search Box -->
                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-100 rounded-lg px-3 py-2 min-w-[200px]">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                        <input type="text" placeholder="nabil" class="border-0 outline-none bg-transparent text-sm flex-1">
                    </div>
                    
                    <!-- User Info -->
                    <div class="flex items-center gap-2">
                        <div class="text-right">
                            <div class="text-sm font-medium">Admin User</div>
                            <div class="text-xs text-gray-400">admin@ulosta.com</div>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-brand text-white flex items-center justify-center font-semibold text-xs">
                            AU
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4 lg:p-8">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white border border-gray-100 rounded-xl p-6">
                        <div class="text-sm text-gray-400 mb-2">Total Perujuk</div>
                        <div class="text-3xl font-bold text-gray-900">{{ isset($verifications) ? $verifications->count() : 156 }}</div>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-xl p-6">
                        <div class="text-sm text-gray-400 mb-2">Menunggu Verifikasi</div>
                        <div class="text-3xl font-bold text-gray-900">{{ isset($verifications) ? $verifications->where('status', 'pending')->count() : 23 }}</div>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-xl p-6">
                        <div class="text-sm text-gray-400 mb-2">Terverifikasi</div>
                        <div class="text-3xl font-bold text-gray-900">{{ isset($verifications) ? $verifications->where('status', 'approved')->count() : 89 }}</div>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-xl p-6">
                        <div class="text-sm text-gray-400 mb-2">Tidak Aktif</div>
                        <div class="text-3xl font-bold text-gray-900">{{ isset($verifications) ? $verifications->where('status', 'inactive')->count() : 12 }}</div>
                    </div>
                </div>

                <!-- Action Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white border border-gray-100 rounded-xl p-6">
                        <div class="text-lg font-semibold mb-2">Verifikasi Pending</div>
                        <div class="text-sm text-gray-400 mb-4">Beberapa akun menunggu verifikasi Anda</div>
                        <a href="#" class="text-brand font-medium text-sm hover:underline">Lihat Detail →</a>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-xl p-6">
                        <div class="text-lg font-semibold mb-2">Pengguna Tidak Aktif</div>
                        <div class="text-sm text-gray-400 mb-4">Kelola akun yang sudah tidak aktif lam</div>
                        <a href="#" class="text-brand font-medium text-sm hover:underline">Lihat Detail →</a>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-xl p-6">
                        <div class="text-lg font-semibold mb-2">Lihat Laporan</div>
                        <div class="text-sm text-gray-400 mb-4">Statistik dan laporan aktivitas</div>
                        <a href="#" class="text-brand font-medium text-sm hover:underline">Lihat Detail →</a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white border border-gray-100 rounded-xl p-6">
                    <div class="text-lg font-semibold mb-4">Aktivasi Terbaru</div>
                    <div class="space-y-4">
                        @forelse($verifications ?? [] as $v)
                            <div class="flex items-center gap-4 py-4 border-b border-gray-100 last:border-b-0">
                                <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 font-semibold">
                                    {{ strtoupper(substr($v->name ?? 'N', 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium mb-0.5">{{ $v->name ?? 'Unknown' }}</div>
                                    <div class="text-sm text-gray-400 mb-0.5">{{ $v->email ?? 'No email' }}</div>
                                    <div class="text-xs text-gray-400">Menunggu Verifikasi pengajuan baru</div>
                                </div>
                            </div>
                        @empty
                            <div class="flex items-center gap-4 py-4 border-b border-gray-100">
                                <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 font-semibold">N</div>
                                <div class="flex-1">
                                    <div class="font-medium mb-0.5">Nabila sadarion</div>
                                    <div class="text-sm text-gray-400 mb-0.5">nabila@gmail.com</div>
                                    <div class="text-xs text-gray-400">Menunggu Verifikasi pengajuan baru</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 py-4 border-b border-gray-100">
                                <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 font-semibold">K</div>
                                <div class="flex-1">
                                    <div class="font-medium mb-0.5">Karni Prasetyo</div>
                                    <div class="text-sm text-gray-400 mb-0.5">karni@gmail.com</div>
                                    <div class="text-xs text-gray-400">Menunggu Verifikasi pengajuan baru</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 py-4">
                                <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 font-semibold">A</div>
                                <div class="flex-1">
                                    <div class="font-medium mb-0.5">Amos balaba</div>
                                    <div class="text-sm text-gray-400 mb-0.5">amos@gmail.com</div>
                                    <div class="text-xs text-gray-400">Menunggu Verifikasi pengajuan baru</div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>