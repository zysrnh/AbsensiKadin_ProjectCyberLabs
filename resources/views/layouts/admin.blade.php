<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Absensi Wonderful 2026')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS Play CDN (Bebas NPM / Vite Build) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- QRCode JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        :root {
            --ease-expo: cubic-bezier(0.16, 1, 0.3, 1);
            --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        #sidebar {
            transition: transform 0.3s var(--ease-expo), margin-left 0.25s var(--ease-expo);
        }
        body.sidebar-closed #sidebar {
            margin-left: -16.5rem !important;
        }

        /* 3D Depth & Elevation Shadow System */
        .card-3d {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 
                0 1px 3px rgba(15, 23, 42, 0.03),
                0 8px 20px -4px rgba(15, 23, 42, 0.06),
                0 20px 40px -10px rgba(15, 23, 42, 0.08);
            border-radius: 1.25rem;
            transition: transform 0.25s var(--ease-expo), box-shadow 0.25s var(--ease-expo);
        }
        .card-3d:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 3px 6px rgba(15, 23, 42, 0.04),
                0 12px 28px -4px rgba(15, 23, 42, 0.08),
                0 26px 52px -10px rgba(15, 23, 42, 0.12);
        }

        /* Tactile Physical Push Buttons */
        .btn-3d-dark {
            box-shadow: 0 3px 0 #020617, 0 8px 16px -3px rgba(15, 23, 42, 0.3);
            transition: all 0.15s var(--ease-expo);
        }
        .btn-3d-dark:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #020617, 0 12px 22px -3px rgba(15, 23, 42, 0.35);
        }
        .btn-3d-dark:active {
            transform: translateY(2px);
            box-shadow: 0 1px 0 #020617, 0 4px 8px -2px rgba(15, 23, 42, 0.25);
        }

        .btn-3d-blue {
            box-shadow: 0 3px 0 #1d4ed8, 0 8px 16px -3px rgba(37, 99, 235, 0.35);
            transition: all 0.15s var(--ease-expo);
        }
        .btn-3d-blue:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #1d4ed8, 0 12px 22px -3px rgba(37, 99, 235, 0.4);
        }
        .btn-3d-blue:active {
            transform: translateY(2px);
            box-shadow: 0 1px 0 #1d4ed8, 0 4px 8px -2px rgba(37, 99, 235, 0.25);
        }

        .btn-3d-white {
            box-shadow: 0 2px 0 #cbd5e1, 0 4px 10px -2px rgba(15, 23, 42, 0.06);
            transition: all 0.15s var(--ease-expo);
        }
        .btn-3d-white:hover {
            transform: translateY(-1.5px);
            box-shadow: 0 4px 0 #cbd5e1, 0 8px 16px -3px rgba(15, 23, 42, 0.1);
        }
        .btn-3d-white:active {
            transform: translateY(1.5px);
            box-shadow: 0 1px 0 #cbd5e1, 0 2px 5px -1px rgba(15, 23, 42, 0.05);
        }

        /* 3D Inset Inputs */
        .input-3d {
            box-shadow: inset 0 2px 4px rgba(15, 23, 42, 0.03);
            transition: all 0.2s var(--ease-expo);
        }
        .input-3d:focus {
            box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.02), 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        /* Responsive Desktop Collapse vs Mobile Drawer */
        @media (min-width: 1024px) {
            body.sidebar-closed #sidebar {
                width: 0 !important;
                transform: translateX(-100%) !important;
                overflow: hidden !important;
                border-right: none !important;
                opacity: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50/70 text-slate-800 antialiased min-h-screen flex selection:bg-blue-600 selection:text-white">

    <!-- Mobile Backdrop Overlay dengan Smooth Opacity Fade -->
    <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-950/70 z-40 opacity-0 pointer-events-none transition-opacity duration-300 ease-out backdrop-blur-xs lg:hidden"></div>

    <!-- Sidebar Kiri Solid Charcoal/Slate-900: Desktop Sidebar + Mobile Slide-over Drawer -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 lg:w-64 bg-slate-900 text-white shrink-0 flex flex-col justify-between border-r border-slate-800/80 h-full lg:h-screen lg:sticky lg:top-0 -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-out shadow-2xl lg:shadow-xl">
        
        <div>
            <!-- Sidebar Header Brand -->
            <div class="h-16 flex items-center justify-between px-5 border-b border-slate-800/80">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 group">
                    <img src="{{ asset('images/wonderful-logo.png') }}" alt="Wonderful" class="w-7 h-7 object-contain transition-transform duration-200 group-hover:scale-105">
                    <span class="text-base font-bold tracking-tight text-white leading-tight">Wonderful</span>
                </a>
                <!-- Tombol Close Drawer Khusus Mobile -->
                <button type="button" onclick="toggleSidebar()" class="lg:hidden p-1.5 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800 transition-colors" title="Tutup Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="p-3.5 space-y-4 overflow-y-auto max-h-[calc(100vh-145px)]">
                
                <!-- Section 1: Operasional Presensi -->
                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5" data-i18n="sb_section_ops">
                        Operasional Presensi
                    </span>

                    <!-- 1. Dashboard Pendaftar -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span data-i18n="sb_menu_dashboard">Dashboard Pendaftar</span>
                    </a>

                    <!-- 2. Scanner Presensi QR -->
                    <a href="{{ route('admin.scan') }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.scan') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.scan') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7V5a2 2 0 012-2h2m10 0h2a2 2 0 012 2v2m0 10v2a2 2 0 01-2 2h-2m-10 0H5a2 2 0 01-2-2v-2m4-5h6" />
                        </svg>
                        <span data-i18n="sb_menu_scanner">Scanner Presensi</span>
                    </a>

                    <!-- 3. Cetak ID Card Lanyard -->
                    <a href="{{ route('admin.participants.id-cards.bulk') }}" 
                       target="_blank"
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.participants.id-cards.bulk') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.participants.id-cards.bulk') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        <span data-i18n="sb_menu_idcard">Cetak ID Card Lanyard</span>
                    </a>
                </div>

                <!-- Section 2: Distribusi WhatsApp -->
                <div class="space-y-1 pt-3 border-t border-slate-800/80">
                    <span class="px-3 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5" data-i18n="sb_section_wa">
                        Distribusi WhatsApp
                    </span>

                    <!-- Kirim Undangan Acara -->
                    <a href="{{ route('admin.invitation') }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.invitation') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.invitation') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span data-i18n="sb_menu_invitation">Kirim Undangan</span>
                    </a>

                    <!-- Kirim Tiket QR Peserta -->
                    <a href="{{ route('admin.tickets') }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.tickets') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.tickets') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        <span data-i18n="sb_menu_tickets">Kirim Tiket QR</span>
                    </a>

                    <!-- Kirim Reminder H-1 / Hari-H (RSVP) -->
                    <a href="{{ route('admin.reminder') }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.reminder') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.reminder') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span data-i18n="sb_menu_reminder">Kirim Reminder</span>
                    </a>
                </div>

                <!-- Section 3: Pengaturan -->
                <div class="space-y-1 pt-3 border-t border-slate-800/80">
                    <span class="px-3 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5" data-i18n="sb_section_settings">
                        Pengaturan
                    </span>

                    <!-- Pengaturan Acara -->
                    <a href="{{ route('admin.event-settings') }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.event-settings') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.event-settings') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span data-i18n="sb_menu_event_settings">Pengaturan Acara</span>
                    </a>

                    <!-- Template & Pengaturan WA & Twilio -->
                    <a href="{{ route('admin.wa-settings') }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.wa-settings') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.wa-settings') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span data-i18n="sb_menu_wa_settings">Pengaturan WA & Twilio</span>
                    </a>
                </div>

                <!-- Section 4: Tautan Eksternal -->
                <div class="pt-3 border-t border-slate-800/80">
                    <span class="px-3 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5" data-i18n="sb_section_external">
                        Tautan Eksternal
                    </span>
                    <a href="{{ route('participants.create') }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="flex items-center justify-between px-3 py-2 text-xs font-semibold text-slate-300 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span data-i18n="sb_menu_public_form">Form Publik</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>

        <!-- Sidebar Footer Status & Logout -->
        <div class="p-3.5 border-t border-slate-800/80 space-y-2.5 bg-slate-950/40">
            <div class="flex items-center gap-2.5 px-1">
                <div class="w-8 h-8 rounded-full bg-blue-600/20 text-blue-400 border border-blue-500/30 flex items-center justify-center font-extrabold text-xs shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="truncate min-w-0">
                    <p class="font-bold text-white truncate text-xs">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email ?? 'admin@clevel.id' }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2 px-3 bg-slate-800/80 hover:bg-rose-950/50 hover:text-rose-300 text-slate-300 text-[11px] font-bold rounded-xl border border-slate-700/60 transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span data-i18n="sb_logout">Keluar (Logout)</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- Content Area Right -->
    <div class="flex-grow flex flex-col min-w-0">
        
        <!-- Topbar Mobile/Desktop with Soft Blur -->
        <header class="bg-white/85 backdrop-blur-md border-b border-slate-200/80 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-30 shadow-2xs">
            
            <!-- Toggle Sidebar & Title -->
            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                <button 
                    type="button" 
                    onclick="toggleSidebar()" 
                    title="Buka / Tutup Sidebar"
                    class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-slate-200 rounded-xl transition-all cursor-pointer flex items-center justify-center shadow-xs shrink-0"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex items-center gap-1.5 min-w-0">
                    <span class="hidden sm:inline text-xs font-semibold text-slate-500 shrink-0" data-i18n="breadcrumb_brand">Wonderful Presensi</span>
                    <span class="hidden sm:inline text-slate-300">/</span>
                    <span class="text-xs font-bold text-slate-900 truncate" data-i18n="page_dashboard">@yield('page_title', 'Admin Dashboard')</span>
                </div>
            </div>

            <!-- Topbar Right Badges -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <div class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-600 font-semibold text-xs rounded-full">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ date('d F Y') }}</span>
                </div>
                <!-- Language Switcher (ID | EN) -->
                <div class="flex items-center p-0.5 bg-slate-100 border border-slate-200 rounded-xl shrink-0">
                    <button type="button" onclick="setAdminLanguage('id')" id="adminLangBtnId" class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all cursor-pointer text-white bg-slate-900 shadow-xs">ID</button>
                    <button type="button" onclick="setAdminLanguage('en')" id="adminLangBtnEn" class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all cursor-pointer text-slate-500 hover:text-slate-900">EN</button>
                </div>

                <a href="{{ route('participants.create') }}" target="_blank" class="btn-3d-dark px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition-all flex items-center gap-1.5 border border-slate-900">
                    <span class="hidden sm:inline" data-i18n="top_form_public">Form Publik</span>
                    <span class="sm:hidden text-[11px]" data-i18n="top_form_public">Form</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" title="Keluar / Logout" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-xl border border-slate-200 transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>

        </header>

        <!-- Main Body -->
        <main class="flex-grow p-3 sm:p-5 lg:p-8 pb-24 lg:pb-8 max-w-full overflow-x-hidden">
            <!-- Global Flash Toast Notification (Plus Jakarta Sans & Rounded-xl) -->
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            html: `
                                <div class="text-left text-xs py-1 px-0.5 font-sans">
                                    <div class="flex items-center gap-2 mb-1 text-emerald-700 font-extrabold text-[11px] uppercase tracking-wider">
                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block shrink-0 shadow-2xs"></span>
                                        <span>SUKSES</span>
                                    </div>
                                    <p class="font-extrabold text-slate-900 text-xs">{{ session('success') }}</p>
                                </div>
                            `,
                            customClass: {
                                popup: 'rounded-xl border border-slate-200 bg-white p-3.5 shadow-xl text-left font-sans'
                            }
                        });
                    });
                </script>
            @endif

            @if(session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3500,
                            timerProgressBar: true,
                            html: `
                                <div class="text-left text-xs py-1 px-0.5 font-sans">
                                    <div class="flex items-center gap-2 mb-1 text-rose-700 font-extrabold text-[11px] uppercase tracking-wider">
                                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500 inline-block shrink-0 shadow-2xs"></span>
                                        <span>PERHATIAN</span>
                                    </div>
                                    <p class="font-extrabold text-slate-900 text-xs">{{ session('error') }}</p>
                                </div>
                            `,
                            customClass: {
                                popup: 'rounded-xl border border-slate-200 bg-white p-3.5 shadow-xl text-left font-sans'
                            }
                        });
                    });
                </script>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white/80 border-t border-slate-200/80 py-3.5 px-6 text-xs text-slate-400 flex items-center justify-between">
            <span>&copy; {{ date('Y') }} Wonderful</span>
            <span>Sistem Presensi Resmi</span>
        </footer>

    </div>

    <!-- Mobile App Bottom Navigation Bar (Khusus Layar HP < 1024px) -->
    <nav class="fixed bottom-0 inset-x-0 z-40 bg-slate-900/95 backdrop-blur-md border-t border-slate-800 text-white lg:hidden h-16 px-1 flex items-center justify-around shadow-2xl">
        
        <!-- Tab 1: Dashboard / Beranda -->
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center flex-1 py-1.5 text-center transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-blue-400 font-bold' : 'text-slate-400 hover:text-slate-200' }}">
            <svg class="w-5 h-5 mb-0.5 {{ request()->routeIs('admin.dashboard') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span class="text-[10px] tracking-tight" data-i18n="mobile_tab_home">Beranda</span>
        </a>

        <!-- Tab 2: Kirim Undangan -->
        <a href="{{ route('admin.invitation') }}" class="flex flex-col items-center justify-center flex-1 py-1.5 text-center transition-colors {{ request()->routeIs('admin.invitation') ? 'text-blue-400 font-bold' : 'text-slate-400 hover:text-slate-200' }}">
            <svg class="w-5 h-5 mb-0.5 {{ request()->routeIs('admin.invitation') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span class="text-[10px] tracking-tight" data-i18n="mobile_tab_invitation">Undangan</span>
        </a>

        <!-- Tab 3: Center Elevated Scanner Button -->
        <a href="{{ route('admin.scan') }}" class="flex flex-col items-center justify-center flex-1 -mt-6 group">
            <div class="w-12 h-12 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white flex items-center justify-center shadow-lg shadow-blue-600/50 border-2 border-slate-900 transition-transform group-active:scale-95">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7V5a2 2 0 012-2h2m10 0h2a2 2 0 012 2v2m0 10v2a2 2 0 01-2 2h-2m-10 0H5a2 2 0 01-2-2v-2m4-5h6" />
                </svg>
            </div>
            <span class="text-[10px] font-bold text-slate-300 mt-1 {{ request()->routeIs('admin.scan') ? 'text-blue-400 font-extrabold' : '' }}" data-i18n="mobile_tab_scan">Scan QR</span>
        </a>

        <!-- Tab 4: Kirim Tiket QR -->
        <a href="{{ route('admin.tickets') }}" class="flex flex-col items-center justify-center flex-1 py-1.5 text-center transition-colors {{ request()->routeIs('admin.tickets') ? 'text-blue-400 font-bold' : 'text-slate-400 hover:text-slate-200' }}">
            <svg class="w-5 h-5 mb-0.5 {{ request()->routeIs('admin.tickets') ? 'text-blue-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
            <span class="text-[10px] tracking-tight" data-i18n="mobile_tab_tickets">Tiket QR</span>
        </a>

        <!-- Tab 5: Menu / Drawer Toggle -->
        <button type="button" onclick="toggleSidebar()" class="flex flex-col items-center justify-center flex-1 py-1.5 text-center text-slate-400 hover:text-slate-200 active:text-blue-400 cursor-pointer transition-colors">
            <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <span class="text-[10px] tracking-tight" data-i18n="mobile_tab_menu">Menu</span>
        </button>

    </nav>

    <!-- Script Global Sidebar Toggle (Mobile Drawer Smooth Slide + Desktop Collapse) -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (window.innerWidth < 1024) {
                // Mobile slide-over drawer
                const isOpen = !sidebar.classList.contains('-translate-x-full');
                if (isOpen) {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.remove('opacity-100', 'pointer-events-auto');
                    backdrop.classList.add('opacity-0', 'pointer-events-none');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('opacity-0', 'pointer-events-none');
                    backdrop.classList.add('opacity-100', 'pointer-events-auto');
                    document.body.classList.add('overflow-hidden');
                }
            } else {
                // Desktop toggle
                document.body.classList.toggle('sidebar-closed');
                const isClosed = document.body.classList.contains('sidebar-closed');
                localStorage.setItem('admin_sidebar_closed', isClosed ? 'true' : 'false');
            }
        }

        // Restore desktop state saat halaman dimuat
        if (window.innerWidth >= 1024 && localStorage.getItem('admin_sidebar_closed') === 'true') {
            document.body.classList.add('sidebar-closed');
        }
    </script>

    <!-- Admin i18n Translation Dictionary & Switcher -->
    <script>
        window.adminTranslations = {
            id: {
                // Topbar & Brand
                top_form_public: "Form Publik",
                breadcrumb_brand: "Wonderful Presensi",
                page_dashboard: "Dashboard Pendaftar",

                // Sidebar Navigation
                sb_section_ops: "Operasional Presensi",
                sb_menu_dashboard: "Dashboard Pendaftar",
                sb_menu_scanner: "Scanner Presensi",
                sb_menu_idcard: "Cetak ID Card Lanyard",
                sb_section_wa: "Distribusi WhatsApp",
                sb_menu_invitation: "Kirim Undangan",
                sb_menu_tickets: "Kirim Tiket QR",
                sb_menu_reminder: "Kirim Reminder",
                sb_section_settings: "Pengaturan",
                sb_menu_event_settings: "Pengaturan Acara",
                sb_menu_wa_settings: "Pengaturan WA & Twilio",
                sb_section_external: "Tautan Eksternal",
                sb_menu_public_form: "Form Publik",
                sb_logout: "Keluar (Logout)",

                // Mobile Bottom Nav
                mobile_tab_home: "Beranda",
                mobile_tab_invitation: "Undangan",
                mobile_tab_scan: "Scan QR",
                mobile_tab_tickets: "Tiket QR",
                mobile_tab_menu: "Menu",

                // Dashboard Buttons & Stats
                btn_print_id_card: "Cetak ID Card",
                btn_export_excel: "Export Excel",
                btn_scanner_qr: "Scanner QR",
                btn_new_participant: "Pendaftar Baru",
                
                stat_total_registered: "Total Pendaftar",
                stat_today: "hari ini",
                stat_official_basis: "Basis pendaftar resmi",
                stat_attended_location: "Hadir di Lokasi",
                stat_of: "dari",
                stat_not_attended_yet: "belum hadir",
                stat_rsvp_status: "Status RSVP",
                stat_rsvp_attending: "Hadir",
                stat_rsvp_declined: "Batal",
                stat_rsvp_pending: "Nunggu",
                stat_from_whatsapp: "Dari RSVP WhatsApp",
                stat_attendance_rate: "Tingkat Hadir",
                stat_total_ratio: "Rasio kehadiran total",
                
                filter_search_placeholder: "Cari nama, instansi, WhatsApp...",
                filter_status_all: "Semua Presensi di Lokasi",
                filter_status_not_attended: "Belum Hadir",
                filter_status_attended: "Sudah Hadir",
                filter_rsvp_all: "Semua Status RSVP",
                filter_rsvp_attending: "Pasti Hadir",
                filter_rsvp_declined: "Berhalangan",
                filter_rsvp_pending: "Belum Respon",
                filter_date_all: "Semua Tanggal",
                filter_date_today: "Daftar Hari Ini",
                btn_search: "Cari",
                
                bulk_selected: "peserta dipilih",
                bulk_delete_btn: "Hapus Terpilih",
                
                th_no: "No",
                th_name: "Nama Lengkap",
                th_company_pos: "Instansi & Jabatan",
                th_whatsapp: "WhatsApp",
                th_attendance_rsvp: "Presensi & RSVP",
                th_action: "Aksi",
                
                action_mark_attendance: "Tandai Hadir",
                action_cancel_attendance: "Batalkan Hadir",
                action_view_ticket: "Lihat Tiket QR",
                action_send_wa_blast: "Kirim WA Blast",
                action_send_wa_web: "Kirim WA Web",
                action_delete: "Hapus Peserta",
                empty_attendees: "Tidak ada data peserta yang cocok dengan filter pencarian."
            },
            en: {
                // Topbar & Brand
                top_form_public: "Public Form",
                breadcrumb_brand: "Wonderful Attendance",
                page_dashboard: "Registrant Dashboard",

                // Sidebar Navigation
                sb_section_ops: "Attendance Operations",
                sb_menu_dashboard: "Registrant Dashboard",
                sb_menu_scanner: "Attendance Scanner",
                sb_menu_idcard: "Print Lanyard ID Card",
                sb_section_wa: "WhatsApp Distribution",
                sb_menu_invitation: "Send Invitations",
                sb_menu_tickets: "Send QR Tickets",
                sb_menu_reminder: "Send Reminders",
                sb_section_settings: "Settings",
                sb_menu_event_settings: "Event Settings",
                sb_menu_wa_settings: "WA & Twilio Settings",
                sb_section_external: "External Links",
                sb_menu_public_form: "Public Form",
                sb_logout: "Logout",

                // Mobile Bottom Nav
                mobile_tab_home: "Home",
                mobile_tab_invitation: "Invitations",
                mobile_tab_scan: "Scan QR",
                mobile_tab_tickets: "QR Tickets",
                mobile_tab_menu: "Menu",

                // Dashboard Buttons & Stats
                btn_print_id_card: "Print ID Cards",
                btn_export_excel: "Export Excel",
                btn_scanner_qr: "QR Scanner",
                btn_new_participant: "New Registrant",
                
                stat_total_registered: "Total Registrants",
                stat_today: "today",
                stat_official_basis: "Official registration base",
                stat_attended_location: "Present On-Site",
                stat_of: "of",
                stat_not_attended_yet: "not attended yet",
                stat_rsvp_status: "RSVP Status",
                stat_rsvp_attending: "Attending",
                stat_rsvp_declined: "Declined",
                stat_rsvp_pending: "Pending",
                stat_from_whatsapp: "From WhatsApp RSVP",
                stat_attendance_rate: "Attendance Rate",
                stat_total_ratio: "Total attendance ratio",
                
                filter_search_placeholder: "Search name, institution, WhatsApp...",
                filter_status_all: "All On-Site Attendance",
                filter_status_not_attended: "Not Attended Yet",
                filter_status_attended: "Attended",
                filter_rsvp_all: "All RSVP Statuses",
                filter_rsvp_attending: "Will Attend",
                filter_rsvp_declined: "Cannot Attend",
                filter_rsvp_pending: "Awaiting Response",
                filter_date_all: "All Dates",
                filter_date_today: "Registered Today",
                btn_search: "Search",
                
                bulk_selected: "participants selected",
                bulk_delete_btn: "Delete Selected",
                
                th_no: "No",
                th_name: "Full Name",
                th_company_pos: "Company & Position",
                th_whatsapp: "WhatsApp",
                th_attendance_rsvp: "Attendance & RSVP",
                th_action: "Action",
                
                action_mark_attendance: "Mark Present",
                action_cancel_attendance: "Cancel Attendance",
                action_view_ticket: "View QR Ticket",
                action_send_wa_blast: "Send WA Blast",
                action_send_wa_web: "Send WA Web",
                action_delete: "Delete Participant",
                empty_attendees: "No participant data matches the search filter."
            }
        };

        window.currentAdminLang = localStorage.getItem('admin_lang') || localStorage.getItem('app_lang') || 'id';

        function setAdminLanguage(lang) {
            window.currentAdminLang = lang;
            localStorage.setItem('admin_lang', lang);
            localStorage.setItem('app_lang', lang);
            applyAdminLanguage(lang);
        }

        function applyAdminLanguage(lang) {
            const dict = window.adminTranslations[lang] || window.adminTranslations.id;
            
            // Update button styles
            const btnId = document.getElementById('adminLangBtnId');
            const btnEn = document.getElementById('adminLangBtnEn');
            if (btnId && btnEn) {
                if (lang === 'en') {
                    btnEn.className = "px-2.5 py-1 rounded-lg text-xs font-bold transition-all cursor-pointer text-white bg-slate-900 shadow-xs";
                    btnId.className = "px-2.5 py-1 rounded-lg text-xs font-bold transition-all cursor-pointer text-slate-500 hover:text-slate-900";
                } else {
                    btnId.className = "px-2.5 py-1 rounded-lg text-xs font-bold transition-all cursor-pointer text-white bg-slate-900 shadow-xs";
                    btnEn.className = "px-2.5 py-1 rounded-lg text-xs font-bold transition-all cursor-pointer text-slate-500 hover:text-slate-900";
                }
            }

            // Translate elements with data-i18n
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (dict[key]) {
                    el.innerText = dict[key];
                }
            });

            // Translate placeholders
            document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                const key = el.getAttribute('data-i18n-placeholder');
                if (dict[key]) {
                    el.setAttribute('placeholder', dict[key]);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            applyAdminLanguage(window.currentAdminLang);
        });
    </script>

    @stack('scripts')
</body>
</html>
