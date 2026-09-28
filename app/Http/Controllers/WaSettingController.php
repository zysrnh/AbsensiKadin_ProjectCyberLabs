<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Setting;
use App\Services\TwilioService;
use Illuminate\Http\Request;

class WaSettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan template pesan & Twilio
     */
    public function index()
    {
        $defaultTemplate = "Halo Bapak/Ibu *{nama}*,\n\n"
            . "Terima kasih telah melakukan registrasi kegiatan KADIN 2026.\n\n"
            . "Berikut adalah tiket presensi QR Code Anda:\n"
            . "🔗 {link_tiket}\n\n"
            . "Kode Tiket: *{kode_tiket}*\n"
            . "Instansi: {instansi}\n"
            . "Jabatan: {jabatan}\n\n"
            . "Silakan tunjukkan QR Code pada gambar/tautan terlampir kepada petugas saat tiba di lokasi acara.\n\n"
            . "Salam hangat,\n*Panitia KADIN 2026*";

        $defaultInvitationTemplate = "Yth. Bapak/Ibu *{nama}*,\n\n"
            . "Kamar Dagang dan Industri (KADIN) Indonesia dengan hormat mengundang Anda untuk hadir pada kegiatan:\n\n"
            . "📌 *{nama_acara}*\n"
            . "📅 Tanggal: {tanggal}\n"
            . "⏰ Waktu: {waktu}\n"
            . "📍 Tempat: {venue}\n"
            . "👔 Dresscode: {dresscode}\n\n"
            . "Mengingat kuota tempat terbatas, mohon kesediaan Bapak/Ibu untuk mengisi formulir kehadiran melalui tautan resmi berikut:\n"
            . "🔗 {link_form}\n\n"
            . "Terima kasih atas perhatian dan kerja sama Bapak/Ibu.\n\n"
            . "Salam hormat,\n*Panitia KADIN Indonesia 2026*";

        $template = Setting::get('wa_template', $defaultTemplate);
        $invitationTemplate = Setting::get('wa_invitation_template', $defaultInvitationTemplate);
        $attachQr = Setting::get('wa_attach_qr', '1');
        $twilioMode = Setting::get('twilio_mode', 'freeform');
        $twilioSid = Setting::get('twilio_sid', env('TWILIO_SID', ''));
        $twilioToken = Setting::get('twilio_token', env('TWILIO_AUTH_TOKEN', ''));
        $twilioFrom = Setting::get('twilio_from', env('TWILIO_WHATSAPP_FROM', '+14155238886'));
        $twilioTemplateId = Setting::get('twilio_template_id', '');
        $twilioInvitationTemplateId = Setting::get('twilio_invitation_template_id', '');
        $twilioReminderTemplateId = Setting::get('twilio_reminder_template_id', '');

        // Sample peserta untuk live preview
        $sample = Participant::first() ?? new Participant([
            'name' => 'Budi Santoso, S.E.',
            'company' => 'PT Sumber Pangan Indonesia',
            'position' => 'Direktur Operasional',
            'phone' => '081234567890',
            'qr_token' => 'KD26-EXMPL01',
        ]);

        $previewText = TwilioService::parseTemplate($template, $sample);

        return view('admin.wa-settings', compact(
            'template',
            'invitationTemplate',
            'attachQr',
            'twilioMode',
            'twilioSid',
            'twilioToken',
            'twilioFrom',
            'twilioTemplateId',
            'twilioInvitationTemplateId',
            'twilioReminderTemplateId',
            'sample',
            'previewText'
        ));
    }

    /**
     * Simpan pembaruan pengaturan
     */
    public function update(Request $request)
    {
        $request->validate([
            'wa_template' => 'required|string',
            'wa_invitation_template' => 'nullable|string',
            'twilio_mode' => 'required|in:freeform,template',
            'twilio_sid' => 'nullable|string',
            'twilio_token' => 'nullable|string',
            'twilio_from' => 'nullable|string',
            'twilio_template_id' => 'nullable|string',
            'twilio_invitation_template_id' => 'nullable|string',
            'twilio_reminder_template_id' => 'nullable|string',
        ]);

        Setting::set('wa_template', $request->wa_template);
        if ($request->filled('wa_invitation_template')) {
            Setting::set('wa_invitation_template', $request->wa_invitation_template);
        }
        Setting::set('wa_attach_qr', $request->has('wa_attach_qr') ? '1' : '0');
        Setting::set('twilio_mode', $request->twilio_mode);
        Setting::set('twilio_sid', $request->twilio_sid);
        Setting::set('twilio_token', $request->twilio_token);
        Setting::set('twilio_from', $request->twilio_from);
        Setting::set('twilio_template_id', $request->twilio_template_id);
        Setting::set('twilio_invitation_template_id', $request->twilio_invitation_template_id);
        Setting::set('twilio_reminder_template_id', $request->twilio_reminder_template_id);

        return redirect()->back()->with('success', 'Pengaturan template WhatsApp & Twilio berhasil disimpan!');
    }

    /**
     * Kirim blast pesan undangan pendaftaran via Twilio API
     */
    public function sendInvitation(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'name' => 'nullable|string',
            'message' => 'nullable|string',
            'custom_message' => 'nullable|string',
            'content_sid' => 'nullable|string',
        ]);

        $message = $request->message ?? $request->custom_message;

        $result = TwilioService::sendInvitation(
            toPhone: $request->phone,
            name: $request->name,
            customMessage: $message,
            contentSidOverride: $request->content_sid
        );

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Simpan batas waktu kadaluarsa undangan & pendaftaran
     */
    public function updateInvitationDeadline(Request $request)
    {
        $request->validate([
            'enabled' => 'nullable',
            'registration_deadline' => 'nullable|string',
            'registration_deadline_text' => 'nullable|string',
        ]);

        $enabled = ($request->boolean('enabled') || $request->enabled === '1' || $request->enabled === 1 || $request->enabled === 'true') ? '1' : '0';
        $deadline = $request->registration_deadline ?? '';
        $deadlineText = $request->registration_deadline_text ?? '';

        if (!empty($deadline) && empty($deadlineText)) {
            try {
                $deadlineText = \Carbon\Carbon::parse($deadline)->translatedFormat('d F Y, H:i') . ' WIB';
            } catch (\Throwable $e) {
                $deadlineText = $deadline;
            }
        }

        Setting::set('registration_deadline_enabled', $enabled);
        Setting::set('registration_deadline', $deadline);
        Setting::set('registration_deadline_text', $deadlineText);

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan batas kadaluarsa undangan berhasil disimpan!',
            'data' => [
                'enabled' => $enabled === '1',
                'deadline' => $deadline,
                'deadline_text' => $deadlineText,
            ]
        ]);
    }

    /**
     * Kirim pesan uji coba ke nomor tester
     */
    public function testSend(Request $request)
    {
        $request->validate([
            'test_phone' => 'required|string',
        ]);

        $sample = Participant::first() ?? new Participant([
            'name' => 'Tester KADIN',
            'company' => 'Kadin Indonesia',
            'position' => 'Peninjau Sistem',
            'phone' => $request->test_phone,
            'qr_token' => 'KD26-TEST001',
        ]);

        $result = TwilioService::sendTicket($sample, $request->test_phone);

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    /**
     * Kirim tiket otomatis via Twilio langsung ke 1 peserta dari Dashboard
     */
    public function blastTwilio(Participant $participant)
    {
        $result = TwilioService::sendTicket($participant);

        if ($result['success']) {
            return redirect()->back()->with('success', "Tiket berhasil dikirim ke WhatsApp {$participant->name} via Twilio!");
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    /**
     * Tampilkan halaman khusus pembuatan & pengiriman undangan pendaftaran
     */
    public function invitationPage()
    {
        $defaultInvitationTemplate = "Yth. Bapak/Ibu *{nama}*,\n\n"
            . "Kamar Dagang dan Industri (KADIN) Indonesia dengan hormat mengundang Anda untuk hadir pada kegiatan:\n\n"
            . "📌 *{nama_acara}*\n"
            . "📅 Tanggal: {tanggal}\n"
            . "⏰ Waktu: {waktu}\n"
            . "📍 Tempat: {venue}\n"
            . "👔 Dresscode: {dresscode}\n\n"
            . "Mengingat kuota tempat terbatas, mohon kesediaan Bapak/Ibu untuk mengisi formulir kehadiran melalui tautan resmi berikut:\n"
            . "🔗 {link_form}\n\n"
            . "⏳ Batas Akhir Konfirmasi: {batas_waktu}\n\n"
            . "Terima kasih atas perhatian dan kerja sama Bapak/Ibu.\n\n"
            . "Salam hormat,\n*Panitia KADIN Indonesia 2026*";

        $invitationTemplate = Setting::get('wa_invitation_template', $defaultInvitationTemplate);
        
        $deadlineEnabled = Setting::get('registration_deadline_enabled', '0') === '1';
        $deadlineDatetime = Setting::get('registration_deadline', '2026-10-27T23:59');
        $deadlineText = Setting::get('registration_deadline_text', '27 Oktober 2026, 23:59 WIB');

        $deadlineSettings = [
            'enabled' => $deadlineEnabled,
            'deadline' => $deadlineDatetime,
            'deadline_text' => $deadlineText,
        ];

        $eventSettings = [
            'nama_acara' => Setting::get('event_title', 'Musyawarah & Temu Bisnis KADIN Indonesia 2026'),
            'tanggal' => Setting::get('event_date', '28 Oktober 2026'),
            'waktu' => Setting::get('event_time', '08:30 - 16:30 WIB'),
            'venue' => Setting::get('event_venue_name', 'Grand Ballroom Menara Kadin Indonesia'),
            'dresscode' => Setting::get('event_dresscode', 'Batik Formal / Pakaian Bisnis Rapi'),
            'link_form' => route('home'),
            'batas_waktu' => $deadlineEnabled ? $deadlineText : 'Sesuai kuota tersedia',
        ];

        $participants = Participant::latest()->get();
        $contentSidInvitation = Setting::get('twilio_invitation_template_id', '');

        return view('admin.invitation', compact('invitationTemplate', 'eventSettings', 'participants', 'deadlineSettings', 'contentSidInvitation'));
    }

    /**
     * Kirim undangan pendaftaran massal (bulk blast) via Twilio ke tamu terpilih
     */
    public function sendBulkInvitation(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:participants,id',
            'custom_message' => 'nullable|string',
            'content_sid' => 'nullable|string',
        ]);

        $participants = Participant::whereIn('id', $request->ids)->get();

        if ($participants->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada tamu yang dipilih.',
            ], 400);
        }

        $defaultInvitationTemplate = "Yth. Bapak/Ibu *{nama}*,\n\n"
            . "Kamar Dagang dan Industri (KADIN) Indonesia dengan hormat mengundang Anda untuk hadir pada kegiatan:\n\n"
            . "📌 *{nama_acara}*\n"
            . "📅 Tanggal: {tanggal}\n"
            . "⏰ Waktu: {waktu}\n"
            . "📍 Tempat: {venue}\n"
            . "👔 Dresscode: {dresscode}\n\n"
            . "Mengingat kuota tempat terbatas, mohon kesediaan Bapak/Ibu untuk mengisi formulir kehadiran melalui tautan resmi berikut:\n"
            . "🔗 {link_form}\n\n"
            . "⏳ Batas Akhir Konfirmasi: {batas_waktu}\n\n"
            . "Terima kasih atas perhatian dan kerja sama Bapak/Ibu.\n\n"
            . "Salam hormat,\n*Panitia KADIN Indonesia 2026*";

        $template = $request->filled('custom_message') 
            ? $request->custom_message 
            : Setting::get('wa_invitation_template', $defaultInvitationTemplate);

        $eventTitle = Setting::get('event_title', 'Musyawarah & Temu Bisnis KADIN Indonesia 2026');
        $eventDate = Setting::get('event_date', '28 Oktober 2026');
        $eventTime = Setting::get('event_time', '08:30 - 16:30 WIB');
        $eventVenue = Setting::get('event_venue_name', 'Grand Ballroom Menara Kadin Indonesia');
        $eventDresscode = Setting::get('event_dresscode', 'Batik Formal / Pakaian Bisnis Rapi');
        $linkForm = route('home');
        
        $deadlineEnabled = Setting::get('registration_deadline_enabled', '0') === '1';
        $deadlineText = Setting::get('registration_deadline_text', '27 Oktober 2026, 23:59 WIB');
        $batasWaktu = $deadlineEnabled ? $deadlineText : 'Sesuai kuota tersedia';

        $sentCount = 0;
        $failCount = 0;

        foreach ($participants as $participant) {
            $msg = str_replace([
                '{nama}',
                '{nama_acara}',
                '{tanggal}',
                '{waktu}',
                '{venue}',
                '{dresscode}',
                '{link_form}',
                '{batas_waktu}',
                '{kadaluarsa}',
            ], [
                $participant->name,
                $eventTitle,
                $eventDate,
                $eventTime,
                $eventVenue,
                $eventDresscode,
                $linkForm,
                $batasWaktu,
                $batasWaktu,
            ], $template);

            $result = TwilioService::sendInvitation(
                toPhone: $participant->phone,
                name: $participant->name,
                customMessage: $msg,
                contentSidOverride: $request->content_sid
            );

            if ($result['success']) {
                $sentCount++;
            } else {
                $failCount++;
            }
        }

        return response()->json([
            'success' => $sentCount > 0,
            'sent_count' => $sentCount,
            'fail_count' => $failCount,
            'message' => "Blast selesai: {$sentCount} undangan berhasil dikirim via Twilio." . ($failCount > 0 ? " ({$failCount} gagal)." : ""),
        ]);
    }

    /**
     * Tampilkan halaman khusus pembuatan & pengiriman Tiket QR Presensi
     */
    public function ticketPage()
    {
        $defaultTemplate = "Halo Bapak/Ibu *{nama}*,\n\n"
            . "Terima kasih telah melakukan registrasi kegiatan KADIN 2026.\n\n"
            . "Berikut adalah tiket presensi QR Code Anda:\n"
            . "🔗 {link_tiket}\n\n"
            . "Kode Tiket: *{kode_tiket}*\n"
            . "Instansi: {instansi}\n"
            . "Jabatan: {jabatan}\n\n"
            . "Silakan tunjukkan QR Code pada gambar/tautan terlampir kepada petugas saat tiba di lokasi acara.\n\n"
            . "Salam hangat,\n*Panitia KADIN 2026*";

        $template = Setting::get('wa_template', $defaultTemplate);
        $participants = Participant::latest()->get();

        // Sample peserta untuk live preview di samping kanan
        $sample = $participants->first() ?? new Participant([
            'name' => 'Bpk. Ir. Hendro Wibowo',
            'company' => 'Kadin Jawa Barat',
            'position' => 'Wakil Ketua Bidang Perdagangan',
            'phone' => '081234567890',
            'qr_token' => 'KD26-EXMPL01',
        ]);

        return view('admin.tickets', compact('template', 'participants', 'sample'));
    }

    /**
     * Kirim tiket presensi QR ke 1 peserta / nomor tujuan
     */
    public function sendSingleTicket(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'participant_id' => 'nullable|exists:participants,id',
            'custom_message' => 'nullable|string',
        ]);

        if ($request->filled('participant_id')) {
            $participant = Participant::findOrFail($request->participant_id);
        } else {
            $participant = Participant::first() ?? new Participant([
                'name' => 'Tamu Kehormatan',
                'company' => 'KADIN Indonesia',
                'position' => 'Peserta',
                'phone' => $request->phone,
                'qr_token' => 'KD26-' . strtoupper(Str::random(8)),
            ]);
        }

        $result = TwilioService::sendTicket(
            participant: $participant,
            toPhoneOverride: $request->phone,
            customTemplate: $request->custom_message
        );

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Kirim tiket presensi QR massal (bulk blast) via Twilio ke peserta terpilih
     */
    public function sendBulkTicket(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:participants,id',
            'custom_message' => 'nullable|string',
        ]);

        $participants = Participant::whereIn('id', $request->ids)->get();

        if ($participants->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada peserta yang dipilih.',
            ], 400);
        }

        $sentCount = 0;
        $failCount = 0;

        foreach ($participants as $participant) {
            $result = TwilioService::sendTicket(
                participant: $participant,
                customTemplate: $request->custom_message
            );

            if ($result['success']) {
                $sentCount++;
            } else {
                $failCount++;
            }
        }

        return response()->json([
            'success' => $sentCount > 0,
            'sent_count' => $sentCount,
            'fail_count' => $failCount,
            'message' => "Blast tiket selesai: {$sentCount} tiket QR berhasil dikirim via Twilio." . ($failCount > 0 ? " ({$failCount} gagal)." : ""),
        ]);
    }

    /**
     * Tampilkan halaman khusus pembuatan & pengiriman Pengingat (Reminder H-1 / Hari-H)
     */
    public function reminderPage()
    {
        $defaultReminderTemplate = "Halo Bapak/Ibu *{nama}*,\n\n"
            . "Mengingatkan kembali bahwa agenda *{nama_acara}* akan berlangsung pada:\n"
            . "📅 Hari/Tgl: {tanggal}\n"
            . "⏰ Waktu: {waktu}\n"
            . "📍 Tempat: {venue}\n"
            . "👔 Dresscode: {dresscode}\n\n"
            . "Tiket QR Presensi Anda:\n🔗 {link_tiket}\n\n"
            . "Mohon konfirmasi kesediaan kehadiran Bapak/Ibu melalui tautan berikut:\n"
            . "✅ *Pasti Hadir:* {link_konfirmasi_hadir}\n"
            . "❌ *Berhalangan:* {link_konfirmasi_batal}\n\n"
            . "Terima kasih atas kerja samanya.\n*Panitia KADIN Indonesia 2026*";

        $reminderTemplate = Setting::get('wa_reminder_template', $defaultReminderTemplate);
        $contentSidReminder = Setting::get('twilio_reminder_template_id', '');
        $participants = Participant::latest()->get();

        $eventSettings = [
            'nama_acara' => Setting::get('event_title', 'Musyawarah & Temu Bisnis KADIN Indonesia 2026'),
            'tanggal' => Setting::get('event_date', '28 Oktober 2026'),
            'waktu' => Setting::get('event_time', '08:30 - 16:30 WIB'),
            'venue' => Setting::get('event_venue_name', 'Grand Ballroom Menara Kadin Indonesia'),
            'dresscode' => Setting::get('event_dresscode', 'Batik Formal / Pakaian Bisnis Rapi'),
        ];

        $sample = $participants->first() ?? new Participant([
            'name' => 'Bpk. Ir. Hendro Wibowo',
            'company' => 'Kadin Jawa Barat',
            'position' => 'Wakil Ketua Bidang Perdagangan',
            'phone' => '081234567890',
            'qr_token' => 'KD26-EXMPL01',
        ]);

        return view('admin.reminder', compact(
            'reminderTemplate',
            'contentSidReminder',
            'participants',
            'eventSettings',
            'sample'
        ));
    }

    /**
     * Simpan template & Content SID khusus reminder
     */
    public function saveReminderSettings(Request $request)
    {
        $request->validate([
            'wa_reminder_template' => 'required|string',
            'twilio_reminder_template_id' => 'nullable|string',
        ]);

        Setting::set('wa_reminder_template', $request->wa_reminder_template);
        Setting::set('twilio_reminder_template_id', $request->twilio_reminder_template_id ?? '');

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan template reminder berhasil disimpan!',
        ]);
    }

    /**
     * Kirim reminder ke 1 peserta / nomor tujuan
     */
    public function sendSingleReminder(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'participant_id' => 'nullable|exists:participants,id',
            'custom_message' => 'nullable|string',
            'content_sid' => 'nullable|string',
        ]);

        if ($request->filled('participant_id')) {
            $participant = Participant::findOrFail($request->participant_id);
        } else {
            $participant = Participant::first() ?? new Participant([
                'name' => 'Tamu Kehormatan',
                'company' => 'KADIN Indonesia',
                'position' => 'Peserta',
                'phone' => $request->phone,
                'qr_token' => 'KD26-TEST001',
            ]);
        }

        $result = TwilioService::sendReminder(
            participant: $participant,
            toPhoneOverride: $request->phone,
            customTemplate: $request->custom_message,
            contentSidOverride: $request->content_sid
        );

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Kirim reminder massal (bulk blast) via Twilio ke peserta terpilih
     */
    public function sendBulkReminder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:participants,id',
            'custom_message' => 'nullable|string',
            'content_sid' => 'nullable|string',
        ]);

        $participants = Participant::whereIn('id', $request->ids)->get();

        if ($participants->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada peserta yang dipilih.',
            ], 400);
        }

        $sentCount = 0;
        $failCount = 0;

        foreach ($participants as $participant) {
            $result = TwilioService::sendReminder(
                participant: $participant,
                customTemplate: $request->custom_message,
                contentSidOverride: $request->content_sid
            );

            if ($result['success']) {
                $sentCount++;
            } else {
                $failCount++;
            }
        }

        return response()->json([
            'success' => $sentCount > 0,
            'sent_count' => $sentCount,
            'fail_count' => $failCount,
            'message' => "Blast reminder selesai: {$sentCount} pesan berhasil dikirim via Twilio." . ($failCount > 0 ? " ({$failCount} gagal)." : ""),
        ]);
    }

    /**
     * Webhook Handler untuk Pesan Balasan Masuk dari Twilio WhatsApp (Quick Reply / Text RSVP)
     */
    public function handleTwilioWebhook(Request $request)
    {
        $from = $request->input('From', ''); // whatsapp:+628xxx
        $body = trim(strtolower($request->input('Body', '')));
        $buttonPayload = trim(strtolower($request->input('ButtonPayload', '')));
        $buttonText = trim(strtolower($request->input('ButtonText', '')));

        // Bersihkan nomor pengirim
        $cleanPhone = preg_replace('/[^0-9]/', '', $from);
        if (str_starts_with($cleanPhone, '62')) {
            $shortPhone = '0' . substr($cleanPhone, 2);
        } else {
            $shortPhone = $cleanPhone;
        }

        // Cari peserta berdasarkan nomor telepon
        $participant = Participant::where('phone', $cleanPhone)
            ->orWhere('phone', $shortPhone)
            ->orWhere('phone', '+' . $cleanPhone)
            ->orWhere('phone', 'like', "%{$shortPhone}%")
            ->latest()
            ->first();

        $replyMessage = "";

        if ($participant) {
            $isYes = str_contains($body, 'hadir') || str_contains($body, 'ya') || str_contains($body, 'yes')
                || str_contains($buttonPayload, 'yes') || str_contains($buttonText, 'hadir') || str_contains($buttonText, 'ya');

            $isNo = str_contains($body, 'batal') || str_contains($body, 'tidak') || str_contains($body, 'no')
                || str_contains($body, 'berhalangan') || str_contains($buttonPayload, 'no') || str_contains($buttonText, 'berhalangan');

            if ($isYes) {
                $participant->update([
                    'rsvp_status' => 'confirmed_yes',
                    'rsvp_at' => now(),
                ]);
                $replyMessage = "Terima kasih Bapak/Ibu {$participant->name}, konfirmasi kehadiran Anda telah kami catat. Tiket presensi dapat diakses di: " . route('participants.card', $participant->qr_token);
            } elseif ($isNo) {
                $participant->update([
                    'rsvp_status' => 'confirmed_no',
                    'rsvp_at' => now(),
                ]);
                $replyMessage = "Terima kasih informasinya Bapak/Ibu {$participant->name}, kami telah mencatat bahwa Anda berhalangan hadir.";
            }
        }

        // Format TwiML XML Response
        $twiml = '<?xml version="1.0" encoding="UTF-8"?><Response>';
        if (!empty($replyMessage)) {
            $twiml .= '<Message>' . htmlspecialchars($replyMessage) . '</Message>';
        }
        $twiml .= '</Response>';

        return response($twiml, 200, ['Content-Type' => 'text/xml']);
    }
}
