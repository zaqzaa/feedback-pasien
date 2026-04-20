<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;


// Route form feedback (tanpa auth, bisa diakses siapa saja)
Route::get('/feedback', [App\Http\Controllers\FeedbackController::class, 'form'])->name('feedback.form');
Route::post('/feedback', [App\Http\Controllers\FeedbackController::class, 'submit'])->name('feedback.submit');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Halaman buat pertanyaan
    Route::get('/admin/buatpertanyaan', [App\Http\Controllers\QuestionController::class, 'createCustom'])->name('admin.buatpertanyaan');
    Route::post('/admin/buatpertanyaan', [App\Http\Controllers\QuestionController::class, 'storeCustom'])->name('admin.pertanyaan.store');
    // Route hapus feedback admin
    Route::delete('/admin/feedback/{id}', [App\Http\Controllers\FeedbackController::class, 'delete'])->name('admin.feedback.delete');
    Route::get('/dashboard', [App\Http\Controllers\TokenController::class, 'dashboard'])->name('dashboard');
    Route::post('/generate-token', [App\Http\Controllers\TokenController::class, 'generate'])->name('token.generate');

    // Dashboard admin feedback
    Route::get('/admin/dashboard', [App\Http\Controllers\FeedbackController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/datafeedback', [App\Http\Controllers\FeedbackController::class, 'datafeedback'])->name('admin.datafeedback');
    // Route detail feedback admin
    Route::get('/admin/feedback/{id}', [App\Http\Controllers\FeedbackController::class, 'show'])->name('admin.feedback.show');

    // CRUD pertanyaan feedback
    Route::resource('admin/questions', App\Http\Controllers\QuestionController::class, ['as' => 'admin']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
