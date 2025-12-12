<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Instruksi Pembayaran - UlosTa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --brand-red-50: #FDEAEA;
            --brand-red-600: #AE0808;
            --brand-red-700: #8F0606;
            --brand-red-800: #6F0404;
        }

        .bg-red-600 {
            background-color: var(--brand-red-600) !important;
        }

        .bg-red-700 {
            background-color: var(--brand-red-700) !important;
        }

        .text-red-600 {
            color: var(--brand-red-600) !important;
        }

        .border-red-600 {
            border-color: var(--brand-red-600) !important;
        }

        .hover\:bg-red-700:hover {
            background-color: var(--brand-red-700) !important;
        }

        .hover\:bg-red-50:hover {
            background-color: var(--brand-red-50) !important;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased">
    <!-- Header -->
    <header class="bg-white border-b sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('homepage') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-md bg-red-600 flex items-center justify-center text-white font-bold">U
                </div>
                <span class="text-lg font-semibold">UlosTa</span>
            </a>

            <div class="flex items-center gap-6">
                <a href="{{ route('homepage') }}" class="flex items-center gap-2 text-gray-600 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-sm font-medium">Home</span>
                </a>

                <a href="{{ route('wishlist.index') }}"
                    class="flex items-center gap-2 text-gray-600 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span class="text-sm font-medium">Wishlist</span>
                </a>

                <a href="{{ route('keranjang') }}" class="flex items-center gap-2 text-gray-600 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 6.8a1 1 0 00.9 1.2H19m-7 4a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                    </svg>
                    <span class="text-sm font-medium">Keranjang</span>
                </a>

                <button class="flex items-center gap-2 text-gray-600 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-sm font-medium">Profil</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Profile Dropdown Menu (Hidden by default) -->
    <div id="profileDropdown"
        class="hidden fixed top-16 right-4 sm:right-8 lg:right-24 bg-white rounded-lg shadow-xl border border-gray-200 w-64 z-50">
        <div class="p-4 border-b border-gray-200">
            <div class="text-sm font-semibold text-gray-900">Akun Saya</div>
            <div class="text-xs text-gray-500 mt-1">Pembeli</div>
        </div>
        <div class="py-2">
            <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-sm text-gray-700">Profil saya</span>
            </a>
            <a href="{{ route('wishlist.index') }}"
                class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span class="text-sm text-gray-700">Wishlist Saya</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span class="text-sm text-gray-700">Pesanan Saya</span>
            </a>
        </div>
        <div class="border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-3 px-4 py-3 hover:bg-red-50 transition w-full text-left">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="text-sm text-red-600 font-medium">Keluar</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-screen">
        <h1 class="text-3xl font-bold mb-8">Menunggu Pembayaran</h1>

        <!-- Status Section -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-6 text-center">
            <!-- Clock Icon -->
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <h2 class="text-xl font-bold mb-2">Menunggu Pembayaran</h2>
            <p class="text-gray-600 mb-1">Selesaikan pembayaran sebelum
                {{ \Carbon\Carbon::parse($order->created_at)->addHours(24)->format('d M Y, H:i') }} WIB</p>
        </div>

        <!-- Payment Method Section -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Mandiri Virtual Account</h3>
                <span class="text-sm text-blue-600 font-medium">Menunggu pembayaran</span>
            </div>

            <!-- Virtual Account Number -->
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-2">Nomor Virtual Account</label>
                <div class="flex items-center gap-2">
                    <input type="text" value="8851 2345 6789 0123" readonly
                        class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg font-mono text-lg font-semibold" />
                    <button onclick="copyToClipboard('8851 2345 6789 0123')"
                        class="p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition" title="Salin">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-2">Nomor Virtual Account ini sudah termasuk kode unik</p>
            </div>

            <!-- Total Payment -->
            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-2">Jumlah transfer</label>
                <div class="flex items-center gap-2">
                    <input type="text" value="Rp {{ number_format($order->total_amount, 0, ',', '.') }}" readonly
                        class="flex-1 px-4 py-3 bg-red-50 border border-red-200 rounded-lg text-lg font-bold text-red-600" />
                    <button onclick="copyToClipboard('{{ $order->total_amount }}')"
                        class="p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition" title="Salin">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Payment Instructions -->
            <div class="border-t pt-4">
                <h4 class="font-semibold mb-3">Cara Pembayaran:</h4>
                <div class="space-y-3">
                    <div class="flex gap-3">
                        <div
                            class="w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center flex-shrink-0 text-sm font-semibold">
                            1</div>
                        <p class="text-sm text-gray-700">Buka aplikasi Livin' by Mandiri atau kunjung ATM Mandiri
                            terdekat</p>
                    </div>
                    <div class="flex gap-3">
                        <div
                            class="w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center flex-shrink-0 text-sm font-semibold">
                            2</div>
                        <p class="text-sm text-gray-700">Pilih menu <span class="font-semibold">Bayar/Beli</span> →
                            <span class="font-semibold">Virtual Account</span>
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <div
                            class="w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center flex-shrink-0 text-sm font-semibold">
                            3</div>
                        <p class="text-sm text-gray-700">Masukkan nomor Virtual Account: <span
                                class="font-semibold font-mono">8851 2345 6789 0123</span></p>
                    </div>
                    <div class="flex gap-3">
                        <div
                            class="w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center flex-shrink-0 text-sm font-semibold">
                            4</div>
                        <p class="text-sm text-gray-700">Konfirmasi pembayaran sebesar <span
                                class="font-semibold text-red-600">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</span></p>
                    </div>
                    <div class="flex gap-3">
                        <div
                            class="w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center flex-shrink-0 text-sm font-semibold">
                            5</div>
                        <p class="text-sm text-gray-700">Simpan bukti pembayaran untuk konfirmasi</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h3>

            <!-- Product Items -->
            <div class="space-y-4 mb-6">
                @foreach ($order->items as $item)
                    <div class="flex gap-4">
                        <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                            @if ($item->product_image)
                                <img src="{{ asset('storage/' . ltrim($item->product_image, '/')) }}"
                                    alt="{{ $item->product_name }}" class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-sm">{{ $item->product_name }}</h4>
                            <p class="text-sm font-semibold text-red-600 mt-1">Rp
                                {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Price Details -->
            <div class="border-t pt-4 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Ongkos Kirim</span>
                    <span class="text-green-600">
                        @if ($order->shipping_cost == 0)
                            Gratis
                        @else
                            Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                        @endif
                    </span>
                </div>
                <div class="border-t pt-2 flex justify-between font-bold">
                    <span>Total</span>
                    <span class="text-red-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Info Banner -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-blue-800">
                <span class="font-semibold">Penting:</span> Pembayaran akan diverifikasi otomatis setelah berhasil.
                Jika ada kendala, hubungan customer service kami.
            </p>
        </div>

        <!-- Action Buttons: dinamis nomor WA penjual dan cap waktu submit bukti -->
        <div class="space-y-3">
            <a href="{{ route('profil') }}?tab=pesanan&status=pending"
                class="block w-full text-center bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition font-medium">
                Lihat Pesanan Saya
            </a>

            @php
                // Ambil nomor WA penjual secara prioritas dari relasi Order->seller
                $sellerPhone =
                    optional($order->seller)->phone ??
                    (optional(optional($order->items->first())->product->seller)->phone ?? null);
                // Normalisasi ke format WhatsApp (msisdn, intl)
                $cleanPhone = $sellerPhone ? preg_replace('/\D+/', '', $sellerPhone) : null;
                if ($cleanPhone && str_starts_with($cleanPhone, '0')) {
                    $cleanPhone = '62' . substr($cleanPhone, 1);
                }
                $waText = urlencode(
                    'Halo, ini bukti pembayaran untuk order #' .
                        ($order->order_number ?? $order->id) .
                        ' sejumlah Rp ' .
                        number_format($order->total_amount, 0, ',', '.') .
                        '. Mohon verifikasi.',
                );
                $waUrl = $cleanPhone ? 'https://wa.me/' . $cleanPhone . '?text=' . $waText : null;
            @endphp

            <button id="btn-wa"
                class="block w-full text-center border border-yellow-600 text-yellow-700 py-3 rounded-lg hover:bg-yellow-50 transition font-medium">
                Konfirmasi via WhatsApp
            </button>

            <a href="{{ route('homepage') }}"
                class="block w-full text-center border border-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-50 transition font-medium">
                Kembali ke Beranda
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-neutral-900 text-neutral-300 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 rounded-md bg-red-600 flex items-center justify-center text-white font-bold">
                            U</div>
                        <span class="text-lg font-semibold text-white">UlosTa</span>
                    </div>
                    <p class="text-sm text-neutral-400">Platform jual beli Ulos terpercaya untuk melestarikan tradisi
                        Batak</p>
                    <div class="flex gap-3 mt-4">
                        <a href="#"
                            class="w-8 h-8 rounded-full bg-neutral-800 flex items-center justify-center hover:bg-neutral-700 transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-8 h-8 rounded-full bg-neutral-800 flex items-center justify-center hover:bg-neutral-700 transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-8 h-8 rounded-full bg-neutral-800 flex items-center justify-center hover:bg-neutral-700 transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                    </div>
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
                        <li><a href="#" class="hover:text-white transition">Bagianbagi</a></li>
                        <li><a href="#" class="hover:text-white transition">Bintang Maratur</a></li>
                        <li><a href="#" class="hover:text-white transition">Sibolang</a></li>
                        <li><a href="#" class="hover:text-white transition">Semua Produk</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-white mb-4">Hubungi Kami</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start gap-2">
                            <span class="text-neutral-500">A.</span>
                            <span>Jl.Sisingamangaraja No.123 Medan, Sumatera Utara</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-neutral-500">E.</span>
                            <span>ppw@gmail.com</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-neutral-500">T.</span>
                            <span>+62 812 3456 7890</span>
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
        function copyToClipboard(text) {
            // Remove formatting for copy
            const cleanText = text.replace(/[^\d]/g, '');
            navigator.clipboard.writeText(cleanText).then(function() {
                alert('Berhasil disalin!');
            }, function(err) {
                console.error('Gagal menyalin: ', err);
            });
        }

        // Toggle profile dropdown
        const lastButton = document.querySelectorAll('header button')[document.querySelectorAll('header button').length -
            1];
        const profileDropdown = document.getElementById('profileDropdown');

        lastButton.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!profileDropdown.contains(e.target) && !lastButton.contains(e.target)) {
                profileDropdown.classList.add('hidden');
            }
        });

        // Konfirmasi via WhatsApp: tandai submit lalu buka WA penjual
        (function() {
            const btnWa = document.getElementById('btn-wa');
            if (!btnWa) return;
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            btnWa.addEventListener('click', async () => {
                try {
                    await fetch('{{ route('orders.payment-proof.submitted', $order->id) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        }
                    });
                } catch (e) {
                    /* ignore */ }
                const url = {!! json_encode($waUrl) !!};
                if (url) {
                    window.open(url, '_blank');
                } else {
                    alert('Nomor WhatsApp penjual belum tersedia.');
                }
            });
        })();
    </script>
</body>

</html>
