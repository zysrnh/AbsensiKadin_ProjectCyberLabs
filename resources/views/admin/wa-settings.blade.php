@extends('layouts.admin')

@section('title', 'Pengaturan WhatsApp & Twilio - Kadin 2026')
@section('page_title', 'Pengaturan WhatsApp')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Pengaturan WhatsApp & Twilio</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola mode pengiriman (Sandbox / Meta Template), template teks presensi, dan gambar tiket QR langsung.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded-sm border border-slate-300 transition-colors">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Main Grid: Settings Form Left (7 cols), Live Preview Right (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Column: Form Pengaturan -->
        <div class="lg:col-span-7 space-y-5">
            
            <form action="{{ route('admin.wa-settings.update') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Card 1: Pilihan Mode Twilio -->
                <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-2xs space-y-4">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Mode Pengiriman Twilio</h2>
                            <p class="text-[11px] text-slate-400">Pilih skema pengiriman pesan WhatsApp sesuai status akun Twilio Anda.</p>
                        </div>
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-[10px] font-bold rounded-sm border border-slate-300 font-mono">
                            Twilio Mode
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Mode A: Sandbox / Freeform -->
                        <label class="border border-slate-200 rounded-sm p-3.5 cursor-pointer hover:border-slate-400 transition-colors flex items-start gap-3 bg-slate-50/50 has-[:checked]:border-slate-900 has-[:checked]:bg-slate-100/50">
                            <input 
                                type="radio" 
                                name="twilio_mode" 
                                value="freeform" 
                                id="modeFreeform"
                                {{ old('twilio_mode', $twilioMode) === 'freeform' ? 'checked' : '' }}
                                class="mt-0.5 text-slate-900 focus:ring-slate-900 cursor-pointer"
                                onchange="switchMode('freeform')"
                            >
                            <div class="space-y-1">
                                <span class="text-xs font-bold text-slate-900 block">Mode Sandbox / Bebas</span>
                                <p class="text-[11px] text-slate-500 leading-normal">
                                    Cocok untuk uji coba. Mengirim teks kustom dari box template + gambar QR langsung tanpa perlu approval Meta.
                                </p>
                            </div>
                        </label>

                        <!-- Mode B: Meta Content Template SID -->
                        <label class="border border-slate-200 rounded-sm p-3.5 cursor-pointer hover:border-slate-400 transition-colors flex items-start gap-3 bg-slate-50/50 has-[:checked]:border-slate-900 has-[:checked]:bg-slate-100/50">
                            <input 
                                type="radio" 
                                name="twilio_mode" 
                                value="template" 
                                id="modeTemplate"
                                {{ old('twilio_mode', $twilioMode) === 'template' ? 'checked' : '' }}
                                class="mt-0.5 text-slate-900 focus:ring-slate-900 cursor-pointer"
                                onchange="switchMode('template')"
                            >
                            <div class="space-y-1">
                                <span class="text-xs font-bold text-slate-900 block">Mode Meta Template (Resmi)</span>
                                <p class="text-[11px] text-slate-500 leading-normal">
                                    Wajib untuk akun WhatsApp Business resmi (Production). Menggunakan Twilio Content SID yang disetujui Meta.
                                </p>
                            </div>
                        </label>
                    </div>

                    <!-- Meta Content Template Guide Box -->
                    <div id="metaTemplateGuide" class="p-3.5 bg-blue-50/80 border border-blue-200 rounded-sm text-[11px] text-slate-700 space-y-2 {{ old('twilio_mode', $twilioMode) === 'template' ? '' : 'hidden' }}">
                        <div class="font-bold text-blue-900 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Panduan Variabel Meta Approved Template:</span>
                        </div>
                        <p class="leading-relaxed text-slate-600">
                            Di Twilio Content Builder, buat template kategori <strong>UTILITY</strong> dengan header <strong>Media (Image)</strong>. Sistem otomatis mengirim variabel berikut:
                        </p>
                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 text-center pt-1 font-mono text-[10px]">
                            <div class="bg-white p-1.5 rounded-sm border border-blue-200">
                                <span class="font-bold text-blue-700 block">&#123;&#123;1&#125;&#125;</span>
                                <span class="text-slate-500 font-sans">Nama</span>
                            </div>
                            <div class="bg-white p-1.5 rounded-sm border border-blue-200">
                                <span class="font-bold text-blue-700 block">&#123;&#123;2&#125;&#125;</span>
                                <span class="text-slate-500 font-sans">Instansi</span>
                            </div>
                            <div class="bg-white p-1.5 rounded-sm border border-blue-200">
                                <span class="font-bold text-blue-700 block">&#123;&#123;3&#125;&#125;</span>
                                <span class="text-slate-500 font-sans">Jabatan</span>
                            </div>
                            <div class="bg-white p-1.5 rounded-sm border border-blue-200">
                                <span class="font-bold text-blue-700 block">&#123;&#123;4&#125;&#125;</span>
                                <span class="text-slate-500 font-sans">Kode Tiket</span>
                            </div>
                            <div class="bg-white p-1.5 rounded-sm border border-blue-200">
                                <span class="font-bold text-blue-700 block">&#123;&#123;5&#125;&#125;</span>
                                <span class="text-slate-500 font-sans">Link Web</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Template Pesan (Freeform) -->
                <div id="freeformTemplateCard" class="bg-white border border-slate-200 rounded-sm p-5 shadow-2xs space-y-4">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Format Teks Pesan</h2>
                            <p class="text-[11px] text-slate-400">Digunakan untuk Mode Sandbox / Teks Bebas atau fallback.</p>
                        </div>
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-sm border border-blue-200">
                            Pesan Teks Bebas
                        </span>
                    </div>

                    <!-- Variable Tags Helper -->
                    <div>
                        <span class="text-[11px] font-semibold text-slate-600 block mb-1.5">Klik untuk sisipkan variabel dinamis:</span>
                        <div class="flex flex-wrap gap-1.5">
                            <button type="button" onclick="insertVariable('{nama}')" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 text-[11px] font-mono font-semibold rounded-sm cursor-pointer transition">
                                {nama}
                            </button>
                            <button type="button" onclick="insertVariable('{instansi}')" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 text-[11px] font-mono font-semibold rounded-sm cursor-pointer transition">
                                {instansi}
                            </button>
                            <button type="button" onclick="insertVariable('{jabatan}')" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 text-[11px] font-mono font-semibold rounded-sm cursor-pointer transition">
                                {jabatan}
                            </button>
                            <button type="button" onclick="insertVariable('{kode_tiket}')" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 text-[11px] font-mono font-semibold rounded-sm cursor-pointer transition">
                                {kode_tiket}
                            </button>
                            <button type="button" onclick="insertVariable('{link_tiket}')" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 text-[11px] font-mono font-semibold rounded-sm cursor-pointer transition">
                                {link_tiket}
                            </button>
                        </div>
                    </div>

                    <!-- Textarea Template -->
                    <div>
                        <label for="waTemplateInput" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Isi Pesan WhatsApp <span class="text-rose-500">*</span>
                        </label>
                        <textarea 
                            name="wa_template" 
                            id="waTemplateInput" 
                            rows="7" 
                            required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-sm text-xs font-mono text-slate-900 leading-relaxed focus:outline-none focus:border-slate-900 focus:bg-white transition-colors"
                        >{{ old('wa_template', $template) }}</textarea>
                    </div>

                    <!-- Checkbox: Kirim Gambar QR Langsung -->
                    <div class="pt-2 border-t border-slate-100">
                        <label class="flex items-start gap-2.5 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="wa_attach_qr" 
                                id="attachQrCheckbox"
                                value="1" 
                                {{ $attachQr === '1' ? 'checked' : '' }}
                                class="mt-0.5 rounded-sm border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer"
                            >
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">Kirim Gambar QR Langsung (Sebagai Foto/Media Asli)</span>
                                <span class="text-[11px] text-slate-500 leading-normal block">
                                    WhatsApp peserta akan langsung menampilkan gambar QR Code secara visual (bukan tautan teks) dengan pesan di atas sebagai keterangannya.
                                </span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Card 3: Kredensial Twilio & Template ID -->
                <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-2xs space-y-4">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Kredensial Twilio API</h2>
                            <p class="text-[11px] text-slate-400">Konfigurasi Account SID, Auth Token, dan Template SID Twilio.</p>
                        </div>
                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-sm border border-emerald-200">
                            Twilio REST API
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Account SID -->
                        <div>
                            <label for="twilio_sid" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Twilio Account SID
                            </label>
                            <input 
                                type="text" 
                                name="twilio_sid" 
                                id="twilio_sid" 
                                value="{{ old('twilio_sid', $twilioSid) }}" 
                                placeholder="ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-sm text-xs font-mono text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white"
                            >
                        </div>

                        <!-- Auth Token -->
                        <div>
                            <label for="twilio_token" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Twilio Auth Token
                            </label>
                            <input 
                                type="password" 
                                name="twilio_token" 
                                id="twilio_token" 
                                value="{{ old('twilio_token', $twilioToken) }}" 
                                placeholder="Token rahasia Twilio"
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-sm text-xs font-mono text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white"
                            >
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Twilio WhatsApp Number -->
                        <div>
                            <label for="twilio_from" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Nomor Pengirim Twilio (From)
                            </label>
                            <input 
                                type="text" 
                                name="twilio_from" 
                                id="twilio_from" 
                                value="{{ old('twilio_from', $twilioFrom) }}" 
                                placeholder="+14155238886 (sandbox) atau nomor resmi"
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-sm text-xs font-mono text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white"
                            >
                            <span class="text-[10px] text-slate-400 mt-1 block">Gunakan <code>+14155238886</code> jika memakai Twilio Sandbox.</span>
                        </div>

                        <!-- Template Content SID -->
                        <div>
                            <label for="twilio_template_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Twilio Content SID <span class="text-slate-400 font-normal">(Template ID)</span>
                            </label>
                            <input 
                                type="text" 
                                name="twilio_template_id" 
                                id="twilio_template_id" 
                                value="{{ old('twilio_template_id', $twilioTemplateId) }}" 
                                placeholder="HXxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-sm text-xs font-mono text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white"
                            >
                            <span class="text-[10px] text-slate-400 mt-1 block">Didapat dari Twilio Console &gt; Content Template Builder.</span>
                        </div>
                    </div>

                    <!-- Info Box Twilio -->
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-sm text-[11px] text-slate-600 space-y-1">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Catatan Gambar QR Langsung:</span>
                        </div>
                        <p class="leading-relaxed">
                            Twilio memerlukan endpoint gambar yang dapat diakses publik. Pada pengujian lokal, gunakan tunnel seperti <strong>Ngrok</strong> agar Twilio dapat mengunduh gambar QR peserta secara otomatis dan mengirimkannya ke WhatsApp.
                        </p>
                    </div>

                </div>

                <!-- Tombol Simpan -->
                <div class="flex items-center justify-end">
                    <button 
                        type="submit" 
                        class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors cursor-pointer shadow-2xs border border-slate-900 flex items-center gap-2"
                    >
                        <span>Simpan Pengaturan</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Card 4: Uji Coba Kirim Pesan Tes -->
            <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-2xs space-y-3">
                <div class="border-b border-slate-100 pb-2">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Tes Kirim WhatsApp Twilio</h3>
                    <p class="text-[11px] text-slate-500">Kirim 1 pesan uji coba ke nomor Anda untuk memastikan template dan gambar QR masuk ke WhatsApp.</p>
                </div>

                <form action="{{ route('admin.wa-settings.test') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input 
                        type="tel" 
                        name="test_phone" 
                        required 
                        placeholder="Contoh: 081234567890" 
                        class="flex-grow px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-sm text-xs font-mono text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white"
                    >
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-sm transition-colors cursor-pointer flex items-center gap-1.5 shrink-0"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span>Kirim Tes</span>
                    </button>
                </form>
            </div>

        </div>

        <!-- Right Column: Live Mockup Chat WhatsApp -->
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
                            <span class="text-[10px] text-emerald-200">Online &bull; Akun Resmi</span>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-white/80 bg-black/20 px-2 py-0.5 rounded-sm">
                        Live Preview
                    </span>
                </div>

                <!-- Mockup Chat Wallpaper / Background -->
                <div class="bg-[#efeae2] p-4 min-h-[420px] max-h-[550px] overflow-y-auto space-y-3 font-sans text-xs">
                    
                    <div class="text-center">
                        <span class="px-2 py-0.5 bg-white/80 text-slate-500 text-[10px] font-medium rounded-sm shadow-2xs inline-block">
                            HARI INI
                        </span>
                    </div>

                    <!-- Chat Bubble Masuk -->
                    <div class="max-w-[90%] bg-white rounded-sm shadow-xs p-3 space-y-2.5 border border-slate-200/50">
                        
                        <!-- QR Image Attachment Mockup -->
                        <div id="previewQrContainer" class="bg-slate-50 border border-slate-200 rounded-sm p-3 text-center {{ $attachQr === '1' ? '' : 'hidden' }}">
                            <div class="flex justify-center">
                                <div id="previewQrcode" class="p-1.5 bg-white border border-slate-300 inline-block shadow-2xs"></div>
                            </div>
                            <span class="font-mono font-bold text-[11px] text-slate-800 mt-2 block">{{ $sample->qr_token }}</span>
                            <span class="text-[9px] text-slate-400 block">Lampiran Gambar Tiket QR (Media Asli)</span>
                        </div>

                        <!-- Text Body Message Live -->
                        <div id="previewMessageBody" class="text-xs text-slate-800 whitespace-pre-line leading-relaxed font-sans">
                            {!! nl2br(e($previewText)) !!}
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
                <div class="bg-slate-100 border-t border-slate-200 p-2.5 flex items-center justify-between text-[11px] text-slate-400">
                    <span>Penerima melihat gambar QR langsung di chat</span>
                    <span class="font-mono">WhatsApp Web / App</span>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    const sampleData = {
        nama: "{{ $sample->name }}",
        instansi: "{{ $sample->company }}",
        jabatan: "{{ $sample->position }}",
        kode_tiket: "{{ $sample->qr_token }}",
        link_tiket: "{{ route('participants.card', $sample->qr_token) }}"
    };

    const textarea = document.getElementById('waTemplateInput');
    const previewBody = document.getElementById('previewMessageBody');
    const checkboxAttach = document.getElementById('attachQrCheckbox');
    const previewQr = document.getElementById('previewQrContainer');
    const metaGuide = document.getElementById('metaTemplateGuide');

    // Switch mode
    function switchMode(mode) {
        if (mode === 'template') {
            metaGuide.classList.remove('hidden');
        } else {
            metaGuide.classList.add('hidden');
        }
    }

    // Render Preview QR Code
    document.addEventListener('DOMContentLoaded', function() {
        const qrEl = document.getElementById("previewQrcode");
        if (qrEl) {
            new QRCode(qrEl, {
                text: sampleData.kode_tiket,
                width: 130,
                height: 130,
                colorDark : "#0f172a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.M
            });
        }
    });

    // Sisipkan variabel ke posisi kursor textarea
    function insertVariable(tag) {
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const text = textarea.value;
        textarea.value = text.substring(0, start) + tag + text.substring(end);
        textarea.focus();
        textarea.selectionStart = textarea.selectionEnd = start + tag.length;
        updatePreview();
    }

    // Update Live Preview saat mengetik di textarea
    textarea.addEventListener('input', updatePreview);

    function updatePreview() {
        let text = textarea.value;
        text = text.replaceAll('{nama}', sampleData.nama)
                   .replaceAll('{instansi}', sampleData.instansi)
                   .replaceAll('{jabatan}', sampleData.jabatan)
                   .replaceAll('{kode_tiket}', sampleData.kode_tiket)
                   .replaceAll('{link_tiket}', sampleData.link_tiket);

        previewBody.textContent = text;
    }

    // Toggle Preview Gambar QR
    checkboxAttach.addEventListener('change', function() {
        if (this.checked) {
            previewQr.classList.remove('hidden');
        } else {
            previewQr.classList.add('hidden');
        }
    });
</script>
@endpush
