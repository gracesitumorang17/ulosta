<!-- Seller Navbar Partial -->
<header class="bg-white shadow-sm border-b sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Left: Logo -->
            <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-red-600 flex items-center justify-center shadow-sm">
                    <span class="text-white font-bold text-lg">U</span>
                </div>
                <span class="font-semibold text-lg">UlosTa Seller</span>
            </a>

            <!-- Center Nav -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                @php
                    $nav = [
                        [
                            'route' => 'seller.dashboard',
                            'label' => 'Dashboard',
                            'icon' =>
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18" /><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10V8l2-2h11l2 2v2" /><path stroke-linecap="round" stroke-linejoin="round" d="M5 21V10h14v11" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 21v-6h6v6" />',
                        ],
                        [
                            'route' => 'seller.products.index',
                            'label' => 'Produk',
                            'icon' =>
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M21 16.5V7.5a1 1 0 0 0-.555-.832l-8-4a1 1 0 0 0-.89 0l-8 4A1 1 0 0 0 3 7.5v9a1 1 0 0 0 .555.832l8 4a1 1 0 0 0 .89 0l8-4A1 1 0 0 0 21 16.5ZM3.5 7.75l8.5 4.25 8.5-4.25M12 12v9" />',
                        ],
                        [
                            'route' => 'seller.orders.index',
                            'label' => 'Pesanan',
                            'icon' =>
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l3 12h10l3-8H6" /><path stroke-linecap="round" stroke-linejoin="round" d="M10 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm9 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />',
                        ],
                        [
                            'route' => null,
                            'label' => 'Laporan',
                            'icon' =>
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 14l4-4 3 3 5-5" />',
                        ],
                    ];
                @endphp
                @foreach ($nav as $item)
                    @php $active = $item['route'] && request()->routeIs($item['route']); @endphp
                    <a @if ($item['route']) href="{{ route($item['route']) }}" @else href="#" @endif
                        class="flex items-center gap-2 {{ $active ? 'text-red-600' : 'text-gray-700 hover:text-red-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">{!! $item['icon'] !!}</svg>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <!-- Right -->
            <div class="flex items-center gap-3">
                <a href="{{ route('homepage') }}"
                    class="inline-flex items-center gap-2 border border-gray-300 rounded-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-red-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 6 9 12l6 6" />
                    </svg>
                    <span>Kembali ke Home</span>
                </a>
                <div class="relative">
                    <button id="profile-button" type="button"
                        class="flex items-center gap-2 px-3 py-2 rounded-full bg-gray-100 hover:bg-gray-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 12c2.485 0 4.5-2.015 4.5-4.5S14.485 3 12 3 7.5 5.015 7.5 7.5 9.515 12 12 12Zm0 1.5c-3.038 0-9 1.523-9 4.5v1.5h18V18c0-2.977-5.962-4.5-9-4.5Z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <!-- Popup Menu Profil Penjual -->
                    <div id="profile-menu" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-xl ring-1 ring-black/5 overflow-hidden z-50">
                        <!-- Header dengan info penjual -->
                        <div class="px-4 py-3 bg-gradient-to-r from-red-600 to-red-700">
                            <p class="text-sm font-semibold text-white">{{ Auth::user()->name ?? 'Nama Penjual' }}</p>
                            <p class="text-xs text-red-100 mt-0.5">Penjual</p>
                        </div>
                        
                        <!-- Menu Items -->
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
                                    <span class="text-sm font-medium">Logout</span>
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Toggle profile dropdown menu
    document.addEventListener('DOMContentLoaded', function() {
        const profileButton = document.getElementById('profile-button');
        const profileMenu = document.getElementById('profile-menu');
        
        if (profileButton && profileMenu) {
            profileButton.addEventListener('click', function(e) {
                e.stopPropagation();
                profileMenu.classList.toggle('hidden');
            });
            
            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (!profileMenu.classList.contains('hidden')) {
                    if (!profileMenu.contains(e.target) && !profileButton.contains(e.target)) {
                        profileMenu.classList.add('hidden');
                    }
                }
            });
        }
    });
</script>
