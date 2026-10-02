@extends('layouts.guest')
@section('title', 'Permintaan Bergabung Berhasil Diajukan - Wonderful')

@push('styles')
<style>
    :root {
        --ease-expo: cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Floating Stars Animation (Bottom to Top ala Layar TV Display) */
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

    /* Kinetic Staggered TV Screen Reveal */
    @keyframes tvRevealUp {
        0% {
            opacity: 0;
            transform: translateY(28px) scale(0.97);
            filter: blur(12px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }

    .anim-tv-back {
        animation: tvRevealUp 0.65s var(--ease-expo) 0.05s backwards;
    }
    .anim-tv-card {
        animation: tvRevealUp 0.85s var(--ease-expo) 0.15s backwards;
    }
    .anim-tv-row-1 {
        animation: tvRevealUp 0.65s var(--ease-expo) 0.25s backwards;
    }
    .anim-tv-row-2 {
        animation: tvRevealUp 0.65s var(--ease-expo) 0.32s backwards;
    }
    .anim-tv-row-3 {
        animation: tvRevealUp 0.65s var(--ease-expo) 0.39s backwards;
    }
    .anim-tv-row-4 {
        animation: tvRevealUp 0.65s var(--ease-expo) 0.46s backwards;
    }
    .anim-tv-row-5 {
        animation: tvRevealUp 0.65s var(--ease-expo) 0.53s backwards;
    }
    .anim-tv-notice {
        animation: tvRevealUp 0.75s var(--ease-expo) 0.60s backwards;
    }
    .anim-tv-btn {
        animation: tvRevealUp 0.75s var(--ease-expo) 0.67s backwards;
    }

    .tilt-card-container {
        perspective: 1200px;
    }

    .card-glass {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%), rgba(12, 14, 20, 0.82);
        backdrop-filter: blur(36px) saturate(170%);
        -webkit-backdrop-filter: blur(36px) saturate(170%);
        border: 1px solid rgba(255, 255, 255, 0.10);
        box-shadow: 
            inset 0 1px 0 0 rgba(255, 255, 255, 0.18),
            0 4px 6px -1px rgba(0, 0, 0, 0.4),
            0 24px 50px -15px rgba(0, 0, 0, 0.85);
        transition: transform 0.15s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.25s ease;
        transform-style: preserve-3d;
        will-change: transform;
    }

    .card-glass-subtle {
        background: rgba(255, 255, 255, 0.035);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.10);
    }

    .btn-glow-white {
        background: #ffffff;
        color: #05070a;
        box-shadow: 
            0 4px 20px -2px rgba(255, 255, 255, 0.30),
            0 2px 6px rgba(0, 0, 0, 0.5);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-glow-white:hover {
        transform: translateY(-2px);
        background: #f8fafc;
        box-shadow: 
            0 8px 30px rgba(255, 255, 255, 0.45),
            0 4px 12px rgba(0, 0, 0, 0.6);
    }

    /* Toast Notifikasi Feedback */
    .toast-card-anim {
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.8);
        transform: translateY(-20px);
        opacity: 0;
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease;
    }
    .toast-card-anim.toast-show {
        transform: translateY(0);
        opacity: 1;
    }
    .toast-card-anim.toast-hide {
        transform: translateY(-20px);
        opacity: 0;
    }
</style>
@endpush

@section('content')
<!-- Floating Star Particles Background (Bintang 4 Sudut dari Layar TV) -->
<div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
    <div class="star-particle text-white/40" style="left: 6%; --duration: 16s; --delay: -2s; --star-opacity: 0.35;">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
    </div>
    <div class="star-particle text-sky-200/50" style="left: 18%; --duration: 13s; --delay: -7s; --star-opacity: 0.4;">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
    </div>
    <div class="star-particle text-white/50" style="left: 32%; --duration: 18s; --delay: -11s; --star-opacity: 0.3;">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
    </div>
    <div class="star-particle text-purple-200/40" style="left: 65%; --duration: 14s; --delay: -4s; --star-opacity: 0.35;">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
    </div>
    <div class="star-particle text-white/45" style="left: 82%; --duration: 15s; --delay: -8s; --star-opacity: 0.4;">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
    </div>
    <div class="star-particle text-blue-200/40" style="left: 93%; --duration: 17s; --delay: -12s; --star-opacity: 0.3;">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
    </div>
</div>

<!-- Toast Feedback Interaktif (Salin Kode / Status) -->
<div id="statusToast" class="fixed top-20 left-1/2 -translate-x-1/2 z-50 pointer-events-none w-auto max-w-[92vw]">
    <div id="toastBox" class="toast-card-anim pointer-events-auto bg-neutral-900/95 border border-white/20 text-white rounded-xl px-4 py-2.5 flex items-center gap-2.5 shadow-2xl backdrop-blur-xl">
        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 shrink-0">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
        </span>
        <span id="toastMessage" class="text-xs font-semibold text-neutral-200 tracking-tight whitespace-nowrap">
            Permohonan Terkirim • Menunggu ACC Panitia
        </span>
    </div>
</div>

<div class="max-w-xl mx-auto px-4 sm:px-6 py-4 space-y-4 relative z-10 tilt-card-container">

    <!-- Tombol Kembali ke Halaman Detail Acara -->
    <div class="anim-tv-back">
        <a href="{{ route('home') }}" 
           class="inline-flex items-center gap-2 text-xs font-bold text-neutral-400 hover:text-white transition-colors py-2 px-3 rounded-lg hover:bg-white/10 group">
            <svg class="w-4 h-4 text-neutral-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span data-i18n="back_to_event">Kembali ke Detail Acara</span>
        </a>
    </div>

    <!-- Card Konfirmasi Permintaan Bergabung (Dark Glassmorphism Premium) -->
    <div id="requestedCard" class="card-glass rounded-2xl sm:rounded-3xl p-6 sm:p-8 space-y-6 relative overflow-hidden anim-tv-card shadow-2xl">
        
        <!-- Ambient Glow Lembut di Bagian Atas Card -->
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-80 h-36 bg-emerald-500/15 blur-3xl pointer-events-none rounded-full"></div>

        <!-- Header Konfirmasi -->
        <div class="text-center relative z-10 space-y-4">
            
            <!-- Ikon Centang Sukses dengan Soft Glow -->
            <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 border border-emerald-500/25 text-emerald-400 flex items-center justify-center mx-auto shadow-lg shadow-emerald-500/10 relative">
                <div class="absolute inset-0 rounded-2xl bg-emerald-400/20 blur-md pointer-events-none"></div>
                <svg class="w-7 h-7 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <!-- Judul Halaman -->
            <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight leading-snug" data-i18n="req_success_title">
                Permintaan Bergabung Berhasil Diajukan
            </h1>

        </div>

        <!-- Rincian Formulir (Tabel Kompak Dark Glass) -->
        <div class="space-y-3 relative z-10">
            
            <div class="flex items-center justify-between px-1">
                <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-neutral-400" data-i18n="req_form_details">
                    Rincian Formulir
                </span>
                <span class="text-[10px] font-mono font-medium text-neutral-400" data-i18n="req_status_pending">
                    STATUS: PENDING
                </span>
            </div>

            <!-- Tabel Baris Data Peserta -->
            <div class="card-glass-subtle rounded-xl overflow-hidden divide-y divide-white/5 text-xs">
                
                <!-- Baris Nama -->
                <div class="py-3 px-4 flex justify-between gap-3 items-center anim-tv-row-1 hover:bg-white/[0.02] transition-colors">
                    <span class="font-medium text-neutral-400 text-[11px] sm:text-xs" data-i18n="label_name">Nama Lengkap</span>
                    <span class="font-bold text-white text-right text-xs sm:text-sm">{{ $participant->name }}</span>
                </div>

                <!-- Baris Instansi -->
                <div class="py-3 px-4 flex justify-between gap-3 items-center anim-tv-row-2 hover:bg-white/[0.02] transition-colors">
                    <span class="font-medium text-neutral-400 text-[11px] sm:text-xs" data-i18n="label_company">Instansi / Perusahaan</span>
                    <span class="font-medium text-neutral-200 text-right text-xs sm:text-sm">{{ $participant->company ?? '-' }}</span>
                </div>

                <!-- Baris Jabatan -->
                <div class="py-3 px-4 flex justify-between gap-3 items-center anim-tv-row-3 hover:bg-white/[0.02] transition-colors">
                    <span class="font-medium text-neutral-400 text-[11px] sm:text-xs" data-i18n="label_position">Jabatan / Posisi</span>
                    <span class="font-medium text-neutral-200 text-right text-xs sm:text-sm">{{ $participant->position ?? '-' }}</span>
                </div>

                <!-- Baris WhatsApp -->
                <div class="py-3 px-4 flex justify-between gap-3 items-center anim-tv-row-4 hover:bg-white/[0.02] transition-colors">
                    <span class="font-medium text-neutral-400 text-[11px] sm:text-xs" data-i18n="label_phone">Nomor WhatsApp</span>
                    <span class="font-mono font-medium text-neutral-200 text-right text-xs sm:text-sm">{{ $participant->phone }}</span>
                </div>

                <!-- Baris Kode Registrasi dengan Fitur 1-Click Copy -->
                <div class="py-3 px-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 bg-white/[0.02] anim-tv-row-5">
                    <span class="font-medium text-neutral-400 text-[11px] sm:text-xs" data-i18n="label_reg_code">Kode Registrasi</span>
                    <div class="flex items-center gap-2 self-end sm:self-auto">
                        <span id="regCodeDisplay" class="font-mono font-bold text-white px-2.5 py-1 bg-white/10 border border-white/15 rounded-lg text-xs tracking-wider select-all">
                            {{ $participant->qr_token }}
                        </span>
                        <button type="button" 
                                onclick="copyRegistrationCode('{{ $participant->qr_token }}')" 
                                id="btnCopyCode"
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white/10 hover:bg-white/20 text-neutral-200 hover:text-white border border-white/15 text-xs font-semibold transition-all cursor-pointer shadow-xs active:scale-95"
                                title="Salin Kode Registrasi">
                            <span id="copyIconContainer">
                                <svg class="w-3.5 h-3.5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                            </span>
                            <span id="copyBtnLabel" data-i18n="btn_copy_code">Salin Kode</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>

        <!-- Kotak Informasi Notifikasi WhatsApp -->
        <div class="p-4 rounded-xl bg-emerald-500/[0.07] border border-emerald-500/20 flex items-start gap-3 relative z-10 anim-tv-notice">
            <div class="w-8 h-8 rounded-lg bg-emerald-500/15 text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="space-y-1 min-w-0">
                <h4 class="text-xs font-bold text-white" data-i18n="req_wa_notice_title">
                    Konfirmasi via WhatsApp
                </h4>
                <p class="text-xs text-neutral-300 leading-relaxed" data-i18n="req_wa_notice_desc">
                    Permohonan Anda telah tercatat. Notifikasi persetujuan dan tiket kehadiran resmi akan dikirimkan ke WhatsApp Anda setelah disetujui host.
                </p>
            </div>
        </div>

        <!-- Tombol Aksi Navigasi Utama -->
        <div class="pt-2 relative z-10 anim-tv-btn">
            <a href="{{ route('home') }}" 
               class="btn-glow-white w-full py-3.5 px-6 font-black text-xs sm:text-sm tracking-wide rounded-xl flex items-center justify-center gap-2 cursor-pointer text-center shadow-xl hover:scale-[1.01] active:scale-[0.99] transition-all">
                <svg class="w-4 h-4 text-neutral-950 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span data-i18n="btn_back_to_home">Kembali ke Beranda</span>
            </a>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Interactive 3D Parallax Tilt Effect pada Card untuk Desktop
        const card = document.getElementById('requestedCard');
        if (card && window.innerWidth >= 768) {
            card.addEventListener('mousemove', function(e) {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const rotateX = ((y - centerY) / centerY) * -6;
                const rotateY = ((x - centerX) / centerX) * 6;
                
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.01)`;
                card.style.boxShadow = `0 35px 70px -15px rgba(0, 0, 0, 0.9)`;
            });

            card.addEventListener('mouseleave', function() {
                card.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)`;
                card.style.boxShadow = ``;
            });
        }

        // 2. Animasi Toast Masuk Awal (3 detik lalu keluar lembut)
        const toast = document.getElementById('toastBox');
        if (toast) {
            setTimeout(function() {
                toast.classList.add('toast-show');
            }, 100);

            setTimeout(function() {
                toast.classList.remove('toast-show');
                toast.classList.add('toast-hide');
            }, 3500);
        }
    });

    // 3. Fungsi Salin Kode Registrasi Interaktif
    window.copyRegistrationCode = function(code) {
        if (!code) return;
        
        navigator.clipboard.writeText(code).then(() => {
            const btnLabel = document.getElementById('copyBtnLabel');
            const iconContainer = document.getElementById('copyIconContainer');
            const toast = document.getElementById('toastBox');
            const toastMsg = document.getElementById('toastMessage');

            // Feedback pada tombol
            if (btnLabel) {
                btnLabel.textContent = (window.currentLang === 'en') ? 'Copied!' : 'Tersalin!';
            }
            if (iconContainer) {
                iconContainer.innerHTML = `<svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>`;
            }

            // Tampilkan Toast
            if (toast && toastMsg) {
                toastMsg.textContent = (window.currentLang === 'en') ? 'Registration code copied to clipboard!' : 'Kode registrasi berhasil disalin ke clipboard!';
                toast.classList.remove('toast-hide');
                toast.classList.add('toast-show');

                setTimeout(() => {
                    toast.classList.remove('toast-show');
                    toast.classList.add('toast-hide');
                }, 2500);
            }

            // Kembalikan teks tombol setelah 2.5 detik
            setTimeout(() => {
                const currentBtnLabel = document.getElementById('copyBtnLabel');
                const currentIconContainer = document.getElementById('copyIconContainer');
                if (currentBtnLabel) {
                    currentBtnLabel.textContent = (window.currentLang === 'en') ? 'Copy Code' : 'Salin Kode';
                }
                if (currentIconContainer) {
                    currentIconContainer.innerHTML = `<svg class="w-3.5 h-3.5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>`;
                }
            }, 2500);
        }).catch(err => {
            console.error('Failed to copy registration code: ', err);
        });
    };
</script>
@endpush
