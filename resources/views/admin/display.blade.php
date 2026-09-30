<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Layar Sambutan TV - Musyawarah & Temu Bisnis C LEVEL 2026</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            800: '#0f172a',
                            900: '#0b1329',
                            950: '#060a17',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            overflow: hidden;
            user-select: none;
        }

        /* Subtle Light Grid Pattern */
        .bg-grid-pattern {
            background-size: 40px 40px;
            background-image: 
                linear-gradient(to right, rgba(15, 23, 42, 0.035) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(15, 23, 42, 0.035) 1px, transparent 1px);
        }

        /* Floating Stars Animation (Bottom to Top) */
        @keyframes floatStar {
            0% {
                transform: translateY(0) rotate(0deg) scale(0.6);
                opacity: 0;
            }
            10% {
                opacity: var(--star-opacity, 0.45);
            }
            90% {
                opacity: var(--star-opacity, 0.45);
            }
            100% {
                transform: translateY(-118vh) rotate(180deg) scale(1.1);
                opacity: 0;
            }
        }

        .star-particle {
            position: absolute;
            bottom: -50px;
            animation: floatStar var(--duration, 14s) linear infinite;
            animation-delay: var(--delay, 0s);
            will-change: transform, opacity;
            pointer-events: none;
        }

        /* Welcome Card Animation */
        @keyframes popupZoomIn {
            0% {
                opacity: 0;
                transform: scale(0.92) translateY(15px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .animate-welcome-card {
            animation: popupZoomIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="h-full bg-slate-50 text-slate-900 flex flex-col justify-between relative bg-grid-pattern">

    <!-- Floating Star Particles Background (Bintang 4 Sudut dari Bawah ke Atas) -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <!-- Partikel Bintang 1 -->
        <div class="star-particle text-blue-500" style="left: 4%; --duration: 16s; --delay: -3s; --star-opacity: 0.4;">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
        </div>
        <!-- Partikel Bintang 2 -->
        <div class="star-particle text-sky-400" style="left: 12%; --duration: 12s; --delay: -9s; --star-opacity: 0.55;">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
        </div>
        <!-- Partikel Bintang 3 -->
        <div class="star-particle text-blue-600" style="left: 19%; --duration: 19s; --delay: -14s; --star-opacity: 0.35;">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
        </div>
        <!-- Partikel Bintang 4 -->
        <div class="star-particle text-blue-400" style="left: 28%; --duration: 14s; --delay: -5s; --star-opacity: 0.5;">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
        </div>
        <!-- Partikel Bintang 5 -->
        <div class="star-particle text-sky-500" style="left: 36%; --duration: 17s; --delay: -11s; --star-opacity: 0.4;">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
        </div>
        <!-- Partikel Bintang 6 -->
        <div class="star-particle text-blue-500" style="left: 45%; --duration: 13s; --delay: -2s; --star-opacity: 0.45;">
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
        </div>
        <!-- Partikel Bintang 7 -->
        <div class="star-particle text-indigo-400" style="left: 54%; --duration: 18s; --delay: -8s; --star-opacity: 0.4;">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
        </div>
        <!-- Partikel Bintang 8 -->
        <div class="star-particle text-blue-400" style="left: 63%; --duration: 15s; --delay: -13s; --star-opacity: 0.55;">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
        </div>
        <!-- Partikel Bintang 9 -->
        <div class="star-particle text-sky-400" style="left: 72%; --duration: 14s; --delay: -4s; --star-opacity: 0.45;">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
        </div>
        <!-- Partikel Bintang 10 -->
        <div class="star-particle text-blue-600" style="left: 81%; --duration: 16s; --delay: -10s; --star-opacity: 0.4;">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
        </div>
        <!-- Partikel Bintang 11 -->
        <div class="star-particle text-blue-500" style="left: 90%; --duration: 13s; --delay: -1s; --star-opacity: 0.5;">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
        </div>
        <!-- Partikel Bintang 12 -->
        <div class="star-particle text-sky-500" style="left: 96%; --duration: 18s; --delay: -7s; --star-opacity: 0.35;">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
        </div>
    </div>

    <!-- Top Bar: Header & Live Clock -->
    <header class="relative z-10 px-8 py-5 flex items-center justify-between border-b border-slate-200/80 backdrop-blur-md bg-white/80">
        <!-- Logo C Level -->
        <div class="flex items-center gap-4">
            <div class="px-3.5 py-1.5 bg-blue-600 text-white font-bold text-sm tracking-wider rounded-lg flex items-center gap-2">
                <span>C LEVEL</span>
                <span class="w-1.5 h-1.5 rounded-full bg-white/80"></span>
            </div>
        </div>

        <!-- Live Digital Clock & Actions -->
        <div class="flex items-center gap-6">
            <!-- Jam Digital Real-time -->
            <div class="text-right">
                <div id="live-clock" class="text-xl font-bold font-mono tracking-tight text-slate-900">00:00:00</div>
                <div id="live-date" class="text-xs font-medium text-slate-500">Memuat tanggal...</div>
            </div>

            <!-- Fullscreen & Audio Controls -->
            <div class="flex items-center gap-2 pl-2 border-l border-slate-200">
                <button type="button" id="btn-audio" onclick="toggleAudio()" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 rounded-lg transition-colors cursor-pointer border border-slate-200" title="Suara Sambutan">
                    <svg id="icon-sound-on" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                    </svg>
                    <svg id="icon-sound-off" class="w-4 h-4 hidden text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
                    </svg>
                </button>

                <button type="button" onclick="toggleFullscreen()" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 rounded-lg transition-colors cursor-pointer border border-slate-200" title="Layar Penuh (F11)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Area: In-Place Typography Stage (Tanpa Pop-up Card) -->
    <main class="relative z-10 flex-grow flex items-center justify-center p-8 text-center select-none">

        <div class="relative w-full max-w-5xl mx-auto flex items-center justify-center min-h-[360px]">

            <!-- 1. Standby Hero Typography (Tampil Default) -->
            <div id="standby-screen" class="space-y-4 transition-all duration-700 ease-out transform opacity-100 translate-y-0">
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-bold text-slate-900 tracking-tight leading-tight">
                    Selamat Datang di <br>
                    <span class="text-slate-900 font-extrabold">C LEVEL INDONESIA 2026</span>
                </h1>

                <p class="text-base sm:text-xl text-slate-500 max-w-2xl mx-auto font-normal leading-relaxed pt-2">
                    Silakan arahkan tiket QR Anda pada meja registrasi. Layar ini akan otomatis menampilkan verifikasi kehadiran secara real-time.
                </p>
            </div>

            <!-- 2. Guest Welcome Typography (In-Place Reveal saat Scan) -->
            <div id="welcome-screen" class="hidden absolute inset-0 flex flex-col items-center justify-center space-y-4 sm:space-y-6 transition-all duration-700 ease-out transform opacity-0 translate-y-8">
                <!-- Sambutan -->
                <p class="text-sm sm:text-lg font-semibold tracking-widest text-slate-400 uppercase">
                    Selamat Datang Yang Terhormat
                </p>

                <!-- Nama Tamu Raksasa & Elegan -->
                <h2 id="guest-name" class="text-4xl sm:text-6xl lg:text-7xl font-extrabold text-slate-900 tracking-tight leading-tight max-w-5xl px-4">
                    Nama Peserta
                </h2>

                <!-- Instansi & Jabatan -->
                <div class="pt-2 flex flex-wrap items-center justify-center gap-2 sm:gap-4 text-xl sm:text-3xl font-semibold">
                    <span id="guest-company" class="text-blue-600">
                        Perusahaan / Instansi
                    </span>
                    <span id="company-divider" class="text-slate-300">•</span>
                    <span id="guest-position" class="text-slate-500 font-normal">
                        Jabatan
                    </span>
                </div>
            </div>

        </div>

    </main>

    <!-- Audio Chime Synthesizer & Polling Script -->
    <script>
        let isAudioEnabled = true;
        let lastAttendedTime = '{{ $recentAttended->first() && $recentAttended->first()->attended_at ? $recentAttended->first()->attended_at->toIso8601String() : now()->toIso8601String() }}';
        let welcomeTimeout = null;

        // Digital Clock Live
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('live-clock').innerText = `${hours}:${minutes}:${seconds}`;

            const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            document.getElementById('live-date').innerText = now.toLocaleDateString('id-ID', options);
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Audio Chime Synthesizer via Web Audio API (Tanpa file eksternal)
        function playChimeSound() {
            if (!isAudioEnabled) return;
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const now = ctx.currentTime;

                // Nada 1: C5 (523.25 Hz)
                const osc1 = ctx.createOscillator();
                const gain1 = ctx.createGain();
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(523.25, now);
                gain1.gain.setValueAtTime(0.15, now);
                gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.8);
                osc1.connect(gain1);
                gain1.connect(ctx.destination);
                osc1.start(now);
                osc1.stop(now + 0.8);

                // Nada 2: E5 (659.25 Hz)
                const osc2 = ctx.createOscillator();
                const gain2 = ctx.createGain();
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(659.25, now + 0.12);
                gain2.gain.setValueAtTime(0.2, now + 0.12);
                gain2.gain.exponentialRampToValueAtTime(0.001, now + 1.2);
                osc2.connect(gain2);
                gain2.connect(ctx.destination);
                osc2.start(now + 0.12);
                osc2.stop(now + 1.2);

                // Nada 3: G5 (783.99 Hz)
                const osc3 = ctx.createOscillator();
                const gain3 = ctx.createGain();
                osc3.type = 'sine';
                osc3.frequency.setValueAtTime(783.99, now + 0.25);
                gain3.gain.setValueAtTime(0.25, now + 0.25);
                gain3.gain.exponentialRampToValueAtTime(0.001, now + 1.8);
                osc3.connect(gain3);
                gain3.connect(ctx.destination);
                osc3.start(now + 0.25);
                osc3.stop(now + 1.8);

            } catch (e) {
                console.warn('Audio Context error:', e);
            }
        }

        function toggleAudio() {
            isAudioEnabled = !isAudioEnabled;
            document.getElementById('icon-sound-on').classList.toggle('hidden', !isAudioEnabled);
            document.getElementById('icon-sound-off').classList.toggle('hidden', isAudioEnabled);
            if (isAudioEnabled) playChimeSound();
        }

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => alert(err.message));
            } else {
                if (document.exitFullscreen) document.exitFullscreen();
            }
        }

        // Tampilkan Sambutan Tamu (In-Place Typography Morph)
        function showWelcomeModal(guest) {
            const standby = document.getElementById('standby-screen');
            const welcome = document.getElementById('welcome-screen');
            const nameEl = document.getElementById('guest-name');
            const compEl = document.getElementById('guest-company');
            const posEl = document.getElementById('guest-position');
            const divider = document.getElementById('company-divider');

            nameEl.innerText = guest.name;
            compEl.innerText = guest.company || 'C-Level Indonesia';

            if (guest.position && guest.position !== '-') {
                posEl.innerText = guest.position;
                posEl.classList.remove('hidden');
                if (divider) divider.classList.remove('hidden');
            } else {
                posEl.classList.add('hidden');
                if (divider) divider.classList.add('hidden');
            }

            // Bunyikan nada sambutan
            playChimeSound();

            // 1. Standby keluar dengan fade & slide naik
            standby.classList.add('opacity-0', '-translate-y-6', 'pointer-events-none');

            // 2. Welcome masuk dengan smooth slide & fade in
            welcome.classList.remove('hidden');
            void welcome.offsetWidth; // Trigger reflow
            welcome.classList.remove('opacity-0', 'translate-y-8');
            welcome.classList.add('opacity-100', 'translate-y-0');

            // 3. Reset Timer: Otomatis kembali ke Standby setelah 7 detik
            clearTimeout(welcomeTimeout);
            welcomeTimeout = setTimeout(() => {
                // Welcome keluar
                welcome.classList.remove('opacity-100', 'translate-y-0');
                welcome.classList.add('opacity-0', 'translate-y-8');

                setTimeout(() => {
                    welcome.classList.add('hidden');
                    // Standby masuk kembali
                    standby.classList.remove('opacity-0', '-translate-y-6', 'pointer-events-none');
                    standby.classList.add('opacity-100', 'translate-y-0');
                }, 500);
            }, 7000);
        }

        function escapeHtml(text) {
            if (!text) return '';
            return text.replace(/[&<>"']/g, function(m) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
            });
        }

        // Real-time Polling Background Loop (Setiap 1.2 Detik)
        function pollLatestCheckin() {
            const url = `{{ route('admin.display.latest') }}?last_time=${encodeURIComponent(lastAttendedTime)}`;

            fetch(url, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                // Update statistik counter jika ada di DOM
                if (data.stats) {
                    const elAttended = document.getElementById('stat-attended');
                    const elTotal = document.getElementById('stat-total');
                    if (elAttended) elAttended.innerText = Number(data.stats.attended).toLocaleString('id-ID');
                    if (elTotal) elTotal.innerText = Number(data.stats.total).toLocaleString('id-ID');
                }

                if (data.has_new && data.participant) {
                    lastAttendedTime = data.participant.attended_at_raw;
                    showWelcomeModal(data.participant);
                }
            })
            .catch(err => {
                console.warn('Poll error:', err);
            })
            .finally(() => {
                setTimeout(pollLatestCheckin, 1200);
            });
        }

        // Mulai Polling saat halaman siap
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(pollLatestCheckin, 1000);
        });
    </script>
</body>
</html>
