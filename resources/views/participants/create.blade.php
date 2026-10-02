@extends('layouts.guest')

@section('title', $settings['event_title'] . ' - C LEVEL Indonesia')

@push('styles')
<style>
    /* ==========================================================================
       MONOCHROMATIC DEEP GLASS & LIQUID AURORA SYSTEM
       Filosofi: Pure grey/silver/monochrome palette, true optical glass
       ========================================================================== */
    :root {
        --ease-expo: cubic-bezier(0.16, 1, 0.3, 1);
        --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* 1. Kinetic Hero Entrance */
    @keyframes kineticReveal {
        0% {
            opacity: 0;
            transform: translateY(24px) scale(0.98);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* 2. SVG Self-Drawing Line Animation */
    @keyframes drawPath {
        0% { stroke-dashoffset: 400; }
        100% { stroke-dashoffset: 0; }
    }

    /* 3. Subtle Ambient Float Animation */
    @keyframes ambientFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
    }

    /* 4. Monochromatic Aurora Glow Shimmer */
    @keyframes silverAuroraPulse {
        0%, 100% { opacity: 0.5; transform: scale(1); }
        50% { opacity: 0.85; transform: scale(1.04); }
    }

    .anim-hero-text {
        animation: kineticReveal 0.85s var(--ease-expo) 0.1s backwards;
    }
    .anim-flyer-card {
        animation: kineticReveal 0.95s var(--ease-expo) 0.2s backwards;
    }
    .anim-floating {
        animation: ambientFloat 6s ease-in-out infinite;
    }
    .anim-aurora-glow {
        animation: silverAuroraPulse 8s ease-in-out infinite;
    }

    .svg-draw-line {
        stroke-dasharray: 400;
        stroke-dashoffset: 400;
        animation: drawPath 1.6s var(--ease-expo) 0.3s forwards;
    }

    /* ==========================================================================
       TRUE OPTICAL FROSTED GLASS (BENER-BENER GLASS)
       - High blur + saturation for optical depth
       - Specular top rim light highlight
       - Diffuse multi-tier ambient shadows
       - Translucent surface allowing cosmic stardust/aurora through
       ========================================================================== */
    .card-glass {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%), rgba(12, 14, 20, 0.65);
        backdrop-filter: blur(36px) saturate(170%);
        -webkit-backdrop-filter: blur(36px) saturate(170%);
        border: 1px solid rgba(255, 255, 255, 0.10);
        box-shadow: 
            inset 0 1px 0 0 rgba(255, 255, 255, 0.20),
            inset 0 -1px 0 0 rgba(255, 255, 255, 0.03),
            0 4px 6px -1px rgba(0, 0, 0, 0.4),
            0 24px 50px -15px rgba(0, 0, 0, 0.85);
        position: relative;
        transition: transform 0.35s var(--ease-expo), box-shadow 0.35s var(--ease-expo), border-color 0.3s ease;
    }
    .card-glass:hover {
        border-color: rgba(255, 255, 255, 0.18);
        box-shadow: 
            inset 0 1px 0 0 rgba(255, 255, 255, 0.32),
            inset 0 -1px 0 0 rgba(255, 255, 255, 0.05),
            0 6px 12px -2px rgba(0, 0, 0, 0.5),
            0 30px 60px -15px rgba(0, 0, 0, 0.95);
    }

    .card-glass-subtle {
        background: rgba(255, 255, 255, 0.035);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 
            inset 0 1px 0 rgba(255, 255, 255, 0.12),
            0 4px 12px rgba(0, 0, 0, 0.3);
    }

    /* Ambient Silver / Grey Glow Behind Hero Flyer */
    .flyer-glow-ambient {
        position: absolute;
        inset: -24px;
        background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.10) 0%, rgba(200, 205, 220, 0.04) 50%, transparent 72%);
        filter: blur(40px);
        z-index: 0;
        pointer-events: none;
    }

    /* 3D Tilt Card */
    .tilt-card-container {
        perspective: 1200px;
    }
    .tilt-card {
        transition: transform 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.3s ease;
        transform-style: preserve-3d;
        will-change: transform;
    }

    /* Reversible Scroll Reveal & Exit Animation */
    .scroll-reveal {
        opacity: 0;
        transform: translateY(24px) scale(0.985);
        transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: opacity, transform;
    }
    .scroll-reveal.is-visible {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    /* Info Bar Segment Hover */
    .info-card-dark {
        position: relative;
        transition: background-color 0.25s ease, transform 0.25s ease;
    }
    .info-card-dark:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    /* ==========================================================================
       TACTILE MONOCHROMATIC BUTTONS & INPUTS
       ========================================================================== */
    /* 1. Solid Crisp White Button (Pure contrast on deep grey) */
    .btn-glow-white {
        background: #ffffff;
        color: #05070a;
        box-shadow: 
            0 4px 20px -2px rgba(255, 255, 255, 0.30),
            0 2px 6px rgba(0, 0, 0, 0.5);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-glow-white:hover {
        transform: translateY(-2px);
        background: #f8fafc;
        box-shadow: 
            0 8px 30px rgba(255, 255, 255, 0.45),
            0 4px 12px rgba(0, 0, 0, 0.6);
    }
    .btn-glow-white:active {
        transform: translateY(1px);
        box-shadow: 0 2px 10px rgba(255, 255, 255, 0.2);
    }

    /* 2. Glass Subtle Button */
    .btn-glass {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #e2e8f0;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.10);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-glass:hover {
        background: rgba(255, 255, 255, 0.10);
        border-color: rgba(255, 255, 255, 0.25);
        transform: translateY(-1px);
        color: #ffffff;
    }
    .btn-glass:active {
        transform: translateY(1px);
    }

    /* 3. Dark Frosted Glass Input */
    .input-glass {
        background: rgba(10, 12, 17, 0.65);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #f8fafc;
        box-shadow: 
            inset 0 2px 4px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.04);
        transition: all 0.2s ease;
    }
    .input-glass:focus {
        background: rgba(14, 17, 24, 0.85);
        border-color: rgba(255, 255, 255, 0.40);
        box-shadow: 
            inset 0 1px 2px rgba(0, 0, 0, 0.3),
            0 0 0 3px rgba(255, 255, 255, 0.08),
            0 0 20px rgba(255, 255, 255, 0.06);
        outline: none;
    }
    .input-glass::placeholder {
        color: #64748b;
    }

    .maps-iframe-container iframe {
        width: 100% !important;
        height: 100% !important;
        border: 0 !important;
        display: block;
        filter: invert(90%) hue-rotate(180deg) brightness(95%) contrast(90%);
    }

    /* ==========================================================================
       EXCLUSIVE INVITATION ENVELOPE 3D ANIMATION (MONOCHROME EXECUTIVE)
       ========================================================================== */
    .envelope-wrapper {
        perspective: 1200px;
    }
    .envelope-box {
        position: relative;
        width: 100%;
        max-width: 390px;
        height: 235px;
        background: #0d0f16;
        border-radius: 0.85rem;
        box-shadow: 
            inset 0 1px 0 rgba(255, 255, 255, 0.18),
            0 10px 0 #020306,
            0 25px 50px -12px rgba(0, 0, 0, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.14);
        transform-style: preserve-3d;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
    }
    .envelope-box:hover {
        transform: translateY(-3px);
        box-shadow: 
            inset 0 1px 0 rgba(255, 255, 255, 0.25),
            0 14px 0 #020306,
            0 32px 60px -12px rgba(0, 0, 0, 0.95);
    }
    .envelope-lining {
        position: absolute;
        inset: 0;
        background: #171a23;
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
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        transition: transform 0.75s cubic-bezier(0.16, 1, 0.3, 1) 0.45s, opacity 0.3s ease 0.38s, z-index 0s linear 0.44s, box-shadow 0.7s ease 0.45s;
        z-index: 5;
        opacity: 0;
        transform: translateY(15px);
    }
    .envelope-box.is-opened .envelope-card {
        transform: translateY(-165px);
        opacity: 1;
        z-index: 30;
        box-shadow: 0 30px 60px -10px rgba(0, 0, 0, 0.65);
    }
    .envelope-pocket {
        position: absolute;
        inset: 0;
        clip-path: polygon(0 40%, 50% 75%, 100% 40%, 100% 100%, 0 100%);
        background: #080a10;
        border-radius: 0 0 0.75rem 0.75rem;
        z-index: 15;
        border-top: 1px solid rgba(255, 255, 255, 0.12);
    }
    .envelope-flap {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 118px;
        background: linear-gradient(180deg, #1c202d 0%, #0d0f16 100%);
        clip-path: polygon(0 0, 100% 0, 50% 100%);
        transform-origin: top center;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1), z-index 0s linear 0.3s;
        z-index: 20;
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
         Monochromatic dark glass overlay
         ========================================================================== -->
    <div id="invitationOverlay" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-black/90 backdrop-blur-3xl transition-all duration-700 ease-out overflow-y-auto">
        <div class="w-full max-w-lg my-auto text-center space-y-6 py-6 anim-hero-text">
            
            <!-- Header You Are Invited -->
            <div class="space-y-2 relative">
                <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                    You Are Invited
                </h1>

                <!-- Self-Drawing SVG Curved Line (Silver / White Stroke) -->
                <div class="w-44 sm:w-56 mx-auto pt-1">
                    <svg viewBox="0 0 260 20" fill="none" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12C60 4 140 18 256 6" stroke="rgba(255, 255, 255, 0.45)" stroke-width="4" stroke-linecap="round" class="svg-draw-line" />
                    </svg>
                </div>

                <p class="text-xs sm:text-sm text-neutral-300 max-w-md mx-auto font-medium pt-1">
                    {{ $settings['event_title'] }}
                </p>
            </div>

            <!-- Interactive 3D Envelope Object -->
            <div class="envelope-wrapper pt-12 pb-6">
                <div id="envelopeBox" class="envelope-box mx-auto cursor-pointer" onclick="openInvitationEnvelope()">
                    
                    <!-- Inside Lining -->
                    <div class="envelope-lining"></div>

                    <!-- Letter Card Inside -->
                    <div class="envelope-card">
                        <div class="h-full flex flex-col justify-between text-left">
                            <div class="flex items-center justify-between border-b border-neutral-200 pb-2.5">
                                <span class="px-2.5 py-0.5 bg-neutral-900 text-white font-extrabold text-[10px] tracking-wider uppercase rounded-md shadow-xs">
                                    C LEVEL
                                </span>
                                <span class="text-xs text-neutral-500 font-semibold">{{ $settings['event_date'] }}</span>
                            </div>
                            <div class="py-2 space-y-1.5">
                                <h4 class="text-sm sm:text-base font-black text-neutral-900 leading-snug line-clamp-2">
                                    {{ $settings['event_title'] }}
                                </h4>
                                <p class="text-xs text-neutral-600 flex items-center gap-1.5 truncate">
                                    <svg class="w-3.5 h-3.5 text-neutral-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $settings['event_venue_name'] }}</span>
                                </p>
                            </div>
                            <div class="text-xs text-neutral-900 font-bold flex items-center justify-between border-t border-neutral-200 pt-2">
                                <span>Buka Formulir Pendaftaran</span>
                                <svg class="w-3.5 h-3.5 text-neutral-900 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Envelope Pocket (Front) -->
                    <div class="envelope-pocket"></div>

                    <!-- Flap (Top Folding Triangle) -->
                    <div class="envelope-flap"></div>

                    <!-- Monochromatic Silver Seal Badge / Button -->
                    <div class="envelope-seal">
                        <button type="button" class="rounded-full bg-gradient-to-br from-neutral-100 via-neutral-300 to-neutral-500 border-2 border-white text-neutral-950 flex items-center justify-center shadow-xl hover:scale-105 active:scale-95 transition-transform cursor-pointer" style="width: 52px; height: 52px;" title="Buka Undangan">
                            <svg class="w-6 h-6 text-neutral-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5"/>
                            </svg>
                        </button>
                    </div>

                </div>
            </div>

            <!-- Petunjuk Minimalis di Bawah Amplop -->
            <p class="text-xs text-neutral-400 tracking-wide font-medium flex items-center justify-center gap-1.5 animate-pulse cursor-pointer" onclick="openInvitationEnvelope()">
                <span>Ketuk amplop untuk membuka</span>
                <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </p>

        </div>
    </div>
@endif

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 sm:space-y-16 py-4">

    <!-- ==========================================================================
         1. HERO SECTION ATAS (HEADLINE + FLYER ATAS DENGAN 3D PARALLAX TILT)
         ========================================================================== -->
    <section class="scroll-reveal grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center pt-2 sm:pt-6">
        
        <!-- Sisi Kiri Hero: Teks & Action Ala Luma Event Landing -->
        <div class="lg:col-span-7 space-y-6 anim-hero-text">
            
            <div class="space-y-3 relative">
                <!-- Headline Acara -->
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-[1.15] tracking-tight">
                    {{ $settings['event_title'] }}
                </h1>

                <!-- Self-Drawing SVG Curved Line (Silver/White Stroke) -->
                <div class="w-48 sm:w-64 pt-1">
                    <svg viewBox="0 0 260 20" fill="none" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12C60 4 140 18 256 6" stroke="rgba(255, 255, 255, 0.35)" stroke-width="4" stroke-linecap="round" class="svg-draw-line" />
                    </svg>
                </div>
                
                <!-- Quick Date & Venue Indicator Card (Monochromatic Glass) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    <!-- Date Quick Badge -->
                    <div class="flex items-center gap-3 p-3 rounded-xl card-glass-subtle">
                        <div class="w-10 h-10 rounded-lg bg-white/10 border border-white/15 text-white flex flex-col items-center justify-center font-bold shrink-0">
                            <span class="text-[9px] uppercase tracking-wider text-neutral-400 leading-none">TGL</span>
                            <span class="text-sm font-black leading-none mt-0.5">{{ explode(' ', $settings['event_date'])[0] ?? '2026' }}</span>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-white truncate">{{ $settings['event_date'] }}</div>
                            <div class="text-[11px] text-neutral-400 truncate">{{ $settings['event_time'] }}</div>
                        </div>
                    </div>

                    <!-- Venue Quick Badge -->
                    <div class="flex items-center gap-3 p-3 rounded-xl card-glass-subtle">
                        <div class="w-10 h-10 rounded-lg bg-white/10 border border-white/15 text-neutral-300 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-white truncate">{{ $settings['event_venue_name'] }}</div>
                            <div class="text-[11px] text-neutral-400 truncate">{{ $settings['event_venue_address'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Acara -->
                <p class="text-sm sm:text-base text-neutral-300 leading-relaxed max-w-2xl font-normal pt-2">
                    {{ $settings['event_description'] }}
                </p>
            </div>

            <!-- Tombol Aksi Cepat (White Glow Button + Glass Outline) -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-1">
                <a href="#registration-section" 
                   class="btn-glow-white px-7 py-3.5 font-bold text-xs sm:text-sm tracking-wide rounded-xl flex items-center justify-center gap-2.5 cursor-pointer text-center">
                    <span>Minta untuk Bergabung</span>
                    <svg class="w-4 h-4 text-neutral-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </a>
                
                @if(!empty($settings['event_maps_url']))
                    <a href="{{ $settings['event_maps_url'] }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn-glass px-5 py-3.5 font-semibold text-xs sm:text-sm rounded-xl flex items-center justify-center gap-2 text-center">
                        <svg class="w-4 h-4 text-neutral-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Buka Rute Lokasi</span>
                        <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                @endif
            </div>

            <!-- Host Info ala Luma (Dinamis dari Admin Settings: event_organizer) -->
            @if(!empty($settings['event_organizer']))
                <div class="pt-2 border-t border-white/10 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white font-bold text-xs shadow-md">
                        {{ strtoupper(substr($settings['event_organizer'], 0, 2)) }}
                    </div>
                    <div>
                        <span class="text-[10px] uppercase font-bold tracking-wider text-neutral-400 block">Diselenggarakan Oleh</span>
                        <span class="text-xs font-bold text-neutral-200">{{ $settings['event_organizer'] }}</span>
                    </div>
                </div>
            @endif

        </div>

        <!-- Sisi Kanan Hero: Visual Flyer Acara Atas dengan 3D Parallax Tilt & Monochromatic Glow Halo -->
        <div class="lg:col-span-5 flex justify-center lg:justify-end anim-flyer-card tilt-card-container relative">
            
            <!-- Ambient Silver/Grey Radial Halo behind Flyer -->
            <div class="flyer-glow-ambient anim-aurora-glow"></div>

            <div class="w-full max-w-[370px] anim-floating relative z-10">
                
                <div id="heroFlyerCard" class="tilt-card card-glass rounded-2xl overflow-hidden cursor-pointer p-2.5">
                    
                    @if(!empty($settings['event_flyer']))
                        @php
                            $flyerFit = $settings['event_flyer_fit'] ?? 'contain';
                        @endphp
                        <div class="w-full flex items-center justify-center rounded-xl overflow-hidden {{ $flyerFit === 'contain' ? 'bg-black/60 p-2' : '' }}">
                            <img 
                                src="{{ asset($settings['event_flyer']) }}" 
                                alt="{{ $settings['event_title'] }}" 
                                class="w-full {{ $flyerFit === 'cover' ? 'h-auto aspect-square object-cover' : 'h-auto max-h-[460px] object-contain' }} rounded-lg block shadow-lg"
                            >
                        </div>
                    @else
                        <!-- Poster Grafis Default C LEVEL Monochromatic Glass -->
                        <div class="bg-gradient-to-b from-neutral-900 to-black text-white p-6 sm:p-7 flex flex-col justify-between rounded-xl border border-white/10" style="aspect-ratio: 1/1; min-height: 290px;">
                            
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-1 bg-white/10 text-neutral-200 border border-white/15 font-black text-xs tracking-widest uppercase rounded-lg">
                                    C LEVEL
                                </span>
                                <span class="w-2.5 h-2.5 rounded-full bg-white animate-ping"></span>
                            </div>

                            <div class="my-auto py-5">
                                <h3 class="text-xl sm:text-2xl font-black text-white leading-tight tracking-tight">
                                    {{ $settings['event_title'] }}
                                </h3>
                                <p class="text-xs text-neutral-400 mt-2 line-clamp-2">
                                    {{ $settings['event_description'] }}
                                </p>
                            </div>

                            <div class="pt-3 border-t border-white/10 flex items-center justify-between text-[11px] sm:text-xs text-neutral-400">
                                <span class="text-neutral-300 font-semibold">{{ $settings['event_date'] }}</span>
                                <span class="truncate max-w-[160px] text-right text-neutral-300">{{ $settings['event_venue_name'] }}</span>
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
        
        <!-- Glassmorphism Segmented Bar (Luma True Liquid Glass) -->
        <div class="card-glass rounded-2xl overflow-hidden">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 lg:divide-x divide-white/10 items-stretch">
                
                <!-- 1. LOKASI / GEDUNG -->
                <div class="info-card-dark p-6 sm:p-7 flex flex-col justify-between cursor-default">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-neutral-300">
                            <svg class="w-4 h-4 shrink-0 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400">Lokasi / Venue</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black text-white leading-snug tracking-tight">
                            {{ $settings['event_venue_name'] }}
                        </h3>
                        <p class="text-xs text-neutral-300 leading-relaxed font-normal">
                            {{ $settings['event_venue_address'] }}
                        </p>
                    </div>
                    @if(!empty($settings['event_maps_url']))
                        <div class="pt-4">
                            <a href="{{ $settings['event_maps_url'] }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-1.5 text-[11px] font-bold text-neutral-200 bg-white/10 hover:bg-white/15 border border-white/15 px-3 py-1.5 rounded-lg transition-all">
                                <span>Buka Google Maps</span>
                                <svg class="w-3 h-3 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- 2. TANGGAL -->
                <div class="info-card-dark p-6 sm:p-7 flex flex-col justify-center">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-neutral-300">
                            <svg class="w-4 h-4 shrink-0 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400">Tanggal Pelaksanaan</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-black text-white leading-tight tracking-tight">
                            {{ $settings['event_date'] }}
                        </h3>
                    </div>
                </div>

                <!-- 3. WAKTU -->
                <div class="info-card-dark p-6 sm:p-7 flex flex-col justify-center">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-neutral-300">
                            <svg class="w-4 h-4 shrink-0 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400">Waktu / Jam</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-black text-white leading-tight tracking-tight">
                            {{ $settings['event_time'] }}
                        </h3>
                    </div>
                </div>

                <!-- 4. DRESSCODE -->
                <div class="info-card-dark p-6 sm:p-7 flex flex-col justify-center cursor-default">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-neutral-300">
                            <svg class="w-4 h-4 shrink-0 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400">Ketentuan Busana</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black text-white leading-snug tracking-tight">
                            {{ $settings['event_dresscode'] }}
                        </h3>
                    </div>
                </div>

            </div>
        </div>

        <!-- Wadah Iframe Google Maps Dark Glass -->
        <div class="rounded-2xl overflow-hidden card-glass p-2 relative">
            <div class="h-[280px] sm:h-[350px] w-full maps-iframe-container rounded-xl overflow-hidden bg-black">
                @if(!empty($settings['event_maps_iframe']))
                    {!! $settings['event_maps_iframe'] !!}
                @else
                    <iframe 
                        src="https://maps.google.com/maps?q={{ urlencode(($settings['event_venue_name'] ?? '') . ' ' . ($settings['event_venue_address'] ?? 'Grand Ballroom C LEVEL Indonesia, Jakarta')) }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
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
         3. SECTION REGISTRASI (LAYOUT 2 KOLOM: FLYER KIRI & FORM KANAN)
         ========================================================================== -->
    <section id="registration-section" class="scroll-reveal pt-4">
        
        <!-- Header Registrasi Bersih -->
        <div class="text-center max-w-xl mx-auto space-y-2 mb-8">
            <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                Formulir Pendaftaran & E-Ticket
            </h2>
            <p class="text-xs sm:text-sm text-neutral-400 leading-relaxed font-normal">
                Silakan lengkapi formulir di bawah ini. E-Ticket QR Code presensi resmi akan langsung dikirimkan ke kontak WhatsApp Anda.
            </p>
        </div>

        <!-- Wadah Card Terpadu (Dark Glassmorphic Box ala Luma Pendaftaran) -->
        <div class="max-w-5xl mx-auto rounded-2xl sm:rounded-3xl p-5 sm:p-8 lg:p-10 card-glass">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch">
                
                <!-- SISI KIRI: FLYER ACARA / POSTER (DARK GLASS FRAME) -->
                <div class="lg:col-span-5 flex flex-col">
                    @php
                        $flyerFit = $settings['event_flyer_fit'] ?? 'contain';
                    @endphp
                    <div class="w-full h-full min-h-[250px] sm:min-h-[350px] lg:min-h-[480px] rounded-2xl overflow-hidden border border-white/10 relative flex items-center justify-center bg-black/60 p-3">
                        @if(!empty($settings['event_flyer']))
                            <img 
                                src="{{ asset($settings['event_flyer']) }}" 
                                alt="{{ $settings['event_title'] }}" 
                                class="w-full {{ $flyerFit === 'cover' ? 'h-full object-cover' : 'h-auto max-h-[640px] object-contain' }} rounded-xl block shadow-xl"
                            >
                        @else
                            <!-- Poster Grafis Digital C LEVEL yang Estetik & Super Clean -->
                            <div class="bg-gradient-to-b from-neutral-900 to-black text-white p-6 sm:p-8 flex flex-col justify-between h-full w-full relative overflow-hidden rounded-xl border border-white/10">
                                
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-1 bg-white/10 text-neutral-200 border border-white/15 font-black text-xs tracking-widest uppercase rounded-lg">
                                        C LEVEL
                                    </span>
                                    <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                                </div>

                                <div class="my-auto py-6">
                                    <h3 class="text-2xl sm:text-3xl font-black text-white leading-tight tracking-tight">
                                        {{ $settings['event_title'] }}
                                    </h3>
                                    <p class="text-xs text-neutral-400 mt-2">
                                        {{ $settings['event_description'] }}
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-white/10 flex items-center justify-between text-xs text-neutral-300">
                                    <span>{{ $settings['event_date'] }}</span>
                                    <span class="truncate max-w-[180px] text-right text-neutral-300">{{ $settings['event_venue_name'] }}</span>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>

                <!-- SISI KANAN: FORMULIR PENDAFTARAN (DARK GLASS LIQUID) -->
                <div class="lg:col-span-7 flex flex-col justify-center space-y-5">
                    
                    <!-- Header Form -->
                    <div class="space-y-1.5 border-b border-white/10 pb-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                                Data Calon Peserta
                            </h2>
                            <span class="text-[11px] font-semibold text-neutral-200 bg-white/10 border border-white/15 px-2.5 py-0.5 rounded-full">
                                WhatsApp Ticket
                            </span>
                        </div>
                        <p class="text-xs text-neutral-400 font-normal">
                            Isi seluruh informasi dengan akurat untuk penerbitan tiket QR via WhatsApp.
                        </p>
                    </div>

                    <!-- Alert Jika Pendaftaran Ditutup -->
                    @if($isExpired)
                        <div class="p-4 bg-neutral-900/80 border border-white/20 backdrop-blur-md rounded-xl text-xs text-neutral-200 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white/10 text-neutral-200 flex items-center justify-center shrink-0 border border-white/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="space-y-0.5">
                                <h4 class="font-bold text-white uppercase tracking-wider text-[11px]">Pendaftaran Telah Ditutup</h4>
                                <p class="text-neutral-300 leading-relaxed text-[11px]">
                                    Mohon maaf, batas waktu pendaftaran untuk kegiatan ini telah berakhir pada <strong>{{ $settings['registration_deadline_text'] }}</strong>. Formulir tidak menerima pendaftaran baru.
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Alert Error Validasi Input -->
                    @if($errors->any())
                        <div class="p-3.5 bg-neutral-900/80 border border-white/20 backdrop-blur-md text-neutral-200 rounded-xl text-xs">
                            <p class="font-bold mb-1 text-white">Periksa kembali data Anda:</p>
                            <ul class="list-disc list-inside space-y-0.5 ml-1 text-neutral-300">
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
                            <label for="name" class="block text-xs font-semibold text-neutral-300 uppercase tracking-wider mb-1.5">
                                Nama Lengkap <span class="text-neutral-400">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name') }}" 
                                {{ $isExpired ? 'disabled' : 'required' }}
                                placeholder="Nama Lengkap & Gelar (jika ada)"
                                class="input-glass w-full px-4 py-3 {{ $isExpired ? 'cursor-not-allowed opacity-50' : '' }} {{ $errors->has('name') ? '!border-white/60' : '' }} rounded-xl text-xs sm:text-sm"
                            >
                        </div>

                        <!-- 2. No Telpon / WhatsApp -->
                        <div>
                            <label for="phone" class="block text-xs font-semibold text-neutral-300 uppercase tracking-wider mb-1.5">
                                Nomor WhatsApp Aktif <span class="text-neutral-400">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="tel" 
                                    name="phone" 
                                    id="phone" 
                                    value="{{ old('phone') }}" 
                                    {{ $isExpired ? 'disabled' : 'required' }}
                                    placeholder="08xxxxxxxxxx"
                                    class="input-glass w-full px-4 py-3 {{ $isExpired ? 'cursor-not-allowed opacity-50' : '' }} {{ $errors->has('phone') ? '!border-white/60' : '' }} rounded-xl text-xs sm:text-sm"
                                >
                                <div class="absolute right-3.5 top-3.5 text-neutral-400 pointer-events-none">
                                    <svg class="w-4 h-4 text-neutral-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.043.073.043.419-.101.824z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Perusahaan & 4. Jabatan (Grid 2 Kolom) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Company -->
                            <div>
                                <label for="company" class="block text-xs font-semibold text-neutral-300 uppercase tracking-wider mb-1.5">
                                    Instansi / Perusahaan <span class="text-neutral-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="company" 
                                    id="company" 
                                    value="{{ old('company') }}" 
                                    {{ $isExpired ? 'disabled' : 'required' }}
                                    placeholder="Nama Perusahaan / Organisasi"
                                    class="input-glass w-full px-4 py-3 {{ $isExpired ? 'cursor-not-allowed opacity-50' : '' }} {{ $errors->has('company') ? '!border-white/60' : '' }} rounded-xl text-xs sm:text-sm"
                                >
                            </div>

                            <!-- Position -->
                            <div>
                                <label for="position" class="block text-xs font-semibold text-neutral-300 uppercase tracking-wider mb-1.5">
                                    Jabatan / Posisi <span class="text-neutral-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="position" 
                                    id="position" 
                                    value="{{ old('position') }}" 
                                    {{ $isExpired ? 'disabled' : 'required' }}
                                    placeholder="CEO, Direktur, Manager, dll"
                                    class="input-glass w-full px-4 py-3 {{ $isExpired ? 'cursor-not-allowed opacity-50' : '' }} {{ $errors->has('position') ? '!border-white/60' : '' }} rounded-xl text-xs sm:text-sm"
                                >
                            </div>
                        </div>

                        <!-- 5. Email (Opsional) -->
                        <div>
                            <label for="email" class="block text-xs font-semibold text-neutral-300 uppercase tracking-wider mb-1.5">
                                Alamat Email <span class="text-neutral-400 font-normal">(Opsional)</span>
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email') }}" 
                                {{ $isExpired ? 'disabled' : '' }}
                                placeholder="nama@perusahaan.com"
                                class="input-glass w-full px-4 py-3 {{ $isExpired ? 'cursor-not-allowed opacity-50' : '' }} {{ $errors->has('email') ? '!border-white/60' : '' }} rounded-xl text-xs sm:text-sm"
                            >
                        </div>

                        <!-- Tombol Submit Request to Join (Crisp Solid White ala Luma) -->
                        <div class="pt-2">
                            @if($isExpired)
                                <button 
                                    type="button" 
                                    disabled
                                    class="w-full py-4 px-5 bg-white/5 text-neutral-500 font-semibold text-xs sm:text-sm rounded-xl cursor-not-allowed flex items-center justify-center gap-2 border border-white/10"
                                >
                                    <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <span>Pendaftaran Telah Ditutup</span>
                                </button>
                            @else
                                <button 
                                    type="submit" 
                                    class="btn-glow-white w-full py-4 px-6 font-black text-xs sm:text-sm tracking-wide rounded-xl cursor-pointer flex items-center justify-center gap-2 text-neutral-950"
                                >
                                    <span>Request to Join / Daftar Sekarang</span>
                                    <svg class="w-4 h-4 text-neutral-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        // 1. Intersection Observer Dua Arah
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

        // 2. Interactive 3D Parallax Tilt Effect untuk Flyer Hero
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
                tiltCard.style.boxShadow = `0 25px 45px -10px rgba(0, 0, 0, 0.8)`;
            });

            tiltCard.addEventListener('mouseleave', function() {
                tiltCard.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)`;
                tiltCard.style.boxShadow = ``;
            });
        }

        // 3. Interactive Envelope Opening Animation
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
                if (box.classList.contains('is-opened')) {
                    box.classList.add('is-entering');
                    overlay.classList.add('invitation-overlay-leave');
                    setTimeout(() => {
                        overlay.remove();
                    }, 500);
                    return;
                }

                box.classList.add('is-opened');

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
