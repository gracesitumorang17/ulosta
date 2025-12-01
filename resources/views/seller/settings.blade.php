@php($title = 'Pengaturan Toko')
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }} - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            /* Sinkron dengan dashboard */
            --brand-red-50: #FDEAEA;
            --brand-red-300: #EFA3A3;
            --brand-red-600: #AE0808;
            --brand-red-700: #8F0606;
            --brand-red-800: #6F0404;
            --gold-500: #f5b400;
            --gold-600: #d89d00;
            --gold-700: #b48300;
        }

        .btn-pill {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-weight: 600;
            padding: .55rem 1.05rem;
            border-radius: 9999px;
            font-size: .85rem;
            line-height: 1.1;
            background: var(--brand-red-600);
            color: #fff;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, .06), 0 1px 2px rgba(0, 0, 0, .1)
        }

        .btn-pill:hover {
            background: var(--brand-red-700)
        }

        .btn-outline-red {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-weight: 600;
            padding: .55rem 1.05rem;
            border-radius: 9999px;
            font-size: .85rem;
            line-height: 1.1;
            border: 1px solid var(--brand-red-300);
            color: var(--brand-red-700);
            background: #fff
        }

        .btn-outline-red:hover {
            background: var(--brand-red-50);
            border-color: var(--brand-red-400)
        }

        .btn-gold {
            background: var(--gold-500);
            color: #222;
            font-weight: 600;
            padding: .65rem 1.4rem;
            border-radius: .65rem;
            font-size: .9rem;
            display: inline-flex;
            align-items: center;
            gap: .6rem
        }

        .btn-gold:hover {
            background: var(--gold-600)
        }

        .form-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1.35rem 1.35rem 1.6rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .05)
        }

        .form-label {
            font-size: .72rem;
            letter-spacing: .05em;
            text-transform: uppercase;
            font-weight: 600;
            color: #374151;
            margin-bottom: .35rem;
            display: block
        }

        .input-soft {
            width: 100%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: .65rem;
            padding: .65rem .9rem;
            font-size: .85rem;
            font-weight: 500;
            color: #111827
        }

        .input-soft:focus {
            outline: 2px solid var(--brand-red-300);
            outline-offset: 2px
        }

        .section-title {
            display: flex;
            align-items: center;
            font-weight: 600;
            font-size: .9rem;
            color: #111827;
            margin-bottom: .9rem;
            gap: .55rem
        }

        .badge-icon {
            height: 2.4rem;
            width: 2.4rem;
            border-radius: .9rem;
            background: var(--brand-red-600);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .12)
        }

        .field-helper {
            font-size: .65rem;
            color: #6b7280;
            margin-top: .25rem
        }

        .sticky-action {
            position: sticky;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(248, 250, 252, .75), #f8fafc);
            backdrop-filter: blur(6px);
            padding: 1rem 0 0;
            margin-top: 1.5rem
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50 flex flex-col">
    <!-- NAVBAR (partial) -->
    @include('seller.partials.navbar')
    <!-- MAIN -->
    <main class="flex-1 pb-10">
        <div class="max-w-7xl mx-auto px-4 lg:px-6">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pt-8 mb-6">
                <div class="flex items-start gap-4">
                    <div class="badge-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9.6 19a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 5 15.4a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 5 9.6a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9.6 5a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09A1.65 1.65 0 0 0 15 5c.7 0 1.34-.27 1.82-.75l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06c-.48.48-.75 1.12-.75 1.82 0 .7.27 1.34.75 1.82l.06.06c.48.48.75 1.12.75 1.82z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl md:text-2xl font-semibold tracking-tight text-gray-900">Pengaturan Toko</h1>
                        <p class="text-xs md:text-sm text-gray-600 mt-1">Kelola identitas, kontak, dan media sosial toko
                            Anda.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 md:gap-3">
                    <a href="{{ route('seller.dashboard') }}" class="btn-outline-red">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('seller.settings.save') }}" class="space-y-8">
                @csrf
                <!-- Informasi Dasar -->
                <div class="form-card">
                    <div class="section-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18v4H3zM5 8v12h14V8" />
                        </svg>
                        <span>Informasi Dasar</span>
                    </div>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="form-label">Logo Toko</label>
                            <div
                                class="aspect-square w-28 rounded-xl bg-gray-100 border border-dashed border-gray-300 flex items-center justify-center text-gray-500 text-xs font-semibold mb-2">
                                LOGO</div>
                            <button type="button" class="text-xs font-semibold text-red-600 hover:text-red-700">Ganti
                                Logo</button>
                        </div>
                        <div class="md:col-span-2 space-y-5">
                            <div>
                                <label class="form-label">Nama Toko</label>
                                <input type="text" name="name" value="{{ $store['name'] ?? '' }}"
                                    class="input-soft" />
                            </div>
                            <div>
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description" rows="4" class="input-soft resize-none">{{ $store['description'] ?? '' }}</textarea>
                                <div class="field-helper">Gunakan deskripsi singkat yang informatif.</div>
                            </div>
                            <div>
                                <label class="form-label">Fokus Toko</label>
                                <input type="text" name="focus" value="{{ $store['focus'] ?? '' }}"
                                    class="input-soft" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Kontak -->
                <div class="form-card">
                    <div class="section-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.25 6 12 9.75 12 .734 0 1.463-.108 2.178-.314a.75.75 0 0 0 .508-.553l.433-1.732a.75.75 0 0 1 .54-.565l2.548-.637a.75.75 0 0 0 .55-.51 11.95 11.95 0 0 0 .243-5.818.75.75 0 0 0-.253-.47L15.62 4.743a.75.75 0 0 0-.622-.162 12.035 12.035 0 0 0-4.116 1.489L8.742 5.5a.75.75 0 0 0-.836.207L2.5 11.5" />
                        </svg>
                        <span>Informasi Kontak</span>
                    </div>
                    <div class="space-y-5">
                        <div>
                            <label class="form-label">Alamat</label>
                            <input type="text" name="address" value="{{ $store['address'] ?? '' }}"
                                class="input-soft" />
                        </div>
                        <div class="grid md:grid-cols-3 gap-5">
                            <div>
                                <label class="form-label">Telepon</label>
                                <input type="text" name="phone" value="{{ $store['phone'] ?? '' }}"
                                    class="input-soft" />
                            </div>
                            <div>
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ $store['email'] ?? '' }}"
                                    class="input-soft" />
                            </div>
                            <div>
                                <label class="form-label">Jam Operasional</label>
                                <input type="text" name="hours" value="{{ $store['hours'] ?? '' }}"
                                    class="input-soft" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media Sosial -->
                <div class="form-card">
                    <div class="section-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v16H4z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 9h6v6H9z" />
                        </svg>
                        <span>Media Sosial</span>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Instagram</label>
                            <input type="text" name="instagram" placeholder="@username" class="input-soft" />
                        </div>
                        <div>
                            <label class="form-label">Facebook</label>
                            <input type="text" name="facebook" placeholder="URL halaman" class="input-soft" />
                        </div>
                        <div>
                            <label class="form-label">TikTok</label>
                            <input type="text" name="tiktok" placeholder="@username" class="input-soft" />
                        </div>
                        <div>
                            <label class="form-label">YouTube</label>
                            <input type="text" name="youtube" placeholder="URL kanal" class="input-soft" />
                        </div>
                    </div>
                </div>

                <div class="sticky-action">
                    <div class="flex items-center justify-end gap-3">
                        <button type="button"
                            class="px-4 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-200">Batal</button>
                        <button type="submit" class="btn-gold">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12l5 5L20 7" />
                            </svg>
                            <span>Simpan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script>
        // Dropdown fallback for profile (without Alpine)
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('button');
            const wrapper = e.target.closest('[x-data]');
            document.querySelectorAll('[x-data] > div[x-show]').forEach(el => {
                if (!el.contains(e.target) && !el.previousElementSibling.contains(e.target)) {
                    el.style.display = 'none';
                }
            });
            if (btn && wrapper) {
                const menu = wrapper.querySelector('div[x-show]');
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            }
        });
    </script>
</body>

</html>
