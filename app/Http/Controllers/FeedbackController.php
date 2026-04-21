<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FeedbackToken;
use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use App\Models\Question;

class FeedbackController extends Controller
{
    // Menghapus feedback
    public function delete($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        return redirect()->route('admin.datafeedback')->with('success', 'Feedback berhasil dihapus!');
    }

    // Menampilkan detail feedback
    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        $answers = FeedbackAnswer::where('feedback_id', $feedback->id)->with('question')->get();
        return view('admin.detailfeedback', compact('feedback', 'answers'));
    }

    public function form()
    {
        $questions = Question::all();
        return view('feedback.form', compact('questions'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'feedback' => 'required',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $token = FeedbackToken::where('token', $request->token)->where('used', false)->first();
        if (!$token) {
            return back()->withErrors(['token' => 'Token tidak valid atau sudah digunakan.']);
        }

        try {
            DB::beginTransaction();

            // Tandai token sebagai sudah digunakan
            $token->used = true;
            $token->save();

            // Simpan feedback ke database
            $feedback = Feedback::create([
                'token' => $request->token,
                'rating' => $request->rating,
                'feedback' => $request->feedback,
            ]);

            // Simpan jawaban pertanyaan
            if ($request->has('answers')) {
                foreach ($request->answers as $question_id => $answer) {
                    // Cek jika jawaban ada (tidak kosong)
                    if (!empty($answer)) {
                        FeedbackAnswer::create([
                            'feedback_id' => $feedback->id,
                            'question_id' => $question_id,
                            'answer' => $answer,
                        ]);
                    }
                }
            }

            DB::commit();
            return back()->with('success', 'Feedback berhasil dikirim!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan feedback. Silakan coba lagi.']);
        }
    }

    // Method untuk menampilkan data feedback di dashboard admin
    public function index()
    {
        $feedbacks = Feedback::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('feedbacks'));
    }

    // Menampilkan halaman data feedback
    public function datafeedback()
    {
        $feedbacks = Feedback::orderBy('created_at', 'desc')->get();
        return view('admin.datafeedback', compact('feedbacks'));
    }
}
