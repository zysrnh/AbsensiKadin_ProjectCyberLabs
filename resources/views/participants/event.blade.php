@extends('layouts.guest')
@section('title', $settings['event_title'] . ' - Wonderful')

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
                                <div class="flex items-center gap-1.5 px-2 py-0.5 bg-neutral-900 rounded-md shadow-xs">
                                    <img src="{{ asset('images/wonderful-logo.png') }}" alt="Wonderful" class="w-4 h-4 object-contain">
                                    <img src="{{ asset('images/won.png') }}" alt="Wonderful" class="h-3 w-auto object-contain filter invert brightness-200">
                                </div>
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
                        <button type="button" class="rounded-full bg-gradient-to-br from-neutral-900 to-black border-2 border-white/60 p-1.5 flex items-center justify-center shadow-2xl hover:scale-105 active:scale-95 transition-transform cursor-pointer" style="width: 54px; height: 54px;" title="Buka Undangan">
                            <img src="{{ asset('images/wonderful-logo.png') }}" alt="Wonderful" class="w-10 h-10 object-contain drop-shadow-md">
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
    $hosts = !empty($settings['event_organizer']) 
        ? array_filter(array_map('trim', preg_split('/[\r\n,]+/', $settings['event_organizer']))) 
        : ['Daphne Kusuma', 'Dina Ernawati Saksono'];
    $hostGradients = [
        'from-zinc-300 via-neutral-400 to-zinc-600',
        'from-blue-300 via-indigo-300 to-slate-400',
        'from-slate-200 via-slate-400 to-zinc-500',
    ];
@endphp

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">

    <!-- ==========================================================================
         A. MOBILE VIEW (PERSIS SESUAI SCREENSHOT LUMA MOBILE)
         Urutan: Flyer di Paling Atas (Gede) -> Judul Acara -> Host -> 
                 Tanggal & Lokasi -> Card Pendaftaran -> Tentang Acara -> Lokasi -> Host
         ========================================================================== -->
    <div class="block lg:hidden space-y-6 pt-2 pb-10 max-w-lg mx-auto">
        
        <!-- 1. FLYER POSTER DI PALING ATAS & BESAR (ALA LUMA MOBILE) -->
        <div class="w-full relative anim-flyer-card tilt-card-container">
            <div class="flyer-glow-ambient anim-aurora-glow"></div>

            <div class="w-full relative z-10">
                <div class="tilt-card card-glass rounded-2xl sm:rounded-3xl overflow-hidden cursor-zoom-in group p-2 shadow-2xl relative" 
                     onclick="openFlyerPreview('{{ !empty($settings['event_flyer']) ? asset($settings['event_flyer']) : '' }}')" 
                     title="Ketuk untuk memperbesar flyer">
                    
                    @if(!empty($settings['event_flyer']))
                        <div class="w-full flex items-center justify-center rounded-xl sm:rounded-2xl overflow-hidden bg-black/60 relative">
                            <img 
                                src="{{ asset($settings['event_flyer']) }}" 
                                alt="{{ $settings['event_title'] }}" 
                                class="w-full h-auto max-h-[500px] object-contain rounded-xl block shadow-lg"
                            >
                            <div class="absolute bottom-3 right-3 px-3 py-1.5 rounded-lg bg-black/75 backdrop-blur-md border border-white/20 text-white text-xs font-semibold flex items-center gap-1.5 shadow-xl pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                                <span data-i18n="zoom_badge">Lihat Ukuran Penuh</span>
                            </div>
                        </div>
                    @else
                        <div class="bg-gradient-to-b from-neutral-900 to-black text-white p-7 flex flex-col justify-between rounded-2xl border border-white/10 aspect-square">
                            <div class="flex items-center justify-between">
                                <img src="{{ asset('images/wonderful-logo.png') }}" alt="Wonderful" class="w-6 h-6 object-contain">
                                <span class="w-2.5 h-2.5 rounded-full bg-white animate-ping"></span>
                            </div>
                            <div class="my-auto py-4">
                                <h3 class="text-xl font-black text-white leading-tight">
                                    {{ $settings['event_title'] }}
                                </h3>
                            </div>
                            <div class="pt-3 border-t border-white/10 text-xs text-neutral-400">
                                {{ $settings['event_date'] }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 2. JUDUL ACARA & CURVE SVG -->
        <div class="space-y-3 pt-1">
            <h1 class="text-2xl sm:text-3xl font-black text-white leading-tight tracking-tight">
                {{ $settings['event_title'] }}
            </h1>
            <div class="w-48 pt-0.5">
                <svg viewBox="0 0 260 20" fill="none" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 12C60 4 140 18 256 6" stroke="rgba(255, 255, 255, 0.35)" stroke-width="4" stroke-linecap="round" class="svg-draw-line" />
                </svg>
            </div>
        </div>

        <!-- 3. BARIS HOST (AVATAR CIRCLE + NAMA HOST) -->
        <div class="flex items-center gap-2.5 py-1">
            <div class="flex -space-x-2 overflow-hidden shrink-0">
                @foreach(array_slice($hosts, 0, 3) as $idx => $host)
                    <div class="inline-block h-7 w-7 rounded-full ring-2 ring-neutral-950 bg-gradient-to-tr {{ $hostGradients[$idx % count($hostGradients)] }} text-neutral-950 flex items-center justify-center font-bold text-[10px]">
                        {{ strtoupper(substr($host, 0, 1)) }}
                    </div>
                @endforeach
            </div>
            <div class="text-xs sm:text-sm font-medium text-neutral-300 truncate">
                <span class="text-neutral-400" data-i18n="hosted_by_prefix">Diselenggarakan oleh</span> 
                <span class="text-white font-bold">{{ implode(', ', $hosts) }}</span>
            </div>
        </div>

        <!-- 4. BARIS TANGGAL & LOKASI (ALA LUMA) -->
        <div class="space-y-2.5">
            <!-- Row Tanggal & Jam -->
            <div class="flex items-center gap-3.5 p-3 rounded-xl card-glass-subtle">
                <div class="w-11 h-12 rounded-lg bg-neutral-900 border border-white/15 text-white flex flex-col items-center justify-center shrink-0 overflow-hidden shadow-xs">
                    <div class="w-full bg-white/10 text-[9px] uppercase font-bold tracking-wider text-neutral-300 text-center py-0.5 leading-none">{{ $monthAbbr }}</div>
                    <div class="text-base font-black text-white leading-none mt-1">{{ $dayNumber }}</div>
                </div>
                <div class="min-w-0">
                    <div class="text-xs sm:text-sm font-bold text-white truncate">{{ $settings['event_date'] }}</div>
                    <div class="text-xs text-neutral-400 truncate mt-0.5">{{ $settings['event_time'] }}</div>
                </div>
            </div>

            <!-- Row Lokasi & Alamat -->
            <div class="flex items-center gap-3.5 p-3 rounded-xl card-glass-subtle">
                <div class="w-11 h-12 rounded-lg bg-white/10 border border-white/15 text-neutral-300 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-xs sm:text-sm font-bold text-white truncate">{{ $settings['event_venue_name'] }}</div>
                    <div class="text-xs text-neutral-400 truncate mt-0.5">{{ $settings['event_venue_address'] }}</div>
                </div>
            </div>
        </div>

        <!-- 5. CARD PENDAFTARAN (ALA SCREENSHOT 2 LUMA) -->
        <div class="space-y-2 pt-1">
            <span class="text-xs font-bold text-neutral-400 uppercase tracking-wider block px-1" data-i18n="registration_card_title">
                Pendaftaran
            </span>
            <div class="p-5 rounded-2xl card-glass space-y-4 shadow-xl">
                <!-- Persetujuan Diperlukan banner -->
                <div class="flex items-start gap-3 p-3.5 rounded-xl bg-white/[0.04] border border-white/10">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center shrink-0 text-white">
                        <svg class="w-4 h-4 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs font-bold text-white" data-i18n="approval_required">Persetujuan Diperlukan</div>
                        <div class="text-[11px] text-neutral-400 mt-0.5" data-i18n="approval_desc">Pendaftaran Anda memerlukan persetujuan host.</div>
                    </div>
                </div>

                <!-- Welcome Text -->
                <p class="text-xs sm:text-sm text-neutral-300 font-medium leading-relaxed" data-i18n="welcome_msg">
                    Selamat datang! Untuk mengikuti acara ini, silakan daftar di bawah.
                </p>

                <!-- Tombol Putih Besar "Minta untuk Bergabung / Request to Join" -->
                <a href="{{ route('participants.create') }}" 
                   class="btn-glow-white w-full py-3.5 px-6 font-black text-xs sm:text-sm tracking-wide rounded-xl flex items-center justify-center gap-2 cursor-pointer text-center shadow-xl hover:scale-[1.01] active:scale-[0.99] transition-all">
                    <span data-i18n="btn_request_join">Minta untuk Bergabung</span>
                    <svg class="w-4 h-4 text-neutral-950 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- 6. SECTION TENTANG ACARA (ALA SCREENSHOT 2) -->
        <div class="space-y-3 pt-2">
            <h3 class="text-base font-black text-white tracking-tight" data-i18n="about_event">
                Tentang Acara
            </h3>
            <div class="text-xs sm:text-sm text-neutral-300 leading-relaxed font-normal space-y-3.5">
                @foreach(array_filter(explode("\n", str_replace("\r", "", $settings['event_description'] ?? ''))) as $paragraph)
                    @if(trim($paragraph) !== '')
                        <p>{{ trim($paragraph) }}</p>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- 7. SECTION LOKASI & GOOGLE MAPS (ALA SCREENSHOT 3) -->
        <div class="space-y-3 pt-2">
            <h3 class="text-base font-black text-white tracking-tight" data-i18n="location_title">
                Lokasi
            </h3>
            <div>
                <div class="text-xs sm:text-sm font-bold text-white leading-snug" data-i18n="location_prompt">
                    Harap mendaftar untuk melihat lokasi tepat acara ini.
                </div>
                <div class="text-xs text-neutral-400 mt-0.5">
                    {{ $settings['event_venue_address'] }}
                </div>
            </div>

            <!-- Wadah Peta Embed dengan Badge Maps ↗ -->
            <div class="rounded-2xl overflow-hidden card-glass p-1.5 relative">
                <div class="relative h-[220px] w-full rounded-xl overflow-hidden bg-black maps-iframe-container">
                    @if(!empty($settings['event_maps_url']))
                        <a href="{{ $settings['event_maps_url'] }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="absolute top-3 left-3 z-10 px-3 py-1.5 rounded-lg bg-white/90 hover:bg-white text-neutral-950 font-bold text-xs flex items-center gap-1.5 shadow-md backdrop-blur-md transition-all">
                            <span data-i18n="btn_maps">Maps</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    @endif

                    @if(!empty($settings['event_maps_iframe']))
                        {!! $settings['event_maps_iframe'] !!}
                    @else
                        <iframe 
                            src="https://maps.google.com/maps?q={{ urlencode(($settings['event_venue_name'] ?? '') . ' ' . ($settings['event_venue_address'] ?? 'SCBD Area, Jakarta')) }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            class="w-full h-full border-0"
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    @endif
                </div>
            </div>
        </div>

        <!-- 8. SECTION DISELENGGARAKAN OLEH (ALA SCREENSHOT 3) -->
        <div class="space-y-4 pt-2">
            <h3 class="text-base font-black text-white tracking-tight" data-i18n="hosted_by">
                Diselenggarakan Oleh
            </h3>
            
            <div class="space-y-3">
                @foreach($hosts as $idx => $host)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr {{ $hostGradients[$idx % count($hostGradients)] }} text-neutral-950 border border-white/20 flex items-center justify-center font-bold text-xs shadow-xs shrink-0">
                            {{ strtoupper(substr($host, 0, 1)) }}
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-white">{{ $host }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Action links & Tag ala Luma -->
            <div class="space-y-2 pt-2 text-xs text-neutral-400">
                <div>
                    <a href="mailto:contact@wonderful.ai" class="hover:text-white transition-colors" data-i18n="contact_host">Hubungi Penyelenggara</a>
                </div>
                <div>
                    <a href="javascript:void(0)" onclick="alert('Laporan Anda telah diterima.')" class="hover:text-white transition-colors" data-i18n="report_event">Laporkan Acara</a>
                </div>
            </div>

            <div class="pt-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-neutral-300">
                    # AI
                </span>
            </div>
        </div>

    </div>


    <!-- ==========================================================================
         B. DESKTOP VIEW (MODERN 2-COLUMN LAYOUT)
         Kiri: Konten Detail, Tentang Acara, Lokasi & Host
         Kanan: Flyer Poster (Besar) + Card Pendaftaran Sticky
         ========================================================================== -->
    <div class="hidden lg:grid lg:grid-cols-12 gap-12 lg:gap-14 items-start pt-6 pb-14">
        
        <!-- Sisi Kiri Desktop: Detail Acara Lengkap -->
        <div class="lg:col-span-7 space-y-8 anim-hero-text">
            
            <!-- Headline & Curve -->
            <div class="space-y-4">
                <h1 class="text-4xl lg:text-5xl font-black text-white leading-[1.18] tracking-tight">
                    {{ $settings['event_title'] }}
                </h1>
                <div class="w-60 pt-0.5">
                    <svg viewBox="0 0 260 20" fill="none" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12C60 4 140 18 256 6" stroke="rgba(255, 255, 255, 0.35)" stroke-width="4" stroke-linecap="round" class="svg-draw-line" />
                    </svg>
                </div>
            </div>

            <!-- Host Line -->
            <div class="flex items-center gap-3">
                <div class="flex -space-x-2 overflow-hidden shrink-0">
                    @foreach(array_slice($hosts, 0, 3) as $idx => $host)
                        <div class="inline-block h-8 w-8 rounded-full ring-2 ring-neutral-950 bg-gradient-to-tr {{ $hostGradients[$idx % count($hostGradients)] }} text-neutral-950 flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr($host, 0, 1)) }}
                        </div>
                    @endforeach
                </div>
                <div class="text-sm font-medium text-neutral-300">
                    <span class="text-neutral-400" data-i18n="hosted_by_prefix">Diselenggarakan oleh</span> 
                    <span class="text-white font-bold">{{ implode(', ', $hosts) }}</span>
                </div>
            </div>

            <!-- Quick Date & Venue Cards -->
            <div class="grid grid-cols-2 gap-3.5 pt-2">
                <div class="flex items-center gap-3.5 p-4 rounded-xl card-glass-subtle">
                    <div class="w-12 h-12 rounded-lg bg-neutral-900 border border-white/15 text-white flex flex-col items-center justify-center shrink-0 overflow-hidden shadow-xs">
                        <span class="w-full bg-white/10 text-[9px] uppercase font-bold tracking-wider text-neutral-300 text-center py-0.5 leading-none">{{ $monthAbbr }}</span>
                        <span class="text-lg font-black text-white leading-none mt-1">{{ $dayNumber }}</span>
                    </div>
                    <div class="min-w-0">
                        <div class="text-sm font-bold text-white truncate">{{ $settings['event_date'] }}</div>
                        <div class="text-xs text-neutral-400 truncate mt-0.5">{{ $settings['event_time'] }}</div>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 p-4 rounded-xl card-glass-subtle">
                    <div class="w-12 h-12 rounded-lg bg-white/10 border border-white/15 text-neutral-300 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="text-sm font-bold text-white truncate">{{ $settings['event_venue_name'] }}</div>
                        <div class="text-xs text-neutral-400 truncate mt-0.5" data-i18n="quick_venue_label">{{ $settings['event_venue_address'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Tentang Acara (Paragraf Rapi) -->
            <div class="space-y-4 pt-3 border-t border-white/10">
                <h3 class="text-xl font-black text-white tracking-tight" data-i18n="about_event">
                    Tentang Acara
                </h3>
                <div class="text-base text-neutral-300 leading-relaxed font-normal space-y-4">
                    @foreach(array_filter(explode("\n", str_replace("\r", "", $settings['event_description'] ?? ''))) as $paragraph)
                        @if(trim($paragraph) !== '')
                            <p>{{ trim($paragraph) }}</p>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Lokasi & Map -->
            <div class="space-y-4 pt-3 border-t border-white/10">
                <h3 class="text-xl font-black text-white tracking-tight" data-i18n="location_title">
                    Lokasi
                </h3>
                <div>
                    <div class="text-sm font-bold text-white" data-i18n="location_prompt">
                        Harap mendaftar untuk melihat lokasi tepat acara ini.
                    </div>
                    <div class="text-xs text-neutral-400 mt-0.5">
                        {{ $settings['event_venue_address'] }}
                    </div>
                </div>

                <div class="rounded-2xl overflow-hidden card-glass p-2 relative">
                    <div class="relative h-[320px] w-full rounded-xl overflow-hidden bg-black maps-iframe-container">
                        @if(!empty($settings['event_maps_url']))
                            <a href="{{ $settings['event_maps_url'] }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="absolute top-3 left-3 z-10 px-3.5 py-2 rounded-xl bg-white hover:bg-neutral-100 text-neutral-950 font-bold text-xs flex items-center gap-1.5 shadow-lg backdrop-blur-md transition-all">
                                <span data-i18n="btn_maps">Maps</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        @endif

                        @if(!empty($settings['event_maps_iframe']))
                            {!! $settings['event_maps_iframe'] !!}
                        @else
                            <iframe 
                                src="https://maps.google.com/maps?q={{ urlencode(($settings['event_venue_name'] ?? '') . ' ' . ($settings['event_venue_address'] ?? 'SCBD Area, Jakarta')) }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                class="w-full h-full border-0"
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Diselenggarakan Oleh (Host List) -->
            <div class="space-y-4 pt-3 border-t border-white/10">
                <h3 class="text-xl font-black text-white tracking-tight" data-i18n="hosted_by">
                    Diselenggarakan Oleh
                </h3>
                <div class="flex flex-wrap items-center gap-6">
                    @foreach($hosts as $idx => $host)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr {{ $hostGradients[$idx % count($hostGradients)] }} text-neutral-950 border border-white/20 flex items-center justify-center font-bold text-sm shadow-xs shrink-0">
                                {{ strtoupper(substr($host, 0, 1)) }}
                            </div>
                            <span class="text-sm font-bold text-white">{{ $host }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center gap-6 pt-2 text-xs text-neutral-400">
                    <a href="mailto:contact@wonderful.ai" class="hover:text-white transition-colors" data-i18n="contact_host">Hubungi Penyelenggara</a>
                    <span>•</span>
                    <a href="javascript:void(0)" onclick="alert('Laporan Anda telah diterima.')" class="hover:text-white transition-colors" data-i18n="report_event">Laporkan Acara</a>
                    <span>•</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-neutral-300"># AI</span>
                </div>
            </div>

        </div>

        <!-- Sisi Kanan Desktop: Sticky Sidebar (Flyer Besar + Card Pendaftaran) -->
        <div class="lg:col-span-5 sticky top-24 space-y-6 anim-flyer-card">
            
            <!-- Poster Flyer Besar -->
            <div class="relative tilt-card-container">
                <div class="flyer-glow-ambient anim-aurora-glow"></div>
                <div class="tilt-card card-glass rounded-3xl overflow-hidden cursor-zoom-in group p-2.5 relative shadow-2xl" 
                     onclick="openFlyerPreview('{{ !empty($settings['event_flyer']) ? asset($settings['event_flyer']) : '' }}')" 
                     title="Klik untuk memperbesar flyer">
                    @if(!empty($settings['event_flyer']))
                        <div class="w-full flex items-center justify-center rounded-2xl overflow-hidden bg-black/60 relative">
                            <img 
                                src="{{ asset($settings['event_flyer']) }}" 
                                alt="{{ $settings['event_title'] }}" 
                                class="w-full h-auto max-h-[480px] object-contain rounded-xl block shadow-lg transition-transform duration-300 group-hover:scale-[1.01]"
                            >
                            <div class="absolute bottom-3 right-3 px-3 py-1.5 rounded-lg bg-black/75 backdrop-blur-md border border-white/20 text-white text-xs font-semibold opacity-0 group-hover:opacity-100 transition-all duration-200 flex items-center gap-1.5 shadow-xl pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                                <span data-i18n="zoom_badge">Lihat Ukuran Penuh</span>
                            </div>
                        </div>
                    @else
                        <div class="bg-gradient-to-b from-neutral-900 to-black text-white p-7 flex flex-col justify-between rounded-2xl border border-white/10 aspect-square">
                            <img src="{{ asset('images/wonderful-logo.png') }}" alt="Wonderful" class="w-7 h-7 object-contain">
                            <h3 class="text-2xl font-black text-white leading-tight my-auto">{{ $settings['event_title'] }}</h3>
                            <div class="pt-3 border-t border-white/10 text-xs text-neutral-400">{{ $settings['event_date'] }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card Pendaftaran Sticky Desktop -->
            <div class="p-6 rounded-3xl card-glass space-y-4 shadow-2xl border border-white/10">
                <span class="text-xs font-bold text-neutral-400 uppercase tracking-wider block" data-i18n="registration_card_title">
                    Pendaftaran
                </span>

                <div class="flex items-start gap-3 p-3.5 rounded-xl bg-white/[0.04] border border-white/10">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center shrink-0 text-white">
                        <svg class="w-4 h-4 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs font-bold text-white" data-i18n="approval_required">Persetujuan Diperlukan</div>
                        <div class="text-[11px] text-neutral-400 mt-0.5" data-i18n="approval_desc">Pendaftaran Anda memerlukan persetujuan host.</div>
                    </div>
                </div>

                <p class="text-xs sm:text-sm text-neutral-300 font-medium leading-relaxed" data-i18n="welcome_msg">
                    Selamat datang! Untuk mengikuti acara ini, silakan daftar di bawah.
                </p>

                <a href="{{ route('participants.create') }}" 
                   class="btn-glow-white w-full py-4 px-6 font-black text-sm tracking-wide rounded-xl flex items-center justify-center gap-2 cursor-pointer text-center shadow-xl hover:scale-[1.01] active:scale-[0.99] transition-all">
                    <span data-i18n="btn_request_join">Minta untuk Bergabung</span>
                    <svg class="w-4 h-4 text-neutral-950 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>

        </div>

    </div>

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

        const tiltCards = document.querySelectorAll('.tilt-card');
        tiltCards.forEach(tiltCard => {
            tiltCard.addEventListener('mousemove', function(e) {
                const rect = tiltCard.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const rotateX = ((y - centerY) / centerY) * -8;
                const rotateY = ((x - centerX) / centerX) * 8;
                
                tiltCard.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.01)`;
                tiltCard.style.boxShadow = `0 25px 45px -10px rgba(0, 0, 0, 0.8)`;
            });

            tiltCard.addEventListener('mouseleave', function() {
                tiltCard.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)`;
                tiltCard.style.boxShadow = ``;
            });
        });

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
