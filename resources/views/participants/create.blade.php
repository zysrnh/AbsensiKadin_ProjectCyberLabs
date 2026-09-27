@extends('layouts.guest')

@section('title', $settings['event_title'] . ' - Registrasi KADIN')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6">

    <!-- Grid 2 Kolom Khas Luma Event Page -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">

        <!-- SISI KIRI (Col 7): Cover Poster, Host, Info Event & Detail -->
        <div class="lg:col-span-7 space-y-6">

            <!-- 1. Event Cover / Flyer Banner (Rasio Estetis Luma) -->
            <div class="border border-slate-200 rounded-sm bg-slate-900 overflow-hidden shadow-xs">
                @if(!empty($settings['event_flyer']))
                    <img 
                        src="{{ asset($settings['event_flyer']) }}" 
                        alt="{{ $settings['event_title'] }}" 
                        class="w-full h-auto max-h-[380px] object-cover"
                    >
                @else
                    <!-- Cover Resmi KADIN Berwibawa Ala Luma -->
                    <div class="w-full bg-slate-950 text-white p-7 sm:p-9 border-b-2 border-slate-800 flex flex-col justify-between min-h-[190px]">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="px-2.5 py-1 bg-white text-slate-950 font-black text-xs tracking-widest uppercase rounded-sm">
                                    KADIN
                                </span>
                                <span class="text-xs font-semibold text-slate-300">INDONESIA</span>
                            </div>
                            <span class="text-[11px] font-mono px-2 py-0.5 bg-slate-800 text-slate-300 rounded-sm uppercase tracking-wider">
                                Acara Resmi 2026
                            </span>
                        </div>
                        <div class="mt-6">
                            <span class="text-[11px] uppercase tracking-widest text-slate-400 font-semibold block">Temu Bisnis & Presensi Digital</span>
                            <p class="text-base sm:text-lg font-bold text-slate-200 mt-1">Sistem Pendaftaran Terverifikasi Peserta Kegiatan</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- 2. Profil Host / Penyelenggara (Verified Luma Style) -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-slate-900 text-white rounded-sm flex items-center justify-center font-black text-xs tracking-wider shrink-0 border border-slate-800">
                    KD
                </div>
                <div>
                    <span class="text-[11px] text-slate-500 font-medium block">Diselenggarakan oleh</span>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="text-sm font-bold text-slate-900">{{ $settings['event_organizer'] }}</span>
                        <!-- Verified Badge -->
                        <span class="inline-flex items-center justify-center w-4 h-4 bg-blue-600 text-white rounded-full text-[9px]" title="Terverifikasi">
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>

            <!-- 3. Judul Acara Utama (Gagah & Tegas) -->
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ $settings['event_title'] }}
                </h1>
            </div>

            <!-- 4. Card Event Details (Icon Kalender Khas Luma, Dresscode & Venue) -->
            <div class="bg-white border border-slate-200 rounded-sm divide-y divide-slate-100 shadow-xs">
                
                <!-- Tanggal & Waktu (Kotak Kalender Ala Luma) -->
                <div class="p-4 sm:p-5 flex items-start gap-4">
                    <!-- Mini Calendar Badge Luma -->
                    <div class="w-12 h-14 bg-slate-50 border border-slate-200 rounded-sm flex flex-col items-center justify-center shrink-0 overflow-hidden shadow-2xs">
                        <span class="w-full bg-slate-900 text-white text-[9px] font-bold uppercase py-0.5 text-center tracking-wider">
                            EVENT
                        </span>
                        <span class="text-base font-extrabold text-slate-900 leading-none my-auto">
                            26
                        </span>
                    </div>
                    <div class="min-w-0">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Waktu Pelaksanaan</span>
                        <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $settings['event_date'] }}</p>
                        <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $settings['event_time'] }}</span>
                        </p>
                    </div>
                </div>

                <!-- Dresscode Acara -->
                <div class="p-4 sm:p-5 flex items-start gap-4">
                    <div class="w-12 h-12 bg-slate-100 border border-slate-200 rounded-sm flex items-center justify-center shrink-0 text-slate-800">
                        <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Ketentuan Pakaian (Dresscode)</span>
                        <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $settings['event_dresscode'] }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">Diharapkan mengenakan busana sesuai ketentuan untuk menjaga ketertiban acara.</p>
                    </div>
                </div>

                <!-- Lokasi & Venue -->
                <div class="p-4 sm:p-5 flex items-start gap-4">
                    <div class="w-12 h-12 bg-slate-100 border border-slate-200 rounded-sm flex items-center justify-center shrink-0 text-slate-800">
                        <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-grow">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Lokasi & Venue</span>
                        <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $settings['event_venue_name'] }}</p>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">{{ $settings['event_venue_address'] }}</p>

                        @if(!empty($settings['event_maps_url']))
                            <div class="mt-2.5">
                                <a 
                                    href="{{ $settings['event_maps_url'] }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-semibold rounded-sm border border-slate-300 transition-colors"
                                >
                                    <span>Buka di Google Maps</span>
                                    <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- 5. Peta Google Maps Embed Iframe (Jika Diisi di Admin) -->
            @if(!empty($settings['event_maps_iframe']))
                <div class="bg-white border border-slate-200 rounded-sm p-4 shadow-xs space-y-2">
                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wider block">Peta Lokasi Acara</span>
                    <div class="w-full overflow-hidden rounded-sm border border-slate-200 aspect-video [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:border-0">
                        {!! $settings['event_maps_iframe'] !!}
                    </div>
                </div>
            @endif

            <!-- 6. Deskripsi / Tentang Acara -->
            @if(!empty($settings['event_description']))
                <div class="bg-white border border-slate-200 rounded-sm p-5 sm:p-6 shadow-xs space-y-2">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Tentang Kegiatan</h3>
                    <div class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">
                        {{ $settings['event_description'] }}
                    </div>
                </div>
            @endif

        </div>

        <!-- SISI KANAN (Col 5): Form Pendaftaran Sticky Card Ala Luma -->
        <div class="lg:col-span-5 lg:sticky lg:top-6 space-y-4">

            <!-- Card Registrasi Elegan -->
            <div class="bg-white border border-slate-200 rounded-sm shadow-xs p-6 sm:p-7">
                
                <!-- Card Header -->
                <div class="border-b border-slate-100 pb-4 mb-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold tracking-wider uppercase text-emerald-800 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-sm">
                            Registrasi Peserta
                        </span>
                        <span class="text-xs font-bold text-slate-900 bg-slate-100 px-2 py-0.5 rounded-sm">GRATIS</span>
                    </div>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 mt-2.5 tracking-tight">Daftar Kehadiran</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Isi formulir untuk penerbitan tiket presensi QR Code resmi.</p>
                </div>

                <!-- Alert Error Validasi -->
                @if($errors->any())
                    <div class="mb-4 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-sm text-xs">
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
                        <label for="name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name') }}" 
                            required 
                            placeholder="Contoh: Budi Santoso, S.E."
                            class="w-full px-3.5 py-2.5 bg-slate-50 border {{ $errors->has('name') ? 'border-rose-400 bg-rose-50/40' : 'border-slate-200' }} rounded-sm text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                        >
                    </div>

                    <!-- 2. No Telpon / WhatsApp -->
                    <div>
                        <label for="phone" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            No. Telepon / WhatsApp <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phone" 
                            value="{{ old('phone') }}" 
                            required 
                            placeholder="Contoh: 081234567890"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border {{ $errors->has('phone') ? 'border-rose-400 bg-rose-50/40' : 'border-slate-200' }} rounded-sm text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                        >
                    </div>

                    <!-- 3. Jabatan -->
                    <div>
                        <label for="position" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            Jabatan <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="position" 
                            id="position" 
                            value="{{ old('position') }}" 
                            required 
                            placeholder="Contoh: Direktur Utama / Manajer"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border {{ $errors->has('position') ? 'border-rose-400 bg-rose-50/40' : 'border-slate-200' }} rounded-sm text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                        >
                    </div>

                    <!-- 4. Company -->
                    <div>
                        <label for="company" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            Company / Instansi <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="company" 
                            id="company" 
                            value="{{ old('company') }}" 
                            required 
                            placeholder="Contoh: PT Sumber Pangan Nusantara"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border {{ $errors->has('company') ? 'border-rose-400 bg-rose-50/40' : 'border-slate-200' }} rounded-sm text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                        >
                    </div>

                    <!-- Info Box Tiket QR -->
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-sm text-[11px] text-slate-600 flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-slate-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Tiket QR Code resmi akan langsung diterbitkan setelah pendaftaran berhasil dikirim.</span>
                    </div>

                    <!-- Tombol Submit Solid Formal Charcoal -->
                    <div class="pt-1.5">
                        <button 
                            type="submit" 
                            class="w-full py-3 px-4 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs sm:text-sm rounded-sm transition-colors cursor-pointer flex items-center justify-center gap-2 border border-slate-900 shadow-2xs"
                        >
                            <span>Daftar Acara Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
