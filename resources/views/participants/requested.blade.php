@extends('layouts.guest')

@section('title', 'Permintaan Bergabung Berhasil Diajukan - C LEVEL')

@push('styles')
<style>
    .tilt-card-container {
        perspective: 1200px;
    }
    .card-3d-main {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.95);
        box-shadow: 
            0 2px 4px rgba(15, 23, 42, 0.03),
            0 12px 24px -4px rgba(15, 23, 42, 0.08),
            0 28px 60px -12px rgba(15, 23, 42, 0.16),
            0 45px 85px -20px rgba(15, 23, 42, 0.10);
        transition: transform 0.15s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.25s ease;
        transform-style: preserve-3d;
        will-change: transform;
    }
    .btn-3d-icon {
        box-shadow: 0 2px 0 #cbd5e1, 0 4px 8px -2px rgba(15, 23, 42, 0.08);
        transition: all 0.15s ease;
    }
    .btn-3d-icon:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 0 #cbd5e1, 0 8px 12px -2px rgba(15, 23, 42, 0.12);
    }
    .btn-3d-icon:active {
        transform: translateY(2px);
        box-shadow: 0 1px 0 #cbd5e1;
    }
    
    /* Animasi Toast Melayang (Entrance & Exit Super Smooth) */
    .toast-card-anim {
        box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.12);
        transform: translateY(-50px) scale(0.95);
        opacity: 0;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease;
    }
    .toast-card-anim.toast-show {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
    .toast-card-anim.toast-hide {
        transform: translateY(-50px) scale(0.95);
        opacity: 0;
    }
</style>
@endpush

@section('content')
<!-- Floating Toast Notification (Melayang di Atas, Selewat Saja & Animasi Halus) -->
<div id="waToast" class="fixed top-5 left-1/2 -translate-x-1/2 z-50 w-full max-w-md px-4 pointer-events-none">
    <div class="toast-card-anim pointer-events-auto bg-slate-900 text-white border border-slate-700/80 rounded-2xl p-3.5 sm:p-4 shadow-2xl flex items-center gap-3.5 backdrop-blur-md">
        
        <!-- Icon WhatsApp Centang -->
        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <!-- Teks Informasi Ringkas -->
        <div class="space-y-0.5 min-w-0 flex-1">
            <h4 class="text-xs font-bold text-white tracking-tight">
                Permohonan Berhasil Dikirim
            </h4>
            <p class="text-[11px] text-slate-300 leading-snug">
                E-Ticket QR akan dikirim ke WhatsApp <span class="font-mono text-emerald-400 font-semibold">{{ $participant->phone }}</span> setelah di-ACC panitia.
            </p>
        </div>

        <!-- Tombol Silang Ringkas -->
        <button type="button" onclick="closeWaToast()" class="w-7 h-7 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 flex items-center justify-center shrink-0 transition-colors cursor-pointer" title="Tutup">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

    </div>
</div>

<div class="w-full max-w-lg mx-auto px-4 -my-1 sm:-my-3 tilt-card-container">

    <!-- Card Konfirmasi Permintaan Bergabung 3D (Interactive Parallax Tilt) -->
    <div id="requestedCard" class="card-3d-main rounded-2xl sm:rounded-3xl overflow-hidden relative cursor-pointer">
        
        <!-- Tombol Back Minimalis di Pojok Atas (To The Point) -->
        <div class="absolute top-4 left-4 z-10">
            <a href="{{ route('home') }}" 
               class="btn-3d-icon w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-slate-900 hover:bg-slate-50 flex items-center justify-center transition-all cursor-pointer group"
               title="Kembali">
                <svg class="w-4 h-4 text-slate-600 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
        </div>

        <!-- Header Emerald Bersih & Super Ringkas -->
        <div class="pt-7 pb-5 px-6 text-center border-b border-slate-100 bg-slate-50/60">
            
            <!-- Icon Checklist Sukses -->
            <div class="w-13 h-13 bg-emerald-100 border border-emerald-300 text-emerald-700 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-xs" style="width: 52px; height: 52px;">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight leading-snug">
                Permintaan Bergabung Berhasil Diajukan
            </h1>
        </div>

        <!-- Rincian Formulir (Kompak & Bersih) -->
        <div class="p-5 sm:p-6 space-y-3">
            
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                    Rincian Formulir
                </span>
                <span class="text-[10px] font-mono text-slate-400 font-medium">
                    STATUS: PENDING
                </span>
            </div>

            <!-- Tabel Data 3D Ringkas -->
            <div class="border border-slate-200/90 divide-y divide-slate-100 text-xs rounded-xl overflow-hidden shadow-2xs">
                <div class="py-2.5 px-3.5 bg-slate-50/50 flex justify-between gap-3 items-center">
                    <span class="font-semibold text-slate-500 text-[11px]">Nama Lengkap</span>
                    <span class="font-bold text-slate-900 text-right">{{ $participant->name }}</span>
                </div>
                <div class="py-2.5 px-3.5 flex justify-between gap-3 items-center">
                    <span class="font-semibold text-slate-500 text-[11px]">Instansi / Perusahaan</span>
                    <span class="font-medium text-slate-800 text-right">{{ $participant->company ?? '-' }}</span>
                </div>
                <div class="py-2.5 px-3.5 bg-slate-50/50 flex justify-between gap-3 items-center">
                    <span class="font-semibold text-slate-500 text-[11px]">Jabatan / Posisi</span>
                    <span class="font-medium text-slate-800 text-right">{{ $participant->position ?? '-' }}</span>
                </div>
                <div class="py-2.5 px-3.5 flex justify-between gap-3 items-center">
                    <span class="font-semibold text-slate-500 text-[11px]">Nomor WhatsApp</span>
                    <span class="font-mono font-medium text-slate-800 text-right">{{ $participant->phone }}</span>
                </div>
                <div class="py-2.5 px-3.5 bg-slate-50/50 flex justify-between gap-3 items-center">
                    <span class="font-semibold text-slate-500 text-[11px]">Kode Registrasi</span>
                    <span class="font-mono font-bold text-slate-900 px-2 py-0.5 bg-white border border-slate-300 rounded-md text-[11px] shadow-2xs">
                        {{ $participant->qr_token }}
                    </span>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Interactive 3D Parallax Tilt Effect pada Card
        const card = document.getElementById('requestedCard');
        if (card) {
            card.addEventListener('mousemove', function(e) {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const rotateX = ((y - centerY) / centerY) * -12;
                const rotateY = ((x - centerX) / centerX) * 12;
                
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
                card.style.boxShadow = `0 35px 70px -15px rgba(15, 23, 42, 0.25)`;
            });

            card.addEventListener('mouseleave', function() {
                card.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)`;
                card.style.boxShadow = ``;
            });
        }

        // 2. Animasi Toast Melayang Masuk Halus (Slide-Down)
        const toast = document.querySelector('.toast-card-anim');
        if (toast) {
            setTimeout(function() {
                toast.classList.add('toast-show');
            }, 100);

            // Otomatis meluncur keluar secara halus setelah 4 detik
            setTimeout(function() {
                closeWaToast();
            }, 4000);
        }
    });

    // 3. Fungsi Tutup Toast Melayang
    function closeWaToast() {
        const toast = document.querySelector('.toast-card-anim');
        const container = document.getElementById('waToast');
        if (toast) {
            toast.classList.remove('toast-show');
            toast.classList.add('toast-hide');
            setTimeout(function() {
                if (container) container.remove();
            }, 500);
        }
    }
</script>
@endpush
