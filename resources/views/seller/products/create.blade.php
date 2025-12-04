<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Tambah Produk - ULOSTA Seller</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --brand-red-50: #FDEAEA;
            --brand-red-300: #EFA3A3;
            --brand-red-600: #AE0808;
            --brand-red-700: #8F0606;
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

        .hover\:bg-red-700:hover {
            background-color: var(--brand-red-700) !important;
        }

        .focus\:ring-red-300:focus {
            box-shadow: 0 0 0 4px rgba(239, 163, 163, .6) !important;
        }

        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0.85rem;
            padding: 1.25rem 1.25rem;
        }

        .card-header {
            font-weight: 600;
            margin-bottom: .85rem;
            font-size: .9rem;
        }

        .field-label {
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: #374151;
            margin-bottom: .35rem;
        }

        .input-base {
            width: 100%;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: .6rem;
            padding: .65rem .9rem;
            font-size: .75rem;
        }

        .tips-box {
            background: #faf9ea;
            border: 1px solid #f1e9c2;
            border-radius: .85rem;
            padding: 1.15rem;
        }

        .image-thumb {
            width: 160px;
            height: 160px;
            border-radius: .75rem;
            overflow: hidden;
            background: #f3f4f6;
            position: relative;
        }

        .image-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-main {
            position: absolute;
            left: .4rem;
            bottom: .4rem;
            background: rgba(0, 0, 0, .6);
            color: #fff;
            font-size: .55rem;
            padding: .25rem .4rem;
            border-radius: .4rem;
            letter-spacing: .05em;
            text-transform: uppercase;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50 text-gray-800">
    @include('seller.partials.navbar')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('seller.products.index') }}"
            class="inline-flex items-center text-xs font-medium text-gray-600 hover:text-gray-900 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>Kembali
        </a>

        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold mb-1">Tambah Produk</h1>
                <p class="text-sm text-gray-500">Buat produk baru untuk toko Anda</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-md">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data"
            class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @csrf
            <div class="lg:col-span-2 space-y-6">
                <div class="card">
                    <div class="card-header">Informasi Dasar</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="field-label">Nama Produk *</label>
                            <input type="text" name="name" class="input-base" value="{{ old('name') }}"
                                required />
                        </div>
                        <div>
                            <label class="field-label">Kategori *</label>
                            <select name="category" class="input-base" required>
                                <option value="Pernikahan" @selected(old('category') === 'Pernikahan')>Pernikahan</option>
                                <option value="Penghormatan" @selected(old('category') === 'Penghormatan')>Penghormatan</option>
                                <option value="Kematian" @selected(old('category') === 'Kematian')>Kematian</option>
                            </select>
                        </div>
                        <div>
                            <label class="field-label">Stok *</label>
                            <input type="number" name="stock" class="input-base" value="{{ old('stock') }}"
                                required />
                        </div>
                        <div>
                            <label class="field-label">Harga (Rp) *</label>
                            <input type="number" name="price" class="input-base" value="{{ old('price') }}"
                                required />
                        </div>
                        <div class="md:col-span-2">
                            <label class="field-label">Deskripsi Produk</label>
                            <textarea rows="4" name="description" class="input-base">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Detail Produk</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Bahan</label>
                            <input type="text" name="material" class="input-base" value="{{ old('material') }}" />
                        </div>
                        <div>
                            <label class="field-label">Ukuran</label>
                            <input type="text" name="size" class="input-base" value="{{ old('size') }}" />
                        </div>
                        <div>
                            <label class="field-label">Berat (gram)</label>
                            <input type="number" name="weight" class="input-base" value="{{ old('weight') }}" />
                        </div>
                        <div>
                            <label class="field-label">Asal Daerah</label>
                            <input type="text" name="origin" class="input-base" value="{{ old('origin') }}" />
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header flex items-center justify-between">
                        <span>Gambar Produk *</span>
                    </div>
                    <div class="space-y-4">
                        <label
                            class="w-full h-44 border border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center bg-gray-100 text-center text-xs text-gray-600 cursor-pointer hover:bg-gray-50">
                            <input type="file" name="images[]" multiple accept="image/png,image/jpg,image/jpeg"
                                class="hidden" />
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mb-2 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Klik untuk pilih gambar (multi)
                            <span class="mt-1 text-[10px] text-gray-400">PNG/JPG maks 2MB per file</span>
                        </label>
                        <p class="text-[11px] text-gray-500">Preview gambar akan muncul setelah disimpan di halaman
                            edit.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card">
                    <div class="card-header">Status Produk</div>
                    <label class="flex items-center gap-2 text-xs font-medium">
                        <input type="checkbox" name="status" value="1" class="rounded" checked /> Aktifkan
                        Produk
                    </label>
                    <p class="mt-2 text-[11px] text-gray-500">Produk aktif akan tampil di daftar.</p>
                </div>
                <div class="card space-y-3">
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-md py-2 focus:ring-red-300">Simpan
                        Produk</button>
                    <a href="{{ route('seller.products.index') }}"
                        class="w-full inline-flex justify-center rounded-md border border-gray-300 bg-white text-gray-700 text-sm font-medium py-2 hover:bg-gray-50">Batal</a>
                </div>
                <div class="tips-box text-sm">
                    <h3 class="font-semibold mb-2">Tips Produk Laris</h3>
                    <ul class="list-disc pl-5 space-y-1 text-[12px] text-gray-700">
                        <li>Gunakan foto berkualitas tinggi dengan pencahayaan baik</li>
                        <li>Tulis deskripsi detail tentang motif dan kegunaan Ulos</li>
                        <li>Cantumkan bahan dan ukuran dengan jelas</li>
                        <li>Tetapkan harga kompetitif</li>
                    </ul>
                </div>
            </div>
        </form>
    </main>
</body>

</html>
