<?php

use App\Http\Controllers\EbookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

//! ebook route
Route::middleware(['auth', 'verified'])->group(function () {

    // Rute utama dashboard Ebook
    Route::get('/ebooks', [EbookController::class, 'index'])->name('ebooks.index');

    // Rute untuk membuat Ebook baru
    Route::get('/ebooks/create', [EbookController::class, 'create'])->name('ebooks.create');

    // Rute untuk menyimpan Ebook baru
    Route::post('/ebooks', [EbookController::class, 'store'])->name('ebooks.store');

    // Rute untuk melihat detail Ebook
    Route::get('/ebooks/{ebook}', [EbookController::class, 'show'])->name('ebooks.show');

    // Rute KHUSUS untuk streaming/display PDF secara aman
    Route::get('/ebooks/{ebook}/stream', [EbookController::class, 'stream'])->name('ebooks.stream');

    // Rute untuk menghapus Ebook
    Route::delete('/ebooks/{ebook}', [EbookController::class, 'destroy'])->name('ebooks.destroy');

    // Mengganti rute '/dashboard'
    Route::get('/dashboard', function () {
        return redirect()->route('ebooks.index');
    })->name('dashboard');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
