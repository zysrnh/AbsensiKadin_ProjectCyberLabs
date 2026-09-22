@extends('layouts.app')

@section('title', 'Tiket QR Peserta - ' . $participant->name)

@section('content')
<div class="max-w-xl mx-auto">
    <!-- Action Header -->
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('participants.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 uppercase tracking-wider flex items-center gap-1">
            ← Kembali ke Data Peserta
        </a>
        <a href="{{ route('participants.create') }}" class="text-xs font-bold text-blue-700 hover:text-blue-900 uppercase tracking-wider">
            + Tambah Peserta Baru
        </a>
    </div>

    <!-- Ticket Card (Flat Solid Design) -->
    <div id="printableTicket" class="bg-white border-2 border-slate-900 rounded-none shadow-none overflow-hidden">
        
        <!-- Ticket Header Flat Navy -->
        <div class="bg-slate-900 text-white p-5 border-b-2 border-slate-900 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold tracking-widest uppercase bg-blue-700 text-white px-2 py-0.5 rounded-none inline-block mb-1">
                    E-TIKET KEHADIRAN RESMI
                </span>
                <h2 class="text-lg font-black tracking-tight text-white uppercase">KADIN INDONESIA 2026</h2>
            </div>
            <div class="text-right">
                <span class="text-xs text-slate-400 font-mono">TOKEN</span>
                <p class="text-sm font-mono font-bold text-white">{{ $participant->qr_token }}</p>
            </div>
        </div>

        <!-- Ticket Body -->
        <div class="p-6 space-y-6">
            <!-- QR Code Section Center -->
            <div class="flex flex-col items-center justify-center p-4 bg-slate-50 border border-slate-200">
                <div id="qrcode" class="p-2 bg-white border border-slate-300"></div>
                <p class="mt-3 font-mono font-bold text-sm tracking-widest text-slate-800">{{ $participant->qr_token }}</p>
                <p class="text-[11px] text-slate-500 mt-0.5 text-center">Tunjukkan QR Code ini kepada panitia saat kedatangan untuk absensi.</p>
            </div>

            <!-- Participant Details Table Flat -->
            <div class="border border-slate-200 divide-y divide-slate-200 text-xs">
                <div class="p-2.5 bg-slate-50 flex justify-between">
                    <span class="font-bold text-slate-500 uppercase">Nama Peserta</span>
                    <span class="font-black text-slate-900 text-sm">{{ $participant->name }}</span>
                </div>
                <div class="p-2.5 flex justify-between">
                    <span class="font-bold text-slate-500 uppercase">WhatsApp</span>
                    <span class="font-mono font-bold text-slate-800">{{ $participant->phone_number }}</span>
                </div>
                <div class="p-2.5 bg-slate-50 flex justify-between">
                    <span class="font-bold text-slate-500 uppercase">Email</span>
                    <span class="font-medium text-slate-800">{{ $participant->email }}</span>
                </div>
                @if($participant->institution)
                <div class="p-2.5 flex justify-between">
                    <span class="font-bold text-slate-500 uppercase">Instansi / Jabatan</span>
                    <span class="font-bold text-slate-800">{{ $participant->institution }}</span>
                </div>
                @endif
                <div class="p-2.5 bg-slate-50 flex items-center justify-between">
                    <span class="font-bold text-slate-500 uppercase">Status Kehadiran</span>
                    @if($participant->status === 'attended')
                        <span class="px-2 py-0.5 bg-emerald-600 text-white font-bold text-[11px] uppercase tracking-wider">
                            SUDAH HADIR ({{ $participant->attended_at->format('H:i') }})
                        </span>
                    @else
                        <span class="px-2 py-0.5 bg-amber-600 text-white font-bold text-[11px] uppercase tracking-wider">
                            TERDAFTAR (BELUM ABSEN)
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Ticket Footer & Blast WhatsApp -->
        <div class="p-5 bg-slate-100 border-t border-slate-200 space-y-3">
            <a 
                href="{{ $participant->whatsapp_blast_url }}" 
                target="_blank" 
                rel="noopener noreferrer"
                class="w-full flex items-center justify-center space-x-2 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-none border border-emerald-700 transition"
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
                    class="py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs uppercase tracking-wider rounded-none transition border border-slate-900 flex items-center justify-center space-x-1"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Cetak Tiket</span>
                </button>

                <a 
                    href="{{ route('participants.scan') }}" 
                    class="py-2.5 bg-white hover:bg-slate-50 text-slate-800 font-bold text-xs uppercase tracking-wider rounded-none border border-slate-300 transition text-center flex items-center justify-center space-x-1"
                >
                    <svg class="w-3.5 h-3.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    <span>Buka Scanner</span>
                </a>
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
