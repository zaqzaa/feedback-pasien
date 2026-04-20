<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return view('admin.dashboard');
    }

    public function generate()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        // Generate token sekali pakai
        $token = Str::random(8);
        // Simpan token ke database
        \App\Models\FeedbackToken::create([
            'token' => $token,
            'used' => false,
        ]);
        return back()->with('token_generated', $token);
    }
}
