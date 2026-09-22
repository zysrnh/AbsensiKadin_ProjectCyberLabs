<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Absensi QR Kadin 2026')</title>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- QRCode JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        /* Custom solid flat styling overrides */
        body {
            background-color: #f1f5f9;
            color: #0f172a;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen flex flex-col">

    <!-- Navbar Flat Solid -->
    <nav class="bg-slate-900 text-white border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand / Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-700 text-white font-bold flex items-center justify-center text-sm rounded-none">
                            KD
                        </div>
                        <span class="font-bold text-base tracking-wide text-white uppercase">
                            Absensi Kadin 2026
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <a href="{{ route('participants.create') }}" 
                       class="px-3 py-2 text-xs sm:text-sm font-semibold border {{ request()->routeIs('participants.create') || request()->routeIs('home') ? 'bg-blue-700 border-blue-600 text-white' : 'border-slate-700 text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-none transition">
                        Form Daftar
                    </a>
                    <a href="{{ route('participants.index') }}" 
                       class="px-3 py-2 text-xs sm:text-sm font-semibold border {{ request()->routeIs('participants.index') ? 'bg-blue-700 border-blue-600 text-white' : 'border-slate-700 text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-none transition">
                        Data Peserta & WA Blast
                    </a>
                    <a href="{{ route('participants.scan') }}" 
                       class="px-3 py-2 text-xs sm:text-sm font-semibold border {{ request()->routeIs('participants.scan') ? 'bg-blue-700 border-blue-600 text-white' : 'border-slate-700 text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-none transition">
                        Scanner Absensi
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8 max-w-7xl w-full mx-auto">
        <!-- Flash Message Alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-100 border border-emerald-400 text-emerald-900 text-sm font-medium rounded-none flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="mb-6 p-4 bg-rose-100 border border-rose-400 text-rose-900 text-sm font-medium rounded-none flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-rose-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    <!-- Footer Flat -->
    <footer class="bg-white border-t border-slate-300 py-4 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
            <span>&copy; {{ date('Y') }} Kamar Dagang dan Industri (KADIN) Indonesia.</span>
            <span class="mt-2 sm:mt-0 font-medium text-slate-600">Sistem Absensi & Registrasi QR Code</span>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
