<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>UlosTa — Jual Beli Ulos dengan Mudah</title>

    <!-- Tailwind CDN (for prototyping) -->
    <script src="https://cdn.tailwindcss.com"></script>

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
        
        :root {
            --brand-red-50:#FDEAEA; --brand-red-600:#AE0808; --brand-red-700:#8F0606; --brand-red-800:#6F0404;
        }
        .bg-red-600{background-color:var(--brand-red-600)!important;} .bg-red-700{background-color:var(--brand-red-700)!important;} .bg-red-800{background-color:var(--brand-red-800)!important;}
        .text-red-600{color:var(--brand-red-600)!important;}
        /* Dropdown (kept minimal) */
        .dropdown{position:relative;} .dropdown-menu{display:none;position:absolute;right:0;top:100%;margin-top:.5rem;background:#fff;border-radius:.75rem;box-shadow:0 8px 24px -4px rgba(0,0,0,.15);min-width:220px;z-index:50;}
        .dropdown:focus-within .dropdown-menu,.dropdown:hover .dropdown-menu{display:block;}
    </style>
</head>
<body class="antialiased text-gray-800 bg-gray-50">

    <!-- Navbar - Authenticated User -->
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
                    <form action="#" method="GET" class="w-full">
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
                                placeholder="Cari ulos tradisional ..."
                                class="w-full border border-gray-200 rounded-full py-2.5 pl-10 pr-12 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-300"
                                aria-label="Cari ulos"
                            />
                            <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 bg-red-600 text-white px-4 py-1.5 rounded-full hover:bg-red-700 transition">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right: User Actions -->
                <div class="flex items-center gap-4">
                    @auth
                        <!-- Cart Icon -->
                        <a href="#" class="relative p-2 rounded-full hover:bg-gray-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                            <!-- Cart badge -->
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-semibold">3</span>
                        </a>

                        <!-- Notification Icon -->
                        <a href="#" class="relative p-2 rounded-full hover:bg-gray-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4A6.5 6.5 0 0117 10V8a5 5 0 00-10 0v2c0 2-.8 3.9-2.4 5.4L3 17h5m7 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <!-- Notification badge -->
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-semibold">5</span>
                        </a>

                        <!-- User Profile Dropdown -->
                        <div class="dropdown">
                            <button class="flex items-center gap-2 p-1 rounded-full hover:bg-gray-100 transition">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}&background=AE0808&color=fff" alt="Profile" class="w-9 h-9 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="dropdown-menu">
                                <div class="py-2">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'User' }}</p>
                                        <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'user@example.com' }}</p>
                                    </div>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">Profil Saya</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">Pesanan Saya</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">Wishlist</a>
                                    <div class="border-t border-gray-100 mt-2 pt-2">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">Keluar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endauth

                    @guest
                        <!-- Guest actions: show Home, Masuk & Daftar like design -->
                        <div class="hidden sm:flex items-center gap-3">
                            <a href="{{ url('/') }}" class="text-gray-700 px-3 py-1 rounded-full hover:bg-gray-100 transition flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9.5L12 4l9 5.5V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V9.5z" />
                                </svg>
                                <span class="text-sm">Home</span>
                            </a>
                            <a href="{{ route('masuk') }}" class="text-gray-700 px-4 py-2 rounded-full hover:bg-gray-100 transition">Masuk</a>
                            <a href="{{ route('register') }}" class="bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition">Daftar</a>
                        </div>

                        <!-- For very small screens show icon-only buttons -->
                        <div class="sm:hidden flex items-center gap-2">
                            <a href="{{ route('masuk') }}" class="p-2 rounded-md hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.88 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                        </div>
                    @endguest

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-md hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Search -->
            <div id="mobile-search" class="md:hidden pb-3">
                <form action="#" method="GET">
                    <div class="relative">
                        <input name="q" type="search" placeholder="Cari ulos..." class="w-full border border-gray-200 rounded-full py-2.5 px-4 shadow-sm focus:outline-none" />
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
                                            <a href="#products" class="inline-flex items-center bg-red-600 text-white px-5 py-2 rounded-full shadow hover:bg-red-700 transition">Belanja Sekarang</a>
                                            <a href="#categories" class="inline-flex items-center border border-white/50 text-white px-5 py-2 rounded-full hover:bg-white/10 transition">Pelajari Lebih Lanjut</a>
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
                            <!-- Thumbnail image with title overlay -->
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
                            <!-- Thumbnail image with title overlay -->
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
                            </ul>

                            
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products -->
        <section id="products" class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
                <div class="flex flex-col items-center text-center">
                    <div>
                        <h2 class="text-2xl font-bold" data-aos="fade-up">Koleksi Ulos Terbaik</h2>
                        <p class="text-gray-500 mt-1" data-aos="fade-up" data-aos-delay="60">Pilihan ulos terpopuler dari pengrajin lokal.</p>
                    </div>
                </div>
               
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 items-stretch">

                    @forelse($products as $index => $product)
                        <article class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition group h-full flex flex-col" data-aos="fade-up" data-aos-delay="{{ 40 * ($index + 1) }}">
                            <a href="{{ route('produk.detail', $product['id']) }}" class="block">
                                <div class="relative">
                                    <div class="ratio-3-2">
                                        <img src="{{ $product['image'] ? asset('image/' . $product['image']) : asset('image/default-product.jpg') }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover" loading="lazy" />
                                    </div>

                                <!-- Top-left badge "Terlaris" -->
                                <div class="absolute left-3 top-3">
                                    <span class="bg-red-600 text-white text-xs rounded-full px-3 py-1 font-medium">Terlaris</span>
                                </div>

                                <!-- Favorite heart (top-right) -->
                                <button 
                                    class="absolute right-3 top-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:scale-105 transition" 
                                    aria-label="Simpan favorit"
                                    onclick="toggleWishlist(event, this)"
                                    data-name="{{ $product['name'] ?? '' }}"
                                    data-price="{{ $product['price'] ?? '' }}"
                                    data-original="{{ $product['original_price'] ?? '' }}"
                                    data-tag="{{ $product['tag'] ?? '' }}"
                                    data-image="{{ $product['image'] ?? '' }}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.8 6.6c-1.6-3-5.6-3.4-7.8-.9l-.9 1-.9-1C9 3.2 5 3.6 3.4 6.6-1 14 11.8 20.5 12 20.6c.2-.1 13-6.6 8.8-14z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="p-4 flex-1 flex flex-col">
                                <!-- Tag -->
                                <div class="mb-2">
                                    <span class="inline-block bg-amber-100 text-amber-800 text-[11px] font-medium px-3 py-1 rounded-full tracking-wide">{{ $product['tag'] ?? 'Produk' }}</span>
                                </div>
                                <!-- Title & desc -->
                                <h3 class="font-semibold text-gray-800 text-base">{{ $product['name'] }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ Str::limit($product['description'], 60) }}</p>
                            </a>

                                <!-- Price -->
                                <div class="mt-3">
                                    <div class="text-red-600 font-semibold text-base">{{ $product['formatted_price'] }}</div>
                                    @if($product['formatted_original_price'])
                                        <div class="text-xs text-gray-400 line-through mt-0.5">{{ $product['formatted_original_price'] }}</div>
                                    @endif
                                </div>

                                <div class="my-3 border-t border-dashed border-gray-200"></div>

                                <!-- CTA buttons -->
                                <div class="mt-auto grid grid-cols-2 gap-3">
                                    <form method="GET" action="{{ route('tambah.ke.keranjang') }}" class="flex">
                                        <button type="submit"
                                            data-name="{{ $product['name'] }}"
                                            data-price="{{ $product['formatted_price'] }}"
                                            class="btn-add-to-cart flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-red-700 text-white rounded-md hover:bg-red-800 transition text-sm font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                                                <circle cx="10" cy="20" r="1" />
                                                <circle cx="18" cy="20" r="1" />
                                            </svg>
                                            Keranjang
                                        </button>
                                    </form>
                                    @auth
                                    <a href="{{ route('produk.detail', $product['id']) }}" class="inline-flex items-center justify-center px-3 py-2 border border-red-700 text-red-700 rounded-md hover:bg-red-50 transition text-sm font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
                                    @else
                                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-3 py-2 border border-red-700 text-red-700 rounded-md hover:bg-red-50 transition text-sm font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
                                    @endauth
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Produk</h3>
                            <p class="text-gray-500">Produk sedang dalam proses penambahan. Silakan kembali lagi nanti.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Link: lihat semua koleksi (centered below products) -->
                @if($products->count() > 0)
                <div class="mt-8 text-center">
                    <a href="#" class="inline-block text-sm text-red-600">Lihat Semua Koleksi</a>
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

        // Toggle wishlist function
        function toggleWishlist(event, btn) {
            event.preventDefault();
            event.stopPropagation();
            
            // Check if user is authenticated
            const isAuthenticated = @json(Auth::check());
            if (!isAuthenticated) {
                window.location.href = "{{ route('masuk') }}";
                return;
            }

            // Add to wishlist animation
            btn.classList.add('scale-110');
            setTimeout(() => btn.classList.remove('scale-110'), 200);
            
            const icon = btn.querySelector('svg');
            icon.classList.toggle('fill-current');
            icon.classList.toggle('text-red-600');
            
            alert('Produk ditambahkan ke wishlist');
        }

        // Add-to-cart handler: only intercept for authenticated users.
        // Guests should follow the link (which redirects them to login) without any popup.
        const isAuthenticated = @json(Auth::check());
        document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
            btn.addEventListener('click', (e) => {
                if (!isAuthenticated) {
                    // Let the anchor navigate to the login route. Do not show any popup.
                    return;
                }

                // For authenticated users, prevent navigation and show the added-to-cart feedback.
                e.preventDefault();
                const name = btn.getAttribute('data-name') || 'Produk';
                const price = btn.getAttribute('data-price') || ''; 
                // Animation
                btn.classList.add('transform', 'scale-95');
                setTimeout(() => btn.classList.remove('scale-95'), 150);
                alert(`${name} (${price}) ditambahkan ke keranjang.`);
            });
        });
    </script>
</body>
</html>
