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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- QRCode JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        /* ==========================================================================
           BASE — COSMIC VOID DARK + MONOCHROMATIC AURORA WISPS
           Inspired by Luma.com's dark event page aesthetic
           ========================================================================== */
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --bg-void: #07090f;
            --surface-glass: rgba(255, 255, 255, 0.04);
            --border-glass: rgba(255, 255, 255, 0.09);
            --border-glass-strong: rgba(255, 255, 255, 0.16);
            --rim-light: rgba(255, 255, 255, 0.14);
            --text-primary: #f1f5f9;
            --text-secondary: #8b909c;
            --text-tertiary: #4e535f;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-void);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ------------------------------------------------------------------
           COSMIC BACKGROUND — Near-pure black with very faint grey aurora
           (Same approach as Luma: barely-there vertical light curtain)
           ------------------------------------------------------------------ */
        .bg-cosmic {
            background-color: var(--bg-void);
            background-image:
                /* Micro stardust — very sparse white specks */
                radial-gradient(0.8px 0.8px at 12%  18%, rgba(255,255,255,0.55) 0%, transparent 100%),
                radial-gradient(0.8px 0.8px at 34%   7%, rgba(255,255,255,0.45) 0%, transparent 100%),
                radial-gradient(1.2px 1.2px at 58%  29%, rgba(255,255,255,0.5)  0%, transparent 100%),
                radial-gradient(0.8px 0.8px at 76%  14%, rgba(255,255,255,0.4)  0%, transparent 100%),
                radial-gradient(0.8px 0.8px at 89%  44%, rgba(255,255,255,0.35) 0%, transparent 100%),
                radial-gradient(0.9px 0.9px at 21%  62%, rgba(255,255,255,0.3)  0%, transparent 100%),
                radial-gradient(1.0px 1.0px at 47%  81%, rgba(255,255,255,0.25) 0%, transparent 100%),
                radial-gradient(0.7px 0.7px at 65%  55%, rgba(255,255,255,0.4)  0%, transparent 100%),
                radial-gradient(0.8px 0.8px at 83%  73%, rgba(255,255,255,0.3)  0%, transparent 100%),
                /* Aurora – grey/white wisps only, no hue */
                radial-gradient(ellipse 80% 55% at 50% -5%,  rgba(180,185,200, 0.07) 0%, transparent 70%),
                radial-gradient(ellipse 60% 40% at 80%  12%, rgba(160,165,180, 0.05) 0%, transparent 65%),
                radial-gradient(ellipse 45% 35% at 20%  20%, rgba(150,155,170, 0.04) 0%, transparent 60%);
            background-size:
                500px 500px, 500px 500px, 500px 500px, 500px 500px, 500px 500px,
                500px 500px, 500px 500px, 500px 500px, 500px 500px,
                100% 100%, 100% 100%, 100% 100%;
        }

        /* Vertical aurora curtain — pure greyscale, very delicate */
        .aurora-layer {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        .aurora-layer::before {
            content: '';
            position: absolute;
            top: -30%;
            left: -15%;
            width: 130%;
            height: 115vh;
            background: repeating-linear-gradient(
                82deg,
                transparent               0%,
                transparent               9%,
                rgba(200, 205, 220, 0.028) 11.5%,
                rgba(210, 215, 230, 0.042) 14%,
                transparent               17%,
                rgba(190, 195, 210, 0.022) 21.5%,
                transparent               26%
            );
            filter: blur(55px);
            /* Mask so rays only appear at top-centre, fading out downward */
            mask-image: radial-gradient(ellipse 90% 65% at 50% 5%, black 0%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse 90% 65% at 50% 5%, black 0%, transparent 75%);
        }

        /* ==========================================================================
           GLOBAL GLASS TOKEN
           True frosted glass: high blur + subtle white fill + bright rim light
           ========================================================================== */
        .glass {
            background: var(--surface-glass);
            backdrop-filter: blur(40px) saturate(160%);
            -webkit-backdrop-filter: blur(40px) saturate(160%);
            border: 1px solid var(--border-glass);
            box-shadow:
                inset 0  1px 0   var(--rim-light),       /* top rim highlight */
                inset 0 -1px 0   rgba(255,255,255,0.04),  /* bottom inner glow */
                0 2px  4px rgba(0,0,0,0.35),
                0 8px 30px rgba(0,0,0,0.55),
                0 25px 60px rgba(0,0,0,0.35);
        }

        /* Deep glass — heavier black fill for form cards */
        .glass-deep {
            background: rgba(10, 12, 18, 0.72);
            backdrop-filter: blur(48px) saturate(180%);
            -webkit-backdrop-filter: blur(48px) saturate(180%);
            border: 1px solid var(--border-glass);
            box-shadow:
                inset 0  1px 0 var(--rim-light),
                inset 0 -1px 0 rgba(255,255,255,0.035),
                0 4px 8px   rgba(0,0,0,0.5),
                0 16px 40px rgba(0,0,0,0.65),
                0 40px 80px rgba(0,0,0,0.4);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-cosmic text-slate-100 antialiased min-h-screen flex flex-col justify-between relative">

    <!-- Aurora Curtain Layer -->
    <div class="aurora-layer"></div>

    <!-- ==========================================================================
         HEADER — Ultra-thin monochromatic dark glass
         ========================================================================== -->
    <header class="sticky top-0 z-50 transition-all duration-300"
            style="background: rgba(7, 9, 15, 0.75);
                   backdrop-filter: blur(32px) saturate(150%);
                   -webkit-backdrop-filter: blur(32px) saturate(150%);
                   border-bottom: 1px solid rgba(255,255,255,0.07);
                   box-shadow: 0 1px 0 rgba(255,255,255,0.06), 0 4px 20px rgba(0,0,0,0.5);">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between relative z-10">

            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <!-- Logo pill — subtle white glass -->
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg
                             text-white font-black text-xs tracking-[0.18em] uppercase
                             transition-all duration-200 group-hover:bg-white/10"
                      style="background: rgba(255,255,255,0.07);
                             border: 1px solid rgba(255,255,255,0.12);
                             box-shadow: inset 0 1px 0 rgba(255,255,255,0.14);">
                    <span class="w-1.5 h-1.5 rounded-full bg-white opacity-70 group-hover:opacity-100 transition-opacity"></span>
                    C LEVEL
                </span>
                <span class="text-[11px] font-medium text-white/35 tracking-widest uppercase hidden sm:block">
                    Executive Forum
                </span>
            </a>

            <!-- Right side: subtle "Official" badge -->
            <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-full text-[11px] text-white/40 font-medium"
                 style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);">
                <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Official Portal
            </div>

        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow py-8 sm:py-12 relative z-10">
        @yield('content')
    </main>

    <!-- ==========================================================================
         FOOTER — Same deep glass as header
         ========================================================================== -->
    <footer class="relative z-10"
            style="background: rgba(7, 9, 15, 0.70);
                   backdrop-filter: blur(24px);
                   -webkit-backdrop-filter: blur(24px);
                   border-top: 1px solid rgba(255,255,255,0.06);">
        <div class="max-w-6xl mx-auto px-4 py-6 text-center space-y-1">
            <p class="text-xs text-white/30 font-medium">
                &copy; {{ date('Y') }} C LEVEL Indonesia &mdash; Sistem Presensi &amp; Pendaftaran Resmi
            </p>
            <p class="text-[10px] text-white/15 font-light tracking-wide">
                All rights reserved. Executive Event Management System.
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
