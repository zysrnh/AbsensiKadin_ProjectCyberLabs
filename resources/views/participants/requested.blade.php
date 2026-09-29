@extends('layouts.guest')

@section('title', 'Permintaan Bergabung Berhasil Diajukan - C LEVEL')

@section('content')
<div class="w-full max-w-lg mx-auto px-4 sm:px-6">

    <!-- Card Konfirmasi Permintaan Bergabung Ala Luma Request to Join -->
    <div class="bg-white border border-slate-200 rounded-sm shadow-xs overflow-hidden">
        
        <!-- Header Hijau/Emerald Bersih -->
        <div class="p-6 sm:p-8 text-center border-b border-slate-100 bg-slate-50/50">
            <!-- Icon Checklist Sukses -->
            <div class="w-14 h-14 bg-emerald-100 border border-emerald-200 text-emerald-800 rounded-full flex items-center justify-center mx-auto mb-4" style="width: 56px; height: 56px;">
                <svg width="28" height="28" style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <span class="inline-block px-2.5 py-0.5 bg-emerald-100 text-emerald-800 font-bold text-[10px] tracking-wider uppercase rounded-xs mb-2">
                Permohonan Diterima
            </span>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                Permintaan Bergabung Berhasil Diajukan
            </h1>
            <p class="text-xs text-slate-500 mt-2 max-w-md mx-auto leading-relaxed">
                Pengajuan kehadiran Anda untuk kegiatan <strong>{{ $eventTitle }}</strong> telah berhasil kami terima dalam sistem C LEVEL.
            </p>
        </div>

        <!-- Rincian Data yang Diajukan -->
        <div class="p-6 sm:p-8 space-y-4">
            
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">
                Rincian Formulir
            </span>

            <div class="border border-slate-200 divide-y divide-slate-100 text-xs rounded-sm overflow-hidden">
                <div class="p-3 bg-slate-50/50 flex justify-between gap-3">
                    <span class="font-semibold text-slate-500">Nama Lengkap</span>
                    <span class="font-bold text-slate-900 text-right">{{ $participant->name }}</span>
                </div>
                <div class="p-3 flex justify-between gap-3">
                    <span class="font-semibold text-slate-500">Company / Instansi</span>
                    <span class="font-medium text-slate-800 text-right">{{ $participant->company ?? '-' }}</span>
                </div>
                <div class="p-3 bg-slate-50/50 flex justify-between gap-3">
                    <span class="font-semibold text-slate-500">Jabatan</span>
                    <span class="font-medium text-slate-800 text-right">{{ $participant->position ?? '-' }}</span>
                </div>
                <div class="p-3 flex justify-between gap-3">
                    <span class="font-semibold text-slate-500">Nomor WhatsApp</span>
                    <span class="font-mono font-medium text-slate-800 text-right">{{ $participant->phone }}</span>
                </div>
                <div class="p-3 bg-slate-50/50 flex justify-between gap-3 items-center">
                    <span class="font-semibold text-slate-500">Kode Registrasi</span>
                    <span class="font-mono font-bold text-slate-900 px-2 py-0.5 bg-white border border-slate-300 rounded-xs text-[11px]">
                        {{ $participant->qr_token }}
                    </span>
                </div>
            </div>

            <!-- Notice Box Luma -->
            <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-sm text-xs text-slate-600 flex items-start gap-2.5">
                <svg class="w-4 h-4 text-slate-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="leading-relaxed">
                    Data Anda telah tercatat. Panitia penyelenggara akan meninjau permohonan Anda dan memberikan pembaruan informasi kegiatan.
                </span>
            </div>

            <!-- Tombol Kembali ke Halaman Acara -->
            <div class="pt-2">
                <a 
                    href="{{ route('home') }}" 
                    class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors flex items-center justify-center gap-1.5 shadow-2xs border border-slate-900"
                >
                    <span>← Kembali ke Halaman Acara</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
