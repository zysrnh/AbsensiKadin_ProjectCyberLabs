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

    @keyframes drawPath {
        0% { stroke-dashoffset: 400; }
        100% { stroke-dashoffset: 0; }
    }

    @keyframes ambientFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
    }

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

    .flyer-glow-ambient {
        position: absolute;
        inset: -24px;
        background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.10) 0%, rgba(200, 205, 220, 0.04) 50%, transparent 72%);
        filter: blur(40px);
        z-index: 0;
        pointer-events: none;
    }

    .tilt-card-container {
        perspective: 1200px;
    }
    .tilt-card {
        transition: transform 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.3s ease;
        transform-style: preserve-3d;
        will-change: transform;
    }

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

    .info-card-dark {
        position: relative;
        transition: background-color 0.25s ease, transform 0.25s ease;
    }
    .info-card-dark:hover {
        background: rgba(255, 255, 255, 0.05);
    }

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

    .maps-iframe-container iframe {
        width: 100% !important;
        height: 100% !important;
        border: 0 !important;
        display: block;
        filter: invert(90%) hue-rotate(180deg) brightness(95%) contrast(90%);
    }

    /* 3D Envelope */
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
</style>
@endpush

@section('content')
@if(!empty($showEnvelope))
    <!-- ==========================================================================
         OVERLAY PEMBUKA UNDANGAN INTERAKTIF ("YOU ARE INVITED" + 3D ENVELOPE)
         ========================================================================== -->
    <div id="invitationOverlay" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-black/90 backdrop-blur-3xl transition-all duration-700 ease-out overflow-y-auto">
        <div class="w-full max-w-lg my-auto text-center space-y-6 py-6 anim-hero-text">
            
            <div class="space-y-2 relative">
                <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight" data-i18n="you_are_invited">
                    You Are Invited
                </h1>

                <div class="w-44 sm:w-56 mx-auto pt-1">
                    <svg viewBox="0 0 260 20" fill="none" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12C60 4 140 18 256 6" stroke="rgba(255, 255, 255, 0.45)" stroke-width="4" stroke-linecap="round" class="svg-draw-line" />
                    </svg>
                </div>

                <p class="text-xs sm:text-sm text-neutral-300 max-w-md mx-auto font-medium pt-1">
                    {{ $settings['event_title'] }}
                </p>
            </div>

            <div class="envelope-wrapper pt-12 pb-6">
                <div id="envelopeBox" class="envelope-box mx-auto cursor-pointer" onclick="openInvitationEnvelope()">
                    <div class="envelope-lining"></div>

                    <div class="envelope-card">
                        <div class="h-full flex flex-col justify-between text-left">
                            <div class="flex items-center justify-between border-b border-neutral-200 pb-2.5">
                                <span class="px-2.5 py-0.5 bg-neutral-900 text-white font-extrabold text-[10px] tracking-wider uppercase rounded-md shadow-xs" data-i18n="envelope_badge">
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
                                <span data-i18n="envelope_action">Buka Detail Acara</span>
                                <svg class="w-3.5 h-3.5 text-neutral-900 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="envelope-pocket"></div>
                    <div class="envelope-flap"></div>

                    <div class="envelope-seal">
                        <button type="button" class="rounded-full bg-gradient-to-br from-neutral-100 via-neutral-300 to-neutral-500 border-2 border-white text-neutral-950 flex items-center justify-center shadow-xl hover:scale-105 active:scale-95 transition-transform cursor-pointer" style="width: 52px; height: 52px;" title="Buka Undangan">
                            <svg class="w-6 h-6 text-neutral-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5"/>
                            </svg>
                        </button>
                    </div>

                </div>
            </div>

            <p class="text-xs text-neutral-400 tracking-wide font-medium flex items-center justify-center gap-1.5 animate-pulse cursor-pointer" onclick="openInvitationEnvelope()">
                <span data-i18n="envelope_hint">Ketuk amplop untuk membuka</span>
                <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </p>

        </div>
    </div>
@endif

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 sm:space-y-16 py-4">

    <!-- ==========================================================================
         1. HERO SECTION (HEADLINE + FLYER ATAS DENGAN 3D PARALLAX TILT)
         ========================================================================== -->
    <section class="scroll-reveal grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start pt-4 sm:pt-8">
        
        <!-- Sisi Kiri Hero: Teks & Action Ala Luma Event Landing -->
        <div class="lg:col-span-7 space-y-6 anim-hero-text">
            
            <div class="space-y-4 relative">
                <!-- Headline Acara -->
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-[1.2] tracking-tight">
                    {{ $settings['event_title'] }}
                </h1>

                <!-- Self-Drawing SVG Curved Line (Silver/White Stroke) -->
                <div class="w-48 sm:w-64 pt-0.5">
                    <svg viewBox="0 0 260 20" fill="none" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12C60 4 140 18 256 6" stroke="rgba(255, 255, 255, 0.35)" stroke-width="4" stroke-linecap="round" class="svg-draw-line" />
                    </svg>
                </div>
                
                @php
                    $dateStr = $settings['event_date'] ?? '';
                    $dayNumber = '27';
                    $monthAbbr = 'OKT';
                    if (preg_match('/(\d{1,2})\s+([A-Za-z]+)/', $dateStr, $matches)) {
                        $dayNumber = $matches[1];
                        $monthAbbr = strtoupper(substr($matches[2], 0, 3));
                    } elseif (preg_match('/\d{1,2}/', $dateStr, $matches)) {
                        $dayNumber = $matches[0];
                    }
                @endphp

                <!-- Quick Date & Venue Indicator Card (Monochromatic Glass ala Luma) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    <!-- Date Quick Badge -->
                    <div class="flex items-center gap-3.5 p-3.5 rounded-xl card-glass-subtle">
                        <div class="w-11 h-11 rounded-lg bg-white/10 border border-white/15 text-white flex flex-col items-center justify-center font-bold shrink-0">
                            <span class="text-[9px] uppercase font-bold tracking-wider text-neutral-400 leading-none">{{ $monthAbbr }}</span>
                            <span class="text-base font-black leading-none mt-1">{{ $dayNumber }}</span>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-white truncate">{{ $settings['event_date'] }}</div>
                            <div class="text-[11px] text-neutral-400 truncate mt-0.5">{{ $settings['event_time'] }}</div>
                        </div>
                    </div>

                    <!-- Venue Quick Badge -->
                    <div class="flex items-center gap-3.5 p-3.5 rounded-xl card-glass-subtle">
                        <div class="w-11 h-11 rounded-lg bg-white/10 border border-white/15 text-neutral-300 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-white truncate">{{ $settings['event_venue_name'] }}</div>
                            <div class="text-[11px] text-neutral-400 truncate mt-0.5" data-i18n="quick_venue_label">{{ $settings['event_venue_address'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Acara (Paragraf Rapi ala Luma) -->
                <div class="text-sm sm:text-base text-neutral-300 leading-relaxed max-w-2xl font-normal pt-2 space-y-3.5">
                    @foreach(array_filter(explode("\n", str_replace("\r", "", $settings['event_description'] ?? ''))) as $paragraph)
                        @if(trim($paragraph) !== '')
                            <p>{{ trim($paragraph) }}</p>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Host Info & Request to Join Action (Berdampingan ke URL /register) -->
            <div class="pt-5 border-t border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                
                <!-- Sisi Kiri: Host Info (Diselenggarakan Oleh) -->
                <div class="space-y-2">
                    <span class="text-[10px] uppercase font-bold tracking-wider text-neutral-400 block" data-i18n="hosted_by">
                        Diselenggarakan Oleh
                    </span>
                    @if(!empty($settings['event_organizer']))
                        @php
                            $hosts = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $settings['event_organizer'])));
                            $hostGradients = [
                                'from-zinc-300 via-neutral-400 to-zinc-600',
                                'from-blue-300 via-indigo-300 to-slate-400',
                                'from-slate-200 via-slate-400 to-zinc-500',
                            ];
                        @endphp
                        <div class="flex flex-wrap items-center gap-3">
                            @foreach($hosts as $idx => $host)
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-tr {{ $hostGradients[$idx % count($hostGradients)] }} text-neutral-950 border border-white/20 flex items-center justify-center font-bold text-[11px] shadow-xs shrink-0">
                                        {{ strtoupper(substr($host, 0, 1)) }}
                                    </div>
                                    <span class="text-xs font-bold text-neutral-200">{{ $host }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-white/20 text-white border border-white/20 flex items-center justify-center font-bold text-[11px] shadow-xs shrink-0">
                                C
                            </div>
                            <span class="text-xs font-bold text-neutral-200">C LEVEL Indonesia</span>
                        </div>
                    @endif
                </div>

                <!-- Sisi Kanan: Tombol Request to Join (Mengarah ke /register) -->
                <div class="flex items-center gap-2.5 shrink-0 w-full sm:w-auto pt-1 sm:pt-0">
                    <a href="{{ route('participants.create') }}" 
                       class="btn-glow-white flex-1 sm:flex-none px-7 py-3.5 font-black text-xs sm:text-sm tracking-wide rounded-xl flex items-center justify-center gap-2.5 cursor-pointer text-center shadow-xl hover:scale-[1.03] active:scale-[0.98] transition-all">
                        <span data-i18n="btn_request_join">Request to Join</span>
                        <svg class="w-4 h-4 text-neutral-950 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>

                    @if(!empty($settings['event_maps_url']))
                        <a href="{{ $settings['event_maps_url'] }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="btn-glass p-3.5 font-semibold rounded-xl flex items-center justify-center text-center shrink-0"
                           title="Buka Rute Lokasi (Google Maps)">
                            <svg class="w-4 h-4 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    @endif
                </div>

            </div>

        </div>

        <!-- Sisi Kanan Hero: Visual Flyer Acara Atas dengan 3D Parallax Tilt & Lightbox -->
        <div class="lg:col-span-5 flex justify-center lg:justify-end anim-flyer-card tilt-card-container relative">
            <div class="flyer-glow-ambient anim-aurora-glow"></div>

            <div class="w-full max-w-[370px] anim-floating relative z-10">
                <div id="heroFlyerCard" class="tilt-card card-glass rounded-2xl overflow-hidden cursor-zoom-in group p-2.5 relative" onclick="openFlyerPreview('{{ !empty($settings['event_flyer']) ? asset($settings['event_flyer']) : '' }}')" title="Klik untuk memperbesar flyer">
                    
                    @if(!empty($settings['event_flyer']))
                        @php
                            $flyerFit = $settings['event_flyer_fit'] ?? 'contain';
                        @endphp
                        <div class="w-full flex items-center justify-center rounded-xl overflow-hidden {{ $flyerFit === 'contain' ? 'bg-black/60 p-2' : '' }} relative">
                            <img 
                                src="{{ asset($settings['event_flyer']) }}" 
                                alt="{{ $settings['event_title'] }}" 
                                class="w-full {{ $flyerFit === 'cover' ? 'h-auto aspect-square object-cover' : 'h-auto max-h-[460px] object-contain' }} rounded-lg block shadow-lg transition-transform duration-300 group-hover:scale-[1.01]"
                            >
                            
                            <div class="absolute bottom-3 right-3 px-2.5 py-1 rounded-lg bg-black/70 backdrop-blur-md border border-white/20 text-white text-[11px] font-semibold opacity-0 group-hover:opacity-100 transition-all duration-200 flex items-center gap-1.5 shadow-xl pointer-events-none transform translate-y-1 group-hover:translate-y-0">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                                <span data-i18n="zoom_badge">Lihat Ukuran Penuh</span>
                            </div>
                        </div>
                    @else
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
        
        <!-- Glassmorphism Segmented Bar -->
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
                            <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400" data-i18n="venue_title">Lokasi / Venue</span>
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
                                <span data-i18n="btn_maps">Buka Google Maps</span>
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
                            <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400" data-i18n="date_title">Tanggal Pelaksanaan</span>
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
                            <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400" data-i18n="time_title">Waktu / Jam</span>
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
                            <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400" data-i18n="dresscode_title">Ketentuan Busana</span>
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

    <!-- Bottom CTA Bar -->
    <section class="scroll-reveal py-4 text-center">
        <div class="p-8 rounded-2xl card-glass max-w-2xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-5 text-left">
            <div>
                <h3 class="text-lg font-black text-white" data-i18n="form_section_title">Formulir Pendaftaran & E-Ticket</h3>
                <p class="text-xs text-neutral-400 mt-1" data-i18n="form_section_subtitle">Silakan isi formulir untuk mendapatkan E-Ticket WhatsApp resmi.</p>
            </div>
            <a href="{{ route('participants.create') }}" 
               class="btn-glow-white px-7 py-3.5 font-black text-xs sm:text-sm tracking-wide rounded-xl flex items-center justify-center gap-2 cursor-pointer text-center shrink-0 w-full sm:w-auto shadow-lg hover:scale-105 active:scale-95 transition-all">
                <span data-i18n="btn_request_join">Request to Join</span>
                <svg class="w-4 h-4 text-neutral-950 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </section>

    <!-- ==========================================================================
         LIGHTBOX MODAL PREVIEW FLYER FULLSCREEN
         ========================================================================== -->
    <div id="flyerPreviewModal" 
         class="fixed inset-0 z-[120] hidden items-center justify-center p-3 sm:p-6 bg-black/90 backdrop-blur-2xl transition-all duration-300 opacity-0"
         onclick="handlePreviewBackdropClick(event)">
        
        <button type="button" 
                onclick="closeFlyerPreview()" 
                class="absolute top-4 right-4 sm:top-6 sm:right-6 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white flex items-center justify-center transition-all cursor-pointer shadow-xl z-20 hover:scale-105 active:scale-95"
                title="Tutup Preview (Esc)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div id="previewCard" class="relative max-w-[95vw] max-h-[92vh] flex items-center justify-center transform scale-95 transition-transform duration-300">
            <img id="previewModalImage" 
                 src="" 
                 alt="{{ $settings['event_title'] }}" 
                 class="max-h-[88vh] max-w-[92vw] w-auto h-auto object-contain rounded-2xl shadow-2xl border border-white/15 block bg-black/60"
            >
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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

        window.openFlyerPreview = function(imageUrl) {
            if (!imageUrl) return;
            const modal = document.getElementById('flyerPreviewModal');
            const img = document.getElementById('previewModalImage');
            const card = document.getElementById('previewCard');
            if (!modal || !img) return;

            img.src = imageUrl;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                if (card) {
                    card.classList.remove('scale-95');
                    card.classList.add('scale-100');
                }
            });
        };

        window.closeFlyerPreview = function() {
            const modal = document.getElementById('flyerPreviewModal');
            const card = document.getElementById('previewCard');
            if (!modal) return;

            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            if (card) {
                card.classList.remove('scale-100');
                card.classList.add('scale-95');
            }

            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 250);
        };

        window.handlePreviewBackdropClick = function(event) {
            const img = document.getElementById('previewModalImage');
            if (img && !img.contains(event.target)) {
                closeFlyerPreview();
            }
        };

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('flyerPreviewModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeFlyerPreview();
                }
            }
        });
    });
</script>
@endpush
