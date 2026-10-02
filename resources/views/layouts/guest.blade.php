<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pendaftaran Peserta - C LEVEL')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fdf4',
                            500: '#10b981',
                            600: '#059669',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>

    <!-- QRCode JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #030712;
            color: #f8fafc;
        }

        /* ==========================================================================
           LUMA-INSPIRED DARK AURORA BACKGROUND & STARDUST MESH
           ========================================================================== */
        .bg-aurora-cosmic {
            background-color: #030712;
            background-image: 
                /* Stardust speckles */
                radial-gradient(1px 1px at 25px 35px, rgba(255, 255, 255, 0.75), transparent),
                radial-gradient(1.5px 1.5px at 80px 120px, rgba(255, 255, 255, 0.9), transparent),
                radial-gradient(1px 1px at 160px 70px, rgba(255, 255, 255, 0.6), transparent),
                radial-gradient(1.5px 1.5px at 240px 220px, rgba(255, 255, 255, 0.8), transparent),
                radial-gradient(1px 1px at 320px 160px, rgba(255, 255, 255, 0.7), transparent),
                radial-gradient(1px 1px at 420px 310px, rgba(255, 255, 255, 0.5), transparent),
                /* Ambient Aurora Spherical Glows */
                radial-gradient(ellipse 75% 50% at 50% -12%, rgba(56, 189, 248, 0.18), transparent 75%),
                radial-gradient(ellipse 55% 45% at 85% 15%, rgba(99, 102, 241, 0.15), transparent 70%),
                radial-gradient(ellipse 50% 40% at 15% 25%, rgba(20, 184, 166, 0.13), transparent 70%);
            background-size: 340px 340px, 340px 340px, 340px 340px, 340px 340px, 340px 340px, 340px 340px, 100% 100%, 100% 100%, 100% 100%;
        }

        /* Vertical Aurora Shimmering Curtain Rays (Ethereal Northern Lights) */
        .aurora-rays-layer {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }
        .aurora-rays-layer::before {
            content: '';
            position: absolute;
            top: -20%;
            left: -20%;
            width: 140%;
            height: 110vh;
            background: repeating-linear-gradient(
                78deg,
                transparent 0%,
                transparent 7%,
                rgba(56, 189, 248, 0.045) 9.5%,
                rgba(99, 102, 241, 0.08) 12.5%,
                transparent 15%,
                rgba(20, 184, 166, 0.055) 19%,
                transparent 23.5%
            );
            filter: blur(42px);
            mask-image: radial-gradient(ellipse 85% 75% at 50% 20%, black 25%, transparent 80%);
            -webkit-mask-image: radial-gradient(ellipse 85% 75% at 50% 20%, black 25%, transparent 80%);
            opacity: 0.9;
        }

        /* Glass Surface Global Token */
        .glass-panel {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 20px 45px -15px rgba(0, 0, 0, 0.7);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-aurora-cosmic text-slate-100 antialiased min-h-screen flex flex-col justify-between relative selection:bg-cyan-500/30 selection:text-cyan-200">

    <!-- Ambient Aurora Light Ray Mesh Overlay -->
    <div class="aurora-rays-layer"></div>

    <!-- Clean Minimal Dark Glass Header -->
    <header class="bg-slate-950/60 backdrop-blur-xl border-b border-white/10 py-4 px-4 sm:px-6 sticky top-0 z-40 transition-colors">
        <div class="max-w-6xl mx-auto flex items-center justify-between relative z-10">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <span class="px-3 py-1 bg-white/10 hover:bg-white/15 text-white font-black text-xs sm:text-sm tracking-widest rounded-lg border border-white/15 shadow-sm transition-all group-hover:border-cyan-400/50 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                    <span>C LEVEL</span>
                </span>
                <span class="text-xs font-semibold text-slate-400 hidden sm:inline-block tracking-wide">
                    Exclusive Executive Forum
                </span>
            </a>

            <div class="flex items-center space-x-3 text-xs text-slate-400">
                <span class="hidden md:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-slate-300">
                    <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Official Portal</span>
                </span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow py-6 sm:py-10 relative z-10">
        @yield('content')
    </main>

    <!-- Footer Simple Minimal Dark -->
    <footer class="border-t border-white/10 bg-slate-950/70 backdrop-blur-md py-6 relative z-10">
        <div class="max-w-6xl mx-auto px-4 text-center text-xs text-slate-400 font-medium space-y-1">
            <p>&copy; {{ date('Y') }} C LEVEL Indonesia. Sistem Presensi & Pendaftaran Resmi.</p>
            <p class="text-[11px] text-slate-400 font-normal">All rights reserved. Powered by Executive Event Management.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
