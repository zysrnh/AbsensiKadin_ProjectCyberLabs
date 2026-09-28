@extends('layouts.admin')

@section('title', 'Kirim Undangan Pendaftaran - Kadin 2026')
@section('page_title', 'Kirim Undangan Acara')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-emerald-50 border border-emerald-200 rounded-sm mb-1 text-[11px] font-bold uppercase tracking-wider text-emerald-800">
                Broadcast Link Form
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Kirim Undangan Pendaftaran Acara</h1>
            <p class="text-xs text-slate-500 mt-0.5">Bagikan tautan pendaftaran acara resmi kepada tamu VIP melalui Salin Teks, WhatsApp Web, atau Twilio API.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.wa-settings') }}" class="px-3 py-2 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded-sm border border-slate-300 transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Edit Template Default</span>
            </a>
            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors">
                ← Ke Dashboard
            </a>
        </div>
    </div>

    <!-- Grid: Form Generator Kiri (7 cols), Live Preview WhatsApp Kanan (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Kolom Kiri: Form Generator & Aksi -->
        <div class="lg:col-span-7 space-y-5">
            
            <!-- Card Pengaturan Batas Waktu Kadaluarsa Undangan / Pendaftaran -->
            <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-2xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-sm bg-amber-50 text-amber-700 border border-amber-200 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Batas Waktu Kadaluarsa Undangan</h2>
                            <p class="text-[11px] text-slate-400">Atur batas waktu pendaftaran sebelum link form ditutup otomatis.</p>
                        </div>
                    </div>

                    <!-- Status Pill -->
                    <span id="deadlineStatusBadge" class="px-2 py-0.5 text-[10px] font-bold rounded-sm border uppercase font-mono {{ ($deadlineSettings['enabled'] ?? false) ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-slate-100 text-slate-500 border-slate-200' }}">
                        {{ ($deadlineSettings['enabled'] ?? false) ? 'Batas Aktif' : 'Tanpa Batas' }}
                    </span>
                </div>

                <div class="space-y-3.5">
                    <!-- Toggle Switch -->
                    <label class="inline-flex items-center gap-2.5 cursor-pointer">
                        <input 
                            type="checkbox" 
                            id="enableDeadlineToggle" 
                            class="rounded-xs border-slate-300 text-slate-900 focus:ring-0 focus:ring-offset-0 cursor-pointer w-4 h-4"
                            {{ ($deadlineSettings['enabled'] ?? false) ? 'checked' : '' }}
                            onchange="toggleDeadlineInputs()"
                        >
                        <span class="text-xs font-semibold text-slate-700">Aktifkan batas waktu kadaluarsa (Tutup pendaftaran otomatis setelah waktu ini)</span>
                    </label>

                    <div id="deadlineContainer" class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-1 {{ ($deadlineSettings['enabled'] ?? false) ? '' : 'opacity-40 pointer-events-none' }}">
                        <!-- Input Datetime -->
                        <div class="sm:col-span-5">
                            <label for="deadlineDatetimeInput" class="block text-[11px] font-semibold text-slate-600 uppercase tracking-wider mb-1">
                                Waktu Deadline
                            </label>
                            <input 
                                type="datetime-local" 
                                id="deadlineDatetimeInput" 
                                value="{{ $deadlineSettings['deadline'] ?? '' }}"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-sm text-xs font-mono text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white transition-colors"
                                onchange="onDeadlineDatetimeChanged()"
                            >
                        </div>

                        <!-- Input Teks Tampilan -->
                        <div class="sm:col-span-7">
                            <label for="deadlineTextInput" class="block text-[11px] font-semibold text-slate-600 uppercase tracking-wider mb-1">
                                Teks Pada Pesan & Form
                            </label>
                            <input 
                                type="text" 
                                id="deadlineTextInput" 
                                value="{{ $deadlineSettings['deadline_text'] ?? '' }}"
                                placeholder="Contoh: 27 Oktober 2026, 23:59 WIB"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-sm text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white transition-colors"
                                oninput="onDeadlineTextChanged()"
                            >
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pt-2 border-t border-slate-100">
                        <p class="text-[11px] text-slate-400">
                            Sisipkan tag <code class="font-mono text-slate-700 bg-slate-100 px-1 py-0.5 rounded-xs">{batas_waktu}</code> ke dalam isi pesan.
                        </p>
                        <button 
                            type="button" 
                            onclick="saveDeadlineSetting()" 
                            id="btnSaveDeadline"
                            class="px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors cursor-pointer flex items-center justify-center gap-1.5 shadow-2xs"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Simpan Batas Waktu</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-2xs space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Generator Undangan Tamu</h2>
                        <p class="text-[11px] text-slate-400">Sesuaikan target penerima dan isi pesan sebelum dibagikan.</p>
                    </div>
                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-sm border border-emerald-200 font-mono">
                        Pesan Registrasi
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Tamu / Penerima -->
                    <div>
                        <label for="guestNameInput" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Tamu / Penerima <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="guestNameInput" 
                            value="Bapak/Ibu Pimpinan" 
                            placeholder="Contoh: Bpk. Ir. Hendro Wibowo"
                            class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-sm text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white transition-colors"
                            oninput="updateInvitationText()"
                        >
                    </div>

                    <!-- Nomor WhatsApp -->
                    <div>
                        <label for="guestPhoneInput" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nomor WhatsApp <span class="text-slate-400 font-normal">(opsional untuk salin)</span>
                        </label>
                        <input 
                            type="tel" 
                            id="guestPhoneInput" 
                            placeholder="081234567890" 
                            class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-sm text-xs font-mono text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white transition-colors"
                        >
                    </div>
                </div>

                <!-- Helper Variabel Cepat -->
                <div>
                    <span class="text-[11px] font-semibold text-slate-600 block mb-1.5">Sisipkan variabel ke kursor:</span>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" onclick="insertVar('{nama}')" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 text-[11px] font-mono font-semibold rounded-sm cursor-pointer transition">
                            {nama}
                        </button>
                        <button type="button" onclick="insertVar('{nama_acara}')" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 text-[11px] font-mono font-semibold rounded-sm cursor-pointer transition">
                            {nama_acara}
                        </button>
                        <button type="button" onclick="insertVar('{tanggal}')" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 text-[11px] font-mono font-semibold rounded-sm cursor-pointer transition">
                            {tanggal}
                        </button>
                        <button type="button" onclick="insertVar('{waktu}')" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 text-[11px] font-mono font-semibold rounded-sm cursor-pointer transition">
                            {waktu}
                        </button>
                        <button type="button" onclick="insertVar('{venue}')" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 text-[11px] font-mono font-semibold rounded-sm cursor-pointer transition">
                            {venue}
                        </button>
                        <button type="button" onclick="insertVar('{dresscode}')" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 text-[11px] font-mono font-semibold rounded-sm cursor-pointer transition">
                            {dresscode}
                        </button>
                        <button type="button" onclick="insertVar('{link_form}')" class="px-2 py-1 bg-emerald-100 hover:bg-emerald-200 border border-emerald-300 text-emerald-800 text-[11px] font-mono font-semibold rounded-sm cursor-pointer transition">
                            {link_form}
                        </button>
                        <button type="button" onclick="insertVar('{batas_waktu}')" class="px-2 py-1 bg-amber-100 hover:bg-amber-200 border border-amber-300 text-amber-800 text-[11px] font-mono font-semibold rounded-sm cursor-pointer transition">
                            {batas_waktu}
                        </button>
                    </div>
                </div>

                <!-- Textarea Pesan -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="invitationTextArea" class="text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Isi Pesan WhatsApp Undangan <span class="text-rose-500">*</span>
                        </label>
                        <button type="button" onclick="resetToDefaultTemplate()" class="text-[11px] text-slate-500 hover:text-slate-800 underline cursor-pointer">
                            Reset ke template asal
                        </button>
                    </div>
                    <textarea 
                        id="invitationTextArea" 
                        rows="11" 
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-sm text-xs font-mono text-slate-900 leading-relaxed focus:outline-none focus:border-slate-900 focus:bg-white transition-colors"
                        oninput="onMessageInput()"
                    ></textarea>
                    <div class="mt-1 text-[11px] text-slate-500 flex items-center justify-between">
                        <span>Tautan registrasi: <strong class="text-slate-800 font-mono">{{ $eventSettings['link_form'] }}</strong></span>
                        <span id="charCount" class="font-mono text-slate-400">0 karakter</span>
                    </div>
                </div>

                <!-- Action Buttons: 3 Opsi Pengiriman -->
                <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center gap-2.5">
                    
                    <!-- 1. Salin Teks -->
                    <button 
                        type="button" 
                        onclick="copyInvitationText()" 
                        class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors flex items-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                        </svg>
                        <span>Salin Pesan Undangan</span>
                    </button>

                    <!-- 2. Buka WA Web -->
                    <button 
                        type="button" 
                        onclick="openWhatsAppWeb()" 
                        class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-sm transition-colors flex items-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.299.144.35.49 1.199.533 1.286.044.087.073.189.014.305-.058.115-.087.188-.173.289l-.26.309c-.087.095-.179.199-.077.375.101.173.454.747.973 1.21 0.672.6 1.238.788 1.413.875.174.087.276.073.377-.044.101-.116.433-.506.549-.68.116-.173.232-.144.39-.087s1.011.477 1.184.564.289.13.332.202c.044.072.044.419-.1.824z" />
                        </svg>
                        <span>Buka WhatsApp Web</span>
                    </button>

                    <!-- 3. Blast Twilio -->
                    <button 
                        type="button" 
                        onclick="sendTwilioBroadcast()" 
                        class="px-4 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs rounded-sm transition-colors flex items-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>Kirim via Twilio API</span>
                    </button>

                </div>

            </div>

            <!-- Card: Kirim ke Tamu Undangan Terdaftar (Checklist & Blast Massal) -->
            <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-2xs space-y-4">
                <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Tamu Undangan Terdaftar</h2>
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-[10px] font-bold rounded-sm border border-slate-300 font-mono">
                                {{ $participants->count() }} Tamu
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-400">Pilih tamu dengan checkbox untuk broadcast via Twilio atau klik untuk preview.</p>
                    </div>

                    <!-- Input Filter Cari Cepat -->
                    <div class="w-full sm:w-64">
                        <input 
                            type="text" 
                            id="searchGuestInput" 
                            placeholder="Cari nama / instansi..." 
                            class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 text-xs rounded-sm focus:outline-none focus:border-slate-900 focus:bg-white"
                            oninput="filterGuestTable()"
                        >
                    </div>
                </div>

                <!-- Checkbox Toolbar & Bulk Action -->
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-sm flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <label class="flex items-center gap-2 text-xs font-semibold text-slate-800 cursor-pointer select-none">
                            <input 
                                type="checkbox" 
                                id="selectAllCheckbox" 
                                onchange="toggleSelectAll(this)" 
                                class="rounded-sm border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer"
                            >
                            <span>Pilih Semua Tamu</span>
                        </label>
                        <span class="text-slate-300">|</span>
                        <span id="selectedCountBadge" class="text-xs font-medium text-slate-500">
                            0 tamu dipilih
                        </span>
                    </div>

                    <!-- Tombol Blast Twilio Massal -->
                    <button 
                        type="button" 
                        id="btnBulkTwilio" 
                        onclick="sendBulkTwilio()" 
                        disabled
                        class="w-full sm:w-auto px-4 py-2 bg-blue-700 hover:bg-blue-800 disabled:bg-slate-300 disabled:cursor-not-allowed text-white font-semibold text-xs rounded-sm transition-colors flex items-center justify-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>Blast Twilio ke (<span id="bulkCountNum">0</span>) Terpilih</span>
                    </button>
                </div>

                <!-- Tabel Daftar Tamu Terdaftar -->
                <div class="overflow-x-auto border border-slate-200 rounded-sm max-h-[360px] overflow-y-auto">
                    <table class="w-full text-left text-xs text-slate-700 divide-y divide-slate-200">
                        <thead class="bg-slate-100 text-[11px] font-bold text-slate-700 uppercase tracking-wider sticky top-0 z-10 shadow-2xs">
                            <tr>
                                <th scope="col" class="w-10 px-3 py-2.5 text-center">
                                    &bull;
                                </th>
                                <th scope="col" class="px-3.5 py-2.5">Nama & Instansi</th>
                                <th scope="col" class="px-3 py-2.5">WhatsApp</th>
                                <th scope="col" class="px-3 py-2.5 text-right">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody id="guestTableBody" class="divide-y divide-slate-100 bg-white">
                            @forelse($participants as $p)
                            <tr class="hover:bg-slate-50 transition-colors guest-row" data-name="{{ strtolower($p->name) }}" data-company="{{ strtolower($p->company) }}">
                                <td class="px-3 py-2.5 text-center">
                                    <input 
                                        type="checkbox" 
                                        value="{{ $p->id }}" 
                                        class="guest-checkbox rounded-sm border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer"
                                        onchange="onGuestCheckboxChange()"
                                    >
                                </td>
                                <td class="px-3.5 py-2.5">
                                    <span class="font-bold text-slate-900 block leading-tight">{{ $p->name }}</span>
                                    <span class="text-[11px] text-slate-500">{{ $p->company }} &bull; {{ $p->position }}</span>
                                </td>
                                <td class="px-3 py-2.5 font-mono text-slate-800 text-[11px]">
                                    {{ $p->phone }}
                                </td>
                                <td class="px-3 py-2.5 text-right whitespace-nowrap space-x-1">
                                    <!-- Pilih ke Generator Atas -->
                                    <button 
                                        type="button" 
                                        onclick="pickGuestToEditor('{{ addslashes($p->name) }}', '{{ $p->phone }}')" 
                                        title="Muat data ke form editor atas"
                                        class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold text-[10px] rounded-xs border border-slate-300 transition cursor-pointer"
                                    >
                                        Pilih
                                    </button>
                                    <!-- WA Web Langsung -->
                                    <button 
                                        type="button" 
                                        onclick="directWaWeb('{{ addslashes($p->name) }}', '{{ $p->phone }}')" 
                                        title="Langsung chat WhatsApp Web"
                                        class="px-2 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-[10px] rounded-xs transition cursor-pointer"
                                    >
                                        WA Web
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-slate-400 text-xs">
                                    Belum ada tamu atau peserta yang terdaftar di database.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Petunjuk Penggunaan -->
            <div class="p-4 bg-slate-100 border border-slate-200 rounded-sm text-xs text-slate-600 space-y-2">
                <div class="font-bold text-slate-800 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Alur Pendaftaran Acara:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-[11px] text-slate-600 pl-1 leading-relaxed">
                    <li>Pesan ini berisi link formulir pendaftaran <strong>({{ route('home') }})</strong> yang mengarahkan tamu ke halaman pendaftaran resmi ala Luma.</li>
                    <li>Setelah tamu mengisi form dan menekan tombol <strong>Request to Join</strong>, data akan masuk ke Dashboard Admin dan menunggu konfirmasi/tiket presensi.</li>
                    <li>Gunakan <strong>Salin Pesan</strong> jika Anda ingin menyebarkannya via WhatsApp Group pengurus atau email resmi.</li>
                </ul>
            </div>

        </div>

        <!-- Kolom Kanan: Live Mockup Chat WhatsApp -->
        <div class="lg:col-span-5 sticky top-20">
            <div class="bg-white border border-slate-300 rounded-sm overflow-hidden shadow-sm">
                
                <!-- Mockup Phone Header WA -->
                <div class="bg-[#075e54] text-white px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs uppercase">
                            KD
                        </div>
                        <div>
                            <span class="text-xs font-bold block leading-tight">KADIN INDONESIA 2026</span>
                            <span class="text-[10px] text-emerald-200">Online &bull; Undangan Resmi</span>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-white/80 bg-black/20 px-2 py-0.5 rounded-sm">
                        Live Preview
                    </span>
                </div>

                <!-- Mockup Chat Wallpaper / Background -->
                <div class="bg-[#efeae2] p-4 min-h-[460px] max-h-[580px] overflow-y-auto space-y-3 font-sans text-xs">
                    
                    <div class="text-center">
                        <span class="px-2 py-0.5 bg-white/80 text-slate-500 text-[10px] font-medium rounded-sm shadow-2xs inline-block">
                            HARI INI
                        </span>
                    </div>

                    <!-- Chat Bubble Masuk -->
                    <div class="max-w-[92%] bg-white rounded-sm shadow-xs p-3.5 space-y-2.5 border border-slate-200/50">
                        
                        <!-- Text Body Message Live -->
                        <div id="previewInvitationBody" class="text-xs text-slate-800 whitespace-pre-line leading-relaxed font-sans">
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
                <div class="bg-slate-100 border-t border-slate-200 p-2.5 flex items-center justify-between text-[11px] text-slate-500">
                    <span>Pratinjau tampilan pesan yang diterima tamu di WhatsApp</span>
                    <span class="font-mono text-slate-400">WhatsApp App</span>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    const eventData = @json($eventSettings);
    const rawDefaultTemplate = @json($invitationTemplate);
    let deadlineData = @json($deadlineSettings);

    const nameInput = document.getElementById('guestNameInput');
    const phoneInput = document.getElementById('guestPhoneInput');
    const textArea = document.getElementById('invitationTextArea');
    const previewBody = document.getElementById('previewInvitationBody');
    const charCountEl = document.getElementById('charCount');

    function buildTemplate(name) {
        let text = rawDefaultTemplate;
        const deadlineStr = deadlineData.enabled ? (deadlineData.deadline_text || 'Sesuai kuota') : 'Sesuai kuota tersedia';
        text = text.replaceAll('{nama}', name || 'Bapak/Ibu Pimpinan')
                   .replaceAll('{nama_acara}', eventData.nama_acara)
                   .replaceAll('{tanggal}', eventData.tanggal)
                   .replaceAll('{waktu}', eventData.waktu)
                   .replaceAll('{venue}', eventData.venue)
                   .replaceAll('{dresscode}', eventData.dresscode)
                   .replaceAll('{link_form}', eventData.link_form)
                   .replaceAll('{batas_waktu}', deadlineStr)
                   .replaceAll('{kadaluarsa}', deadlineStr);
        return text;
    }

    // HANDLER PENGATURAN BATAS KADALUARSA UNDANGAN
    function toggleDeadlineInputs() {
        const enabled = document.getElementById('enableDeadlineToggle').checked;
        const container = document.getElementById('deadlineContainer');
        const badge = document.getElementById('deadlineStatusBadge');
        
        if (enabled) {
            container.classList.remove('opacity-40', 'pointer-events-none');
            badge.className = "px-2 py-0.5 text-[10px] font-bold rounded-sm border uppercase font-mono bg-amber-50 text-amber-800 border-amber-200";
            badge.textContent = "Batas Aktif";
        } else {
            container.classList.add('opacity-40', 'pointer-events-none');
            badge.className = "px-2 py-0.5 text-[10px] font-bold rounded-sm border uppercase font-mono bg-slate-100 text-slate-500 border-slate-200";
            badge.textContent = "Tanpa Batas";
        }
        deadlineData.enabled = enabled;
        updateInvitationText();
    }

    function onDeadlineDatetimeChanged() {
        const val = document.getElementById('deadlineDatetimeInput').value;
        if (val) {
            const date = new Date(val);
            if (!isNaN(date.getTime())) {
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                const day = date.getDate();
                const month = months[date.getMonth()];
                const year = date.getFullYear();
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                
                const formatted = `${day} ${month} ${year}, ${hours}:${minutes} WIB`;
                document.getElementById('deadlineTextInput').value = formatted;
                deadlineData.deadline_text = formatted;
                deadlineData.deadline = val;
                updateInvitationText();
            }
        }
    }

    function onDeadlineTextChanged() {
        deadlineData.deadline_text = document.getElementById('deadlineTextInput').value;
        updateInvitationText();
    }

    function saveDeadlineSetting() {
        const enabled = document.getElementById('enableDeadlineToggle').checked;
        const deadline = document.getElementById('deadlineDatetimeInput').value;
        const text = document.getElementById('deadlineTextInput').value.trim();
        const btn = document.getElementById('btnSaveDeadline');

        btn.disabled = true;
        btn.innerHTML = `<svg class="animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg> <span>Menyimpan...</span>`;

        fetch("{{ route('admin.invitation.deadline') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                enabled: enabled ? 1 : 0,
                registration_deadline: deadline,
                registration_deadline_text: text
            })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> <span>Simpan Batas Waktu</span>`;
            
            if (data.success) {
                deadlineData.enabled = data.data.enabled;
                deadlineData.deadline = data.data.deadline;
                deadlineData.deadline_text = data.data.deadline_text;
                updateInvitationText();
                
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: data.message || 'Batas kadaluarsa berhasil disimpan!',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
                    text: data.message || 'Terjadi kesalahan.',
                    confirmButtonColor: '#0f172a'
                });
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> <span>Simpan Batas Waktu</span>`;
            Swal.fire({
                icon: 'error',
                title: 'Error Koneksi',
                text: 'Tidak dapat menyimpan pengaturan ke server.',
                confirmButtonColor: '#0f172a'
            });
        });
    }

    function initPage() {
        const initialText = buildTemplate(nameInput.value.trim());
        textArea.value = initialText;
        updatePreview(initialText);
    }

    function updateInvitationText() {
        const text = buildTemplate(nameInput.value.trim());
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

    function resetToDefaultTemplate() {
        updateInvitationText();
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

    // 1. Salin Teks Undangan ke Clipboard
    function copyInvitationText() {
        const text = textArea.value;
        if (!text) return;

        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Pesan undangan berhasil disalin!',
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
                title: 'Pesan disalin ke clipboard!',
                showConfirmButton: false,
                timer: 2000
            });
        });
    }

    // 2. Buka WhatsApp Web / App
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

    // 3. Blast Twilio API
    function sendTwilioBroadcast() {
        const phone = phoneInput.value.trim();
        const name = nameInput.value.trim();
        const message = textArea.value.trim();

        if (!phone) {
            Swal.fire({
                icon: 'warning',
                title: 'Nomor WhatsApp Kosong',
                text: 'Silakan isi nomor WhatsApp tujuan terlebih dahulu sebelum mengirim via Twilio.',
                confirmButtonColor: '#0f172a'
            });
            phoneInput.focus();
            return;
        }

        Swal.fire({
            title: 'Kirim Undangan Twilio?',
            text: `Kirim pesan undangan ke nomor ${phone}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1d4ed8',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Kirim Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Mengirim Pesan...',
                    text: 'Menghubungkan ke Twilio REST API...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch("{{ route('admin.invitation.send') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        name: name || 'Bapak/Ibu Pimpinan',
                        phone: phone,
                        custom_message: message
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil Terkirim!',
                            text: data.message || 'Pesan undangan berhasil dikirim via WhatsApp Twilio.',
                            confirmButtonColor: '#0f172a'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Mengirim',
                            text: data.message || 'Gagal mengirim pesan via Twilio.',
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

    function filterGuestTable() {
        const query = document.getElementById('searchGuestInput').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.guest-row');
        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const company = row.getAttribute('data-company') || '';
            if (name.includes(query) || company.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        updateBulkUI();
    }

    // Pilih tamu ke Form Editor Atas
    function pickGuestToEditor(name, phone) {
        nameInput.value = name;
        phoneInput.value = phone;
        updateInvitationText();
        window.scrollTo({ top: 0, behavior: 'smooth' });
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'info',
            title: `Tamu "${name}" dimuat ke editor!`,
            showConfirmButton: false,
            timer: 2000
        });
    }

    // Direct WhatsApp Web untuk 1 tamu
    function directWaWeb(name, phone) {
        const message = buildTemplate(name);
        let cleanPhone = phone.replace(/[^0-9]/g, '');
        if (cleanPhone.startsWith('0')) {
            cleanPhone = '62' + cleanPhone.substring(1);
        }
        const encoded = encodeURIComponent(message);
        window.open(`https://wa.me/${cleanPhone}?text=${encoded}`, '_blank');
    }

    // Kirim Bulk Twilio
    function sendBulkTwilio() {
        const selected = document.querySelectorAll('.guest-checkbox:checked');
        const ids = Array.from(selected).map(cb => cb.value);

        if (ids.length === 0) return;

        Swal.fire({
            title: `Blast Twilio ke ${ids.length} Tamu?`,
            text: `Sistem akan mengirimkan pesan undangan resmi via WhatsApp Twilio ke ${ids.length} tamu terpilih. Lanjutkan?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1d4ed8',
            cancelButtonColor: '#64748b',
            confirmButtonText: `Ya, Blast Sekarang (${ids.length})`,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses Blast Twilio...',
                    text: `Sedang mengirim ke ${ids.length} nomor WhatsApp...`,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch("{{ route('admin.invitation.send-bulk') }}", {
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
                            title: 'Blast Selesai!',
                            text: data.message,
                            confirmButtonColor: '#0f172a'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Blast Gagal',
                            text: data.message || 'Terjadi kendala saat blast Twilio.',
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

    // Inisialisasi saat DOM siap
    document.addEventListener('DOMContentLoaded', initPage);
</script>
@endpush
