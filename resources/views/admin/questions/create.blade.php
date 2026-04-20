@extends('adminlte::page')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Tambah Pertanyaan</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.questions.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="question">Pertanyaan</label>
                            <input type="text" name="question" class="form-control" required style="color:#000; border:2px solid #333; border-radius:8px; padding:10px; font-size:1rem;">
                            <div class="form-group">
                                <label for="question" class="mb-2">Pertanyaan</label>
                                <input type="text" name="question" class="form-control mb-2" required style="color:#000; border:2px solid #333; border-radius:8px; padding:10px; font-size:1rem;">
                                @error('question')
                                    <span class="text-danger mb-2">{{ $message }}</span>
                                @enderror
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
