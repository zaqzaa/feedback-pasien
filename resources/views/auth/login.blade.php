<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Selamat Datang</title>

    <style>
        /* Replace the --bg-url value with your preferred background image URL */
        :root{
            --bg-url: url('{{ asset("images/bg2.jpg") }}');
            --panel-bg: rgba(6,10,8,0.56); /* translucent dark */
            --panel-border: rgba(255,255,255,0.06);
            --accent: #0b6b35; /* clinic green */
            --accent-2: #0e8a49;
            --muted: rgba(255,255,255,0.75);
            --radius: 10px;
        }

        *{box-sizing:border-box}
        html,body{height:100%;margin:0;font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial;background-color:#000}

        body{
            background-image: var(--bg-url);
            background-size:cover;background-position:center center;background-attachment:fixed;
            display:flex;align-items:center;justify-content:center;padding:24px;
        }

        /* dimming overlay for better contrast */
        body::before{content:'';position:fixed;inset:0;background:linear-gradient(180deg, rgba(6,9,8,0.24), rgba(6,9,8,0.54));pointer-events:none}

        .center-card{
            width:360px;max-width:calc(100% - 48px);
            background:var(--panel-bg);
            border-radius:var(--radius);
            padding:22px;
            box-shadow:0 10px 30px rgba(2,6,6,0.6);
            border:1px solid var(--panel-border);
            backdrop-filter: blur(6px) saturate(120%);
            color:var(--muted);
            text-align:center;
        }

        .brand-mark{width:70px;height:70px;border-radius:8px;margin:0 auto 12px;display:flex;align-items:center;justify-content:center;background:linear-gradient(180deg,var(--accent-2),var(--accent));color:#fff;font-weight:800;font-size:28px;cursor:default;transition:transform 160ms ease, box-shadow 160ms ease}
        .login-heading{color:#fff;font-weight:700;margin:4px 0 8px;letter-spacing:1px}
        .login-sub{font-size:13px;margin-bottom:18px;color:rgba(255,255,255,0.8)}

        form{display:block;text-align:left}
        .field{margin-bottom:14px}
        .input{width:100%;padding:12px 10px;border-radius:8px;background:transparent;border:1px solid rgba(255,255,255,0.08);color:#fff;font-size:14px}
        .input::placeholder{color:rgba(255,255,255,0.65)}
        .input:focus{outline:none;border-color:var(--accent-2);box-shadow:0 8px 20px rgba(11,107,53,0.12)}

        .actions{display:flex;flex-direction:column;gap:10px;margin-top:8px}
        .btn{display:inline-flex;align-items:center;justify-content:center;padding:12px 14px;border-radius:8px;font-weight:700;cursor:pointer;text-decoration:none;border:0}
        .btn-primary{background:linear-gradient(180deg,var(--accent),var(--accent-2));color:#fff}
        .btn-link{background:transparent;border:1px solid rgba(255,255,255,0.06);color:var(--muted)}

        .row-links{display:flex;justify-content:space-between;margin-top:8px}
        .row-links a{color:rgba(255,255,255,0.9);font-size:13px;text-decoration:none}

        .small-note{font-size:12px;color:rgba(255,255,255,0.65);margin-top:12px;text-align:center}

        @media (max-width:420px){
            .center-card{width:92%;padding:18px}
            .brand-mark{width:60px;height:60px}
        }
    </style>
</head>
<body>
    <div class="center-card" role="region" aria-labelledby="login-title">
        <div id="brand-emoji" class="brand-mark" aria-hidden="true" data-default="😄" data-hover="😁">😄</div>
        <h1 id="login-title" class="login-heading">LOGIN</h1>
        <div class="login-sub">Masuk untuk mengelola data klinik atau pilih Isi Feedback untuk memberikan masukan</div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
                <input id="email" class="input" type="email" name="email" placeholder="Email" required autofocus autocomplete="email">
            </div>

            <div class="field">
                <input id="password" class="input" type="password" name="password" placeholder="Kata sandi" required autocomplete="current-password">
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Masuk</button>
                <a href="{{ route('feedback.form') }}" class="btn btn-link">Isi Feedback</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-link">Registrasi</a>
                @endif
            </div>
        </form>    </div>

    <script>
        // Emoji hover/touch interaction: swap default -> hover emoji when cursor/touch is over the element
        (function(){
            const el = document.getElementById('brand-emoji');
            if (!el) return;
            const defaultE = el.dataset.default || '😄';
            const hoverE = el.dataset.hover || '😘';
            let leaveTimeout = null;

            const enter = () => {
                clearTimeout(leaveTimeout);
                el.textContent = hoverE;
                el.style.transform = 'scale(1.06)';
                el.style.boxShadow = '0 8px 24px rgba(0,0,0,0.25)';
            };

            const leave = () => {
                el.style.transform = 'scale(1)';
                el.style.boxShadow = '';
                // small delay so change doesn't feel abrupt
                leaveTimeout = setTimeout(()=> el.textContent = defaultE, 120);
            };

            el.addEventListener('mouseenter', enter);
            el.addEventListener('mouseleave', leave);

            // keyboard/accessibility: focus/blur
            el.setAttribute('tabindex', '0');
            el.addEventListener('focus', enter);
            el.addEventListener('blur', leave);

            // touch support: toggle briefly on touchstart
            el.addEventListener('touchstart', (e) => {
                enter();
                // prevent immediate click propagation on some devices
                e.stopPropagation();
            }, {passive:false});
            el.addEventListener('touchend', () => { leave(); });
        })();
    </script>
</body>
</html>
