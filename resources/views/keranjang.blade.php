<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Keranjang Belanja - UlosTa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root { --brand-red: #AE0808; }
        .bg-red-600 { background-color: var(--brand-red) !important; }
        .text-red-600 { color: var(--brand-red) !important; }
        .hover\:bg-red-700:hover { background-color: var(--brand-red) !important; }
        .focus\:ring-red-300:focus { --tw-ring-color: var(--brand-red); box-shadow: 0 0 0 4px rgba(174,8,8,.12); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <!-- Simple header -->
    <header class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-red-600 text-white font-bold flex items-center justify-center">U</div>
                <span class="font-semibold">UlosTa</span>
            </a>
            <nav class="hidden sm:flex items-center gap-6 text-sm">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-red-600 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9.5L12 4l9 5.5V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V9.5z"/></svg>
                    Home
                </a>
                <a href="{{ route('keranjang') }}" class="text-gray-900 font-medium flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2z"/></svg>
                    Keranjang
                </a>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 14.707a1 1 0 01-1.414 0L7 10.414l4.293-4.293a1 1 0 011.414 1.414L9.414 10l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd"/></path></svg>
            Lanjut Belanja
        </a>

        <div class="flex items-center justify-between mt-4">
            <div>
                <h1 class="text-2xl font-bold">Keranjang Belanja</h1>
                <p class="text-sm text-gray-500">{{ $items->sum('quantity') }} produk dalam keranjang</p>
            </div>
            @if($items->count() > 0)
            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Yakin ingin mengosongkan keranjang?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">
                    Kosongkan Keranjang
                </button>
            </form>
            @endif
        </div>

        @if(session('success'))
        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Cart list -->
            <section class="lg:col-span-2 space-y-4">
                @forelse($items as $item)
                <div class="bg-white border rounded-xl shadow-sm">
                    <div class="p-4 flex items-start gap-4">
                        <img src="{{ $item->image ? asset('image/'.$item->image) : asset('image/Background.png') }}" alt="{{ $item->product_name }}" class="w-24 h-24 object-cover rounded-md border" />
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="font-medium">{{ $item->product_name }}</h3>
                                    @if($item->tag)
                                        <span class="text-xs text-gray-500 inline-block mt-0.5">{{ $item->tag }}</span>
                                    @endif
                                </div>
                                <form action="{{ route('cart.delete', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-gray-400 hover:text-red-600" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 100 2h.293l.853 10.24A2 2 0 007.141 18h5.718a2 2 0 001.995-1.76L15.707 6H16a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zm-1 6a1 1 0 012 0v6a1 1 0 11-2 0V8zm5 0a1 1 0 10-2 0v6a1 1 0 102 0V8z" clip-rule="evenodd"/></svg>
                                    </button>
                                </form>
                            </div>
                            <div class="mt-2 text-red-600 font-semibold">Rp {{ number_format($item->price,0,',','.') }}</div>
                            <div class="mt-3 flex items-center gap-3 text-sm">
                                <span>Jumlah:</span>
                                <div class="inline-flex items-center border rounded-md overflow-hidden">
                                    <form action="{{ route('cart.qty', $item) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button name="qty" value="{{ max(1,$item->quantity-1) }}" 
                                                class="px-3 py-1 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors {{ $item->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $item->quantity <= 1 ? 'disabled' : '' }}>−</button>
                                    </form>
                                    <span class="px-4 py-1 bg-gray-50 font-medium">{{ $item->quantity }}</span>
                                    <form action="{{ route('cart.qty', $item) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button name="qty" value="{{ $item->quantity+1 }}" class="px-3 py-1 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">+</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 border-t text-xs text-gray-500 flex items-center justify-between">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($item->price * $item->quantity,0,',','.') }}</span>
                    </div>
                </div>
                @empty
                    <div class="bg-white border rounded-xl shadow-sm p-8 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Keranjang Anda kosong</h3>
                        <p class="text-gray-500 mb-4">Belum ada produk yang ditambahkan ke keranjang</p>
                        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 14.707a1 1 0 01-1.414 0L7 10.414l4.293-4.293a1 1 0 011.414 1.414L9.414 10l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                            </svg>
                            Mulai Belanja
                        </a>
                    </div>
                @endforelse
            </section>

            <!-- Summary -->
            <aside class="lg:col-span-1">
                <div class="bg-white border rounded-xl shadow-sm p-4">
                    <h3 class="font-semibold">Ringkasan Pemesanan</h3>
                    <div class="mt-3 space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span>Subtotal ({{ $items->sum('quantity') }} produk)</span>
                            <span>Rp {{ number_format($subtotal,0,',','.') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Ongkos Kirim</span>
                            <span class="{{ $subtotal >= 500000 ? 'text-green-600 line-through' : '' }}">
                                @if($subtotal >= 500000)
                                    <span class="mr-2">Rp {{ number_format($shipping,0,',','.') }}</span>
                                    <span class="text-green-600 font-medium">GRATIS</span>
                                @else
                                    Rp {{ number_format($shipping,0,',','.') }}
                                @endif
                            </span>
                        </div>
                        @if($subtotal >= 500000)
                        <div class="flex items-center justify-between text-green-600 text-xs">
                            <span>🎉 Selamat! Anda mendapat gratis ongkir</span>
                        </div>
                        @else
                        <div class="flex items-center justify-between text-amber-600 text-xs">
                            <span>Belanja Rp {{ number_format(500000 - $subtotal,0,',','.') }} lagi untuk gratis ongkir</span>
                        </div>
                        @endif
                        <hr class="my-2">
                        <div class="flex items-center justify-between font-semibold">
                            <span>Total</span>
                            <span class="text-red-600">Rp {{ number_format($subtotal >= 500000 ? $subtotal : $total,0,',','.') }}</span>
                        </div>
                    </div>

                    @if($items->count() > 0)
                    <a href="{{ route('checkout') }}" class="mt-4 w-full bg-red-600 text-white py-2.5 rounded-md hover:bg-red-700 transition-colors font-medium block text-center">
                        Lanjut ke Pembayaran
                    </a>
                    @else
                    <button disabled class="mt-4 w-full bg-gray-300 text-gray-500 py-2.5 rounded-md cursor-not-allowed font-medium">
                        Keranjang Kosong
                    </button>
                    @endif

                    <div class="mt-4 p-3 rounded-md bg-amber-50 text-amber-800 text-sm flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4a1 1 0 002 0V7zm0 6a1 1 0 10-2 0 1 1 0 002 0z" clip-rule="evenodd"/></svg>
                        Gratis ongkir untuk pembelian di atas Rp 500.000
                    </div>

                    <ul class="mt-4 text-xs text-gray-500 space-y-1">
                        <li>Pengiriman aman & terpercaya</li>
                        <li>Produk dijamin 100% original</li>
                        <li>Garansi uang kembali</li>
                    </ul>
                </div>
            </aside>
        </div>
    </main>

    <footer class="bg-neutral-900 text-neutral-300 mt-12">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-red-600 rounded-md flex items-center justify-center font-bold text-white text-sm">U</div>
                        <div class="text-white font-semibold text-lg">UlosTa</div>
                    </div>
                    <p class="mt-4 text-neutral-400">Platform jual beli Ulos terpercaya untuk melestarikan tradisi Batak.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold">Tautan Cepat</h4>
                    <ul class="mt-3 space-y-2 text-neutral-400">
                        <li><a href="#" class="hover:text-white">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white">Kontak</a></li>
                        <li><a href="#" class="hover:text-white">Bantuan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold">Kategori</h4>
                    <ul class="mt-3 space-y-2 text-neutral-400">
                        <li><a href="#" class="hover:text-white">Ragihotang</a></li>
                        <li><a href="#" class="hover:text-white">Bintang Maratur</a></li>
                        <li><a href="#" class="hover:text-white">Sibolang</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold">Hubungi Kami</h4>
                    <ul class="mt-3 space-y-1 text-neutral-400">
                        <li>Jl. Sisingamangaraja No.123, Medan</li>
                        <li>+62 812 3456 7890</li>
                        <li>ppw@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-neutral-800 pt-4 text-center text-neutral-500 text-sm">© {{ date('Y') }} UlosTa. Semua hak dilindungi.</div>
        </div>
    </footer>

    <script>
        // Auto hide alert after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.bg-green-50');
            if (alert) {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 3000);
            }
        });

        // Add loading state for buttons
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const button = this.querySelector('button[type="submit"]');
                if (button) {
                    button.disabled = true;
                    button.innerHTML = button.innerHTML.includes('Loading') ? button.innerHTML : button.innerHTML + ' <span class="ml-2">...</span>';
                }
            });
        });

        // Add confirm dialog for delete actions
        document.querySelectorAll('form[action*="cart/"]').forEach(form => {
            if (form.querySelector('input[name="_method"][value="DELETE"]')) {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Yakin ingin menghapus produk ini dari keranjang?')) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
</body>
</html>
