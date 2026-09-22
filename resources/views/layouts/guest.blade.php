<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pendaftaran Peserta - KADIN')</title>

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

    <!-- Clean Public Header: KADIN Saja -->
    <header class="bg-white border-b border-slate-200 py-3.5 px-4 sm:px-6">
        <div class="max-w-xl mx-auto flex items-center justify-center">
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 bg-slate-900 text-white font-black text-sm tracking-widest rounded-sm">
                    KADIN
                </span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center py-8">
        @yield('content')
    </main>

    <!-- Footer Simple -->
    <footer class="bg-white border-t border-slate-200 py-3.5">
        <div class="max-w-xl mx-auto px-4 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} KADIN. Hak Cipta Dilindungi.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
