<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Informasi Rekening - Onboarding Penjual</title>
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">
</head>

<body class="min-h-screen bg-white text-gray-800">
    <div class="max-w-3xl mx-auto px-6 py-12">
        <div class="flex items-center gap-3 mb-8 justify-center">
            <div
                class="w-11 h-11 rounded-xl bg-[var(--brand-red-600)] text-white flex items-center justify-center font-extrabold text-lg">
                U</div>
            <div class="text-xl font-semibold">UlosTa</div>
        </div>

        <div class="rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8">
            <div class="mb-6">
                <h1 class="text-xl md:text-2xl font-semibold">Informasi Rekening</h1>
                <p class="text-sm text-gray-500">Langkah 4 dari 5</p>
            </div>

            <div class="mb-4 rounded-xl border border-indigo-200 bg-indigo-50 text-indigo-700 text-sm px-4 py-3">
                Rekening ini akan digunakan untuk menerima pembayaran dari penjualan produk. Pastikan data yang
                dimasukkan benar.
            </div>

            @php($store = session('seller_store', []))

            <form method="POST" action="{{ route('seller.onboarding.bank.save') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="label">Bank</label>
                    <input type="text" name="bank_name" placeholder="Bank"
                        value="{{ old('bank_name', $store['bank_name'] ?? '') }}" class="input" />
                </div>

                <div>
                    <label class="label">Nomor Rekening</label>
                    <input type="text" name="bank_account" placeholder="123456789"
                        value="{{ old('bank_account', $store['bank_account'] ?? '') }}" class="input" />
                </div>

                <div>
                    <label class="label">Nama Pemilik Rekening</label>
                    <input type="text" name="bank_holder" placeholder="Sesuai dengan yang tertera di buku tabungan"
                        value="{{ old('bank_holder', $store['bank_holder'] ?? '') }}" class="input" />
                </div>

                <div class="mb-2 rounded-xl border border-yellow-200 bg-yellow-50 text-yellow-700 text-sm px-4 py-3">
                    Penting: Pastikan nama pemilik rekening sama dengan nama yang terdaftar di KTP Anda untuk
                    menghindari penolakan verifikasi.
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('seller.onboarding.address') }}"
                        class="btn-outline inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold">Kembali</a>
                    <button type="submit"
                        class="btn-red inline-flex items-center justify-center px-6 py-2.5 rounded-xl text-sm font-semibold">Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
