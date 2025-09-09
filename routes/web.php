<?php

// routes/web.php
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('landing_page');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
});

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