<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedbackToken;

class FeedbackController extends Controller
{
    // Menghapus feedback
    public function delete($id)
    {
        $feedback = \App\Models\Feedback::findOrFail($id);
        $feedback->delete();
        return redirect()->route('admin.datafeedback')->with('success', 'Feedback berhasil dihapus!');
    }
    // Menampilkan detail feedback
    public function show($id)
    {
    $feedback = \App\Models\Feedback::findOrFail($id);
    $answers = \App\Models\FeedbackAnswer::where('feedback_id', $feedback->id)->with('question')->get();
    return view('admin.detailfeedback', compact('feedback', 'answers'));
    }
    public function form()
    {
        $questions = \App\Models\Question::all();
        return view('feedback.form', compact('questions'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'feedback' => 'required',
        ]);

        $token = FeedbackToken::where('token', $request->token)->where('used', false)->first();
        if (!$token) {
            return back()->withErrors(['token' => 'Token tidak valid atau sudah digunakan.']);
        }

        // Tandai token sebagai sudah digunakan
        $token->used = true;
        $token->save();

        // Simpan feedback ke database
        $feedback = \App\Models\Feedback::create([
            'token' => $request->token,
            'feedback' => $request->feedback,
        ]);

        // Simpan jawaban pertanyaan
        if ($request->has('answers')) {
            foreach ($request->answers as $question_id => $answer) {
                \App\Models\FeedbackAnswer::create([
                    'feedback_id' => $feedback->id,
                    'question_id' => $question_id,
                    'answer' => $answer,
                ]);
            }
        }

        return back()->with('success', 'Feedback berhasil dikirim!');
    }

    // Method untuk menampilkan data feedback di dashboard admin
    public function index()
    {
        $feedbacks = \App\Models\Feedback::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('feedbacks'));
    }

    // Menampilkan halaman data feedback
    public function datafeedback()
    {
        $feedbacks = \App\Models\Feedback::orderBy('created_at', 'desc')->get();
        return view('admin.datafeedback', compact('feedbacks'));
    }
}
