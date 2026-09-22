<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Absensi Kadin')</title>

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

    <!-- Top Navbar: Clean, Minimal, White Bar with Subtle Border -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14">
                
                <!-- Brand / Logo Minimalist Formal -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2.5">
                    <span class="px-2 py-0.5 bg-slate-900 text-white font-extrabold text-xs tracking-wider rounded-sm">
                        KADIN
                    </span>
                    <span class="font-bold text-sm text-slate-900 tracking-tight">
                        Absensi 2026
                    </span>
                </a>

                <!-- Navigation Tabs Clean -->
                <nav class="flex items-center space-x-1 sm:space-x-2">
                    <a href="{{ route('participants.create') }}" 
                       class="px-3 py-1.5 text-xs font-semibold rounded-sm transition-colors {{ request()->routeIs('participants.create') || request()->routeIs('home') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Form Daftar
                    </a>
                    <a href="{{ route('participants.index') }}" 
                       class="px-3 py-1.5 text-xs font-semibold rounded-sm transition-colors {{ request()->routeIs('participants.index') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Data Peserta & WA
                    </a>
                    <a href="{{ route('participants.scan') }}" 
                       class="px-3 py-1.5 text-xs font-semibold rounded-sm transition-colors {{ request()->routeIs('participants.scan') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Scanner QR
                    </a>
                </nav>

            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Simple Flat -->
    <footer class="bg-white border-t border-slate-200 py-4 mt-auto">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
            <span>&copy; {{ date('Y') }} Kamar Dagang dan Industri (KADIN) Indonesia</span>
            <span class="mt-1 sm:mt-0 text-slate-400">Sistem Registrasi & Tiket Absensi QR</span>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
