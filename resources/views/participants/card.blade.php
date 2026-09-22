@extends('layouts.guest')

@section('title', 'Tiket Presensi QR - ' . $participant->name)

@section('content')
<div class="w-full max-w-md px-4 sm:px-6">
    
    <!-- Ticket Card Clean Flat -->
    <div id="printableTicket" class="bg-white border border-slate-300 rounded-sm shadow-xs overflow-hidden">
        
        <!-- Ticket Header Formal Flat -->
        <div class="bg-slate-900 text-white p-4 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold tracking-wider uppercase bg-slate-800 text-slate-200 px-2 py-0.5 rounded-sm inline-block mb-1">
                    E-Tiket Presensi
                </span>
                <h2 class="text-sm font-bold tracking-tight text-white uppercase">KADIN INDONESIA 2026</h2>
            </div>
            <div class="text-right">
                <span class="text-[10px] text-slate-400 font-mono block">KODE TIKET</span>
                <span class="text-xs font-mono font-bold text-white">{{ $participant->qr_token }}</span>
            </div>
        </div>

        <!-- Ticket Body -->
        <div class="p-6 space-y-5">
            <!-- QR Code Box -->
            <div class="flex flex-col items-center justify-center p-5 bg-slate-50 border border-slate-200 rounded-sm">
                <div id="qrcode" class="p-2 bg-white border border-slate-300 shadow-2xs"></div>
                <p class="mt-3 font-mono font-bold text-sm tracking-wider text-slate-900">{{ $participant->qr_token }}</p>
                <p class="text-[11px] text-slate-500 mt-0.5 text-center">Tunjukkan QR Code ini kepada petugas presensi saat tiba di lokasi.</p>
            </div>

            <!-- Participant Details List Clean -->
            <div class="border border-slate-200 divide-y divide-slate-100 text-xs rounded-sm">
                <div class="p-3 bg-slate-50/50 flex justify-between gap-2">
                    <span class="font-semibold text-slate-500">Nama</span>
                    <span class="font-bold text-slate-900 text-right">{{ $participant->name }}</span>
                </div>
                <div class="p-3 flex justify-between gap-2">
                    <span class="font-semibold text-slate-500">Instansi</span>
                    <span class="font-medium text-slate-800 text-right">{{ $participant->company ?? '-' }}</span>
                </div>
                @if($participant->position)
                <div class="p-3 bg-slate-50/50 flex justify-between gap-2">
                    <span class="font-semibold text-slate-500">Jabatan</span>
                    <span class="font-medium text-slate-800 text-right">{{ $participant->position }}</span>
                </div>
                @endif
                <div class="p-3 flex justify-between gap-2">
                    <span class="font-semibold text-slate-500">WhatsApp</span>
                    <span class="font-mono font-medium text-slate-800 text-right">{{ $participant->phone }}</span>
                </div>
                @if($participant->email)
                <div class="p-3 bg-slate-50/50 flex justify-between gap-2">
                    <span class="font-semibold text-slate-500">Email</span>
                    <span class="font-medium text-slate-800 text-right">{{ $participant->email }}</span>
                </div>
                @endif
                <div class="p-3 flex items-center justify-between gap-2">
                    <span class="font-semibold text-slate-500">Status Kehadiran</span>
                    @if($participant->status === 'attended')
                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-[10px] uppercase rounded-sm">
                            Hadir ({{ $participant->attended_at ? $participant->attended_at->format('H:i') : '' }})
                        </span>
                    @else
                        <span class="px-2 py-0.5 bg-amber-100 text-amber-800 border border-amber-300 font-bold text-[10px] uppercase rounded-sm">
                            Terdaftar (Belum Hadir)
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Ticket Footer: Cetak / Simpan Tiket Saja -->
        <div class="p-4 bg-slate-50 border-t border-slate-200">
            <button 
                type="button" 
                onclick="window.print()" 
                class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors flex items-center justify-center space-x-1.5 cursor-pointer shadow-2xs border border-slate-900"
            >
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Simpan Tiket</span>
            </button>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qrContainer = document.getElementById("qrcode");
        if (qrContainer) {
            new QRCode(qrContainer, {
                text: "{{ $participant->qr_token }}",
                width: 170,
                height: 170,
                colorDark : "#0f172a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        }
    });
</script>
@endpush
