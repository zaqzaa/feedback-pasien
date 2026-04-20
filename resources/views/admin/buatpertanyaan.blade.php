@extends('layouts.plain')

@section('title','Buat Pertanyaan')

@section('styles')
<style>
    :root{ --bg-url: --bg-url: url('{{ asset("images/bg2.jpg") }}');
            --panel-bg: rgba(6,10,8,0.56); /* translucent dark */
            --panel-border: rgba(255,255,255,0.06);
            --accent: #0b6b35; /* clinic green */
            --accent-2: #0e8a49;
            --muted: rgba(255,255,255,0.75);
            --radius: 10px; }
    html,body{height:100%}
    body{margin:0;font-family:Inter,system-ui,Segoe UI,Roboto,Arial;color:#e6f7ee;background-color:#07121a;background-image:var(--bg-url);background-size:cover;background-position:center;display:flex;align-items:center;justify-content:center;padding:40px}
    body::before{content:'';position:fixed;inset:0;background:linear-gradient(180deg, rgba(6,9,8,0.22), rgba(6,9,8,0.56));pointer-events:none}

    .container{width:100%;max-width:720px;margin:0 auto}
    .card{background:linear-gradient(180deg, rgba(6,9,8,0.64), rgba(6,9,8,0.52));border-radius:14px;padding:26px;border:1px solid rgba(255,255,255,0.04);box-shadow:0 30px 80px rgba(2,6,6,0.66);backdrop-filter:blur(8px) saturate(120%)}

    h2.title{margin:0 0 8px;color:#fff;font-size:20px;font-weight:800}
    .subtle{color:rgba(230,247,238,0.86);font-size:13px;margin-bottom:14px}

    .form-group{margin-bottom:14px}
    label{display:block;color:rgba(230,247,238,0.9);font-weight:700;margin-bottom:8px}
    .input{width:100%;padding:12px 14px;border-radius:10px;border:1px solid rgba(255,255,255,0.06);background:rgba(255,255,255,0.02);color:#e6f7ee}

    .btn-primary{background:linear-gradient(180deg,var(--accent),var(--accent-2));color:#fff;padding:10px 14px;border-radius:12px;border:0;font-weight:700}
    .btn-ghost{background:transparent;border:1px solid rgba(255,255,255,0.06);color:rgba(230,247,238,0.95);padding:10px 14px;border-radius:12px;text-decoration:none}

    @media (max-width:720px){
        body{padding:22px}
        .container{max-width:96%}
    }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <h2 class="title">Buat Pertanyaan</h2>
            <div class="subtle">Tambahkan pertanyaan yang akan muncul pada form feedback pasien.</div>

            <div style="margin-top:12px">
                <form method="POST" action="{{ route('admin.pertanyaan.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="pertanyaan">Pertanyaan</label>
                        <input type="text" name="pertanyaan" id="pertanyaan" class="input" required style="font-size:1rem;">
                        @error('pertanyaan')
                            <div style="color:#ffb4b4;margin-top:8px">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:8px">
                        <button type="submit" class="btn-primary">Simpan</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn-ghost">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
