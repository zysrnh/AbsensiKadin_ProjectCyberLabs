@extends('layouts.guest')

@section('title', $settings['event_title'] . ' - KADIN Indonesia')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6">

    <!-- Container Grid 2 Kolom dengan Fallback CSS Grid Manual (Tahan Purging) -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">

        <!-- ================= SISI KIRI: Poster Acara, Deskripsi & Peta ================= -->
        <div class="space-y-6" style="min-width: 300px;">

            <!-- 1. Poster / Flyer Acara (Rasio Persegi Mantap) -->
            <div class="border border-slate-200 rounded-sm bg-white overflow-hidden shadow-xs">
                @if(!empty($settings['event_flyer']))
                    <img 
                        src="{{ asset($settings['event_flyer']) }}" 
                        alt="{{ $settings['event_title'] }}" 
                        class="w-full h-auto object-cover"
                        style="aspect-ratio: 1/1; width: 100%; object-fit: cover;"
                    >
                @else
                    <!-- Poster Grafis Default KADIN yang Proporsional -->
                    <div class="bg-slate-900 text-white p-6 sm:p-7 flex flex-col justify-between border-b-4 border-blue-600" style="aspect-ratio: 1/1; min-height: 320px;">
                        <div class="flex items-center justify-between">
                            <span class="px-2 py-0.5 bg-blue-600 text-white font-black text-xs tracking-widest uppercase rounded-xs">
                                KADIN
                            </span>
                            <span class="text-[11px] font-mono text-slate-400 uppercase tracking-wider">
                                TAHUN 2026
                            </span>
                        </div>

                        <div class="my-auto py-4">
                            <span class="text-[10px] uppercase tracking-widest text-blue-400 font-bold block mb-1">
                                Undangan Resmi
                            </span>
                            <h3 class="text-xl sm:text-2xl font-black text-white leading-tight tracking-tight">
                                {{ $settings['event_title'] }}
                            </h3>
                            <p class="text-xs text-slate-400 mt-2 font-medium">Kamar Dagang dan Industri Indonesia</p>
                        </div>

                        <div class="pt-3 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
                            <span>Presensi Digital</span>
                            <span class="font-mono text-slate-300">E-Ticket QR</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- 2. Tentang Acara -->
            @if(!empty($settings['event_description']))
                <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-xs space-y-2">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Tentang Kegiatan</h3>
                    <div class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">
                        {{ $settings['event_description'] }}
                    </div>
                </div>
            @endif

            <!-- 3. Peta Lokasi (Iframe Embed) -->
            @if(!empty($settings['event_maps_iframe']))
                <div class="bg-white border border-slate-200 rounded-sm p-4 shadow-xs space-y-2">
                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wider block">Peta Lokasi</span>
                    <div class="w-full overflow-hidden rounded-sm border border-slate-200 aspect-video [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:border-0">
                        {!! $settings['event_maps_iframe'] !!}
                    </div>
                </div>
            @endif

        </div>

        <!-- ================= SISI KANAN: Header, Detail Logistik, & Form Pendaftaran ================= -->
        <div class="space-y-6" style="min-width: 320px;">

            <!-- 1. Header Informasi Acara -->
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 bg-slate-900 text-white font-bold text-[10px] rounded-xs">
                        HOST
                    </span>
                    <span class="text-xs font-semibold text-slate-700">{{ $settings['event_organizer'] }}</span>
                    <span class="inline-flex items-center justify-center w-3.5 h-3.5 bg-blue-600 text-white rounded-full text-[8px]" title="Penyelenggara Terverifikasi">
                        <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ $settings['event_title'] }}
                </h1>
            </div>

            <!-- 2. Detail Logistik (Waktu, Dresscode, Lokasi) -->
            <div class="bg-white border border-slate-200 rounded-sm divide-y divide-slate-100 shadow-xs text-xs">
                
                <!-- Waktu & Tanggal -->
                <div class="p-3.5 sm:p-4 flex items-start gap-3">
                    <div class="w-9 h-9 bg-slate-100 border border-slate-200 rounded-sm flex items-center justify-center shrink-0 text-slate-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Waktu Pelaksanaan</span>
                        <p class="text-xs sm:text-sm font-bold text-slate-900 mt-0.5">{{ $settings['event_date'] }}</p>
                        <p class="text-slate-500 mt-0.5">{{ $settings['event_time'] }}</p>
                    </div>
                </div>

                <!-- Dresscode -->
                <div class="p-3.5 sm:p-4 flex items-start gap-3">
                    <div class="w-9 h-9 bg-slate-100 border border-slate-200 rounded-sm flex items-center justify-center shrink-0 text-slate-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Dresscode Acara</span>
                        <p class="text-xs sm:text-sm font-bold text-slate-900 mt-0.5">{{ $settings['event_dresscode'] }}</p>
                    </div>
                </div>

                <!-- Lokasi & Venue -->
                <div class="p-3.5 sm:p-4 flex items-start gap-3">
                    <div class="w-9 h-9 bg-slate-100 border border-slate-200 rounded-sm flex items-center justify-center shrink-0 text-slate-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="flex-grow min-w-0">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Lokasi & Venue</span>
                        <p class="text-xs sm:text-sm font-bold text-slate-900 mt-0.5">{{ $settings['event_venue_name'] }}</p>
                        <p class="text-slate-500 mt-0.5 leading-relaxed">{{ $settings['event_venue_address'] }}</p>

                        @if(!empty($settings['event_maps_url']))
                            <div class="mt-2">
                                <a 
                                    href="{{ $settings['event_maps_url'] }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 hover:bg-slate-100 text-slate-700 text-[11px] font-semibold rounded-sm border border-slate-200 transition-colors"
                                >
                                    <span>Buka di Google Maps</span>
                                    <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- 3. Form Registrasi Peserta -->
            <div class="bg-white border border-slate-200 rounded-sm shadow-xs p-5 sm:p-6 space-y-4">
                
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 tracking-tight">Formulir Pendaftaran</h2>
                        <p class="text-[11px] text-slate-500 mt-0.5">Lengkapi data untuk mendapatkan tiket QR Code resmi.</p>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-800 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-sm uppercase tracking-wider">
                        GRATIS
                    </span>
                </div>

                <!-- Alert Error Validasi -->
                @if($errors->any())
                    <div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-sm text-xs">
                        <p class="font-bold mb-1">Periksa kembali data Anda:</p>
                        <ul class="list-disc list-inside space-y-0.5 ml-1 text-rose-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Submit 4 Field Wajib -->
                <form action="{{ route('participants.store') }}" method="POST" class="space-y-3.5">
                    @csrf

                    <!-- 1. Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name') }}" 
                            required 
                            placeholder="Contoh: Budi Santoso, S.E."
                            class="w-full px-3 py-2 bg-slate-50 border {{ $errors->has('name') ? 'border-rose-400 bg-rose-50/40' : 'border-slate-200' }} rounded-sm text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                        >
                    </div>

                    <!-- 2. No Telpon / WhatsApp -->
                    <div>
                        <label for="phone" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            No. Telepon / WhatsApp <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phone" 
                            value="{{ old('phone') }}" 
                            required 
                            placeholder="Contoh: 081234567890"
                            class="w-full px-3 py-2 bg-slate-50 border {{ $errors->has('phone') ? 'border-rose-400 bg-rose-50/40' : 'border-slate-200' }} rounded-sm text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                        >
                    </div>

                    <!-- 3. Jabatan -->
                    <div>
                        <label for="position" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            Jabatan <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="position" 
                            id="position" 
                            value="{{ old('position') }}" 
                            required 
                            placeholder="Contoh: Direktur Utama / Manajer"
                            class="w-full px-3 py-2 bg-slate-50 border {{ $errors->has('position') ? 'border-rose-400 bg-rose-50/40' : 'border-slate-200' }} rounded-sm text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                        >
                    </div>

                    <!-- 4. Company -->
                    <div>
                        <label for="company" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            Company / Instansi <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="company" 
                            id="company" 
                            value="{{ old('company') }}" 
                            required 
                            placeholder="Contoh: PT Sumber Pangan Nusantara"
                            class="w-full px-3 py-2 bg-slate-50 border {{ $errors->has('company') ? 'border-rose-400 bg-rose-50/40' : 'border-slate-200' }} rounded-sm text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                        >
                    </div>

                    <!-- Info Box Tiket QR -->
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-sm text-[11px] text-slate-600 flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 text-slate-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Tiket resmi QR Code akan langsung diterbitkan setelah pendaftaran dikirim.</span>
                    </div>

                    <!-- Tombol Submit Solid Charcoal -->
                    <div class="pt-1">
                        <button 
                            type="submit" 
                            class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs sm:text-sm rounded-sm transition-colors cursor-pointer flex items-center justify-center gap-2 border border-slate-900 shadow-2xs"
                        >
                            <span>Daftar Acara Sekarang</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>

</div>
@endsection
