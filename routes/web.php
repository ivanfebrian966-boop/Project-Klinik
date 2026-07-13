<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\Dokter\DokterDashboardController;
use App\Http\Controllers\Pasien\PasienDashboardController;

// -------------------------------------------------------
// PUBLIC ROUTES (tidak butuh login)
// -------------------------------------------------------

// Homepage redirect ke login atau ke dashboard sesuai role
Route::get('/', function () {
    if (session()->has('user_id')) {
        $role = session('user_role');
        return match($role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'dokter' => redirect()->route('dokter.dashboard'),
            'pasien' => redirect()->route('pasien.dashboard'),
            default  => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
})->name('home');

// Autentikasi
Route::get('/login',   [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',  [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registrasi khusus untuk pasien
Route::get('/register',  [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// -------------------------------------------------------
// ROUTES YANG BUTUH LOGIN
// -------------------------------------------------------
Route::middleware(['auth.klinik'])->group(function () {

    // ---- ADMIN ROUTES ----
    Route::middleware(['role.klinik:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Admin kelola data pasien
        Route::resource('pasien', PasienController::class);

        // Admin kelola data dokter
        Route::resource('dokter', DokterController::class);

        // Admin kelola jadwal
        Route::resource('jadwal', JadwalController::class);

        // Admin kelola rekam medis
        Route::resource('rekam-medis', RekamMedisController::class)->parameters([
            'rekam-medis' => 'rekamMedi',
        ]);
    });

    // ---- DOKTER ROUTES ----
    Route::middleware(['role.klinik:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
        Route::get('/dashboard', [DokterDashboardController::class, 'dashboard'])->name('dashboard');

        // Dokter melakukan diagnosa dan membuat rekam medis
        Route::get('/diagnosa', [DokterDashboardController::class, 'diagnosaIndex'])->name('diagnosa.index');
        Route::get('/diagnosa/{id}/isi', [DokterDashboardController::class, 'diagnosaForm'])->name('diagnosa.form');
        Route::post('/diagnosa/{id}/isi', [DokterDashboardController::class, 'diagnosaStore'])->name('diagnosa.store');
        Route::post('/rekam-medis/buat', [DokterDashboardController::class, 'buatRekamMedis'])->name('rekam.buat');
    });

    // ---- PASIEN ROUTES ----
    Route::middleware(['role.klinik:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
        Route::get('/dashboard', [PasienDashboardController::class, 'dashboard'])->name('dashboard');

        // Pasien melakukan booking jadwal
        Route::get('/booking', [PasienDashboardController::class, 'bookingIndex'])->name('booking.index');
        Route::post('/booking', [PasienDashboardController::class, 'bookingProses'])->name('booking.proses');
    });
});
