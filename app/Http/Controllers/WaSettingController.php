<?php

namespace App\Http\Controllers;

use App\Models\InvitationGuest;
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
        $twilioMode = Setting::get('twilio_mode', 'template');
        $twilioSid = Setting::get('twilio_sid', env('TWILIO_SID', ''));
        $twilioToken = Setting::get('twilio_token', env('TWILIO_AUTH_TOKEN', ''));
        $twilioFrom = Setting::get('twilio_from', env('TWILIO_WHATSAPP_FROM', '+14155238886'));
        $twilioTemplateId = Setting::get('twilio_template_id', 'HXb5bb1bdad43f0d1d4198c4ae1c8cc5d9');
        $twilioInvitationTemplateId = Setting::get('twilio_invitation_template_id', 'HX55189df5f82668658e0c028e8a3892f1');
        $twilioReminderTemplateId = Setting::get('twilio_reminder_template_id', 'HXd5eba0c89c4950f3c1edec3740e25f19');

        return view('admin.wa-settings', compact(
            'twilioMode',
            'twilioSid',
            'twilioToken',
            'twilioFrom',
            'twilioTemplateId',
            'twilioInvitationTemplateId',
            'twilioReminderTemplateId'
        ));
    }

    /**
     * Simpan pembaruan pengaturan Twilio & Content SID
     */
    public function update(Request $request)
    {
        $request->validate([
            'twilio_mode' => 'required|in:freeform,template',
            'twilio_sid' => 'nullable|string',
            'twilio_token' => 'nullable|string',
            'twilio_from' => 'nullable|string',
            'twilio_template_id' => 'nullable|string',
            'twilio_invitation_template_id' => 'nullable|string',
            'twilio_reminder_template_id' => 'nullable|string',
        ]);

        Setting::set('twilio_mode', $request->twilio_mode);
        Setting::set('twilio_sid', $request->twilio_sid);
        Setting::set('twilio_token', $request->twilio_token);
        Setting::set('twilio_from', $request->twilio_from);
        Setting::set('twilio_template_id', $request->twilio_template_id);
        Setting::set('twilio_invitation_template_id', $request->twilio_invitation_template_id);
        Setting::set('twilio_reminder_template_id', $request->twilio_reminder_template_id);

        return redirect()->back()->with('success', 'Konfigurasi kredensial Twilio & Content SID resmi berhasil disimpan!');
    }

    /**
     * Upload Flyer / Gambar Media WhatsApp via AJAX
     */
    public function uploadFlyer(Request $request)
    {
        $request->validate([
            'flyer' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        if ($request->hasFile('flyer')) {
            $file = $request->file('flyer');
            $filename = 'wa_flyer_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destPath = public_path('uploads/flyers');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $file->move($destPath, $filename);
            $relative = 'uploads/flyers/' . $filename;
            
            // Simpan sebagai flyer acara aktif
            Setting::set('event_flyer', $relative);

            return response()->json([
                'success' => true,
                'url' => asset($relative),
                'path' => $relative,
                'filename' => $filename,
                'message' => 'Flyer berhasil diunggah dan disimpan sebagai media aktif!',
            ]);
        }

        return response()->json([
            'success' => false, 
            'message' => 'File gambar tidak ditemukan atau tidak valid.'
        ], 400);
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
            'attach_flyer' => 'nullable',
            'media_url' => 'nullable|string',
        ]);

        $message = $request->message ?? $request->custom_message;

        $attachFlyer = $request->boolean('attach_flyer') || $request->attach_flyer === '1' || $request->attach_flyer === 1 || $request->attach_flyer === 'true';
        $mediaUrl = null;
        if ($request->filled('media_url')) {
            $mediaUrl = $request->media_url;
        } elseif ($attachFlyer) {
            $flyer = Setting::get('event_flyer', '');
            $mediaUrl = !empty($flyer) ? asset($flyer) : null;
        }

        $result = TwilioService::sendInvitation(
            toPhone: $request->phone,
            name: $request->name,
            customMessage: $message,
            contentSidOverride: $request->content_sid,
            mediaUrl: $mediaUrl
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
            'name' => 'Tester Wonderful',
            'company' => 'Wonderful',
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
            . "Wonderful dengan hormat mengundang Anda untuk hadir pada kegiatan eksklusif:\n\n"
            . "📌 *{nama_acara}*\n"
            . "📅 Tanggal: {tanggal}\n"
            . "⏰ Waktu: {waktu}\n"
            . "📍 Tempat: {venue}\n"
            . "👔 Dresscode: {dresscode}\n\n"
            . "Mengingat kuota tempat terbatas, mohon kesediaan Bapak/Ibu untuk mengisi formulir kehadiran melalui tautan resmi berikut:\n"
            . "🔗 {link_form}\n\n"
            . "⏳ Batas Akhir Konfirmasi: {batas_waktu}\n\n"
            . "Terima kasih atas perhatian dan kerja sama Bapak/Ibu.\n\n"
            . "Salam hormat,\n*Panitia Wonderful 2026*";

        $invitationTemplate = Setting::get('wa_invitation_template', $defaultInvitationTemplate);
        $invitationTemplate = str_replace([
            'Kamar Dagang dan Industri (KADIN) Indonesia',
            'Panitia KADIN Indonesia 2026',
            'Panitia KADIN 2026',
            'KADIN Indonesia 2026',
            'KADIN Indonesia',
            'Menara Kadin Indonesia',
            'Panitia C LEVEL Indonesia 2026',
            'C LEVEL Indonesia 2026',
            'C LEVEL Indonesia',
            'Grand Ballroom C LEVEL Indonesia',
        ], [
            'Wonderful',
            'Panitia Wonderful 2026',
            'Panitia Wonderful 2026',
            'Wonderful 2026',
            'Wonderful',
            'SCBD Area',
            'Panitia Wonderful 2026',
            'Wonderful 2026',
            'Wonderful',
            'SCBD Area',
        ], $invitationTemplate);
        
        $deadlineEnabled = Setting::get('registration_deadline_enabled', '0') === '1';
        $deadlineDatetime = Setting::get('registration_deadline', '2026-10-27T23:59');
        $deadlineText = Setting::get('registration_deadline_text', '27 Oktober 2026, 23:59 WIB');

        $deadlineSettings = [
            'enabled' => $deadlineEnabled,
            'deadline' => $deadlineDatetime,
            'deadline_text' => $deadlineText,
        ];

        $eventFlyer = Setting::get('event_flyer', '');
        $eventFlyerUrl = !empty($eventFlyer) ? asset($eventFlyer) : '';

        $eventSettings = [
            'nama_acara' => Setting::get('event_title', 'The Executive Roundtable — From AI Ambition to Enterprise Impact'),
            'tanggal' => Setting::get('event_date', '27 Oktober 2026'),
            'waktu' => Setting::get('event_time', '15.30 - 19.00 WIB'),
            'venue' => Setting::get('event_venue_name', 'SCBD Area'),
            'dresscode' => Setting::get('event_dresscode', 'By invitation only. Kindly confirm your attendance with the GWI team'),
            'link_form' => route('participants.invitation'),
            'batas_waktu' => $deadlineEnabled ? $deadlineText : 'Sesuai kuota tersedia',
            'link_flyer' => $eventFlyerUrl ?: route('home'),
        ];

        $participants = Participant::latest()->get();
        $invitationGuests = InvitationGuest::latest()->get();
        $contentSidInvitation = Setting::get('twilio_invitation_template_id', '');

        return view('admin.invitation', compact(
            'invitationTemplate', 
            'eventSettings', 
            'participants', 
            'invitationGuests',
            'deadlineSettings', 
            'contentSidInvitation',
            'eventFlyer',
            'eventFlyerUrl'
        ));
    }

    /**
     * Tambah satu calon tamu undangan baru
     */
    public function storeInvitationGuest(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:35',
            'company' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        $guest = InvitationGuest::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'company' => $validated['company'] ?: '-',
            'position' => $validated['position'] ?: '-',
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Calon tamu berhasil ditambahkan.',
            'guest' => $guest,
        ]);
    }

    /**
     * Import / Paste massal banyak kontak calon tamu undangan
     */
    public function importInvitationGuests(Request $request)
    {
        $request->validate([
            'raw_contacts' => 'required|string',
        ]);

        $lines = preg_split('/\r\n|\r|\n/', $request->raw_contacts);
        $imported = 0;

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            // Split by tab, comma, semicolon, or pipe
            $parts = preg_split('/[\t,;|]/', $line);
            $parts = array_map('trim', $parts);
            $parts = array_values(array_filter($parts, fn($p) => $p !== ''));

            if (empty($parts)) continue;

            $name = '';
            $phone = '';
            $company = '-';
            $position = '-';

            // Identify parts
            foreach ($parts as $p) {
                $digits = preg_replace('/[^0-9]/', '', $p);
                // If it looks like a phone number and we don't have phone yet
                if (strlen($digits) >= 8 && empty($phone) && (str_starts_with($digits, '0') || str_starts_with($digits, '62') || str_starts_with($digits, '8'))) {
                    $phone = $p;
                } elseif (empty($name)) {
                    $name = $p;
                } elseif ($company === '-') {
                    $company = $p;
                } elseif ($position === '-') {
                    $position = $p;
                }
            }

            // Fallback if phone wasn't detected by prefix rule
            if (empty($phone)) {
                foreach ($parts as $p) {
                    $digits = preg_replace('/[^0-9]/', '', $p);
                    if (strlen($digits) >= 8) {
                        $phone = $p;
                        break;
                    }
                }
            }

            // Fallback if name is empty
            if (empty($name)) {
                $name = 'Bapak/Ibu Pimpinan';
            }

            if (!empty($phone)) {
                InvitationGuest::create([
                    'name' => $name,
                    'phone' => $phone,
                    'company' => $company ?: '-',
                    'position' => $position ?: '-',
                    'status' => 'pending',
                ]);
                $imported++;
            }
        }

        return response()->json([
            'success' => $imported > 0,
            'imported_count' => $imported,
            'message' => "Berhasil menyimpan {$imported} kontak calon tamu undangan.",
        ]);
    }

    /**
     * Hapus satu calon tamu undangan
     */
    public function destroyInvitationGuest(InvitationGuest $guest)
    {
        $guest->delete();

        return response()->json([
            'success' => true,
            'message' => 'Calon tamu berhasil dihapus.',
        ]);
    }

    /**
     * Kirim undangan pendaftaran massal (bulk blast) via Twilio ke tamu terpilih
     */
    public function sendBulkInvitation(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'target_type' => 'nullable|string', // 'guest' or 'participant'
            'custom_message' => 'nullable|string',
            'content_sid' => 'nullable|string',
            'attach_flyer' => 'nullable',
            'media_url' => 'nullable|string',
        ]);

        $targetType = $request->get('target_type', 'guest');
        if ($targetType === 'participant') {
            $recipients = Participant::whereIn('id', $request->ids)->get();
        } else {
            $recipients = InvitationGuest::whereIn('id', $request->ids)->get();
        }

        if ($recipients->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada tamu yang dipilih.',
            ], 400);
        }

        $defaultInvitationTemplate = "Yth. Bapak/Ibu *{nama}*,\n\n"
            . "Wonderful dengan hormat mengundang Anda untuk hadir pada kegiatan eksklusif:\n\n"
            . "📌 *{nama_acara}*\n"
            . "📅 Tanggal: {tanggal}\n"
            . "⏰ Waktu: {waktu}\n"
            . "📍 Tempat: {venue}\n"
            . "👔 Dresscode: {dresscode}\n\n"
            . "Mengingat kuota tempat terbatas, mohon kesediaan Bapak/Ibu untuk mengisi formulir kehadiran melalui tautan resmi berikut:\n"
            . "🔗 {link_form}\n\n"
            . "⏳ Batas Akhir Konfirmasi: {batas_waktu}\n\n"
            . "Terima kasih atas perhatian dan kerja sama Bapak/Ibu.\n\n"
            . "Salam hormat,\n*Panitia Wonderful 2026*";

        $template = $request->filled('custom_message') 
            ? $request->custom_message 
            : Setting::get('wa_invitation_template', $defaultInvitationTemplate);

        $eventTitle = Setting::get('event_title', 'The Executive Roundtable — From AI Ambition to Enterprise Impact');
        $eventDate = Setting::get('event_date', '27 Oktober 2026');
        $eventTime = Setting::get('event_time', '15.30 - 19.00 WIB');
        $eventVenue = Setting::get('event_venue_name', 'SCBD Area');
        $eventDresscode = Setting::get('event_dresscode', 'By invitation only. Kindly confirm your attendance with the GWI team');
        $linkForm = route('home');
        
        $flyerPath = Setting::get('event_flyer', '');
        $flyerUrl = !empty($flyerPath) ? asset($flyerPath) : route('home');

        $deadlineEnabled = Setting::get('registration_deadline_enabled', '0') === '1';
        $deadlineText = Setting::get('registration_deadline_text', '27 Oktober 2026, 23:59 WIB');
        $batasWaktu = $deadlineEnabled ? $deadlineText : 'Sesuai kuota tersedia';

        $attachFlyer = $request->boolean('attach_flyer') || $request->attach_flyer === '1' || $request->attach_flyer === 1 || $request->attach_flyer === 'true';
        $mediaUrl = null;
        if ($request->filled('media_url')) {
            $mediaUrl = $request->media_url;
        } elseif ($attachFlyer) {
            $mediaUrl = !empty($flyerPath) ? asset($flyerPath) : null;
        }

        $sentCount = 0;
        $failCount = 0;

        foreach ($recipients as $recipient) {
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
                '{link_flyer}',
            ], [
                $recipient->name,
                $eventTitle,
                $eventDate,
                $eventTime,
                $eventVenue,
                $eventDresscode,
                $linkForm,
                $batasWaktu,
                $batasWaktu,
                $flyerUrl,
            ], $template);

            $result = TwilioService::sendInvitation(
                toPhone: $recipient->phone,
                name: $recipient->name,
                customMessage: $msg,
                contentSidOverride: $request->content_sid,
                mediaUrl: $mediaUrl
            );

            if ($result['success']) {
                $sentCount++;
                if ($targetType === 'guest' && $recipient instanceof InvitationGuest) {
                    $recipient->update([
                        'status' => 'sent',
                        'sent_at' => now(),
                    ]);
                }
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
            . "Terima kasih telah melakukan registrasi kegiatan Wonderful 2026.\n\n"
            . "Berikut adalah tiket presensi QR Code Anda:\n"
            . "🔗 {link_tiket}\n\n"
            . "Kode Tiket: *{kode_tiket}*\n"
            . "Instansi: {instansi}\n"
            . "Jabatan: {jabatan}\n\n"
            . "Silakan tunjukkan QR Code pada gambar/tautan terlampir kepada petugas saat tiba di lokasi acara.\n\n"
            . "Salam hangat,\n*Panitia Wonderful 2026*";

        $template = Setting::get('wa_template', $defaultTemplate);
        $template = str_replace([
            'kegiatan KADIN 2026',
            'Panitia KADIN 2026',
            'Panitia KADIN Indonesia 2026',
            'KADIN Indonesia 2026',
            'KADIN 2026',
            'KADIN Indonesia',
            'kegiatan C LEVEL Indonesia 2026',
            'Panitia C LEVEL Indonesia 2026',
            'C LEVEL Indonesia 2026',
            'C LEVEL Indonesia',
        ], [
            'kegiatan Wonderful 2026',
            'Panitia Wonderful 2026',
            'Panitia Wonderful 2026',
            'Wonderful 2026',
            'Wonderful 2026',
            'Wonderful',
            'kegiatan Wonderful 2026',
            'Panitia Wonderful 2026',
            'Wonderful 2026',
            'Wonderful',
        ], $template);

        $participants = Participant::latest()->get();

        // Sample peserta untuk live preview di samping kanan
        $sample = $participants->first() ?? new Participant([
            'name' => 'Bpk. Ir. Hendro Wibowo',
            'company' => 'Wonderful',
            'position' => 'Executive Director',
            'phone' => '081234567890',
            'qr_token' => 'CL26-EXMPL01',
        ]);

        $eventFlyer = Setting::get('event_flyer', '');
        $eventFlyerUrl = !empty($eventFlyer) ? asset($eventFlyer) : '';

        return view('admin.tickets', compact('template', 'participants', 'sample', 'eventFlyer', 'eventFlyerUrl'));
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
            'media_type' => 'nullable|string', // 'qr', 'flyer', 'none'
            'media_url' => 'nullable|string',
        ]);

        if ($request->filled('participant_id')) {
            $participant = Participant::findOrFail($request->participant_id);
        } else {
            $participant = Participant::first() ?? new Participant([
                'name' => 'Tamu Kehormatan',
                'company' => 'Wonderful',
                'position' => 'Peserta',
                'phone' => $request->phone,
                'qr_token' => 'KD26-' . strtoupper(\Illuminate\Support\Str::random(8)),
            ]);
        }

        $mediaUrlOverride = null;
        if ($request->input('media_type') === 'flyer' || $request->boolean('attach_flyer')) {
            $flyer = Setting::get('event_flyer', '');
            $mediaUrlOverride = $request->filled('media_url') ? $request->media_url : (!empty($flyer) ? asset($flyer) : null);
        } elseif ($request->input('media_type') === 'none') {
            $mediaUrlOverride = 'none';
        } elseif ($request->filled('media_url')) {
            $mediaUrlOverride = $request->media_url;
        }

        $result = TwilioService::sendTicket(
            participant: $participant,
            toPhoneOverride: $request->phone,
            customTemplate: $request->custom_message,
            mediaUrlOverride: $mediaUrlOverride
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
            'media_type' => 'nullable|string',
            'media_url' => 'nullable|string',
        ]);

        $participants = Participant::whereIn('id', $request->ids)->get();

        if ($participants->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada peserta yang dipilih.',
            ], 400);
        }

        $mediaUrlOverride = null;
        if ($request->input('media_type') === 'flyer' || $request->boolean('attach_flyer')) {
            $flyer = Setting::get('event_flyer', '');
            $mediaUrlOverride = $request->filled('media_url') ? $request->media_url : (!empty($flyer) ? asset($flyer) : null);
        } elseif ($request->input('media_type') === 'none') {
            $mediaUrlOverride = 'none';
        } elseif ($request->filled('media_url')) {
            $mediaUrlOverride = $request->media_url;
        }

        $sentCount = 0;
        $failCount = 0;

        foreach ($participants as $participant) {
            $result = TwilioService::sendTicket(
                participant: $participant,
                customTemplate: $request->custom_message,
                mediaUrlOverride: $mediaUrlOverride
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
            . "Mengingatkan kembali bahwa agenda penting *{nama_acara}* akan berlangsung pada:\n"
            . "📅 Hari/Tgl: {tanggal}\n"
            . "⏰ Waktu: {waktu}\n"
            . "📍 Tempat: {venue}\n"
            . "👔 Dresscode: {dresscode}\n\n"
            . "Tiket QR Presensi Anda:\n🔗 {link_tiket}\n\n"
            . "Mohon konfirmasi kesediaan kehadiran Bapak/Ibu melalui tautan berikut:\n"
            . "✅ *Pasti Hadir:* {link_konfirmasi_hadir}\n"
            . "❌ *Berhalangan:* {link_konfirmasi_batal}\n\n"
            . "Terima kasih atas kerja samanya.\n*Panitia Wonderful 2026*";

        $reminderTemplate = Setting::get('wa_reminder_template', $defaultReminderTemplate);
        $reminderTemplate = str_replace([
            'Panitia KADIN Indonesia 2026',
            'Panitia KADIN 2026',
            'KADIN Indonesia 2026',
            'KADIN 2026',
            'Menara Kadin Indonesia',
            'Kadin Indonesia',
            'KADIN Indonesia',
            'Panitia C LEVEL Indonesia 2026',
            'C LEVEL Indonesia 2026',
            'C LEVEL Indonesia',
            'Grand Ballroom C LEVEL Indonesia',
        ], [
            'Panitia Wonderful 2026',
            'Panitia Wonderful 2026',
            'Wonderful 2026',
            'Wonderful 2026',
            'SCBD Area',
            'Wonderful',
            'Wonderful',
            'Panitia Wonderful 2026',
            'Wonderful 2026',
            'Wonderful',
            'SCBD Area',
        ], $reminderTemplate);

        $contentSidReminder = Setting::get('twilio_reminder_template_id', '');
        $participants = Participant::latest()->get();

        $eventFlyer = Setting::get('event_flyer', '');
        $eventFlyerUrl = !empty($eventFlyer) ? asset($eventFlyer) : '';

        $eventSettings = [
            'nama_acara' => Setting::get('event_title', 'The Executive Roundtable — From AI Ambition to Enterprise Impact'),
            'tanggal' => Setting::get('event_date', '27 Oktober 2026'),
            'waktu' => Setting::get('event_time', '15.30 - 19.00 WIB'),
            'venue' => Setting::get('event_venue_name', 'SCBD Area'),
            'dresscode' => Setting::get('event_dresscode', 'By invitation only. Kindly confirm your attendance with the GWI team'),
            'link_flyer' => $eventFlyerUrl ?: route('home'),
        ];

        $sample = $participants->first() ?? new Participant([
            'name' => 'Bpk. Ir. Hendro Wibowo',
            'company' => 'Wonderful',
            'position' => 'Executive Director',
            'phone' => '081234567890',
            'qr_token' => 'CL26-EXMPL01',
        ]);

        return view('admin.reminder', compact(
            'reminderTemplate',
            'contentSidReminder',
            'participants',
            'eventSettings',
            'sample',
            'eventFlyer',
            'eventFlyerUrl'
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
            'attach_flyer' => 'nullable',
            'media_url' => 'nullable|string',
        ]);

        if ($request->filled('participant_id')) {
            $participant = Participant::findOrFail($request->participant_id);
        } else {
            $participant = Participant::first() ?? new Participant([
                'name' => 'Tamu Kehormatan',
                'company' => 'Wonderful',
                'position' => 'Peserta',
                'phone' => $request->phone,
                'qr_token' => 'KD26-TEST001',
            ]);
        }

        $attachFlyer = $request->boolean('attach_flyer') || $request->attach_flyer === '1' || $request->attach_flyer === 1 || $request->attach_flyer === 'true';
        $mediaUrl = null;
        if ($request->filled('media_url')) {
            $mediaUrl = $request->media_url;
        } elseif ($attachFlyer) {
            $flyer = Setting::get('event_flyer', '');
            $mediaUrl = !empty($flyer) ? asset($flyer) : null;
        }

        $result = TwilioService::sendReminder(
            participant: $participant,
            toPhoneOverride: $request->phone,
            customTemplate: $request->custom_message,
            contentSidOverride: $request->content_sid,
            mediaUrl: $mediaUrl
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
            'attach_flyer' => 'nullable',
            'media_url' => 'nullable|string',
        ]);

        $participants = Participant::whereIn('id', $request->ids)->get();

        if ($participants->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada peserta yang dipilih.',
            ], 400);
        }

        $attachFlyer = $request->boolean('attach_flyer') || $request->attach_flyer === '1' || $request->attach_flyer === 1 || $request->attach_flyer === 'true';
        $mediaUrl = null;
        if ($request->filled('media_url')) {
            $mediaUrl = $request->media_url;
        } elseif ($attachFlyer) {
            $flyer = Setting::get('event_flyer', '');
            $mediaUrl = !empty($flyer) ? asset($flyer) : null;
        }

        $sentCount = 0;
        $failCount = 0;

        foreach ($participants as $participant) {
            $result = TwilioService::sendReminder(
                participant: $participant,
                customTemplate: $request->custom_message,
                contentSidOverride: $request->content_sid,
                mediaUrl: $mediaUrl
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
