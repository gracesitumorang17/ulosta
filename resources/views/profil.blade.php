<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Profil - UlosTa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Tailwind CDN -->
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

    <style>
        :root {
            --brand-red-50:  #FDEAEA;
            --brand-red-300: #EFA3A3;
            --brand-red-600: #AE0808;
            --brand-red-700: #8F0606;
            --brand-red-800: #6F0404;
        }

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
        .focus\:ring-red-300:focus { --tw-ring-color: var(--brand-red-300) !important; }

        .tab-active {
            background-color: #f3f4f6;
            border-bottom: 2px solid var(--brand-red-600);
        }

        /* Filter tabs styling */
        .filter-tab {
            color: #6b7280;
            text-decoration: none;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .filter-tab:hover {
            color: var(--brand-red-600);
            border-bottom-color: #EFA3A3;
        }

        .filter-tab.active {
            color: var(--brand-red-600);
            border-bottom-color: var(--brand-red-600);
        }

        .filter-tab span {
            background-color: transparent;
            color: #6b7280;
        }

        .filter-tab.active span {
            background-color: transparent;
            color: var(--brand-red-600);
            font-weight: 600;
        }
    </style>
</head>
<body class="antialiased text-gray-800 bg-gray-50">

    @if(Auth::user()->role === 'seller')
        <!-- Navbar Seller (with Home, Wishlist, Keranjang, Profil) -->
        @include('seller.partials.navbar-home')
    @else
    <!-- Navbar Buyer -->
    <header class="bg-white shadow-sm sticky top-0 z-40 border-b">
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

                <!-- Right: User Navigation Links -->
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
                            @if($wishlistCount > 0)
                            <span id="wishlist-badge" class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
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
                            @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                            @endif
                        </div>
                        <span class="text-sm font-medium">Keranjang</span>
                    </a>

                    <!-- Profil -->
                    <a href="{{ route('profil') }}" class="flex items-center gap-2 text-red-600 hover:text-red-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm font-medium">Profil</span>
                    </a>
                </div>
            </div>
        </div>
    </header>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="flex items-center text-sm text-gray-600 mb-6">
            <a href="{{ route('homepage') }}" class="hover:text-red-600">
                Beranda
            </a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium">Profil</span>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Sidebar - User Info Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <!-- Profile Picture -->
                    <div class="flex flex-col items-center">
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center text-white text-4xl font-bold mb-4 shadow-lg">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        
                        <h2 class="text-xl font-semibold text-gray-900 text-center">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500 text-center mt-1">{{ $user->email }}</p>
                        
                        <span class="inline-block mt-3 bg-red-100 text-red-700 text-xs font-medium px-3 py-1 rounded-full">
                            {{ $user->role === 'seller' ? 'Penjual' : 'Pembeli' }}
                        </span>
                    </div>

                    <!-- User Details (untuk semua user) -->
                    <div class="mt-6 space-y-4 border-t pt-4">
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Nomor Telepon</p>
                                <p class="text-sm font-medium text-gray-900">{{ $user->phone ?? 'Belum diisi' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Alamat</p>
                                <p class="text-sm font-medium text-gray-900">{{ $user->address ?? 'Belum diisi' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Bergabung</p>
                                <p class="text-sm font-medium text-gray-900">{{ $user->created_at->format('F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    @if($user->role === 'seller')
                    <!-- Statistik Toko (untuk seller) -->
                    <div class="mt-6 space-y-3 border-t pt-4">
                        <h3 class="text-sm font-semibold text-gray-700 mb-4">Statistik Toko</h3>
                        
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-600">Total Produk</span>
                            </div>
                            <span class="text-lg font-semibold text-gray-900">24</span>
                        </div>

                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-600">Terjual</span>
                            </div>
                            <span class="text-lg font-semibold text-gray-900">156</span>
                        </div>

                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-600">Rating</span>
                            </div>
                            <span class="text-lg font-semibold text-gray-900">4.8/5</span>
                        </div>
                    </div>
                    @endif

                    <!-- Settings Button -->
                    <div class="mt-6 pt-4 border-t">
                        <a href="#" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Pengaturan</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Content - Tabs -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Tabs Header -->
                    <div class="flex border-b border-gray-200">
                        <button 
                            onclick="switchTab('profil')" 
                            id="tab-profil" 
                            class="tab-btn flex-1 px-6 py-4 text-sm font-medium text-gray-700 hover:bg-gray-50 transition tab-active"
                        >
                            Informasi Profil
                        </button>
                        <button 
                            onclick="switchTab('pesanan')" 
                            id="tab-pesanan" 
                            class="tab-btn flex-1 px-6 py-4 text-sm font-medium text-gray-700 hover:bg-gray-50 transition"
                        >
                            Pesanan
                        </button>
                        <button 
                            onclick="switchTab('wishlist')" 
                            id="tab-wishlist" 
                            class="tab-btn flex-1 px-6 py-4 text-sm font-medium text-gray-700 hover:bg-gray-50 transition"
                        >
                            Wishlist
                        </button>
                    </div>

                    <!-- Tab Content: Informasi Profil -->
                    <div id="content-profil" class="tab-content p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Profil</h3>
                            <button 
                                onclick="toggleEditMode()" 
                                id="edit-btn"
                                class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span>Edit Profil</span>
                            </button>
                        </div>

                        <p class="text-sm text-gray-600 mb-6">Kelola informasi pribadi Anda</p>

                        <!-- Display Mode -->
                        <div id="display-mode">
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                    <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                                        {{ $user->phone ?? 'Belum diisi' }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                    <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                                        {{ $user->address ?? 'Belum diisi' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Mode -->
                        <div id="edit-mode" class="hidden">
                            <form action="{{ route('profil.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                                Nama Lengkap <span class="text-red-600">*</span>
                                            </label>
                                            <input 
                                                type="text" 
                                                id="name" 
                                                name="name" 
                                                value="{{ old('name', $user->name) }}"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300 @error('name') border-red-500 @enderror"
                                                required
                                            />
                                            @error('name')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                                Email <span class="text-red-600">*</span>
                                            </label>
                                            <input 
                                                type="email" 
                                                id="email" 
                                                name="email" 
                                                value="{{ old('email', $user->email) }}"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300 @error('email') border-red-500 @enderror"
                                                required
                                            />
                                            @error('email')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                            Nomor Telepon <span class="text-red-600">*</span>
                                        </label>
                                        <input 
                                            type="tel" 
                                            id="phone" 
                                            name="phone" 
                                            value="{{ old('phone', $user->phone) }}"
                                            placeholder="Contoh: 081234567890"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300 @error('phone') border-red-500 @enderror"
                                            required
                                        />
                                        @error('phone')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                            Alamat
                                        </label>
                                        <textarea 
                                            id="address" 
                                            name="address" 
                                            rows="3"
                                            placeholder="Jl.TPL No 123 Balige"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300 @error('address') border-red-500 @enderror"
                                        >{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex gap-3 pt-4">
                                        <button 
                                            type="submit"
                                            class="flex-1 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium"
                                        >
                                            Simpan Perubahan
                                        </button>
                                        <button 
                                            type="button"
                                            onclick="toggleEditMode()"
                                            class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium"
                                        >
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tab Content: Pesanan -->
                    <div id="content-pesanan" class="tab-content hidden p-6">
                        <!-- Back Button & Header -->
                        <div class="flex items-center gap-3 mb-5">
                            <button onclick="switchTab('profil')" class="flex items-center gap-1.5 text-gray-600 hover:text-gray-900 transition text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Kembali
                            </button>
                        </div>

                        <div class="mb-5">
                            <h3 class="text-xl font-bold text-gray-900">Pesanan Saya</h3>
                            @if(isset($orders))
                            <p class="text-xs text-gray-500 mt-1">{{ $orders->count() }} pesanan ditemukan</p>
                            @endif
                        </div>

                        @if(isset($orders) && isset($statusCounts))
                        <!-- Filter Tabs -->
                        <div class="mb-5 overflow-x-auto">
                            <div class="flex gap-2 border-b">
                                <a href="{{ route('profil') }}?tab=pesanan&status=all{{ request('search') ? '&search='.request('search') : '' }}" 
                                   class="filter-tab pb-2.5 px-3 {{ request('status', 'all') === 'all' ? 'active' : '' }}">
                                    <span class="font-semibold text-sm">Semua</span>
                                    <span class="ml-1.5 px-1.5 py-0.5 text-xs rounded-full">{{ $statusCounts['all'] }}</span>
                                </a>
                                <a href="{{ route('profil') }}?tab=pesanan&status=pending{{ request('search') ? '&search='.request('search') : '' }}" 
                                   class="filter-tab pb-2.5 px-3 {{ request('status') === 'pending' ? 'active' : '' }}">
                                    <span class="font-semibold text-sm">Menunggu</span>
                                    <span class="ml-1.5 px-1.5 py-0.5 text-xs rounded-full">{{ $statusCounts['pending'] }}</span>
                                </a>
                                <a href="{{ route('profil') }}?tab=pesanan&status=processing{{ request('search') ? '&search='.request('search') : '' }}" 
                                   class="filter-tab pb-2.5 px-3 {{ request('status') === 'processing' ? 'active' : '' }}">
                                    <span class="font-semibold text-sm">Diproses</span>
                                    <span class="ml-1.5 px-1.5 py-0.5 text-xs rounded-full">{{ $statusCounts['processing'] }}</span>
                                </a>
                                <a href="{{ route('profil') }}?tab=pesanan&status=shipped{{ request('search') ? '&search='.request('search') : '' }}" 
                                   class="filter-tab pb-2.5 px-3 {{ request('status') === 'shipped' ? 'active' : '' }}">
                                    <span class="font-semibold text-sm">Dikirim</span>
                                    <span class="ml-1.5 px-1.5 py-0.5 text-xs rounded-full">{{ $statusCounts['shipped'] }}</span>
                                </a>
                                <a href="{{ route('profil') }}?tab=pesanan&status=delivered{{ request('search') ? '&search='.request('search') : '' }}" 
                                   class="filter-tab pb-2.5 px-3 {{ request('status') === 'delivered' ? 'active' : '' }}">
                                    <span class="font-semibold text-sm">Selesai</span>
                                    <span class="ml-1.5 px-1.5 py-0.5 text-xs rounded-full">{{ $statusCounts['delivered'] }}</span>
                                </a>
                                <a href="{{ route('profil') }}?tab=pesanan&status=cancelled{{ request('search') ? '&search='.request('search') : '' }}" 
                                   class="filter-tab pb-2.5 px-3 {{ request('status') === 'cancelled' ? 'active' : '' }}">
                                    <span class="font-semibold text-sm">Dibatalkan</span>
                                    <span class="ml-1.5 px-1.5 py-0.5 text-xs rounded-full">{{ $statusCounts['cancelled'] }}</span>
                                </a>
                            </div>
                        </div>

                        <!-- Search Bar -->
                        <div class="mb-5">
                            <form action="{{ route('profil') }}" method="GET" class="relative">
                                <input type="hidden" name="tab" value="pesanan">
                                <input type="hidden" name="status" value="{{ request('status', 'all') }}">
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       placeholder="Cari pesanan..." 
                                       class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </form>
                        </div>

                        @if($orders->count() > 0)
                        <!-- Orders Table -->
                        <div class="bg-white border rounded-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50 border-b">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID Pesanan</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Produk</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($orders as $order)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-4 py-3">
                                                <p class="text-xs font-semibold text-gray-900">{{ $order->order_number }}</p>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex flex-col gap-2">
                                                    @foreach($order->orderItems as $item)
                                                    <div class="flex items-center gap-2">
                                                        <img src="{{ asset('image/' . $item->product_image) }}" 
                                                             alt="Product" 
                                                             class="w-10 h-10 object-cover rounded-lg flex-shrink-0">
                                                        <div class="min-w-0">
                                                            <p class="text-xs font-medium text-gray-900 truncate">{{ $item->product_name }}</p>
                                                            <p class="text-xs text-gray-500">{{ $item->quantity }}x</p>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <p class="text-xs font-bold text-red-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                            </td>
                                            <td class="px-4 py-3">
                                                @php
                                                    $statusConfig = [
                                                        'pending' => ['label' => 'Menunggu', 'color' => 'bg-yellow-100 text-yellow-800', 'dot' => 'bg-yellow-400'],
                                                        'processing' => ['label' => 'Diproses', 'color' => 'bg-blue-100 text-blue-800', 'dot' => 'bg-blue-400'],
                                                        'shipped' => ['label' => 'Dikirim', 'color' => 'bg-purple-100 text-purple-800', 'dot' => 'bg-purple-400'],
                                                        'delivered' => ['label' => 'Selesai', 'color' => 'bg-green-100 text-green-800', 'dot' => 'bg-green-400'],
                                                        'cancelled' => ['label' => 'Dibatalkan', 'color' => 'bg-red-100 text-red-800', 'dot' => 'bg-red-400'],
                                                    ];
                                                    $status = $statusConfig[$order->status] ?? ['label' => $order->status, 'color' => 'bg-gray-100 text-gray-800', 'dot' => 'bg-gray-400'];
                                                @endphp
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $status['color'] }}">
                                                    <span class="w-1.5 h-1.5 rounded-full {{ $status['dot'] }}"></span>
                                                    {{ $status['label'] }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <p class="text-xs text-gray-600">{{ $order->created_at->format('Y-m-d') }}</p>
                                            </td>
                                            <td class="px-4 py-3">
                                                <button onclick="showOrderDetail({{ $order->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    Lihat Detail
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <p class="text-gray-600 text-sm mb-1">{{ request('search') ? 'Tidak ada hasil untuk "'.request('search').'"' : 'Belum ada pesanan' }}</p>
                            <a href="{{ route('homepage') }}" class="inline-block mt-4 px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                                Mulai Belanja
                            </a>
                        </div>
                        @endif
                        @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <p class="text-gray-600 text-sm">Belum ada pesanan</p>
                            <a href="{{ route('homepage') }}" class="inline-block mt-4 px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                                Mulai Belanja
                            </a>
                        </div>
                        @endif
                    </div>

                    <!-- Modal Detail Pesanan -->
                    <div id="orderDetailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-start justify-center p-6" style="padding-top: calc(8rem + 3cm); padding-left: calc(1.5rem + 50px + 4cm);">
                        <div class="bg-white rounded-xl max-w-md w-full shadow-2xl" style="max-height: 85vh; display: flex; flex-direction: column;">
                            <div id="orderDetailContent" class="p-6 overflow-y-auto" style="flex: 1;">
                                <!-- Content will be loaded dynamically -->
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content: Wishlist -->
                    <div id="content-wishlist" class="tab-content hidden p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Wishlist Saya</h3>
                        @if($user->wishlists->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($user->wishlists as $wishlist)
                            <div class="bg-white border rounded-xl shadow-sm overflow-hidden hover:shadow-md transition" data-wishlist-id="{{ $wishlist->id }}">
                                <div class="aspect-[4/3] relative">
                                    <img src="{{ asset('image/' . $wishlist->product_image) }}" alt="{{ $wishlist->product_name }}" class="absolute inset-0 w-full h-full object-cover" />
                                </div>
                                <div class="p-4">
                                    <h4 class="font-semibold text-gray-900 text-base mb-1">{{ $wishlist->product_name }}</h4>
                                    <div class="text-red-600 font-bold text-lg mb-3">{{ $wishlist->getFormattedPriceAttribute() }}</div>
                                    <button 
                                        onclick="deleteWishlist({{ $wishlist->id }})"
                                        class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium flex items-center justify-center gap-2"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <p class="text-gray-600 text-sm">Belum ada wishlist</p>
                            <a href="{{ route('homepage') }}" class="inline-block mt-4 px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                                Belanja Sekarang
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-200 mt-12">
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

    <script>
        // Tab switching
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('tab-active');
            });
            
            // Show selected tab content
            document.getElementById('content-' + tabName).classList.remove('hidden');
            
            // Add active class to selected tab
            document.getElementById('tab-' + tabName).classList.add('tab-active');
        }

        // Toggle edit mode
        function toggleEditMode() {
            const displayMode = document.getElementById('display-mode');
            const editMode = document.getElementById('edit-mode');
            const editBtn = document.getElementById('edit-btn');
            
            if (displayMode.classList.contains('hidden')) {
                // Switch to display mode
                displayMode.classList.remove('hidden');
                editMode.classList.add('hidden');
                editBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    <span>Edit Profil</span>
                `;
            } else {
                // Switch to edit mode
                displayMode.classList.add('hidden');
                editMode.classList.remove('hidden');
                editBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Tutup Edit</span>
                `;
            }
        }

        // Show edit mode if there are validation errors
        @if($errors->any())
        toggleEditMode();
        @endif

        // Auto-switch tab based on URL parameter
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');
            
            if (tab && ['profil', 'pesanan', 'wishlist'].includes(tab)) {
                switchTab(tab);
            }
        });

        // Show order detail modal
        function showOrderDetail(orderId) {
            const modal = document.getElementById('orderDetailModal');
            const content = document.getElementById('orderDetailContent');
            
            // Find order data
            const orders = @json($orders ?? []);
            const order = orders.find(o => o.id === orderId);
            
            if (!order) return;
            
            // Status configuration
            const statusConfig = {
                'pending': { label: 'Menunggu', color: 'text-yellow-600', dot: 'bg-yellow-400' },
                'processing': { label: 'Diproses', color: 'text-blue-600', dot: 'bg-blue-400' },
                'shipped': { label: 'Dikirim', color: 'text-purple-600', dot: 'bg-purple-400' },
                'delivered': { label: 'Selesai', color: 'text-green-600', dot: 'bg-green-400' },
                'cancelled': { label: 'Dibatalkan', color: 'text-red-600', dot: 'bg-red-400' }
            };
            const status = statusConfig[order.status] || { label: order.status, color: 'text-gray-600', dot: 'bg-gray-400' };
            
            // Build products HTML
            let productsHtml = '';
            order.order_items.forEach(item => {
                productsHtml += `
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="text-sm font-medium text-gray-900">${item.product_name}</p>
                            <p class="text-xs text-gray-500">${item.quantity} x Rp ${parseInt(item.price).toLocaleString('id-ID')}</p>
                        </div>
                        <p class="text-sm font-semibold text-red-600">Rp ${parseInt(item.price * item.quantity).toLocaleString('id-ID')}</p>
                    </div>
                `;
            });
            
            // Build modal content
            content.innerHTML = `
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Detail Pesanan ${order.order_number}</h3>
                        <p class="text-xs text-gray-500 mt-1">Informasi lengkap pesanan Anda</p>
                    </div>
                    <button onclick="closeOrderDetail()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="mb-5">
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Status Pesanan</h4>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full ${status.dot}"></span>
                        <span class="text-sm font-medium ${status.color}">${status.label}</span>
                    </div>
                </div>

                <div class="mb-5 bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Informasi Pengiriman</h4>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Alamat:</p>
                            <p class="text-sm text-gray-900 leading-relaxed">${order.shipping_address_1 || 'Tidak ada alamat'}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Telepon:</p>
                            <p class="text-sm text-gray-900">${order.shipping_phone || '-'}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Produk</h4>
                    <div class="space-y-3">
                        ${productsHtml}
                    </div>
                </div>

                <div class="border-t pt-4 mt-4 bg-red-50 -mx-6 px-6 py-4 rounded-b-xl">
                    <div class="flex justify-between items-center">
                        <p class="text-sm font-semibold text-gray-900">Total Pembayaran</p>
                        <p class="text-xl font-bold text-red-600">Rp ${parseInt(order.total_amount).toLocaleString('id-ID')}</p>
                    </div>
                </div>
            `;
            
            modal.classList.remove('hidden');
        }

        // Close order detail modal
        function closeOrderDetail() {
            document.getElementById('orderDetailModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('orderDetailModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeOrderDetail();
            }
        });

        // Wishlist Delete Function
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function deleteWishlist(id) {
            if (!confirm('Hapus dari wishlist?')) {
                return;
            }

            fetch(`/wishlist/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update badge counter
                    updateWishlistBadge(data.count);
                    
                    // Remove item from DOM
                    const item = document.querySelector(`[data-wishlist-id="${id}"]`);
                    if (item) {
                        item.style.transition = 'opacity 0.3s';
                        item.style.opacity = '0';
                        setTimeout(() => {
                            item.remove();
                            
                            // Check if empty, show empty state
                            const container = document.querySelector('#content-wishlist .grid');
                            if (container && container.children.length === 0) {
                                window.location.reload();
                            }
                        }, 300);
                    }
                } else {
                    alert('Gagal menghapus produk');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }

        function updateWishlistBadge(count) {
            const badge = document.getElementById('wishlist-badge');
            const mobileBadge = document.getElementById('mobile-wishlist-badge');
            
            if (badge) {
                if (count > 0) {
                    badge.textContent = count > 99 ? '99+' : count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            }
            
            if (mobileBadge) {
                if (count > 0) {
                    mobileBadge.textContent = count > 99 ? '99+' : count;
                    mobileBadge.style.display = 'flex';
                } else {
                    mobileBadge.style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>
