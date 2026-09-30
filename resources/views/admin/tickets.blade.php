@extends('layouts.admin')

@section('title', 'Kirim Tiket QR Presensi - C Level 2026')
@section('page_title', 'Kirim Tiket QR')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Kirim Tiket Presensi QR</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kirimkan kartu tiket masuk ber-QR Code kepada peserta yang telah disetujui / terdaftar via WhatsApp.</p>
        </div>

        <div class="flex items-center flex-wrap gap-2">
            <!-- Pengaturan Twilio & Template -->
            <a href="{{ route('admin.wa-settings') }}" class="btn-3d-white px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition-all flex items-center gap-1.5 shadow-2xs">
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Pengaturan Twilio & Template</span>
            </a>

            <!-- Tombol Dashboard (Text-only) -->
            <a href="{{ route('admin.dashboard') }}" class="btn-3d-white px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 shadow-2xs transition-all">
                Dashboard
            </a>
        </div>
    </div>

    <!-- Grid: Form & List Kiri (7 cols), Live Preview QR Kanan (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Kolom Kiri: Generator Tiket & Tabel Peserta (7 cols) -->
        <div class="lg:col-span-7 space-y-5">
            
            <!-- Card 1: Generator Pesan Tiket QR -->
            <div class="card-3d p-5 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Generator Tiket Presensi QR</h2>
                        <p class="text-[11px] text-slate-400">Sesuaikan data peserta dan format pesan tiket QR sebelum dikirimkan.</p>
                    </div>
                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-full border border-blue-200/80 font-mono">
                        Tiket Presensi
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Peserta -->
                    <div>
                        <label for="ticketNameInput" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Peserta <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="ticketNameInput" 
                            value="{{ $sample->name }}" 
                            placeholder="Contoh: Budi Santoso, S.E."
                            class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                            oninput="updateTicketMessage()"
                        >
                    </div>

                    <!-- Nomor WhatsApp -->
                    <div>
                        <label for="ticketPhoneInput" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nomor WhatsApp <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="tel" 
                            id="ticketPhoneInput" 
                            value="{{ $sample->phone }}"
                            placeholder="081234567890" 
                            class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                        >
                    </div>

                    <!-- Instansi / Perusahaan -->
                    <div>
                        <label for="ticketCompanyInput" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Instansi / Perusahaan
                        </label>
                        <input 
                            type="text" 
                            id="ticketCompanyInput" 
                            value="{{ $sample->company }}" 
                            placeholder="Contoh: PT Sumber Pangan Nusantara"
                            class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all font-semibold"
                            oninput="updateTicketMessage()"
                        >
                    </div>

                    <!-- Jabatan & Token QR -->
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="ticketPositionInput" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Jabatan
                            </label>
                            <input 
                                type="text" 
                                id="ticketPositionInput" 
                                value="{{ $sample->position }}" 
                                placeholder="Contoh: Direktur"
                                class="input-3d w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                                oninput="updateTicketMessage()"
                            >
                        </div>
                        <div>
                            <label for="ticketTokenInput" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Kode Tiket
                            </label>
                            <input 
                                type="text" 
                                id="ticketTokenInput" 
                                value="{{ $sample->qr_token }}" 
                                placeholder="CL26-XXXX"
                                class="input-3d w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-900 uppercase focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                                oninput="onQrTokenChanged()"
                            >
                        </div>
                    </div>
                </div>

                <!-- Helper Variabel Cepat -->
                <div>
                    <span class="text-[11px] font-semibold text-slate-600 block mb-1.5">Sisipkan variabel ke kursor:</span>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" onclick="insertTicketVar('{nama}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg border border-slate-200 cursor-pointer transition-all">
                            {nama}
                        </button>
                        <button type="button" onclick="insertTicketVar('{instansi}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg border border-slate-200 cursor-pointer transition-all">
                            {instansi}
                        </button>
                        <button type="button" onclick="insertTicketVar('{jabatan}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg border border-slate-200 cursor-pointer transition-all">
                            {jabatan}
                        </button>
                        <button type="button" onclick="insertTicketVar('{kode_tiket}')" class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-800 text-[11px] font-mono font-bold rounded-lg border border-blue-200 cursor-pointer transition-all">
                            {kode_tiket}
                        </button>
                        <button type="button" onclick="insertTicketVar('{link_tiket}')" class="px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-[11px] font-mono font-bold rounded-lg border border-emerald-200 cursor-pointer transition-all">
                            {link_tiket}
                        </button>
                    </div>
                </div>

                <!-- Textarea Template Pesan Tiket -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="ticketTextArea" class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Isi Pesan WhatsApp Tiket <span class="text-rose-500">*</span>
                        </label>
                        <button type="button" onclick="resetToDefaultTicketTemplate()" class="text-[11px] font-medium text-slate-500 hover:text-slate-800 underline cursor-pointer">
                            Reset ke template asal
                        </button>
                    </div>
                    <textarea 
                        id="ticketTextArea" 
                        rows="8" 
                        class="input-3d w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono text-slate-900 leading-relaxed focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                        oninput="onTicketTextManualInput()"
                    ></textarea>
                    <div class="mt-1.5 text-[11px] text-slate-500 flex items-center justify-between">
                        <span>Pesan menyertakan link tiket web & gambar QR Code via Twilio</span>
                        <span id="ticketCharCount" class="font-mono text-slate-400">0 karakter</span>
                    </div>
                </div>

                <!-- Action Buttons: 3 Opsi Pengiriman Tiket -->
                <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center gap-2.5">
                    
                    <!-- 1. Salin Teks -->
                    <button 
                        type="button" 
                        onclick="copyTicketMessage()" 
                        class="btn-3d-dark px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl border border-slate-900 transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                        </svg>
                        <span>Salin Pesan Tiket</span>
                    </button>

                    <!-- 2. Buka WA Web -->
                    <button 
                        type="button" 
                        onclick="openTicketWaWeb()" 
                        class="btn-3d-dark px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl border border-emerald-600 transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.299.144.35.49 1.199.533 1.286.044.087.073.189.014.305-.058.115-.087.188-.173.289l-.26.309c-.087.095-.179.199-.077.375.101.173.454.747.973 1.21 0.672.6 1.238.788 1.413.875.174.087.276.073.377-.044.101-.116.433-.506.549-.68.116-.173.232-.144.39-.087s1.011.477 1.184.564.289.13.332.202c.044.072.044.419-.1.824z" />
                        </svg>
                        <span>Buka WhatsApp Web</span>
                    </button>

                    <!-- 3. Blast Twilio (Dengan MediaUrl Gambar QR Asli) -->
                    <button 
                        type="button" 
                        onclick="sendSingleTicketTwilio()" 
                        class="btn-3d-blue px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl border border-blue-600 transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>Kirim via Twilio API</span>
                    </button>

                </div>

            </div>

            <!-- Card 2: Daftar Peserta & Tiket QR Terdaftar -->
            <div class="card-3d p-5 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Peserta Terdaftar</h2>
                            <span class="px-2.5 py-0.5 bg-slate-100 text-slate-700 text-[10px] font-bold rounded-full border border-slate-200 font-mono">
                                {{ $participants->count() }} Peserta
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-400">Pilih peserta untuk mengirimkan tiket via Twilio atau klik untuk preview.</p>
                    </div>

                    <!-- Input Filter Cari Cepat -->
                    <div class="w-full sm:w-64">
                        <input 
                            type="text" 
                            id="searchParticipantInput" 
                            placeholder="Cari nama / token / instansi..." 
                            class="input-3d w-full px-3.5 py-2 bg-slate-50 border border-slate-200 text-xs rounded-xl focus:outline-none focus:border-blue-600 focus:bg-white"
                            oninput="filterParticipantTable()"
                        >
                    </div>
                </div>

                <!-- Checkbox Toolbar & Bulk Action -->
                <div class="p-3 bg-slate-50/80 border border-slate-200/80 rounded-xl flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <label class="flex items-center gap-2 text-xs font-semibold text-slate-800 cursor-pointer select-none">
                            <input 
                                type="checkbox" 
                                id="selectAllParticipantCheckbox" 
                                onchange="toggleSelectAllParticipants(this)" 
                                class="rounded-sm border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer"
                            >
                            <span>Pilih Semua Peserta</span>
                        </label>
                        <span class="text-slate-300">|</span>
                        <span id="selectedTicketBadge" class="text-xs font-medium text-slate-500">
                            0 peserta dipilih
                        </span>
                    </div>

                    <!-- Tombol Blast Twilio Massal -->
                    <button 
                        type="button" 
                        id="btnBulkTicketTwilio" 
                        onclick="sendBulkTicketTwilio()" 
                        disabled
                        class="w-full sm:w-auto btn-3d-blue px-4 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-slate-300 disabled:border-slate-300 disabled:shadow-none disabled:cursor-not-allowed text-white font-bold text-xs rounded-xl border border-blue-600 transition-all flex items-center justify-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>Blast Tiket ke (<span id="bulkTicketNum">0</span>) Terpilih</span>
                    </button>
                </div>

                <!-- Tabel Peserta -->
                <div class="overflow-x-auto border border-slate-200/80 rounded-xl max-h-[380px] overflow-y-auto">
                    <table class="w-full text-left text-xs text-slate-700 divide-y divide-slate-200">
                        <thead class="bg-slate-50 text-[11px] font-bold text-slate-700 uppercase tracking-wider sticky top-0 z-10 shadow-2xs">
                            <tr>
                                <th scope="col" class="w-10 px-3 py-2.5 text-center">&bull;</th>
                                <th scope="col" class="px-3.5 py-2.5">Peserta & Instansi</th>
                                <th scope="col" class="px-3 py-2.5">Kode Tiket</th>
                                <th scope="col" class="px-3 py-2.5">Status</th>
                                <th scope="col" class="px-3 py-2.5 text-right">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody id="participantTableBody" class="divide-y divide-slate-100 bg-white">
                            @forelse($participants as $p)
                            <tr class="hover:bg-slate-50 transition-colors participant-row" data-name="{{ strtolower($p->name) }}" data-company="{{ strtolower($p->company) }}" data-token="{{ strtolower($p->qr_token) }}">
                                <td class="px-3 py-2.5 text-center">
                                    <input 
                                        type="checkbox" 
                                        value="{{ $p->id }}" 
                                        class="ticket-checkbox rounded-sm border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer"
                                        onchange="onTicketCheckboxChange()"
                                    >
                                </td>
                                <td class="px-3.5 py-2.5">
                                    <span class="font-bold text-slate-900 block leading-tight">{{ $p->name }}</span>
                                    <span class="text-[11px] text-slate-500">{{ $p->company }} &bull; {{ $p->position }}</span>
                                    <span class="text-[10px] text-slate-400 font-mono block mt-0.5">{{ $p->phone }}</span>
                                </td>
                                <td class="px-3 py-2.5 font-mono text-slate-800 text-[11px]">
                                    <span class="px-2 py-0.5 bg-slate-100 border border-slate-200 rounded-md font-bold">{{ $p->qr_token }}</span>
                                </td>
                                <td class="px-3 py-2.5">
                                    @if($p->status === 'attended')
                                        <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200/80 rounded-full">
                                            Hadir
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 text-[10px] font-bold border border-amber-200/80 rounded-full">
                                            Terdaftar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-2.5 text-right whitespace-nowrap space-x-1">
                                    <!-- Muat ke Generator -->
                                    <button 
                                        type="button" 
                                        onclick="pickParticipantToEditor('{{ addslashes($p->name) }}', '{{ $p->phone }}', '{{ addslashes($p->company) }}', '{{ addslashes($p->position) }}', '{{ $p->qr_token }}')" 
                                        title="Muat data ke form editor & pratinjau QR"
                                        class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-[10px] rounded-lg border border-slate-200 transition cursor-pointer"
                                    >
                                        Pilih
                                    </button>
                                    <!-- WA Web Tiket -->
                                    <button 
                                        type="button" 
                                        onclick="directTicketWaWeb('{{ addslashes($p->name) }}', '{{ $p->phone }}', '{{ addslashes($p->company) }}', '{{ addslashes($p->position) }}', '{{ $p->qr_token }}')" 
                                        title="Langsung chat WhatsApp Web tiket ini"
                                        class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] rounded-lg transition cursor-pointer shadow-2xs"
                                    >
                                        WA Web
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-400 text-xs">
                                    Belum ada data peserta yang terdaftar di database.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Live Mockup Chat WhatsApp dengan Gambar QR Code Asli (5 cols) -->
        <div class="lg:col-span-5 sticky top-20">
            <div class="card-3d overflow-hidden">
                
                <!-- Mockup Phone Header WA -->
                <div class="bg-[#075e54] text-white px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs uppercase">
                            CL
                        </div>
                        <div>
                            <span class="text-xs font-bold block leading-tight">C LEVEL INDONESIA 2026</span>
                            <span class="text-[10px] text-emerald-200">Online &bull; Tiket Presensi Resmi</span>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-white/90 bg-black/20 px-2 py-0.5 rounded-full">
                        Live Preview QR
                    </span>
                </div>

                <!-- Mockup Chat Wallpaper / Background -->
                <div class="bg-[#efeae2] p-4 min-h-[460px] max-h-[580px] overflow-y-auto space-y-3 font-sans text-xs">
                    
                    <div class="text-center">
                        <span class="px-2.5 py-0.5 bg-white/85 text-slate-500 text-[10px] font-semibold rounded-full shadow-2xs inline-block">
                            HARI INI
                        </span>
                    </div>

                    <!-- Chat Bubble Masuk -->
                    <div class="max-w-[92%] bg-white rounded-2xl rounded-tl-sm shadow-xs p-3.5 space-y-2.5 border border-slate-200/50">
                        
                        <!-- QR Code Container Asli -->
                        <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-3 text-center">
                            <div class="flex justify-center">
                                <div id="previewTicketQrcode" class="p-2 bg-white border border-slate-200 rounded-lg inline-block shadow-2xs"></div>
                            </div>
                            <span id="previewTicketQrTokenText" class="font-mono font-bold text-[11px] text-slate-800 mt-2 block">{{ $sample->qr_token }}</span>
                            <span class="text-[10px] text-slate-400 block">Gambar Tiket QR Masuk Acara</span>
                        </div>

                        <!-- Text Body Message Live -->
                        <div id="previewTicketMessageBody" class="text-xs text-slate-800 whitespace-pre-line leading-relaxed font-sans">
                            <!-- Diisi via JavaScript -->
                        </div>

                        <!-- Chat Timestamp & Double Checkmarks -->
                        <div class="flex items-center justify-end space-x-1 text-[10px] text-slate-400 pt-1">
                            <span>{{ date('H:i') }}</span>
                            <svg class="w-3.5 h-3.5 text-blue-500 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7m-14 4l4 4L19 7" />
                            </svg>
                        </div>
                    </div>

                </div>

                <!-- Mockup Chat Input Footer -->
                <div class="bg-slate-50 border-t border-slate-200 p-3 flex items-center justify-between text-[11px] text-slate-500">
                    <span>Peserta melihat gambar QR tiket langsung di chat</span>
                    <span class="font-mono text-slate-400">WhatsApp App</span>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    const rawDefaultTicketTemplate = @json($template);

    const nameInput = document.getElementById('ticketNameInput');
    const phoneInput = document.getElementById('ticketPhoneInput');
    const companyInput = document.getElementById('ticketCompanyInput');
    const positionInput = document.getElementById('ticketPositionInput');
    const tokenInput = document.getElementById('ticketTokenInput');
    const textArea = document.getElementById('ticketTextArea');
    const previewBody = document.getElementById('previewTicketMessageBody');
    const previewTokenText = document.getElementById('previewTicketQrTokenText');
    const charCountEl = document.getElementById('ticketCharCount');

    let currentQrCodeInstance = null;

    function buildTicketTemplate(data) {
        let text = rawDefaultTicketTemplate;
        const linkTiket = "{{ url('/ticket') }}/" + (data.kode_tiket || 'TOKEN');
        text = text.replaceAll('{nama}', data.nama || 'Peserta C LEVEL')
                   .replaceAll('{instansi}', data.instansi || '-')
                   .replaceAll('{jabatan}', data.jabatan || '-')
                   .replaceAll('{kode_tiket}', data.kode_tiket || 'CL26-XXXXX')
                   .replaceAll('{link_tiket}', linkTiket);
        return text;
    }

    function getCurrentFormData() {
        return {
            nama: nameInput.value.trim(),
            phone: phoneInput.value.trim(),
            instansi: companyInput.value.trim(),
            jabatan: positionInput.value.trim(),
            kode_tiket: tokenInput.value.trim().toUpperCase()
        };
    }

    function renderQr(token) {
        const qrEl = document.getElementById("previewTicketQrcode");
        if (!qrEl) return;
        qrEl.innerHTML = '';
        currentQrCodeInstance = new QRCode(qrEl, {
            text: token || 'CL26-EXMPL',
            width: 130,
            height: 130,
            colorDark : "#0f172a",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.M
        });
        previewTokenText.textContent = token || '-';
    }

    function initPage() {
        const data = getCurrentFormData();
        const initialText = buildTicketTemplate(data);
        textArea.value = initialText;
        updatePreview(initialText);
        renderQr(data.kode_tiket);
    }

    function updateTicketMessage() {
        const data = getCurrentFormData();
        const text = buildTicketTemplate(data);
        textArea.value = text;
        updatePreview(text);
    }

    function onQrTokenChanged() {
        const data = getCurrentFormData();
        renderQr(data.kode_tiket);
        updateTicketMessage();
    }

    function onTicketTextManualInput() {
        updatePreview(textArea.value);
    }

    function updatePreview(text) {
        previewBody.textContent = text;
        charCountEl.textContent = text.length + ' karakter';
    }

    function resetToDefaultTicketTemplate() {
        updateTicketMessage();
    }

    function insertTicketVar(tag) {
        const start = textArea.selectionStart;
        const end = textArea.selectionEnd;
        const text = textArea.value;
        textArea.value = text.substring(0, start) + tag + text.substring(end);
        textArea.focus();
        textArea.selectionStart = textArea.selectionEnd = start + tag.length;
        updatePreview(textArea.value);
    }

    // 1. Salin Teks Tiket
    function copyTicketMessage() {
        const text = textArea.value;
        if (!text) return;

        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Pesan tiket berhasil disalin ke clipboard!',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
        }).catch(() => {
            textArea.select();
            document.execCommand('copy');
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Pesan tiket disalin!',
                showConfirmButton: false,
                timer: 2000
            });
        });
    }

    // 2. Buka WhatsApp Web Tiket
    function openTicketWaWeb() {
        const phone = phoneInput.value.trim();
        const text = textArea.value;
        
        let cleanPhone = phone.replace(/[^0-9]/g, '');
        if (cleanPhone.startsWith('0')) {
            cleanPhone = '62' + cleanPhone.substring(1);
        }

        const encoded = encodeURIComponent(text);
        let url = cleanPhone ? `https://wa.me/${cleanPhone}?text=${encoded}` : `https://web.whatsapp.com/send?text=${encoded}`;
        window.open(url, '_blank');
    }

    // 3. Kirim 1 Tiket via Twilio
    function sendSingleTicketTwilio() {
        const phone = phoneInput.value.trim();
        const name = nameInput.value.trim();
        const message = textArea.value.trim();

        if (!phone) {
            Swal.fire({
                icon: 'warning',
                title: 'Nomor WhatsApp Kosong',
                text: 'Silakan isi nomor WhatsApp tujuan terlebih dahulu.',
                confirmButtonColor: '#0f172a'
            });
            phoneInput.focus();
            return;
        }

        Swal.fire({
            title: 'Kirim Tiket QR Twilio?',
            text: `Kirim tiket presensi QR ke nomor "${phone}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1d4ed8',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Kirim Tiket',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Mengirim Tiket...',
                    text: 'Menghubungkan ke Twilio REST API...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch("{{ route('admin.tickets.send-single') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        phone: phone,
                        custom_message: message
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Tiket Terkirim!',
                            text: data.message || 'Tiket QR berhasil dikirim via WhatsApp Twilio.',
                            confirmButtonColor: '#0f172a'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Mengirim',
                            text: data.message || 'Terjadi kesalahan saat kirim tiket.',
                            confirmButtonColor: '#0f172a'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Koneksi',
                        text: 'Tidak dapat menghubungi server API Twilio.',
                        confirmButtonColor: '#0f172a'
                    });
                });
            }
        });
    }

    // CHECKBOX & BULK ACTIONS TIKET
    function toggleSelectAllParticipants(master) {
        const checkboxes = document.querySelectorAll('.ticket-checkbox');
        checkboxes.forEach(cb => {
            const row = cb.closest('tr');
            if (row && row.style.display !== 'none') {
                cb.checked = master.checked;
            }
        });
        updateTicketBulkUI();
    }

    function onTicketCheckboxChange() {
        updateTicketBulkUI();
    }

    function updateTicketBulkUI() {
        const selected = document.querySelectorAll('.ticket-checkbox:checked');
        const count = selected.length;
        const total = document.querySelectorAll('.ticket-checkbox').length;
        
        document.getElementById('selectedTicketBadge').textContent = `${count} peserta dipilih`;
        document.getElementById('bulkTicketNum').textContent = count;
        
        const btnBulk = document.getElementById('btnBulkTicketTwilio');
        btnBulk.disabled = (count === 0);

        const selectAll = document.getElementById('selectAllParticipantCheckbox');
        if (selectAll) {
            selectAll.checked = (count > 0 && count === total);
            selectAll.indeterminate = (count > 0 && count < total);
        }
    }

    function filterParticipantTable() {
        const query = document.getElementById('searchParticipantInput').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.participant-row');
        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const company = row.getAttribute('data-company') || '';
            const token = row.getAttribute('data-token') || '';
            if (name.includes(query) || company.includes(query) || token.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        updateTicketBulkUI();
    }

    // Pilih peserta ke Form Editor
    function pickParticipantToEditor(name, phone, company, position, token) {
        nameInput.value = name;
        phoneInput.value = phone;
        companyInput.value = company;
        positionInput.value = position;
        tokenInput.value = token;

        renderQr(token);
        updateTicketMessage();

        window.scrollTo({ top: 0, behavior: 'smooth' });
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'info',
            title: `Tiket "${name}" dimuat ke editor!`,
            showConfirmButton: false,
            timer: 2000
        });
    }

    // Direct WhatsApp Web Tiket untuk 1 peserta
    function directTicketWaWeb(name, phone, company, position, token) {
        const data = {
            nama: name,
            instansi: company,
            jabatan: position,
            kode_tiket: token
        };
        const message = buildTicketTemplate(data);
        let cleanPhone = phone.replace(/[^0-9]/g, '');
        if (cleanPhone.startsWith('0')) {
            cleanPhone = '62' + cleanPhone.substring(1);
        }
        const encoded = encodeURIComponent(message);
        window.open(`https://wa.me/${cleanPhone}?text=${encoded}`, '_blank');
    }

    // Blast Tiket Twilio Massal
    function sendBulkTicketTwilio() {
        const selected = document.querySelectorAll('.ticket-checkbox:checked');
        const ids = Array.from(selected).map(cb => cb.value);

        if (ids.length === 0) return;

        Swal.fire({
            title: `Blast Tiket QR ke ${ids.length} Peserta?`,
            text: `Sistem akan mengirimkan tiket presensi QR Code via WhatsApp Twilio ke seluruh ${ids.length} peserta terpilih. Lanjutkan?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1d4ed8',
            cancelButtonColor: '#64748b',
            confirmButtonText: `Ya, Blast Tiket (${ids.length})`,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses Blast Tiket...',
                    text: `Sedang mengirim tiket QR ke ${ids.length} nomor WhatsApp...`,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch("{{ route('admin.tickets.send-bulk') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ids: ids,
                        custom_message: textArea.value.trim()
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Blast Tiket Selesai!',
                            text: data.message,
                            confirmButtonColor: '#0f172a'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Blast Gagal',
                            text: data.message || 'Terjadi kesalahan saat blast tiket.',
                            confirmButtonColor: '#0f172a'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Koneksi',
                        text: 'Tidak dapat menghubungi server API Twilio.',
                        confirmButtonColor: '#0f172a'
                    });
                });
            }
        });
    }

    document.addEventListener('DOMContentLoaded', initPage);
</script>
@endpush
