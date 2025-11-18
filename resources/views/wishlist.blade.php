<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Wishlist - UlosTa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand': '#AE0808'
                    }
                }
            }
        }
    </script>

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
        .hover\:bg-red-700:hover { background-color: var(--brand-red-700) !important; }
        .hover\:bg-red-50:hover  { background-color: var(--brand-red-50) !important; }
    </style>
</head>
<body class="antialiased text-gray-800 bg-gray-50">
    <!-- Navbar -->
    <header class="bg-white shadow-sm sticky top-0 z-40 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('homepage') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-md bg-red-600 flex items-center justify-center text-white font-bold">U</div>
                        <span class="text-lg font-semibold">UlosTa</span>
                    </a>
                </div>

                <div class="flex items-center gap-6">
                    <a href="{{ route('homepage') }}" class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="text-sm font-medium">Home</span>
                    </a>

                    <a href="{{ route('wishlist.index') }}" class="relative flex items-center gap-2 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="text-sm font-medium">Wishlist</span>
                        @if($wishlistCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $wishlistCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('keranjang') }}" class="flex items-center gap-2 text-gray-800 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                        <span class="text-sm font-medium">Keranjang</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                Wishlist Saya
            </h1>
            <p class="text-gray-600 mt-2">{{ $wishlistCount }} produk di wishlist</p>
            
            <div class="mt-4">
                <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 font-medium transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Lanjutkan Belanja
                </a>
            </div>
        </div>

        @if($wishlists->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($wishlists as $item)
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition group" data-wishlist-id="{{ $item->id }}">
                <div class="relative">
                    <div class="aspect-[4/3] relative">
                        <img src="{{ asset('image/' . $item->product_image) }}" alt="{{ $item->product_name }}" class="absolute inset-0 w-full h-full object-cover" />
                    </div>

                    <button 
                        onclick="removeFromWishlist({{ $item->id }})"
                        class="absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center shadow-md hover:bg-white transition"
                        title="Hapus dari wishlist"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>

                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 mb-2">{{ $item->product_name }}</h3>

                    <div class="mb-4">
                        <div class="text-red-600 font-bold text-lg">{{ $item->formatted_price }}</div>
                        @if($item->formatted_original_price)
                        <div class="text-sm text-gray-400 line-through">{{ $item->formatted_original_price }}</div>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <button 
                            onclick="addToCart('{{ $item->product_name }}', '{{ $item->formatted_price }}', '{{ $item->formatted_original_price }}', '', '{{ $item->product_image }}')"
                            class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800 transition text-sm font-medium"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                                <circle cx="10" cy="20" r="1" />
                                <circle cx="18" cy="20" r="1" />
                            </svg>
                            Keranjang
                        </button>
                        <button 
                            onclick="removeFromWishlist({{ $item->id }})"
                            class="border border-red-600 text-red-600 px-4 py-2 rounded-lg hover:bg-red-50 transition text-sm font-medium"
                        >
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 bg-white rounded-xl shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">Wishlist Kosong</h3>
            <p class="text-gray-600 mb-6">Belum ada produk yang Anda sukai</p>
            <a href="{{ route('homepage') }}" class="inline-flex items-center bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                Mulai Belanja
            </a>
        </div>
        @endif
    </main>

    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function removeFromWishlist(id) {
            if (!confirm('Yakin ingin menghapus produk dari wishlist?')) return;

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
                    const item = document.querySelector(`[data-wishlist-id="${id}"]`);
                    if (item) {
                        item.remove();
                    }
                    
                    if (data.count === 0) {
                        setTimeout(() => window.location.reload(), 500);
                    }
                    
                    showToast('Produk dihapus dari wishlist');
                } else {
                    alert('Gagal menghapus produk');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }

        function addToCart(name, price, original, tag, image) {
            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name, price, original, tag, image })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast(`${name} berhasil ditambahkan ke keranjang!`);
                } else {
                    alert('Gagal menambahkan ke keranjang');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }

        function showToast(message) {
            let toast = document.getElementById('toast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toast';
                toast.className = 'fixed top-5 right-5 z-50 bg-white border border-gray-200 shadow-xl rounded-lg px-4 py-3 flex items-center gap-3';
                toast.innerHTML = `
                    <div class="w-8 h-8 flex items-center justify-center rounded-full bg-green-100 text-green-700">
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' viewBox='0 0 20 20' fill='currentColor'>
                            <path fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.172l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd' />
                        </svg>
                    </div>
                    <span id="toast-text" class="text-sm font-medium text-gray-800"></span>
                `;
                document.body.appendChild(toast);
            }
            
            toast.querySelector('#toast-text').textContent = message;
            toast.classList.remove('hidden');
            
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
    </script>
</body>
</html>
