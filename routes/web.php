<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\RecommendationController;

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

// API untuk mendapatkan jabatan berdasarkan divisi
Route::get('/api/job-positions-by-division', [EmployeeController::class, 'getJobPositionsByDivision'])
    ->name('api.job-positions-by-division');

// API untuk mendapatkan level kompetensi berdasarkan jabatan
Route::get('/api/competency-level-by-job-position', [EmployeeController::class, 'getCompetencyLevelByJobPosition'])
    ->name('api.competency-level-by-job-position');

// Halaman Pelatihan
Route::get('/pelatihan', function () {
    return view('pelatihan');
});

// Training Management
Route::resource('trainings', TrainingController::class)->names('trainings');
Route::get('/api/trainings/search', [TrainingController::class, 'search'])->name('api.trainings.search');

// Recommendations
Route::get('/rekomendasi', [RecommendationController::class, 'index'])->name('recommendations.index');
Route::get('/api/recommendations', [RecommendationController::class, 'getRecommendations'])->name('api.recommendations');

// Data Sertifikasi Routes
Route::get('/data-sertifikasi', [CertificationController::class, 'index'])->name('certifications.index');
Route::get('/data-sertifikasi/create', [CertificationController::class, 'create'])->name('certifications.create');
Route::post('/data-sertifikasi', [CertificationController::class, 'store'])->name('certifications.store');
Route::get('/data-sertifikasi/{employee}', [CertificationController::class, 'show'])->name('certifications.show');

// Delete specific certification for employee
Route::delete('/data-sertifikasi/{employee}/certification/{certification}', [CertificationController::class, 'destroy'])
    ->name('certifications.destroy');

// API untuk mendapatkan detail training
Route::get('/api/training-details', [CertificationController::class, 'getTrainingDetails'])
    ->name('api.training-details');

// Halaman Data Sertifikasi & Rekomendasi dihapus

// API Routes untuk CRUD Pelatihan (aktifkan jika PelatihanController sudah dibuat)
// use App\Http\Controllers\PelatihanController;
// Route::prefix('api/pelatihan')->group(function () {
//     Route::get('/', [PelatihanController::class, 'index']);
//     Route::post('/', [PelatihanController::class, 'store']);
//     Route::get('/search', [PelatihanController::class, 'search']);
//     Route::get('/{id}', [PelatihanController::class, 'show']);
//     Route::put('/{id}', [PelatihanController::class, 'update']);
//     Route::delete('/{id}', [PelatihanController::class, 'destroy']);
// });