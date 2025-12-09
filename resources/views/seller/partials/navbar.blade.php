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
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18l-1.5-4.5H4.5L3 7z" />
                               <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7" />
                               <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-5h6v5" />',
                        ],
                        [
                            'route' => 'seller.products.index',
                            'label' => 'Produk',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3l8 4v10l-8 4-8-4V7l8-4Z" />
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M4 7l8 4 8-4" />',
                        ],
                        [
                            'route' => 'seller.orders.index',
                            'label' => 'Pesanan',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 8V7a4 4 0 0 1 8 0v1" />
                                         <rect x="5" y="8" width="14" height="12" rx="2" ry="2" />
                                         <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6" />',
                        ],
                        [
                            'route' => 'seller.reports.index',
                            'label' => 'Laporan',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 17l6-6 4 4 7-7" />
                               <path stroke-linecap="round" stroke-linejoin="round" d="M14 5h6v6" />',
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
                        <div class="px-4 py-3" style="background-color: #AE0808;">
                            <p class="text-sm font-semibold text-white">{{ Auth::user()->name ?? 'Nama Penjual' }}</p>
                            <p class="text-xs text-white/80 mt-0.5">Penjual</p>
                        </div>
                        
                        <!-- Menu Items -->
                        <nav class="py-2">
                            <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="text-sm font-medium">Profil Saya</span>
                            </a>
                            
                            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                                </svg>
                                <span class="text-sm font-medium">Pesanan Saya</span>
                            </a>
                            
                            <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span class="text-sm font-medium">Wishlist</span>
                            </a>
                            
                            <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19" />
                                </svg>
                                <span class="text-sm font-medium">Dashboard Toko</span>
                            </a>
                            
                            <div class="my-2 border-t border-gray-100"></div>
                            
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span class="text-sm font-medium">Keluar</span>
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
