<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LombaController;





Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

     Route::get('/lomba', [LombaController::class, 'index'])->name('lomba');
    Route::post('/lomba/store', [LombaController::class, 'store'])->name('lomba.store');
    Route::delete('/lomba/delete/{id}', [LombaController::class, 'destroy'])->name('lomba.delete');

});


Route::middleware(['auth'])->group(function () {
    // Halaman Utama Daftar Lomba
    Route::get('/lomba', [LombaController::class, 'index'])->name('Lomba.peserta.index');

    Route::post('/lomba/store', [LombaController::class, 'store'])->name('Lomba.peserta.store');

    Route::delete('/lomba/hapus-proposal/{user_id}', [LombaController::class, 'hapusproposal'])->name('Lomba.peserta.hapusproposal');

    // Proses Tambah Proposal (PATCH)
    Route::patch('/lomba/tambahproposal/{id}', [LombaController::class, 'tambahproposal'])->name('Lomba.peserta.tambahproposal');

    // Proses Orisinalitas (PATCH)
    // Di routes/web.php, pastikan seperti ini:
// Route untuk Orisinalitas
Route::patch('lomba/peserta/tambahorisinalitas/{id}', [LombaController::class, 'tambahorisinalitas'])
    ->name('Lomba.peserta.tambahorisinalitas');

Route::delete('lomba/peserta/hapusorisinalitas/{id}', [LombaController::class, 'hapusorisinalitas'])
    ->name('Lomba.peserta.hapusorisinalitas');

    // Proses Hapus (DELETE)
   Route::delete('/lomba/destroy/{id}', [LombaController::class, 'destroy'])->name('Lomba.peserta.destroy');

// Route untuk Edit (dengan parameter ID yang di-encrypt)
Route::get('/lomba/edit/{id}', [LombaController::class, 'edit'])->name('Lomba.peserta.edit');

// Route untuk Simpan Data (Store)
Route::post('/lomba/store', [LombaController::class, 'store'])->name('Lomba.peserta.store');

// Route untuk Upload Proposal
Route::patch('/lomba/upload-proposal/{user_id}', [LombaController::class, 'tambahproposal'])->name('Lomba.peserta.tambahproposal');
});

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
