<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\PrintController;

// Rute utama (landing page)
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Rute untuk menampilkan layout dengan navigasi dinamis
Route::get('/dashboard/{category?}', function ($category = 'tools') {
    return view('layouts.app', compact('category'));
})->name('dashboard');

// Resource routes untuk Anggota
Route::resource('anggotas', AnggotaController::class);

// Rute untuk menampilkan QR Code anggota
Route::get('anggotas/{anggota}/qr', [KehadiranController::class, 'showAnggotaQr'])->name('anggotas.showQr');
// Rute baru untuk mengunduh QR Code anggota
Route::get('anggotas/{anggota}/download-qr', [KehadiranController::class, 'downloadAnggotaQr'])->name('anggotas.downloadQr');

// Resource routes untuk Kegiatan (jika Anda ingin punya CRUD untuk kegiatan)
Route::resource('kegiatans', KegiatanController::class);

// --- Rute Spesifik untuk Fitur QR Code Kehadiran (PENTING: Ditempatkan sebelum resource 'kehadirans') ---
Route::get('kehadirans/scan-qr', [KehadiranController::class, 'scanQrForm'])->name('kehadirans.scanQrForm');
Route::post('kehadirans/process-qr-scan', [KehadiranController::class, 'processQrScan'])->name('kehadirans.processQrScan');
// Rute untuk pencarian anggota (AJAX)
Route::get('kehadirans/search-anggota', [KehadiranController::class, 'searchAnggota'])->name('kehadirans.searchAnggota');


// Resource routes untuk Kehadiran (Ditempatkan setelah rute spesifik 'kehadirans/*')
Route::resource('kehadirans', KehadiranController::class);


// --- RUTE UNTUK FITUR PRINT ---
Route::prefix('prints')->name('prints.')->group(function () {
    // Harian
    Route::get('daily', [PrintController::class, 'showDailyPrintForm'])->name('daily.form');
    Route::post('daily', [PrintController::class, 'printDaily'])->name('daily.generate');

    // Bulanan
    Route::get('monthly', [PrintController::class, 'showMonthlyPrintForm'])->name('monthly.form');
    Route::post('monthly', [PrintController::class, 'printMonthly'])->name('monthly.generate');

    // Tahunan
    Route::get('annual', [PrintController::class, 'showAnnualPrintForm'])->name('annual.form');
    Route::post('annual', [PrintController::class, 'printAnnual'])->name('annual.generate');
});