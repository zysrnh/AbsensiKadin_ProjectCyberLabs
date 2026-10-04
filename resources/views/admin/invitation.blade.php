@extends('layouts.admin')

@section('title', 'Kirim Undangan Pendaftaran - Wonderful 2026')
@section('page_title', 'Kirim Undangan Acara')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Kirim Undangan Pendaftaran Acara</h1>
            <p class="text-xs text-slate-500 mt-0.5">Bagikan tautan pendaftaran acara resmi kepada tamu VIP melalui Salin Teks, WhatsApp Web, atau Twilio API dengan lampiran flyer acara.</p>
        </div>

        <div class="flex items-center flex-wrap gap-2">
            <!-- Edit Template Default -->
            <a href="{{ route('admin.wa-settings') }}" class="btn-3d-white px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition-all flex items-center gap-1.5 shadow-2xs">
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Edit Template Default</span>
            </a>

            <!-- Tombol Dashboard (Text-only) -->
            <a href="{{ route('admin.dashboard') }}" class="btn-3d-white px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 shadow-2xs transition-all">
                Dashboard
            </a>
        </div>
    </div>

    <!-- Grid: Form Generator Kiri (7 cols), Live Preview WhatsApp Kanan (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Kolom Kiri: Form Generator & Aksi -->
        <div class="lg:col-span-7 space-y-5">
            
            <!-- Card Pengaturan Batas Waktu Kadaluarsa Undangan / Pendaftaran -->
            <div class="card-3d p-5 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 border border-amber-200/80 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Batas Waktu Kadaluarsa Undangan</h2>
                            <p class="text-[11px] text-slate-400">Atur batas waktu pendaftaran sebelum link form ditutup otomatis.</p>
                        </div>
                    </div>

                    <!-- Status Pill -->
                    <span id="deadlineStatusBadge" class="px-2.5 py-1 text-[10px] font-bold rounded-full border uppercase font-mono {{ ($deadlineSettings['enabled'] ?? false) ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-slate-100 text-slate-500 border-slate-200' }}">
                        {{ ($deadlineSettings['enabled'] ?? false) ? 'Batas Aktif' : 'Tanpa Batas' }}
                    </span>
                </div>

                <div class="space-y-3.5">
                    <!-- Toggle Switch -->
                    <label class="inline-flex items-center gap-2.5 cursor-pointer">
                        <input 
                            type="checkbox" 
                            id="enableDeadlineToggle" 
                            class="rounded-sm border-slate-300 text-slate-900 focus:ring-0 focus:ring-offset-0 cursor-pointer w-4 h-4"
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
                                class="input-3d w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
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
                                class="input-3d w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                                oninput="onDeadlineTextChanged()"
                            >
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pt-2 border-t border-slate-100">
                        <p class="text-[11px] text-slate-400">
                            Sisipkan tag <code class="font-mono text-slate-700 bg-slate-100 px-1 py-0.5 rounded-sm">{batas_waktu}</code> ke dalam isi pesan.
                        </p>
                        <button 
                            type="button" 
                            onclick="saveDeadlineSetting()" 
                            id="btnSaveDeadline"
                            class="btn-3d-dark px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl border border-slate-900 transition-all cursor-pointer flex items-center justify-center gap-1.5 shadow-2xs"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Simpan Batas Waktu</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card: Lampiran Flyer Acara (Gambar WhatsApp) -->
            <div class="card-3d p-5 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-violet-50 text-violet-700 border border-violet-200/80 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Lampiran Flyer Acara (Gambar WhatsApp)</h2>
                            <p class="text-[11px] text-slate-400">Lampirkan poster/flyer acara secara otomatis saat pesan WhatsApp dikirimkan.</p>
                        </div>
                    </div>

                    <!-- Status Pill -->
                    <span id="flyerStatusBadge" class="px-2.5 py-1 text-[10px] font-bold rounded-full border uppercase font-mono {{ !empty($eventFlyerUrl) ? 'bg-violet-50 text-violet-800 border-violet-200' : 'bg-slate-100 text-slate-500 border-slate-200' }}">
                        {{ !empty($eventFlyerUrl) ? 'Flyer Tersedia' : 'Belum Ada Flyer' }}
                    </span>
                </div>

                <div class="space-y-3.5">
                    <!-- Toggle Switch -->
                    <label class="inline-flex items-center gap-2.5 cursor-pointer">
                        <input 
                            type="checkbox" 
                            id="attachFlyerToggle" 
                            class="rounded-sm border-slate-300 text-slate-900 focus:ring-0 focus:ring-offset-0 cursor-pointer w-4 h-4"
                            {{ !empty($eventFlyerUrl) ? 'checked' : '' }}
                            onchange="onToggleFlyerAttachment()"
                        >
                        <span class="text-xs font-semibold text-slate-700">Lampirkan gambar flyer pada pesan WhatsApp (Twilio Media & Live Preview)</span>
                    </label>

                    <div class="flex flex-col sm:flex-row items-center gap-4 p-3.5 bg-slate-50 border border-slate-200 rounded-xl">
                        <!-- Thumbnail Flyer -->
                        <div class="w-20 h-24 sm:w-20 sm:h-20 rounded-lg overflow-hidden border border-slate-200 bg-white flex items-center justify-center shrink-0">
                            <img id="cardFlyerThumb" src="{{ $eventFlyerUrl ?: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=300&q=80' }}" alt="Thumbnail Flyer" class="w-full h-full object-cover {{ empty($eventFlyerUrl) ? 'opacity-40' : '' }}">
                        </div>

                        <div class="flex-1 space-y-1.5 text-left w-full sm:w-auto">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-800" id="cardFlyerName">
                                    {{ !empty($eventFlyer) ? basename($eventFlyer) : 'Default Event Poster' }}
                                </span>
                                <span class="text-[10px] font-mono text-slate-400">JPG, PNG, WEBP</span>
                            </div>
                            <p class="text-[11px] text-slate-500 leading-normal">
                                Poster ini akan dikirim sebagai media foto WhatsApp di atas teks undangan resmi. Anda juga dapat memotong (crop) gambar sebelum disimpan.
                            </p>
                            
                            <div class="flex flex-wrap items-center gap-2 pt-1">
                                <!-- Hidden file input for new upload -->
                                <input type="file" id="flyerFileInput" accept="image/png,image/jpeg,image/jpg,image/webp" class="hidden" onchange="handleFlyerFileSelect(this)">
                                
                                <button 
                                    type="button" 
                                    onclick="document.getElementById('flyerFileInput').click()" 
                                    id="btnUploadFlyer"
                                    class="px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 font-bold text-[11px] rounded-lg border border-slate-200 shadow-2xs transition-all flex items-center gap-1.5 cursor-pointer"
                                >
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span>Unggah Flyer / Gambar Baru</span>
                                </button>

                                <button 
                                    type="button" 
                                    onclick="cropCurrentFlyer()" 
                                    id="btnCropFlyer"
                                    class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] rounded-lg border border-slate-200 transition-all flex items-center gap-1.5 cursor-pointer {{ empty($eventFlyerUrl) ? 'hidden' : '' }}"
                                >
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z" />
                                    </svg>
                                    <span>Potong / Crop Flyer</span>
                                </button>

                                <a 
                                    href="{{ $eventFlyerUrl ?: '#' }}" 
                                    target="_blank" 
                                    id="btnDownloadFlyer" 
                                    class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] rounded-lg border border-slate-200 transition-all flex items-center gap-1 {{ empty($eventFlyerUrl) ? 'hidden' : '' }}"
                                >
                                    <span>Lihat Flyer</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card: Generator Undangan Tamu -->
            <div class="card-3d p-5 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Generator Undangan Tamu</h2>
                        <p class="text-[11px] text-slate-400">Sesuaikan target penerima dan isi pesan sebelum dibagikan.</p>
                    </div>
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-full border border-emerald-200/80 font-mono">
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
                            class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all font-semibold"
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
                            class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-semibold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                        >
                    </div>
                </div>

                <!-- Helper Variabel Cepat -->
                <div>
                    <span class="text-[11px] font-semibold text-slate-600 block mb-1.5">Sisipkan variabel ke kursor:</span>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" onclick="insertVar('{nama}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg border border-slate-200 cursor-pointer transition-all">
                            {nama}
                        </button>
                        <button type="button" onclick="insertVar('{nama_acara}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg border border-slate-200 cursor-pointer transition-all">
                            {nama_acara}
                        </button>
                        <button type="button" onclick="insertVar('{tanggal}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg border border-slate-200 cursor-pointer transition-all">
                            {tanggal}
                        </button>
                        <button type="button" onclick="insertVar('{waktu}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg border border-slate-200 cursor-pointer transition-all">
                            {waktu}
                        </button>
                        <button type="button" onclick="insertVar('{venue}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg border border-slate-200 cursor-pointer transition-all">
                            {venue}
                        </button>
                        <button type="button" onclick="insertVar('{dresscode}')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-mono font-bold rounded-lg border border-slate-200 cursor-pointer transition-all">
                            {dresscode}
                        </button>
                        <button type="button" onclick="insertVar('{link_form}')" class="px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-[11px] font-mono font-bold rounded-lg border border-emerald-200 cursor-pointer transition-all">
                            {link_form}
                        </button>
                        <button type="button" onclick="insertVar('{batas_waktu}')" class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-800 text-[11px] font-mono font-bold rounded-lg border border-amber-200 cursor-pointer transition-all">
                            {batas_waktu}
                        </button>
                        <button type="button" onclick="insertVar('{link_flyer}')" class="px-2.5 py-1 bg-violet-50 hover:bg-violet-100 text-violet-800 text-[11px] font-mono font-bold rounded-lg border border-violet-200 cursor-pointer transition-all">
                            {link_flyer}
                        </button>
                    </div>
                </div>

                <!-- Textarea Pesan -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="invitationTextArea" class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Isi Pesan WhatsApp Undangan <span class="text-rose-500">*</span>
                        </label>
                        <button type="button" onclick="resetToDefaultTemplate()" class="text-[11px] font-medium text-slate-500 hover:text-slate-800 underline cursor-pointer">
                            Reset ke template asal
                        </button>
                    </div>
                    <textarea 
                        id="invitationTextArea" 
                        rows="11" 
                        class="input-3d w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono text-slate-900 leading-relaxed focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                        oninput="onMessageInput()"
                    ></textarea>
                    <div class="mt-1.5 text-[11px] text-slate-500 flex items-center justify-between">
                        <span>Tautan registrasi: <strong class="text-slate-800 font-mono">{{ $eventSettings['link_form'] }}</strong></span>
                        <span id="charCount" class="font-mono text-slate-400">0 karakter</span>
                    </div>
                </div>

                <!-- Input Opsional Twilio Content SID (Quick Reply / CTA) -->
                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="contentSidInput" class="text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                            Twilio Content SID (Undangan Acara)
                        </label>
                        <span class="text-[10px] text-slate-400">Opsional untuk Meta Approved Template</span>
                    </div>
                    <input 
                        type="text" 
                        id="contentSidInput" 
                        value="{{ $contentSidInvitation ?? '' }}" 
                        placeholder="Contoh: HX55189df5..." 
                        class="input-3d w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-900 focus:outline-none focus:border-blue-600"
                    >
                    <p class="text-[10px] text-slate-500 leading-normal">
                        Jika diisi, pengiriman via Twilio akan menggunakan template resmi interaktif Meta. Jika kosong, sistem otomatis mengirim pesan teks lengkap di atas beserta lampiran gambar.
                    </p>
                </div>

                <!-- Action Buttons: 3 Opsi Pengiriman -->
                <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center gap-2.5">
                    
                    <!-- 1. Salin Teks -->
                    <button 
                        type="button" 
                        onclick="copyInvitationText()" 
                        class="btn-3d-dark px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl border border-slate-900 transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs"
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
                        class="btn-3d-dark px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl border border-emerald-600 transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.299.144.35.49 1.199.533 1.286.044.087.073.189.014.305-.058.115-.087.188-.173.289l-.26.309c-.087.095-.179.199-.077.375.101.173.454.747.973 1.21 0.672.6 1.238.788 1.413.875.174.087.276.073.377-.044.101-.116.433-.506.549-.68.116-.173.232-.144.39-.087s1.011.477 1.184.564.289.13.332.202c.044.072.044.419-.1.824z" />
                        </svg>
                        <span>Buka WhatsApp Web</span>
                    </button>

                    <!-- 3. Kirim via Twilio REST API -->
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

            <!-- Card: Database Calon Tamu Undangan & Blast Massal -->
            <div class="card-3d p-4 sm:p-5 space-y-3.5">
                <!-- Header Card: Judul & Action Buttons -->
                <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Database Calon Tamu Undangan</h2>
                            <span id="tabCountBadge" class="px-2 py-0.5 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-md border border-blue-200 font-mono">
                                {{ $invitationGuests->count() }} Calon Tamu
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-0.5">Input atau simpan daftar kontak yang ingin diundang, lalu pilih untuk blast Twilio massal.</p>
                    </div>

                    <!-- Tombol Aksi Tambah & Import Kontak -->
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <button 
                            type="button" 
                            onclick="openAddGuestModal()" 
                            class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-lg transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Tambah Tamu</span>
                        </button>

                        <button 
                            type="button" 
                            onclick="openImportGuestsModal()" 
                            class="px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-lg border border-slate-200 hover:border-slate-300 transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs"
                        >
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span>Paste Banyak Nomor</span>
                        </button>
                    </div>
                </div>

                <!-- Tab Navigasi & Filter Pencarian (1 Baris) -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                    <!-- Tab Selector -->
                    <div class="flex items-center gap-1 p-1 bg-slate-100 rounded-lg border border-slate-200 text-xs w-full sm:w-auto">
                        <button 
                            type="button" 
                            id="tabBtnGuests" 
                            onclick="switchGuestTab('guest')" 
                            class="flex-1 sm:flex-initial px-3 py-1 font-bold rounded-md bg-white text-slate-900 shadow-2xs transition-all cursor-pointer flex items-center justify-center gap-1.5"
                        >
                            <span>Calon Tamu (Target Blast)</span>
                            <span class="px-1.5 py-0.2 bg-blue-100 text-blue-700 rounded text-[10px] font-mono font-bold">{{ $invitationGuests->count() }}</span>
                        </button>
                        <button 
                            type="button" 
                            id="tabBtnParticipants" 
                            onclick="switchGuestTab('participant')" 
                            class="flex-1 sm:flex-initial px-3 py-1 font-semibold rounded-md text-slate-600 hover:text-slate-900 transition-all cursor-pointer flex items-center justify-center gap-1.5"
                        >
                            <span>Peserta Terdaftar</span>
                            <span class="px-1.5 py-0.2 bg-slate-200 text-slate-600 rounded text-[10px] font-mono font-bold">{{ $participants->count() }}</span>
                        </button>
                    </div>

                    <!-- Search Input -->
                    <div class="relative w-full sm:w-60">
                        <svg class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input 
                            type="text" 
                            id="searchGuestInput" 
                            placeholder="Cari nama atau nomor..." 
                            class="w-full pl-8.5 pr-3 py-1.5 bg-slate-50 border border-slate-200 text-xs text-slate-800 placeholder-slate-400 rounded-lg focus:outline-none focus:border-blue-600 focus:bg-white transition"
                            oninput="filterGuestTable()"
                        >
                    </div>
                </div>

                <!-- Slim Action Bar: Counter & Blast Button -->
                <div class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2">
                        <span id="selectedCountBadge" class="font-medium text-slate-600">0 kontak dipilih</span>
                    </div>

                    <!-- Tombol Blast Twilio Massal -->
                    <button 
                        type="button" 
                        id="btnBulkTwilio" 
                        onclick="sendBulkTwilio()" 
                        disabled
                        class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 disabled:opacity-40 disabled:hover:bg-blue-600 disabled:cursor-not-allowed text-white font-bold text-xs rounded-md transition flex items-center gap-1.5 cursor-pointer shadow-2xs"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>Blast Twilio ke (<span id="bulkCountNum">0</span>) Terpilih</span>
                    </button>
                </div>

                <!-- TAB 1: Daftar Calon Tamu Undangan -->
                <div id="containerGuests" class="overflow-x-auto border border-slate-200 rounded-lg max-h-[380px] overflow-y-auto">
                    <table class="w-full text-left text-xs text-slate-700 divide-y divide-slate-200">
                        <thead class="bg-slate-50 text-[11px] font-bold text-slate-700 uppercase tracking-wider sticky top-0 z-10 shadow-2xs">
                            <tr>
                                <th scope="col" class="w-10 px-3 py-2.5 text-center">
                                    <input 
                                        type="checkbox" 
                                        class="master-checkbox rounded-sm border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer w-4 h-4"
                                        onchange="toggleSelectAll(this)"
                                        title="Pilih semua yang tampil"
                                    >
                                </th>
                                <th scope="col" class="px-3.5 py-2.5">Nama & Instansi</th>
                                <th scope="col" class="px-3.5 py-2.5">WhatsApp</th>
                                <th scope="col" class="px-3.5 py-2.5 text-center">Status</th>
                                <th scope="col" class="px-3.5 py-2.5 text-right">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody id="guestTableBody" class="divide-y divide-slate-100 bg-white">
                            @forelse($invitationGuests as $g)
                            <tr class="hover:bg-slate-50 transition-colors guest-row-item" data-type="guest" data-name="{{ strtolower($g->name) }}" data-phone="{{ $g->phone }}" data-company="{{ strtolower($g->company ?? '') }}">
                                <td class="px-3 py-2.5 text-center">
                                    <input 
                                        type="checkbox" 
                                        value="{{ $g->id }}" 
                                        class="guest-checkbox rounded-sm border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer w-4 h-4"
                                        onchange="onGuestCheckboxChange()"
                                    >
                                </td>
                                <td class="px-3.5 py-2.5">
                                    <span class="font-bold text-slate-900 block leading-tight">{{ $g->name }}</span>
                                    <span class="text-[11px] text-slate-500">{{ $g->company ?: '-' }} @if(!empty($g->position) && $g->position !== '-') &bull; {{ $g->position }} @endif</span>
                                </td>
                                <td class="px-3.5 py-2.5 font-mono text-slate-800 text-[11px]">
                                    {{ $g->phone }}
                                </td>
                                <td class="px-3.5 py-2.5 text-center whitespace-nowrap">
                                    @if($g->status === 'sent')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Terkirim ({{ $g->sent_at ? $g->sent_at->format('d/m H:i') : '' }})
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Belum Dikirim
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3.5 py-2.5 text-right whitespace-nowrap space-x-1">
                                    <!-- Pilih ke Generator Atas -->
                                    <button 
                                        type="button" 
                                        onclick="pickGuestToEditor('{{ addslashes($g->name) }}', '{{ $g->phone }}')" 
                                        title="Muat data ke form editor atas"
                                        class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-[10px] rounded-md border border-slate-200 transition cursor-pointer"
                                    >
                                        Pilih
                                    </button>
                                    <!-- WA Web Langsung -->
                                    <button 
                                        type="button" 
                                        onclick="directWaWeb('{{ addslashes($g->name) }}', '{{ $g->phone }}')" 
                                        title="Langsung chat WhatsApp Web"
                                        class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] rounded-md transition cursor-pointer shadow-2xs"
                                    >
                                        WA Web
                                    </button>
                                    <!-- Hapus Calon Tamu -->
                                    <button 
                                        type="button" 
                                        onclick="deleteGuest({{ $g->id }}, '{{ addslashes($g->name) }}')" 
                                        title="Hapus calon tamu"
                                        class="px-2 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-[10px] rounded-md border border-rose-200 transition cursor-pointer"
                                    >
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                        </div>
                                        <h4 class="text-xs font-bold text-slate-800">Belum Ada Calon Tamu</h4>
                                        <p class="text-[11px] text-slate-400 mt-0.5 mb-3">Input nomor WhatsApp atau paste daftar kontak untuk mulai blast undangan.</p>
                                        <div class="flex items-center gap-2">
                                            <button type="button" onclick="openAddGuestModal()" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-md transition cursor-pointer shadow-2xs flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                                <span>Tambah Tamu</span>
                                            </button>
                                            <button type="button" onclick="openImportGuestsModal()" class="px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 font-bold text-xs rounded-md transition cursor-pointer shadow-2xs">
                                                Paste Banyak Nomor
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- TAB 2: Daftar Peserta yang Sudah Mendaftar -->
                <div id="containerParticipants" class="overflow-x-auto border border-slate-200 rounded-lg max-h-[380px] overflow-y-auto hidden">
                    <table class="w-full text-left text-xs text-slate-700 divide-y divide-slate-200">
                        <thead class="bg-slate-50 text-[11px] font-bold text-slate-700 uppercase tracking-wider sticky top-0 z-10 shadow-2xs">
                            <tr>
                                <th scope="col" class="w-10 px-3 py-2.5 text-center">
                                    <input 
                                        type="checkbox" 
                                        class="master-checkbox rounded-sm border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer w-4 h-4"
                                        onchange="toggleSelectAll(this)"
                                        title="Pilih semua yang tampil"
                                    >
                                </th>
                                <th scope="col" class="px-3.5 py-2.5">Nama & Instansi</th>
                                <th scope="col" class="px-3.5 py-2.5">WhatsApp</th>
                                <th scope="col" class="px-3.5 py-2.5 text-center">Status Presensi</th>
                                <th scope="col" class="px-3.5 py-2.5 text-right">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody id="participantTableBody" class="divide-y divide-slate-100 bg-white">
                            @forelse($participants as $p)
                            <tr class="hover:bg-slate-50 transition-colors guest-row-item" data-type="participant" data-name="{{ strtolower($p->name) }}" data-phone="{{ $p->phone }}" data-company="{{ strtolower($p->company) }}">
                                <td class="px-3 py-2.5 text-center">
                                    <input 
                                        type="checkbox" 
                                        value="{{ $p->id }}" 
                                        class="guest-checkbox rounded-sm border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer w-4 h-4"
                                        onchange="onGuestCheckboxChange()"
                                    >
                                </td>
                                <td class="px-3.5 py-2.5">
                                    <span class="font-bold text-slate-900 block leading-tight">{{ $p->name }}</span>
                                    <span class="text-[11px] text-slate-500">{{ $p->company }} &bull; {{ $p->position }}</span>
                                </td>
                                <td class="px-3.5 py-2.5 font-mono text-slate-800 text-[11px]">
                                    {{ $p->phone }}
                                </td>
                                <td class="px-3.5 py-2.5 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        Terdaftar di Web
                                    </span>
                                </td>
                                <td class="px-3.5 py-2.5 text-right whitespace-nowrap space-x-1">
                                    <button 
                                        type="button" 
                                        onclick="pickGuestToEditor('{{ addslashes($p->name) }}', '{{ $p->phone }}')" 
                                        title="Muat data ke form editor atas"
                                        class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-[10px] rounded-md border border-slate-200 transition cursor-pointer"
                                    >
                                        Pilih
                                    </button>
                                    <button 
                                        type="button" 
                                        onclick="directWaWeb('{{ addslashes($p->name) }}', '{{ $p->phone }}')" 
                                        title="Langsung chat WhatsApp Web"
                                        class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] rounded-md transition cursor-pointer shadow-2xs"
                                    >
                                        WA Web
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-400 text-xs">
                                    Belum ada peserta yang mendaftar di sistem.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Live Mockup Chat WhatsApp -->
        <div class="lg:col-span-5 sticky top-20">
            <div class="card-3d overflow-hidden">
                
                <!-- Mockup Phone Header WA -->
                <div class="bg-[#075e54] text-white px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center p-1 font-bold text-xs uppercase">
                            <img src="{{ asset('images/wonderful-logo.png') }}" alt="Wonderful" class="w-5 h-5 object-contain">
                        </div>
                        <div>
                            <span class="text-xs font-bold block leading-tight">WONDERFUL 2026</span>
                            <span class="text-[10px] text-emerald-200">Online &bull; Undangan Resmi</span>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-white/90 bg-black/20 px-2 py-0.5 rounded-full">
                        Live Preview
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
                        
                        <!-- Flyer Image Attachment in WA Chat Bubble (Clean, no text overlay) -->
                        <div id="previewFlyerBubble" class="{{ !empty($eventFlyerUrl) ? '' : 'hidden' }} -mx-1.5 -mt-1.5 mb-2.5 rounded-xl overflow-hidden border border-slate-200/60 bg-slate-100 relative group">
                            <img id="previewFlyerImg" src="{{ $eventFlyerUrl ?: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1000&q=80' }}" alt="Flyer Acara" class="w-full h-auto max-h-[280px] object-cover">
                        </div>

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
                <div class="bg-slate-50 border-t border-slate-200 p-3 flex items-center justify-between text-[11px] text-slate-500">
                    <span>Pratinjau tampilan pesan yang diterima tamu di WhatsApp</span>
                    <span class="font-mono text-slate-400">WhatsApp App</span>
                </div>

            </div>
        </div>

    </div>

</div>

<!-- Modal 1: Tambah Calon Tamu Satuan -->
<div id="modalAddGuest" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="card-3d w-full max-w-md overflow-hidden p-0 border border-slate-200 shadow-2xl bg-white rounded-2xl">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <div>
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">Tambah Calon Tamu Undangan</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Simpan kontak calon tamu untuk dikirimi undangan pendaftaran.</p>
            </div>
            <button type="button" onclick="closeAddGuestModal()" class="w-8 h-8 rounded-xl bg-white hover:bg-slate-100 text-slate-500 hover:text-slate-800 flex items-center justify-center font-bold text-base transition-colors cursor-pointer border border-slate-200">&times;</button>
        </div>

        <form id="formAddGuest" onsubmit="submitAddGuest(event)" class="p-5 space-y-3.5">
            <div>
                <label for="newGuestName" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="newGuestName" 
                    required 
                    placeholder="Contoh: Bpk. Ir. Hendro Wibowo" 
                    class="input-3d w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white font-medium"
                >
            </div>

            <div>
                <label for="newGuestPhone" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                    Nomor WhatsApp <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="tel" 
                    id="newGuestPhone" 
                    required 
                    placeholder="Contoh: 081234567890 atau 628123456789" 
                    class="input-3d w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white font-mono font-medium"
                >
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="newGuestCompany" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        Instansi / Perusahaan
                    </label>
                    <input 
                        type="text" 
                        id="newGuestCompany" 
                        placeholder="Contoh: PT CyberLabs" 
                        class="input-3d w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white font-medium"
                    >
                </div>

                <div>
                    <label for="newGuestPosition" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        Jabatan
                    </label>
                    <input 
                        type="text" 
                        id="newGuestPosition" 
                        placeholder="Contoh: Direktur" 
                        class="input-3d w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white font-medium"
                    >
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeAddGuestModal()" class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 cursor-pointer">
                    Batal
                </button>
                <button type="submit" id="btnSubmitAddGuest" class="btn-3d-blue px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl border border-blue-600 cursor-pointer">
                    Simpan Calon Tamu
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Paste Cepat Banyak Kontak Sekaligus -->
<div id="modalImportGuests" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="card-3d w-full max-w-lg overflow-hidden p-0 border border-slate-200 shadow-2xl bg-white rounded-2xl">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <div>
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">Paste Banyak Kontak Sekaligus</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Copas nomor WhatsApp atau daftar nama dari Excel / Chat.</p>
            </div>
            <button type="button" onclick="closeImportGuestsModal()" class="w-8 h-8 rounded-xl bg-white hover:bg-slate-100 text-slate-500 hover:text-slate-800 flex items-center justify-center font-bold text-base transition-colors cursor-pointer border border-slate-200">&times;</button>
        </div>

        <form id="formImportGuests" onsubmit="submitImportGuests(event)" class="p-5 space-y-3.5">
            <div class="p-3 bg-blue-50/70 border border-blue-100 rounded-xl text-left space-y-1">
                <span class="text-[11px] font-bold text-blue-900 block">Format yang didukung (satu baris per kontak):</span>
                <p class="text-[11px] text-blue-800 font-mono leading-tight">
                    08123456789, Bpk. Hendro, PT CyberLabs<br>
                    08987654321, Ibu Maya<br>
                    085711223344
                </p>
                <span class="text-[10px] text-blue-700 block italic pt-0.5">*Tanda pemisah bisa koma, tab (dari copy Excel), atau titik-koma.</span>
            </div>

            <div>
                <label for="rawContactsInput" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                    Daftar Nomor / Kontak <span class="text-rose-500">*</span>
                </label>
                <textarea 
                    id="rawContactsInput" 
                    rows="7" 
                    required 
                    placeholder="Tempel / Paste daftar nomor di sini..." 
                    class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white font-mono"
                ></textarea>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeImportGuestsModal()" class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 cursor-pointer">
                    Batal
                </button>
                <button type="submit" id="btnSubmitImportGuests" class="btn-3d-blue px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl border border-blue-600 cursor-pointer">
                    Simpan Semua Kontak
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Cropper Gambar Flyer -->
<div id="cropFlyerModal" class="fixed inset-0 z-50 bg-black/75 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="card-3d w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden p-0 border border-slate-200 shadow-2xl bg-white rounded-2xl">
        <!-- Header -->
        <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between bg-white">
            <div>
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">Potong / Crop Gambar Flyer</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Sesuaikan area potongan gambar flyer sebelum disimpan.</p>
            </div>
            <button type="button" onclick="closeCropFlyerModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center font-bold text-base transition-colors cursor-pointer">&times;</button>
        </div>

        <!-- Body Viewport -->
        <div class="p-4 flex-grow overflow-hidden flex flex-col items-center justify-center bg-slate-950">
            <div class="w-full max-h-[50vh] flex items-center justify-center overflow-hidden rounded-xl">
                <img id="cropperFlyerImage" src="" alt="Crop Source" class="max-w-full block">
            </div>
        </div>

        <!-- Toolbar Controls -->
        <div class="bg-white border-t border-slate-100 px-5 py-3.5 flex items-center justify-between flex-wrap gap-2.5 text-xs">
            <!-- Rasio -->
            <div class="flex items-center gap-1.5 flex-wrap">
                <span class="font-bold text-slate-600 text-[11px]">Rasio:</span>
                <button type="button" id="btnRatioPoster" onclick="setCropRatio(4/5, this)" class="crop-ratio-btn px-2.5 py-1.5 bg-slate-900 text-white font-bold rounded-lg border border-slate-900 text-[11px]">4:5 Poster</button>
                <button type="button" id="btnRatioSquare" onclick="setCropRatio(1/1, this)" class="crop-ratio-btn px-2.5 py-1.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-lg text-[11px]">1:1</button>
                <button type="button" id="btnRatioBanner" onclick="setCropRatio(16/9, this)" class="crop-ratio-btn px-2.5 py-1.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-lg text-[11px]">16:9</button>
                <button type="button" id="btnRatioFree" onclick="setCropRatio(NaN, this)" class="crop-ratio-btn px-2.5 py-1.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-lg text-[11px]">Bebas</button>
            </div>

            <!-- Tools Zoom & Rotate -->
            <div class="flex items-center gap-1">
                <button type="button" onclick="cropper && cropper.zoom(0.1)" class="w-7 h-7 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold rounded-lg flex items-center justify-center text-xs" title="Zoom In">+</button>
                <button type="button" onclick="cropper && cropper.zoom(-0.1)" class="w-7 h-7 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold rounded-lg flex items-center justify-center text-xs" title="Zoom Out">-</button>
                <button type="button" onclick="cropper && cropper.rotate(90)" class="px-2 h-7 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold rounded-lg flex items-center justify-center text-[10px]" title="Putar 90&deg;">&#8635; 90&deg;</button>
                <button type="button" onclick="cropper && cropper.reset()" class="px-2 h-7 bg-white hover:bg-slate-50 border border-slate-200 text-slate-600 font-bold rounded-lg text-[10px]">Reset</button>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2">
                <button type="button" onclick="closeCropFlyerModal()" class="px-3 py-1.5 bg-white border border-slate-200 text-slate-700 font-bold text-xs rounded-xl hover:bg-slate-50">
                    Batal
                </button>
                <button type="button" onclick="applyCroppedFlyer()" id="btnApplyCrop" class="btn-3d-blue px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl border border-blue-600 flex items-center gap-1.5 cursor-pointer">
                    <span>Potong & Terapkan Flyer</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Cropper.js CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

<script>
    const eventData = @json($eventSettings);
    const rawDefaultTemplate = @json($invitationTemplate);
    let deadlineData = @json($deadlineSettings);
    let currentFlyerUrl = @json($eventFlyerUrl);

    const nameInput = document.getElementById('guestNameInput');
    const phoneInput = document.getElementById('guestPhoneInput');
    const textArea = document.getElementById('invitationTextArea');
    const previewBody = document.getElementById('previewInvitationBody');
    const charCountEl = document.getElementById('charCount');

    let cropper = null;

    function buildTemplate(name) {
        let text = rawDefaultTemplate;
        const deadlineStr = deadlineData.enabled ? (deadlineData.deadline_text || 'Sesuai kuota') : 'Sesuai kuota tersedia';
        const flyerUrl = currentFlyerUrl || eventData.link_flyer || '{{ route('home') }}';
        text = text.replaceAll('{nama}', name || 'Bapak/Ibu Pimpinan')
                   .replaceAll('{nama_acara}', eventData.nama_acara)
                   .replaceAll('{tanggal}', eventData.tanggal)
                   .replaceAll('{waktu}', eventData.waktu)
                   .replaceAll('{venue}', eventData.venue)
                   .replaceAll('{dresscode}', eventData.dresscode)
                   .replaceAll('{link_form}', eventData.link_form)
                   .replaceAll('{batas_waktu}', deadlineStr)
                   .replaceAll('{kadaluarsa}', deadlineStr)
                   .replaceAll('{link_flyer}', flyerUrl);
        return text;
    }

    // HANDLER LAMPIRAN FLYER GAMBAR
    function onToggleFlyerAttachment() {
        const checked = document.getElementById('attachFlyerToggle').checked;
        const bubble = document.getElementById('previewFlyerBubble');
        if (bubble) {
            if (checked && currentFlyerUrl) {
                bubble.classList.remove('hidden');
            } else {
                bubble.classList.add('hidden');
            }
        }
    }

    // Cropper Functions
    function handleFlyerFileSelect(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            openCropFlyerModal(e.target.result);
        };
        reader.readAsDataURL(file);
    }

    function cropCurrentFlyer() {
        if (!currentFlyerUrl) return;
        openCropFlyerModal(currentFlyerUrl);
    }

    function openCropFlyerModal(imageSrc) {
        const modal = document.getElementById('cropFlyerModal');
        const cropImg = document.getElementById('cropperFlyerImage');
        cropImg.src = imageSrc;
        modal.classList.remove('hidden');

        if (cropper) {
            cropper.destroy();
        }

        setTimeout(() => {
            cropper = new Cropper(cropImg, {
                aspectRatio: 4 / 5, // Default rasio poster
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.95,
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
            });
        }, 150);
    }

    function closeCropFlyerModal() {
        const modal = document.getElementById('cropFlyerModal');
        modal.classList.add('hidden');
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        document.getElementById('flyerFileInput').value = '';
    }

    function setCropRatio(ratio, btn) {
        if (!cropper) return;
        cropper.setAspectRatio(ratio);

        const buttons = document.querySelectorAll('.crop-ratio-btn');
        buttons.forEach(b => {
            b.className = "crop-ratio-btn px-2.5 py-1.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-lg text-[11px]";
        });
        if (btn) {
            btn.className = "crop-ratio-btn px-2.5 py-1.5 bg-slate-900 text-white font-bold rounded-lg border border-slate-900 text-[11px]";
        }
    }

    function applyCroppedFlyer() {
        if (!cropper) return;
        const btn = document.getElementById('btnApplyCrop');
        btn.disabled = true;
        btn.innerHTML = `<svg class="animate-spin w-3 h-3 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg> <span>Menyimpan...</span>`;

        const canvas = cropper.getCroppedCanvas({
            width: 1080,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        canvas.toBlob(function(blob) {
            const formData = new FormData();
            formData.append('flyer', blob, 'cropped_flyer.jpg');

            fetch("{{ route('admin.wa.upload-flyer') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = `<span>Potong & Terapkan Flyer</span>`;
                closeCropFlyerModal();

                if (data.success) {
                    currentFlyerUrl = data.url;
                    eventData.link_flyer = data.url;

                    document.getElementById('cardFlyerThumb').src = data.url;
                    document.getElementById('cardFlyerThumb').classList.remove('opacity-40');
                    document.getElementById('cardFlyerName').textContent = data.filename;
                    document.getElementById('previewFlyerImg').src = data.url;
                    document.getElementById('attachFlyerToggle').checked = true;
                    document.getElementById('previewFlyerBubble').classList.remove('hidden');

                    const badge = document.getElementById('flyerStatusBadge');
                    badge.className = "px-2.5 py-1 text-[10px] font-bold rounded-full border uppercase font-mono bg-violet-50 text-violet-800 border-violet-200";
                    badge.textContent = "Flyer Tersedia";

                    const cropBtn = document.getElementById('btnCropFlyer');
                    if (cropBtn) cropBtn.classList.remove('hidden');

                    const downloadBtn = document.getElementById('btnDownloadFlyer');
                    if (downloadBtn) {
                        downloadBtn.href = data.url;
                        downloadBtn.classList.remove('hidden');
                    }

                    updateInvitationText();

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Flyer berhasil dipotong dan diterapkan!',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan',
                        text: data.message || 'Gagal mengunggah flyer.',
                        confirmButtonColor: '#0f172a'
                    });
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = `<span>Potong & Terapkan Flyer</span>`;
                Swal.fire({
                    icon: 'error',
                    title: 'Error Koneksi',
                    text: 'Gagal menghubungi server.',
                    confirmButtonColor: '#0f172a'
                });
            });
        }, 'image/jpeg', 0.92);
    }

    // HANDLER PENGATURAN BATAS KADALUARSA UNDANGAN
    function toggleDeadlineInputs() {
        const enabled = document.getElementById('enableDeadlineToggle').checked;
        const container = document.getElementById('deadlineContainer');
        const badge = document.getElementById('deadlineStatusBadge');
        
        if (enabled) {
            container.classList.remove('opacity-40', 'pointer-events-none');
            badge.className = "px-2.5 py-1 text-[10px] font-bold rounded-full border uppercase font-mono bg-amber-50 text-amber-800 border-amber-200";
            badge.textContent = "Batas Aktif";
        } else {
            container.classList.add('opacity-40', 'pointer-events-none');
            badge.className = "px-2.5 py-1 text-[10px] font-bold rounded-full border uppercase font-mono bg-slate-100 text-slate-500 border-slate-200";
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
        onToggleFlyerAttachment();
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
        const attachFlyer = document.getElementById('attachFlyerToggle').checked;

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
            text: `Kirim pesan undangan ke nomor ${phone}?` + (attachFlyer ? ' (Menyertakan lampiran gambar flyer)' : ''),
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
                        custom_message: message,
                        content_sid: document.getElementById('contentSidInput') ? document.getElementById('contentSidInput').value.trim() : '',
                        attach_flyer: attachFlyer ? 1 : 0,
                        media_url: attachFlyer ? currentFlyerUrl : null
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

    let currentActiveTab = 'guest';

    function switchGuestTab(tab) {
        currentActiveTab = tab;
        const btnGuests = document.getElementById('tabBtnGuests');
        const btnParticipants = document.getElementById('tabBtnParticipants');
        const containerGuests = document.getElementById('containerGuests');
        const containerParticipants = document.getElementById('containerParticipants');
        const badge = document.getElementById('tabCountBadge');

        // Uncheck all checkboxes on switch
        document.querySelectorAll('.guest-checkbox').forEach(cb => cb.checked = false);
        document.querySelectorAll('.master-checkbox').forEach(cb => { cb.checked = false; cb.indeterminate = false; });

        if (tab === 'guest') {
            btnGuests.className = "flex-1 sm:flex-initial px-3 py-1 font-bold rounded-md bg-white text-slate-900 shadow-2xs transition-all cursor-pointer flex items-center justify-center gap-1.5";
            btnParticipants.className = "flex-1 sm:flex-initial px-3 py-1 font-semibold rounded-md text-slate-600 hover:text-slate-900 transition-all cursor-pointer flex items-center justify-center gap-1.5";
            containerGuests.classList.remove('hidden');
            containerParticipants.classList.add('hidden');
            badge.textContent = "{{ $invitationGuests->count() }} Calon Tamu";
        } else {
            btnParticipants.className = "flex-1 sm:flex-initial px-3 py-1 font-bold rounded-md bg-white text-slate-900 shadow-2xs transition-all cursor-pointer flex items-center justify-center gap-1.5";
            btnGuests.className = "flex-1 sm:flex-initial px-3 py-1 font-semibold rounded-md text-slate-600 hover:text-slate-900 transition-all cursor-pointer flex items-center justify-center gap-1.5";
            containerParticipants.classList.remove('hidden');
            containerGuests.classList.add('hidden');
            badge.textContent = "{{ $participants->count() }} Peserta Terdaftar";
        }

        filterGuestTable();
    }

    // CHECKBOX & BULK ACTIONS
    function toggleSelectAll(master) {
        const activeContainer = currentActiveTab === 'guest' 
            ? document.getElementById('containerGuests') 
            : document.getElementById('containerParticipants');
        
        const checkboxes = activeContainer.querySelectorAll('.guest-checkbox');
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
        const activeContainer = currentActiveTab === 'guest' 
            ? document.getElementById('containerGuests') 
            : document.getElementById('containerParticipants');

        const selected = activeContainer.querySelectorAll('.guest-checkbox:checked');
        const count = selected.length;
        const total = activeContainer.querySelectorAll('.guest-checkbox').length;
        
        document.getElementById('selectedCountBadge').textContent = `${count} kontak dipilih`;
        document.getElementById('bulkCountNum').textContent = count;
        
        const btnBulk = document.getElementById('btnBulkTwilio');
        btnBulk.disabled = (count === 0);

        const selectAll = activeContainer.querySelector('.master-checkbox');
        if (selectAll) {
            selectAll.checked = (count > 0 && count === total);
            selectAll.indeterminate = (count > 0 && count < total);
        }
    }

    function filterGuestTable() {
        const query = document.getElementById('searchGuestInput').value.toLowerCase().trim();
        const activeContainer = currentActiveTab === 'guest' 
            ? document.getElementById('containerGuests') 
            : document.getElementById('containerParticipants');

        const rows = activeContainer.querySelectorAll('.guest-row-item');
        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const phone = row.getAttribute('data-phone') || '';
            const company = row.getAttribute('data-company') || '';
            if (name.includes(query) || phone.includes(query) || company.includes(query)) {
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

    // Modal Tambah Calon Tamu
    function openAddGuestModal() {
        document.getElementById('modalAddGuest').classList.remove('hidden');
        document.getElementById('newGuestName').focus();
    }

    function closeAddGuestModal() {
        document.getElementById('modalAddGuest').classList.add('hidden');
        document.getElementById('formAddGuest').reset();
    }

    function submitAddGuest(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmitAddGuest');
        const origText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<svg class="animate-spin w-3 h-3 text-white inline mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg> Menyimpan...`;

        fetch("{{ route('admin.invitation.guests.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                name: document.getElementById('newGuestName').value.trim(),
                phone: document.getElementById('newGuestPhone').value.trim(),
                company: document.getElementById('newGuestCompany').value.trim(),
                position: document.getElementById('newGuestPosition').value.trim(),
            })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = origText;
            if (data.success) {
                closeAddGuestModal();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Disimpan!',
                    text: data.message,
                    timer: 1800,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Terjadi kesalahan saat menyimpan.',
                    confirmButtonColor: '#0f172a'
                });
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = origText;
            Swal.fire({
                icon: 'error',
                title: 'Error Koneksi',
                text: 'Gagal menghubungi server.',
                confirmButtonColor: '#0f172a'
            });
        });
    }

    // Modal Import / Paste Banyak Kontak
    function openImportGuestsModal() {
        document.getElementById('modalImportGuests').classList.remove('hidden');
        document.getElementById('rawContactsInput').focus();
    }

    function closeImportGuestsModal() {
        document.getElementById('modalImportGuests').classList.add('hidden');
        document.getElementById('formImportGuests').reset();
    }

    function submitImportGuests(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmitImportGuests');
        const origText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<svg class="animate-spin w-3 h-3 text-white inline mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg> Mengimpor...`;

        fetch("{{ route('admin.invitation.guests.import') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                raw_contacts: document.getElementById('rawContactsInput').value.trim()
            })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = origText;
            if (data.success) {
                closeImportGuestsModal();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Diimpor!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Tidak ada nomor yang berhasil diimpor.',
                    confirmButtonColor: '#0f172a'
                });
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = origText;
            Swal.fire({
                icon: 'error',
                title: 'Error Koneksi',
                text: 'Gagal menghubungi server.',
                confirmButtonColor: '#0f172a'
            });
        });
    }

    // Hapus Calon Tamu
    function deleteGuest(id, name) {
        Swal.fire({
            title: `Hapus Tamu "${name}"?`,
            text: 'Data calon tamu ini akan dihapus dari daftar undangan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`{{ url('/admin/invitation/guests') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Calon tamu berhasil dihapus!',
                            showConfirmButton: false,
                            timer: 1800
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        });
    }

    // Kirim Bulk Twilio
    function sendBulkTwilio() {
        const activeContainer = currentActiveTab === 'guest' 
            ? document.getElementById('containerGuests') 
            : document.getElementById('containerParticipants');

        const selected = activeContainer.querySelectorAll('.guest-checkbox:checked');
        const ids = Array.from(selected).map(cb => cb.value);
        const attachFlyer = document.getElementById('attachFlyerToggle').checked;

        if (ids.length === 0) return;

        Swal.fire({
            title: `Blast Twilio ke ${ids.length} Kontak?`,
            text: `Sistem akan mengirimkan pesan undangan resmi via WhatsApp Twilio ke ${ids.length} kontak terpilih.` + (attachFlyer ? ' (Menyertakan lampiran flyer acara)' : '') + ' Lanjutkan?',
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
                        target_type: currentActiveTab,
                        custom_message: textArea.value.trim(),
                        content_sid: document.getElementById('contentSidInput') ? document.getElementById('contentSidInput').value.trim() : '',
                        attach_flyer: attachFlyer ? 1 : 0,
                        media_url: attachFlyer ? currentFlyerUrl : null
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
                        }).then(() => {
                            location.reload();
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
