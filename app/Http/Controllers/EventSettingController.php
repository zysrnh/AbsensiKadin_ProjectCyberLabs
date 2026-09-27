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
            'event_title' => Setting::get('event_title', 'Musyawarah & Temu Bisnis KADIN Indonesia 2026'),
            'event_organizer' => Setting::get('event_organizer', 'KADIN Indonesia'),
            'event_date' => Setting::get('event_date', '28 Oktober 2026'),
            'event_time' => Setting::get('event_time', '08:30 - 16:30 WIB'),
            'event_venue_name' => Setting::get('event_venue_name', 'Grand Ballroom Menara Kadin Indonesia'),
            'event_venue_address' => Setting::get('event_venue_address', 'Jl. H. R. Rasuna Said Blok X-5 Kav. 2-3, Setiabudi, Jakarta Selatan'),
            'event_maps_url' => Setting::get('event_maps_url', 'https://maps.google.com/?q=Menara+Kadin+Indonesia'),
            'event_maps_iframe' => Setting::get('event_maps_iframe', ''),
            'event_dresscode' => Setting::get('event_dresscode', 'Batik Formal / Pakaian Bisnis Rapi'),
            'event_description' => Setting::get('event_description', 'Pertemuan strategis para pelaku usaha, pimpinan asosiasi, dan pemangku kepentingan industri nasional dalam rangka akselerasi ekonomi dan kolaborasi bisnis berkelanjutan.'),
            'event_flyer' => Setting::get('event_flyer', ''),
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
            'flyer_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

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

        Setting::set('event_title', $validated['event_title']);
        Setting::set('event_organizer', $validated['event_organizer'] ?? 'KADIN Indonesia');
        Setting::set('event_date', $validated['event_date']);
        Setting::set('event_time', $validated['event_time']);
        Setting::set('event_venue_name', $validated['event_venue_name']);
        Setting::set('event_venue_address', $validated['event_venue_address']);
        Setting::set('event_maps_url', $validated['event_maps_url'] ?? null);
        Setting::set('event_maps_iframe', $validated['event_maps_iframe'] ?? null);
        Setting::set('event_dresscode', $validated['event_dresscode']);
        Setting::set('event_description', $validated['event_description'] ?? null);

        return redirect()->route('admin.event-settings')->with('success', 'Pengaturan acara berhasil diperbarui!');
    }
}
