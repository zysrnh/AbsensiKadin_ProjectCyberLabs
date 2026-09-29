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
    .btn-3d-dark {
        box-shadow: 0 4px 0 #020617, 0 10px 20px -3px rgba(15, 23, 42, 0.35);
        transition: all 0.15s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-3d-dark:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 #020617, 0 14px 26px -4px rgba(15, 23, 42, 0.4);
    }
    .btn-3d-dark:active {
        transform: translateY(2px);
        box-shadow: 0 1px 0 #020617;
    }
    .modal-backdrop-anim {
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .modal-box-anim {
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.35s ease;
    }
    .modal-hidden {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }
    .modal-hidden .modal-box-anim {
        transform: scale(0.92) translateY(15px);
        opacity: 0;
    }
</style>
@endpush

@section('content')
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

<!-- Pop-up Modal Informasi ACC & E-Ticket WhatsApp -->
<div id="waQrModal" class="modal-backdrop-anim fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    <div class="modal-box-anim card-3d-main w-full max-w-sm rounded-2xl p-6 text-center space-y-4 bg-white relative">
        
        <!-- Icon WhatsApp / Notifikasi -->
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center mx-auto shadow-xs">
            <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
        </div>

        <div class="space-y-1.5">
            <h3 class="text-base font-black text-slate-900 tracking-tight">
                Menunggu Persetujuan Panitia
            </h3>
            <p class="text-xs text-slate-500 leading-relaxed">
                Permohonan Anda berhasil dicatat. Silakan tunggu konfirmasi panitia. E-Ticket QR Code resmi akan langsung dikirimkan ke nomor WhatsApp:
            </p>
            <div class="pt-1">
                <span class="inline-block px-3 py-1 bg-slate-100 border border-slate-200 text-slate-900 font-mono font-bold text-xs rounded-lg">
                    {{ $participant->phone }}
                </span>
            </div>
        </div>

        <div class="pt-2 flex justify-center">
            <button type="button" onclick="closeWaModal()" class="btn-3d-dark w-12 h-12 rounded-full bg-slate-900 hover:bg-slate-800 text-white flex items-center justify-center cursor-pointer border border-slate-900 shadow-md hover:scale-105 active:scale-95 transition-transform" title="Tutup">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </button>
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

        // 2. Auto-close Pop-Up Notifikasi secara Halus setelah 3 Detik
        setTimeout(function() {
            closeWaModal();
        }, 3000);
    });

    // 3. Fungsi Tutup Modal WhatsApp
    function closeWaModal() {
        const modal = document.getElementById('waQrModal');
        if (modal) {
            modal.classList.add('modal-hidden');
            setTimeout(() => {
                modal.remove();
            }, 350);
        }
    }
</script>
@endpush
