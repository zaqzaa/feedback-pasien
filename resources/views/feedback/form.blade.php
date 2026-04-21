@extends('layouts.plain')

@section('title', 'Pengisian Feedback')

@section('styles')

<style>
    /* Match login theme: full-bleed background image + centered translucent panel */
    :root{  --bg-url: url('{{ asset("images/bg2.jpg") }}');
            --panel-bg: rgba(6,10,8,0.56); /* translucent dark */
            --panel-border: rgba(255,255,255,0.06);
            --accent: #0b6b35; /* clinic green */
            --accent-2: #0e8a49;
            --muted: rgba(255,255,255,0.75);
            --radius: 10px; }

    html,body{height:100%;}
    body{margin:0;font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial;color:#e6f7ee;background-color:#07121a;background-image:var(--bg-url);background-size:cover;background-position:center center;display:flex;align-items:center;justify-content:center;padding:28px}

    /* dim overlay for good contrast (keeps background visible) */
    body::before{content:'';position:fixed;inset:0;background:linear-gradient(180deg, rgba(6,9,8,0.24), rgba(6,9,8,0.54));pointer-events:none}

    .card{width:520px;max-width:96%;border-radius:14px;background:linear-gradient(180deg, rgba(6,9,8,0.6), rgba(6,9,8,0.5));box-shadow:0 20px 60px rgba(2,6,6,0.6);border:1px solid rgba(255,255,255,0.04);backdrop-filter:blur(6px) saturate(120%);overflow:hidden}
    .card-body{padding:28px}

    h2.page-title{margin:0 0 12px;font-size:24px;color:#ffffff;font-weight:800;text-align:center;letter-spacing:0.6px}
    .subtitle{color:rgba(230,247,238,0.85);text-align:center;margin-bottom:18px;font-size:13px}

    /* Inputs: translucent dark with subtle border and focus glow */
    label.small-label{display:block;font-weight:600;margin-bottom:8px;color:rgba(255,255,255,0.85)}
    .input, textarea{width:100%;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);padding:12px 14px;border-radius:10px;color:#e6f7ee;font-size:15px}
    .input::placeholder, textarea::placeholder{color:rgba(230,243,238,0.55)}
    .input:focus, textarea:focus{outline:none;border-color:var(--accent-2);box-shadow:0 10px 30px rgba(14,138,73,0.12)}

    textarea{min-height:140px;resize:vertical}
    .field{margin-bottom:16px}

    /* Actions: stacked full-width buttons matching login look */
    .actions{display:flex;flex-direction:column;gap:12px;margin-top:6px}
    .btn-primary{display:inline-block;background:linear-gradient(180deg,var(--accent),var(--accent-2));color:#fff;padding:12px 16px;border-radius:10px;border:0;font-weight:700;cursor:pointer;text-align:center}
    .btn-ghost{display:inline-block;background:transparent;border:1px solid rgba(255,255,255,0.06);color:rgba(230,247,238,0.9);padding:12px 16px;border-radius:10px;text-decoration:none;text-align:center}

    .success{background:linear-gradient(180deg, rgba(18,84,43,0.28), rgba(14,58,31,0.12));color:#dff7e7;padding:10px;border-radius:8px;margin-bottom:12px;border:1px solid rgba(14,138,73,0.08)}
    .error{color:#ffb4b4;font-size:.95rem;margin-top:6px}

    /* Star Rating */
    .rating-wrapper {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 6px;
    }
    .rating-wrapper input {
        display: none;
    }
    .rating-wrapper label {
        cursor: pointer;
        color: rgba(255, 255, 255, 0.15);
        transition: color 0.2s ease, transform 0.1s ease;
    }
    .rating-wrapper label:active {
        transform: scale(0.9);
    }
    .rating-wrapper label svg {
        width: 34px;
        height: 34px;
        fill: currentColor;
    }
    /* Hover and checked states */
    .rating-wrapper label:hover,
    .rating-wrapper label:hover ~ label,
    .rating-wrapper input:checked ~ label {
        color: #facc15; /* Tailwind yellow-400 */
        filter: drop-shadow(0 0 6px rgba(250, 204, 21, 0.4));
    }

    /* Responsive tweaks */
    @media (max-width:560px){
        .card{width:92%;padding:0}
        .card-body{padding:20px}
        h2.page-title{font-size:20px}
    }
</style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h2 class="page-title">{{ __('Pengisian Feedback') }}</h2>
            <div class="subtitle">Masukkan token dan isi feedback singkat. Semua masukan membantu meningkatkan layanan.</div>

            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('feedback.submit') }}">
                @csrf

                <div class="field">
                    <label for="token" class="small-label">Token</label>
                    <input type="text" name="token" id="token" required class="input" placeholder="">
                    @error('token')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                @if(isset($questions) && count($questions))
                    <div class="field">
                        <label class="small-label">Pertanyaan</label>
                        <div style="display:flex;flex-direction:column;gap:12px;">
                            @foreach($questions as $question)
                                <div>
                                    <label style="display:block;margin-bottom:6px;color:rgba(230,247,238,0.85);">{{ $question->question }}</label>
                                    <input type="text" name="answers[{{ $question->id }}]" class="input" placeholder="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="field">
                    <label class="small-label">Rating Pelayanan</label>
                    <div class="rating-wrapper">
                        <input type="radio" id="star5" name="rating" value="5" required />
                        <label for="star5" title="5 Bintang">
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </label>
                        <input type="radio" id="star4" name="rating" value="4" />
                        <label for="star4" title="4 Bintang">
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </label>
                        <input type="radio" id="star3" name="rating" value="3" />
                        <label for="star3" title="3 Bintang">
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </label>
                        <input type="radio" id="star2" name="rating" value="2" />
                        <label for="star2" title="2 Bintang">
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </label>
                        <input type="radio" id="star1" name="rating" value="1" />
                        <label for="star1" title="1 Bintang">
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </label>
                    </div>
                    @error('rating')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label class="small-label">Isi Feedback</label>
                    <textarea name="feedback" id="feedback" rows="4" required class="input" placeholder="Tulis masukan Anda..."></textarea>
                    @error('feedback')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="actions">
                    <button type="submit" class="btn-primary">Kirim Jawaban</button>
                    <a href="{{ route('dashboard') }}" class="btn-ghost">Kembali</a>
                    
                </div>
            </form>
        </div>
    </div>
@endsection
