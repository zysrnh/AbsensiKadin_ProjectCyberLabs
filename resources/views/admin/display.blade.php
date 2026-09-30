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
            background-color: #060a17;
            color: #ffffff;
            overflow: hidden;
            user-select: none;
        }

        /* Ambient Glow & Grid */
        .bg-grid-pattern {
            background-size: 40px 40px;
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        }

        /* Welcome Card Animation */
        @keyframes popupZoomIn {
            0% {
                opacity: 0;
                transform: scale(0.85) translateY(20px);
            }
            70% {
                transform: scale(1.02) translateY(0);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .animate-welcome-card {
            animation: popupZoomIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Pulse glow */
        .glow-box {
            box-shadow: 0 0 50px -10px rgba(59, 130, 246, 0.3), 0 0 100px -20px rgba(16, 185, 129, 0.2);
        }
    </style>
</head>
<body class="h-full bg-navy-950 flex flex-col justify-between relative bg-grid-pattern">

    <!-- Ambient Lights Background -->
    <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 right-10 w-[500px] h-[350px] bg-emerald-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Top Bar: Header & Live Clock -->
    <header class="relative z-10 px-8 py-6 flex items-center justify-between border-b border-white/10 backdrop-blur-md bg-navy-950/40">
        <!-- Logo & Event Info -->
        <div class="flex items-center gap-4">
            <div class="px-3.5 py-1.5 bg-blue-600 text-white font-black text-sm tracking-wider rounded-lg shadow-lg shadow-blue-600/30 flex items-center gap-2">
                <span>C LEVEL</span>
                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
            </div>
            <div>
                <h2 class="text-sm font-extrabold text-white tracking-wide uppercase">Musyawarah & Temu Bisnis C LEVEL Indonesia</h2>
                <p class="text-xs text-slate-400 font-medium">Hotel Pullman Bandung Grand Central • 2026</p>
            </div>
        </div>

        <!-- Live Digital Clock & Stats Widget -->
        <div class="flex items-center gap-6">
            <!-- Counter Kehadiran -->
            <div class="flex items-center gap-3 bg-white/5 border border-white/10 px-4 py-2 rounded-xl">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <div class="text-left">
                    <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block">Tamu Hadir</span>
                    <span class="text-sm font-black text-white" id="stat-attended">{{ number_format($stats['attended']) }}</span>
                    <span class="text-xs text-slate-400 font-medium">/ <span id="stat-total">{{ number_format($stats['total']) }}</span></span>
                </div>
            </div>

            <!-- Jam Digital Real-time -->
            <div class="text-right">
                <div id="live-clock" class="text-2xl font-black font-mono tracking-tight text-white">00:00:00</div>
                <div id="live-date" class="text-xs font-semibold text-slate-400">Memuat tanggal...</div>
            </div>

            <!-- Fullscreen & Audio Controls -->
            <div class="flex items-center gap-2 pl-2 border-l border-white/10">
                <button type="button" id="btn-audio" onclick="toggleAudio()" class="p-2.5 bg-white/5 hover:bg-white/15 text-slate-300 hover:text-white rounded-lg transition-colors cursor-pointer border border-white/10" title="Suara Sambutan">
                    <svg id="icon-sound-on" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                    </svg>
                    <svg id="icon-sound-off" class="w-4 h-4 hidden text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
                    </svg>
                </button>

                <button type="button" onclick="toggleFullscreen()" class="p-2.5 bg-white/5 hover:bg-white/15 text-slate-300 hover:text-white rounded-lg transition-colors cursor-pointer border border-white/10" title="Layar Penuh (F11)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Area: Standby Mode & Welcome Popup -->
    <main class="relative z-10 flex-grow flex items-center justify-center p-8 text-center">

        <!-- Standby Hero Banner (Tampil saat belum ada scan baru) -->
        <div id="standby-screen" class="max-w-4xl mx-auto space-y-6 transition-opacity duration-500">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/10 border border-blue-400/30 text-blue-400 text-xs font-extrabold uppercase tracking-widest">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                <span>Gerbang Presensi Resmi Tamu Undangan</span>
            </div>

            <h1 class="text-4xl sm:text-6xl font-black text-white tracking-tight leading-tight">
                Selamat Datang di <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-sky-300 to-emerald-400">
                    C LEVEL INDONESIA 2026
                </span>
            </h1>

            <p class="text-lg text-slate-400 max-w-2xl mx-auto font-medium leading-relaxed">
                Silakan arahkan tiket QR Anda pada meja registrasi. Layar ini akan otomatis menampilkan verifikasi kehadiran secara real-time.
            </p>

            <div class="pt-4 flex items-center justify-center gap-4 text-xs text-slate-500">
                <span class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Sistem Terhubung Real-Time</span>
                </span>
                <span>•</span>
                <span class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span>Mendukung Scan dari HP Panitia</span>
                </span>
            </div>
        </div>

        <!-- Grand Welcome Overlay Card (Muncul saat ada scan baru) -->
        <div id="welcome-card" class="hidden absolute inset-x-4 max-w-4xl mx-auto z-30 animate-welcome-card">
            <div class="relative bg-gradient-to-b from-slate-900/95 to-navy-900/95 border-2 border-emerald-500/80 rounded-3xl p-8 sm:p-12 shadow-2xl backdrop-blur-2xl glow-box">
                
                <!-- Badge Atas -->
                <div class="flex items-center justify-center gap-2 mb-4">
                    <span class="px-4 py-1.5 rounded-full bg-emerald-500 text-navy-950 font-black text-xs uppercase tracking-widest flex items-center gap-2 shadow-lg shadow-emerald-500/20">
                        <svg class="w-4 h-4 text-navy-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>PRESENSI TERVERIFIKASI</span>
                    </span>
                </div>

                <div class="space-y-4 my-2">
                    <p class="text-sm uppercase tracking-widest text-slate-400 font-extrabold">Selamat Datang Yang Terhormat</p>
                    
                    <!-- Nama Peserta Raksasa -->
                    <h2 id="guest-name" class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight">
                        Nama Peserta
                    </h2>

                    <!-- Instansi & Jabatan -->
                    <div class="pt-2 flex flex-col items-center justify-center gap-1">
                        <p id="guest-company" class="text-xl sm:text-2xl font-black text-amber-400">
                            Perusahaan / Instansi
                        </p>
                        <p id="guest-position" class="text-sm sm:text-base font-semibold text-slate-300">
                            Jabatan
                        </p>
                    </div>
                </div>

                <!-- Footer Card Sambutan -->
                <div class="mt-8 pt-6 border-t border-white/10 flex items-center justify-between text-xs text-slate-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Waktu Presensi: <b id="guest-time" class="text-white font-mono font-bold">-</b></span>
                    </div>
                    <span class="font-bold tracking-wider text-slate-500 uppercase">C LEVEL INDONESIA 2026</span>
                </div>

                <!-- Progress Bar Otomatis Hitung Mundur -->
                <div class="absolute bottom-0 left-0 right-0 h-1.5 bg-white/10 rounded-b-3xl overflow-hidden">
                    <div id="welcome-progress" class="h-full bg-emerald-500 transition-all duration-100 ease-linear w-full"></div>
                </div>
            </div>
        </div>

    </main>

    <!-- Bottom Bar: Daftar Tamu Terbaru Yang Hadir -->
    <footer class="relative z-10 px-8 py-4 bg-navy-950/60 border-t border-white/10 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-6">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 shrink-0 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                <span>Baru Hadir</span>
            </span>

            <div id="recent-guests-marquee" class="flex items-center gap-4 overflow-x-auto no-scrollbar text-xs">
                @forelse($recentAttended as $attendee)
                <div class="px-3.5 py-1.5 bg-white/5 border border-white/10 rounded-xl flex items-center gap-2 shrink-0">
                    <span class="font-bold text-white">{{ $attendee->name }}</span>
                    <span class="text-slate-400">•</span>
                    <span class="text-amber-400 font-medium">{{ $attendee->company ?? 'C-Level' }}</span>
                    <span class="text-[10px] text-slate-400 font-mono">({{ $attendee->attended_at ? $attendee->attended_at->format('H:i') : '' }})</span>
                </div>
                @empty
                <span class="text-slate-500 italic text-xs">Belum ada peserta yang hadir.</span>
                @endforelse
            </div>
        </div>
    </footer>

    <!-- Audio Chime Synthesizer & Polling Script -->
    <script>
        let isAudioEnabled = true;
        let lastAttendedTime = '{{ $recentAttended->first() && $recentAttended->first()->attended_at ? $recentAttended->first()->attended_at->toIso8601String() : now()->toIso8601String() }}';
        let welcomeTimeout = null;
        let progressInterval = null;

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

        // Tampilkan Popup Sambutan Megah
        function showWelcomeModal(guest) {
            const standby = document.getElementById('standby-screen');
            const card = document.getElementById('welcome-card');
            const nameEl = document.getElementById('guest-name');
            const compEl = document.getElementById('guest-company');
            const posEl = document.getElementById('guest-position');
            const timeEl = document.getElementById('guest-time');
            const progress = document.getElementById('welcome-progress');

            nameEl.innerText = guest.name;
            compEl.innerText = guest.company || 'C-Level Indonesia';
            posEl.innerText = guest.position || '-';
            timeEl.innerText = guest.time;

            // Bunyikan nada sambutan
            playChimeSound();

            // Tampilkan card, sembunyikan standby
            standby.classList.add('opacity-0');
            card.classList.remove('hidden');

            // Tambahkan tamu ke daftar marquee bawah
            prependRecentGuest(guest);

            // Reset Timer & Progress Bar (Tampil 6.5 detik)
            clearTimeout(welcomeTimeout);
            clearInterval(progressInterval);

            const duration = 6500;
            const startTime = Date.now();

            progress.style.width = '100%';
            progressInterval = setInterval(() => {
                const elapsed = Date.now() - startTime;
                const remaining = Math.max(0, 1 - (elapsed / duration));
                progress.style.width = (remaining * 100) + '%';
            }, 50);

            welcomeTimeout = setTimeout(() => {
                clearInterval(progressInterval);
                card.classList.add('hidden');
                standby.classList.remove('opacity-0');
            }, duration);
        }

        function prependRecentGuest(guest) {
            const container = document.getElementById('recent-guests-marquee');
            const item = document.createElement('div');
            item.className = 'px-3.5 py-1.5 bg-emerald-500/20 border border-emerald-500/50 rounded-xl flex items-center gap-2 shrink-0 animate-pulse';
            item.innerHTML = `
                <span class="font-bold text-white">${escapeHtml(guest.name)}</span>
                <span class="text-slate-400">•</span>
                <span class="text-amber-400 font-medium">${escapeHtml(guest.company)}</span>
                <span class="text-[10px] text-emerald-400 font-mono font-bold">(${guest.time})</span>
            `;
            if (container.firstElementChild) {
                container.insertBefore(item, container.firstElementChild);
            } else {
                container.appendChild(item);
            }
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
                // Update statistik counter
                if (data.stats) {
                    document.getElementById('stat-attended').innerText = Number(data.stats.attended).toLocaleString('id-ID');
                    document.getElementById('stat-total').innerText = Number(data.stats.total).toLocaleString('id-ID');
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
