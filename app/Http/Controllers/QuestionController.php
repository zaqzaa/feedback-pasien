<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Menampilkan form buat pertanyaan custom
    public function createCustom()
    {
        return view('admin.buatpertanyaan');
    }

    // Menyimpan pertanyaan baru custom
    public function storeCustom(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
        ]);
        \App\Models\Question::create([
            'question' => $request->pertanyaan,
        ]);
        return redirect()->route('admin.dashboard')->with('success', 'Pertanyaan berhasil ditambahkan!');
    }
    public function index()
    {
        $questions = Question::all();
        return view('admin.questions.index', compact('questions'));
    }

    // Add resourceful create/store to satisfy Route::resource
    public function create()
    {
        // return the resourceful create view
        return view('admin.questions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
        ]);

        Question::create([
            'question' => $request->input('question'),
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan berhasil ditambahkan');
    }

    // ...existing resource CRUD (index, create, store, edit, update, destroy)...

    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required|string|max:255',
        ]);
        $question->update($request->only('question'));
        return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan berhasil diupdate');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan berhasil dihapus');
    }
}
