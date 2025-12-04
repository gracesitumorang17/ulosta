<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Alamat Toko - Onboarding Penjual</title>
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

        .btn-outline {
            border: 1px solid var(--brand-red-600);
            color: var(--brand-red-600);
            background: #fff
        }

        .btn-outline:hover {
            background: #fff5f5
        }

        .input {
            width: 100%;
            border: 1px solid #e5e7eb;
            background: #f7f7f7;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }

        .label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            600: '#AE0808',
                            700: '#8F0606'
                        }
                    }
                }
            }
        };
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">
</head>

<body class="min-h-screen bg-white text-gray-800">
    <div class="max-w-3xl mx-auto px-6 py-12">
        <div class="flex items-center gap-3 mb-8 justify-center">
            <div
                class="w-11 h-11 rounded-xl bg-brand-600 text-white flex items-center justify-center font-extrabold text-lg">
                U</div>
            <div class="text-xl font-semibold">UlosTa</div>
        </div>

        <div class="rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8">
            <div class="mb-6">
                <h1 class="text-xl md:text-2xl font-semibold">Alamat Toko</h1>
                <p class="text-sm text-gray-500">Langkah 3 dari 5</p>
            </div>

            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-md">
                    {{ session('success') }}</div>
            @endif

            @php
                $store = session('seller_store', []);
            @endphp

            <form method="POST" action="{{ route('seller.onboarding.address.save') }}" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="label">Provinsi</label>
                        <input type="text" name="province" placeholder="Provinsi"
                            value="{{ old('province', $store['province'] ?? '') }}" class="input" />
                    </div>
                    <div>
                        <label class="label">Kota/Kabupaten</label>
                        <input type="text" name="city" placeholder="Kota/Kabupaten"
                            value="{{ old('city', $store['city'] ?? '') }}" class="input" />
                    </div>
                    <div>
                        <label class="label">Kecamatan</label>
                        <input type="text" name="district" placeholder="Nama Kecamatan"
                            value="{{ old('district', $store['district'] ?? '') }}" class="input" />
                    </div>
                    <div>
                        <label class="label">Kode Pos</label>
                        <input type="text" name="postal_code" placeholder="Kode Pos"
                            value="{{ old('postal_code', $store['postal_code'] ?? '') }}" class="input" />
                    </div>
                </div>

                <div>
                    <label class="label">Alamat Lengkap</label>
                    <textarea name="address" rows="5" placeholder="Nama jalan, nomor rumah, RT/RW, Kelurahan, dan patokan"
                        class="input">{{ old('address', $store['address'] ?? '') }}</textarea>
                    <p class="text-xs text-gray-500 mt-2">Alamat ini akan digunakan sebagai alamat
                        pengambilan/pengiriman produk.</p>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('seller.onboarding.info') }}"
                        class="btn-outline inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold">Kembali</a>
                    <button type="submit"
                        class="btn-red inline-flex items-center justify-center px-6 py-2.5 rounded-xl text-sm font-semibold">Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
