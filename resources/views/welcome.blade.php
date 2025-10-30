<?php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UlosTa</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
      @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
      <!-- Tailwind fallback bawaan Laravel 11 (biarkan agar utilitas Tailwind berfungsi tanpa build) -->
      <style>
        /*! tailwindcss v4 minimal fallback (dipersingkat) */
        html{line-height:1.5}*,*:before,*:after{box-sizing:border-box;border:0 solid}img,video{max-width:100%;height:auto;display:block}
      </style>
      <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
      body{font-family:Inter,system-ui,Segoe UI,Roboto,Arial,sans-serif}
    </style>
  </head>
  <body class="bg-white text-gray-800">
    <!-- Header -->
    <header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b">
      <div class="max-w-6xl mx-auto h-16 px-4 flex items-center gap-4">
        <a href="/" class="flex items-center gap-2 font-semibold text-gray-900">
          <span class="w-8 h-8 rounded-lg bg-red-600 text-white grid place-items-center">U</span>
          <span>UlosTa</span>
        </a>

        <!-- Search -->
        <form class="flex-1 max-w-xl ml-2">
          <label class="relative block">
            <input
              class="w-full border rounded-lg pl-10 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20"
              placeholder="Cari produk ulos terbaik..." />
            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m21 21-4.35-4.35M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16z"/>
            </svg>
          </label>
        </form>

        <nav class="hidden md:flex items-center gap-5">
          <a class="text-sm hover:text-red-600" href="#">Home</a>
          <a class="text-sm hover:text-red-600" href="#">Produk</a>
          <a class="text-sm hover:text-red-600" href="#">Kontak</a>
          <a class="inline-flex items-center bg-red-600 text-white rounded-lg px-4 py-2 text-sm hover:brightness-95" href="#">Daftar</a>
        </nav>
      </div>
    </header>

    <main>
      <!-- Hero -->
      <section class="max-w-6xl mx-auto px-4 mt-6">
        <div class="relative h-[260px] md:h-[320px] rounded-2xl overflow-hidden">
          <img class="absolute inset-0 w-full h-full object-cover"
               src="https://images.unsplash.com/photo-1581864724858-8bafad6f6f6a?q=80&w=1920&auto=format&fit=crop"
               alt="Banner Ulos">
          <div class="absolute inset-0 bg-black/45"></div>
          <div class="relative z-10 p-6 md:p-10 text-white max-w-xl">
            <h1 class="text-2xl md:text-4xl font-bold leading-tight">Jual Beli Ulos dengan Mudah</h1>
            <p class="mt-3 text-sm md:text-base text-white/90">
              Temukan koleksi ulos autentik dari perajin, kurasi terbaik, dan harga terjangkau.
            </p>
            <div class="mt-4 flex gap-3">
              <a class="inline-flex items-center bg-red-600 text-white rounded-lg px-4 py-2 text-sm hover:brightness-95" href="#">
                Belanja Sekarang
              </a>
              <a class="inline-flex items-center px-4 py-2 text-sm rounded-lg bg-white/10 hover:bg-white/20 backdrop-blur" href="#">
                Pelajari Lebih Lanjut
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Kategori Pilihan -->
      <section class="max-w-6xl mx-auto px-4 mt-10">
        <div class="flex flex-col items-center text-center mb-6">
          <span class="px-3 py-1 text-xs rounded-full bg-amber-100 text-amber-700">Kategori Pilihan</span>
          <h2 class="mt-3 text-2xl md:text-3xl font-bold">Temukan Ulos Anda</h2>
          <p class="mt-2 text-gray-600 text-sm">Jelajahi koleksi berdasarkan jenis dan fungsi upacara.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
          <!-- Kartu 1 -->
          <article class="relative rounded-2xl overflow-hidden shadow-sm">
            <img class="absolute inset-0 w-full h-full object-cover"
                 src="https://images.unsplash.com/photo-1622396090030-dacc5c35e2df?q=80&w=1600&auto=format&fit=crop"
                 alt="Jenis Ulos">
            <div class="absolute inset-0 bg-black/35"></div>
            <div class="relative z-10 p-5 text-white">
              <h3 class="text-lg font-semibold">Jenis Ulos Adat</h3>
              <ul class="mt-3 text-sm space-y-1 text-white/90">
                <li>• Ulos Ragidup</li>
                <li>• Ulos Bintang</li>
                <li>• Ulos Ragi Idup</li>
              </ul>
            </div>
          </article>

          <!-- Kartu 2 -->
          <article class="relative rounded-2xl overflow-hidden shadow-sm">
            <img class="absolute inset-0 w-full h-full object-cover"
                 src="https://images.unsplash.com/photo-1518843875459-f738682238a6?q=80&w=1600&auto=format&fit=crop"
                 alt="Fungsi Ulos">
            <div class="absolute inset-0 bg-black/35"></div>
            <div class="relative z-10 p-5 text-white">
              <h3 class="text-lg font-semibold">Fungsi Ulos</h3>
              <ul class="mt-3 text-sm space-y-1 text-white/90">
                <li>• Perkawinan</li>
                <li>• Kelahiran</li>
                <li>• Upacara Adat</li>
              </ul>
            </div>
          </article>
        </div>
      </section>

      <!-- Produk Pilihan -->
      <section class="max-w-6xl mx-auto px-4 mt-12">
        <div class="flex flex-col items-center text-center mb-6">
          <span class="px-3 py-1 text-xs rounded-full bg-amber-100 text-amber-700">Produk Pilihan</span>
          <h2 class="mt-3 text-2xl md:text-3xl font-bold">Koleksi Ulos Terbaik</h2>
        </div>

        @php
          $items = [
            ['title'=>'Ulos Ragidup','img'=>'https://images.unsplash.com/photo-1612152607435-8f266a9c4d7b?q=80&w=1200&auto=format&fit=crop','price'=>350000,'seller'=>'Toko A'],
            ['title'=>'Ulos Bintang','img'=>'https://images.unsplash.com/photo-1601582585289-3c4063c947c2?q=80&w=1200&auto=format&fit=crop','price'=>420000,'seller'=>'Toko B'],
            ['title'=>'Ulos Ragi Hotang','img'=>'https://images.unsplash.com/photo-1545239351-1141bd82e8a6?q=80&w=1200&auto=format&fit=crop','price'=>390000,'seller'=>'Toko C'],
            ['title'=>'Ulos Sadum','img'=>'https://images.unsplash.com/photo-1516826957135-700dedea698c?q=80&w=1200&auto=format&fit=crop','price'=>310000,'seller'=>'Toko D'],
            ['title'=>'Ulos Sibolang','img'=>'https://images.unsplash.com/photo-1607706189992-eae578626c87?q=80&w=1200&auto=format&fit=crop','price'=>450000,'seller'=>'Toko E'],
            ['title'=>'Ulos Mangiring','img'=>'https://images.unsplash.com/photo-1520975954732-35dd222996f2?q=80&w=1200&auto=format&fit=crop','price'=>330000,'seller'=>'Toko F'],
          ];
        @endphp

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          @foreach ($items as $p)
            <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
              <div class="aspect-[4/3] overflow-hidden">
                <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}"
                     class="w-full h-full object-cover hover:scale-105 transition duration-300">
              </div>
              <div class="p-4">
                <div class="flex items-start justify-between gap-3">
                  <h3 class="font-semibold text-base">{{ $p['title'] }}</h3>
                  <button class="text-sm px-2 py-1 rounded-md bg-rose-50 text-rose-600 hover:bg-rose-100">♥</button>
                </div>
                <p class="text-sm text-gray-500 mt-1">{{ $p['seller'] }}</p>
                <div class="mt-3 flex items-center justify-between">
                  <span class="font-bold text-red-600">Rp{{ number_format($p['price'],0,',','.') }}</span>
                  <button class="inline-flex items-center bg-red-600 text-white rounded-lg px-3 py-1.5 text-sm hover:brightness-95">
                    Tambah
                  </button>
                </div>
              </div>
            </article>
          @endforeach
        </div>

        <div class="mt-8 text-center">
          <a href="#" class="px-4 py-2 rounded-lg border hover:bg-gray-50 text-sm">Muat lebih banyak</a>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer class="mt-16 bg-gray-900 text-gray-300">
      <div class="max-w-6xl mx-auto px-4 py-10 grid md:grid-cols-4 gap-8">
        <div>
          <div class="flex items-center gap-2 font-semibold text-white mb-3">
            <span class="w-8 h-8 rounded-lg bg-red-600 text-white grid place-items-center">U</span>
            <span>UlosTa</span>
          </div>
          <p class="text-sm">Jelajah pilihan ulos terbaik dari perajin Nusantara.</p>
        </div>
        <div>
          <h4 class="text-white font-semibold mb-3">Tentang</h4>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="hover:text-white">Profil</a></li>
            <li><a href="#" class="hover:text-white">Partner</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-white font-semibold mb-3">Bantuan</h4>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="hover:text-white">FAQ</a></li>
            <li><a href="#" class="hover:text-white">Kebijakan</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-white font-semibold mb-3">Kontak</h4>
          <p class="text-sm">Email: support@ulosta.local</p>
        </div>
      </div>
      <div class="border-t border-white/10">
        <div class="max-w-6xl mx-auto px-4 py-4 text-xs text-gray-400">© {{ date('Y') }} UlosTa. All rights reserved.</div>
      </div>
    </footer>
  </body>
</html>