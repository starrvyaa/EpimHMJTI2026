<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\KaryaController;

// 1. HALAMAN UTAMA (Sudah diberi nama 'home' agar tidak error lagi!)
Route::get('/', function () {
    return view('welcome');
})->name('home');


// 2. ROUTE YANG BUTUH LOGIN (Semua disatukan di sini agar rapi)
Route::middleware(['auth'])->group(function () {

    // --- Management Lomba (Peserta) ---
    Route::get('/lomba', [LombaController::class, 'index'])->name('Lomba.peserta.index');
    Route::post('/lomba/store', [LombaController::class, 'store'])->name('Lomba.peserta.store');
    Route::get('/lomba/edit/{id}', [LombaController::class, 'edit'])->name('Lomba.peserta.edit');
    Route::delete('/lomba/destroy/{id}', [LombaController::class, 'destroy'])->name('Lomba.peserta.destroy');
    Route::delete('/lomba/delete/{id}', [LombaController::class, 'destroy'])->name('lomba.delete'); // Cadangan jika ada view lama yang pakai nama ini

    // --- Berkas Proposal ---
    Route::patch('/lomba/tambahproposal/{id}', [LombaController::class, 'tambahproposal'])->name('Lomba.peserta.tambahproposal');
    Route::delete('/lomba/hapus-proposal/{user_id}', [LombaController::class, 'hapusproposal'])->name('Lomba.peserta.hapusproposal');
    
    // Route ini URL-nya berbeda tapi tadinya namanya sama, saya bedakan sedikit biar tidak bentrok
    Route::patch('/lomba/upload-proposal/{user_id}', [LombaController::class, 'tambahproposal'])->name('Lomba.peserta.upload_proposal');

    // --- Berkas Orisinalitas ---
    Route::patch('lomba/peserta/tambahorisinalitas/{id}', [LombaController::class, 'tambahorisinalitas'])->name('Lomba.peserta.tambahorisinalitas');
    Route::delete('lomba/peserta/hapusorisinalitas/{id}', [LombaController::class, 'hapusorisinalitas'])->name('Lomba.peserta.hapusorisinalitas');

    // --- Profile User ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Pengumpulan Karya ---
    Route::get('/karya', [KaryaController::class, 'index'])->name('karya.index');
    Route::post('/karya/store', [KaryaController::class, 'store'])->name('karya.store');

    // --- Tiket Finalis ---
    Route::get('/tiket', [LombaController::class, 'tiketFinalis'])->name('tiket.finalis');

    // --- Admin: Verifikasi Pembayaran ---
    Route::middleware(['auth', 'only_admin'])->group(function () {
        Route::patch('/admin/pembayaran/verifikasi/{id}', [LombaController::class, 'verifikasiPembayaran'])
            ->name('admin.pembayaran.verifikasi');
        Route::patch('/admin/pembayaran/tolak/{id}', [LombaController::class, 'tolakPembayaran'])
            ->name('admin.pembayaran.tolak');
        Route::patch('/admin/kelulusan/{id}/{status}', [LombaController::class, 'aturKelulusan'])
            ->name('admin.kelulusan.atur');
    });
});


// 3. ROUTE AUTENTIKASI (LOGIN, REGISTER, LOGOUT)
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// 4. ROUTE DASHBOARD
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');


require __DIR__.'/auth.php';