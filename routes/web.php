<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\TestDemoController;

// Dashboard homepage
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Demonstration of original ATS Test.php operations using Laravel models
Route::get('test-demo', [TestDemoController::class, 'runDemo'])->name('test.demo');

// CRUD Resources
Route::resource('pasien', PasienController::class);
Route::resource('dokter', DokterController::class);
Route::resource('jadwal', JadwalController::class);

// Match parameter binding to controller variable $rekamMedi
Route::resource('rekam-medis', RekamMedisController::class)->parameters([
    'rekam-medis' => 'rekamMedi'
]);
