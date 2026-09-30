@extends('layouts.guest')

@section('title', 'E-Tiket Presensi QR - ' . $participant->name)

@push('styles')
<style>
    .card-3d-ticket {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.95);
        box-shadow: 
            0 2px 4px rgba(15, 23, 42, 0.03),
            0 12px 24px -4px rgba(15, 23, 42, 0.08),
            0 28px 60px -12px rgba(15, 23, 42, 0.12);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-3d-dark {
        box-shadow: 0 3px 0 #0f172a, 0 6px 12px -2px rgba(15, 23, 42, 0.2);
        transition: all 0.15s ease;
    }
    .btn-3d-dark:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 0 #0f172a, 0 8px 16px -2px rgba(15, 23, 42, 0.25);
    }
    .btn-3d-dark:active {
        transform: translateY(2px);
        box-shadow: 0 1px 0 #0f172a;
    }
    .btn-3d-light {
        box-shadow: 0 2px 0 #cbd5e1, 0 4px 8px -2px rgba(15, 23, 42, 0.06);
        transition: all 0.15s ease;
    }
    .btn-3d-light:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 0 #cbd5e1, 0 6px 12px -2px rgba(15, 23, 42, 0.1);
    }
    .btn-3d-light:active {
        transform: translateY(1px);
        box-shadow: 0 1px 0 #cbd5e1;
    }

    @media print {
        header, footer, .no-print {
            display: none !important;
        }
        body, main {
            background: #ffffff !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .card-3d-ticket {
            box-shadow: none !important;
            border: 1px solid #cbd5e1 !important;
            max-width: 100% !important;
            margin: 0 auto !important;
        }
    }
</style>
@endpush

@section('content')
<div class="w-full max-w-lg mx-auto px-4 py-2 sm:py-6">
    
    <!-- Kartu E-Tiket Modern 3D -->
    <div id="printableTicket" class="card-3d-ticket rounded-2xl sm:rounded-3xl overflow-hidden border border-slate-200">
        
        <!-- Header Acara Formal & Elegan -->
        <div class="bg-slate-950 text-white p-5 sm:p-6 relative overflow-hidden">
            <div class="flex items-center justify-between gap-3 mb-2">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-500/20 text-blue-300 border border-blue-400/30 font-bold text-[10px] uppercase tracking-wider rounded-lg">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                    E-Tiket Presensi Resmi
                </span>
                <span class="text-[11px] font-mono text-slate-400 font-bold tracking-wider">
                    {{ $participant->qr_token }}
                </span>
            </div>

            <h1 class="text-base sm:text-lg font-black text-white uppercase tracking-tight leading-snug">
                {{ $eventSettings['title'] ?? 'C LEVEL INDONESIA 2026' }}
            </h1>

            <div class="mt-3 pt-3 border-t border-slate-800/80 flex flex-wrap items-center gap-y-1.5 gap-x-4 text-xs text-slate-300">
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $eventSettings['date'] ?? '28 Oktober 2026' }}</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $eventSettings['time'] ?? '08:30 - 16:30 WIB' }}</span>
                </div>
                <div class="flex items-center gap-1.5 w-full">
                    <svg class="w-3.5 h-3.5 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="truncate">{{ $eventSettings['venue'] ?? 'Grand Ballroom C LEVEL Indonesia' }}</span>
                </div>
            </div>
        </div>

        <!-- Body Tiket -->
        <div class="p-5 sm:p-6 space-y-5">
            
            <!-- Box QR Code Presensi -->
            <div class="flex flex-col items-center justify-center p-6 bg-slate-50 border border-slate-200/90 rounded-2xl shadow-inner-xs text-center">
                
                <!-- QR Wrapper Putih Bersih dengan Margin -->
                <div class="p-3 bg-white border border-slate-300 rounded-xl shadow-xs inline-block">
                    <div id="qrcode" class="flex items-center justify-center"></div>
                </div>

                <!-- Token & Tombol Copy -->
                <div class="mt-3.5 flex items-center justify-center gap-2">
                    <span class="font-mono font-black text-base tracking-widest text-slate-900 bg-white px-3 py-1 rounded-lg border border-slate-300 shadow-2xs">
                        {{ $participant->qr_token }}
                    </span>
                    <button 
                        type="button" 
                        onclick="copyToken('{{ $participant->qr_token }}')" 
                        class="p-1.5 bg-white hover:bg-slate-100 text-slate-600 rounded-lg border border-slate-300 shadow-2xs transition-all cursor-pointer"
                        title="Salin Kode Tiket"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                        </svg>
                    </button>
                </div>

                <p class="text-[11px] text-slate-500 mt-2 max-w-xs leading-relaxed">
                    Tunjukkan QR Code ini pada layar HP Anda kepada petugas meja registrasi saat tiba di lokasi acara.
                </p>
            </div>

            <!-- Banner Status Presensi -->
            @if($participant->status === 'attended')
            <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-xl flex items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <span class="font-extrabold text-xs block text-emerald-900">TERVERIFIKASI HADIR</span>
                        <span class="text-[11px] text-emerald-700">Presensi berhasil dicatat petugas</span>
                    </div>
                </div>
                <span class="px-2.5 py-1 bg-white border border-emerald-300 font-bold text-[11px] text-emerald-800 rounded-lg shadow-2xs font-mono">
                    {{ $participant->attended_at ? $participant->attended_at->timezone('Asia/Jakarta')->format('H:i') . ' WIB' : 'Hadir' }}
                </span>
            </div>
            @else
            <div class="p-3.5 bg-amber-50 border border-amber-200 text-amber-900 rounded-xl flex items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-amber-500 text-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="font-extrabold text-xs block text-amber-900">TERDAFTAR RESMI</span>
                        <span class="text-[11px] text-amber-700">Menunggu kedatangan di meja registrasi</span>
                    </div>
                </div>
                <span class="px-2.5 py-1 bg-white border border-amber-300 font-bold text-[10px] text-amber-800 rounded-lg shadow-2xs uppercase">
                    Belum Hadir
                </span>
            </div>
            @endif

            <!-- Rincian Identitas Peserta -->
            <div class="border border-slate-200 divide-y divide-slate-100 text-xs rounded-xl overflow-hidden shadow-2xs">
                <div class="py-2.5 px-3.5 bg-slate-50/50 flex justify-between gap-3 items-center">
                    <span class="font-semibold text-slate-500 text-[11px]">Nama Tamu / Peserta</span>
                    <span class="font-bold text-slate-900 text-right">{{ $participant->name }}</span>
                </div>
                <div class="py-2.5 px-3.5 flex justify-between gap-3 items-center">
                    <span class="font-semibold text-slate-500 text-[11px]">Instansi / Perusahaan</span>
                    <span class="font-medium text-slate-800 text-right">{{ $participant->company ?? '-' }}</span>
                </div>
                @if($participant->position)
                <div class="py-2.5 px-3.5 bg-slate-50/50 flex justify-between gap-3 items-center">
                    <span class="font-semibold text-slate-500 text-[11px]">Jabatan / Posisi</span>
                    <span class="font-medium text-slate-800 text-right">{{ $participant->position }}</span>
                </div>
                @endif
                <div class="py-2.5 px-3.5 flex justify-between gap-3 items-center">
                    <span class="font-semibold text-slate-500 text-[11px]">Nomor WhatsApp</span>
                    <span class="font-mono font-medium text-slate-800 text-right">{{ $participant->phone }}</span>
                </div>
                @if($participant->email)
                <div class="py-2.5 px-3.5 bg-slate-50/50 flex justify-between gap-3 items-center">
                    <span class="font-semibold text-slate-500 text-[11px]">Alamat Email</span>
                    <span class="font-medium text-slate-800 text-right">{{ $participant->email }}</span>
                </div>
                @endif
            </div>

        </div>

        <!-- Ticket Footer Action Buttons -->
        <div class="p-4 sm:p-5 bg-slate-50 border-t border-slate-200/90 flex flex-col sm:flex-row gap-2.5 no-print">
            <button 
                type="button" 
                onclick="window.print()" 
                class="btn-3d-dark flex-1 py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl border border-slate-900 transition-all flex items-center justify-center gap-2 cursor-pointer"
            >
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Simpan PDF</span>
            </button>
            <a 
                href="{{ route('home') }}" 
                class="btn-3d-light py-2.5 px-4 bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs rounded-xl border border-slate-300 transition-all flex items-center justify-center gap-1.5 cursor-pointer text-center"
            >
                <span>Beranda Acara</span>
            </a>
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
                width: 180,
                height: 180,
                colorDark : "#0f172a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        }
    });

    function copyToken(token) {
        navigator.clipboard.writeText(token).then(() => {
            alert('Kode tiket ' + token + ' berhasil disalin!');
        }).catch(() => {
            prompt('Salin kode tiket:', token);
        });
    }
</script>
@endpush
