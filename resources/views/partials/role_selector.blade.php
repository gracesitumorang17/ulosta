@php
    $show = auth()->check() && !session('role');
@endphp

<style>
    /* Minimal role selector modal styles */
    .role-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 60
    }

    .role-modal {
        width: 360px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        overflow: hidden
    }

    .role-modal-header {
        padding: 18px;
        border-bottom: 1px solid #eee
    }

    .role-modal-body {
        padding: 10px
    }

    .role-list {
        list-style: none;
        padding: 6px;
        margin: 0
    }

    .role-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-radius: 8px;
        margin: 8px;
        background: #fff;
        border: 1px solid #f0f0f0
    }

    .role-list li a {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: #111;
        width: 100%
    }

    .role-title {
        font-weight: 600
    }

    .role-sub {
        font-size: 13px;
        color: #888
    }

    .role-footer {
        padding: 10px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 8px
    }

    .btn-link {
        background: #fff;
        border: 1px solid #ddd;
        padding: 8px 12px;
        border-radius: 8px;
        text-decoration: none;
        color: #111
    }

    .btn-primary {
        background: #AE0808;
        color: #fff;
        padding: 8px 12px;
        border-radius: 8px;
        text-decoration: none
    }
</style>

<div id="role-modal-backdrop" class="role-modal-backdrop" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="role-modal" role="document">
        <div class="role-modal-header">
            <div style="font-size:18px;font-weight:700">Akun Saya</div>
            <div style="color:#9b9b9b;font-size:13px">Pilih peran untuk melanjutkan</div>
        </div>
        <div class="role-modal-body">
            <ul class="role-list">
                <li>
                    <a href="{{ url('/profile') }}">
                        <div
                            style="width:36px;height:36px;border-radius:50%;background:#fff;border:1px solid #eee;display:flex;align-items:center;justify-content:center">
                            👤</div>
                        <div>
                            <div class="role-title">Profil saya</div>
                            <div class="role-sub">Lihat & ubah profil</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/orders') }}">
                        <div
                            style="width:36px;height:36px;border-radius:50%;background:#fff;border:1px solid #eee;display:flex;align-items:center;justify-content:center">
                            🛒</div>
                        <div>
                            <div class="role-title">Pesanan Saya</div>
                            <div class="role-sub">Lihat pesanan sebagai pembeli</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/wishlist') }}">
                        <div
                            style="width:36px;height:36px;border-radius:50%;background:#fff;border:1px solid #eee;display:flex;align-items:center;justify-content:center">
                            ♡</div>
                        <div>
                            <div class="role-title">Wishlist</div>
                            <div class="role-sub">Produk yang disimpan</div>
                        </div>
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ url('/set-role') }}" style="width:100%">
                        @csrf
                        <input type="hidden" name="role" value="seller">
                        <button type="submit"
                            style="all:unset;cursor:pointer;display:flex;align-items:center;gap:12px;width:100%">
                            <div
                                style="width:36px;height:36px;border-radius:50%;background:#fff;border:1px solid #eee;display:flex;align-items:center;justify-content:center">
                                🏬</div>
                            <div>
                                <div class="role-title">Dashboard Toko</div>
                                <div class="role-sub">Kelola toko sebagai penjual</div>
                            </div>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        <div class="role-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-link">Keluar</button>
            </form>
            <button id="role-modal-close" class="btn-primary">Tutup</button>
        </div>
    </div>
</div>

<div id="role-selector" class="hidden">
    <!-- simple form untuk upgrade ke seller -->
    @auth
        @if(auth()->check() && auth()->user()->role !== 'seller')
            <form method="POST" action="{{ route('set.role') }}" class="px-4 py-3">
                @csrf
                <input type="hidden" name="role" value="seller">
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded">
                    Jadi Penjual
                </button>
            </form>
        @endif
    @endauth
</div>

<script>
    (function() {
        const show = {{ $show ? 'true' : 'false' }};
        const backdrop = document.getElementById('role-modal-backdrop');
        const closeBtn = document.getElementById('role-modal-close');
        if (!backdrop) return;

        function open() {
            backdrop.style.display = 'flex';
            backdrop.setAttribute('aria-hidden', 'false');
        }

        function close() {
            backdrop.style.display = 'none';
            backdrop.setAttribute('aria-hidden', 'true');
        }
        if (show) {
            open();
        }
        closeBtn?.addEventListener('click', close);
        backdrop.addEventListener('click', function(e) {
            if (e.target === backdrop) close();
        });
    })();
</script>
