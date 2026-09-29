@extends('layouts.guest')

@section('title', 'Konfirmasi Kehadiran - ' . $settings['event_title'])

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6">

    <!-- Card Konfirmasi RSVP -->
    <div class="bg-white border border-slate-200 rounded-sm shadow-xs overflow-hidden">
        
        <!-- Header Banner Solid -->
        <div class="p-6 sm:p-7 text-center border-b {{ $isAttending ? 'bg-emerald-50 border-emerald-200 text-emerald-900' : 'bg-slate-100 border-slate-200 text-slate-800' }}">
            <div class="w-14 h-14 mx-auto mb-3.5 rounded-sm {{ $isAttending ? 'bg-emerald-600 text-white' : 'bg-slate-700 text-white' }} flex items-center justify-center shadow-xs">
                @if($isAttending)
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                @else
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                @endif
            </div>

            <span class="text-[10px] font-bold uppercase tracking-widest px-2.5 py-0.5 rounded-xs {{ $isAttending ? 'bg-emerald-200 text-emerald-900' : 'bg-slate-200 text-slate-800' }}">
                {{ $isAttending ? 'KONFIRMASI HADIR' : 'KONFIRMASI BERHALANGAN' }}
            </span>

            <h1 class="text-xl sm:text-2xl font-black mt-2 tracking-tight">
                {{ $isAttending ? 'Kehadiran Anda Telah Terkonfirmasi!' : 'Konfirmasi Berhalangan Telah Diterima' }}
            </h1>

            <p class="text-xs mt-1.5 leading-relaxed {{ $isAttending ? 'text-emerald-800' : 'text-slate-600' }}">
                Yth. <strong>{{ $participant->name }}</strong> ({{ $participant->company }})
            </p>
        </div>

        <!-- Body Penjelasan -->
        <div class="p-6 sm:p-7 space-y-5 text-xs text-slate-700">
            @if($isAttending)
                <div class="p-3.5 bg-emerald-50/70 border border-emerald-200 rounded-sm text-emerald-900 leading-relaxed">
                    Terima kasih atas konfirmasi kehadiran Anda. Tempat duduk dan tiket presensi digital Anda telah disiapkan oleh panitia.
                </div>
            @else
                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-sm text-slate-600 leading-relaxed">
                    Terima kasih atas pemberitahuan Bapak/Ibu. Kami sangat memahami kesibukan Anda dan berharap dapat berjumpa di kesempatan agenda C LEVEL berikutnya.
                </div>
            @endif

            <!-- Ringkasan Acara -->
            <div class="bg-slate-50 border border-slate-200 rounded-sm divide-y divide-slate-100">
                <div class="p-3 flex justify-between">
                    <span class="text-slate-500 text-[11px]">Kegiatan</span>
                    <strong class="text-slate-900 text-right max-w-xs">{{ $settings['event_title'] }}</strong>
                </div>
                <div class="p-3 flex justify-between">
                    <span class="text-slate-500 text-[11px]">Waktu</span>
                    <span class="text-slate-800 font-semibold">{{ $settings['event_date'] }} ({{ $settings['event_time'] }})</span>
                </div>
                <div class="p-3 flex justify-between">
                    <span class="text-slate-500 text-[11px]">Lokasi</span>
                    <span class="text-slate-800 font-semibold text-right">{{ $settings['event_venue_name'] }}</span>
                </div>
                <div class="p-3 flex justify-between">
                    <span class="text-slate-500 text-[11px]">Dresscode</span>
                    <span class="text-slate-800 font-semibold">{{ $settings['event_dresscode'] }}</span>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="space-y-2.5 pt-2">
                @if($isAttending)
                    <a 
                        href="{{ route('participants.card', $participant->qr_token) }}" 
                        class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors flex items-center justify-center gap-2 border border-slate-900 shadow-2xs"
                    >
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        <span>Buka E-Ticket Presensi QR Anda</span>
                    </a>

                    <div class="text-center pt-2">
                        <span class="text-slate-400 text-[11px]">Ada kendala mendadak? </span>
                        <a href="{{ route('participants.rsvp', ['token' => $participant->qr_token, 'status' => 'no']) }}" class="text-[11px] font-semibold text-rose-600 hover:underline">
                            Ubah menjadi Berhalangan
                        </a>
                    </div>
                @else
                    <a 
                        href="{{ route('participants.rsvp', ['token' => $participant->qr_token, 'status' => 'yes']) }}" 
                        class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-sm transition-colors flex items-center justify-center gap-2 border border-emerald-600 shadow-2xs"
                    >
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Saya Berubah Pikiran, Saya Pasti Hadir</span>
                    </a>

                    <div class="text-center pt-2">
                        <a href="{{ route('home') }}" class="text-[11px] font-semibold text-slate-500 hover:underline">
                            ← Kembali ke Beranda Acara
                        </a>
                    </div>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection
