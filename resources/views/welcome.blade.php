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
        .ratio-4-3 > image { position: absolute; top:0; left:0; width:100%; height:100%; object-fit:cover; }
        
        /* Dropdown menu styles */
        .dropdown { position: relative; }
        .dropdown-menu { 
            display: none; 
            position: absolute; 
            right: 0; 
            top: 100%; 
            margin-top: 0.5rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            min-width: 200px;
            z-index: 50;
        }
        .dropdown:hover .dropdown-menu { display: block; }
    </style>
</head>
<body class="antialiased text-gray-800 bg-gray-50">

    <!-- Navbar - Authenticated User -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
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
                    <form action="#" method="GET" class="w-full">
                        <div class="relative">
                            <input
                                name="q"
                                type="search"
                                placeholder="Cari ulos, jenis, atau fungsi..."
                                class="w-full border border-gray-200 rounded-full py-2.5 px-4 pr-12 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-300"
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
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}&background=b81a1a&color=fff" alt="Profile" class="w-9 h-9 rounded-full">
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
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <span class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil Saya
                                    </span>
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <span class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Pesanan Saya
                                    </span>
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <span class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        Wishlist
                                    </span>
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <span class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Pengaturan
                                    </span>
                                </a>
                                <div class="border-t border-gray-100 mt-2 pt-2">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                            <span class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Keluar
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

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
            <div class="h-[56vh] md:h-[72vh] bg-gray-800">
                <img
                    src="{{ asset('image/Background.png') }}"
                    alt="Ulos tradisional"
                    class="w-full h-full object-cover opacity-90"
                />
                <div class="absolute inset-0 bg-black/35"></div>

                <div class="absolute inset-0 flex items-center">
                    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 w-full">
                        <div class="max-w-2xl text-white" data-aos="fade-up">
                            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight">
                                Jual Beli Ulos dengan Mudah
                            </h1>
                            <p class="mt-4 text-lg sm:text-xl text-white/90">
                                Temukan ulos tradisional Batak berkualitas dari pengrajin lokal. Mudah, aman, dan terpercaya.
                            </p>

                            <div class="mt-6 flex flex-wrap gap-3">
                                <a href="#products" class="inline-flex items-center bg-red-600 text-white px-5 py-3 rounded-lg shadow hover:scale-105 transform transition">Belanja Sekarang</a>
                                <a href="#categories" class="inline-flex items-center border border-white/40 text-white px-5 py-3 rounded-lg hover:bg-white/10 transition">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories -->
        <section id="categories" class="py-16">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
                <h2 class="text-center text-2xl sm:text-3xl font-semibold" data-aos="fade-up">Temukan Ulos Anda</h2>
                <p class="text-center text-gray-500 mt-2 mb-8" data-aos="fade-up" data-aos-delay="80">Jelajahi kategori ulos berdasarkan jenis dan fungsi populer.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Card: Jenis Ulos Adat -->
                    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition group" data-aos="fade-right">
                        <div class="flex items-start gap-4">
                            <div>
                                <h3 class="text-lg font-semibold">Jenis Ulos Adat</h3>
                                <p class="text-sm text-gray-500 mt-1">Beberapa ulos khas yang sering dicari.</p>

                                <ul class="mt-3 space-y-2 text-sm">
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

                                <div class="mt-4">
                                    <a href="#" class="text-red-600 font-medium group-hover:underline">Lihat semua jenis</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Fungsi Ulos -->
                    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition group" data-aos="fade-left">
                        <div class="flex items-start gap-4">
                            <div>
                                <h3 class="text-lg font-semibold">Fungsi Ulos</h3>
                                <p class="text-sm text-gray-500 mt-1">Ulos yang biasa dipakai pada berbagai acara adat.</p>

                                <ul class="mt-3 space-y-2 text-sm">
                                    <li>Pernikahan</li>
                                    <li>Kelahiran</li>
                                    <li>Kematian</li>
                                </ul>

                                <div class="mt-4">
                                    <a href="#" class="text-red-600 font-medium group-hover:underline">Jelajahi fungsi ulos</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products -->
        <section id="products" class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold" data-aos="fade-up">Koleksi Ulos Terbaik</h2>
                        <p class="text-gray-500 mt-1" data-aos="fade-up" data-aos-delay="60">Pilihan ulos terpopuler dari pengrajin lokal.</p>
                    </div>
                    
                    <div>
                        <a href="#" class="text-sm text-red-600">Lihat Semua Koleksi</a>
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
                                'desc' => 'Ulos tradisional dengan motif ulos Ragi Hotang yang indah'
                            ],
                            ['name' => 'Ulos Sibolang', 'tag' => 'Kematian', 'price' => 'Rp.450.000', 'original' => 'Rp.600.000', 'image' => 'Ulos Sibolang Rasta Pamontari.jpg', 'desc' => 'Ulos tradisional dengan motif khas'],
                            ['name' => 'Ulos Mangiring', 'tag' => 'Syukuran', 'price' => 'Rp.380.000', 'original' => 'Rp.500.000', 'image' => 'Ulos Mangiring.jpg', 'desc' => 'Ulos tradisional dengan motif halus'],
                            ['name' => 'Ulos Sadum', 'tag' => 'Pernikahan', 'price' => 'Rp.600.000', 'original' => 'Rp.750.000', 'image' => 'Ulos Sadum.jpeg', 'desc' => 'Tenunan berkualitas tinggi'],
                            ['name' => 'Ulos Bintang Maratur', 'tag' => 'Pernikahan', 'price' => 'Rp.490.000', 'original' => 'Rp.650.000', 'image' => 'Ulos Bintang Maratur.jpg', 'desc' => 'Motif tradisional khas Batak'],
                            ['name' => 'Ulos Ragi Hidup', 'tag' => 'Pernikahan', 'price' => 'Rp.350.000', 'original' => 'Rp.450.000', 'image' => 'Ulos Ragi Hotang.jpg', 'desc' => 'Kerajinan dari pengrajin lokal'],
                        ];
                    @endphp

                    @foreach($products as $index => $p)
                        <article class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transform hover:scale-[1.02] transition group" data-aos="fade-up" data-aos-delay="{{ 40 * ($index + 1) }}">
                            <div class="relative">
                                <div class="ratio-3-2">
                                    <img src="{{ asset('image/' . $p['image']) }}" alt="{{ $p['name'] }}" class="w-full h-full object-cover" />
                                </div>

                                <!-- Top-left badge "Terlaris" -->
                                <div class="absolute left-3 top-3">
                                    <span class="bg-red-600 text-white text-xs rounded-full px-3 py-1 font-medium">Terlaris</span>
                                </div>

                                <!-- Favorite heart (top-right) -->
                                <button class="absolute right-3 top-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:scale-105 transition" aria-label="Simpan favorit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.8 6.6c-1.6-3-5.6-3.4-7.8-.9l-.9 1-.9-1C9 3.2 5 3.6 3.4 6.6-1 14 11.8 20.5 12 20.6c.2-.1 13-6.6 8.8-14z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="p-4">
                                <!-- Tag -->
                                <div class="mb-2">
                                    <span class="inline-block bg-amber-100 text-amber-800 text-xs font-medium px-3 py-1 rounded-full">{{ $p['tag'] }}</span>
                                </div>
                                <!-- Title & desc -->
                                <h3 class="font-semibold text-gray-800 text-base">{{ $p['name'] }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $p['desc'] }}</p>

                                <!-- Price -->
                                <div class="mt-3 flex items-end justify-between">
                                    <div>
                                        <div class="text-red-600 font-bold text-lg">{{ $p['price'] }}</div>
                                        <div class="text-sm text-gray-400 line-through mt-0.5">{{ $p['original'] }}</div>
                                    </div>
                                </div>

                                <hr class="my-4 border-gray-200">

                                <!-- Add to cart button (full width) -->
                                <div>
                                    <button
                                        data-name="{{ $p['name'] }}"
                                        data-price="{{ $p['price'] }}"
                                        class="btn-add-to-cart w-full inline-flex items-center justify-center gap-3 px-4 py-3 bg-red-700 text-white rounded-lg hover:bg-red-800 transition shadow"
                                    >
                                         <!-- cart icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                                            <circle cx="10" cy="20" r="1" />
                                            <circle cx="18" cy="20" r="1" />
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
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

        // Add-to-cart (authenticated user can add to cart)
        document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
            btn.addEventListener('click', (e) => {
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
