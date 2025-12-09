<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pembayaran - UlosTa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --brand-red-50:  #FDEAEA;
            --brand-red-600: #AE0808;
            --brand-red-700: #8F0606;
            --brand-red-800: #6F0404;
        }
        .bg-red-600 { background-color: var(--brand-red-600) !important; }
        .bg-red-700 { background-color: var(--brand-red-700) !important; }
        .text-red-600 { color: var(--brand-red-600) !important; }
        .border-red-600 { border-color: var(--brand-red-600) !important; }
        .hover\:bg-red-700:hover { background-color: var(--brand-red-700) !important; }
        .hover\:bg-red-50:hover { background-color: var(--brand-red-50) !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <!-- Header -->
    <header class="bg-white border-b sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('homepage') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-md bg-red-600 flex items-center justify-center text-white font-bold">U</div>
                <span class="text-lg font-semibold">UlosTa</span>
            </a>

            <div class="flex items-center gap-6">
                <a href="{{ route('homepage') }}" class="flex items-center gap-2 text-gray-600 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-sm font-medium">Home</span>
                </a>

                <a href="{{ route('wishlist.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span class="text-sm font-medium">Wishlist</span>
                </a>

                <a href="{{ route('keranjang') }}" class="flex items-center gap-2 text-gray-600 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                    </svg>
                    <span class="text-sm font-medium">Keranjang</span>
                </a>

                <div class="relative">
                    <button id="profile-button" type="button" class="flex items-center gap-2 text-gray-600 hover:text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm font-medium">Profil</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                            <a href="{{ route('keranjang') }}" class="flex items-center gap-3 px-4 py-3 text-gray-800 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                                </svg>
                                <span class="text-sm">Keranjang Saya</span>
                            </a>
                            <div class="my-2 border-t border-gray-100"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span class="text-sm">Keluar</span>
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>
                
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Left Column - Form -->
                <div class="lg:col-span-2 order-2 lg:order-1">
                    <!-- Alamat Pengiriman -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="w-2 h-2 rounded-full bg-red-600"></div>
                            <h2 class="text-lg font-semibold">Alamat Pengiriman</h2>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-600">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_lengkap" 
                                    placeholder="Masukkan nama lengkap"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-600"
                                />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon <span class="text-red-600">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    name="nomor_telepon" 
                                    placeholder="Masukkan nomor telepon"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-600"
                                />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat Lengkap <span class="text-red-600">*</span>
                                </label>
                                <textarea 
                                    name="alamat_lengkap" 
                                    rows="3" 
                                    placeholder="Masukkan alamat lengkap"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-600"
                                ></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Kota <span class="text-red-600">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="kota" 
                                        placeholder="Masukkan Kota"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-600"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Kode Pos <span class="text-red-600">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="kode_pos" 
                                        placeholder="Masukkan Kode Pos"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-600"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Metode Pengiriman -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-semibold mb-4">Metode Pengiriman</h2>
                        
                        <div class="p-4 border border-green-200 bg-green-50 rounded-lg flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-green-800">Pengiriman Gratis</p>
                                <p class="text-sm text-green-600">Minimal Pembelian Rp 500.000</p>
                            </div>
                            <span class="text-green-600 font-bold">Gratis</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="lg:col-span-1 order-1 lg:order-2">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                        <h2 class="text-lg font-semibold mb-6">Ringkasan Pesanan</h2>
                        <!-- Product Items -->
                        <div class="space-y-4 mb-6 max-h-60 overflow-y-auto">
                            @foreach($items as $item)
                            <div class="flex gap-4">
                                <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                    <img src="{{ asset('image/' . $item->image) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-sm truncate">{{ $item->product_name }}</h3>
                                    <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                    <p class="text-sm font-semibold text-red-600">{{ $item->formatted_price }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- Price Summary -->
                        <div class="border-t pt-4 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Ongkir</span>
                                <span class="font-medium">
                                    @if($shipping == 0)
                                        <span class="text-green-600">Gratis</span>
                                    @else
                                        Rp {{ number_format($shipping, 0, ',', '.') }}
                                    @endif
                                </span>
                            </div>
                            <div class="border-t pt-3 flex justify-between text-base font-bold">
                                <span>Total</span>
                                <span class="text-red-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <!-- Buttons -->
                        <div class="mt-6 space-y-3">
                            <button 
                                type="submit"
                                class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition font-medium"
                            >
                                Buat Pesanan
                            </button>
                            <a 
                                href="{{ route('keranjang') }}"
                                class="block w-full text-center border border-red-600 text-red-600 py-3 rounded-lg hover:bg-red-50 transition font-medium"
                            >
                                ← Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
           
    <!-- Footer -->
    <footer class="bg-neutral-900 text-neutral-300 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-md bg-red-600 flex items-center justify-center text-white font-bold">U</div>
                        <span class="text-lg font-semibold text-white">UlosTa</span>
                    </div>
                    <p class="text-sm text-neutral-400">Platform jual beli ulos terpercaya untuk melestarikan tradisi lokal</p>
                </div>

                <div>
                    <h3 class="font-semibold text-white mb-4">Tentang Kami</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">Cara Berbelanja</a></li>
                        <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-white transition">Syarat dan Ketentuan</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-white mb-4">Kategori</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Pernikahan</a></li>
                        <li><a href="#" class="hover:text-white transition">Kenduri Kerja</a></li>
                        <li><a href="#" class="hover:text-white transition">Siluluton</a></li>
                        <li><a href="#" class="hover:text-white transition">Semua Produk</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-white mb-4">Hubungi Kami</h3>
                    <ul class="space-y-2 text-sm">
                        <li>Email: ppwproject@gmail.com</li>
                        <li>Telepon: +62 812 3456 7890</li>
                        <li class="flex gap-3 mt-4">
                            <a href="#" class="text-neutral-400 hover:text-white"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                            <a href="#" class="text-neutral-400 hover:text-white"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                            <a href="#" class="text-neutral-400 hover:text-white"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-neutral-800 mt-8 pt-8 text-center text-sm text-neutral-500">
                © {{ date('Y') }} UlosTa. Semua hak dilindungi.
            </div>
        </div>
    </footer>

    <script>
        // Toggle profile dropdown
        const profileButton = document.getElementById('profile-button');
        const profileMenu = document.getElementById('profile-menu');

        profileButton.addEventListener('click', function(e) {
            e.stopPropagation();
            profileMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!profileMenu.contains(e.target) && !profileButton.contains(e.target)) {
                profileMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
