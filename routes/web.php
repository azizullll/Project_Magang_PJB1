<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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