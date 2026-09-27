@extends('layouts.guest')

@section('title', $settings['event_title'] . ' - Registrasi KADIN')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6">

    <!-- Grid 2 Kolom Ala Luma: Info Acara (Kiri) & Form Pendaftaran Sticky (Kanan) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SISI KIRI: Flyer, Jadwal, Lokasi, Dresscode & Deskripsi Acara -->
        <div class="lg:col-span-7 space-y-6">

            <!-- 1. Flyer / Poster Acara -->
            <div class="border border-slate-200 rounded-sm bg-white overflow-hidden shadow-xs">
                @if(!empty($settings['event_flyer']))
                    <img 
                        src="{{ asset($settings['event_flyer']) }}" 
                        alt="{{ $settings['event_title'] }}" 
                        class="w-full h-auto max-h-[380px] object-cover"
                    >
                @else
                    <!-- Default Minimalist Visual Banner Flat -->
                    <div class="w-full bg-slate-900 text-white p-8 sm:p-10 flex flex-col justify-between min-h-[220px]">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 bg-white text-slate-950 font-black text-xs tracking-widest uppercase rounded-sm">
                                KADIN EVENT
                            </span>
                            <span class="text-xs text-slate-300 font-mono">EDISI 2026</span>
                        </div>
                        <div class="mt-6">
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight">
                                {{ $settings['event_title'] }}
                            </h2>
                            <p class="text-xs text-slate-400 mt-2">Kamar Dagang dan Industri Indonesia</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- 2. Judul Acara & Host -->
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-2.5 py-1 bg-slate-100 border border-slate-200 text-slate-700 text-xs font-semibold rounded-sm">
                    <span class="w-2 h-2 rounded-full bg-slate-900"></span>
                    <span>Diselenggarakan oleh {{ $settings['event_organizer'] }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight leading-tight">
                    {{ $settings['event_title'] }}
                </h1>
            </div>

            <!-- 3. Kotak Meta Info: Tanggal, Waktu & Dresscode -->
            <div class="bg-white border border-slate-200 rounded-sm divide-y divide-slate-100 shadow-xs">
                
                <!-- Tanggal & Jam Pelaksanaan -->
                <div class="p-4 flex items-start gap-3.5">
                    <div class="w-9 h-9 bg-slate-100 border border-slate-200 rounded-sm flex items-center justify-center shrink-0 text-slate-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Waktu & Tanggal</span>
                        <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $settings['event_date'] }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $settings['event_time'] }}</p>
                    </div>
                </div>

                <!-- Dresscode Acara (Request Khusus) -->
                <div class="p-4 flex items-start gap-3.5">
                    <div class="w-9 h-9 bg-slate-100 border border-slate-200 rounded-sm flex items-center justify-center shrink-0 text-slate-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Dresscode</span>
                        <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $settings['event_dresscode'] }}</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Harap mengenakan pakaian sesuai ketentuan kegiatan.</p>
                    </div>
                </div>

                <!-- Tempat / Lokasi Venue -->
                <div class="p-4 flex items-start gap-3.5">
                    <div class="w-9 h-9 bg-slate-100 border border-slate-200 rounded-sm flex items-center justify-center shrink-0 text-slate-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Lokasi & Venue</span>
                        <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $settings['event_venue_name'] }}</p>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">{{ $settings['event_venue_address'] }}</p>

                        @if(!empty($settings['event_maps_url']))
                            <div class="mt-2.5">
                                <a 
                                    href="{{ $settings['event_maps_url'] }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-semibold rounded-sm border border-slate-300 transition-colors"
                                >
                                    <span>Buka di Google Maps</span>
                                    <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- 4. Peta Google Maps Embed Iframe (Jika Tersedia) -->
            @if(!empty($settings['event_maps_iframe']))
                <div class="bg-white border border-slate-200 rounded-sm p-4 shadow-xs space-y-2">
                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wider block">Peta Lokasi Interaktif</span>
                    <div class="w-full overflow-hidden rounded-sm border border-slate-200 aspect-video [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:border-0">
                        {!! $settings['event_maps_iframe'] !!}
                    </div>
                </div>
            @endif

            <!-- 5. Deskripsi Acara -->
            @if(!empty($settings['event_description']))
                <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-xs space-y-2">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Tentang Kegiatan</h3>
                    <div class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">
                        {{ $settings['event_description'] }}
                    </div>
                </div>
            @endif

        </div>

        <!-- SISI KANAN: Form Pendaftaran Sticky Card Ala Luma -->
        <div class="lg:col-span-5 lg:sticky lg:top-8 space-y-4">

            <!-- Card Formulir Pendaftaran -->
            <div class="bg-white border border-slate-200 rounded-sm shadow-xs p-6 sm:p-7">
                
                <div class="border-b border-slate-100 pb-4 mb-5">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold tracking-wider uppercase text-emerald-800 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-sm">
                            Registrasi Dibuka
                        </span>
                        <span class="text-xs font-bold text-slate-900">GRATIS</span>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900 mt-2 tracking-tight">Formulir Peserta</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Lengkapi data diri untuk penerbitan tiket QR Code resmi.</p>
                </div>

                <!-- Alert Error Validasi -->
                @if($errors->any())
                    <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-sm text-xs">
                        <div class="font-bold mb-1 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Periksa kembali isian Anda:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-0.5 ml-2 text-rose-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Submit 4 Field Wajib -->
                <form action="{{ route('participants.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- 1. Nama -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name') }}" 
                            required 
                            placeholder="Contoh: Budi Santoso, S.E."
                            class="w-full px-3.5 py-2.5 bg-white border {{ $errors->has('name') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} rounded-sm text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                        >
                    </div>

                    <!-- 2. No Telpon / WhatsApp -->
                    <div>
                        <label for="phone" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            No. Telepon / WhatsApp <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phone" 
                            value="{{ old('phone') }}" 
                            required 
                            placeholder="Contoh: 081234567890"
                            class="w-full px-3.5 py-2.5 bg-white border {{ $errors->has('phone') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} rounded-sm text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                        >
                    </div>

                    <!-- 3. Jabatan -->
                    <div>
                        <label for="position" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Jabatan <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="position" 
                            id="position" 
                            value="{{ old('position') }}" 
                            required 
                            placeholder="Contoh: Direktur Utama / Manajer"
                            class="w-full px-3.5 py-2.5 bg-white border {{ $errors->has('position') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} rounded-sm text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                        >
                    </div>

                    <!-- 4. Company -->
                    <div>
                        <label for="company" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Company / Instansi <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="company" 
                            id="company" 
                            value="{{ old('company') }}" 
                            required 
                            placeholder="Contoh: PT Sumber Pangan Nusantara"
                            class="w-full px-3.5 py-2.5 bg-white border {{ $errors->has('company') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} rounded-sm text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                        >
                    </div>

                    <!-- Info Box Tiket QR -->
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-sm text-[11px] text-slate-600 flex items-start gap-2">
                        <svg class="w-4 h-4 text-slate-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Tiket resmi QR Code akan langsung diterbitkan di layar setelah formulir dikirim.</span>
                    </div>

                    <!-- Tombol Submit Solid Charcoal -->
                    <div class="pt-2">
                        <button 
                            type="submit" 
                            class="w-full py-3 px-4 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm rounded-sm transition-colors cursor-pointer flex items-center justify-center gap-2 border border-slate-900 shadow-2xs"
                        >
                            <span>Daftar Acara Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>

</div>
@endsection
