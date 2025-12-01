<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Informasi Toko - Onboarding Penjual</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --brand-red-600: #AE0808;
            --brand-red-700: #8F0606;
            --muted: #f7f7f7;
            --border: #e5e7eb;
        }

        .btn-red {
            background: var(--brand-red-600);
            color: #fff
        }

        .btn-red:hover {
            background: var(--brand-red-700)
        }
    </style>
</head>

<body class="min-h-screen bg-white text-gray-800">
    <div class="max-w-3xl mx-auto px-6 py-12">
        <div class="flex items-center gap-3 mb-8 justify-center">
            <div
                class="w-11 h-11 rounded-xl bg-[color:var(--brand-red-600)] text-white flex items-center justify-center font-extrabold text-lg">
                U</div>
            <div class="text-xl font-semibold">UlosTa</div>
        </div>

        <div class="rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8">
            <div class="mb-6">
                <h1 class="text-xl md:text-2xl font-semibold">Informasi Toko</h1>
                <p class="text-sm text-gray-500">Langkah 2 dari 5</p>
            </div>

            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-md">
                    {{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('seller.onboarding.info.save') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold mb-2">Nama Toko</label>
                    <input type="text" name="name" placeholder="Contoh: Toko Ulos Berkah" required
                        value="{{ old('name', $store['name'] ?? '') }}"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-200" />
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-2">Nama yang menarik akan membantu pembeli menemukan anda</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Fokus Toko</label>
                    <input type="text" name="focus" placeholder="Contoh: 'Ulos Adat', 'Ulos Modern', 'Ulos Antik'"
                        value="{{ old('focus', $store['focus'] ?? '') }}"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-200" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Deskripsi Toko</label>
                    <textarea name="description" rows="5" placeholder="Ceritakan tentang toko anda dan keunggulan toko anda"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-200">{{ old('description', $store['description'] ?? '') }}</textarea>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('homepage') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-gray-300 text-sm font-semibold">Kembali</a>
                    <button type="submit"
                        class="btn-red inline-flex items-center justify-center px-6 py-2.5 rounded-xl text-sm font-semibold">Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
