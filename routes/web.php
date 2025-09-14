<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelatihanController;

// Landing Page
Route::get('/', function () {
    return view('landing_page');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

// Auth Routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman Data Karyawan
Route::get('/data-karyawan', function () {
    return view('data_karyawan');
});

// Halaman Pelatihan
Route::get('/pelatihan', function () {
    return view('pelatihan');
});

// Halaman Data Sertifikasi
Route::get('/data-sertifikasi', function () {
    return view('data_sertifikasi');
});

// Halaman Rekomendasi
Route::get('/rekomendasi', function () {
    return view('rekomendasi');
});

// API Routes untuk CRUD Pelatihan
Route::prefix('api/pelatihan')->group(function () {
    Route::get('/', [PelatihanController::class, 'index']); // GET /api/pelatihan - List semua pelatihan
    Route::post('/', [PelatihanController::class, 'store']); // POST /api/pelatihan - Tambah pelatihan baru
    Route::get('/search', [PelatihanController::class, 'search']); // GET /api/pelatihan/search?q=query - Search pelatihan
    Route::get('/{id}', [PelatihanController::class, 'show']); // GET /api/pelatihan/{id} - Detail pelatihan
    Route::put('/{id}', [PelatihanController::class, 'update']); // PUT /api/pelatihan/{id} - Update pelatihan
    Route::delete('/{id}', [PelatihanController::class, 'destroy']); // DELETE /api/pelatihan/{id} - Hapus pelatihan
});