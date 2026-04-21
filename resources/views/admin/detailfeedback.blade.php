@extends('layouts.plain')

@section('title','Detail Feedback')

@section('styles')
<style>
    :root{ --bg-url:--bg-url: url('{{ asset("images/bg2.jpg") }}');
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

    table{width:100%;border-collapse:collapse;color:rgba(230,247,238,0.95);margin-bottom:12px}
    th{ text-align:left;padding:10px 12px;font-weight:700;font-size:13px;color:rgba(255,255,255,0.9)}
    td{padding:10px 12px;border-top:1px dashed rgba(255,255,255,0.03);vertical-align:top;color:rgba(230,247,238,0.92)}

    .answers-table{margin-top:8px}
    .btn-ghost{display:inline-block;background:transparent;border:1px solid rgba(255,255,255,0.06);color:rgba(230,247,238,0.95);padding:10px 14px;border-radius:12px;text-decoration:none}

    @media (max-width:720px){
        body{padding:22px}
        .container{max-width:96%}
        th, td{padding:8px}
    }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <h2 class="title">Detail Feedback</h2>
            <div class="subtle">Informasi lengkap dari satu entri feedback.</div>

            <div style="margin-top:14px">
                <table>
                    <tr>
                        <th>Token</th>
                        <td>{{ $feedback->token }}</td>
                    </tr>
                    <tr>
                        <th>Rating</th>
                        <td>
                            @for ($j = 1; $j <= 5; $j++)
                                @if ($j <= $feedback->rating)
                                    <span style="color: #facc15; font-size: 1.2rem;">&#9733;</span>
                                @else
                                    <span style="color: rgba(255,255,255,0.2); font-size: 1.2rem;">&#9733;</span>
                                @endif
                            @endfor
                        </td>
                    </tr>
                    <tr>
                        <th>Feedback</th>
                        <td>{{ $feedback->feedback }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $feedback->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                </table>

                @if(isset($answers) && count($answers))
                    <div class="answers-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($answers as $ans)
                                    <tr>
                                        <td>{{ $ans->question->question }}</td>
                                        <td>{{ $ans->answer }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div style="margin-top:12px">
                    <a href="{{ route('admin.datafeedback') }}" class="btn-ghost">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
