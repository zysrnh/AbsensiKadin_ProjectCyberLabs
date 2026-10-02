<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EventSettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan informasi acara
     */
    public function index()
    {
        $settings = [
            'event_title' => Setting::get('event_title', 'The Executive Roundtable — From AI Ambition to Enterprise Impact'),
            'event_organizer' => Setting::get('event_organizer', 'Wonderful'),
            'event_date' => Setting::get('event_date', '27 Oktober 2026'),
            'event_time' => Setting::get('event_time', '15.30 - 19.00 WIB'),
            'event_venue_name' => Setting::get('event_venue_name', 'SCBD Area'),
            'event_venue_address' => Setting::get('event_venue_address', 'SCBD Area, Jakarta Selatan'),
            'event_maps_url' => Setting::get('event_maps_url', 'https://maps.google.com/?q=SCBD+Jakarta'),
            'event_maps_iframe' => Setting::get('event_maps_iframe', ''),
            'event_dresscode' => Setting::get('event_dresscode', 'By invitation only. Kindly confirm your attendance with the GWI team'),
            'event_description' => Setting::get('event_description', 'The Executive Roundtable — From AI Ambition to Enterprise Impact'),
            'event_flyer' => Setting::get('event_flyer', ''),
            'event_flyer_fit' => Setting::get('event_flyer_fit', 'contain'),
            'display_welcome_text' => Setting::get('display_welcome_text', 'Selamat Datang di'),
            'display_event_title' => Setting::get('display_event_title', 'Wonderful 2026'),
            'display_instruction_text' => Setting::get('display_instruction_text', 'Silakan arahkan tiket QR Anda pada meja registrasi. Layar ini akan otomatis menampilkan verifikasi kehadiran secara real-time.'),
        ];

        return view('admin.event-settings', compact('settings'));
    }

    /**
     * Simpan pembaruan pengaturan acara
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'event_title' => 'required|string|max:255',
            'event_organizer' => 'nullable|string|max:255',
            'event_date' => 'required|string|max:100',
            'event_time' => 'required|string|max:100',
            'event_venue_name' => 'required|string|max:255',
            'event_venue_address' => 'required|string|max:500',
            'event_maps_url' => 'nullable|string|max:500',
            'event_maps_iframe' => 'nullable|string',
            'event_dresscode' => 'required|string|max:255',
            'event_description' => 'nullable|string|max:2000',
            'flyer_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:10240',
            'event_flyer_fit' => 'nullable|string|in:contain,cover',
            'display_welcome_text' => 'nullable|string|max:255',
            'display_event_title' => 'nullable|string|max:255',
            'display_instruction_text' => 'nullable|string|max:1000',
        ], [
            'flyer_file.image' => 'File flyer harus berupa format gambar (JPG, PNG, WEBP, atau AVIF).',
            'flyer_file.mimes' => 'Format file flyer yang diperbolehkan hanya JPG, JPEG, PNG, WEBP, atau AVIF.',
            'flyer_file.max' => 'Ukuran file flyer terlalu besar, maksimal 10 MB.',
            'event_title.required' => 'Judul / nama acara wajib diisi.',
            'event_date.required' => 'Tanggal acara wajib diisi.',
            'event_time.required' => 'Waktu acara wajib diisi.',
            'event_venue_name.required' => 'Nama gedung / ballroom wajib diisi.',
            'event_venue_address.required' => 'Alamat lengkap venue wajib diisi.',
            'event_dresscode.required' => 'Dresscode acara wajib diisi.',
        ]);

        // Hapus flyer jika ada permintaan hapus
        if ($request->input('remove_flyer') == '1') {
            Setting::set('event_flyer', '');
        }

        // Simpan flyer jika ada upload
        if ($request->hasFile('flyer_file')) {
            $file = $request->file('flyer_file');
            $filename = 'flyer_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/flyers');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            Setting::set('event_flyer', 'uploads/flyers/' . $filename);
        }

        // Simpan preferensi proporsi tampilan flyer (contain vs cover)
        Setting::set('event_flyer_fit', $request->input('event_flyer_fit', 'contain'));

        Setting::set('event_title', $validated['event_title']);
        Setting::set('event_organizer', $validated['event_organizer'] ?? 'Wonderful');
        Setting::set('event_date', $validated['event_date']);
        Setting::set('event_time', $validated['event_time']);
        Setting::set('event_venue_name', $validated['event_venue_name']);
        Setting::set('event_venue_address', $validated['event_venue_address']);
        Setting::set('event_maps_url', $validated['event_maps_url'] ?? null);
        Setting::set('event_maps_iframe', $validated['event_maps_iframe'] ?? null);
        Setting::set('event_dresscode', $validated['event_dresscode']);
        Setting::set('event_description', $validated['event_description'] ?? null);
        Setting::set('display_welcome_text', $validated['display_welcome_text'] ?? 'Selamat Datang di');
        Setting::set('display_event_title', $validated['display_event_title'] ?? 'Wonderful 2026');
        Setting::set('display_instruction_text', $validated['display_instruction_text'] ?? 'Silakan arahkan tiket QR Anda pada meja registrasi. Layar ini akan otomatis menampilkan verifikasi kehadiran secara real-time.');

        return redirect()->route('admin.event-settings')->with('success', 'Pengaturan acara berhasil diperbarui!');
    }
}
