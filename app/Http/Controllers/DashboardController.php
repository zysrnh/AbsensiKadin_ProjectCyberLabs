<?php

namespace App\Http\Controllers;

use App\Models\Participant;
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

        $stats = [
            'total' => $total,
            'attended' => $attended,
            'registered' => $registered,
            'today_registered' => $todayRegistered,
            'attendance_rate' => $rate,
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
                'Waktu Hadir',
                'Waktu Pendaftaran',
            ], ';');

            foreach ($participants as $index => $p) {
                fputcsv($handle, [
                    $index + 1,
                    $p->qr_token,
                    $p->name,
                    $p->company,
                    $p->position,
                    $p->phone,
                    $p->email ?? '-',
                    $p->status === 'attended' ? 'HADIR' : 'BELUM HADIR',
                    $p->attended_at ? $p->attended_at->format('d/m/Y H:i:s') : '-',
                    $p->created_at->format('d/m/Y H:i:s'),
                ], ';');
            }

            fclose($handle);
        }, 200, $headers);
    }
}
