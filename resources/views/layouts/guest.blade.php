<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pendaftaran Peserta - Wonderful')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- QRCode JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        /* ==========================================================================
           BASE — COSMIC VOID DARK + MONOCHROMATIC AURORA WISPS
           Inspired by Luma.com's dark event page aesthetic
           ========================================================================== */
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --bg-void: #07090f;
            --surface-glass: rgba(255, 255, 255, 0.04);
            --border-glass: rgba(255, 255, 255, 0.09);
            --border-glass-strong: rgba(255, 255, 255, 0.16);
            --rim-light: rgba(255, 255, 255, 0.14);
            --text-primary: #f1f5f9;
            --text-secondary: #8b909c;
            --text-tertiary: #4e535f;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-void);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ------------------------------------------------------------------
           COSMIC BACKGROUND — Near-pure black with very faint grey aurora
           ------------------------------------------------------------------ */
        .bg-cosmic {
            background-color: var(--bg-void);
            background-image:
                /* Micro stardust — sparse white specks */
                radial-gradient(0.8px 0.8px at 12%  18%, rgba(255,255,255,0.55) 0%, transparent 100%),
                radial-gradient(0.8px 0.8px at 34%   7%, rgba(255,255,255,0.45) 0%, transparent 100%),
                radial-gradient(1.2px 1.2px at 58%  29%, rgba(255,255,255,0.5)  0%, transparent 100%),
                radial-gradient(0.8px 0.8px at 76%  14%, rgba(255,255,255,0.4)  0%, transparent 100%),
                radial-gradient(0.8px 0.8px at 89%  44%, rgba(255,255,255,0.35) 0%, transparent 100%),
                radial-gradient(0.9px 0.9px at 21%  62%, rgba(255,255,255,0.3)  0%, transparent 100%),
                radial-gradient(1.0px 1.0px at 47%  81%, rgba(255,255,255,0.25) 0%, transparent 100%),
                radial-gradient(0.7px 0.7px at 65%  55%, rgba(255,255,255,0.4)  0%, transparent 100%),
                radial-gradient(0.8px 0.8px at 83%  73%, rgba(255,255,255,0.3)  0%, transparent 100%),
                /* Aurora – grey/white wisps only, no hue */
                radial-gradient(ellipse 80% 55% at 50% -5%,  rgba(180,185,200, 0.07) 0%, transparent 70%),
                radial-gradient(ellipse 60% 40% at 80%  12%, rgba(160,165,180, 0.05) 0%, transparent 65%),
                radial-gradient(ellipse 45% 35% at 20%  20%, rgba(150,155,170, 0.04) 0%, transparent 60%);
            background-size:
                500px 500px, 500px 500px, 500px 500px, 500px 500px, 500px 500px,
                500px 500px, 500px 500px, 500px 500px, 500px 500px,
                100% 100%, 100% 100%, 100% 100%;
        }

        /* Vertical aurora curtain — pure greyscale, very delicate */
        .aurora-layer {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        .aurora-layer::before {
            content: '';
            position: absolute;
            top: -30%;
            left: -15%;
            width: 130%;
            height: 115vh;
            background: repeating-linear-gradient(
                82deg,
                transparent               0%,
                transparent               9%,
                rgba(200, 205, 220, 0.028) 11.5%,
                rgba(210, 215, 230, 0.042) 14%,
                transparent               17%,
                rgba(190, 195, 210, 0.022) 21.5%,
                transparent               26%
            );
            filter: blur(55px);
            mask-image: radial-gradient(ellipse 90% 65% at 50% 5%, black 0%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse 90% 65% at 50% 5%, black 0%, transparent 75%);
        }

        /* ==========================================================================
           GLOBAL GLASS TOKEN
           True frosted glass: high blur + subtle white fill + bright rim light
           ========================================================================== */
        .glass {
            background: var(--surface-glass);
            backdrop-filter: blur(40px) saturate(160%);
            -webkit-backdrop-filter: blur(40px) saturate(160%);
            border: 1px solid var(--border-glass);
            box-shadow:
                inset 0  1px 0   var(--rim-light),
                inset 0 -1px 0   rgba(255,255,255,0.04),
                0 2px  4px rgba(0,0,0,0.35),
                0 8px 30px rgba(0,0,0,0.55),
                0 25px 60px rgba(0,0,0,0.35);
        }

        /* Deep glass — heavier black fill for form cards */
        .glass-deep {
            background: rgba(10, 12, 18, 0.72);
            backdrop-filter: blur(48px) saturate(180%);
            -webkit-backdrop-filter: blur(48px) saturate(180%);
            border: 1px solid var(--border-glass);
            box-shadow:
                inset 0  1px 0 var(--rim-light),
                inset 0 -1px 0 rgba(255,255,255,0.035),
                0 4px 8px   rgba(0,0,0,0.5),
                0 16px 40px rgba(0,0,0,0.65),
                0 40px 80px rgba(0,0,0,0.4);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-cosmic text-slate-100 antialiased min-h-screen flex flex-col justify-between relative">

    <!-- Aurora Curtain Layer -->
    <div class="aurora-layer"></div>

    <!-- ==========================================================================
         HEADER — Ultra-thin monochromatic dark glass with Bilingual Switcher
         ========================================================================== -->
    <header class="sticky top-0 z-50 transition-all duration-300"
            style="background: rgba(7, 9, 15, 0.75);
                   backdrop-filter: blur(32px) saturate(150%);
                   -webkit-backdrop-filter: blur(32px) saturate(150%);
                   border-bottom: 1px solid rgba(255,255,255,0.07);
                   box-shadow: 0 1px 0 rgba(255,255,255,0.06), 0 4px 20px rgba(0,0,0,0.5);">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between relative z-10">

            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <!-- Wonderful Logo (Pure Logo, No Background Box) -->
                <img src="{{ asset('images/wonderful-logo.png') }}" alt="Wonderful" class="w-7 h-7 sm:w-8 sm:h-8 object-contain transition-transform duration-200 group-hover:scale-110 drop-shadow-md">
                <span class="text-[11px] font-medium text-white/40 tracking-widest uppercase hidden sm:block pl-1" data-i18n="header_subtitle">
                    Executive Roundtable
                </span>
            </a>

            <!-- Bilingual Switcher (ID & EN) -->
            <div class="flex items-center gap-1 p-1 rounded-xl bg-white/[0.05] border border-white/12 backdrop-blur-md shadow-inner">
                <button type="button" 
                        onclick="setLanguage('id')" 
                        id="langBtnId"
                        class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer text-white bg-white/20 border border-white/20 shadow-xs"
                        title="Bahasa Indonesia">
                    ID
                </button>
                <button type="button" 
                        onclick="setLanguage('en')" 
                        id="langBtnEn"
                        class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer text-neutral-400 hover:text-white hover:bg-white/10"
                        title="English">
                    EN
                </button>
            </div>

        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow py-8 sm:py-12 relative z-10">
        @yield('content')
    </main>

    <!-- ==========================================================================
         FOOTER — Same deep glass as header
         ========================================================================== -->
    <footer class="relative z-10"
            style="background: rgba(7, 9, 15, 0.70);
                   backdrop-filter: blur(24px);
                   -webkit-backdrop-filter: blur(24px);
                   border-top: 1px solid rgba(255,255,255,0.06);">
        <div class="max-w-6xl mx-auto px-4 py-6 text-center space-y-1">
            <p class="text-xs text-white/35 font-medium" data-i18n="footer_copy">
                &copy; {{ date('Y') }} Wonderful &mdash; Sistem Presensi &amp; Pendaftaran Resmi
            </p>
            <p class="text-[10px] text-white/20 font-light tracking-wide" data-i18n="footer_sub">
                All rights reserved. Executive Event Management System.
            </p>
        </div>
    </footer>

    <!-- Global Bilingual Translation Engine -->
    <script>
        const i18nTranslations = {
            id: {
                header_subtitle: "Executive Roundtable",
                footer_copy: "© " + new Date().getFullYear() + " Wonderful — Sistem Presensi & Pendaftaran Resmi",
                footer_sub: "All rights reserved. Executive Event Management System.",
                you_are_invited: "You Are Invited",
                envelope_badge: "Wonderful",
                envelope_action: "Buka Detail Acara",
                envelope_hint: "Ketuk amplop untuk membuka",
                quick_date_label: "Tanggal Pelaksanaan",
                quick_venue_label: "Lokasi / Venue",
                hosted_by_prefix: "Diselenggarakan oleh",
                hosted_by: "Diselenggarakan Oleh",
                registration_card_title: "Pendaftaran",
                approval_required: "Persetujuan Diperlukan",
                approval_desc: "Pendaftaran Anda memerlukan persetujuan host.",
                welcome_msg: "Selamat datang! Untuk mengikuti acara ini, silakan daftar di bawah.",
                btn_request_join: "Minta untuk Bergabung",
                about_event: "Tentang Acara",
                location_title: "Lokasi",
                location_prompt: "Harap mendaftar untuk melihat lokasi tepat acara ini.",
                btn_maps: "Maps",
                contact_host: "Hubungi Penyelenggara",
                report_event: "Laporkan Acara",
                venue_title: "Lokasi / Venue",
                date_title: "Tanggal Pelaksanaan",
                time_title: "Waktu / Jam",
                dresscode_title: "Ketentuan Busana",
                form_section_title: "Formulir Pendaftaran & E-Ticket",
                form_section_subtitle: "Silakan lengkapi formulir di bawah ini. E-Ticket QR Code presensi resmi akan langsung dikirimkan ke kontak WhatsApp Anda.",
                form_card_title: "Data Calon Peserta",
                form_card_subtitle: "Isi seluruh informasi dengan akurat untuk penerbitan tiket QR via WhatsApp.",
                label_name: "Nama Lengkap",
                placeholder_name: "Nama Lengkap & Gelar (jika ada)",
                label_phone: "Nomor WhatsApp Aktif",
                placeholder_phone: "08xxxxxxxxxx",
                label_company: "Instansi / Perusahaan",
                placeholder_company: "Nama Perusahaan / Organisasi",
                label_position: "Jabatan / Posisi",
                placeholder_position: "CEO, Direktur, Manager, dll",
                label_email: "Alamat Email",
                placeholder_email: "nama@perusahaan.com",
                btn_submit: "Request to Join",
                closed_alert_title: "Pendaftaran Telah Ditutup",
                btn_closed: "Pendaftaran Telah Ditutup",
                zoom_badge: "Lihat Ukuran Penuh",
                preview_close: "Tutup Preview (Esc)",
                back_to_event: "Kembali ke Detail Acara",
                req_success_title: "Permintaan Bergabung Berhasil Diajukan",
                req_status_pending: "STATUS: MENUNGGU PERSETUJUAN",
                req_status_badge: "Menunggu Persetujuan Panitia",
                req_form_details: "Rincian Formulir",
                label_reg_code: "Kode Registrasi",
                btn_copy_code: "Salin Kode",
                copied_tooltip: "Kode berhasil disalin!",
                req_wa_notice_title: "Konfirmasi via WhatsApp",
                req_wa_notice_desc: "Permohonan Anda telah tercatat. Notifikasi persetujuan dan tiket kehadiran resmi akan dikirimkan ke WhatsApp Anda setelah disetujui host.",
                btn_back_to_home: "Kembali ke Beranda"
            },
            en: {
                header_subtitle: "Executive Roundtable",
                footer_copy: "© " + new Date().getFullYear() + " Wonderful — Official Attendance & Registration System",
                footer_sub: "All rights reserved. Executive Event Management System.",
                you_are_invited: "You Are Invited",
                envelope_badge: "Wonderful",
                envelope_action: "Open Event Details",
                envelope_hint: "Tap envelope to open",
                quick_date_label: "Event Date",
                quick_venue_label: "Venue / Location",
                hosted_by_prefix: "Hosted by",
                hosted_by: "Hosted By",
                registration_card_title: "Registration",
                approval_required: "Approval Required",
                approval_desc: "Your registration requires host approval.",
                welcome_msg: "Welcome! To attend this event, please register below.",
                btn_request_join: "Request to Join",
                about_event: "About Event",
                location_title: "Location",
                location_prompt: "Please register to view the exact location of this event.",
                btn_maps: "Maps",
                contact_host: "Contact Host",
                report_event: "Report Event",
                venue_title: "Venue / Location",
                date_title: "Event Date",
                time_title: "Time",
                dresscode_title: "Dress Code",
                form_section_title: "Registration & E-Ticket",
                form_section_subtitle: "Please complete the form below. Official QR Code E-Ticket will be directly sent to your WhatsApp number.",
                form_card_title: "Attendee Information",
                form_card_subtitle: "Fill in all details accurately for official WhatsApp QR ticketing.",
                label_name: "Full Name",
                placeholder_name: "Full Name & Title (if any)",
                label_phone: "Active WhatsApp Number",
                placeholder_phone: "08xxxxxxxxxx or international format",
                label_company: "Company / Organization",
                placeholder_company: "Company or Organization Name",
                label_position: "Job Title / Position",
                placeholder_position: "CEO, Director, VP, Manager, etc.",
                label_email: "Email Address",
                placeholder_email: "name@company.com",
                btn_submit: "Request to Join",
                closed_alert_title: "Registration Is Closed",
                btn_closed: "Registration Is Closed",
                zoom_badge: "View Fullscreen",
                preview_close: "Close Preview (Esc)",
                back_to_event: "Back to Event Details",
                req_success_title: "Request to Join Submitted Successfully",
                req_status_pending: "STATUS: PENDING APPROVAL",
                req_status_badge: "Pending Host Approval",
                req_form_details: "Form Details",
                label_reg_code: "Registration Code",
                btn_copy_code: "Copy Code",
                copied_tooltip: "Code copied successfully!",
                req_wa_notice_title: "WhatsApp Notification",
                req_wa_notice_desc: "Your request has been recorded. Approval notification and official attendance ticket will be sent to your WhatsApp number once approved by the host.",
                btn_back_to_home: "Back to Home"
            }
        };

        window.currentLang = localStorage.getItem('app_lang') || 'id';

        function setLanguage(lang) {
            window.currentLang = lang;
            localStorage.setItem('app_lang', lang);
            applyLanguage(lang);
        }

        function applyLanguage(lang) {
            const dict = i18nTranslations[lang] || i18nTranslations.id;
            
            // Update active buttons styling
            const btnId = document.getElementById('langBtnId');
            const btnEn = document.getElementById('langBtnEn');
            if (btnId && btnEn) {
                if (lang === 'en') {
                    btnEn.className = "px-2.5 py-1 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer text-white bg-white/20 border border-white/20 shadow-xs";
                    btnId.className = "px-2.5 py-1 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer text-neutral-400 hover:text-white hover:bg-white/10";
                } else {
                    btnId.className = "px-2.5 py-1 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer text-white bg-white/20 border border-white/20 shadow-xs";
                    btnEn.className = "px-2.5 py-1 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer text-neutral-400 hover:text-white hover:bg-white/10";
                }
            }

            // Translate text contents
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
            applyLanguage(window.currentLang);
        });
    </script>

    @stack('scripts')
</body>
</html>
