@extends('layouts.admin')

@section('title', 'Pengaturan WhatsApp & Twilio - Kadin 2026')
@section('page_title', 'Pengaturan WhatsApp')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Pengaturan WhatsApp & Twilio</h1>
            <p class="text-xs text-slate-500 mt-0.5">Sesuaikan template pesan presensi, lampiran gambar QR, dan integrasi WhatsApp API Twilio.</p>
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

                <!-- Card 1: Template Pesan -->
                <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-2xs space-y-4">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Template Pesan WhatsApp</h2>
                            <p class="text-[11px] text-slate-400">Pesan yang dikirimkan ke nomor WhatsApp peserta.</p>
                        </div>
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-sm border border-blue-200">
                            WhatsApp Blast
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
                            Format Teks Pesan <span class="text-rose-500">*</span>
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
                                <span class="text-xs font-bold text-slate-800 block">Kirim Gambar QR Code Langsung (MediaUrl)</span>
                                <span class="text-[11px] text-slate-500 leading-normal block">
                                    Twilio akan otomatis mengunduh gambar QR peserta dari endpoint sistem dan melampirkannya sebagai gambar langsung di chat WhatsApp.
                                </span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Card 2: Kredensial Twilio -->
                <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-2xs space-y-4">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Kredensial Twilio API</h2>
                            <p class="text-[11px] text-slate-400">Hubungkan akun Twilio untuk broadcast pesan via WhatsApp Business API.</p>
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
                            <span class="text-[10px] text-slate-400 mt-1 block">Gunakan <code>+14155238886</code> jika menggunakan Twilio Sandbox.</span>
                        </div>

                        <!-- Template Content SID (Opsional) -->
                        <div>
                            <label for="twilio_template_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Content SID / Template ID <span class="text-slate-400 font-normal">(opsional)</span>
                            </label>
                            <input 
                                type="text" 
                                name="twilio_template_id" 
                                id="twilio_template_id" 
                                value="{{ old('twilio_template_id', $twilioTemplateId) }}" 
                                placeholder="HXxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-sm text-xs font-mono text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white"
                            >
                            <span class="text-[10px] text-slate-400 mt-1 block">Wajib jika memakai template resmi Meta yang telah di-approve.</span>
                        </div>
                    </div>

                    <!-- Info Box Twilio -->
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-sm text-[11px] text-slate-600 space-y-1">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Aturan WhatsApp Business API:</span>
                        </div>
                        <p class="leading-relaxed">
                            Jika menggunakan akun <strong>Twilio Sandbox</strong>, nomor penerima harus join terlebih dahulu (misal kirim <code>join &lt;kata-kunci&gt;</code> ke nomor Twilio). Jika akun <strong>Production</strong>, pastikan isi template telah disetujui di Meta / Twilio Console.
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

            <!-- Card 3: Uji Coba Kirim Pesan Tes -->
            <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-2xs space-y-3">
                <div class="border-b border-slate-100 pb-2">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Tes Kirim WhatsApp Twilio</h3>
                    <p class="text-[11px] text-slate-500">Kirim 1 pesan uji coba ke nomor Anda untuk memastikan koneksi Twilio dan gambar QR berjalan.</p>
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
                            <span class="text-[9px] text-slate-400 block">Lampiran Gambar Tiket QR (MediaUrl)</span>
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
                    <span>Simulasi pesan yang akan diterima di HP peserta</span>
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
