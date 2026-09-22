<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pendaftaran Peserta - Kadin 2026')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- Clean Public Header: Formal KADIN Identity Only (No Internal Admin Links) -->
    <header class="bg-white border-b border-slate-200 py-3.5 px-4 sm:px-6">
        <div class="max-w-xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-2.5">
                <span class="px-2 py-0.5 bg-slate-900 text-white font-extrabold text-xs tracking-wider rounded-sm">
                    KADIN
                </span>
                <div class="leading-none">
                    <span class="font-bold text-xs sm:text-sm text-slate-900 tracking-tight block">Kamar Dagang dan Industri Indonesia</span>
                    <span class="text-[10px] text-slate-500 font-medium">Sistem Registrasi & Presensi 2026</span>
                </div>
            </div>
            <div class="hidden sm:block">
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider bg-slate-100 px-2 py-1 rounded-sm border border-slate-200">
                    Formulir Resmi
                </span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center py-8">
        @yield('content')
    </main>

    <!-- Footer Simple -->
    <footer class="bg-white border-t border-slate-200 py-4">
        <div class="max-w-xl mx-auto px-4 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} KADIN Indonesia. Seluruh hak cipta dilindungi.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
