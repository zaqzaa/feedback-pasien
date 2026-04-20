@extends('layouts.plain')

@section('title', 'Dashboard Admin')

@section('styles')
<style>
    :root{ --bg-url: url('{{ asset("images/bg2.jpg") }}');
            --panel-bg: rgba(6,10,8,0.56); /* translucent dark */
            --panel-border: rgba(255,255,255,0.06);
            --accent: #0b6b35; /* clinic green */
            --accent-2: #0e8a49;
            --muted: rgba(255,255,255,0.75);
            --radius: 10px; }   
    html,body{height:100%}
    body{margin:0;font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial;color:#e6f7ee;background-color:#07121a;background-image:var(--bg-url);background-size:cover;background-position:center center;display:flex;align-items:center;justify-content:center;padding:56px 28px}
    body::before{content:'';position:fixed;inset:0;background:linear-gradient(180deg, rgba(6,9,8,0.22), rgba(6,9,8,0.56));pointer-events:none}

    .container{width:100%;max-width:1040px;margin:0 auto}
    .card{background:linear-gradient(180deg, rgba(6,9,8,0.64), rgba(6,9,8,0.52));border-radius:16px;padding:30px;border:1px solid rgba(255,255,255,0.04);box-shadow:0 30px 80px rgba(2,6,6,0.66);backdrop-filter:blur(8px) saturate(120%)}

    .header-row{display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:18px}
    h2{margin:0;color:#fff;font-size:22px;font-weight:800;line-height:1}
    .subtle{color:rgba(230,247,238,0.88);font-size:14px;margin-top:6px}

    .panel{background:transparent;padding:16px;border-radius:12px;border:1px solid rgba(255,255,255,0.03)}

    /* Buttons & forms match feedback theme */
    .btn-primary{display:inline-block;background:linear-gradient(180deg,var(--accent),var(--accent-2));color:#fff;padding:12px 16px;border-radius:12px;border:0;font-weight:700;cursor:pointer}
    .btn-ghost{display:inline-block;background:transparent;border:1px solid rgba(255,255,255,0.06);color:rgba(230,247,238,0.95);padding:12px 16px;border-radius:12px;text-decoration:none}

    .actions{display:flex;gap:12px;flex-wrap:wrap}
    .row{display:flex;gap:12px;align-items:center}
    form.inline{display:inline}

    /* Slight spacing for token success box */
    .token-success{margin-bottom:12px;padding:12px;border-radius:10px;background:linear-gradient(180deg, rgba(18,84,43,0.22), rgba(14,58,31,0.08));color:#dff7e7;border:1px solid rgba(14,138,73,0.08)}

    /* Provide more vertical rhythm for lower links */
    .link-actions{margin-top:18px;display:flex;gap:12px;flex-wrap:wrap}

    /* Small screen tweaks */
    @media (max-width:820px){
        body{padding:28px}
        .container{max-width:96%}
        .header-row{flex-direction:column;align-items:flex-start;gap:10px}
        .actions{width:100%;flex-direction:column}
        .actions .btn-primary, .actions .btn-ghost{width:100%;text-align:center}
    }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="header-row">
                <div>
                    <h2>Dashboard Admin</h2>
                    <div class="subtle">Kelola token, pertanyaan, dan lihat data feedback di halaman ini.</div>
                </div>
                <div class="actions">
                    <form method="POST" action="{{ route('token.generate') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-primary">Buat Token</button>
                    </form>
                </div>
            </div>

            <div style="margin-top:8px" class="panel">
                @if(session('token_generated'))
                    <div class="token-success">
                        Token berhasil dibuat: <strong>{{ session('token_generated') }}</strong>
                    </div>
                @endif

                <h3 style="margin:0 0 10px;color:#e6f7ee">Generate Token untuk Isi Feedback</h3>
                <p style="margin:0 0 12px;color:rgba(230,247,238,0.82);font-size:14px">Gunakan tombol di samping untuk membuat token baru yang dapat dibagikan kepada pasien/klien.</p>
            </div>

            <div class="link-actions">
                <a href="{{ route('admin.datafeedback') }}" class="btn-ghost">Lihat Data Feedback</a>
                <a href="{{ route('admin.buatpertanyaan') }}" class="btn-ghost">Buat Pertanyaan</a>
                <a href="{{ route('admin.questions.index') }}" class="btn-ghost">Pertanyaan yang sudah dibuat</a>
            </div>
        </div>
    </div>
@endsection
