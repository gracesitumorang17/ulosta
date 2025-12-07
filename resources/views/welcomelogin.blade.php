<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Homepage - UlosTa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Tailwind CDN (for prototyping) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand': '#dc2626'
                    }
                }
            }
        }
    </script>

    <!-- AOS (Animate On Scroll) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <style>
    /* small helper for image aspect ratio boxes */
    .ratio-4-3 { padding-top: 75%; position: relative; }
    .ratio-3-2 { padding-top: 66.6667%; position: relative; }
    /* 578x497 (~1.163:1) ratio for category thumbnails */
    .ratio-578-497 { padding-top: 85.99%; position: relative; }
    /* target actual img elements inside ratio wrappers */
    .ratio-4-3 > img, .ratio-3-2 > img, .ratio-578-497 > img { position: absolute; top:0; left:0; width:100%; height:100%; object-fit:cover; }
        
        /* Brand color system (kept lightweight, no Tailwind config) */
        :root {
            --brand-red-50:  #FDEAEA;  /* very light tint for hovers */
            --brand-red-300: #EFA3A3;  /* ring color */
            --brand-red-600: #AE0808;  /* primary */
            --brand-red-700: #8F0606;  /* hover */
            --brand-red-800: #6F0404;  /* active */
        }

        /* Map only the shades used in this page for consistent branding */
        .bg-red-600 { background-color: var(--brand-red-600) !important; }
        .bg-red-700 { background-color: var(--brand-red-700) !important; }
        .bg-red-800 { background-color: var(--brand-red-800) !important; }
        .bg-red-50  { background-color: var(--brand-red-50) !important; }

        .text-red-600 { color: var(--brand-red-600) !important; }
        .border-red-700 { border-color: var(--brand-red-700) !important; }
        .text-red-700 { color: var(--brand-red-700) !important; }

        .hover\:bg-red-700:hover { background-color: var(--brand-red-700) !important; }
        .hover\:bg-red-800:hover { background-color: var(--brand-red-800) !important; }
        .hover\:bg-red-50:hover  { background-color: var(--brand-red-50) !important; }

        /* Focus ring */
        .focus\:ring-red-300:focus { --tw-ring-color: var(--brand-red-300) !important; box-shadow: 0 0 0 4px rgba(239,163,163,0.6) !important; }
        
        /* Wishlist heart animation */
        .wishlist-btn {
            transition: all 0.3s ease;
        }
        
        .wishlist-btn:hover {
            transform: scale(1.1);
        }
        
        .wishlist-btn.active svg {
            fill: #dc2626;
            stroke: #dc2626;
        }
        
        .wishlist-btn.active {
            animation: heartBeat 0.3s ease-in-out;
        }
        
        @keyframes heartBeat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.3); }
            50% { transform: scale(1.1); }
            75% { transform: scale(1.2); }
        }
    </style>
</head>
<body class="antialiased text-gray-800 bg-white">

    <!-- Navbar for Authenticated Users -->
    <header class="bg-white shadow-sm sticky top-0 z-40 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Left: Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
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
                            <!-- search icon -->
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                                </svg>
                            </div>
                            <input
                                name="q"
                                type="search"
                                value="{{ $search ?? '' }}"
                                placeholder="Cari ulos tradisional ..."
                                class="w-full bg-gray-100 border border-gray-200 rounded-full py-2.5 pl-10 pr-12 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-300"
                                aria-label="Cari ulos"
                            />
                            @if($search ?? false)
                            <a href="{{ route('homepage') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" title="Hapus pencarian">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Right: User Navigation Links -->
                <div class="flex items-center gap-6">
                    <!-- Home -->
                    <a href="{{ url('/') }}" class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="text-sm font-medium">Home</span>
                    </a>

                    <!-- Wishlist/Suka -->
                    <a href="{{ route('wishlist.index') }}" class="relative flex items-center gap-2 text-gray-800 hover:text-red-600 transition">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            @if($wishlistCount > 0)
                            <span id="wishlist-badge" class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                                {{ $wishlistCount > 99 ? '99+' : $wishlistCount }}
                            </span>
                            @else
                            <span id="wishlist-badge" class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full hidden">
                                0
                            </span>
                            @endif
                        </div>
                        <span class="text-sm font-medium">Wishlist</span>
                    </a>

                    <!-- Keranjang -->
                    <a href="{{ route('keranjang') }}" class="relative flex items-center gap-2 text-gray-800 hover:text-red-600 transition" id="cart-link">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                            <!-- Cart Badge -->
                            @if($cartCount > 0)
                            <span id="cart-badge" class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                            @else
                            <span id="cart-badge" class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full hidden">
                                0
                            </span>
                            @endif
                        </div>
                        <span class="text-sm font-medium">Keranjang</span>
                    </a>

                    <!-- Profil (button + popup dropdown) -->
                    <div class="relative" id="profile-dd">
                        <button id="profile-btn" type="button" aria-expanded="false" class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm font-medium">Profil</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Popup menu -->
                        <div id="profile-menu" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-xl ring-1 ring-black/5 overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">Akun Saya</p>
                                <p class="text-xs text-gray-500">Pembeli</p>
                            </div>
                            <nav class="py-2">
                                <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="text-sm">Profil saya</span>
                                </a>
                                <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span class="text-sm">Wishlist Saya</span>
                                </a>
                                <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                                    </svg>
                                    <span class="text-sm">Pesanan Saya</span>
                                </a>
                                <div class="my-2 border-t border-gray-100"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m6-10V5a3 3 0 10-6 0v1" />
                                        </svg>
                                        <span class="text-sm">Keluar</span>
                                    </button>
                                </form>
                            </nav>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-md hover:bg-gray-100" aria-expanded="false" aria-controls="mobile-menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Search -->
            <div id="mobile-search" class="md:hidden pb-3">
                <form action="{{ route('homepage') }}" method="GET">
                    <div class="relative">
                        <input 
                            name="q" 
                            type="search" 
                            value="{{ $search ?? '' }}"
                            placeholder="Cari ulos..." 
                            class="w-full border border-gray-200 rounded-full py-2.5 px-4 pr-10 shadow-sm focus:outline-none" 
                        />
                        @if($search ?? false)
                        <a href="{{ route('homepage') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" title="Hapus pencarian">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Mobile Menu Panel -->
            <div id="mobile-menu" class="md:hidden hidden pb-4">
                <nav class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="text-sm font-medium">Home</span>
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="relative flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            @if($wishlistCount > 0)
                            <span id="mobile-wishlist-badge" class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                                {{ $wishlistCount > 99 ? '99+' : $wishlistCount }}
                            </span>
                            @else
                            <span id="mobile-wishlist-badge" class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full hidden">
                                0
                            </span>
                            @endif
                        </div>
                        <span class="text-sm font-medium">Wishlist</span>
                    </a>
                    <a href="{{ route('keranjang') }}" class="relative flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50" id="mobile-cart-link">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                            <!-- Mobile Cart Badge -->
                            @if($cartCount > 0)
                            <span id="mobile-cart-badge" class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                            @else
                            <span id="mobile-cart-badge" class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full hidden">
                                0
                            </span>
                            @endif
                        </div>
                        <span class="text-sm font-medium">Keranjang</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m6-10V5a3 3 0 10-6 0v1" />
                            </svg>
                            <span class="text-sm">Keluar</span>
                        </button>
                    </form>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <main>
        <section class="relative">
            <div class="bg-white">
                <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
                    <!-- constrained hero banner to align with product grid -->
                    <div class="py-6">
                        <div class="bg-white rounded-lg overflow-hidden shadow-sm">
                            <div class="w-[1364px] h-[548px] max-w-full mx-auto relative">
                                <img
                                    src="{{ asset('image/Background.png') }}"
                                    alt="Ulos tradisional"
                                    width="1364"
                                    height="548"
                                    class="w-full h-full object-cover object-center"
                                />

                                <!-- subtle gradient overlay -->
                                <div class="absolute inset-0 bg-gradient-to-b from-black/10 to-black/40"></div>

                                <div class="absolute inset-0 flex items-center">
                                    <div class="pl-6 md:pl-10 lg:pl-12 max-w-2xl text-white text-left" data-aos="fade-up">
                                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight">
                                            Jual Beli Ulos dengan Mudah
                                        </h1>
                                        <p class="mt-3 text-sm sm:text-base text-white/90">
                                            Temukan koleksi Ulos asli Batak terbaik untuk berbagai kebutuhan tradisi dan upacara adat
                                        </p>

                                        <div class="mt-4 flex flex-wrap gap-3">
                                            <a href="#products" class="inline-flex items-center bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:scale-105 transform transition">Belanja Sekarang</a>
                                            <a href="#categories" class="inline-flex items-center border border-white/40 text-white px-4 py-2 rounded-lg hover:bg-white/10 transition">Pelajari Lebih Lanjut</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section id="categories" class="py-16">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <div class="inline-block bg-amber-100 text-amber-800 px-4 py-2 rounded-full text-sm font-medium mb-4">
                        Kategori Pilihan
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900" data-aos="fade-up">Temukan Ulos Anda</h2>
                    <p class="text-center text-gray-500 mt-2" data-aos="fade-up" data-aos-delay="80">Jelajahi kategori ulos berdasarkan jenis dan fungsi populer.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Card: Jenis Ulos Adat -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition group relative overflow-hidden" data-aos="fade-right">
                        <div class="relative">
                            <div class="mb-4 rounded-xl overflow-hidden relative">
                                <div class="ratio-3-2">
                                    <img src="{{ asset('image/jenis ulos.jpg') }}" alt="Jenis Ulos Adat" class="absolute inset-0 w-full h-full object-cover" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
                                    <div class="absolute left-4 bottom-4">
                                        <h3 class="text-white text-xl font-semibold drop-shadow">Jenis Ulos Adat</h3>
                                    </div>
                                </div>
                            </div>
                            <ul class="space-y-3 text-sm mb-6">
                                <li class="flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full bg-red-600"></span>
                                    Ulos Ragidup
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full bg-yellow-500"></span>
                                    Ulos Ragi Hotang
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full bg-indigo-500"></span>
                                    Ulos Sibolang
                                </li>
                                                    </ul>
                                                    
                        </div>
                    </div>

                    <!-- Card: Fungsi Ulos -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition group relative overflow-hidden" data-aos="fade-left">
                        <div class="relative">
                            <div class="mb-4 rounded-xl overflow-hidden relative">
                                <div class="ratio-3-2">
                                    <img src="{{ asset('image/fungsiulos.jpg') }}" alt="Fungsi Ulos" class="absolute inset-0 w-full h-full object-cover" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
                                    <div class="absolute left-4 bottom-4">
                                        <h3 class="text-white text-xl font-semibold drop-shadow">Fungsi Ulos</h3>
                                    </div>
                                </div>
                            </div>
                            <ul class="space-y-3 text-sm mb-6">
                                <li class="flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full bg-pink-500"></span>
                                    Pernikahan
                                </li>
                                <li class="flex items-center gap-2">
                                       <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                                    Kelahiran
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full bg-gray-500"></span>
                                    Kematian
                                </li>
                                                    
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products -->
        <section id="products" class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
                <!-- Section Header with Filters -->
                <div class="text-center mb-8">
                    <div class="inline-block bg-amber-100 text-amber-800 px-4 py-2 rounded-full text-sm font-medium mb-4">
                        Kategori Pilihan
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900" data-aos="fade-up">Temukan Ulos Anda</h2>
                    <p class="text-gray-500 mt-2" data-aos="fade-up" data-aos-delay="60">
                        @if($search ?? false)
                            Hasil pencarian untuk: <span class="font-semibold text-red-600">"{{ $search }}"</span>
                            @if(count($products) > 0)
                                ({{ count($products) }} produk ditemukan)
                            @endif
                        @else
                            Jelajahi koleksi Ulos berdasarkan jenis dan fungsi tradisi
                        @endif
                    </p>
                </div>

                <!-- Filter Section -->
                <form id="filter-form" method="GET" action="{{ route('homepage') }}" class="flex flex-wrap items-center justify-center gap-6 mb-8" data-aos="fade-up" data-aos-delay="100">
                    <!-- Hidden search input to preserve search query -->
                    @if($search ?? false)
                    <input type="hidden" name="q" value="{{ $search }}">
                    @endif

                    <!-- Jenis Filter -->
                    <div class="flex items-center gap-3">
                        <label class="text-sm font-medium text-gray-700">Jenis :</label>
                        <div class="relative">
                            <select name="jenis" id="jenis-filter" onchange="document.getElementById('filter-form').submit()" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-600 cursor-pointer">
                                <option value="">Semua Jenis</option>
                                <option value="Ragidup" {{ ($jenisFilter ?? '') == 'Ragidup' ? 'selected' : '' }}>Ulos Ragidup</option>
                                <option value="Ragi Hotang" {{ ($jenisFilter ?? '') == 'Ragi Hotang' ? 'selected' : '' }}>Ulos Ragi Hotang</option>
                                <option value="Sibolang" {{ ($jenisFilter ?? '') == 'Sibolang' ? 'selected' : '' }}>Ulos Sibolang</option>
                                <option value="Bintang Maratur" {{ ($jenisFilter ?? '') == 'Bintang Maratur' ? 'selected' : '' }}>Ulos Bintang Maratur</option>
                                <option value="Sadum" {{ ($jenisFilter ?? '') == 'Sadum' ? 'selected' : '' }}>Ulos Sadum</option>
                                <option value="Mangiring" {{ ($jenisFilter ?? '') == 'Mangiring' ? 'selected' : '' }}>Ulos Mangiring</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Fungsi Filter -->
                    <div class="flex items-center gap-3">
                        <label class="text-sm font-medium text-gray-700">Fungsi :</label>
                        <div class="relative">
                            <select name="fungsi" id="fungsi-filter" onchange="document.getElementById('filter-form').submit()" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-600 cursor-pointer">
                                <option value="">Semua Fungsi</option>
                                <option value="Pernikahan" {{ ($fungsiFilter ?? '') == 'Pernikahan' ? 'selected' : '' }}>Pernikahan</option>
                                <option value="Kelahiran" {{ ($fungsiFilter ?? '') == 'Kelahiran' ? 'selected' : '' }}>Kelahiran</option>
                                <option value="Kematian" {{ ($fungsiFilter ?? '') == 'Kematian' ? 'selected' : '' }}>Kematian</option>
                                <option value="Syukuran" {{ ($fungsiFilter ?? '') == 'Syukuran' ? 'selected' : '' }}>Syukuran</option>
                                <option value="Serbaguna" {{ ($fungsiFilter ?? '') == 'Serbaguna' ? 'selected' : '' }}>Serbaguna</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Reset Button -->
                    @if(($jenisFilter ?? false) || ($fungsiFilter ?? false))
                    <a href="{{ route('homepage') }}{{ ($search ?? false) ? '?q=' . $search : '' }}" class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reset Filter
                    </a>
                    @endif
                </form>
               
                @if(count($products) > 0)
                <div id="product-grid" class="mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 items-stretch">

                    @foreach($products as $index => $p)
                        <article class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transform hover:scale-[1.02] transition group h-full flex flex-col" 
                                 data-aos="fade-up" 
                                 data-aos-delay="{{ 40 * ($index + 1) }}">
                            <div class="relative">
                                <a href="{{ route('produk.detail', $p['id']) }}" class="block">
                                    <div class="aspect-[4/3] relative">
                                        <img src="{{ asset('image/' . $p['image']) }}" alt="{{ $p['name'] }}" class="absolute inset-0 w-full h-full object-cover" />
                                    </div>
                                </a>

                                <!-- Top-left badge "Terlaris" -->
                                <div class="absolute left-3 top-3">
                                    <span class="bg-red-600 text-white text-xs font-semibold px-3 py-1 rounded">Terlaris</span>
                                </div>
                                
                                <!-- Top-right Wishlist button -->
                                <div class="absolute right-3 top-3">
                                    <button 
                                        class="wishlist-btn w-9 h-9 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center shadow-md hover:bg-white"
                                        data-product-id="{{ $index }}"
                                        aria-label="Tambah ke wishlist"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        

                            <div class="p-4 flex-1 flex flex-col">
                                <!-- Category (Fungsi Ulos) -->
                                @if(!empty($p['category']))
                                <div class="mb-2">
                                    <span class="inline-block bg-yellow-100 text-gray-800 text-xs font-semibold px-3 py-1.5 rounded">{{ $p['category'] }}</span>
                                </div>
                                @endif
                                <!-- Title & desc -->
                                <a href="{{ route('produk.detail', $p['id']) }}" class="hover:text-red-600 transition-colors">
                                    <h3 class="font-semibold text-gray-800 text-base">{{ $p['name'] }}</h3>
                                </a>
                                <p class="text-sm text-gray-500 mt-1">{{ $p['desc'] }}</p>

                                <!-- Price -->
                                <div class="mt-3">
                                    <div class="text-red-600 font-bold text-lg">{{ $p['price'] }}</div>
                                    <div class="text-sm text-gray-400 line-through mt-0.5">{{ $p['original'] }}</div>
                                </div>

                                <!-- thin divider to separate price and CTA -->
                                <div class="my-4 border-t border-gray-200"></div>

                                <!-- CTA buttons -->
                                <div class="mt-auto grid grid-cols-2 gap-3">
                                    <button
                                        data-name="{{ $p['name'] }}"
                                        data-price="{{ $p['price'] }}"
                                        data-original="{{ $p['original'] }}"
                                        data-tag="{{ $p['tag'] }}"
                                        data-image="{{ $p['image'] }}"
                                        class="btn-add-to-cart inline-flex items-center justify-center gap-2 px-4 bg-red-700 text-white rounded-lg hover:bg-red-800 transition-shadow shadow-sm text-sm font-medium h-11"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                                        </svg>
                                        <span>Keranjang</span>
                                    </button>
                                    <a href="{{ route('produk.detail', $p['id']) }}" class="inline-flex items-center justify-center gap-1 px-4 border border-red-700 text-red-700 rounded-lg hover:bg-red-50 h-11 text-sm font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if(!($search ?? false))
                <!-- Link: lihat semua koleksi (centered below products) -->
                <div class="mt-8 text-center">
                    <a href="#" class="inline-block text-sm text-red-600">Lihat Semua Koleksi</a>
                </div>
                @endif

                @else
                <!-- Empty State - No Products Found -->
                <div class="mt-12 text-center py-16">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gray-100 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-gray-500 mb-6">Maaf, tidak ada produk yang cocok dengan pencarian "{{ $search }}"</p>
                    <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Lihat Semua Produk</span>
                    </a>
                </div>
                @endif
            </div>
        </section>
    </main>

      <!-- Footer -->
    <footer class="bg-gray-900 text-gray-200">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-red-600 rounded-md flex items-center justify-center font-bold">U</div>
                        <div>
                            <h4 class="font-semibold">UlosTa</h4>
                            <p class="text-sm text-gray-400">Platform Jual Beli Ulos Terpercaya</p>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-6">
                    <div>
                        <h5 class="text-gray-300 font-semibold">Tautan Cepat</h5>
                        <ul class="mt-3 space-y-2 text-sm text-gray-400">
                            <li><a href="#" class="hover:underline">Tentang Kami</a></li>
                            <li><a href="#" class="hover:underline">Kontak</a></li>
                            <li><a href="#" class="hover:underline">Bantuan</a></li>
                        </ul>
                    </div>

                    <div>
                        <h5 class="text-gray-300 font-semibold">Bantuan</h5>
                        <ul class="mt-3 space-y-2 text-sm text-gray-400">
                            <li><a href="#" class="hover:underline">Pengiriman</a></li>
                            <li><a href="#" class="hover:underline">Pengembalian</a></li>
                            <li><a href="#" class="hover:underline">FAQ</a></li>
                        </ul>
                    </div>

                    <div>
                        <h5 class="text-gray-300 font-semibold">Kontak</h5>
                        <p class="mt-3 text-sm text-gray-400">ppwproject@gmail.com</p>
                        <p class="mt-1 text-sm text-gray-400">+62 812 3456 7890</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 py-4 text-center text-sm text-gray-500 mt-8">
                © {{ date('Y') }} UlosTa. Semua hak dilindungi.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // AOS init
        AOS.init({ duration: 700, once: true });

        // Toast element factory
        function ensureToast() {
            let toast = document.getElementById('toast-add-cart');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toast-add-cart';
                toast.className = 'fixed top-5 right-5 z-50 hidden';
                toast.innerHTML = `
                    <div class="bg-white/95 backdrop-blur border border-gray-200 shadow-xl rounded-lg px-4 py-3 flex items-start gap-3 min-w-[280px]">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-green-100 text-green-700">
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' viewBox='0 0 20 20' fill='currentColor'>
                                <path fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.172l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd' />
                            </svg>
                        </div>
                        <div class="text-sm">
                            <div class="font-semibold text-gray-800">Berhasil ditambahkan</div>
                            <div class="text-gray-600" id="toast-text">Produk masuk ke keranjang.</div>
                        </div>
                        <button class="ml-2 text-gray-400 hover:text-gray-600" aria-label="Tutup" onclick="document.getElementById('toast-add-cart').classList.add('hidden')">×</button>
                    </div>`;
                document.body.appendChild(toast);
            }
            return toast;
        }

        function showToast(message) {
            const toast = ensureToast();
            toast.querySelector('#toast-text').textContent = message;
            toast.classList.remove('hidden');
            clearTimeout(window.__toastTimer);
            window.__toastTimer = setTimeout(() => toast.classList.add('hidden'), 2000);
        }

        // Wishlist functionality - using database instead of localStorage
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            btn.addEventListener('click', async function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Get product data from closest article
                const article = this.closest('article');
                const productName = article.querySelector('.btn-add-to-cart').dataset.name;
                const productPrice = article.querySelector('.btn-add-to-cart').dataset.price;
                const productOriginal = article.querySelector('.btn-add-to-cart').dataset.original;
                const productTag = article.querySelector('.btn-add-to-cart').dataset.tag;
                const productImage = article.querySelector('.btn-add-to-cart').dataset.image;
                
                // Add visual feedback
                this.classList.add('transform', 'scale-95');
                setTimeout(() => this.classList.remove('scale-95'), 120);
                
                try {
                    const res = await fetch('{{ route('wishlist.add') }}', {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json', 
                            'X-CSRF-TOKEN': csrf, 
                            'Accept': 'application/json' 
                        },
                        body: JSON.stringify({ 
                            name: productName,
                            price: productPrice,
                            original: productOriginal,
                            tag: productTag,
                            image: productImage
                        })
                    });
                    
                    const data = await res.json();
                    
                    if (data.success) {
                        // Toggle active state based on action
                        if (data.action === 'added') {
                            this.classList.add('active');
                            showToast(data.message || 'Ditambahkan ke wishlist');
                        } else {
                            this.classList.remove('active');
                            showToast(data.message || 'Dihapus dari wishlist');
                        }
                        
                        // Update wishlist badge
                        updateWishlistBadge(data.count);
                    } else {
                        showToast('Gagal memperbarui wishlist');
                    }
                } catch (e) {
                    console.error('Error updating wishlist:', e);
                    showToast('Terjadi kesalahan');
                }
            });
        });

        // Add-to-cart handler (persist via AJAX + toast)
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
            btn.addEventListener('click', async () => {
                const name = btn.dataset.name;
                const price = btn.dataset.price;
                const original = btn.dataset.original;
                const tag = btn.dataset.tag;
                const image = btn.dataset.image;
                btn.classList.add('transform','scale-95');
                setTimeout(()=>btn.classList.remove('scale-95'),120);
                try {
                    const res = await fetch('{{ route('cart.add') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                        body: JSON.stringify({ name, price, original, tag, image })
                    });
                    const data = await res.json();
                    if (data.success) {
                        showToast(`${name} berhasil ditambahkan ke keranjang!`);
                        
                        // Update cart badges
                        updateCartBadge(data.count);
                    } else {
                        showToast('Gagal menambahkan ke keranjang');
                    }
                } catch (e) {
                    showToast('Terjadi kesalahan');
                }
            });
        });

        // Profile dropdown: toggle on click, close on outside click or Esc
        (function(){
            const btn = document.getElementById('profile-btn');
            const menu = document.getElementById('profile-menu');
            if (!btn || !menu) return;

            const closeMenu = () => {
                menu.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');
            };
            const openMenu = () => {
                menu.classList.remove('hidden');
                btn.setAttribute('aria-expanded', 'true');
            };

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (menu.classList.contains('hidden')) openMenu(); else closeMenu();
            });

            document.addEventListener('click', () => {
                if (!menu.classList.contains('hidden')) closeMenu();
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeMenu();
            });
        })();

        // Footer year
        const yearEl = document.getElementById('year');
        if (yearEl) { yearEl.textContent = new Date().getFullYear(); }
        
        // Mobile menu toggle
        (function(){
            const btn = document.getElementById('mobile-menu-btn');
            const panel = document.getElementById('mobile-menu');
            if (!btn || !panel) return;
            const toggle = () => {
                const isHidden = panel.classList.contains('hidden');
                panel.classList.toggle('hidden');
                btn.setAttribute('aria-expanded', String(isHidden));
            };
            btn.addEventListener('click', (e)=>{ e.stopPropagation(); toggle(); });
            document.addEventListener('click', (e)=>{
                if (!panel.classList.contains('hidden')) {
                    // close if clicking outside panel & button
                    if (!panel.contains(e.target) && !btn.contains(e.target)) {
                        panel.classList.add('hidden');
                        btn.setAttribute('aria-expanded','false');
                    }
                }
            });
            document.addEventListener('keydown', (e)=>{
                if (e.key === 'Escape' && !panel.classList.contains('hidden')) {
                    panel.classList.add('hidden');
                    btn.setAttribute('aria-expanded','false');
                }
            });
        })();

        // Update cart badge function
        function updateCartBadge(count) {
            const badge = document.getElementById('cart-badge');
            const mobileBadge = document.getElementById('mobile-cart-badge');
            
            if (count > 0) {
                const displayCount = count > 99 ? '99+' : count;
                
                if (badge) {
                    badge.textContent = displayCount;
                    badge.classList.remove('hidden');
                }
                
                if (mobileBadge) {
                    mobileBadge.textContent = displayCount;
                    mobileBadge.classList.remove('hidden');
                }
            } else {
                if (badge) {
                    badge.classList.add('hidden');
                }
                if (mobileBadge) {
                    mobileBadge.classList.add('hidden');
                }
            }
        }

        // Update wishlist badge function
        function updateWishlistBadge(count) {
            const badge = document.getElementById('wishlist-badge');
            const mobileBadge = document.getElementById('mobile-wishlist-badge');
            
            if (count > 0) {
                const displayCount = count > 99 ? '99+' : count;
                
                if (badge) {
                    badge.textContent = displayCount;
                    badge.classList.remove('hidden');
                }
                
                if (mobileBadge) {
                    mobileBadge.textContent = displayCount;
                    mobileBadge.classList.remove('hidden');
                }
            } else {
                if (badge) {
                    badge.classList.add('hidden');
                }
                if (mobileBadge) {
                    mobileBadge.classList.add('hidden');
                }
            }
        }
    </script>
</body>
</html>