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

// Halaman Input Data
Route::get('/input', function () {
    return view('input');
});

// Halaman Kompetensi
Route::get('/kompetensi', function () {
    return view('kompetensi');
});

// Halaman Pelatihan
Route::get('/pelatihan', function () {
    return view('pelatihan');
});

// Halaman Pengaturan
Route::get('/pengaturan', function () {
    return view('pengaturan');
});

// Halaman Cek Kompetensi
Route::get('/cek-kompetensi', function () {
    return view('cek_kompetensi');
});