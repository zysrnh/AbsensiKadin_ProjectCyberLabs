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

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Admin Header Bar Clean Solid Flat -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-2xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14">
                
                <!-- Left: Admin Brand -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2.5">
                        <span class="px-2 py-0.5 bg-slate-900 text-white font-extrabold text-xs tracking-wider rounded-sm">
                            KADIN
                        </span>
                        <div class="flex items-center gap-1.5">
                            <span class="font-bold text-sm text-slate-900 tracking-tight">Admin Presensi</span>
                            <span class="px-1.5 py-0.2 bg-slate-100 border border-slate-200 text-[10px] font-bold text-slate-600 rounded-sm">
                                2026
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Center: Navigation Tabs -->
                <nav class="flex items-center space-x-1 sm:space-x-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-3 py-1.5 text-xs font-semibold rounded-sm transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Dashboard Pendaftar
                    </a>
                    <a href="{{ route('admin.scan') }}" 
                       class="px-3 py-1.5 text-xs font-semibold rounded-sm transition-colors {{ request()->routeIs('admin.scan') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Scanner Presensi
                    </a>
                </nav>

                <!-- Right: External Link to Public Form -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('participants.create') }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-sm border border-slate-200 transition-colors"
                       title="Buka form pendaftaran publik di tab baru">
                        <span>Form Publik</span>
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8 max-w-7xl w-full mx-auto">
        <!-- Flash Alert Message -->
        @if(session('success'))
            <div class="mb-6 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium rounded-sm flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 font-bold ml-4">
                    ✕
                </button>
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
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 hover:text-rose-900 font-bold ml-4">
                    ✕
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer Simple Flat -->
    <footer class="bg-white border-t border-slate-200 py-3 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400">
            <span>&copy; {{ date('Y') }} KADIN Indonesia &bull; Panel Administrator</span>
            <span class="mt-1 sm:mt-0">Sistem Presensi & QR Code Scanner</span>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
