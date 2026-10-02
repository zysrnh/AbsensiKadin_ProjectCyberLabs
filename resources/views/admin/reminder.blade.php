@extends('layouts.admin')

@section('title', 'Kirim Pengingat (Reminder & RSVP) - Wonderful 2026')
@section('page_title', 'Kirim Reminder Acara')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Kirim Pengingat & Konfirmasi Kehadiran</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kirim pengingat acara (H-3, H-1, atau Hari-H) kepada peserta terdaftar dengan opsi konfirmasi kehadiran Yes/No.</p>
        </div>

        <div class="flex items-center flex-wrap gap-2">
            <!-- Pengaturan Twilio -->
            <a href="{{ route('admin.wa-settings') }}" class="btn-3d-white px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition-all flex items-center gap-1.5 shadow-2xs">
                <span>Pengaturan Twilio</span>
            </a>

            <!-- Tombol Dashboard (Text-only) -->
            <a href="{{ route('admin.dashboard') }}" class="btn-3d-white px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition-all shadow-2xs">
                <span>Dashboard</span>
            </a>
        </div>
    </div>

    <!-- Ringkasan Statistik Respon RSVP -->
    @php
        $totalPeserta = $participants->count();
        $totalHadir = $participants->where('rsvp_status', 'confirmed_yes')->count();
        $totalBatal = $participants->where('rsvp_status', 'confirmed_no')->count();
        $totalPending = $participants->where('rsvp_status', 'pending')->count();
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        
        <!-- 1. Total Peserta -->
        <div class="card-3d p-5 flex flex-col justify-between relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Total Peserta</span>
                    <div class="flex items-baseline gap-2 mt-1.5">
                        <span class="text-3xl font-black text-slate-900 font-mono">{{ $totalPeserta }}</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <span class="text-[11px] text-slate-500 block">Pendaftar terverifikasi</span>
            </div>
        </div>

        <!-- 2. Pasti Hadir -->
        <div class="card-3d p-5 flex flex-col justify-between relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider block">Pasti Hadir</span>
                    <div class="flex items-baseline gap-2 mt-1.5">
                        <span class="text-3xl font-black text-emerald-600 font-mono">{{ $totalHadir }}</span>
                        <span class="text-xs font-semibold text-slate-400">
                            {{ $totalPeserta > 0 ? round(($totalHadir / $totalPeserta) * 100) : 0 }}%
                        </span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $totalPeserta > 0 ? ($totalHadir / $totalPeserta) * 100 : 0 }}%"></div>
                </div>
                <span class="text-[11px] text-emerald-600 font-medium mt-1.5 block">Konfirmasi Yes</span>
            </div>
        </div>

        <!-- 3. Berhalangan -->
        <div class="card-3d p-5 flex flex-col justify-between relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-rose-700 uppercase tracking-wider block">Berhalangan</span>
                    <div class="flex items-baseline gap-2 mt-1.5">
                        <span class="text-3xl font-black text-rose-600 font-mono">{{ $totalBatal }}</span>
                        <span class="text-xs font-semibold text-slate-400">
                            {{ $totalPeserta > 0 ? round(($totalBatal / $totalPeserta) * 100) : 0 }}%
                        </span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-rose-500 h-1.5 rounded-full" style="width: {{ $totalPeserta > 0 ? ($totalBatal / $totalPeserta) * 100 : 0 }}%"></div>
                </div>
                <span class="text-[11px] text-rose-600 font-medium mt-1.5 block">Konfirmasi No</span>
            </div>
        </div>

        <!-- 4. Belum Respon -->
        <div class="card-3d p-5 flex flex-col justify-between relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-amber-700 uppercase tracking-wider block">Belum Respon</span>
                    <div class="flex items-baseline gap-2 mt-1.5">
                        <span class="text-3xl font-black text-amber-600 font-mono">{{ $totalPending }}</span>
                        <span class="text-xs font-semibold text-slate-400">
                            {{ $totalPeserta > 0 ? round(($totalPending / $totalPeserta) * 100) : 0 }}%
                        </span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $totalPeserta > 0 ? ($totalPending / $totalPeserta) * 100 : 0 }}%"></div>
                </div>
                <span class="text-[11px] text-amber-600 font-medium mt-1.5 block">Menunggu balasan</span>
            </div>
        </div>
    </div>

    <!-- Grid: Form Generator Kiri (7 cols), Live Preview WhatsApp Kanan (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Kolom Kiri: Form Generator & Aksi -->
        <div class="lg:col-span-7 space-y-5">
            
            <div class="card-3d p-5 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Generator Pesan Pengingat</h2>
                        <p class="text-[11px] text-slate-400">Pilih preset template atau sesuaikan pesan pengingat.</p>
                    </div>
                </div>

                <!-- Tombol Preset Template Cepat -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Pilihan Preset Template:
                    </label>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" onclick="loadPreset('h3')" id="btnPresetH3" class="preset-btn px-3 py-2 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 transition-all cursor-pointer text-center">
                            Reminder H-3
                        </button>
                        <button type="button" onclick="loadPreset('h1')" id="btnPresetH1" class="preset-btn px-3 py-2 bg-blue-50 border border-blue-200 rounded-xl text-xs font-bold text-blue-900 transition-all cursor-pointer text-center">
                            Reminder H-1
                        </button>
                        <button type="button" onclick="loadPreset('h0')" id="btnPresetH0" class="preset-btn px-3 py-2 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 transition-all cursor-pointer text-center">
                            Reminder Hari-H
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Peserta Uji Coba -->
                    <div>
                        <label for="reminderNameInput" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Peserta <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="reminderNameInput" 
                            value="{{ $sample->name ?? 'Budi Santoso, S.E.' }}" 
                            class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                            oninput="updateReminderText()"
                        >
                    </div>

                    <!-- Nomor WhatsApp -->
                    <div>
                        <label for="reminderPhoneInput" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nomor WhatsApp
                        </label>
                        <input 
                            type="tel" 
                            id="reminderPhoneInput" 
                            value="{{ $sample->phone ?? '081234567890' }}" 
                            placeholder="081234567890" 
                            class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                        >
                    </div>
                </div>

                <!-- Helper Variabel Cepat -->
                <div>
                    <span class="text-[11px] font-semibold text-slate-600 block mb-1.5">Sisipkan variabel ke kursor:</span>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" onclick="insertVar('{nama}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg cursor-pointer transition-all">
                            {nama}
                        </button>
                        <button type="button" onclick="insertVar('{nama_acara}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg cursor-pointer transition-all">
                            {nama_acara}
                        </button>
                        <button type="button" onclick="insertVar('{tanggal}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg cursor-pointer transition-all">
                            {tanggal}
                        </button>
                        <button type="button" onclick="insertVar('{waktu}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg cursor-pointer transition-all">
                            {waktu}
                        </button>
                        <button type="button" onclick="insertVar('{venue}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg cursor-pointer transition-all">
                            {venue}
                        </button>
                        <button type="button" onclick="insertVar('{link_tiket}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg cursor-pointer transition-all">
                            {link_tiket}
                        </button>
                        <button type="button" onclick="insertVar('{link_konfirmasi_hadir}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg cursor-pointer transition-all">
                            {link_konfirmasi_hadir}
                        </button>
                        <button type="button" onclick="insertVar('{link_konfirmasi_batal}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg cursor-pointer transition-all">
                            {link_konfirmasi_batal}
                        </button>
                    </div>
                </div>

                <!-- Textarea Pesan -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="reminderTextArea" class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Isi Pesan WhatsApp Reminder <span class="text-rose-500">*</span>
                        </label>
                        <button type="button" onclick="saveAsDefaultTemplate()" class="text-[11px] font-bold text-blue-600 hover:underline cursor-pointer">
                            Simpan Sebagai Template Utama
                        </button>
                    </div>
                    <textarea 
                        id="reminderTextArea" 
                        rows="12" 
                        class="input-3d w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono text-slate-900 leading-relaxed focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                        oninput="onMessageInput()"
                    ></textarea>
                    <div class="mt-1.5 text-[11px] text-slate-500 flex items-center justify-between">
                        <span>Pesan mendukung WhatsApp Markdown (*tebal*, _miring_)</span>
                        <span id="charCount" class="font-mono text-slate-400">0 karakter</span>
                    </div>
                </div>

                <!-- Input Opsional Twilio Content SID (Quick Reply) -->
                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="contentSidInput" class="text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                            Twilio Content SID (Quick Reply Buttons)
                        </label>
                        <span class="text-[10px] text-slate-400">Opsional untuk Meta Approved Template</span>
                    </div>
                    <input 
                        type="text" 
                        id="contentSidInput" 
                        value="{{ $contentSidReminder }}" 
                        placeholder="Contoh: HX9b3e1c2d4f8a..." 
                        class="input-3d w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-900 focus:outline-none focus:border-blue-600"
                    >
                    <p class="text-[10px] text-slate-500 leading-normal">
                        Jika diisi, pengiriman via Twilio akan memunculkan tombol interaktif resmi di WhatsApp. Jika kosong, sistem otomatis mengirim pesan teks lengkap dengan tautan konfirmasi 1-klik.
                    </p>
                </div>

                <!-- Action Buttons: Salin, WA Web, Twilio -->
                <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center gap-2.5">
                    
                    <!-- 1. Salin Teks -->
                    <button 
                        type="button" 
                        onclick="copyReminderText()" 
                        class="btn-3d-dark px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl border border-slate-900 transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                        </svg>
                        <span>Salin Pesan</span>
                    </button>

                    <!-- 2. Buka WA Web -->
                    <button 
                        type="button" 
                        onclick="openWhatsAppWeb()" 
                        class="btn-3d-dark px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl border border-emerald-600 transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.155.57 4.179 1.564 5.926l-1.632 5.962 6.136-1.61c1.706.93 3.659 1.464 5.732 1.464 6.627 0 12-5.373 12-12 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        <span>Kirim via WA Web</span>
                    </button>

                    <!-- 3. Kirim via Twilio -->
                    <button 
                        type="button" 
                        onclick="sendTwilioBroadcast()" 
                        class="btn-3d-blue px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl border border-blue-600 transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>Kirim via Twilio API</span>
                    </button>

                </div>

            </div>

        </div>

        <!-- Kolom Kanan: Pratinjau Chat WhatsApp & Petunjuk Webhook (5 cols) -->
        <div class="lg:col-span-5 space-y-4">
            
            <!-- WhatsApp Phone Mockup Container -->
            <div class="card-3d overflow-hidden">
                
                <!-- Mockup Chat Header -->
                <div class="bg-slate-900 text-white px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-full bg-neutral-900 border border-white/20 flex items-center justify-center p-1 font-bold text-xs text-white uppercase">
                            <img src="{{ asset('images/wonderful-logo.png') }}" alt="Wonderful" class="w-5 h-5 object-contain">
                        </div>
                        <div>
                            <div class="text-xs font-bold leading-tight flex items-center gap-1">
                                <span>Wonderful</span>
                                <svg class="w-3 h-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-[10px] text-slate-300 block">Akun Resmi Official</span>
                        </div>
                    </div>

                    <span class="text-[10px] bg-slate-800 text-slate-300 px-2 py-0.5 rounded-full font-mono">
                        Live Preview
                    </span>
                </div>

                <!-- Chat Body Simulator -->
                <div class="bg-slate-100 p-4 min-h-[380px] max-h-[500px] overflow-y-auto space-y-3">
                    
                    <!-- Bubble Chat Hijau WhatsApp -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl rounded-tl-sm p-3.5 shadow-2xs max-w-[95%] space-y-2 text-xs text-slate-800 leading-relaxed">
                        <div id="previewReminderBody" class="whitespace-pre-line font-sans">
                            <!-- Diisi oleh script -->
                        </div>

                        <!-- Simulasi Tombol Interaktif WhatsApp Quick Reply -->
                        <div class="pt-2 border-t border-slate-100 space-y-1.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Simulasi Tombol WhatsApp:</span>
                            <div class="grid grid-cols-2 gap-1.5">
                                <div class="px-2.5 py-1.5 bg-emerald-50 border border-emerald-300 text-emerald-800 text-[11px] font-bold rounded-lg text-center">
                                    ✅ Ya, Saya Hadir
                                </div>
                                <div class="px-2.5 py-1.5 bg-rose-50 border border-rose-300 text-rose-800 text-[11px] font-bold rounded-lg text-center">
                                    ❌ Berhalangan
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-1 text-[10px] text-slate-400 pt-1">
                            <span>{{ date('H:i') }}</span>
                            <svg class="w-3.5 h-3.5 text-blue-500 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7m-14 4l4 4L19 7" />
                            </svg>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Box URL Webhook Twilio untuk Otomasi -->
            <div class="card-3d p-4 text-xs space-y-2">
                <span class="font-bold text-slate-900 block text-[11px] uppercase tracking-wider">
                    🔗 Webhook Twilio Incoming Message
                </span>
                <p class="text-slate-500 text-[11px]">
                    Pasang URL berikut di Twilio Console (menu <em>Phone Numbers / WhatsApp Senders ➔ When a message comes in</em>) agar balasan tamu otomatis tercatat:
                </p>
                <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-mono text-[11px] text-slate-800 break-all select-all">
                    {{ url('/twilio/webhook') }}
                </div>
            </div>

        </div>

    </div>

    <!-- Section Bawah: Tabel Peserta Terdaftar dengan Checkbox & Filter Status RSVP -->
    <div class="card-3d overflow-hidden">
        
        <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Daftar Tamu & Respon Kehadiran</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Pilih tamu untuk blast reminder massal atau filter berdasarkan konfirmasi hadir/batal.</p>
            </div>

            <!-- Filter Status Tab & Search -->
            <div class="flex flex-wrap items-center gap-2">
                <div class="inline-flex rounded-xl border border-slate-200 bg-slate-50 p-1 text-xs">
                    <button type="button" onclick="setRsvpFilter('all')" id="tabFilterAll" class="px-3 py-1 font-bold rounded-lg bg-white text-slate-900 shadow-2xs">
                        Semua ({{ $totalPeserta }})
                    </button>
                    <button type="button" onclick="setRsvpFilter('pending')" id="tabFilterPending" class="px-3 py-1 font-semibold rounded-lg text-slate-600 hover:text-slate-900">
                        Belum Respon ({{ $totalPending }})
                    </button>
                    <button type="button" onclick="setRsvpFilter('confirmed_yes')" id="tabFilterYes" class="px-3 py-1 font-semibold rounded-lg text-slate-600 hover:text-slate-900">
                        Hadir ({{ $totalHadir }})
                    </button>
                    <button type="button" onclick="setRsvpFilter('confirmed_no')" id="tabFilterNo" class="px-3 py-1 font-semibold rounded-lg text-slate-600 hover:text-slate-900">
                        Batal ({{ $totalBatal }})
                    </button>
                </div>

                <input 
                    type="text" 
                    id="searchGuestInput" 
                    placeholder="Cari nama / instansi..." 
                    class="input-3d px-3.5 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white"
                    oninput="filterGuestTable()"
                >
            </div>
        </div>

        <!-- Action Bar Bulk -->
        <div class="px-4 py-3 bg-slate-50/80 border-b border-slate-200/80 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span id="selectedCountBadge" class="text-xs font-semibold text-slate-700">0 tamu dipilih</span>
            </div>

            <button 
                type="button" 
                id="btnBulkTwilio" 
                onclick="sendBulkTwilio()" 
                disabled
                class="btn-3d-blue px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl border border-blue-600 transition-all disabled:opacity-40 disabled:border-slate-300 disabled:shadow-none disabled:cursor-not-allowed flex items-center gap-1.5 cursor-pointer shadow-2xs"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span>Blast Reminder Twilio ke (<span id="bulkCountNum">0</span>) Peserta</span>
            </button>
        </div>

        <!-- Tabel Peserta -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                        <th class="p-3 w-10 text-center">
                            <input 
                                type="checkbox" 
                                id="selectAllCheckbox" 
                                class="rounded-sm border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer w-4 h-4"
                                onchange="toggleSelectAll(this)"
                            >
                        </th>
                        <th class="p-3">Nama Tamu & Instansi</th>
                        <th class="p-3">WhatsApp</th>
                        <th class="p-3 text-center">Status Konfirmasi</th>
                        <th class="p-3 text-right">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 bg-white" id="guestTableBody">
                    @forelse($participants as $p)
                        <tr class="hover:bg-slate-50 transition guest-row" data-name="{{ strtolower($p->name) }}" data-company="{{ strtolower($p->company) }}" data-rsvp="{{ $p->rsvp_status }}">
                            <td class="p-3 text-center">
                                <input 
                                    type="checkbox" 
                                    value="{{ $p->id }}" 
                                    class="guest-checkbox rounded-sm border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer w-4 h-4"
                                    onchange="onGuestCheckboxChange()"
                                >
                            </td>
                            <td class="p-3">
                                <strong class="text-slate-900 block font-bold leading-tight">{{ $p->name }}</strong>
                                <span class="text-[11px] text-slate-500">{{ $p->position }} - {{ $p->company }}</span>
                            </td>
                            <td class="p-3 font-mono text-[11px] text-slate-800">
                                {{ $p->phone }}
                            </td>
                            <td class="p-3 text-center">
                                @if($p->rsvp_status === 'confirmed_yes')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 rounded-full font-bold text-[10px] uppercase font-mono">
                                        <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Pasti Hadir
                                    </span>
                                @elseif($p->rsvp_status === 'confirmed_no')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-50 text-rose-800 border border-rose-200/80 rounded-full font-bold text-[10px] uppercase font-mono">
                                        <svg class="w-3 h-3 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        Berhalangan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 bg-amber-50 text-amber-800 border border-amber-200/80 rounded-full font-bold text-[10px] uppercase font-mono">
                                        Belum Respon
                                    </span>
                                @endif
                                @if($p->rsvp_at)
                                    <span class="block text-[10px] text-slate-400 mt-0.5">{{ $p->rsvp_at->format('d/m H:i') }}</span>
                                @endif
                            </td>
                            <td class="p-3 text-right space-x-1 whitespace-nowrap">
                                <button 
                                    type="button" 
                                    onclick="pickGuestToEditor('{{ addslashes($p->name) }}', '{{ $p->phone }}', '{{ $p->qr_token }}')" 
                                    class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-200 rounded-lg text-[10px] font-bold cursor-pointer transition"
                                >
                                    Pilih
                                </button>
                                <button 
                                    type="button" 
                                    onclick="directWaWeb('{{ addslashes($p->name) }}', '{{ $p->phone }}', '{{ $p->qr_token }}')" 
                                    class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-[10px] font-bold cursor-pointer transition shadow-2xs"
                                >
                                    WA Web
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 text-xs">
                                Belum ada data peserta terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    const eventData = @json($eventSettings);
    let rawDefaultTemplate = @json($reminderTemplate);

    const nameInput = document.getElementById('reminderNameInput');
    const phoneInput = document.getElementById('reminderPhoneInput');
    const textArea = document.getElementById('reminderTextArea');
    const previewBody = document.getElementById('previewReminderBody');
    const charCountEl = document.getElementById('charCount');
    const contentSidInput = document.getElementById('contentSidInput');

    let currentGuestToken = '{{ $sample->qr_token ?? "CL26-EXMPL01" }}';
    let currentRsvpFilter = 'all';

    // Preset templates
    const presets = {
        h3: "Halo Bapak/Ibu *{nama}*,\n\n"
            + "Mengingatkan kembali bahwa agenda penting *{nama_acara}* akan berlangsung 3 hari lagi:\n"
            + "📅 Hari/Tgl: {tanggal}\n"
            + "⏰ Waktu: {waktu}\n"
            + "📍 Tempat: {venue}\n"
            + "👔 Dresscode: {dresscode}\n\n"
            + "Tiket QR Presensi Anda:\n🔗 {link_tiket}\n\n"
            + "Mohon konfirmasi kesediaan kehadiran Bapak/Ibu melalui tautan berikut:\n"
            + "✅ *Pasti Hadir:* {link_konfirmasi_hadir}\n"
            + "❌ *Berhalangan:* {link_konfirmasi_batal}\n\n"
            + "Terima kasih atas perhatiannya.\n*Panitia Wonderful 2026*",

        h1: "Halo Bapak/Ibu *{nama}*,\n\n"
            + "Mengingatkan kembali bahwa agenda penting *{nama_acara}* akan berlangsung BESOK:\n"
            + "📅 Hari/Tgl: {tanggal}\n"
            + "⏰ Waktu: {waktu}\n"
            + "📍 Tempat: {venue}\n"
            + "👔 Dresscode: {dresscode}\n\n"
            + "Tiket QR Presensi Anda:\n🔗 {link_tiket}\n\n"
            + "Mohon konfirmasi kesediaan kehadiran Bapak/Ibu melalui tautan berikut:\n"
            + "✅ *Pasti Hadir:* {link_konfirmasi_hadir}\n"
            + "❌ *Berhalangan:* {link_konfirmasi_batal}\n\n"
            + "Terima kasih atas kerja samanya.\n*Panitia Wonderful 2026*",

        h0: "Halo Bapak/Ibu *{nama}*,\n\n"
            + "Agenda penting *{nama_acara}* akan berlangsung HARI INI:\n"
            + "⏰ Waktu: {waktu}\n"
            + "📍 Tempat: {venue}\n"
            + "👔 Dresscode: {dresscode}\n\n"
            + "Tunjukkan E-Ticket QR ini kepada petugas registrasi saat tiba di lokasi:\n"
            + "🔗 {link_tiket}\n\n"
            + "Sampai berjumpa di lokasi kegiatan!\n*Panitia Wonderful 2026*"
    };

    function loadPreset(type) {
        if (presets[type]) {
            rawDefaultTemplate = presets[type];
            updateReminderText();

            ['h3', 'h1', 'h0'].forEach(p => {
                const btn = document.getElementById('btnPreset' + p.toUpperCase());
                if (btn) {
                    if (p === type) {
                        btn.className = "preset-btn px-3 py-2 bg-blue-50 border border-blue-200 rounded-xl text-xs font-bold text-blue-900 transition-all cursor-pointer text-center";
                    } else {
                        btn.className = "preset-btn px-3 py-2 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 transition-all cursor-pointer text-center";
                    }
                }
            });

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: `Preset template ${type.toUpperCase()} dimuat!`,
                showConfirmButton: false,
                timer: 1800
            });
        }
    }

    function buildTemplate(name, token) {
        let text = rawDefaultTemplate;
        const qToken = token || currentGuestToken;
        const baseUrl = "{{ url('/') }}";
        const linkTiket = `${baseUrl}/ticket/${qToken}`;
        const linkYes = `${baseUrl}/rsvp/${qToken}/yes`;
        const linkNo = `${baseUrl}/rsvp/${qToken}/no`;

        text = text.replaceAll('{nama}', name || 'Bapak/Ibu Pimpinan')
                   .replaceAll('{nama_acara}', eventData.nama_acara)
                   .replaceAll('{tanggal}', eventData.tanggal)
                   .replaceAll('{waktu}', eventData.waktu)
                   .replaceAll('{venue}', eventData.venue)
                   .replaceAll('{dresscode}', eventData.dresscode)
                   .replaceAll('{kode_tiket}', qToken)
                   .replaceAll('{link_tiket}', linkTiket)
                   .replaceAll('{link_konfirmasi_hadir}', linkYes)
                   .replaceAll('{link_konfirmasi_batal}', linkNo);
        return text;
    }

    function initPage() {
        const initialText = buildTemplate(nameInput.value.trim(), currentGuestToken);
        textArea.value = initialText;
        updatePreview(initialText);
    }

    function updateReminderText() {
        const text = buildTemplate(nameInput.value.trim(), currentGuestToken);
        textArea.value = text;
        updatePreview(text);
    }

    function onMessageInput() {
        updatePreview(textArea.value);
    }

    function updatePreview(text) {
        previewBody.textContent = text;
        charCountEl.textContent = text.length + ' karakter';
    }

    // Sisipkan variabel tag
    function insertVar(tag) {
        const start = textArea.selectionStart;
        const end = textArea.selectionEnd;
        const text = textArea.value;
        textArea.value = text.substring(0, start) + tag + text.substring(end);
        textArea.focus();
        textArea.selectionStart = textArea.selectionEnd = start + tag.length;
        updatePreview(textArea.value);
    }

    // Simpan template default via AJAX
    function saveAsDefaultTemplate() {
        fetch("{{ route('admin.reminder.settings') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                wa_reminder_template: textArea.value,
                twilio_reminder_template_id: contentSidInput.value.trim()
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                rawDefaultTemplate = textArea.value;
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Template reminder berhasil disimpan!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    }

    // 1. Salin Teks Reminder
    function copyReminderText() {
        const text = textArea.value;
        if (!text) return;

        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Pesan pengingat berhasil disalin!',
                showConfirmButton: false,
                timer: 2000
            });
        });
    }

    // 2. Buka WhatsApp Web
    function openWhatsAppWeb() {
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

    // 3. Kirim via Twilio Broadcast
    function sendTwilioBroadcast() {
        const phone = phoneInput.value.trim();
        const name = nameInput.value.trim();
        const message = textArea.value.trim();
        const contentSid = contentSidInput.value.trim();

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
            title: 'Kirim Pengingat Twilio?',
            text: `Kirim pesan reminder ke nomor ${phone}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Kirim Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Mengirim Pengingat...',
                    text: 'Menghubungkan ke Twilio API...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch("{{ route('admin.reminder.send-single') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        phone: phone,
                        custom_message: message,
                        content_sid: contentSid
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Reminder Terkirim!',
                            text: data.message || 'Pesan pengingat berhasil dikirim via WhatsApp Twilio.',
                            confirmButtonColor: '#0f172a'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Mengirim',
                            text: data.message || 'Gagal mengirim pengingat via Twilio.',
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

    // CHECKBOX & BULK ACTIONS
    function toggleSelectAll(master) {
        const checkboxes = document.querySelectorAll('.guest-checkbox');
        checkboxes.forEach(cb => {
            const row = cb.closest('tr');
            if (row && row.style.display !== 'none') {
                cb.checked = master.checked;
            }
        });
        updateBulkUI();
    }

    function onGuestCheckboxChange() {
        updateBulkUI();
    }

    function updateBulkUI() {
        const selected = document.querySelectorAll('.guest-checkbox:checked');
        const count = selected.length;
        const total = document.querySelectorAll('.guest-checkbox').length;
        
        document.getElementById('selectedCountBadge').textContent = `${count} tamu dipilih`;
        document.getElementById('bulkCountNum').textContent = count;
        
        const btnBulk = document.getElementById('btnBulkTwilio');
        btnBulk.disabled = (count === 0);

        const selectAll = document.getElementById('selectAllCheckbox');
        if (selectAll) {
            selectAll.checked = (count > 0 && count === total);
            selectAll.indeterminate = (count > 0 && count < total);
        }
    }

    function setRsvpFilter(type) {
        currentRsvpFilter = type;
        const tabs = ['all', 'pending', 'confirmed_yes', 'confirmed_no'];
        tabs.forEach(t => {
            const tabEl = document.getElementById('tabFilter' + (t === 'all' ? 'All' : (t === 'pending' ? 'Pending' : (t === 'confirmed_yes' ? 'Yes' : 'No'))));
            if (tabEl) {
                if (t === type) {
                    tabEl.className = "px-3 py-1 font-bold rounded-lg bg-white text-slate-900 shadow-2xs";
                } else {
                    tabEl.className = "px-3 py-1 font-semibold rounded-lg text-slate-600 hover:text-slate-900";
                }
            }
        });
        filterGuestTable();
    }

    function filterGuestTable() {
        const query = document.getElementById('searchGuestInput').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.guest-row');
        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const company = row.getAttribute('data-company') || '';
            const rsvp = row.getAttribute('data-rsvp') || '';

            const matchQuery = name.includes(query) || company.includes(query);
            const matchFilter = (currentRsvpFilter === 'all') || (rsvp === currentRsvpFilter);

            if (matchQuery && matchFilter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        updateBulkUI();
    }

    function pickGuestToEditor(name, phone, token) {
        nameInput.value = name;
        phoneInput.value = phone;
        currentGuestToken = token;
        updateReminderText();
        window.scrollTo({ top: 0, behavior: 'smooth' });
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'info',
            title: `Peserta "${name}" dimuat ke editor!`,
            showConfirmButton: false,
            timer: 1800
        });
    }

    function directWaWeb(name, phone, token) {
        const message = buildTemplate(name, token);
        let cleanPhone = phone.replace(/[^0-9]/g, '');
        if (cleanPhone.startsWith('0')) {
            cleanPhone = '62' + cleanPhone.substring(1);
        }
        const encoded = encodeURIComponent(message);
        window.open(`https://wa.me/${cleanPhone}?text=${encoded}`, '_blank');
    }

    function sendBulkTwilio() {
        const selected = document.querySelectorAll('.guest-checkbox:checked');
        const ids = Array.from(selected).map(cb => cb.value);

        if (ids.length === 0) return;

        Swal.fire({
            title: `Blast Reminder ke ${ids.length} Peserta?`,
            text: `Sistem akan mengirimkan pesan pengingat agenda acara via WhatsApp Twilio ke ${ids.length} peserta terpilih. Lanjutkan?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#64748b',
            confirmButtonText: `Ya, Blast Sekarang (${ids.length})`,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses Blast Reminder...',
                    text: `Sedang mengirim ke ${ids.length} nomor WhatsApp...`,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch("{{ route('admin.reminder.send-bulk') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ids: ids,
                        custom_message: textArea.value.trim(),
                        content_sid: contentSidInput.value.trim()
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Blast Reminder Selesai!',
                            text: data.message,
                            confirmButtonColor: '#0f172a'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Blast Gagal',
                            text: data.message || 'Terjadi kendala saat blast reminder.',
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
