@extends('layouts.guest')

@section('title', $settings['event_title'] . ' - C LEVEL Indonesia')

@push('styles')
<style>
    /* ==========================================================================
       ANIMASI ENTRANCE & MICRO-INTERACTIONS (TERINSPIRASI VIDEO SHOWCASE)
       Easing: Apple / Ease-out-expo cubic-bezier(0.16, 1, 0.3, 1)
       ========================================================================== */
    @keyframes fadeUpEntrance {
        0% {
            opacity: 0;
            transform: translateY(28px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes floatPhoneMockup {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-8px) rotate(-0.5deg);
        }
    }

    @keyframes floatPill {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-5px);
        }
    }

    /* Staggered Delay Classes */
    .anim-hero-text {
        animation: fadeUpEntrance 0.85s cubic-bezier(0.16, 1, 0.3, 1) 0.05s backwards;
    }
    .anim-hero-phone {
        animation: fadeUpEntrance 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.2s backwards;
    }
    .anim-phone-floating {
        animation: floatPhoneMockup 5.5s ease-in-out infinite;
    }
    .anim-pill-floating {
        animation: floatPill 4s ease-in-out infinite;
    }
    .anim-pill-floating-delay {
        animation: floatPill 4.5s ease-in-out 1.5s infinite;
    }
    .anim-info-bar {
        animation: fadeUpEntrance 0.85s cubic-bezier(0.16, 1, 0.3, 1) 0.35s backwards;
    }
    .anim-bottom-section {
        animation: fadeUpEntrance 0.85s cubic-bezier(0.16, 1, 0.3, 1) 0.5s backwards;
    }

    html {
        scroll-behavior: smooth;
    }
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 py-2">

    <!-- ==========================================================================
         1. HERO SECTION ATAS (HEADLINE + PHONE MOCKUP SLIDE-IN)
         ========================================================================== -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center pt-2 sm:pt-6">
        
        <!-- Sisi Kiri Hero: Teks & Action -->
        <div class="lg:col-span-7 space-y-6 anim-hero-text">
            
            <!-- Badge Undangan Resmi -->
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 border border-blue-200 rounded-sm text-blue-900 text-xs font-bold tracking-wider uppercase">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                <span>Exclusive Invitation &bull; C LEVEL Indonesia</span>
            </div>

            <!-- Headline Utama (Plus Jakarta Sans Bold) -->
            <div class="space-y-3">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 leading-[1.15] tracking-tight">
                    {{ $settings['event_title'] }}
                </h1>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl font-normal">
                    {{ $settings['event_description'] }}
                </p>
            </div>

            <!-- Tombol Aksi Cepat -->
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <a href="#registration-section" 
                   class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm tracking-wide rounded-sm transition-all duration-200 flex items-center gap-2 border border-slate-900 shadow-2xs cursor-pointer active:translate-y-0.5">
                    <span>Ajukan Kehadiran Sekarang</span>
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </a>
                
                @if(!empty($settings['event_maps_url']))
                    <a href="{{ $settings['event_maps_url'] }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="px-5 py-3 bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 font-semibold text-xs sm:text-sm rounded-sm transition-colors border border-slate-300 flex items-center gap-2 shadow-2xs">
                        <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Buka Rute Maps</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                @endif
            </div>

            <!-- Jaminan Kemudahan -->
            <div class="flex items-center gap-5 pt-3 text-xs text-slate-500 border-t border-slate-200">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Tiket Digital Instan</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Kirim via WhatsApp</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Fast Check-in 1 Detik</span>
                </div>
            </div>

        </div>

        <!-- Sisi Kanan Hero: Visual Mockup Smartphone Floating (Mirip Video) -->
        <div class="lg:col-span-5 flex justify-center lg:justify-end anim-hero-phone">
            <div class="relative w-full max-w-[310px] anim-phone-floating">
                
                <!-- Floating Badge Pill Atas (Khas Video) -->
                <div class="absolute -top-3 -left-4 z-20 bg-white border border-slate-200 shadow-sm rounded-sm px-3 py-1.5 flex items-center gap-2 anim-pill-floating">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span class="text-[11px] font-bold text-slate-800 tracking-tight">E-Ticket QR Ready</span>
                </div>

                <!-- Floating Badge Pill Bawah (Khas Video) -->
                <div class="absolute -bottom-4 -right-4 z-20 bg-slate-900 border border-slate-800 text-white shadow-sm rounded-sm px-3 py-2 flex items-center gap-2 anim-pill-floating-delay">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                    <div class="text-left">
                        <p class="text-[10px] text-slate-400 font-medium leading-none">Status Akses</p>
                        <p class="text-xs font-bold text-white mt-0.5 leading-none">Tamu VIP & Executive</p>
                    </div>
                </div>

                <!-- Kerangka Smartphone Flat Minimalis -->
                <div class="bg-slate-950 p-3 rounded-2xl border-4 border-slate-800 shadow-xl overflow-hidden">
                    
                    <!-- Dynamic Island / Speaker Kamera -->
                    <div class="w-24 h-4 bg-slate-900 rounded-full mx-auto mb-2 flex items-center justify-center">
                        <span class="w-2 h-2 rounded-full bg-slate-800"></span>
                    </div>

                    <!-- Layar Smartphone -->
                    <div class="bg-slate-900 rounded-xl p-4 text-white space-y-4">
                        
                        <!-- Header Mockup App -->
                        <div class="flex items-center justify-between border-b border-slate-800 pb-2.5">
                            <div class="flex items-center gap-1.5">
                                <span class="px-1.5 py-0.5 bg-blue-600 text-white font-extrabold text-[9px] rounded-xs uppercase">
                                    C LEVEL
                                </span>
                                <span class="text-[11px] font-bold text-white">Scanner 2026</span>
                            </div>
                            <span class="text-[10px] text-slate-400 font-mono">09:41 WIB</span>
                        </div>

                        <!-- Card QR Code di dalam Mockup -->
                        <div class="bg-white rounded-lg p-4 text-center text-slate-900 space-y-2.5">
                            <span class="text-[9px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-50 px-2 py-0.5 rounded-xs inline-block">
                                Kartu Presensi Digital
                            </span>
                            
                            <!-- Visual QR Dummy Rapi -->
                            <div class="w-32 h-32 mx-auto bg-slate-50 border border-slate-200 p-2 flex flex-col items-center justify-center rounded-sm">
                                <svg class="w-24 h-24 text-slate-900" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M2 2h8v8H2V2zm2 2v4h4V4H4zm10-2h8v8h-8V2zm2 2v4h4V4h-4zM2 14h8v8H2v-8zm2 2v4h4v-4H4zm14-2h4v2h-4v-2zm-4 0h2v4h-2v-4zm2 4h2v4h-2v-4zm2 2h4v2h-4v-2zm-6-2h2v2h-2v-2zm4-4h2v2h-2v-2zm-2-2h2v2h-2v-2z"/>
                                </svg>
                            </div>
                            
                            <p class="font-mono text-xs font-bold text-slate-950 tracking-wider">CL26-EXECUTIVE</p>
                            <p class="text-[10px] text-slate-500 leading-tight">Tunjukkan kepada panitia di pintu masuk ballroom.</p>
                        </div>

                        <!-- Card Peserta Mockup -->
                        <div class="bg-slate-800/80 border border-slate-700/60 p-2.5 rounded-lg flex items-center justify-between text-xs">
                            <div>
                                <p class="text-[10px] text-slate-400">Verifikasi Langsung</p>
                                <p class="font-bold text-white text-xs mt-0.5">Pintu Masuk VIP</p>
                            </div>
                            <span class="px-2 py-1 bg-emerald-500 text-slate-950 font-bold text-[10px] rounded-xs uppercase">
                                Valid
                            </span>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </section>


    <!-- ==========================================================================
         2. BLOK INFORMASI ACARA (URUTAN: LOKASI -> TANGGAL -> WAKTU -> DRESSCODE)
         ========================================================================== -->
    <section class="anim-info-bar">
        
        <!-- Header Kecil Section Info -->
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <span class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                <span class="w-1.5 h-3 bg-blue-600 rounded-none inline-block"></span>
                Rincian Jadwal & Tempat Acara
            </span>
            <span class="text-[11px] text-slate-500">Konfirmasi Kehadiran Wajib Terdaftar</span>
        </div>

        <!-- Bar Card Solid Royal Blue (Khas Campty Stats Bar) -->
        <div class="bg-blue-700 text-white rounded-sm shadow-xs border border-blue-800 p-5 sm:p-7">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 divide-y sm:divide-y-0 lg:divide-x divide-blue-600/70">
                
                <!-- 1. LOKASI / GEDUNG -->
                <div class="space-y-2 lg:pr-5 pt-3 sm:pt-0">
                    <div class="flex items-center gap-2 text-blue-200">
                        <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-[11px] font-bold uppercase tracking-wider">Lokasi / Venue</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-black text-white leading-snug tracking-tight">
                        {{ $settings['event_venue_name'] }}
                    </h3>
                    <p class="text-xs text-blue-100/90 leading-relaxed font-normal">
                        {{ $settings['event_venue_address'] }}
                    </p>
                    @if(!empty($settings['event_maps_url']))
                        <a href="{{ $settings['event_maps_url'] }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-1 text-[11px] font-bold text-white bg-blue-800/80 hover:bg-blue-900 px-2.5 py-1 rounded-xs mt-1 transition-colors">
                            <span>Buka Google Maps</span>
                            <svg class="w-3 h-3 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    @endif
                </div>

                <!-- 2. TANGGAL -->
                <div class="space-y-2 sm:pl-0 lg:px-5 pt-4 sm:pt-0">
                    <div class="flex items-center gap-2 text-blue-200">
                        <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-[11px] font-bold uppercase tracking-wider">Tanggal Pelaksanaan</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-white leading-tight tracking-tight">
                        {{ $settings['event_date'] }}
                    </h3>
                    <p class="text-xs text-blue-100 font-medium">
                        Agenda Resmi C LEVEL 2026
                    </p>
                </div>

                <!-- 3. WAKTU -->
                <div class="space-y-2 sm:pl-0 lg:px-5 pt-4 sm:pt-0">
                    <div class="flex items-center gap-2 text-blue-200">
                        <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-[11px] font-bold uppercase tracking-wider">Waktu / Jam</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-white leading-tight tracking-tight">
                        {{ $settings['event_time'] }}
                    </h3>
                    <p class="text-xs text-blue-100 font-medium">
                        Registrasi & Sesi Konferensi
                    </p>
                </div>

                <!-- 4. DRESSCODE -->
                <div class="space-y-2 sm:pl-0 lg:pl-5 pt-4 sm:pt-0">
                    <div class="flex items-center gap-2 text-blue-200">
                        <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-[11px] font-bold uppercase tracking-wider">Ketentuan Busana</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-black text-white leading-snug tracking-tight">
                        {{ $settings['event_dresscode'] }}
                    </h3>
                    <p class="text-xs text-blue-100 font-medium">
                        Standar Kehadiran Eksekutif
                    </p>
                </div>

            </div>
        </div>

    </section>


    <!-- ==========================================================================
         3. SECTION PALING BAWAH: FLYER ACARA & FORMULIR REGISTRASI
         ========================================================================== -->
    <section id="registration-section" class="pt-4 anim-bottom-section">
        
        <!-- Header Section Registrasi -->
        <div class="text-center max-w-xl mx-auto mb-8 space-y-2">
            <span class="px-2.5 py-0.5 bg-slate-900 text-white font-extrabold text-[10px] tracking-widest uppercase rounded-xs">
                Registrasi Peserta
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Formulir Pendaftaran & E-Ticket
            </h2>
            <p class="text-xs text-slate-500 leading-relaxed font-normal">
                Silakan lengkapi formulir di bawah ini. E-Ticket QR Code presensi resmi akan langsung dikirimkan ke kontak WhatsApp Anda.
            </p>
        </div>

        <!-- Grid 2 Kolom: Sisi Kiri Flyer & Sisi Kanan Form -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- ================= SISI KIRI: FLYER / POSTER ACARA ================= -->
            <div class="lg:col-span-5 space-y-5">
                
                <!-- Card Poster Acara -->
                <div class="border border-slate-200 rounded-sm bg-white overflow-hidden shadow-xs">
                    
                    @if(!empty($settings['event_flyer']))
                        <img 
                            src="{{ asset($settings['event_flyer']) }}" 
                            alt="{{ $settings['event_title'] }}" 
                            class="w-full h-auto object-cover"
                            style="aspect-ratio: 1/1; width: 100%; object-fit: cover;"
                        >
                    @else
                        <!-- Poster Grafis Default C LEVEL yang Proporsional -->
                        <div class="bg-slate-900 text-white p-6 sm:p-7 flex flex-col justify-between border-b-4 border-blue-600" style="aspect-ratio: 1/1; min-height: 320px;">
                            
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-0.5 bg-blue-600 text-white font-black text-xs tracking-widest uppercase rounded-xs">
                                    C LEVEL
                                </span>
                                <span class="text-[11px] font-mono text-slate-400 uppercase tracking-wider">
                                    TAHUN 2026
                                </span>
                            </div>

                            <div class="my-auto py-4 space-y-2">
                                <span class="text-[10px] uppercase tracking-widest text-blue-400 font-bold block">
                                    Official Invitation
                                </span>
                                <h3 class="text-xl sm:text-2xl font-black text-white leading-tight tracking-tight">
                                    {{ $settings['event_title'] }}
                                </h3>
                                <p class="text-xs text-slate-400 font-medium">C LEVEL Indonesia</p>
                            </div>

                            <div class="pt-3 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
                                <span>{{ $settings['event_date'] }}</span>
                                <span>{{ $settings['event_venue_name'] }}</span>
                            </div>

                        </div>
                    @endif

                    <!-- Detail Tambahan di Bawah Poster -->
                    <div class="p-4 bg-slate-50 border-t border-slate-100 text-xs space-y-2.5">
                        <div class="flex items-start gap-2 text-slate-700">
                            <svg class="w-4 h-4 text-blue-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <div>
                                <strong class="text-slate-900 block font-bold">Penyelenggara Resmi:</strong>
                                <span class="text-slate-600">{{ $settings['event_organizer'] }}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 text-slate-700">
                            <svg class="w-4 h-4 text-blue-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <div>
                                <strong class="text-slate-900 block font-bold">Sistem Verifikasi:</strong>
                                <span class="text-slate-600">Presensi Berbasis QR Code Unik Terenkripsi</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


            <!-- ================= SISI KANAN: FORMULIR PENDAFTARAN PESERTA ================= -->
            <div class="lg:col-span-7 space-y-4">
                
                <div class="bg-white border border-slate-200 rounded-sm shadow-xs p-5 sm:p-7 space-y-5">
                    
                    <!-- Header Form -->
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-4">
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">Data Calon Peserta</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Isi seluruh informasi dengan akurat untuk pencetakan ID Card & Tiket.</p>
                        </div>
                        <div class="flex items-center gap-1.5">
                            @if($settings['registration_deadline_enabled'])
                                <span class="text-[10px] font-bold {{ $isExpired ? 'text-rose-800 bg-rose-50 border-rose-200' : 'text-amber-800 bg-amber-50 border-amber-200' }} border px-2 py-0.5 rounded-sm uppercase tracking-wider">
                                    {{ $isExpired ? 'Pendaftaran Ditutup' : 'Batas: ' . $settings['registration_deadline_text'] }}
                                </span>
                            @endif
                            <span class="text-[10px] font-bold text-emerald-800 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-sm uppercase tracking-wider">
                                BEBAS BIAYA
                            </span>
                        </div>
                    </div>

                    <!-- Alert Jika Pendaftaran Ditutup -->
                    @if($isExpired)
                        <div class="p-4 bg-rose-50 border border-rose-300 rounded-sm text-xs text-rose-900 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-sm bg-rose-200/80 text-rose-800 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="space-y-0.5">
                                <h4 class="font-bold text-rose-900 uppercase tracking-wider text-[11px]">Pendaftaran Telah Ditutup</h4>
                                <p class="text-rose-800 leading-relaxed text-[11px]">
                                    Mohon maaf, batas waktu pendaftaran untuk kegiatan ini telah berakhir pada <strong>{{ $settings['registration_deadline_text'] }}</strong>. Formulir tidak menerima pendaftaran baru.
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Alert Error Validasi Input -->
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

                    <!-- Formulir Form Action POST -->
                    <form action="{{ route('participants.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- 1. Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-xs font-semibold text-slate-800 uppercase tracking-wider mb-1.5">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name') }}" 
                                {{ $isExpired ? 'disabled' : 'required' }}
                                placeholder="Contoh: Budi Santoso, S.E., M.M."
                                class="w-full px-3.5 py-2.5 {{ $isExpired ? 'bg-slate-100 text-slate-400 cursor-not-allowed border-slate-200 opacity-70' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-slate-900' }} border {{ $errors->has('name') ? 'border-rose-400 bg-rose-50/40' : '' }} rounded-sm text-xs sm:text-sm placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-900 transition-colors"
                            >
                        </div>

                        <!-- 2. No Telpon / WhatsApp -->
                        <div>
                            <label for="phone" class="block text-xs font-semibold text-slate-800 uppercase tracking-wider mb-1.5">
                                Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="tel" 
                                name="phone" 
                                id="phone" 
                                value="{{ old('phone') }}" 
                                {{ $isExpired ? 'disabled' : 'required' }}
                                placeholder="Contoh: 081234567890"
                                class="w-full px-3.5 py-2.5 {{ $isExpired ? 'bg-slate-100 text-slate-400 cursor-not-allowed border-slate-200 opacity-70' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-slate-900' }} border {{ $errors->has('phone') ? 'border-rose-400 bg-rose-50/40' : '' }} rounded-sm text-xs sm:text-sm placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-900 transition-colors"
                            >
                            <span class="text-[11px] text-slate-400 mt-1 block">Tiket QR dan pengingat jadwal akan dikirimkan otomatis ke nomor ini.</span>
                        </div>

                        <!-- 3. Perusahaan / Instansi & 4. Jabatan (Grid 2 Kolom) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Company -->
                            <div>
                                <label for="company" class="block text-xs font-semibold text-slate-800 uppercase tracking-wider mb-1.5">
                                    Instansi / Perusahaan <span class="text-rose-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="company" 
                                    id="company" 
                                    value="{{ old('company') }}" 
                                    {{ $isExpired ? 'disabled' : 'required' }}
                                    placeholder="Contoh: PT Sumber Pangan"
                                    class="w-full px-3.5 py-2.5 {{ $isExpired ? 'bg-slate-100 text-slate-400 cursor-not-allowed border-slate-200 opacity-70' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-slate-900' }} border {{ $errors->has('company') ? 'border-rose-400 bg-rose-50/40' : '' }} rounded-sm text-xs sm:text-sm placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-900 transition-colors"
                                >
                            </div>

                            <!-- Position -->
                            <div>
                                <label for="position" class="block text-xs font-semibold text-slate-800 uppercase tracking-wider mb-1.5">
                                    Jabatan / Posisi <span class="text-rose-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="position" 
                                    id="position" 
                                    value="{{ old('position') }}" 
                                    {{ $isExpired ? 'disabled' : 'required' }}
                                    placeholder="Contoh: Chief Executive Officer"
                                    class="w-full px-3.5 py-2.5 {{ $isExpired ? 'bg-slate-100 text-slate-400 cursor-not-allowed border-slate-200 opacity-70' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-slate-900' }} border {{ $errors->has('position') ? 'border-rose-400 bg-rose-50/40' : '' }} rounded-sm text-xs sm:text-sm placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-900 transition-colors"
                                >
                            </div>
                        </div>

                        <!-- 5. Email (Opsional) -->
                        <div>
                            <label for="email" class="block text-xs font-semibold text-slate-800 uppercase tracking-wider mb-1.5">
                                Alamat Email <span class="text-slate-400 font-normal">(Opsional)</span>
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email') }}" 
                                {{ $isExpired ? 'disabled' : '' }}
                                placeholder="budi@perusahaan.co.id"
                                class="w-full px-3.5 py-2.5 {{ $isExpired ? 'bg-slate-100 text-slate-400 cursor-not-allowed border-slate-200 opacity-70' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-slate-900' }} border {{ $errors->has('email') ? 'border-rose-400 bg-rose-50/40' : '' }} rounded-sm text-xs sm:text-sm placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-900 transition-colors"
                            >
                        </div>

                        <!-- Info Box Permohonan -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-sm text-xs text-slate-600 flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="leading-relaxed">
                                {{ $isExpired ? 'Pendaftaran ditutup karena telah melewati batas kadaluarsa.' : 'Permohonan kehadiran Anda akan tercatat dalam sistem pendaftaran C LEVEL dan diverifikasi oleh panitia.' }}
                            </span>
                        </div>

                        <!-- Tombol Submit Request to Join / Pendaftaran Ditutup -->
                        <div class="pt-2">
                            @if($isExpired)
                                <button 
                                    type="button" 
                                    disabled
                                    class="w-full py-3 px-5 bg-slate-200 text-slate-500 font-semibold text-xs sm:text-sm rounded-sm cursor-not-allowed flex items-center justify-center gap-2 border border-slate-300 shadow-none"
                                >
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <span>Pendaftaran Telah Ditutup</span>
                                </button>
                            @else
                                <button 
                                    type="submit" 
                                    class="w-full py-3.5 px-6 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm tracking-wide rounded-sm transition-all duration-200 cursor-pointer flex items-center justify-center gap-2 border border-slate-900 shadow-xs active:translate-y-0.5"
                                >
                                    <span>Request to Join (Kirim Permohonan)</span>
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </button>
                            @endif
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </section>

</div>
@endsection
