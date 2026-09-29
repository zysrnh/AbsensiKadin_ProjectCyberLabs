@extends('layouts.guest')

@section('title', 'Permintaan Bergabung Berhasil Diajukan - C LEVEL')

@push('styles')
<style>
    .card-3d-main {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.95);
        box-shadow: 
            0 2px 4px rgba(15, 23, 42, 0.03),
            0 12px 24px -4px rgba(15, 23, 42, 0.08),
            0 28px 60px -12px rgba(15, 23, 42, 0.16),
            0 45px 85px -20px rgba(15, 23, 42, 0.10);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
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
</style>
@endpush

@section('content')
<div class="w-full max-w-lg mx-auto px-4 -my-2 sm:-my-4">

    <!-- Card Konfirmasi Permintaan Bergabung 3D (Kompak, Fit 1 Layar & To The Point) -->
    <div class="card-3d-main rounded-2xl sm:rounded-3xl overflow-hidden relative">
        
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

        <!-- Header Emerald Bersih & Kompak -->
        <div class="pt-6 pb-4 px-6 text-center border-b border-slate-100 bg-slate-50/60">
            
            <!-- Icon Checklist Sukses -->
            <div class="w-12 h-12 bg-emerald-100 border border-emerald-300 text-emerald-700 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <span class="inline-block px-2.5 py-0.5 bg-emerald-100 text-emerald-800 font-bold text-[10px] tracking-wider uppercase rounded-md mb-1.5 shadow-2xs">
                Permohonan Diterima
            </span>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight leading-snug">
                Permintaan Bergabung Berhasil Diajukan
            </h1>
            <p class="text-[11px] sm:text-xs text-slate-500 mt-1 max-w-sm mx-auto leading-relaxed">
                Pengajuan kehadiran Anda untuk <strong>{{ $eventTitle }}</strong> telah kami terima di sistem resmi.
            </p>
        </div>

        <!-- Rincian Formulir (Kompak & Bersih) -->
        <div class="p-5 sm:p-6 space-y-3.5">
            
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

            <!-- Notice Box Ringkas -->
            <div class="p-3 bg-blue-50/60 border border-blue-200/80 rounded-xl text-[11px] text-blue-900 flex items-center gap-2.5 shadow-2xs">
                <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="leading-relaxed">
                    Data Anda telah tercatat. Panitia akan segera meninjau dan mengirimkan konfirmasi kehadiran resmi ke WhatsApp Anda.
                </span>
            </div>

        </div>

    </div>

</div>
@endsection
