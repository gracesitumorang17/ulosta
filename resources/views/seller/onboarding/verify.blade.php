<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Dokumen Verifikasi - Onboarding Penjual</title>
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

        .dropzone {
            border: 1px solid #d1d5db;
            background: #fafafa;
            border-radius: 0.75rem;
            padding: 1rem;
            color: #6b7280;
        }

        .dz-inner {
            border: 2px dashed #d1d5db;
            border-radius: 0.75rem;
            padding: 1rem;
            text-align: center;
            background: #fff;
        }

        .dz-icon {
            width: 24px;
            height: 24px;
            color: #6b7280;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">
</head>

<body class="min-h-screen bg-white text-gray-800">
    <div class="max-w-3xl mx-auto px-6 py-12">
        <div class="flex items-center gap-3 mb-8 justify-center">
            <div
                class="w-11 h-11 rounded-xl bg-(--brand-red-600) text-white flex items-center justify-center font-extrabold text-lg">
                U</div>
            <div class="text-xl font-semibold">UlosTa</div>
        </div>

        <div class="rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8">
            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 text-red-700 text-sm px-4 py-3">
                    @foreach ($errors->all() as $err)
                        <div>{{ $err }}</div>
                    @endforeach
                </div>
            @endif
            <div class="mb-6">
                <h1 class="text-xl md:text-2xl font-semibold">Dokumen verifikasi</h1>
                <p class="text-sm text-gray-500">Langkah 5 dari 5</p>
            </div>

            <div class="mb-4 rounded-xl border border-indigo-200 bg-indigo-50 text-indigo-700 text-sm px-4 py-3">
                <div class="font-semibold">Verifikasi Identitas</div>
                <div>Dokumen ini diperlukan untuk memverifikasi identitas Anda sebagai penjual terpercaya</div>
            </div>

            @php($store = session('seller_store', []))

            <form method="POST" action="{{ route('seller.onboarding.verify.save') }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                <div>
                    <label class="label">Nomor KTP</label>
                    <input type="text" name="ktp_number" placeholder="1234567890123456"
                        value="{{ old('ktp_number', $store['ktp_number'] ?? '') }}" class="input" />
                    <p class="text-xs text-gray-500 mt-1">16 digit</p>
                </div>

                <div>
                    <div class="label">Kartu Tanda Penduduk</div>
                    <p class="text-xs text-gray-500 mb-2">Upload foto KTP Anda yang masih berlaku</p>
                    <div class="dropzone">
                        <div class="dz-inner">
                            <svg class="dz-icon" viewBox="0 0 24 24" fill="none">
                                <path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                            <div class="mt-2 text-sm">Klik untuk Upload atau drag & drop</div>
                            <div class="text-xs text-gray-500">PNG, JPG, PDF (Maks 5 MB)</div>
                            <input type="file" name="ktp_photo" accept=".png,.jpg,.jpeg,.pdf" class="mt-3" />
                        </div>
                    </div>
                </div>

                <div>
                    <div class="label">Foto Selfie dengan KTP</div>
                    <p class="text-xs text-gray-500 mb-2">Upload foto selfie Anda sambil memegang KTP di samping wajah
                    </p>
                    <div class="dropzone">
                        <div class="dz-inner">
                            <svg class="dz-icon" viewBox="0 0 24 24" fill="none">
                                <path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                            <div class="mt-2 text-sm">Klik untuk Upload atau drag & drop</div>
                            <div class="text-xs text-gray-500">PNG, JPG, PDF (Maks 5 MB)</div>
                            <input type="file" name="selfie_photo" accept=".png,.jpg,.jpeg,.pdf" class="mt-3" />
                        </div>
                    </div>
                </div>

                <div>
                    <div class="label">Foto Toko/Tempat Usaha</div>
                    <p class="text-xs text-gray-500 mb-2">Upload foto toko fisik atau tempat usaha Anda (jika ada)</p>
                    <div class="dropzone">
                        <div class="dz-inner">
                            <svg class="dz-icon" viewBox="0 0 24 24" fill="none">
                                <path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                            <div class="mt-2 text-sm">Klik untuk Upload atau drag & drop</div>
                            <div class="text-xs text-gray-500">PNG, JPG, PDF (Maks 5 MB)</div>
                            <input type="file" name="store_photo" accept=".png,.jpg,.jpeg,.pdf" class="mt-3" />
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-yellow-200 bg-yellow-50 text-yellow-700 text-sm px-4 py-3">
                    <div class="font-medium">Dokumen Belum Lengkap</div>
                    <ul class="list-disc ml-5 mt-1 text-xs">
                        <li>Upload foto KTP Anda</li>
                        <li>Nomor KTP harus 16 digit</li>
                        <li>Upload foto selfie dengan KTP</li>
                    </ul>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('seller.onboarding.bank') }}"
                        class="btn-outline inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold">Kembali</a>
                    <button type="submit"
                        class="btn-red inline-flex items-center justify-center px-6 py-2.5 rounded-xl text-sm font-semibold">Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
