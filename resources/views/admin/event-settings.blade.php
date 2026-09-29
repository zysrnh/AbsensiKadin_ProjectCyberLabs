@extends('layouts.admin')

@section('title', 'Pengaturan Informasi Acara - Admin C Level 2026')

@section('content')
<div class="space-y-6 max-w-5xl">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-slate-100 border border-slate-200 rounded-sm mb-1 text-[11px] font-bold uppercase tracking-wider text-slate-700">
                Landing Page Acara
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Pengaturan Informasi Acara</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kustomisasi informasi kegiatan yang tampil di halaman depan pendaftaran ala Luma (Flyer, Waktu, Lokasi, Dresscode, dan Peta).</p>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('home') }}" target="_blank" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-800 font-semibold text-xs rounded-sm border border-slate-300 transition-colors flex items-center gap-1.5 shadow-2xs">
                <span>Lihat Halaman Depan</span>
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-sm text-xs flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-sm text-xs">
            <p class="font-bold mb-1">Terjadi kesalahan pengisian formulir:</p>
            <ul class="list-disc list-inside space-y-0.5 ml-2 text-rose-700">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Setting Acara -->
    <form action="{{ route('admin.event-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Card 1: Visual & Identitas Acara -->
        <div class="bg-white border border-slate-200 rounded-sm p-6 shadow-xs space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">1. Flyer & Identitas Acara</h2>
                <p class="text-xs text-slate-500 mt-0.5">Unggah poster visual kegiatan dan tentukan judul resmi acara.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                <!-- Preview Flyer -->
                <div class="md:col-span-4">
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                        Flyer / Poster Acara
                    </label>
                    <div class="border border-slate-200 rounded-sm p-3 bg-slate-50 text-center">
                        @if(!empty($settings['event_flyer']))
                            <img src="{{ asset($settings['event_flyer']) }}" alt="Flyer Acara" class="w-full h-auto max-h-56 object-cover rounded-sm border border-slate-300 mb-3 mx-auto">
                        @else
                            <div class="w-full h-44 bg-slate-200 border border-dashed border-slate-300 rounded-sm flex flex-col items-center justify-center text-slate-500 mb-3">
                                <svg class="w-8 h-8 text-slate-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs">Belum ada flyer</span>
                            </div>
                        @endif
                        <input type="file" name="flyer_file" accept="image/*" class="text-xs text-slate-600 w-full file:mr-2 file:py-1.5 file:px-3 file:rounded-sm file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800 cursor-pointer">
                        <span class="text-[10px] text-slate-400 block mt-1">Format: JPG, PNG, WEBP (Maks 3MB)</span>
                    </div>
                </div>

                <!-- Input Detail Judul & Penyelenggara -->
                <div class="md:col-span-8 space-y-4">
                    <div>
                        <label for="event_title" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Judul / Nama Acara <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="event_title" id="event_title" value="{{ old('event_title', $settings['event_title']) }}" required class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-sm text-sm text-slate-900 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="event_organizer" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Penyelenggara (Host)
                            </label>
                            <input type="text" name="event_organizer" id="event_organizer" value="{{ old('event_organizer', $settings['event_organizer']) }}" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-sm text-sm text-slate-900 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900">
                        </div>

                        <div>
                            <label for="event_dresscode" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Dresscode Acara <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="event_dresscode" id="event_dresscode" value="{{ old('event_dresscode', $settings['event_dresscode']) }}" required placeholder="Contoh: Batik Formal / Pakaian Bisnis" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-sm text-sm text-slate-900 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900">
                        </div>
                    </div>

                    <div>
                        <label for="event_description" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Deskripsi / Tentang Acara
                        </label>
                        <textarea name="event_description" id="event_description" rows="3" class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-sm text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900" placeholder="Jelaskan gambaran umum kegiatan...">{{ old('event_description', $settings['event_description']) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Jadwal, Tempat, & Peta -->
        <div class="bg-white border border-slate-200 rounded-sm p-6 shadow-xs space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">2. Jadwal, Lokasi & Peta Lokasi</h2>
                <p class="text-xs text-slate-500 mt-0.5">Atur waktu pelaksanaan, nama gedung, serta integrasi peta Google Maps.</p>
            </div>

            <!-- Jadwal Waktu -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="event_date" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tanggal Acara <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="event_date" id="event_date" value="{{ old('event_date', $settings['event_date']) }}" required placeholder="Contoh: 28 Oktober 2026" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-sm text-sm text-slate-900 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900">
                </div>

                <div>
                    <label for="event_time" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Jam / Waktu Pelaksanaan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="event_time" id="event_time" value="{{ old('event_time', $settings['event_time']) }}" required placeholder="Contoh: 08:30 - 16:30 WIB" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-sm text-sm text-slate-900 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900">
                </div>
            </div>

            <!-- Lokasi Gedung -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="event_venue_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Gedung / Ballroom <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="event_venue_name" id="event_venue_name" value="{{ old('event_venue_name', $settings['event_venue_name']) }}" required placeholder="Contoh: Grand Ballroom C Level Hall" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-sm text-sm text-slate-900 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900">
                </div>

                <div>
                    <label for="event_maps_url" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tautan Google Maps Langsung (Link URL)
                    </label>
                    <input type="url" name="event_maps_url" id="event_maps_url" value="{{ old('event_maps_url', $settings['event_maps_url']) }}" placeholder="https://maps.google.com/?q=..." class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-sm text-sm text-slate-900 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900">
                </div>
            </div>

            <div>
                <label for="event_venue_address" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Alamat Lengkap Venue <span class="text-rose-500">*</span>
                </label>
                <textarea name="event_venue_address" id="event_venue_address" rows="2" required class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-sm text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900" placeholder="Contoh: Jl. H. R. Rasuna Said Blok X-5 Kav. 2-3, Setiabudi, Jakarta Selatan">{{ old('event_venue_address', $settings['event_venue_address']) }}</textarea>
            </div>

            <!-- Embed Iframe Google Maps -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="event_maps_iframe" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Kode Embed Iframe Google Maps (Opsional)
                    </label>
                    <span class="text-[10px] text-slate-400">Salin dari Google Maps > Share > Embed a map</span>
                </div>
                <textarea name="event_maps_iframe" id="event_maps_iframe" rows="3" class="w-full px-3.5 py-2 bg-slate-50 font-mono text-xs text-slate-800 border border-slate-300 rounded-sm focus:outline-none focus:border-slate-900 focus:bg-white" placeholder="Contoh: <iframe src=&quot;https://www.google.com/maps/embed?...&quot; ...></iframe>">{{ old('event_maps_iframe', $settings['event_maps_iframe']) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Jika diisi, peta Google Maps interaktif akan langsung tayang di landing page acara.</p>
            </div>
        </div>

        <!-- Tombol Aksi Simpan Solid Charcoal -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors cursor-pointer border border-slate-900 flex items-center gap-2 shadow-2xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Simpan Perubahan Acara</span>
            </button>
        </div>
    </form>

</div>
@endsection
