<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

// Beranda & Ringkasan
Route::get('/', [HomeController::class, 'index'])->name('home');

// Verifikasi Publik Sertifikat
Route::get('/verifikasi', [VerificationController::class, 'index'])->name('verify.index');
Route::post('/verifikasi', [VerificationController::class, 'search'])->name('verify.search');
Route::get('/verifikasi/{token}', [VerificationController::class, 'show'])->name('verify.show');

// Manajemen Acara
Route::resource('events', EventController::class);

// Manajemen Sertifikat dalam Acara
Route::get('/events/{event}/certificates/create', [CertificateController::class, 'create'])->name('certificates.create');
Route::post('/events/{event}/certificates', [CertificateController::class, 'store'])->name('certificates.store');
Route::get('/events/{event}/certificates/bulk', [CertificateController::class, 'bulkCreate'])->name('certificates.bulk.create');
Route::post('/events/{event}/certificates/bulk', [CertificateController::class, 'bulkStore'])->name('certificates.bulk.store');

// PDF Sertifikat
Route::get('/certificates/{certificate}/pdf', [CertificateController::class, 'showPdf'])->name('certificates.pdf.show');
Route::get('/certificates/{certificate}/download', [CertificateController::class, 'downloadPdf'])->name('certificates.pdf.download');
Route::delete('/certificates/{certificate}', [CertificateController::class, 'destroy'])->name('certificates.destroy');
