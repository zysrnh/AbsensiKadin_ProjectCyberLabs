<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\WaSettingController;
use Illuminate\Support\Facades\Route;

// Halaman Publik: Form Registrasi Pendaftaran
Route::get('/', [ParticipantController::class, 'create'])->name('home');
Route::get('/register', [ParticipantController::class, 'create'])->name('participants.create');
Route::post('/register', [ParticipantController::class, 'store'])->name('participants.store');

// Tiket QR Peserta & Endpoint Raw Image untuk Twilio MediaUrl
Route::get('/ticket/{token}', [ParticipantController::class, 'card'])->name('participants.card');
Route::get('/ticket/{token}/qr-image', [ParticipantController::class, 'qrImage'])->name('participants.qr-image');

// Panel Admin: Dashboard Pendaftar & Pengaturan Presensi
Route::prefix('admin')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/participants/{participant}/toggle-checkin', [DashboardController::class, 'toggleCheckin'])->name('admin.participants.toggle');
    Route::post('/participants/{participant}/twilio', [WaSettingController::class, 'blastTwilio'])->name('admin.participants.twilio');
    Route::delete('/participants/{participant}', [DashboardController::class, 'destroy'])->name('admin.participants.destroy');
    Route::get('/export/csv', [DashboardController::class, 'exportCsv'])->name('admin.export.csv');
    
    // Pengaturan Template WA & Twilio
    Route::get('/wa-settings', [WaSettingController::class, 'index'])->name('admin.wa-settings');
    Route::post('/wa-settings', [WaSettingController::class, 'update'])->name('admin.wa-settings.update');
    Route::post('/wa-settings/test', [WaSettingController::class, 'testSend'])->name('admin.wa-settings.test');

    // Scanner Presensi Admin
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

// Scanner Absensi Kamera API
Route::get('/scan', [ParticipantController::class, 'scan'])->name('participants.scan');
Route::post('/scan/verify', [ParticipantController::class, 'verifyScan'])->name('participants.scan.verify');

// Legacy routes alias
Route::get('/participants', fn () => redirect()->route('admin.dashboard'))->name('participants.index');
Route::delete('/participants/{participant}', [ParticipantController::class, 'destroy'])->name('participants.destroy');
