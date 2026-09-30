<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Absensi C Level 2026')</title>

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

        #sidebar {
            transition: margin-left 0.25s var(--ease-expo);
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
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50/70 text-slate-800 antialiased min-h-screen flex selection:bg-blue-600 selection:text-white">

    <!-- Sidebar Kiri Solid Charcoal/Slate-900 Modern Smooth -->
    <aside id="sidebar" class="w-64 bg-slate-900 text-white shrink-0 flex flex-col justify-between border-r border-slate-800/80 min-h-screen sticky top-0 h-screen z-40 shadow-xl">
        
        <div>
            <!-- Sidebar Header Brand -->
            <div class="h-16 flex items-center px-5 border-b border-slate-800/80 gap-3">
                <span class="px-2.5 py-1 bg-blue-600 text-white font-black text-xs tracking-wider rounded-lg shadow-sm flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                    <span>C LEVEL</span>
                </span>
                <div>
                    <h1 class="text-sm font-bold tracking-tight text-white leading-tight">Presensi 2026</h1>
                    <span class="text-[10px] text-slate-400 font-medium flex items-center gap-1">
                        <span class="w-1 h-1 rounded-full bg-emerald-400"></span>
                        <span>Panel Administrator</span>
                    </span>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="p-3.5 space-y-4 overflow-y-auto max-h-[calc(100vh-145px)]">
                
                <!-- Section 1: Operasional Presensi -->
                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5">
                        Operasional Presensi
                    </span>

                    <!-- 1. Dashboard Pendaftar -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span>Dashboard Pendaftar</span>
                    </a>

                    <!-- 2. Scanner Presensi QR -->
                    <a href="{{ route('admin.scan') }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.scan') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.scan') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7V5a2 2 0 012-2h2m10 0h2a2 2 0 012 2v2m0 10v2a2 2 0 01-2 2h-2m-10 0H5a2 2 0 01-2-2v-2m4-5h6" />
                        </svg>
                        <span>Scanner Presensi</span>
                    </a>

                    <!-- 3. Cetak ID Card Lanyard -->
                    <a href="{{ route('admin.participants.id-cards.bulk') }}" 
                       target="_blank"
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.participants.id-cards.bulk') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.participants.id-cards.bulk') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        <span>Cetak ID Card Lanyard</span>
                    </a>
                </div>

                <!-- Section 2: Distribusi WhatsApp -->
                <div class="space-y-1 pt-3 border-t border-slate-800/80">
                    <span class="px-3 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5">
                        Distribusi WhatsApp
                    </span>

                    <!-- Kirim Undangan Acara -->
                    <a href="{{ route('admin.invitation') }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.invitation') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.invitation') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>Kirim Undangan</span>
                    </a>

                    <!-- Kirim Tiket QR Peserta -->
                    <a href="{{ route('admin.tickets') }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.tickets') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.tickets') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        <span>Kirim Tiket QR</span>
                    </a>

                    <!-- Kirim Reminder H-1 / Hari-H (RSVP) -->
                    <a href="{{ route('admin.reminder') }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.reminder') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.reminder') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span>Kirim Reminder</span>
                    </a>
                </div>

                <!-- Section 3: Pengaturan -->
                <div class="space-y-1 pt-3 border-t border-slate-800/80">
                    <span class="px-3 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5">
                        Pengaturan
                    </span>

                    <!-- Pengaturan Acara -->
                    <a href="{{ route('admin.event-settings') }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.event-settings') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.event-settings') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Pengaturan Acara</span>
                    </a>

                    <!-- Template & Pengaturan WA & Twilio -->
                    <a href="{{ route('admin.wa-settings') }}" 
                       class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition-all {{ request()->routeIs('admin.wa-settings') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.wa-settings') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span>Pengaturan WA & Twilio</span>
                    </a>
                </div>

                <!-- Section 4: Tautan Eksternal -->
                <div class="pt-3 border-t border-slate-800/80">
                    <span class="px-3 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5">
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
                            <span>Form Publik</span>
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
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- Content Area Right -->
    <div class="flex-grow flex flex-col min-w-0">
        
        <!-- Topbar Mobile/Desktop with Soft Blur -->
        <header class="bg-white/85 backdrop-blur-md border-b border-slate-200/80 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-30 shadow-2xs">
            
            <!-- Toggle Sidebar & Title -->
            <div class="flex items-center gap-3">
                <button 
                    type="button" 
                    onclick="toggleSidebar()" 
                    title="Buka / Tutup Sidebar"
                    class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-slate-200 rounded-xl transition-all cursor-pointer flex items-center justify-center shadow-xs"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-500">C Level Presensi</span>
                    <span class="text-slate-300">/</span>
                    <span class="text-xs font-bold text-slate-900">@yield('page_title', 'Admin Dashboard')</span>
                </div>
            </div>

            <!-- Topbar Right Badges -->
            <div class="flex items-center gap-3">
                <div class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-600 font-semibold text-xs rounded-full">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ date('d F Y') }}</span>
                </div>
                <a href="{{ route('participants.create') }}" target="_blank" class="btn-3d-dark px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition-all flex items-center gap-1.5 border border-slate-900">
                    <span>+ Form Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
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
        <main class="flex-grow p-4 sm:p-6 lg:p-8">
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
            <span>&copy; {{ date('Y') }} C LEVEL Indonesia</span>
            <span>Sistem Presensi Resmi</span>
        </footer>

    </div>

    <!-- Script Global Sidebar Toggle -->
    <script>
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-closed');
            const isClosed = document.body.classList.contains('sidebar-closed');
            localStorage.setItem('admin_sidebar_closed', isClosed ? 'true' : 'false');
        }

        // Restore state saat halaman dimuat
        if (localStorage.getItem('admin_sidebar_closed') === 'true') {
            document.body.classList.add('sidebar-closed');
        }
    </script>

    @stack('scripts')
</body>
</html>
