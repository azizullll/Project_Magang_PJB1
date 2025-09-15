<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;

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

// Data Karyawan CRUD
Route::resource('data-karyawan', EmployeeController::class)->parameters([
    'data-karyawan' => 'employee'
])->names('employees');

// Hapus sertifikat individual
Route::delete('/employees/{employee}/certificates/{certification}', [EmployeeController::class, 'destroyCertificate'])
    ->name('employees.certificates.destroy');

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