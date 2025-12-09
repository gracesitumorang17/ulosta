<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Edit Produk - ULOSTA Seller</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --brand-red-50: #FDEAEA;
            --brand-red-300: #EFA3A3;
            --brand-red-600: #AE0808;
            --brand-red-700: #8F0606;
            --gold-500: #f5b400;
            --gold-600: #d89d00;
            --gold-700: #b48300;
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

        .toggle-track {
            width: 38px;
            height: 20px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            padding: 0 2px;
            cursor: pointer;
        }

        .toggle-knob {
            width: 16px;
            height: 16px;
            border-radius: 9999px;
            background: #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .25);
            transition: transform .18s ease;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50 text-gray-800">
    @include('seller.partials.navbar')

    @php
        // Pastikan field tersedia
        $p = $product;
    @endphp

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-md">
                <strong class="block mb-1">Gagal menyimpan perubahan:</strong>
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-md">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('seller.products.index') }}"
            class="inline-flex items-center text-xs font-medium text-gray-600 hover:text-gray-900 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>

        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold mb-1">Edit Produk</h1>
                <p class="text-sm text-gray-500">Perbarui informasi produk Ulos</p>
            </div>
            <button type="button" id="openPreview"
                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-white border border-gray-300 text-xs font-medium text-gray-700 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                </svg>
                Preview Produk
            </button>
        </div>

        <form method="POST" action="{{ route('seller.products.update', $slugValue) }}" enctype="multipart/form-data"
            class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @csrf
            @method('PUT')
            <!-- Kolom kiri (2 kolom) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Dasar -->
                <div class="card">
                    <div class="card-header">Informasi Dasar</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="field-label">Nama Produk *</label>
                            <input type="text" name="name" class="input-base" value="{{ $p['name'] }}"
                                required />
                        </div>
                        <div>
                            <label class="field-label">Fungsi<label>
                                    <select name="category" class="input-base" required>
                                        @php $cat = $p['category']; @endphp
                                        <option value="Pernikahan" @selected($cat === 'Pernikahan')>Pernikahan</option>
                                        <option value="Kelahiran" @selected($cat === 'Kelahiran')>Kelahiran</option>
                                        <option value="Kematian" @selected($cat === 'Kematian')>Kematian</option>
                                        <option value="Syukuran" @selected($cat === 'Syukuran')>Syukuran</option>
                                        <option value="Serbaguna" @selected($cat === 'Serbaguna')>Serbaguna</option>
                                    </select>
                        </div>
                        <div>
                            <label class="field-label">Jenis Ulos</label>
                            <input type="text" name="jenis" class="input-base" value="{{ $p['jenis'] ?? '' }}" />
                        </div>
                        <div>
                            <label class="field-label">Stok *</label>
                            <input type="number" name="stock" class="input-base" value="{{ $p['stock'] }}"
                                required />
                        </div>
                        <div>
                            <label class="field-label">Harga (Rp) *</label>
                            <input type="number" name="price" class="input-base" value="{{ $p['price'] }}"
                                required />
                        </div>
                        <div class="md:col-span-2">
                            <label class="field-label">Deskripsi Produk</label>
                            <textarea rows="4" name="description" class="input-base">{{ $p['description'] }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Detail Produk -->
                <div class="card">
                    <div class="card-header">Detail Produk</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Bahan</label>
                            <input type="text" name="material" class="input-base" value="{{ $p['material'] }}" />
                        </div>
                        <div>
                            <label class="field-label">Ukuran</label>
                            <input type="text" name="size" class="input-base" value="{{ $p['size'] }}" />
                        </div>
                        <div>
                            <label class="field-label">Berat (gram)</label>
                            <input type="number" name="weight" class="input-base" value="{{ $p['weight'] }}" />
                        </div>
                        <div>
                            <label class="field-label">Asal Daerah</label>
                            <input type="text" name="origin" class="input-base" value="{{ $p['origin'] }}" />
                        </div>
                    </div>
                </div>

                <!-- Gambar Produk -->
                <div class="card">
                    <div class="card-header flex items-center justify-between">
                        <span>Gambar Produk *</span>
                        @if (session('success'))
                            <span class="text-[11px] text-green-600 font-medium">{{ session('success') }}</span>
                        @endif
                    </div>
                    <div class="space-y-4">
                        <label
                            class="w-full h-44 border border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center bg-gray-100 text-center text-xs text-gray-600 cursor-pointer hover:bg-gray-50">
                            <input id="imageInput" type="file" name="images[]" multiple
                                accept="image/png,image/jpg,image/jpeg" class="hidden" />
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mb-2 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Klik untuk pilih gambar (multi)
                            <span class="mt-1 text-[10px] text-gray-400">PNG/JPG maks 2MB per file</span>
                        </label>
                        <p class="text-[11px] text-gray-500">Preview gambar baru muncul saat memilih file.</p>
                        <div class="flex flex-wrap gap-4">
                            @if (!empty($uploaded))
                                <div class="image-thumb">
                                    <img src="{{ $uploaded[0] }}" alt="Gambar Saat Ini" />
                                    <span class="badge-main">GAMBAR</span>
                                </div>
                            @endif
                            <div id="incomingPreview" class="image-thumb" style="display:none">
                                <img id="incomingImg" src="" alt="Gambar Baru" />
                                <span class="badge-main">BARU</span>
                            </div>
                        </div>
                        <script>
                            (function() {
                                const input = document.getElementById('imageInput');
                                const incomingBox = document.getElementById('incomingPreview');
                                const incomingImg = document.getElementById('incomingImg');
                                if (!input) return;
                                input.addEventListener('change', function() {
                                    if (this.files && this.files.length > 0) {
                                        const file = this.files[0];
                                        const url = URL.createObjectURL(file);
                                        incomingImg.src = url;
                                        incomingBox.style.display = 'block';
                                    } else {
                                        incomingBox.style.display = 'none';
                                        incomingImg.src = '';
                                    }
                                });
                            })();
                        </script>
                    </div>
                </div>
            </div>

            <!-- Kolom kanan -->
            <div class="space-y-6">
                <div class="card">
                    <div class="card-header">Status Produk</div>
                    <label class="flex items-center gap-2 text-xs font-medium">
                        <input type="hidden" name="status" value="0" />
                        <input type="checkbox" name="status" value="1" class="rounded"
                            {{ $p['status'] ? 'checked' : '' }} /> Aktifkan Produk
                    </label>
                    <p class="mt-2 text-[11px] text-gray-500">Produk aktif akan tampil di daftar.</p>
                </div>

                <div class="card space-y-3">
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-md py-2 focus:ring-red-300">Simpan
                        Perubahan</button>
                    <a href="{{ route('seller.products.index') }}"
                        class="w-full inline-flex justify-center rounded-md border border-gray-300 bg-white text-gray-700 text-sm font-medium py-2 hover:bg-gray-50">Kembali</a>
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
    <!-- Modal Preview -->
    <div id="previewModal" class="fixed inset-0 bg-black/40 z-40 hidden">
        <div class="absolute inset-0 flex items-start justify-center pt-10 px-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-5xl overflow-hidden">
                <div class="flex items-center justify-between px-5 py-3 border-b">
                    <div>
                        <h2 class="text-lg font-semibold">Preview Produk</h2>
                        <p class="text-xs text-gray-500">Tampilan seperti yang dilihat pembeli</p>
                    </div>
                    <button type="button" id="closePreview" class="p-2 rounded-md hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8" class="w-5 h-5 text-gray-700">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="rounded-xl overflow-hidden bg-gray-100">
                            @if (!empty($uploaded))
                                <img src="{{ $uploaded[0] }}" alt="Preview Gambar"
                                    class="w-full h-72 object-cover" />
                            @else
                                <div class="w-full h-72 flex items-center justify-center text-xs text-gray-500">Tidak
                                    ada gambar</div>
                            @endif
                        </div>
                        <span
                            class="inline-block mt-3 text-[11px] bg-yellow-100 text-yellow-800 px-3 py-1 rounded-md">Produk
                            Aktif</span>
                    </div>
                    <div>
                        @php $cat = $p['category'] ?? null; @endphp
                        @if ($cat)
                            <span
                                class="inline-block text-[11px] bg-gray-200 text-gray-700 px-3 py-1 rounded-md mb-2">{{ $cat }}</span>
                        @endif
                        <h3 class="text-xl font-semibold">{{ $p['name'] }}</h3>
                        <div class="mt-2">
                            <span class="text-2xl text-red-600 font-bold">Rp
                                {{ number_format((float) ($p['price'] ?? 0), 0, ',', '.') }}</span>
                        </div>
                        <div class="mt-4 flex items-center justify-between text-sm">
                            <span class="text-gray-500">Ketersediaan</span>
                            @php $stock = $p['stock'] ?? 0; @endphp
                            <span class="text-green-600">Stok tersedia ({{ $stock }} pcs)</span>
                        </div>
                        <hr class="my-4" />
                        <div>
                            <h4 class="font-semibold mb-2">Deskripsi Produk</h4>
                            <p class="text-sm text-gray-700">{{ $p['description'] }}</p>
                        </div>
                        <div class="mt-4 card">
                            <div class="card-header">Detail Produk</div>
                            <ul class="space-y-2 text-sm">
                                @if (!empty($p['material']))
                                    <li><strong>Bahan:</strong> {{ $p['material'] }}</li>
                                @endif
                                @if (!empty($p['size']))
                                    <li><strong>Ukuran:</strong> {{ $p['size'] }}</li>
                                @endif
                                @if (!empty($p['weight']))
                                    <li><strong>Berat:</strong> {{ $p['weight'] }} gram</li>
                                @endif
                                @if (!empty($p['origin']))
                                    <li><strong>Asal Daerah:</strong> {{ $p['origin'] }}</li>
                                @endif
                                @if (!empty($p['jenis']))
                                    <li><strong>Jenis Ulos:</strong> {{ $p['jenis'] }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function() {
            const openBtn = document.getElementById('openPreview');
            const closeBtn = document.getElementById('closePreview');
            const modal = document.getElementById('previewModal');
            if (openBtn && modal) {
                openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
            }
            if (closeBtn && modal) {
                closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
            }
            // Close on backdrop click
            if (modal) {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) modal.classList.add('hidden');
                });
            }
        })();
    </script>
</body>

</html>
