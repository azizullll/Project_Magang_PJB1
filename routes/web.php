<?php

// routes/web.php
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('landing_page');
});

// Halaman Data Karyawan
Route::get('/cek-kompetensi', function () {
    return view('cek_kompetensi');
});
