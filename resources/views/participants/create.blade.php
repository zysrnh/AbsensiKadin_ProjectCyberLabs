@extends('layouts.guest')

@section('title', $settings['event_title'] . ' - C LEVEL Indonesia')

@push('styles')
<style>
    /* ==========================================================================
       SVGATOR-INSPIRED ANIMATION SYSTEM & SVG LINE DRAWING
       Referensi: https://www.svgator.com/blog/website-animation-examples-and-effects/
       ========================================================================== */
    :root {
        --ease-expo: cubic-bezier(0.16, 1, 0.3, 1);
        --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* 1. Kinetic Hero Entrance */
    @keyframes kineticReveal {
        0% {
            opacity: 0;
            transform: translateY(30px) scale(0.98);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* 2. SVG Self-Drawing Line Animation (SVGator Example #7 & #8) */
    @keyframes drawPath {
        0% {
            stroke-dashoffset: 400;
        }
        100% {
            stroke-dashoffset: 0;
        }
    }

    /* 3. Subtle Ambient Float Animation */
    @keyframes ambientFloat {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-8px);
        }
    }

    /* 4. Subtle Ambient Sparkle Rotation */
    @keyframes spinAmbient {
        0% {
            transform: rotate(0deg) scale(1);
        }
        50% {
            transform: rotate(180deg) scale(1.1);
        }
        100% {
            transform: rotate(360deg) scale(1);
        }
    }

    .anim-hero-text {
        animation: kineticReveal 0.9s var(--ease-expo) 0.1s backwards;
    }
    .anim-flyer-card {
        animation: kineticReveal 1s var(--ease-expo) 0.25s backwards;
    }
    .anim-floating {
        animation: ambientFloat 6s ease-in-out infinite;
    }
    .anim-spin {
        animation: spinAmbient 18s linear infinite;
    }

    .svg-draw-line {
        stroke-dasharray: 400;
        stroke-dashoffset: 400;
        animation: drawPath 1.6s var(--ease-expo) 0.4s forwards;
    }

    /* 3D Tilt Card Smooth Transition */
    .tilt-card-container {
        perspective: 1200px;
    }
    .tilt-card {
        transition: transform 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.3s ease;
        transform-style: preserve-3d;
        will-change: transform;
    }

    /* Reversible Scroll Reveal & Exit Animation (Mobile & Desktop) */
    .scroll-reveal {
        opacity: 0;
        transform: translateY(28px) scale(0.98);
        transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: opacity, transform;
    }
    .scroll-reveal.is-visible {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    /* Info Card Full Segment Navy Hover with Lift Up */
    .info-card {
        position: relative;
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.25s ease, box-shadow 0.25s ease, border-radius 0.2s ease;
        z-index: 1;
    }
    .info-card:hover {
        background-color: #0b192c;
        transform: translateY(-8px);
        border-radius: 1rem;
        box-shadow: 
            0 8px 0 #020617,
            0 22px 35px -5px rgba(2, 6, 23, 0.5);
        z-index: 20;
    }

    /* ==========================================================================
       3D DEPTH, TACTILE ELEVATION & MULTI-LAYER SHADOW SYSTEM
       ========================================================================== */
    .card-3d-main {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.95);
        box-shadow: 
            0 2px 4px rgba(15, 23, 42, 0.03),
            0 12px 24px -4px rgba(15, 23, 42, 0.08),
            0 28px 60px -12px rgba(15, 23, 42, 0.16),
            0 45px 85px -20px rgba(15, 23, 42, 0.10);
        position: relative;
        transition: transform 0.35s var(--ease-expo), box-shadow 0.35s var(--ease-expo);
    }
    .card-3d-main:hover {
        transform: translateY(-4px);
        box-shadow: 
            0 4px 6px rgba(15, 23, 42, 0.04),
            0 16px 32px -4px rgba(15, 23, 42, 0.10),
            0 36px 70px -12px rgba(15, 23, 42, 0.20),
            0 55px 95px -20px rgba(15, 23, 42, 0.14);
    }

    .info-bar-3d {
        box-shadow: 
            0 8px 0 #1e3a8a,
            0 20px 40px -8px rgba(30, 58, 138, 0.45),
            0 30px 60px -15px rgba(15, 23, 42, 0.3);
        border: 1px solid #1d4ed8;
    }

    .hero-card-3d {
        box-shadow: 
            0 8px 0 #0f172a,
            0 20px 40px -8px rgba(15, 23, 42, 0.4),
            0 35px 70px -15px rgba(15, 23, 42, 0.25);
    }

    .flyer-3d-box {
        box-shadow: 
            inset 0 1px 1px rgba(255, 255, 255, 0.15),
            0 12px 28px -4px rgba(15, 23, 42, 0.25),
            0 25px 45px -10px rgba(15, 23, 42, 0.2);
    }

    /* 3D Tactile Buttons (Efek Tombol Fisik Timbul & Push-down) */
    .btn-3d-dark {
        box-shadow: 0 4px 0 #020617, 0 10px 20px -3px rgba(15, 23, 42, 0.35);
        transition: all 0.15s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-3d-dark:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 #020617, 0 14px 26px -4px rgba(15, 23, 42, 0.4);
    }
    .btn-3d-dark:active {
        transform: translateY(3px);
        box-shadow: 0 1px 0 #020617, 0 4px 10px -2px rgba(15, 23, 42, 0.25);
    }

    .btn-3d-white {
        box-shadow: 0 3px 0 #cbd5e1, 0 8px 16px -3px rgba(15, 23, 42, 0.1);
        transition: all 0.15s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-3d-white:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 0 #cbd5e1, 0 12px 22px -3px rgba(15, 23, 42, 0.14);
    }
    .btn-3d-white:active {
        transform: translateY(2px);
        box-shadow: 0 1px 0 #cbd5e1, 0 3px 6px -1px rgba(15, 23, 42, 0.08);
    }

    .input-3d {
        box-shadow: inset 0 2px 4px rgba(15, 23, 42, 0.04);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .input-3d:focus {
        box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.03), 0 0 0 4px rgba(15, 23, 42, 0.10);
    }

    .maps-iframe-container iframe {
        width: 100% !important;
        height: 100% !important;
        border: 0 !important;
        display: block;
    }

    /* ==========================================================================
       EXCLUSIVE INVITATION ENVELOPE 3D ANIMATION
       ========================================================================== */
    .envelope-wrapper {
        perspective: 1200px;
    }
    .envelope-box {
        position: relative;
        width: 100%;
        max-width: 390px;
        height: 235px;
        background: #0f172a;
        border-radius: 0.85rem;
        box-shadow: 
            0 10px 0 #020617,
            0 25px 50px -12px rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(59, 130, 246, 0.3);
        transform-style: preserve-3d;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
    }
    .envelope-box:hover {
        transform: translateY(-3px);
        box-shadow: 
            0 14px 0 #020617,
            0 32px 60px -12px rgba(15, 23, 42, 0.7);
    }
    .envelope-lining {
        position: absolute;
        inset: 0;
        background: #1e3a8a;
        border-radius: 0.85rem;
        z-index: 1;
    }
    .envelope-card {
        position: absolute;
        bottom: 12px;
        left: 16px;
        right: 16px;
        height: 220px;
        background: #ffffff;
        border-radius: 0.75rem;
        padding: 1.35rem 1.4rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        /* delay 0.45s — tunggu flap hampir selesai melipat dulu */
        transition: transform 0.75s cubic-bezier(0.16, 1, 0.3, 1) 0.45s, opacity 0.3s ease 0.38s, z-index 0s linear 0.44s, box-shadow 0.7s ease 0.45s;
        z-index: 5;
        opacity: 0;
        transform: translateY(15px);
    }
    .envelope-box.is-opened .envelope-card {
        transform: translateY(-165px);
        opacity: 1;
        /* Naik ke atas flap dan pocket agar tidak tertimpa */
        z-index: 30;
        box-shadow: 0 30px 60px -10px rgba(0, 0, 0, 0.45);
    }
    .envelope-pocket {
        position: absolute;
        inset: 0;
        clip-path: polygon(0 40%, 50% 75%, 100% 40%, 100% 100%, 0 100%);
        background: #0b192c;
        border-radius: 0 0 0.75rem 0.75rem;
        z-index: 15;
        border-top: 1px solid rgba(59, 130, 246, 0.25);
    }
    .envelope-flap {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 118px;
        background: linear-gradient(180deg, #1e3a8a 0%, #0f172a 100%);
        clip-path: polygon(0 0, 100% 0, 50% 100%);
        transform-origin: top center;
        /* z-index segera jatuh ke 1 tepat setengah jalan rotasi (0.3s), sehingga tidak menindih kartu */
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1), z-index 0s linear 0.3s;
        z-index: 20;
        /* hidden: bagian belakang flap tidak terlihat sama sekali saat sudah berputar */
        backface-visibility: hidden;
    }
    .envelope-box.is-opened .envelope-flap {
        transform: rotateX(180deg);
        z-index: 1;
    }
    .envelope-seal {
        position: absolute;
        top: 103px;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 25;
        transition: opacity 0.25s ease, transform 0.3s ease;
    }
    .envelope-box.is-opened .envelope-seal {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.3) rotate(20deg);
        pointer-events: none;
    }
    .envelope-box.is-entering {
        transform: scale(1.3) translateY(30px);
        opacity: 0;
        transition: transform 0.65s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.55s ease;
    }
    .invitation-overlay-leave {
        opacity: 0 !important;
        pointer-events: none !important;
        transition: opacity 0.65s ease-out;
    }

    html {
        scroll-behavior: smooth;
    }
</style>
@endpush

@section('content')
@if(!empty($showEnvelope))
    <!-- ==========================================================================
         OVERLAY PEMBUKA UNDANGAN INTERAKTIF ("YOU ARE INVITED" + 3D ENVELOPE)
         ========================================================================== -->
    <div id="invitationOverlay" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-slate-900/95 backdrop-blur-xl transition-all duration-700 ease-out overflow-y-auto">
        <div class="w-full max-w-lg my-auto text-center space-y-6 py-6 anim-hero-text">
            
            <!-- Header You Are Invited -->
            <div class="space-y-2 relative">
                <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                    You Are Invited
                </h1>

                <!-- Self-Drawing SVG Curved Line (Ala Hero Line) -->
                <div class="w-44 sm:w-56 mx-auto pt-1">
                    <svg viewBox="0 0 260 20" fill="none" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12C60 4 140 18 256 6" stroke="#3B82F6" stroke-width="4.5" stroke-linecap="round" class="svg-draw-line" />
                    </svg>
                </div>

                <p class="text-xs sm:text-sm text-slate-300 max-w-md mx-auto font-medium pt-1">
                    {{ $settings['event_title'] }}
                </p>
            </div>

            <!-- Interactive 3D Envelope Object (Ruang Napas Luas) -->
            <div class="envelope-wrapper pt-12 pb-6">
                <div id="envelopeBox" class="envelope-box mx-auto cursor-pointer" onclick="openInvitationEnvelope()">
                    
                    <!-- Inside Lining -->
                    <div class="envelope-lining"></div>

                    <!-- Letter Card Inside -->
                    <div class="envelope-card">
                        <div class="h-full flex flex-col justify-between text-left">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                                <span class="px-2.5 py-0.5 bg-blue-600 text-white font-extrabold text-[10px] tracking-wider uppercase rounded-md shadow-xs">
                                    C LEVEL
                                </span>
                                <span class="text-xs text-slate-500 font-semibold">{{ $settings['event_date'] }}</span>
                            </div>
                            <div class="py-2 space-y-1.5">
                                <h4 class="text-sm sm:text-base font-black text-slate-900 leading-snug line-clamp-2">
                                    {{ $settings['event_title'] }}
                                </h4>
                                <p class="text-xs text-slate-500 flex items-center gap-1.5 truncate">
                                    <svg class="w-3.5 h-3.5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $settings['event_venue_name'] }}</span>
                                </p>
                            </div>
                            <div class="text-xs text-blue-600 font-bold flex items-center justify-between border-t border-slate-100 pt-2">
                                <span>Buka Formulir Pendaftaran</span>
                                <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Envelope Pocket (Front) -->
                    <div class="envelope-pocket"></div>

                    <!-- Flap (Top Folding Triangle) -->
                    <div class="envelope-flap"></div>

                    <!-- Wax Seal Badge / Button -->
                    <div class="envelope-seal">
                        <button type="button" class="rounded-full bg-gradient-to-br from-amber-400 to-amber-600 border-2 border-amber-200 text-amber-950 flex items-center justify-center shadow-lg hover:scale-105 active:scale-95 transition-transform cursor-pointer" style="width: 52px; height: 52px;" title="Buka Undangan">
                            <svg class="w-6 h-6 text-amber-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5"/>
                            </svg>
                        </button>
                    </div>

                </div>
            </div>

            <!-- Petunjuk Minimalis di Bawah Amplop -->
            <p class="text-xs text-slate-400 tracking-wide font-medium flex items-center justify-center gap-1.5 animate-pulse cursor-pointer" onclick="openInvitationEnvelope()">
                <span>Ketuk amplop untuk membuka</span>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </p>

        </div>
    </div>
@endif

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-14 py-4">

    <!-- ==========================================================================
         1. HERO SECTION ATAS (HEADLINE + FLYER ATAS DENGAN 3D PARALLAX TILT)
         ========================================================================== -->
    <section class="scroll-reveal grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center pt-2 sm:pt-4">
        
        <!-- Sisi Kiri Hero: Teks & Action -->
        <div class="lg:col-span-7 space-y-6 anim-hero-text">
            
            <div class="space-y-3 relative">
                <!-- Aksen Doodle Star Sparkle (SVGator Ambient Accent) -->
                <div class="absolute -top-6 -left-6 text-blue-600/70 anim-spin pointer-events-none hidden sm:block">
                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/>
                    </svg>
                </div>

                <!-- Headline Acara -->
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 leading-[1.12] tracking-tight">
                    {{ $settings['event_title'] }}
                </h1>

                <!-- Self-Drawing SVG Curved Line (SVGator Animation Example) -->
                <div class="w-48 sm:w-64 pt-1">
                    <svg viewBox="0 0 260 20" fill="none" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12C60 4 140 18 256 6" stroke="#2563EB" stroke-width="4.5" stroke-linecap="round" class="svg-draw-line" />
                    </svg>
                </div>
                
                <!-- Deskripsi Acara -->
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl font-normal pt-1">
                    {{ $settings['event_description'] }}
                </p>
            </div>

            <!-- Tombol Aksi Cepat 3D (Responsif Mobile Elegan) -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-1">
                <a href="#registration-section" 
                   class="btn-3d-dark px-6 py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm tracking-wide rounded-xl flex items-center justify-center gap-2.5 border border-slate-900 cursor-pointer text-center">
                    <span>Isi Formulir Pendaftaran</span>
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </a>
                
                @if(!empty($settings['event_maps_url']))
                    <a href="{{ $settings['event_maps_url'] }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn-3d-white px-5 py-3.5 bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 font-semibold text-xs sm:text-sm rounded-xl border border-slate-300 flex items-center justify-center gap-2 text-center">
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

        </div>

        <!-- Sisi Kanan Hero: Visual Flyer Acara Atas dengan Interactive 3D Parallax Tilt -->
        <div class="lg:col-span-5 flex justify-center lg:justify-end anim-flyer-card tilt-card-container">
            <div class="w-full max-w-[360px] anim-floating">
                
                <div id="heroFlyerCard" class="tilt-card hero-card-3d border-2 border-slate-900 bg-white rounded-2xl overflow-hidden cursor-pointer">
                    
                    @if(!empty($settings['event_flyer']))
                        <img 
                            src="{{ asset($settings['event_flyer']) }}" 
                            alt="{{ $settings['event_title'] }}" 
                            class="w-full h-auto object-cover rounded-2xl"
                            style="aspect-ratio: 1/1; width: 100%; object-fit: cover;"
                        >
                    @else
                        <!-- Poster Grafis Default C LEVEL yang Proporsional & Super Clean -->
                        <div class="bg-slate-900 text-white p-6 sm:p-7 flex flex-col justify-between border-b-4 border-blue-600 rounded-2xl" style="aspect-ratio: 1/1; min-height: 280px;">
                            
                            <div>
                                <span class="px-2.5 py-1 bg-blue-600 text-white font-black text-xs tracking-widest uppercase rounded-lg shadow-xs">
                                    C LEVEL
                                </span>
                            </div>

                            <div class="my-auto py-5">
                                <h3 class="text-xl sm:text-2xl font-black text-white leading-tight tracking-tight">
                                    {{ $settings['event_title'] }}
                                </h3>
                            </div>

                            <div class="pt-3 border-t border-slate-800 flex items-center justify-between text-[11px] sm:text-xs text-slate-400">
                                <span>{{ $settings['event_date'] }}</span>
                                <span class="truncate max-w-[160px] text-right">{{ $settings['event_venue_name'] }}</span>
                            </div>

                        </div>
                    @endif

                </div>

            </div>
        </div>

    </section>


    <!-- ==========================================================================
         2. BLOK INFORMASI ACARA (LOKASI -> TANGGAL -> WAKTU -> DRESSCODE)
         ========================================================================== -->
    <section class="scroll-reveal space-y-6">
        
        <!-- Bar Card Solid Royal Blue 3D (Full-Bleed Segments) -->
        <div class="pt-2">
            <div class="bg-blue-700 text-white rounded-2xl info-bar-3d relative">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 lg:divide-x divide-blue-600/70 items-stretch">
                    
                    <!-- 1. LOKASI / GEDUNG -->
                    <div class="info-card lg:rounded-l-2xl rounded-t-2xl sm:rounded-tl-2xl p-6 sm:p-7 flex flex-col justify-between cursor-default">
                    <div class="space-y-2">
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
                    </div>
                    @if(!empty($settings['event_maps_url']))
                        <div class="pt-3">
                            <a href="{{ $settings['event_maps_url'] }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-1 text-[11px] font-bold text-white bg-blue-800 hover:bg-blue-900 px-2.5 py-1 rounded-xs transition-colors">
                                <span>Buka Google Maps</span>
                                <svg class="w-3 h-3 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- 2. TANGGAL -->
                <div class="info-card p-6 sm:p-7 flex flex-col justify-between">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-blue-200">
                            <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[11px] font-bold uppercase tracking-wider">Tanggal Pelaksanaan</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-black text-white leading-tight tracking-tight">
                            {{ $settings['event_date'] }}
                        </h3>
                    </div>
                    <p class="text-xs text-blue-100 font-medium pt-3">
                        Agenda Resmi C LEVEL 2026
                    </p>
                </div>

                <!-- 3. WAKTU -->
                <div class="info-card p-6 sm:p-7 flex flex-col justify-between">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-blue-200">
                            <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-[11px] font-bold uppercase tracking-wider">Waktu / Jam</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-black text-white leading-tight tracking-tight">
                            {{ $settings['event_time'] }}
                        </h3>
                    </div>
                    <p class="text-xs text-blue-100 font-medium pt-3">
                        Registrasi & Sesi Konferensi
                    </p>
                </div>

                <!-- 4. DRESSCODE -->
                <div class="info-card lg:rounded-r-2xl rounded-b-2xl sm:rounded-br-2xl p-6 sm:p-7 flex flex-col justify-between cursor-default">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-blue-200">
                            <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-[11px] font-bold uppercase tracking-wider">Ketentuan Busana</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black text-white leading-snug tracking-tight">
                            {{ $settings['event_dresscode'] }}
                        </h3>
                    </div>
                    <p class="text-xs text-blue-100 font-medium pt-3">
                        Standar Kehadiran Eksekutif
                    </p>
                </div>

            </div>
        </div>
    </div>

        <!-- Wadah Iframe Google Maps 3D Terpadu -->
        <div class="rounded-2xl overflow-hidden card-3d-main border border-slate-200/90 relative">
            <div class="h-[280px] sm:h-[360px] w-full maps-iframe-container bg-slate-100">
                @if(!empty($settings['event_maps_iframe']))
                    {!! $settings['event_maps_iframe'] !!}
                @else
                    <iframe 
                        src="https://maps.google.com/maps?q={{ urlencode(($settings['event_venue_name'] ?? '') . ' ' . ($settings['event_venue_address'] ?? 'Menara Kadin Indonesia')) }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                        class="w-full h-full border-0"
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                @endif
            </div>
        </div>

    </section>


    <!-- ==========================================================================
         3. SECTION REGISTRASI (LAYOUT BESAR 2 KOLOM: FLYER KIRI & FORM KANAN)
         ========================================================================== -->
    <section id="registration-section" class="scroll-reveal pt-4">
        
        <!-- Header Registrasi Bersih -->
        <div class="text-center max-w-xl mx-auto space-y-2 mb-8">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Formulir Pendaftaran & E-Ticket
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-normal">
                Silakan lengkapi formulir di bawah ini. E-Ticket QR Code presensi resmi akan langsung dikirimkan ke kontak WhatsApp Anda.
            </p>
        </div>

        <!-- Wadah Card Terpadu (Smooth & 3D Multi-Layer Shadow) -->
        <div class="max-w-5xl mx-auto rounded-2xl sm:rounded-3xl p-5 sm:p-8 lg:p-10 card-3d-main">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch">
                
                <!-- SISI KIRI: FLYER ACARA / POSTER (SMOOTH ROUNDED 3D) -->
                <div class="lg:col-span-5 flex flex-col">
                    <div class="w-full h-full min-h-[250px] sm:min-h-[350px] lg:min-h-[480px] rounded-2xl overflow-hidden border border-slate-200 flyer-3d-box relative flex flex-col">
                        @if(!empty($settings['event_flyer']))
                            <img 
                                src="{{ asset($settings['event_flyer']) }}" 
                                alt="{{ $settings['event_title'] }}" 
                                class="w-full h-full object-cover rounded-2xl"
                                style="width: 100%; height: 100%; object-fit: cover;"
                            >
                        @else
                            <!-- Poster Grafis Digital C LEVEL yang Estetik & Super Clean (Ala Gambar 2) -->
                            <div class="bg-slate-900 text-white p-6 sm:p-8 flex flex-col justify-between h-full relative overflow-hidden rounded-2xl border-b-4 border-blue-600">
                                
                                <div>
                                    <span class="px-2.5 py-1 bg-blue-600 text-white font-black text-xs tracking-widest uppercase rounded-lg shadow-xs">
                                        C LEVEL
                                    </span>
                                </div>

                                <div class="my-auto py-6">
                                    <h3 class="text-2xl sm:text-3xl font-black text-white leading-tight tracking-tight">
                                        {{ $settings['event_title'] }}
                                    </h3>
                                </div>

                                <div class="pt-4 border-t border-slate-800 flex items-center justify-between text-xs text-slate-400">
                                    <span>{{ $settings['event_date'] }}</span>
                                    <span class="truncate max-w-[200px] text-right">{{ $settings['event_venue_name'] }}</span>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>

                <!-- SISI KANAN: FORMULIR PENDAFTARAN (SMOOTH & CLEAN ALA GAMBAR KE-2) -->
                <div class="lg:col-span-7 flex flex-col justify-center space-y-5">
                    
                    <!-- Header Form -->
                    <div class="space-y-1.5 border-b border-slate-100 pb-4">
                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                            Data Calon Peserta
                        </h2>
                        <p class="text-xs text-slate-500 font-normal">
                            Isi seluruh informasi dengan akurat untuk penerbitan tiket QR via WhatsApp.
                        </p>
                    </div>

                    <!-- Alert Jika Pendaftaran Ditutup -->
                    @if($isExpired)
                        <div class="p-4 bg-rose-50 border border-rose-300 rounded-xl text-xs text-rose-900 flex items-start gap-3 shadow-2xs">
                            <div class="w-8 h-8 rounded-lg bg-rose-200/80 text-rose-800 flex items-center justify-center shrink-0">
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
                        <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs shadow-2xs">
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
                                placeholder="Nama Lengkap"
                                class="input-3d w-full px-4 py-2.5 {{ $isExpired ? 'bg-slate-100 text-slate-400 cursor-not-allowed border-slate-200 opacity-70' : 'bg-slate-50/90 border-slate-200 text-slate-900 focus:bg-white focus:border-slate-900' }} border {{ $errors->has('name') ? 'border-rose-400 bg-rose-50/40' : '' }} rounded-xl text-xs sm:text-sm placeholder-slate-400 focus:outline-none"
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
                                placeholder="08xxxxxxxxxx"
                                class="input-3d w-full px-4 py-2.5 {{ $isExpired ? 'bg-slate-100 text-slate-400 cursor-not-allowed border-slate-200 opacity-70' : 'bg-slate-50/90 border-slate-200 text-slate-900 focus:bg-white focus:border-slate-900' }} border {{ $errors->has('phone') ? 'border-rose-400 bg-rose-50/40' : '' }} rounded-xl text-xs sm:text-sm placeholder-slate-400 focus:outline-none"
                            >
                        </div>

                        <!-- 3. Perusahaan & 4. Jabatan (Grid 2 Kolom) -->
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
                                    placeholder="Nama Perusahaan / Instansi"
                                    class="input-3d w-full px-4 py-2.5 {{ $isExpired ? 'bg-slate-100 text-slate-400 cursor-not-allowed border-slate-200 opacity-70' : 'bg-slate-50/90 border-slate-200 text-slate-900 focus:bg-white focus:border-slate-900' }} border {{ $errors->has('company') ? 'border-rose-400 bg-rose-50/40' : '' }} rounded-xl text-xs sm:text-sm placeholder-slate-400 focus:outline-none"
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
                                    placeholder="Jabatan / Posisi"
                                    class="input-3d w-full px-4 py-2.5 {{ $isExpired ? 'bg-slate-100 text-slate-400 cursor-not-allowed border-slate-200 opacity-70' : 'bg-slate-50/90 border-slate-200 text-slate-900 focus:bg-white focus:border-slate-900' }} border {{ $errors->has('position') ? 'border-rose-400 bg-rose-50/40' : '' }} rounded-xl text-xs sm:text-sm placeholder-slate-400 focus:outline-none"
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
                                placeholder="email@perusahaan.com"
                                class="input-3d w-full px-4 py-2.5 {{ $isExpired ? 'bg-slate-100 text-slate-400 cursor-not-allowed border-slate-200 opacity-70' : 'bg-slate-50/90 border-slate-200 text-slate-900 focus:bg-white focus:border-slate-900' }} border {{ $errors->has('email') ? 'border-rose-400 bg-rose-50/40' : '' }} rounded-xl text-xs sm:text-sm placeholder-slate-400 focus:outline-none"
                            >
                        </div>

                        <!-- Tombol Submit Request to Join / Pendaftaran Ditutup -->
                        <div class="pt-2">
                            @if($isExpired)
                                <button 
                                    type="button" 
                                    disabled
                                    class="w-full py-3.5 px-5 bg-slate-200 text-slate-500 font-semibold text-xs sm:text-sm rounded-xl cursor-not-allowed flex items-center justify-center gap-2 border border-slate-300 shadow-none"
                                >
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <span>Pendaftaran Telah Ditutup</span>
                                </button>
                            @else
                                <button 
                                    type="submit" 
                                    class="btn-3d-dark w-full py-3.5 px-6 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm tracking-wide rounded-xl cursor-pointer flex items-center justify-center gap-2 border border-slate-900"
                                >
                                    <span>Request to Join</span>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Intersection Observer Dua Arah (Entrance Masuk & Exit Keluar saat Scroll di Mobile & Desktop)
        const reveals = document.querySelectorAll('.scroll-reveal');
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    } else {
                        entry.target.classList.remove('is-visible');
                    }
                });
            }, {
                threshold: 0.08,
                rootMargin: '0px 0px -30px 0px'
            });

            reveals.forEach(el => observer.observe(el));
        } else {
            reveals.forEach(el => el.classList.add('is-visible'));
        }

        // 2. Interactive 3D Parallax Tilt Effect untuk Flyer Hero (SVGator Style)
        const tiltCard = document.getElementById('heroFlyerCard');
        if (tiltCard) {
            tiltCard.addEventListener('mousemove', function(e) {
                const rect = tiltCard.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const rotateX = ((y - centerY) / centerY) * -10;
                const rotateY = ((x - centerX) / centerX) * 10;
                
                tiltCard.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
                tiltCard.style.boxShadow = `0 20px 30px -10px rgba(15, 23, 42, 0.25)`;
            });

            tiltCard.addEventListener('mouseleave', function() {
                tiltCard.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)`;
                tiltCard.style.boxShadow = ``;
            });
        }

        // 3. Interactive Envelope Opening Animation (Koreografi Realistis & Sinematik)
        window.openInvitationEnvelope = function(instant = false) {
            const overlay = document.getElementById('invitationOverlay');
            const box = document.getElementById('envelopeBox');
            if (!overlay) return;

            if (instant) {
                overlay.classList.add('invitation-overlay-leave');
                setTimeout(() => {
                    overlay.remove();
                }, 400);
                return;
            }

            if (box) {
                // Jika sudah terbuka dan diklik lagi, langsung transisi cepat
                if (box.classList.contains('is-opened')) {
                    box.classList.add('is-entering');
                    overlay.classList.add('invitation-overlay-leave');
                    setTimeout(() => {
                        overlay.remove();
                    }, 500);
                    return;
                }

                // Tahap 1 & 2: Segel lepas & Flap melipat ke atas 180° secara 3D
                // Tahap 3: Kartu surat undangan meluncur naik secara halus (CSS delay 0.35s)
                box.classList.add('is-opened');

                // Tahap 4: Zoom halus masuk ke formulir pendaftaran setelah kartu terungkap jelas (1450ms)
                setTimeout(() => {
                    box.classList.add('is-entering');
                    overlay.classList.add('invitation-overlay-leave');
                    setTimeout(() => {
                        overlay.remove();
                    }, 650);
                }, 1450);
            }
        };
    });
</script>
@endpush
