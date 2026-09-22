@extends('layouts.app')

@section('title', 'Tiket QR Peserta - ' . $participant->name)

@section('content')
<div class="py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <!-- Action Header -->
        <div class="mb-4 flex items-center justify-between text-xs">
            <a href="{{ route('participants.index') }}" class="font-medium text-slate-500 hover:text-slate-900 flex items-center gap-1">
                ← Kembali ke Data Peserta
            </a>
            <a href="{{ route('participants.create') }}" class="font-semibold text-slate-900 hover:underline">
                + Tambah Peserta
            </a>
        </div>

        <!-- Ticket Card Clean Flat -->
        <div id="printableTicket" class="bg-white border border-slate-300 rounded-sm shadow-xs overflow-hidden">
            
            <!-- Ticket Header Formal Flat -->
            <div class="bg-slate-900 text-white p-4 flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold tracking-wider uppercase bg-slate-800 text-slate-200 px-2 py-0.5 rounded-sm inline-block mb-1">
                        E-Tiket Kehadiran
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
                    <p class="text-[11px] text-slate-500 mt-0.5 text-center">Tunjukkan QR Code ini kepada panitia saat kedatangan.</p>
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

            <!-- Ticket Footer: Blast WhatsApp & Cetak -->
            <div class="p-4 bg-slate-50 border-t border-slate-200 space-y-2">
                <a 
                    href="{{ $participant->whatsapp_blast_url }}" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="w-full flex items-center justify-center space-x-2 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-sm transition-colors cursor-pointer"
                >
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.299.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.353.101.173.45 0.742.966 1.202.664.591 1.224.774 1.397.86.173.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086.159.058 1.011.477 1.184.564.173.087.289.13.332.202.043.073.043.419-.101.824z"/>
                    </svg>
                    <span>Kirim Tiket QR ke WhatsApp Peserta</span>
                </a>

                <div class="grid grid-cols-2 gap-2">
                    <button 
                        type="button" 
                        onclick="window.print()" 
                        class="py-2 bg-white hover:bg-slate-100 text-slate-800 font-semibold text-xs rounded-sm border border-slate-300 transition-colors flex items-center justify-center space-x-1 cursor-pointer"
                    >
                        <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <span>Cetak Tiket</span>
                    </button>

                    <a 
                        href="{{ route('participants.scan') }}" 
                        class="py-2 bg-white hover:bg-slate-100 text-slate-800 font-semibold text-xs rounded-sm border border-slate-300 transition-colors text-center flex items-center justify-center space-x-1"
                    >
                        <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        <span>Scanner QR</span>
                    </a>
                </div>
            </div>

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
                width: 160,
                height: 160,
                colorDark : "#0f172a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        }
    });
</script>
@endpush
