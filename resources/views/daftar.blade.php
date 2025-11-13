<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Daftar - UlosTa</title>
    <style>
        :root{
            --red:#AE0808;
            --muted:#f3f3f3;
            --border:#e2e2e2;
            --text:#2b2b2b;
            --radius:14px;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }
        body{
            margin:0;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            background: #fff;
            color:var(--text);
            padding:24px;
        }
        .card{
            width:380px;
            border-radius:16px;
            border:1px solid var(--border);
            padding:28px;
            box-shadow:0 6px 18px rgba(0,0,0,0.03);
        }
        .brand{
            display:flex;
            gap:10px;
            align-items:center;
            justify-content:center;
            margin-bottom:8px;
        }
        .logo{
            width:44px;height:44px;border-radius:10px;background:var(--red);display:inline-flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:20px;
        }
        h1{margin:6px 0 6px;font-size:22px;text-align:center;}
        p.lead{margin:0 0 18px;color:#767676;font-size:13px;text-align:center;}
        label{display:block;font-size:13px;margin:10px 0 6px;color:#555;font-weight:500;}
        .field{
            display:flex;
            align-items:center;
            gap:10px;
            background:#f7f7f7;
            padding:12px 14px;
            border-radius:10px;
            border:1px solid transparent;
            margin-bottom:12px;
        }
        .field input{
            border:0;background:transparent;outline:none;font-size:14px;width:100%;color:var(--text);
        }
        .field input::placeholder{
            color:#9b9b9b;
        }
        .checkbox-row{
            display:flex;
            align-items:flex-start;
            gap:10px;
            margin:12px 0;
            padding:12px;
            background:#f9f9f9;
            border-radius:8px;
            border:1px solid var(--border);
        }
        .checkbox-row input[type="checkbox"]{
            margin-top:3px;
            width:16px;
            height:16px;
            cursor:pointer;
        }
        .checkbox-row label{
            margin:0;
            font-size:12px;
            color:#666;
            line-height:1.4;
            cursor:pointer;
        }
        .right-link{
            color:var(--red);
            text-decoration:none;
            font-size:13px;
            font-weight:600;
        }
        .btn{
            width:100%;
            background:var(--red);
            color:#fff;
            border:0;padding:13px 14px;border-radius:10px;font-weight:600;cursor:pointer;margin-top:10px;
            font-size:15px;
        }
        .btn:hover{
            background:#AE0808;
        }
        .sep{display:flex;align-items:center;gap:10px;margin:18px 0;color:#bdbdbd;font-size:13px}
        .sep:before,.sep:after{content:"";flex:1;height:1px;background:#eee}
        .social{
            display:flex;flex-direction:column;gap:10px;
        }
        .social button{
            display:flex;align-items:center;justify-content:center;gap:10px;padding:11px;border-radius:10px;border:1px solid var(--border);background:#fff;cursor:pointer;font-size:14px;
        }
        .social button:hover{
            background:#fafafa;
        }
        .small{font-size:13px;color:#777;text-align:center;margin-top:14px}
        .small a{color:var(--red);text-decoration:none;font-weight:600}
        .icon{width:18px;height:18px;display:inline-block}
        .eye{cursor:pointer;opacity:0.7}
        .eye:hover{opacity:1}
        .error-box{
            margin-bottom:12px;
            padding:10px;
            border-radius:8px;
            background:#fff3f3;
            border:1px solid #ffd6d6;
            color:#AE0808;
            font-size:13px;
        }
        @media(max-width:420px){ 
            .card{width:100%;padding:20px} 
        }
    </style>
</head>
<body>
    <div class="card" role="main" aria-label="Register card">
        <div class="brand">
            <div class="logo">U</div>
            <div style="font-weight:700;font-size:18px">UlosTa</div>
        </div>

        <h1>Buat Akun Baru</h1>
        <p class="lead">Bergabunglah dengan marketplace Ulos terbaik</p>

        @if($errors->any())
            <div class="error-box">
                @foreach($errors->all() as $err)
                    <div>{{ $err }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <label for="name">Nama Lengkap</label>
            <div class="field">
                <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden>
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="#9b9b9b"/>
                </svg>
                <input id="name" name="name" type="text" placeholder="Masukkan nama lengkap" required value="{{ old('name') }}">
            </div>

            <label for="email">Email</label>
            <div class="field">
                <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden>
                    <path d="M3 6.5A2.5 2.5 0 0 1 5.5 4h13A2.5 2.5 0 0 1 21 6.5v11A2.5 2.5 0 0 1 18.5 20h-13A2.5 2.5 0 0 1 3 17.5v-11z" stroke="#9b9b9b" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 7.5l7.5 5L19 7.5" stroke="#9b9b9b" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input id="email" name="email" type="email" placeholder="nama@email.com" required value="{{ old('email') }}">
            </div>

            <label for="phone">Nomor Telepon</label>
            <div class="field">
                <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden>
                    <path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2a1 1 0 011.11-.27 11.36 11.36 0 003.48.56 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1 11.36 11.36 0 00.56 3.48 1 1 0 01-.27 1.11l-2.17 2.2z" fill="#9b9b9b"/>
                </svg>
                <input id="phone" name="phone" type="tel" placeholder="08xx xxxx xxxx" required value="{{ old('phone') }}">
            </div>

            <div class="checkbox-row">
                <input type="checkbox" id="seller" name="seller" value="1" {{ old('seller') ? 'checked' : '' }}>
                <label for="seller">Daftar sebagai Penjual<br><span style="color:#999;font-size:11px;">Centang jika Anda ingin menjual produk Ulos</span></label>
            </div>

            <label for="password">Password</label>
            <div class="field">
                <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden>
                    <rect x="3.5" y="10" width="17" height="9" rx="2" stroke="#9b9b9b" stroke-width="1.2"/>
                    <path d="M8 10V8a4 4 0 0 1 8 0v2" stroke="#9b9b9b" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input id="password" name="password" type="password" placeholder="Minimal 8 karakter" required>
                <svg id="toggleEye1" class="eye" viewBox="0 0 24 24" width="20" height="20" fill="none" aria-hidden>
                    <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" stroke="#9b9b9b" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="3" stroke="#9b9b9b" stroke-width="1.2"/>
                </svg>
            </div>

            <label for="password_confirmation">Konfirmasi Password</label>
            <div class="field">
                <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden>
                    <rect x="3.5" y="10" width="17" height="9" rx="2" stroke="#9b9b9b" stroke-width="1.2"/>
                    <path d="M8 10V8a4 4 0 0 1 8 0v2" stroke="#9b9b9b" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Masukkan ulang password" required>
                <svg id="toggleEye2" class="eye" viewBox="0 0 24 24" width="20" height="20" fill="none" aria-hidden>
                    <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" stroke="#9b9b9b" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="3" stroke="#9b9b9b" stroke-width="1.2"/>
                </svg>
            </div>

            <div class="checkbox-row">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">Saya menyetujui <a href="#" class="right-link">Syarat & Ketentuan</a> dan <a href="#" class="right-link">Kebijakan Privasi</a></label>
            </div>

            <button type="submit" class="btn">Daftar Sekarang</button>
        </form>

        <div class="sep">atau daftar dengan</div>

        <div class="social">
            <button type="button" onclick="location.href='{{ url('/auth/google') }}'">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden><path d="M21 12.3c0-.7-.1-1.4-.3-2H12v3.8h4.6c-.2 1.2-.9 2.2-1.9 2.9v2.4h3.1c1.8-1.6 2.8-4.1 2.8-6.9z" fill="#4285F4"/><path d="M12 22c2.7 0 4.9-.9 6.6-2.4l-3.1-2.4c-.9.6-2.1 1-3.5 1-2.7 0-5-1.8-5.8-4.3H3.9v2.7C5.6 19.7 8.6 22 12 22z" fill="#34A853"/><path d="M6.2 13.9A6.8 6.8 0 0 1 6 12c0-.7.1-1.4.3-2H3.9v-2.7A10 10 0 0 0 2 12c0 1.6.4 3.1 1.1 4.4l3.1-2.5z" fill="#FBBC05"/><path d="M12 6.2c1.5 0 2.8.5 3.9 1.5l2.9-2.9C16.8 2.9 14.6 2 12 2 8.6 2 5.6 4.3 3.9 7.3l3.1 2.4C7 8 9.3 6.2 12 6.2z" fill="#EA4335"/></svg>
                Masuk dengan Google
            </button>

            <button type="button" onclick="location.href='{{ url('/auth/facebook') }}'">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden><path d="M22 12.1C22 6.6 17.5 2 12 2S2 6.6 2 12.1c0 5 3.7 9.1 8.5 9.9v-7h-2.6V12h2.6V9.8c0-2.5 1.5-3.9 3.7-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.2c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7C18.3 21.2 22 17.1 22 12.1z" fill="#1877F2"/></svg>
                Masuk dengan Facebook
            </button>
        </div>

        <div class="small">Sudah Punya Akun? <a href="{{ route('masuk') }}">Masuk</a></div>
    </div>

    <script>
        (function(){
            const pw1 = document.getElementById('password');
            const eye1 = document.getElementById('toggleEye1');
            eye1.addEventListener('click', ()=> {
                if (pw1.type === 'password'){ pw1.type = 'text'; eye1.style.opacity = '1'; }
                else { pw1.type = 'password'; eye1.style.opacity = '0.7'; }
            });

            const pw2 = document.getElementById('password_confirmation');
            const eye2 = document.getElementById('toggleEye2');
            eye2.addEventListener('click', ()=> {
                if (pw2.type === 'password'){ pw2.type = 'text'; eye2.style.opacity = '1'; }
                else { pw2.type = 'password'; eye2.style.opacity = '0.7'; }
            });
        })();
    </script>
</body>
</html>
