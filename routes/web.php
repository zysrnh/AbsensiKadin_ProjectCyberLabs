<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventSettingController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\WaSettingController;
use Illuminate\Support\Facades\Route;

// Halaman Publik: Undangan Digital & Form Registrasi Pendaftaran Ala Luma
Route::get('/', [ParticipantController::class, 'event'])->name('home');
Route::get('/invitation', [ParticipantController::class, 'event'])->name('participants.invitation');
Route::get('/register', [ParticipantController::class, 'create'])->name('participants.create');
Route::post('/register', [ParticipantController::class, 'store'])->name('participants.store');
Route::get('/requested/{token}', [ParticipantController::class, 'requested'])->name('participants.requested');

// Tiket QR Peserta & Endpoint Raw Image untuk Twilio MediaUrl
Route::get('/ticket/{token}', [ParticipantController::class, 'card'])->name('participants.card');
Route::get('/ticket/{token}/qr-image', [ParticipantController::class, 'qrImage'])->name('participants.qr-image');

// Konfirmasi Kehadiran / RSVP Cepat 1-Klik
Route::get('/rsvp/{token}/{status}', [ParticipantController::class, 'rsvp'])->name('participants.rsvp');

// Webhook Masuk Twilio WhatsApp (Quick Reply / Interactive Messages)
Route::post('/twilio/webhook', [WaSettingController::class, 'handleTwilioWebhook'])->name('twilio.webhook');
Route::post('/api/twilio/webhook', [WaSettingController::class, 'handleTwilioWebhook'])->name('api.twilio.webhook');

// Autentikasi Administrator
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Panel Admin: Diproteksi Middleware Auth
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/participants/{participant}/toggle-checkin', [DashboardController::class, 'toggleCheckin'])->name('admin.participants.toggle');
    Route::post('/participants/{participant}/twilio', [WaSettingController::class, 'blastTwilio'])->name('admin.participants.twilio');
    Route::delete('/participants/{participant}', [DashboardController::class, 'destroy'])->name('admin.participants.destroy');
    Route::post('/participants/bulk-delete', [DashboardController::class, 'bulkDestroy'])->name('admin.participants.bulk-destroy');
    Route::get('/export/csv', [DashboardController::class, 'exportCsv'])->name('admin.export.csv');
    Route::get('/export/excel', [DashboardController::class, 'exportExcel'])->name('admin.export.excel');
    
    // Cetak ID Card Lanyard / Name Tag Peserta
    Route::get('/participants/id-cards/bulk', [DashboardController::class, 'printBulkIdCards'])->name('admin.participants.id-cards.bulk');
    Route::get('/participants/{participant}/id-card', [DashboardController::class, 'printIdCard'])->name('admin.participants.id-card');
    Route::post('/participants/id-cards/settings', [DashboardController::class, 'saveIdCardSettings'])->name('admin.participants.id-cards.settings.save');
    Route::post('/participants/id-cards/settings/reset', [DashboardController::class, 'resetIdCardSettings'])->name('admin.participants.id-cards.settings.reset');
    
    // Pengaturan Template WA & Twilio
    Route::get('/wa-settings', [WaSettingController::class, 'index'])->name('admin.wa-settings');
    Route::post('/wa-settings', [WaSettingController::class, 'update'])->name('admin.wa-settings.update');
    Route::post('/wa-settings/test', [WaSettingController::class, 'testSend'])->name('admin.wa-settings.test');
    // Kirim & Kelola Undangan Pendaftaran Acara
    Route::get('/invitation', [WaSettingController::class, 'invitationPage'])->name('admin.invitation');
    Route::post('/invitation/send', [WaSettingController::class, 'sendInvitation'])->name('admin.invitation.send');
    Route::post('/invitation/send-bulk', [WaSettingController::class, 'sendBulkInvitation'])->name('admin.invitation.send-bulk');
    Route::post('/invitation/deadline', [WaSettingController::class, 'updateInvitationDeadline'])->name('admin.invitation.deadline');

    // Kirim & Kelola Tiket Presensi QR Peserta
    Route::get('/send-tickets', [WaSettingController::class, 'ticketPage'])->name('admin.tickets');
    Route::post('/send-tickets/send-single', [WaSettingController::class, 'sendSingleTicket'])->name('admin.tickets.send-single');
    Route::post('/send-tickets/send-bulk', [WaSettingController::class, 'sendBulkTicket'])->name('admin.tickets.send-bulk');

    // Kirim & Kelola Pengingat (Reminder H-1 / Hari-H dengan RSVP Yes/No)
    Route::get('/reminder', [WaSettingController::class, 'reminderPage'])->name('admin.reminder');
    Route::post('/reminder/settings', [WaSettingController::class, 'saveReminderSettings'])->name('admin.reminder.settings');
    Route::post('/reminder/send-single', [WaSettingController::class, 'sendSingleReminder'])->name('admin.reminder.send-single');
    Route::post('/reminder/send-bulk', [WaSettingController::class, 'sendBulkReminder'])->name('admin.reminder.send-bulk');

    // Upload Flyer WhatsApp AJAX
    Route::post('/wa/upload-flyer', [WaSettingController::class, 'uploadFlyer'])->name('admin.wa.upload-flyer');

    // Pengaturan Acara (Luma Event Landing)
    Route::get('/event-settings', [EventSettingController::class, 'index'])->name('admin.event-settings');
    Route::post('/event-settings', [EventSettingController::class, 'update'])->name('admin.event-settings.update');

    // Scanner Presensi Admin
    Route::get('/scan', function () {
        $recentAttended = \App\Models\Participant::where('status', 'attended')
            ->orderByDesc('attended_at')
            ->limit(10)
            ->get();
        return view('admin.scan', compact('recentAttended'));
    })->name('admin.scan');

    // Layar Sambutan TV / Live Welcome Screen Real-time
    Route::get('/display', [DashboardController::class, 'displayScreen'])->name('admin.display');
    Route::get('/display/latest', [DashboardController::class, 'latestCheckin'])->name('admin.display.latest');
});

// Shortcut /dashboard langsung ke /admin/dashboard
Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))->name('dashboard');

// Scanner Absensi Kamera API
Route::get('/scan', [ParticipantController::class, 'scan'])->name('participants.scan');
Route::post('/scan/verify', [ParticipantController::class, 'verifyScan'])->name('participants.scan.verify');

// ─── API Mobile Flutter Scanner ───
Route::prefix('api')->group(function () {
    Route::post('/login', [AuthController::class, 'apiLogin'])->name('api.login');
    Route::post('/scan/verify', [ParticipantController::class, 'verifyScan'])->name('api.scan.verify');
});

// Legacy routes alias
Route::get('/participants', fn () => redirect()->route('admin.dashboard'))->name('participants.index');
Route::delete('/participants/{participant}', [ParticipantController::class, 'destroy'])->name('participants.destroy');
