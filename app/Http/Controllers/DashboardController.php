<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Setting;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    /**
     * Halaman Dashboard Admin Pendaftar & Presensi
     */
    public function index(Request $request)
    {
        $query = Participant::query();

        // Filter Pencarian
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('qr_token', 'like', "%{$search}%");
            });
        }

        // Filter Status Kehadiran
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Status RSVP
        if ($request->filled('rsvp')) {
            if ($request->rsvp === 'pending') {
                $query->where(function ($q) {
                    $q->whereNull('rsvp_status')->orWhere('rsvp_status', 'pending');
                });
            } else {
                $query->where('rsvp_status', $request->rsvp);
            }
        }

        // Filter Tanggal
        if ($request->filled('date') && $request->date === 'today') {
            $query->whereDate('created_at', today());
        }

        $participants = $query->latest()->paginate(15)->withQueryString();

        // Kalkulasi Statistik Admin
        $total = Participant::count();
        $attended = Participant::where('status', 'attended')->count();
        $registered = Participant::where('status', 'registered')->count();
        $todayRegistered = Participant::whereDate('created_at', today())->count();
        $rate = $total > 0 ? round(($attended / $total) * 100, 1) : 0;

        $rsvpAttending = Participant::where('rsvp_status', 'attending')->count();
        $rsvpDeclined = Participant::where('rsvp_status', 'declined')->count();
        $rsvpPending = Participant::where(function ($q) {
            $q->whereNull('rsvp_status')->orWhere('rsvp_status', 'pending');
        })->count();

        $stats = [
            'total' => $total,
            'attended' => $attended,
            'registered' => $registered,
            'today_registered' => $todayRegistered,
            'attendance_rate' => $rate,
            'rsvp_attending' => $rsvpAttending,
            'rsvp_declined' => $rsvpDeclined,
            'rsvp_pending' => $rsvpPending,
        ];

        // 5 Absensi Terkini
        $recentCheckins = Participant::where('status', 'attended')
            ->orderByDesc('attended_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('participants', 'stats', 'recentCheckins'));
    }

    /**
     * Check-in manual oleh admin langsung dari tabel dashboard
     */
    public function toggleCheckin(Participant $participant)
    {
        if ($participant->status === 'attended') {
            $participant->update([
                'status' => 'registered',
                'attended_at' => null,
            ]);
            $msg = "Status presensi {$participant->name} dikembalikan ke Belum Hadir.";
        } else {
            $participant->update([
                'status' => 'attended',
                'attended_at' => now(),
            ]);
            $msg = "Presensi {$participant->name} berhasil diverifikasi manual!";
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $participant->status,
                'attended_at' => $participant->attended_at ? $participant->attended_at->isoFormat('dddd, D MMMM Y • HH:mm') . ' WIB' : null,
                'updated_at_formatted' => now()->isoFormat('dddd, D MMMM Y • HH:mm') . ' WIB',
                'message' => $msg,
                'participant_name' => $participant->name,
            ]);
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Hapus data pendaftar dari dashboard
     */
    public function destroy(Participant $participant)
    {
        $name = $participant->name;
        $participant->delete();

        return redirect()->back()->with('success', "Data peserta \"{$name}\" berhasil dihapus.");
    }

    /**
     * Cetak ID Card Lanyard / Name Tag satuan untuk 1 peserta
     */
    public function printIdCard(Participant $participant)
    {
        $participants = collect([$participant]);
        $rawTitle = Setting::get('event_title', 'Musyawarah & Temu Bisnis C LEVEL Indonesia 2026');
        $rawVenue = Setting::get('event_venue_name', 'Grand Ballroom C LEVEL Indonesia');

        $cleanTitle = str_ireplace(['KADIN Indonesia', 'KADIN'], 'C LEVEL Indonesia', $rawTitle);
        $cleanVenue = str_ireplace(['Menara Kadin Indonesia', 'Menara Kadin'], 'C LEVEL Summit Hall', $rawVenue);

        $eventSettings = [
            'nama_acara' => $cleanTitle,
            'tanggal' => Setting::get('event_date', '28 Oktober 2026'),
            'venue' => $cleanVenue,
        ];

        return view('admin.id-card', compact('participants', 'eventSettings'));
    }

    /**
     * Cetak ID Card Lanyard / Name Tag massal untuk semua / hasil filter peserta
     */
    public function printBulkIdCards(Request $request)
    {
        $query = Participant::query();

        if ($request->filled('ids')) {
            $ids = is_array($request->ids) ? $request->ids : explode(',', $request->ids);
            $query->whereIn('id', $ids);
        } else {
            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('company', 'like', "%{$search}%")
                      ->orWhere('position', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('qr_token', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('rsvp')) {
                if ($request->rsvp === 'pending') {
                    $query->where(function ($q) {
                        $q->whereNull('rsvp_status')->orWhere('rsvp_status', 'pending');
                    });
                } else {
                    $query->where('rsvp_status', $request->rsvp);
                }
            }
        }

        $participants = $query->latest()->get();

        $rawTitle = Setting::get('event_title', 'Musyawarah & Temu Bisnis C LEVEL Indonesia 2026');
        $rawVenue = Setting::get('event_venue_name', 'Grand Ballroom C LEVEL Indonesia');

        $cleanTitle = str_ireplace(['KADIN Indonesia', 'KADIN'], 'C LEVEL Indonesia', $rawTitle);
        $cleanVenue = str_ireplace(['Menara Kadin Indonesia', 'Menara Kadin'], 'C LEVEL Summit Hall', $rawVenue);

        $eventSettings = [
            'nama_acara' => $cleanTitle,
            'tanggal' => Setting::get('event_date', '28 Oktober 2026'),
            'venue' => $cleanVenue,
        ];

        return view('admin.id-card', compact('participants', 'eventSettings'));
    }

    /**
     * Export data pendaftar ke file CSV
     */
    public function exportCsv(): StreamedResponse
    {
        $fileName = 'pendaftar_kadin_2026_' . date('Y-m-d_His') . '.csv';
        $participants = Participant::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($participants) {
            $handle = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header kolom
            fputcsv($handle, [
                'No',
                'Kode Tiket QR',
                'Nama Lengkap',
                'Instansi / Perusahaan',
                'Jabatan',
                'Nomor WhatsApp',
                'Email',
                'Status Presensi',
                'Status RSVP',
                'Waktu Hadir',
                'Waktu RSVP',
                'Waktu Pendaftaran',
            ], ';');

            foreach ($participants as $index => $p) {
                $rsvpLabel = match($p->rsvp_status) {
                    'attending' => 'KONFIRMASI HADIR',
                    'declined' => 'BERHALANGAN',
                    default => 'MENUNGGU KONFIRMASI'
                };

                fputcsv($handle, [
                    $index + 1,
                    $p->qr_token,
                    $p->name,
                    $p->company,
                    $p->position,
                    $p->phone,
                    $p->email ?? '-',
                    $p->status === 'attended' ? 'HADIR' : 'BELUM HADIR',
                    $rsvpLabel,
                    $p->attended_at ? $p->attended_at->format('d/m/Y H:i:s') : '-',
                    $p->rsvp_at ? $p->rsvp_at->format('d/m/Y H:i:s') : '-',
                    $p->created_at->format('d/m/Y H:i:s'),
                ], ';');
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Halaman Layar Sambutan TV / Display Mode
     */
    public function displayScreen()
    {
        $recentAttended = Participant::where('status', 'attended')
            ->orderByDesc('attended_at')
            ->limit(5)
            ->get();

        $stats = [
            'total' => Participant::count(),
            'attended' => Participant::where('status', 'attended')->count(),
        ];

        return view('admin.display', compact('recentAttended', 'stats'));
    }

    /**
     * Endpoint Polling Real-time Checkin Terbaru untuk Layar TV
     */
    public function latestCheckin(Request $request)
    {
        $lastTime = $request->query('last_time');
        $query = Participant::where('status', 'attended');

        if ($lastTime) {
            try {
                $query->where('attended_at', '>', \Carbon\Carbon::parse($lastTime));
            } catch (\Exception $e) {
                // fallback jika format parse error
            }
        }

        $latest = $query->orderByDesc('attended_at')->first();
        $totalAttended = Participant::where('status', 'attended')->count();
        $totalRegistered = Participant::count();

        return response()->json([
            'has_new' => (bool)$latest,
            'participant' => $latest ? [
                'id' => $latest->id,
                'name' => $latest->name,
                'company' => $latest->company ?? '-',
                'position' => $latest->position ?? '-',
                'time' => $latest->attended_at ? $latest->attended_at->timezone('Asia/Jakarta')->format('H:i:s') . ' WIB' : now()->timezone('Asia/Jakarta')->format('H:i:s') . ' WIB',
                'attended_at_raw' => $latest->attended_at ? $latest->attended_at->toIso8601String() : now()->toIso8601String(),
            ] : null,
            'stats' => [
                'attended' => $totalAttended,
                'total' => $totalRegistered,
            ]
        ]);
    }
}
