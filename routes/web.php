<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParticipantController;
use Illuminate\Support\Facades\Route;

// Halaman Publik: Form Registrasi Pendaftaran
Route::get('/', [ParticipantController::class, 'create'])->name('home');
Route::get('/register', [ParticipantController::class, 'create'])->name('participants.create');
Route::post('/register', [ParticipantController::class, 'store'])->name('participants.store');

// Tiket QR Peserta
Route::get('/ticket/{token}', [ParticipantController::class, 'card'])->name('participants.card');

// Panel Admin: Dashboard Pendaftar & Presensi
Route::prefix('admin')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/participants/{participant}/toggle-checkin', [DashboardController::class, 'toggleCheckin'])->name('admin.participants.toggle');
    Route::delete('/participants/{participant}', [DashboardController::class, 'destroy'])->name('admin.participants.destroy');
    Route::get('/export/csv', [DashboardController::class, 'exportCsv'])->name('admin.export.csv');
    Route::get('/scan', function () {
        $recentAttended = \App\Models\Participant::where('status', 'attended')
            ->orderByDesc('attended_at')
            ->limit(10)
            ->get();
        return view('admin.scan', compact('recentAttended'));
    })->name('admin.scan');
});

// Shortcut /dashboard langsung ke /admin/dashboard
Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))->name('dashboard');

// Scanner Absensi Kamera
Route::get('/scan', [ParticipantController::class, 'scan'])->name('participants.scan');
Route::post('/scan/verify', [ParticipantController::class, 'verifyScan'])->name('participants.scan.verify');

// Alias data peserta ke dashboard admin
Route::get('/participants', fn () => redirect()->route('admin.dashboard'))->name('participants.index');
Route::delete('/participants/{participant}', [ParticipantController::class, 'destroy'])->name('participants.destroy');
