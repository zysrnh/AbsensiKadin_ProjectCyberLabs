@extends('layouts.guest')

@section('title', 'Pendaftaran - ' . $settings['event_title'])

@push('styles')
<style>
    :root {
        --ease-expo: cubic-bezier(0.16, 1, 0.3, 1);
    }

    .card-glass {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%), rgba(12, 14, 20, 0.70);
        backdrop-filter: blur(36px) saturate(170%);
        -webkit-backdrop-filter: blur(36px) saturate(170%);
        border: 1px solid rgba(255, 255, 255, 0.10);
        box-shadow: 
            inset 0 1px 0 0 rgba(255, 255, 255, 0.20),
            0 4px 6px -1px rgba(0, 0, 0, 0.4),
            0 24px 50px -15px rgba(0, 0, 0, 0.85);
    }

    .card-glass-subtle {
        background: rgba(255, 255, 255, 0.035);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.12);
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
    .btn-glow-white:active {
        transform: translateY(1px);
    }

    .input-glass {
        background: rgba(10, 12, 17, 0.65);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #f8fafc;
        box-shadow: 
            inset 0 2px 4px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.04);
        transition: all 0.2s ease;
    }
    .input-glass:focus {
        background: rgba(14, 17, 24, 0.85);
        border-color: rgba(255, 255, 255, 0.40);
        box-shadow: 
            inset 0 1px 2px rgba(0, 0, 0, 0.3),
            0 0 0 3px rgba(255, 255, 255, 0.08);
        outline: none;
    }
    .input-glass::placeholder {
        color: #64748b;
    }
</style>
@endpush

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-4 space-y-6">

    <!-- Tombol Kembali ke Halaman Detail Acara -->
    <div>
        <a href="{{ route('home') }}" 
           class="inline-flex items-center gap-2 text-xs font-bold text-neutral-400 hover:text-white transition-colors py-2 px-3 rounded-lg hover:bg-white/10 group">
            <svg class="w-4 h-4 text-neutral-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span data-i18n="back_to_event">Kembali ke Detail Acara</span>
        </a>
    </div>

    <!-- Ringkasan Info Acara (Event Context Banner) -->
    <div class="card-glass-subtle p-4 sm:p-5 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="space-y-1 min-w-0">
            <span class="text-[10px] uppercase font-bold tracking-wider text-neutral-400 block" data-i18n="form_section_title">
                Formulir Pendaftaran
            </span>
            <h1 class="text-base sm:text-lg font-black text-white leading-snug truncate">
                {{ $settings['event_title'] }}
            </h1>
            <p class="text-xs text-neutral-300 flex items-center gap-1.5 truncate">
                <span>{{ $settings['event_date'] }}</span>
                <span>•</span>
                <span class="truncate">{{ $settings['event_venue_name'] }}</span>
            </p>
        </div>

        @if(!empty($settings['event_flyer']))
            <div class="w-14 h-14 rounded-xl overflow-hidden border border-white/15 shrink-0 hidden sm:block bg-black/60">
                <img src="{{ asset($settings['event_flyer']) }}" alt="Flyer" class="w-full h-full object-cover">
            </div>
        @endif
    </div>

    <!-- Wadah Card Form Terpisah (Standalone Registration Card) -->
    <div class="rounded-2xl sm:rounded-3xl p-6 sm:p-10 card-glass space-y-6">
        
        <!-- Header Form -->
        <div class="space-y-1.5 border-b border-white/10 pb-4">
            <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight" data-i18n="form_card_title">
                Data Calon Peserta
            </h2>
            <p class="text-xs text-neutral-400 font-normal" data-i18n="form_card_subtitle">
                Isi seluruh informasi dengan akurat untuk penerbitan tiket QR via WhatsApp.
            </p>
        </div>

        <!-- Alert Jika Pendaftaran Ditutup -->
        @if($isExpired)
            <div class="p-4 bg-neutral-900/80 border border-white/20 backdrop-blur-md rounded-xl text-xs text-neutral-200 flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-white/10 text-neutral-200 flex items-center justify-center shrink-0 border border-white/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="space-y-0.5">
                    <h4 class="font-bold text-white uppercase tracking-wider text-[11px]" data-i18n="closed_alert_title">Pendaftaran Telah Ditutup</h4>
                    <p class="text-neutral-300 leading-relaxed text-[11px]">
                        Mohon maaf, batas waktu pendaftaran untuk kegiatan ini telah berakhir pada <strong>{{ $settings['registration_deadline_text'] }}</strong>. Formulir tidak menerima pendaftaran baru.
                    </p>
                </div>
            </div>
        @endif

        <!-- Alert Error Validasi Input -->
        @if($errors->any())
            <div class="p-3.5 bg-neutral-900/80 border border-white/20 backdrop-blur-md text-neutral-200 rounded-xl text-xs">
                <p class="font-bold mb-1 text-white">Periksa kembali data Anda:</p>
                <ul class="list-disc list-inside space-y-0.5 ml-1 text-neutral-300">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulir Form Action POST -->
        <form action="{{ route('participants.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- 1. Nama Lengkap -->
            <div>
                <label for="name" class="block text-xs font-semibold text-neutral-300 uppercase tracking-wider mb-1.5">
                    <span data-i18n="label_name">Nama Lengkap</span> <span class="text-neutral-400">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name') }}" 
                    {{ $isExpired ? 'disabled' : 'required' }}
                    autofocus
                    placeholder="Nama Lengkap & Gelar (jika ada)"
                    data-i18n-placeholder="placeholder_name"
                    class="input-glass w-full px-4 py-3 {{ $isExpired ? 'cursor-not-allowed opacity-50' : '' }} {{ $errors->has('name') ? '!border-white/60' : '' }} rounded-xl text-xs sm:text-sm"
                >
            </div>

            <!-- 2. No Telpon / WhatsApp -->
            <div>
                <label for="phone" class="block text-xs font-semibold text-neutral-300 uppercase tracking-wider mb-1.5">
                    <span data-i18n="label_phone">Nomor WhatsApp Aktif</span> <span class="text-neutral-400">*</span>
                </label>
                <div class="relative">
                    <input 
                        type="tel" 
                        name="phone" 
                        id="phone" 
                        value="{{ old('phone') }}" 
                        {{ $isExpired ? 'disabled' : 'required' }}
                        placeholder="08xxxxxxxxxx"
                        data-i18n-placeholder="placeholder_phone"
                        class="input-glass w-full px-4 py-3 {{ $isExpired ? 'cursor-not-allowed opacity-50' : '' }} {{ $errors->has('phone') ? '!border-white/60' : '' }} rounded-xl text-xs sm:text-sm"
                    >
                    <div class="absolute right-3.5 top-3.5 text-neutral-400 pointer-events-none">
                        <svg class="w-4 h-4 text-neutral-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.043.073.043.419-.101.824z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- 3. Perusahaan & 4. Jabatan (Grid 2 Kolom) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Company -->
                <div>
                    <label for="company" class="block text-xs font-semibold text-neutral-300 uppercase tracking-wider mb-1.5">
                        <span data-i18n="label_company">Instansi / Perusahaan</span> <span class="text-neutral-400">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="company" 
                        id="company" 
                        value="{{ old('company') }}" 
                        {{ $isExpired ? 'disabled' : 'required' }}
                        placeholder="Nama Perusahaan / Organisasi"
                        data-i18n-placeholder="placeholder_company"
                        class="input-glass w-full px-4 py-3 {{ $isExpired ? 'cursor-not-allowed opacity-50' : '' }} {{ $errors->has('company') ? '!border-white/60' : '' }} rounded-xl text-xs sm:text-sm"
                    >
                </div>

                <!-- Position -->
                <div>
                    <label for="position" class="block text-xs font-semibold text-neutral-300 uppercase tracking-wider mb-1.5">
                        <span data-i18n="label_position">Jabatan / Posisi</span> <span class="text-neutral-400">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="position" 
                        id="position" 
                        value="{{ old('position') }}" 
                        {{ $isExpired ? 'disabled' : 'required' }}
                        placeholder="CEO, Direktur, Manager, dll"
                        data-i18n-placeholder="placeholder_position"
                        class="input-glass w-full px-4 py-3 {{ $isExpired ? 'cursor-not-allowed opacity-50' : '' }} {{ $errors->has('position') ? '!border-white/60' : '' }} rounded-xl text-xs sm:text-sm"
                    >
                </div>
            </div>

            <!-- 5. Email (Opsional) -->
            <div>
                <label for="email" class="block text-xs font-semibold text-neutral-300 uppercase tracking-wider mb-1.5">
                    <span data-i18n="label_email">Alamat Email</span> <span class="text-neutral-400 font-normal">(Opsional)</span>
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email') }}" 
                    {{ $isExpired ? 'disabled' : '' }}
                    placeholder="nama@perusahaan.com"
                    data-i18n-placeholder="placeholder_email"
                    class="input-glass w-full px-4 py-3 {{ $isExpired ? 'cursor-not-allowed opacity-50' : '' }} {{ $errors->has('email') ? '!border-white/60' : '' }} rounded-xl text-xs sm:text-sm"
                >
            </div>

            <!-- Tombol Submit Request to Join -->
            <div class="pt-3">
                @if($isExpired)
                    <button 
                        type="button" 
                        disabled
                        class="w-full py-4 px-5 bg-white/5 text-neutral-500 font-semibold text-xs sm:text-sm rounded-xl cursor-not-allowed flex items-center justify-center gap-2 border border-white/10"
                    >
                        <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span data-i18n="btn_closed">Pendaftaran Telah Ditutup</span>
                    </button>
                @else
                    <button 
                        type="submit" 
                        class="btn-glow-white w-full py-4 px-6 font-black text-xs sm:text-sm tracking-wide rounded-xl cursor-pointer flex items-center justify-center gap-2 text-neutral-950 hover:scale-[1.01] active:scale-[0.99] transition-all shadow-xl"
                    >
                        <span data-i18n="btn_submit">Request to Join / Kirim Pendaftaran</span>
                        <svg class="w-4 h-4 text-neutral-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                @endif
            </div>

        </form>

    </div>

</div>
@endsection
