@extends('layouts.plain')

@section('title','Daftar Pertanyaan Feedback')

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

    .container{width:100%;max-width:920px;margin:0 auto}
    .card{background:linear-gradient(180deg, rgba(6,9,8,0.64), rgba(6,9,8,0.52));border-radius:14px;padding:22px;border:1px solid rgba(255,255,255,0.04);box-shadow:0 30px 80px rgba(2,6,6,0.66);backdrop-filter:blur(8px) saturate(120%)}

    .header{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:12px}
    h2{margin:0;color:#fff;font-size:20px;font-weight:800}
    .subtle{color:rgba(230,247,238,0.86);font-size:13px}

    table{width:100%;border-collapse:collapse;color:rgba(230,247,238,0.95)}
    thead th{ text-align:left;padding:12px 14px;font-weight:700;font-size:13px;color:rgba(255,255,255,0.9);border-bottom:1px solid rgba(255,255,255,0.04)}
    tbody td{padding:12px 14px;border-bottom:1px dashed rgba(255,255,255,0.03);vertical-align:middle;font-size:14px}

    .btn-ghost{display:inline-block;background:transparent;border:1px solid rgba(255,255,255,0.06);color:rgba(230,247,238,0.95);padding:8px 12px;border-radius:10px;text-decoration:none}
    .btn-primary{background:linear-gradient(180deg,var(--accent),var(--accent-2));color:#fff;padding:10px 14px;border-radius:10px;border:0;font-weight:700}
    .btn-danger{background:linear-gradient(180deg,#9b1c1c,#c0392b);color:#fff;padding:8px 12px;border-radius:10px;border:0}

    .row-actions{display:flex;gap:8px;align-items:center}

    @media (max-width:820px){
        body{padding:22px}
        .container{max-width:96%}
        thead th, tbody td{padding:10px}
        .row-actions{flex-direction:column;align-items:flex-start}
        .btn-ghost, .btn-primary, .btn-danger{width:100%;text-align:center}
    }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="header">
                <div>
                    <h2>Daftar Pertanyaan Feedback</h2>
                    <div class="subtle">Pertanyaan yang akan ditampilkan pada form feedback.</div>
                </div>
                <div>
                    <a href="{{ route('admin.questions.create') }}" class="btn-primary">Tambah Pertanyaan</a>
                </div>
            </div>

            @if(session('success'))
                <div style="margin-bottom:12px;padding:10px;border-radius:10px;background:linear-gradient(180deg, rgba(18,84,43,0.22), rgba(14,58,31,0.08));color:#dff7e7;border:1px solid rgba(14,138,73,0.08)">{{ session('success') }}</div>
            @endif

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pertanyaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $q)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $q->question }}</td>
                                <td class="row-actions">
                                    <a href="{{ route('admin.questions.edit', $q->id) }}" class="btn-ghost">Edit</a>
                                    <form action="{{ route('admin.questions.destroy', $q->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="empty" style="padding:18px;text-align:center;color:rgba(230,247,238,0.75)">Belum ada pertanyaan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
