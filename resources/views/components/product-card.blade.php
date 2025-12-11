<article class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition group h-full flex flex-col"
    data-aos="fade-up" data-aos-delay="{{ 40 * ($index + 1) }}">
    <div class="relative">
        <div class="ratio-3-2">
            <img src="{{ $p['image_url'] ?? ($p['image'] ? asset('storage/' . ltrim($p['image'], '/')) : asset('image/ulos1.jpeg')) }}"
                alt="{{ $p['name'] }}" class="w-full h-full object-cover" loading="lazy" />
        </div>

        <div class="absolute left-3 top-3">
            <span class="bg-red-600 text-white text-xs rounded-full px-3 py-1 font-medium">Terlaris</span>
        </div>

        <button
            class="absolute right-3 top-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:scale-105 transition"
            aria-label="Simpan favorit">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M20.8 6.6c-1.6-3-5.6-3.4-7.8-.9l-.9 1-.9-1C9 3.2 5 3.6 3.4 6.6-1 14 11.8 20.5 12 20.6c.2-.1 13-6.6 8.8-14z" />
            </svg>
        </button>
    </div>

    <div class="p-4 flex-1 flex flex-col">
        <div class="mb-2">
            <span
                class="inline-block bg-amber-100 text-amber-800 text-[11px] font-medium px-3 py-1 rounded-full tracking-wide">{{ $p['tag'] }}</span>
        </div>

        <h3 class="font-semibold text-gray-800 text-base">{{ $p['name'] }}</h3>
        <p class="text-sm text-gray-500 mt-1">{{ $p['desc'] }}</p>

        <div class="mt-3">
            <div class="text-red-600 font-semibold text-base">{{ $p['price'] }}</div>
        </div>

        <div class="my-3 border-t border-dashed border-gray-200"></div>

        <div class="mt-auto">
            <form method="GET" action="{{ route('tambah.ke.keranjang') }}">
                <button type="submit" data-name="{{ $p['name'] }}" data-price="{{ $p['price'] }}"
                    class="btn-add-to-cart w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-700 text-white rounded-md hover:bg-red-800 transition text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                        <circle cx="10" cy="20" r="1" />
                        <circle cx="18" cy="20" r="1" />
                    </svg>
                    Keranjang
                </button>
            </form>
        </div>
    </div>
</article>
