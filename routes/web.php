<?php

use App\Http\Controllers\ParticipantController;
use Illuminate\Support\Facades\Route;

// Halaman utama: Form Registrasi Pendaftaran
Route::get('/', [ParticipantController::class, 'create'])->name('home');

// Registrasi Peserta
Route::get('/register', [ParticipantController::class, 'create'])->name('participants.create');
Route::post('/register', [ParticipantController::class, 'store'])->name('participants.store');

// Tiket QR Peserta
Route::get('/ticket/{token}', [ParticipantController::class, 'card'])->name('participants.card');

// Daftar Peserta & Blast WhatsApp (Panitia)
Route::get('/participants', [ParticipantController::class, 'index'])->name('participants.index');
Route::delete('/participants/{participant}', [ParticipantController::class, 'destroy'])->name('participants.destroy');

// Scanner Absensi Kamera
Route::get('/scan', [ParticipantController::class, 'scan'])->name('participants.scan');
Route::post('/scan/verify', [ParticipantController::class, 'verifyScan'])->name('participants.scan.verify');

