<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Masuk - UlosTa</title>
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
            margin-bottom:8px;
        }
        .logo{
            width:44px;height:44px;border-radius:10px;background:var(--red);display:inline-flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:20px;
        }
        h1{margin:6px 0 6px;font-size:22px;}
        p.lead{margin:0 0 18px;color:#767676;font-size:13px;}
        label{display:block;font-size:13px;margin:10px 0 6px;color:#555;}
        .field{
            display:flex;
            align-items:center;
            gap:10px;
            background:var(--muted);
            padding:10px 12px;
            border-radius:10px;
            border:1px solid transparent;
        }
        .field input{
            border:0;background:transparent;outline:none;font-size:14px;width:100%;
        }
        .input-row{margin-bottom:12px;display:flex;align-items:center;gap:8px;}
        .right-link{margin-left:auto;font-size:13px;color:var(--red);text-decoration:none;}
        .btn{
            width:100%;
            background:var(--red);
            color:#fff;
            border:0;padding:12px 14px;border-radius:10px;font-weight:600;cursor:pointer;margin-top:10px;
        }
        .sep{display:flex;align-items:center;gap:10px;margin:18px 0;color:#bdbdbd;font-size:13px}
        .sep:before,.sep:after{content:"";flex:1;height:1px;background:#eee}
        .social{
            display:flex;flex-direction:column;gap:10px;
        }
        .social button{
            display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;border:1px solid var(--border);background:#fff;cursor:pointer;
        }
        .small{font-size:13px;color:#777;text-align:center;margin-top:14px}
        .small a{color:var(--red);text-decoration:none;font-weight:600}
        .terms{font-size:12px;color:#9a9a9a;margin-top:16px;text-align:center}
        .eye{cursor:pointer;opacity:0.7}
        .icon{width:18px;height:18px;display:inline-block}
        @media(max-width:420px){ .card{width:100%;padding:20px} }
    </style>
</head>
<body>
    <div class="card" role="main" aria-label="Login card">
        <div class="brand" style="justify-content: center;">
            <div class="logo">U</div>
            <div style="font-weight:700;font-size:18px">UlosTa</div>
        </div>

        <h1>Masuk ke Akun</h1>
        <p class="lead">Selamat datang kembali! Silakan masuk untuk melanjutkan.</p>

      <form method="POST" action="{{ route('masuk.submit') }}">
            @csrf

            <label for="email">Email</label>
            <div class="field" style="background:#f7f7f7;padding:12px 14px;">
                <!-- mail icon -->
                <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden>
                    <path d="M3 6.5A2.5 2.5 0 0 1 5.5 4h13A2.5 2.5 0 0 1 21 6.5v11A2.5 2.5 0 0 1 18.5 20h-13A2.5 2.5 0 0 1 3 17.5v-11z" stroke="#9b9b9b" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 7.5l7.5 5L19 7.5" stroke="#9b9b9b" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input id="email" name="email" type="email" placeholder="nama@email.com" required value="{{ old('email') }}" style="color:var(--text);">
            </div>

            @if($errors->has('email') || $errors->has('password') || session('error'))
                <div style="margin-top:10px;padding:10px;border-radius:8px;background:#fff3f3;border:1px solid #ffd6d6;color:#AE0808;font-size:13px">
                    @foreach($errors->all() as $err)
                        <div>{{ $err }}</div>
                    @endforeach
                    @if(session('error'))
                        <div>{{ session('error') }}</div>
                    @endif
                </div>
            @endif

            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:6px">
                <label for="password">Password</label>
                <a class="right-link" href="#" onclick="alert('Fitur lupa password segera hadir!'); return false;">Lupa Password?</a>
            </div>

            <div class="field" style="margin-top:6px;background:#f7f7f7;padding:12px 14px;">
                <!-- lock icon -->
                <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden>
                    <rect x="3.5" y="10" width="17" height="9" rx="2" stroke="#9b9b9b" stroke-width="1.2"/>
                    <path d="M8 10V8a4 4 0 0 1 8 0v2" stroke="#9b9b9b" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input id="password" name="password" type="password" placeholder="Masukkan Password" required>
                <svg id="toggleEye" class="eye" viewBox="0 0 24 24" width="20" height="20" fill="none" aria-hidden>
                    <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" stroke="#9b9b9b" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="3" stroke="#9b9b9b" stroke-width="1.2"/>
                </svg>
            </div>

            <button type="submit" class="btn" style="background:var(--red);border-radius:10px;padding:12px 14px;font-size:15px">Masuk</button>
        </form>

        <div class="sep">atau</div>

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

        <div class="small">Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></div>

        <div class="terms">Dengan masuk, Anda menyetujui <a href="#" style="color:var(--red)">Syarat & Ketentuan</a> dan <a href="#" style="color:var(--red)">Kebijakan Privasi</a></div>
    </div>

    <script>
        (function(){
            const pw = document.getElementById('password');
            const eye = document.getElementById('toggleEye');
            eye.addEventListener('click', ()=> {
                if (pw.type === 'password'){ pw.type = 'text'; eye.style.opacity = '1'; }
                else { pw.type = 'password'; eye.style.opacity = '0.7'; }
            });
        })();
    </script>
</body>
</html>
