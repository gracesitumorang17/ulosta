<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ $product['name'] ?? 'Detail Produk' }} - UlosTa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS (Animate On Scroll) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <style>
        /* Brand red overrides */
        :root { 
            --brand-red: #AE0808;
            --brand-red-700: #8F0606;
            --brand-red-800: #6F0404;
        }

        .bg-red-600 { background-color: var(--brand-red) !important; }
        .bg-red-700 { background-color: var(--brand-red-700) !important; }
        .bg-red-800 { background-color: var(--brand-red-800) !important; }
        .bg-red-50 { background-color: rgba(174,8,8,0.05) !important; }
        .text-red-600 { color: var(--brand-red) !important; }
        .hover\:bg-red-700:hover { background-color: var(--brand-red-800) !important; }
        .hover\:bg-red-800:hover { background-color: #6F0404 !important; }
        .hover\:bg-red-50:hover { background-color: rgba(174,8,8,0.05) !important; }
        .focus\:ring-red-300:focus { --tw-ring-color: rgba(174,8,8,0.3) !important; }
        .border-red-600 { border-color: var(--brand-red) !important; }

        /* Image aspect ratios */
        .ratio-1-1 { padding-top: 100%; position: relative; }
        .ratio-4-3 { padding-top: 75%; position: relative; }
        .ratio-1-1 > img, .ratio-4-3 > img { 
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; 
        }

        /* Dropdown styles */
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

        /* Thumbnail styles */
        .thumbnail-container {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        
        .thumbnail {
            width: 80px;
            height: 80px;
            border: 2px solid transparent;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: border-color 0.2s;
        }
        
        .thumbnail:hover,
        .thumbnail.active {
            border-color: var(--brand-red);
        }
        
        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Quantity input */
        .quantity-input {
            display: flex;
            align-items: center;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            width: fit-content;
        }
        
        .quantity-btn {
            background: #f9fafb;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
        }
        
        .quantity-btn:hover {
            background: #f3f4f6;
        }
        
        .quantity-input input {
            border: none;
            outline: none;
            text-align: center;
            width: 60px;
            padding: 0.5rem 0;
        }
    </style>
</head>
<body class="antialiased text-gray-800 bg-gray-50">

    <!-- Navbar -->
    <header class="bg-white shadow-sm sticky top-0 z-40 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Left: Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-md bg-red-700 flex items-center justify-center text-white font-bold">
                            U
                        </div>
                        <span class="text-lg font-semibold">UlosTa</span>
                    </a>
                </div>

                <!-- Center: Search -->
                <div class="flex-1 hidden md:flex justify-center px-4 max-w-2xl">
                    <form action="#" method="GET" class="w-full">
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
                                class="w-full border border-gray-200 rounded-full py-2.5 pl-10 pr-12 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-300"
                            />
                        </div>
                    </form>
                </div>

                <!-- Right: Navigation -->
                <div class="flex items-center gap-6">
                    @auth
                        <!-- Home -->
                        <a href="{{ url('/') }}" class="flex items-center gap-2 text-gray-600 hover:text-red-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="text-sm font-medium">Home</span>
                        </a>

                        <!-- Wishlist -->
                        <a href="{{ route('wishlist.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-red-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span class="text-sm font-medium">Wishlist</span>
                        </a>

                        <!-- Keranjang -->
                        <a href="{{ route('keranjang') }}" class="flex items-center gap-2 text-gray-600 hover:text-red-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                            <span class="text-sm font-medium">Keranjang</span>
                        </a>

                        <!-- Profile Dropdown -->
                        <div class="dropdown">
                            <button class="flex items-center gap-2 p-1 rounded-full hover:bg-gray-100 transition">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}&background=AE0808&color=fff" alt="Profile" class="w-9 h-9 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
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
                    @else
                        <a href="{{ route('masuk') }}" class="text-gray-700 px-4 py-2 rounded-full hover:bg-gray-100 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-red-700 text-white px-4 py-2 rounded-full hover:bg-red-800 transition">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-600 mb-6" data-aos="fade-up">
            <div class="flex items-center gap-2">
                <a href="{{ url('/') }}" class="hover:text-red-600">Beranda</a>
                <span>/</span>
                <a href="#" class="hover:text-red-600">Produk</a>
                <span>/</span>
                <span class="text-gray-800 font-medium">{{ $product['name'] ?? 'Ulos Ragihotang Premium' }}</span>
            </div>
        </nav>

        <!-- Product Detail Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Product Images -->
            <div class="space-y-4" data-aos="fade-right">
                <!-- Badge -->
                <div class="relative">
                    <span class="absolute top-4 left-4 bg-red-600 text-white text-sm px-3 py-1 rounded-full font-medium z-10">
                        Terlaris
                    </span>
                </div>

                <!-- Main Image -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                    <div class="ratio-1-1">
                        <img id="main-image" src="{{ asset('image/' . ($product['image'] ?? 'Ulos Ragi Hotang.jpg')) }}" alt="{{ $product['name'] ?? 'Ulos Ragihotang Premium' }}" class="w-full h-full object-cover">
                    </div>
                </div>

                <!-- Thumbnail Images -->
                <div class="thumbnail-container">
                    <div class="thumbnail active" onclick="changeMainImage('{{ asset('image/' . ($product['image'] ?? 'Ulos Ragi Hotang.jpg')) }}', this)">
                        <img src="{{ asset('image/' . ($product['image'] ?? 'Ulos Ragi Hotang.jpg')) }}" alt="Thumbnail 1">
                    </div>
                    <div class="thumbnail" onclick="changeMainImage('{{ asset('image/Ulos Sibolang Rasta Pamontari.jpg') }}', this)">
                        <img src="{{ asset('image/Ulos Sibolang Rasta Pamontari.jpg') }}" alt="Thumbnail 2">
                    </div>
                    <div class="thumbnail" onclick="changeMainImage('{{ asset('image/Ulos Mangiring.jpg') }}', this)">
                        <img src="{{ asset('image/Ulos Mangiring.jpg') }}" alt="Thumbnail 3">
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="space-y-6" data-aos="fade-left">
                <!-- Category Tags -->
                <div class="flex gap-2">
                    <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">{{ $product['category'] ?? 'Ragihotang' }}</span>
                    <span class="inline-block bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">{{ $product['function'] ?? 'Pernikahan' }}</span>
                </div>

                <!-- Product Title -->
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">
                    {{ $product['name'] ?? 'Ulos Ragihotang Premium' }}
                </h1>

                <!-- Rating -->
                <div class="flex items-center gap-2">
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600">({{ $product['reviews'] ?? '64 review' }})</span>
                </div>

                <!-- Price -->
                <div class="space-y-2">
                    <div class="text-3xl font-bold text-red-600">{{ $product['price'] ?? 'Rp 1.250.000' }}</div>
                    @if(isset($product['original_price']))
                        <div class="flex items-center gap-2">
                            <span class="text-lg text-gray-400 line-through">{{ $product['original_price'] }}</span>
                            <span class="bg-red-100 text-red-600 text-sm px-2 py-1 rounded">Diskon 20%</span>
                        </div>
                    @endif
                </div>

                <!-- Product Description -->
                <div class="space-y-3">
                    <h3 class="text-lg font-semibold text-gray-900">Deskripsi Produk</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $product['description'] ?? 'Ulos Ragihotang Premium adalah kain tenun tradisional Batak yang dibuat dengan teknik tenun tradisional. Motif Ragihotang melambangkan kehormatan dan kebanggaan. Cocok untuk upacara pernikahan adat Batak. Terbuat dari benang berkualitas tinggi dengan pewarnaan alami yang tahan lama.' }}
                    </p>
                </div>

                <!-- Specifications -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">Spesifikasi</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Jenis Ulos:</span>
                            <div class="font-medium">{{ $product['type'] ?? 'Ragihotang' }}</div>
                        </div>
                        <div>
                            <span class="text-gray-500">Fungsi:</span>
                            <div class="font-medium">{{ $product['function'] ?? 'Pernikahan' }}</div>
                        </div>
                        <div>
                            <span class="text-gray-500">Ukuran:</span>
                            <div class="font-medium">{{ $product['size'] ?? '200 x 150 cm' }}</div>
                        </div>
                        <div>
                            <span class="text-gray-500">Berat:</span>
                            <div class="font-medium">{{ $product['weight'] ?? '800 gram' }}</div>
                        </div>
                        <div>
                            <span class="text-gray-500">Material:</span>
                            <div class="font-medium">{{ $product['material'] ?? 'Katun Premium' }}</div>
                        </div>
                        <div>
                            <span class="text-gray-500">Asal:</span>
                            <div class="font-medium">{{ $product['origin'] ?? 'Sumatera Utara' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Quantity and Actions -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-700 font-medium">Jumlah:</span>
                        <div class="quantity-input">
                            <button type="button" class="quantity-btn" onclick="decreaseQuantity()">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </button>
                            <input type="number" id="quantity" value="1" min="1" max="10">
                            <button type="button" class="quantity-btn" onclick="increaseQuantity()">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </div>
                        <span class="text-sm text-gray-500">Stok: {{ $product['stock'] ?? '15 pcs' }}</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button
                            class="flex-1 flex items-center justify-center gap-2 bg-red-700 text-white py-3 px-6 rounded-lg hover:bg-red-800 transition font-medium"
                            onclick="addToCart(this)"
                            data-name="{{ $product['name'] ?? 'Ulos Ragihotang Premium' }}"
                            data-price="{{ $product['price'] ?? 'Rp 1.250.000' }}"
                            data-original="{{ $product['original_price'] ?? '' }}"
                            data-tag="{{ $product['tag'] ?? ($product['category'] ?? '') }}"
                            data-image="{{ $product['image'] ?? 'Ulos Ragi Hotang.jpg' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                            <span>Keranjang</span>
                        </button>
                        <button
                            class="flex-1 flex items-center justify-center bg-gray-900 text-white py-3 px-6 rounded-lg hover:bg-gray-800 transition font-medium"
                            onclick="buyNow(this)"
                            data-name="{{ $product['name'] ?? 'Ulos Ragihotang Premium' }}"
                            data-price="{{ $product['price'] ?? 'Rp 1.250.000' }}"
                            data-original="{{ $product['original_price'] ?? '' }}"
                            data-tag="{{ $product['tag'] ?? ($product['category'] ?? '') }}"
                            data-image="{{ $product['image'] ?? 'Ulos Ragi Hotang.jpg' }}"
                        >
                            Beli Sekarang
                        </button>
                    </div>

                    <!-- Wishlist and Share -->
                    <div class="flex gap-3">
                        <button
                            class="flex items-center gap-2 text-gray-600 hover:text-red-600 transition"
                            onclick="toggleWishlist(this)"
                            data-name="{{ $product['name'] ?? 'Ulos Ragihotang Premium' }}"
                            data-price="{{ $product['price'] ?? 'Rp 1.250.000' }}"
                            data-original="{{ $product['original_price'] ?? '' }}"
                            data-tag="{{ $product['tag'] ?? ($product['category'] ?? '') }}"
                            data-image="{{ $product['image'] ?? 'Ulos Ragi Hotang.jpg' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span class="text-sm">Simpan</span>
                        </button>
                        <button class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition" onclick="shareProduct()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                            </svg>
                            <span class="text-sm">Bagikan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommendations Section -->
        <section class="py-16 border-t">
            <div class="mb-8" data-aos="fade-up">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Rekomendasi Ulos</h2>
                <p class="text-gray-600">Produk lain yang mungkin anda sukai</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $recommendations = [
                        [
                            'name' => 'Ulos Bintang Maratur',
                            'tag' => 'Kelahiran', 
                            'price' => 'Rp 750.000',
                            'original' => 'Rp 900.000',
                            'image' => 'Ulos Bintang Maratur.jpg',
                            'badge' => 'Terlaris'
                        ],
                        [
                            'name' => 'Ulos Ragidup', 
                            'tag' => 'Pernikahan',
                            'price' => 'Rp 850.000', 
                            'original' => 'Rp 1.000.000',
                            'image' => 'Ulos Ragi Hotang.jpg',
                            'badge' => 'Terlaris'
                        ],
                        [
                            'name' => 'Ulos Bintang Maratur',
                            'tag' => 'Kelahiran',
                            'price' => 'Rp 750.000',
                            'original' => 'Rp 900.000', 
                            'image' => 'Ulos Bintang Maratur.jpg',
                            'badge' => 'Terlaris'
                        ]
                    ];
                @endphp

                @foreach($recommendations as $index => $item)
                    <article class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition group" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="relative">
                            <div class="ratio-4-3">
                                <img src="{{ asset('image/' . $item['image']) }}" alt="{{ $item['name'] }}">
                            </div>
                            <div class="absolute left-3 top-3">
                                <span class="bg-red-600 text-white text-xs rounded-full px-3 py-1 font-medium">{{ $item['badge'] }}</span>
                            </div>
                            <button
                                class="absolute right-3 top-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:scale-105 transition"
                                onclick="toggleWishlist(this)"
                                data-name="{{ $item['name'] }}"
                                data-price="{{ $item['price'] }}"
                                data-original="{{ $item['original'] }}"
                                data-tag="{{ $item['tag'] }}"
                                data-image="{{ $item['image'] }}"
                                aria-label="Tambah ke wishlist"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.8 6.6c-1.6-3-5.6-3.4-7.8-.9l-.9 1-.9-1C9 3.2 5 3.6 3.4 6.6-1 14 11.8 20.5 12 20.6c.2-.1 13-6.6 8.8-14z" />
                                </svg>
                            </button>
                        </div>

                        <div class="p-4">
                            <div class="mb-2">
                                <span class="inline-block bg-amber-100 text-amber-800 text-xs font-medium px-3 py-1 rounded-full">{{ $item['tag'] }}</span>
                            </div>
                            <h3 class="font-semibold text-gray-800">{{ $item['name'] }}</h3>
                            
                            <div class="mt-3">
                                <div class="text-red-600 font-bold text-lg">{{ $item['price'] }}</div>
                                <div class="text-sm text-gray-400 line-through">{{ $item['original'] }}</div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-gray-200">
                                <button
                                    class="w-full bg-red-700 text-white py-2 px-4 rounded-lg hover:bg-red-800 transition text-sm font-medium"
                                    onclick="addToCart(this)"
                                    data-name="{{ $item['name'] }}"
                                    data-price="{{ $item['price'] }}"
                                    data-original="{{ $item['original'] }}"
                                    data-tag="{{ $item['tag'] }}"
                                    data-image="{{ $item['image'] }}"
                                >
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-red-600 rounded-md flex items-center justify-center font-bold">U</div>
                        <div>
                            <h4 class="font-semibold">UlosTa</h4>
                            <p class="text-sm text-gray-400">Ulos Marketplace</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400">Platform jual beli Ulos terpercaya untuk melestarikan tradisi Batak</p>
                </div>

                <div>
                    <h5 class="text-gray-300 font-semibold mb-3">Tautan Cepat</h5>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:underline">Tentang Kami</a></li>
                        <li><a href="#" class="hover:underline">Cara Berbelanja</a></li>
                        <li><a href="#" class="hover:underline">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:underline">Syarat dan Ketentuan</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-gray-300 font-semibold mb-3">Kategori</h5>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:underline">Ragihotang</a></li>
                        <li><a href="#" class="hover:underline">Bintang Maratur</a></li>
                        <li><a href="#" class="hover:underline">Sibolang</a></li>
                        <li><a href="#" class="hover:underline">Semua Produk</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-gray-300 font-semibold mb-3">Hubungi Kami</h5>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>Jl. Sisingamangaraja</li>
                        <li>No.123, Medan, Sumatra Utara</li>
                        <li>+62 812 3456 7980</li>
                        <li>ppw@gmail.com</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 py-4 text-center text-sm text-gray-500 mt-8">
                © {{ date('Y') }} UlosTa. Semua hak dilindungi.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Toast helpers
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

        // AOS init
        AOS.init({ duration: 700, once: true });

        // Image gallery functionality
        function changeMainImage(src, thumbnail) {
            document.getElementById('main-image').src = src;
            
            // Remove active class from all thumbnails
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            
            // Add active class to clicked thumbnail
            thumbnail.classList.add('active');
        }

        // Quantity controls
        function increaseQuantity() {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value) || 1;
            const maxValue = parseInt(input.getAttribute('max')) || 10;
            
            if (currentValue < maxValue) {
                input.value = currentValue + 1;
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value) || 1;
            const minValue = parseInt(input.getAttribute('min')) || 1;
            
            if (currentValue > minValue) {
                input.value = currentValue - 1;
            }
        }

        // Add to cart via AJAX then go to keranjang
        async function addToCart(btn) {
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let qty = 1;
            const qtyEl = document.getElementById('quantity');
            if (qtyEl) {
                qty = parseInt(qtyEl.value) || 1;
            }
            const payload = {
                name: btn.dataset.name,
                price: btn.dataset.price,
                original: btn.dataset.original,
                tag: btn.dataset.tag,
                image: btn.dataset.image,
                qty: qty
            };

            btn.classList.add('transform', 'scale-95');
            setTimeout(() => btn.classList.remove('scale-95'), 150);

            try {
                const res = await fetch("{{ route('cart.add') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });
                // Jika tidak JSON (misal redirect ke login), arahkan ke halaman masuk
                const ct = res.headers.get('content-type') || '';
                if (!ct.includes('application/json')) {
                    window.location.href = "{{ route('masuk') }}";
                    return;
                }
                const data = await res.json();
                if (data.success) {
                    showToast(`${payload.name} (${qty} pcs) berhasil ditambahkan ke keranjang!`);
                } else {
                    alert('Gagal menambahkan ke keranjang');
                }
            } catch (e) {
                alert('Terjadi kesalahan saat menambahkan ke keranjang');
            }
        }

        // Wishlist toggle via database
        async function toggleWishlist(btn) {
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const icon = btn.querySelector('svg');
            try {
                const res = await fetch("{{ route('wishlist.add') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify({
                        name: btn.dataset.name,
                        price: btn.dataset.price,
                        original: btn.dataset.original,
                        tag: btn.dataset.tag,
                        image: btn.dataset.image
                    })
                });
                const ct = res.headers.get('content-type') || '';
                if (!ct.includes('application/json')) {
                    window.location.href = "{{ route('masuk') }}";
                    return;
                }
                const data = await res.json();
                if (data.success) {
                    // Toggle icon state
                    if (data.action === 'added') {
                        icon.classList.add('fill-current', 'text-red-600');
                        icon.classList.remove('text-gray-600');
                    } else {
                        icon.classList.remove('fill-current', 'text-red-600');
                        icon.classList.add('text-gray-600');
                    }
                } else {
                    alert('Gagal memperbarui wishlist');
                }
            } catch (e) {
                alert('Terjadi kesalahan saat memperbarui wishlist');
            }
        }

        // Buy now - add to cart and redirect to checkout
        async function buyNow(btn) {
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let qty = 1;
            const qtyEl = document.getElementById('quantity');
            if (qtyEl) {
                qty = parseInt(qtyEl.value) || 1;
            }
            const payload = {
                name: btn.dataset.name,
                price: btn.dataset.price,
                original: btn.dataset.original,
                tag: btn.dataset.tag,
                image: btn.dataset.image,
                qty: qty
            };

            btn.classList.add('transform', 'scale-95');
            setTimeout(() => btn.classList.remove('scale-95'), 150);

            try {
                const res = await fetch("{{ route('cart.add') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const ct = res.headers.get('content-type') || '';
                if (!ct.includes('application/json')) {
                    window.location.href = "{{ route('masuk') }}";
                    return;
                }
                const data = await res.json();
                if (data.success) {
                    // Redirect langsung ke checkout
                    window.location.href = "{{ route('checkout') }}";
                } else {
                    alert('Gagal menambahkan ke keranjang');
                }
            } catch (e) {
                alert('Terjadi kesalahan saat memproses pesanan');
            }
        }

        // Share product
        function shareProduct() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $product['name'] ?? 'Ulos Ragihotang Premium' }}',
                    text: 'Lihat produk ulos tradisional ini di UlosTa',
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Link produk berhasil disalin!');
                });
            }
        }

        // Quantity input validation
        document.getElementById('quantity').addEventListener('change', function() {
            const value = parseInt(this.value);
            const min = parseInt(this.getAttribute('min')) || 1;
            const max = parseInt(this.getAttribute('max')) || 10;
            
            if (value < min) this.value = min;
            if (value > max) this.value = max;
        });
    </script>
</body>
</html>