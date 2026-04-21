@extends('layouts.plain')

@section('title','Data Feedback')

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
    body{margin:0;font-family:Inter,system-ui,Segoe UI,Roboto,Arial;color:#e6f7ee;background-color:#07121a;background-image:var(--bg-url);background-size:cover;background-position:center;display:flex;align-items:center;justify-content:center;padding:40px}
    body::before{content:'';position:fixed;inset:0;background:linear-gradient(180deg, rgba(6,9,8,0.22), rgba(6,9,8,0.56));pointer-events:none}

    .container{width:100%;max-width:1040px;margin:0 auto}
    .card{background:linear-gradient(180deg, rgba(6,9,8,0.64), rgba(6,9,8,0.52));border-radius:14px;padding:24px;border:1px solid rgba(255,255,255,0.04);box-shadow:0 30px 80px rgba(2,6,6,0.66);backdrop-filter:blur(8px) saturate(120%)}

    h2.title{margin:0 0 8px;color:#fff;font-size:20px;font-weight:800}
    .subtle{color:rgba(230,247,238,0.86);font-size:13px;margin-bottom:14px}

    /* Table styles */
    .table-wrap{overflow:auto;border-radius:8px}
    table{width:100%;border-collapse:collapse;background:transparent;color:rgba(230,247,238,0.95)}
    thead th{ text-align:left;padding:12px 14px;font-weight:700;font-size:13px;color:rgba(255,255,255,0.9);border-bottom:1px solid rgba(255,255,255,0.04)}
    tbody td{padding:12px 14px;border-bottom:1px dashed rgba(255,255,255,0.03);vertical-align:middle;font-size:14px}
    tbody tr:nth-child(even){background:linear-gradient(90deg, rgba(255,255,255,0.01), rgba(255,255,255,0.00))}

    .empty{padding:22px;text-align:center;color:rgba(230,247,238,0.75)}

    /* Buttons */
    .btn-ghost{display:inline-block;background:transparent;border:1px solid rgba(255,255,255,0.06);color:rgba(230,247,238,0.95);padding:8px 12px;border-radius:10px;text-decoration:none}
    .btn-primary{background:linear-gradient(180deg,var(--accent),var(--accent-2));color:#fff;padding:10px 14px;border-radius:10px;border:0;font-weight:700}
    .btn-danger{background:linear-gradient(180deg,#9b1c1c,#c0392b);color:#fff;padding:8px 12px;border-radius:10px;border:0}

    .actions{display:flex;gap:8px;align-items:center}

    @media (max-width:820px){
        body{padding:22px}
        .card{padding:18px}
        thead th, tbody td{padding:10px}
        .actions{flex-direction:column;align-items:flex-start}
        .btn-ghost, .btn-primary, .btn-danger{width:100%;text-align:center}
    }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;gap:12px;flex-wrap:wrap">
                <div>
                    <h2 class="title">Data Feedback</h2>
                    <div class="subtle">Semua entri feedback yang dikumpulkan dari pasien/klien.</div>
                </div>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn-ghost">Kembali</a>
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Token</th>
                            <th>Rating</th>
                            <th>Feedback</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedbacks as $i => $feedback)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $feedback->token }}</td>
                                <td>
                                    @for ($j = 1; $j <= 5; $j++)
                                        @if ($j <= $feedback->rating)
                                            <span style="color: #facc15;">&#9733;</span>
                                        @else
                                            <span style="color: rgba(255,255,255,0.2);">&#9733;</span>
                                        @endif
                                    @endfor
                                </td>
                                <td>{{ $feedback->feedback }}</td>
                                <td>{{ $feedback->created_at->format('d-m-Y') }}</td>
                                <td class="actions">
                                    <a href="{{ route('admin.feedback.show', $feedback->id) }}" class="btn-ghost">Detail</a>
                                    <form action="{{ route('admin.feedback.delete', $feedback->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus feedback ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="empty">Belum ada feedback</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
