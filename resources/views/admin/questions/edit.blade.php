
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Pertanyaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.questions.update', $question->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="question" class="form-label fw-bold mb-2">Pertanyaan &nbsp; &nbsp;</label>
                            <input type="text" name="question" id="question" class="form-control mb-2" value="{{ $question->question }}" required style="color:#000; border:2px solid #333; border-radius:8px; padding:10px; font-size:1rem;">
                            @error('question')
                                <span class="text-danger small mb-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update &nbsp; &nbsp;</button>
                            <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
