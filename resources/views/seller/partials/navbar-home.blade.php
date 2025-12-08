<!-- Seller Navbar for Homepage -->
<header class="bg-white shadow-sm border-b sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Left: Logo -->
            <div class="flex items-center">
                <a href="{{ route('homepage') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-md bg-red-600 flex items-center justify-center text-white font-bold">
                        U
                    </div>
                    <span class="text-lg font-semibold">UlosTa</span>
                </a>
            </div>

            <!-- Center: Search -->
            <div class="flex-1 hidden md:flex justify-center px-4 max-w-2xl">
                <form action="{{ route('homepage') }}" method="GET" class="w-full">
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                            </svg>
                        </div>
                        <input
                            name="q"
                            type="search"
                            placeholder="Cari ulos tradisional ..."
                            class="w-full bg-gray-100 border border-gray-200 rounded-full py-2.5 pl-10 pr-4 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-300"
                            aria-label="Cari ulos"
                        />
                    </div>
                </form>
            </div>

            <!-- Right: Navigation Links -->
            <div class="flex items-center gap-6">
                <!-- Home -->
                <a href="{{ route('homepage') }}" class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-sm font-medium">Home</span>
                </a>

                <!-- Wishlist -->
                <a href="{{ route('wishlist.index') }}" class="relative flex items-center gap-2 text-gray-800 hover:text-red-600 transition">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        @php
                            $wishlistCount = Auth::user()->wishlists()->count();
                        @endphp
                        @if($wishlistCount > 0)
                        <span class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                            {{ $wishlistCount > 99 ? '99+' : $wishlistCount }}
                        </span>
                        @endif
                    </div>
                    <span class="text-sm font-medium">Wishlist</span>
                </a>

                <!-- Keranjang -->
                <a href="{{ route('keranjang') }}" class="relative flex items-center gap-2 text-gray-800 hover:text-red-600 transition">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                        @php
                            $cartCount = Auth::user()->cartItems()->sum('quantity');
                        @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                            {{ $cartCount > 99 ? '99+' : $cartCount }}
                        </span>
                        @endif
                    </div>
                    <span class="text-sm font-medium">Keranjang</span>
                </a>

                <!-- Profil (button + popup dropdown) -->
                <div class="relative">
                    <button id="profile-button" type="button" class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm font-medium">Profil</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Popup Menu Profil Penjual -->
                    <div id="profile-menu" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-xl ring-1 ring-black/5 overflow-hidden z-50">
                        <!-- Header dengan info penjual -->
                        <div class="px-4 py-3" style="background: linear-gradient(to right, #AE0808, #8F0606);">
                            <p class="text-sm font-semibold text-white">{{ Auth::user()->name ?? 'Nama Penjual' }}</p>
                            <p class="text-xs text-red-100 mt-0.5">Penjual</p>
                        </div>
                        
                        <!-- Menu Items -->
                        <nav class="py-2">
                            <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="text-sm font-medium">Profil Saya</span>
                            </a>
                            
                            <a href="{{ route('seller.orders.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l3 12h10l3-8H6M10 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm9 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                </svg>
                                <span class="text-sm font-medium">Pesanan Saya</span>
                            </a>
                            
                            <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                <span class="text-sm font-medium">Wishlist</span>
                            </a>
                            
                            <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M4.5 10V8l2-2h11l2 2v2M5 21V10h14v11M9 21v-6h6v6" />
                                </svg>
                                <span class="text-sm font-medium">Dashboard Toko</span>
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
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!profileButton.contains(e.target) && !profileMenu.contains(e.target)) {
                    profileMenu.classList.add('hidden');
                }
            });
        }
    });
</script>
