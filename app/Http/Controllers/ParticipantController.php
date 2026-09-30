<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ParticipantController extends Controller
{
    /**
     * Tampilkan form registrasi / pendaftaran
     */
    public function create(Request $request)
    {
        $showEnvelope = !$request->is('register') && !$request->has('direct');

        $settings = [
            'event_title' => Setting::get('event_title', 'Musyawarah & Temu Bisnis C LEVEL Indonesia 2026'),
            'event_organizer' => Setting::get('event_organizer', 'C LEVEL Indonesia'),
            'event_date' => Setting::get('event_date', '28 Oktober 2026'),
            'event_time' => Setting::get('event_time', '08:30 - 16:30 WIB'),
            'event_venue_name' => Setting::get('event_venue_name', 'Grand Ballroom C LEVEL Indonesia'),
            'event_venue_address' => Setting::get('event_venue_address', 'Grand Ballroom C LEVEL Indonesia, Jakarta'),
            'event_maps_url' => Setting::get('event_maps_url', 'https://maps.google.com/?q=Jakarta'),
            'event_maps_iframe' => Setting::get('event_maps_iframe', ''),
            'event_dresscode' => Setting::get('event_dresscode', 'Batik Formal / Pakaian Bisnis Rapi'),
            'event_description' => Setting::get('event_description', 'Pertemuan strategis para pelaku usaha, pimpinan asosiasi, dan pemangku kepentingan industri nasional dalam rangka akselerasi ekonomi dan kolaborasi bisnis berkelanjutan.'),
            'event_flyer' => Setting::get('event_flyer', ''),
            'registration_deadline_enabled' => Setting::get('registration_deadline_enabled', '0') === '1',
            'registration_deadline' => Setting::get('registration_deadline', '2026-10-27T23:59'),
            'registration_deadline_text' => Setting::get('registration_deadline_text', '27 Oktober 2026, 23:59 WIB'),
        ];

        // Cek status kadaluarsa
        $isExpired = false;
        if ($settings['registration_deadline_enabled'] && !empty($settings['registration_deadline'])) {
            try {
                $isExpired = now()->greaterThan(\Carbon\Carbon::parse($settings['registration_deadline']));
            } catch (\Throwable $e) {
                $isExpired = false;
            }
        }

        return view('participants.create', compact('settings', 'isExpired', 'showEnvelope'));
    }

    /**
     * Simpan data registrasi dan generate QR Token unik
     */
    public function store(Request $request)
    {
        // Proteksi jika pendaftaran sudah kadaluarsa
        $deadlineEnabled = Setting::get('registration_deadline_enabled', '0') === '1';
        $deadline = Setting::get('registration_deadline', '');
        if ($deadlineEnabled && !empty($deadline)) {
            try {
                if (now()->greaterThan(\Carbon\Carbon::parse($deadline))) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Mohon maaf, periode pendaftaran untuk acara ini telah ditutup karena telah melewati batas waktu pendaftaran.');
                }
            } catch (\Throwable $e) {
                // Abaikan error parse
            }
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:25',
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor telepon / WhatsApp wajib diisi.',
            'position.required' => 'Jabatan wajib diisi.',
            'company.required' => 'Company wajib diisi.',
        ]);

        // Generate Token QR unik: KD26-XXXXXXXX
        do {
            $token = 'KD26-' . strtoupper(Str::random(8));
        } while (Participant::where('qr_token', $token)->exists());

        $participant = Participant::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'position' => $validated['position'],
            'company' => $validated['company'],
            'email' => null,
            'notes' => null,
            'qr_token' => $token,
            'status' => 'registered',
        ]);

        return redirect()->route('participants.requested', $participant->qr_token)
            ->with('success', 'Permintaan bergabung berhasil diajukan!');
    }

    /**
     * Tampilkan halaman konfirmasi pengajuan / Request to Join
     */
    public function requested(string $token)
    {
        $participant = Participant::where('qr_token', $token)->firstOrFail();
        $eventTitle = Setting::get('event_title', 'Musyawarah & Temu Bisnis C LEVEL Indonesia 2026');

        return view('participants.requested', compact('participant', 'eventTitle'));
    }

    /**
     * Tampilkan halaman kartu QR peserta
     */
    public function card(string $token)
    {
        $participant = Participant::where('qr_token', $token)->firstOrFail();
        $eventSettings = [
            'title' => Setting::get('event_title', 'Musyawarah & Temu Bisnis C LEVEL Indonesia 2026'),
            'date' => Setting::get('event_date', '28 Oktober 2026'),
            'time' => Setting::get('event_time', '08:30 - 16:30 WIB'),
            'venue' => Setting::get('event_venue_name', 'Grand Ballroom C LEVEL Indonesia'),
            'dresscode' => Setting::get('event_dresscode', 'Batik Formal / Pakaian Bisnis Rapi'),
        ];

        return view('participants.card', compact('participant', 'eventSettings'));
    }

    /**
     * Tampilkan daftar peserta untuk admin/panitia & fitur blast WA
     */
    public function index(Request $request)
    {
        $query = Participant::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('qr_token', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $participants = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => Participant::count(),
            'attended' => Participant::where('status', 'attended')->count(),
            'registered' => Participant::where('status', 'registered')->count(),
        ];

        return view('participants.index', compact('participants', 'stats'));
    }

    /**
     * Tampilkan halaman scanner kamera untuk panitia/admin absensi
     */
    public function scan()
    {
        $recentAttended = Participant::where('status', 'attended')
            ->orderByDesc('attended_at')
            ->limit(10)
            ->get();

        return view('participants.scan', compact('recentAttended'));
    }

    /**
     * Endpoint API Verifikasi QR Code saat di-scan
     */
    public function verifyScan(Request $request)
    {
        $request->validate([
            'qr_token' => 'required|string',
        ]);

        $rawToken = trim($request->qr_token);
        
        // Ekstraksi jika yang di-scan berupa URL lengkap (misal: http://.../ticket/KD26-XXX)
        $token = $rawToken;
        if (str_contains($rawToken, '/')) {
            $parts = explode('/', rtrim($rawToken, '/'));
            $token = end($parts);
        }
        $token = strtoupper(trim($token));

        $participant = Participant::where('qr_token', $token)
            ->orWhere('qr_token', $rawToken)
            ->first();

        if (!$participant) {
            return response()->json([
                'success' => false,
                'message' => "QR Code ({$token}) tidak terdaftar dalam sistem C LEVEL 2026.",
            ], 404);
        }

        if ($participant->status === 'attended') {
            $waktuFormatted = $participant->attended_at 
                ? $participant->attended_at->timezone('Asia/Jakarta')->translatedFormat('H:i:s, d M Y') . ' WIB'
                : '-';
            return response()->json([
                'success' => false,
                'already_attended' => true,
                'message' => "Peserta atas nama <b>{$participant->name}</b> sudah melakukan absensi pada {$waktuFormatted}",
                'participant' => $participant,
            ], 409);
        }

        // Catat kehadiran
        $participant->update([
            'status' => 'attended',
            'attended_at' => now(),
        ]);

        $waktuSekarang = $participant->attended_at 
            ? $participant->attended_at->timezone('Asia/Jakarta')->format('H:i:s') . ' WIB'
            : now()->timezone('Asia/Jakarta')->format('H:i:s') . ' WIB';

        return response()->json([
            'success' => true,
            'message' => "Absensi berhasil dicatat! Selamat datang, <b>{$participant->name}</b>.",
            'participant' => [
                'name' => $participant->name,
                'company' => $participant->company ?? '-',
                'position' => $participant->position ?? '-',
                'time' => $waktuSekarang,
                'qr_token' => $participant->qr_token,
            ],
        ]);
    }

    /**
     * Hapus peserta
     */
    public function destroy(Participant $participant)
    {
        $participant->delete();

        return redirect()->back()->with('success', 'Data peserta berhasil dihapus.');
    }

    /**
     * Endpoint raw image PNG QR Code untuk media Twilio WhatsApp
     */
    public function qrImage(string $token)
    {
        $participant = Participant::where('qr_token', $token)->firstOrFail();
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=500x500&margin=30&ecc=H&data=" . urlencode($participant->qr_token);

        try {
            $imageContent = \Illuminate\Support\Facades\Http::timeout(5)->get($qrUrl)->body();
            return response($imageContent, 200, [
                'Content-Type' => 'image/png',
                'Cache-Control' => 'public, max-age=86400',
            ]);
        } catch (\Throwable $e) {
            return redirect($qrUrl);
        }
    }

    /**
     * Konfirmasi respon RSVP kehadiran via link 1-klik
     */
    public function rsvp(string $token, string $status)
    {
        $participant = Participant::where('qr_token', $token)->firstOrFail();

        $isAttending = in_array(strtolower($status), ['yes', 'hadir', 'y', '1', 'confirm']);
        $newRsvpStatus = $isAttending ? 'confirmed_yes' : 'confirmed_no';

        $participant->update([
            'rsvp_status' => $newRsvpStatus,
            'rsvp_at' => now(),
        ]);

        $settings = [
            'event_title' => Setting::get('event_title', 'Musyawarah & Temu Bisnis C LEVEL Indonesia 2026'),
            'event_organizer' => Setting::get('event_organizer', 'C LEVEL Indonesia'),
            'event_date' => Setting::get('event_date', '28 Oktober 2026'),
            'event_time' => Setting::get('event_time', '08:30 - 16:30 WIB'),
            'event_venue_name' => Setting::get('event_venue_name', 'Grand Ballroom Menara C LEVEL Indonesia'),
            'event_dresscode' => Setting::get('event_dresscode', 'Batik Formal / Pakaian Bisnis Rapi'),
        ];

        return view('participants.rsvp', compact('participant', 'isAttending', 'settings'));
    }
}



