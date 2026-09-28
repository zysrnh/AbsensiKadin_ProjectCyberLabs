<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Absensi Kadin 2026')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        #sidebar {
            transition: margin-left 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        body.sidebar-closed #sidebar {
            margin-left: -16rem !important;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex">

    <!-- Sidebar Kiri Solid Charcoal/Slate-900 (Flat Formal) -->
    <aside id="sidebar" class="w-64 bg-slate-900 text-white shrink-0 flex flex-col justify-between border-r border-slate-800 min-h-screen sticky top-0 h-screen z-40">
        
        <div>
            <!-- Sidebar Header Brand -->
            <div class="h-16 flex items-center px-6 border-b border-slate-800 gap-2.5">
                <span class="px-2 py-0.5 bg-blue-600 text-white font-black text-xs tracking-wider rounded-sm">
                    KADIN
                </span>
                <div>
                    <h1 class="text-sm font-bold tracking-tight text-white leading-none">Presensi 2026</h1>
                    <span class="text-[10px] text-slate-400 font-medium">Panel Administrator</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="p-4 space-y-1">
                <span class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">
                    Menu Utama
                </span>

                <!-- 1. Dashboard Pendaftar -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-sm transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span>Dashboard Pendaftar</span>
                </a>

                <!-- 2. Kirim Undangan Acara -->
                <a href="{{ route('admin.invitation') }}" 
                   class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-sm transition-colors {{ request()->routeIs('admin.invitation') ? 'bg-blue-600 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.invitation') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>Kirim Undangan</span>
                </a>

                <!-- 3. Kirim Tiket QR Peserta -->
                <a href="{{ route('admin.tickets') }}" 
                   class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-sm transition-colors {{ request()->routeIs('admin.tickets') ? 'bg-blue-600 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.tickets') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    <span>Kirim Tiket QR</span>
                </a>

                <!-- 4. Kirim Reminder H-1 / Hari-H (RSVP Yes/No) -->
                <a href="{{ route('admin.reminder') }}" 
                   class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-sm transition-colors {{ request()->routeIs('admin.reminder') ? 'bg-blue-600 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.reminder') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span>Kirim Reminder</span>
                </a>

                <!-- 4. Template & Pengaturan WA -->
                <a href="{{ route('admin.wa-settings') }}" 
                   class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-sm transition-colors {{ request()->routeIs('admin.wa-settings') ? 'bg-blue-600 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.wa-settings') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span>Pengaturan WA & Twilio</span>
                </a>

                <!-- 3. Scanner Presensi QR -->
                <a href="{{ route('admin.scan') }}" 
                   class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-sm transition-colors {{ request()->routeIs('admin.scan') ? 'bg-blue-600 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.scan') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    <span>Scanner Presensi</span>
                </a>

                <!-- 4. Pengaturan Acara (Luma Event Landing) -->
                <a href="{{ route('admin.event-settings') }}" 
                   class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-sm transition-colors {{ request()->routeIs('admin.event-settings') ? 'bg-blue-600 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.event-settings') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <span>Pengaturan Acara</span>
                </a>

                <!-- Separator -->
                <div class="pt-4 mt-4 border-t border-slate-800">
                    <span class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">
                        Tautan Eksternal
                    </span>
                    <a href="{{ route('participants.create') }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="flex items-center justify-between px-3 py-2 text-xs font-semibold text-slate-300 hover:bg-slate-800 hover:text-white rounded-sm transition-colors">
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
        <div class="p-4 border-t border-slate-800 space-y-2.5">
            <div class="flex items-center justify-between text-xs">
                <div class="truncate">
                    <p class="font-semibold text-white truncate text-xs">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email ?? 'admin@kadin.id' }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-1.5 px-2 bg-slate-800 hover:bg-rose-950/60 hover:text-rose-400 text-slate-300 text-[11px] font-semibold rounded-sm border border-slate-700 transition-colors flex items-center justify-center gap-1.5 cursor-pointer">
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
        
        <!-- Topbar Mobile/Desktop -->
        <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-30 shadow-2xs">
            
            <!-- Toggle Sidebar & Title -->
            <div class="flex items-center gap-3">
                <button 
                    type="button" 
                    onclick="toggleSidebar()" 
                    title="Buka / Tutup Sidebar"
                    class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-slate-200 rounded-sm transition-colors cursor-pointer flex items-center justify-center shadow-2xs"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-500">KADIN Presensi</span>
                    <span class="text-slate-300">/</span>
                    <span class="text-xs font-bold text-slate-800">@yield('page_title', 'Admin Dashboard')</span>
                </div>
            </div>

            <!-- Topbar Right Badges -->
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-500 font-medium hidden sm:inline-block">
                    {{ date('d F Y') }}
                </span>
                <a href="{{ route('participants.create') }}" target="_blank" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors flex items-center gap-1.5 shadow-2xs">
                    <span>+ Form Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" title="Keluar / Logout" class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-slate-100 rounded-sm border border-slate-200 transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>

        </header>

        <!-- Main Body -->
        <main class="flex-grow p-4 sm:p-6 lg:p-8">
            <!-- Flash Alert -->
            @if(session('success'))
                <div class="mb-6 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium rounded-sm flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 font-bold ml-4">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium rounded-sm flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 hover:text-rose-900 font-bold ml-4">✕</button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-3 px-6 text-xs text-slate-400 flex items-center justify-between">
            <span>&copy; {{ date('Y') }} Kamar Dagang dan Industri (KADIN) Indonesia</span>
            <span>Versi Presensi 1.0</span>
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
