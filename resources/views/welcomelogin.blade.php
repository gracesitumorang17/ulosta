<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Homepage - UlosTa</title>

    <!-- Tailwind CDN (for prototyping) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS (Animate On Scroll) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <style>
        /* small helper for image aspect ratio boxes */
        .ratio-4-3 {
            padding-top: 75%;
            position: relative;
        }

        .ratio-3-2 {
            padding-top: 66.6667%;
            position: relative;
        }

        /* 578x497 (~1.163:1) ratio for category thumbnails */
        .ratio-578-497 {
            padding-top: 85.99%;
            position: relative;
        }

        /* target actual img elements inside ratio wrappers */
        .ratio-4-3>img,
        .ratio-3-2>img,
        .ratio-578-497>img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* (removed) old hover dropdown styles no longer used */

        /* Brand red overrides: map Tailwind "red-" utility classes used in this view to the provided hex */
        :root {
            --brand-red: #AE0808;
        }

        /* Backgrounds */
        .bg-red-600 {
            background-color: var(--brand-red) !important;
        }

        .bg-red-700 {
            background-color: var(--brand-red) !important;
        }

        .bg-red-800 {
            background-color: var(--brand-red) !important;
        }

        .bg-red-50 {
            background-color: var(--brand-red) !important;
        }

        /* Text */
        .text-red-600 {
            color: var(--brand-red) !important;
        }

        /* Hover variants */
        .hover\:bg-red-700:hover {
            background-color: var(--brand-red) !important;
        }

        .hover\:bg-red-800:hover {
            background-color: var(--brand-red) !important;
        }

        .hover\:bg-red-50:hover {
            background-color: var(--brand-red) !important;
        }

        /* Focus ring */
        .focus\:ring-red-300:focus {
            --tw-ring-color: var(--brand-red) !important;
            box-shadow: 0 0 0 4px rgba(174, 8, 8, 0.12) !important;
        }
    </style>

    <!--
    DEV SETUP (singkat):
    1) cd d:\laragon\www\ulosta\ulosta
    2) composer install
    3) copy .env.example .env   (Windows)  OR  cp .env.example .env
    4) php artisan key:generate
    5) edit .env -> DB_DATABASE, DB_USERNAME, DB_PASSWORD
    6) php artisan migrate
    7) php artisan storage:link
    8) npm install && npm run dev
    9) php artisan serve --host=127.0.0.1 --port=8000
    -->
</head>

<body class="antialiased text-gray-800 bg-gray-50">

    <!-- Navbar for Authenticated Users -->
    <header class="bg-white shadow-sm sticky top-0 z-40 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Left: Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-md bg-red-600 flex items-center justify-center text-white font-bold">
                            U
                        </div>
                        <span class="text-lg font-semibold">UlosTa</span>
                    </a>
                </div>

                <!-- Center: Search -->
                <div class="flex-1 hidden md:flex justify-center px-4 max-w-2xl">
                    <form action="#" method="GET" class="w-full">
                        <div class="relative">
                            <!-- search icon -->
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                                </svg>
                            </div>
                            <input name="q" type="search" placeholder="Cari ulos tradisional ..."
                                class="w-full bg-gray-100 border border-gray-200 rounded-full py-2.5 pl-10 pr-4 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-300"
                                aria-label="Cari ulos" />
                        </div>
                    </form>
                </div>

                <!-- Right: User Navigation Links -->
                <div class="flex items-center gap-6">
                    <!-- Home -->
                    <a href="{{ url('/') }}"
                        class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="text-sm font-medium">Home</span>
                    </a>

                    <!-- Wishlist -->
                    <a href="#" class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="text-sm font-medium">Wishlist</span>
                    </a>

                    <!-- Keranjang -->
                    <a href="#" class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                        <span class="text-sm font-medium">Keranjang</span>
                    </a>

                    <!-- Profil (button + popup dropdown) -->
                    <div class="relative" id="profile-dd">
                        <button id="profile-btn" type="button" aria-expanded="false"
                            class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm font-medium">Profil</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Popup menu -->
                        <div id="profile-menu"
                            class="hidden absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-xl ring-1 ring-black/5 overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">Akun Saya</p>
                                @auth
                                    <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role ?? 'Pembeli') }}</p>
                                @else
                                    <p class="text-xs text-gray-500">Pembeli</p>
                                @endauth
                            </div>
                            <nav class="py-2">
                                <a href="#"
                                    class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="text-sm">Profil saya</span>
                                </a>
                                <a href="#"
                                    class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                                    </svg>
                                    <span class="text-sm">Pesanan Saya</span>
                                </a>
                                <a href="#"
                                    class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span class="text-sm">Wishlist</span>
                                </a>
                                <div class="my-2 border-t border-gray-100"></div>
                                @auth
                                    @if (auth()->user()->role === 'seller')
                                        <a href="{{ route('seller.dashboard') }}"
                                            class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                                            </svg>
                                            <span class="text-sm">Dashboard Toko</span>
                                        </a>
                                    @else
                                        <form method="POST" action="{{ route('set.role') }}" class="px-4 py-3">
                                            @csrf
                                            <input type="hidden" name="role" value="seller">
                                            <button type="submit"
                                                class="w-full text-left flex items-center gap-3 text-gray-800 hover:bg-gray-50"
                                                style="background:none;border:0;padding:0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                                                </svg>
                                                <span class="text-sm">Dashboard Toko (Jadi Penjual)</span>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m6-10V5a3 3 0 10-6 0v1" />
                                        </svg>
                                        <span class="text-sm">Keluar</span>
                                    </button>
                                </form>
                            </nav>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-md hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Search -->
            <div id="mobile-search" class="md:hidden pb-3">
                <form action="#" method="GET">
                    <div class="relative">
                        <input name="q" type="search" placeholder="Cari ulos..."
                            class="w-full border border-gray-200 rounded-full py-2.5 px-4 shadow-sm focus:outline-none" />
                    </div>
                </form>
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
                                <img src="{{ asset('image/Background.png') }}" alt="Ulos tradisional" width="1364"
                                    height="548" class="w-full h-full object-cover object-center" />

                                <!-- subtle gradient overlay -->
                                <div class="absolute inset-0 bg-gradient-to-b from-black/10 to-black/40"></div>

                                <div class="absolute inset-0 flex items-center">
                                    <div class="pl-6 md:pl-10 lg:pl-12 max-w-2xl text-white text-left"
                                        data-aos="fade-up">
                                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight">
                                            Jual Beli Ulos dengan Mudah
                                        </h1>
                                        <p class="mt-3 text-sm sm:text-base text-white/90">
                                            Temukan koleksi Ulos asli Batak terbaik untuk berbagai kebutuhan tradisi dan
                                            upacara adat
                                        </p>

                                        <div class="mt-4 flex flex-wrap gap-3">
                                            <a href="#products"
                                                class="inline-flex items-center bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:scale-105 transform transition">Belanja
                                                Sekarang</a>
                                            <a href="#categories"
                                                class="inline-flex items-center border border-white/40 text-white px-4 py-2 rounded-lg hover:bg-white/10 transition">Pelajari
                                                Lebih Lanjut</a>
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
                    <div
                        class="inline-block bg-amber-100 text-amber-800 px-4 py-2 rounded-full text-sm font-medium mb-4">
                        Kategori Pilihan
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900" data-aos="fade-up">Temukan Ulos Anda</h2>
                    <p class="text-center text-gray-500 mt-2" data-aos="fade-up" data-aos-delay="80">Jelajahi
                        kategori ulos berdasarkan jenis dan fungsi populer.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Card: Jenis Ulos Adat -->
                    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition group relative overflow-hidden"
                        data-aos="fade-right">
                        <div class="absolute inset-0 bg-gradient-to-br from-red-50/50 to-transparent"></div>
                        <div class="relative">
                            <!-- Thumbnail image -->
                            <div class="mb-4 rounded-lg overflow-hidden">
                                <div class="ratio-578-497">
                                    <img src="{{ asset('image/jenis ulos.jpg') }}" alt="Jenis Ulos Adat"
                                        width="578" height="497" />
                                </div>
                            </div>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Jenis Ulos Adat</h3>
                                    <p class="text-sm text-gray-500">Beberapa ulos khas yang sering dicari</p>
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

                            <a href="#"
                                class="inline-flex items-center text-red-600 font-medium group-hover:underline">
                                Lihat semua jenis
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Card: Fungsi Ulos -->
                    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition group relative overflow-hidden"
                        data-aos="fade-left">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent"></div>
                        <div class="relative">
                            <!-- Thumbnail image -->
                            <div class="mb-4 rounded-lg overflow-hidden">
                                <div class="ratio-578-497">
                                    <img src="{{ asset('image/fungsiulos.jpg') }}" alt="Fungsi Ulos" width="578"
                                        height="497" />
                                </div>
                            </div>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Fungsi Ulos</h3>
                                    <p class="text-sm text-gray-500">Ulos untuk berbagai acara adat</p>
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
                            </ul>

                            <a href="#"
                                class="inline-flex items-center text-red-600 font-medium group-hover:underline">
                                Jelajahi fungsi ulos
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products -->
        <section id="products" class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">

                <!-- Filters bar (Jenis, Fungsi) -->
                <div class="mb-6 flex flex-wrap items-center gap-3" data-aos="fade-up">
                    <div class="text-sm text-gray-600">Jenis</div>
                    <div class="relative">
                        <button type="button"
                            class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-md text-sm text-gray-700 shadow-sm hover:bg-gray-50">
                            <span>Semua Jenis</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="text-sm text-gray-600 ml-2">Fungsi</div>
                    <div class="relative">
                        <button type="button"
                            class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-md text-sm text-gray-700 shadow-sm hover:bg-gray-50">
                            <span>Semua Fungsi</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col items-center text-center">
                    <div>
                        <h2 class="text-2xl font-bold" data-aos="fade-up">Koleksi Ulos Terbaik</h2>
                        <p class="text-gray-500 mt-1" data-aos="fade-up" data-aos-delay="60">Pilihan ulos terpopuler
                            dari pengrajin lokal.</p>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 items-stretch">

                    @php
                        $products = [
                            [
                                'name' => 'Ulos Ragi Hotang',
                                'tag' => 'Pernikahan',
                                'price' => 'Rp.800.000',
                                'original' => 'Rp.1.000.000',
                                'image' => 'Ulos Ragi Hotang.jpg',
                                'desc' => 'Ulos tradisional dengan motif ulos Ragi Hotang yang indah',
                            ],
                            [
                                'name' => 'Ulos Sibolang',
                                'tag' => 'Kematian',
                                'price' => 'Rp.450.000',
                                'original' => 'Rp.600.000',
                                'image' => 'Ulos Sibolang Rasta Pamontari.jpg',
                                'desc' => 'Ulos tradisional dengan motif khas',
                            ],
                            [
                                'name' => 'Ulos Mangiring',
                                'tag' => 'Syukuran',
                                'price' => 'Rp.380.000',
                                'original' => 'Rp.500.000',
                                'image' => 'Ulos Mangiring.jpg',
                                'desc' => 'Ulos tradisional dengan motif halus',
                            ],
                            [
                                'name' => 'Ulos Sadum',
                                'tag' => 'Pernikahan',
                                'price' => 'Rp.600.000',
                                'original' => 'Rp.750.000',
                                'image' => 'Ulos Sadum.jpeg',
                                'desc' => 'Tenunan berkualitas tinggi',
                            ],
                            [
                                'name' => 'Ulos Bintang Maratur',
                                'tag' => 'Pernikahan',
                                'price' => 'Rp.490.000',
                                'original' => 'Rp.650.000',
                                'image' => 'Ulos Bintang Maratur.jpg',
                                'desc' => 'Motif tradisional khas Batak',
                            ],
                            [
                                'name' => 'Ulos Ragi Hidup',
                                'tag' => 'Pernikahan',
                                'price' => 'Rp.350.000',
                                'original' => 'Rp.450.000',
                                'image' => 'Ulos Ragi Hotang.jpg',
                                'desc' => 'Kerajinan dari pengrajin lokal',
                            ],
                        ];
                    @endphp

                    @foreach ($products as $index => $p)
                        <article
                            class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transform hover:scale-[1.02] transition group h-full flex flex-col"
                            data-aos="fade-up" data-aos-delay="{{ 40 * ($index + 1) }}">
                            <div class="relative">
                                <div class="ratio-3-2">
                                    <img src="{{ asset('image/' . $p['image']) }}" alt="{{ $p['name'] }}"
                                        class="w-full h-full object-cover" />
                                </div>

                                <!-- Top-left badge "Populer" -->
                                <div class="absolute left-3 top-3">
                                    <span
                                        class="bg-red-600 text-white text-xs rounded-full px-3 py-1 font-medium">Populer</span>
                                </div>

                                <!-- Favorite heart (top-right) -->
                                <button
                                    class="absolute right-3 top-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:scale-105 transition"
                                    aria-label="Simpan favorit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M20.8 6.6c-1.6-3-5.6-3.4-7.8-.9l-.9 1-.9-1C9 3.2 5 3.6 3.4 6.6-1 14 11.8 20.5 12 20.6c.2-.1 13-6.6 8.8-14z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="p-4 flex-1 flex flex-col">
                                <!-- Tag -->
                                <div class="mb-2">
                                    <span
                                        class="inline-block bg-amber-100 text-amber-800 text-xs font-medium px-3 py-1 rounded-full">{{ $p['tag'] }}</span>
                                </div>
                                <!-- Title & desc -->
                                <h3 class="font-semibold text-gray-800 text-base">{{ $p['name'] }}</h3>
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
                                    <button data-name="{{ $p['name'] }}" data-price="{{ $p['price'] }}"
                                        class="btn-add-to-cart inline-flex items-center justify-center gap-2 px-4 bg-red-700 text-white rounded-lg hover:bg-red-800 transition-shadow shadow-sm text-sm font-medium h-11">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                                            <circle cx="10" cy="20" r="1" />
                                            <circle cx="18" cy="20" r="1" />
                                        </svg>
                                        <span>Keranjang</span>
                                    </button>
                                    <a href="#"
                                        class="inline-flex items-center justify-center px-4 border border-red-700 text-red-700 rounded-lg hover:bg-red-50 h-11 text-sm font-medium">Detail</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Link: lihat semua koleksi (centered below products) -->
                <div class="mt-8 text-center">
                    <a href="#" class="inline-block text-sm text-red-600">Lihat Semua Koleksi</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer (dark, multi-column) -->
    <footer class="bg-neutral-900 text-neutral-300 mt-16">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 bg-red-600 rounded-md flex items-center justify-center font-bold text-white text-sm">
                            U</div>
                        <div class="text-white font-semibold text-lg">UlosTa</div>
                    </div>
                    <p class="mt-4 text-sm text-neutral-400">Platform jual-beli ulos asli Batak dari pengrajin lokal
                        dengan aman dan mudah.</p>
                    <div class="mt-4 flex items-center gap-3 text-neutral-400">
                        <a href="#" aria-label="Instagram" class="hover:text-white">IG</a>
                        <a href="#" aria-label="Facebook" class="hover:text-white">FB</a>
                        <a href="#" aria-label="Twitter" class="hover:text-white">X</a>
                        <a href="#" aria-label="YouTube" class="hover:text-white">YT</a>
                    </div>
                </div>

                <!-- Tentang -->
                <div>
                    <h4 class="text-white font-semibold">Tentang Kami</h4>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Profil Perusahaan</a></li>
                        <li><a href="#" class="hover:text-white">Karir</a></li>
                        <li><a href="#" class="hover:text-white">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-white">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <!-- Kategori -->
                <div>
                    <h4 class="text-white font-semibold">Kategori</h4>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Ulos Pernikahan</a></li>
                        <li><a href="#" class="hover:text-white">Ulos Kelahiran</a></li>
                        <li><a href="#" class="hover:text-white">Ulos Kematian</a></li>
                        <li><a href="#" class="hover:text-white">Ulos Lainnya</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-white font-semibold">Hubungi Kami</h4>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li>Email: support@ulosta.id</li>
                        <li>Telepon: +62 812-3456-7890</li>
                        <li>Alamat: Medan, Sumatera Utara</li>
                    </ul>
                </div>
            </div>

            <div
                class="mt-10 border-t border-neutral-800 pt-6 text-sm text-neutral-400 flex flex-col sm:flex-row items-center justify-between">
                <p>© <span id="year"></span> UlosTa. All rights reserved.</p>
                <div class="mt-2 sm:mt-0">Indonesia</div>
            </div>
        </div>
    </footer>

    @include('partials.role_selector')

    <!-- Scripts -->
    <script>
        // AOS init
        AOS.init({
            duration: 700,
            once: true
        });

        // Add-to-cart handler for authenticated users
        document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const name = btn.getAttribute('data-name') || 'Produk';
                const price = btn.getAttribute('data-price') || '';

                // Animation
                btn.classList.add('transform', 'scale-95');
                setTimeout(() => btn.classList.remove('scale-95'), 150);

                // Show success feedback
                alert(`${name} (${price}) berhasil ditambahkan ke keranjang!`);
            });
        });

        // (removed) profile dropdown script — navbar uses simple profile link to match design
        // Profile dropdown: toggle on click, close on outside click or Esc
        (function() {
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
                if (menu.classList.contains('hidden')) openMenu();
                else closeMenu();
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
        if (yearEl) {
            yearEl.textContent = new Date().getFullYear();
        }
    </script>
</body>

</html>
