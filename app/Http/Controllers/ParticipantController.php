<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ParticipantController extends Controller
{
    /**
     * Tampilkan form registrasi / pendaftaran
     */
    public function create()
    {
        return view('participants.create');
    }

    /**
     * Simpan data registrasi dan generate QR Token unik
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:participants,email',
            'phone_number' => 'required|string|max:25',
            'institution' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar sebelumnya.',
            'phone_number.required' => 'Nomor WhatsApp / telepon wajib diisi untuk blast tiket.',
        ]);

        // Generate Token QR unik: KD26-XXXXXXXX
        do {
            $token = 'KD26-' . strtoupper(Str::random(8));
        } while (Participant::where('qr_token', $token)->exists());

        $participant = Participant::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'institution' => $validated['institution'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'qr_token' => $token,
            'status' => 'registered',
        ]);

        return redirect()->route('participants.card', $participant->qr_token)
            ->with('success', 'Registrasi berhasil! Tiket QR Code telah dibuat.');
    }

    /**
     * Tampilkan halaman kartu QR peserta
     */
    public function card(string $token)
    {
        $participant = Participant::where('qr_token', $token)->firstOrFail();

        return view('participants.card', compact('participant'));
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
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%")
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

        $token = trim($request->qr_token);
        $participant = Participant::where('qr_token', $token)->first();

        if (!$participant) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak terdaftar dalam sistem Kadin 2026.',
            ], 404);
        }

        if ($participant->status === 'attended') {
            return response()->json([
                'success' => false,
                'already_attended' => true,
                'message' => "Peserta atas nama <b>{$participant->name}</b> sudah melakukan absensi pada " . $participant->attended_at->format('H:i:s, d M Y'),
                'participant' => $participant,
            ], 409);
        }

        // Catat kehadiran
        $participant->update([
            'status' => 'attended',
            'attended_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Absensi berhasil dicatat! Selamat datang, <b>{$participant->name}</b>.",
            'participant' => [
                'name' => $participant->name,
                'institution' => $participant->institution ?? '-',
                'time' => $participant->attended_at->format('H:i:s'),
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
}

