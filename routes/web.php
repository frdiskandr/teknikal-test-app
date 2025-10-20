<?php

use App\Http\Controllers\EbookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

//! ebook route
Route::middleware(['auth', 'verified'])->group(function () {

    // Rute utama dashboard Ebook (READ: index)
    Route::get('/ebooks', [EbookController::class, 'index'])->name('ebooks.index');

    // Rute untuk melihat detail Ebook (viewer) (READ: show)
    Route::get('/ebooks/{ebook}', [EbookController::class, 'show'])->name('ebooks.show');

    // Rute KHUSUS untuk streaming/display PDF secara aman
    Route::get('/ebooks/{ebook}/stream', [EbookController::class, 'stream'])->name('ebooks.stream');

    // Rute untuk menghapus Ebook (DELETE: destroy)
    Route::delete('/ebooks/{ebook}', [EbookController::class, 'destroy'])->name('ebooks.destroy');

    // Mengganti rute '/dashboard' default Breeze ke rute Ebook kita
    // Ini memastikan user diarahkan ke daftar Ebook setelah login.
    Route::get('/dashboard', function () {
        return redirect()->route('ebooks.index');
    })->name('dashboard');

    // ... Rute lain (profile, dll.) ...
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
