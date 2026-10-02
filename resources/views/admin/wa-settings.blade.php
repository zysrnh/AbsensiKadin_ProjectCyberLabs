@extends('layouts.admin')

@section('title', 'Pengaturan WhatsApp & Twilio - Wonderful 2026')
@section('page_title', 'Pengaturan WA & Twilio')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pengaturan WhatsApp & Twilio</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola kredensial akun Twilio, nomor pengirim, dan 3 slot Content SID resmi Meta untuk broadcast otomatis.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn-3d-white px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition-all shadow-2xs">
                Dashboard
            </a>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-center gap-2 font-medium">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs">
            <p class="font-bold mb-1">Terjadi kesalahan pengisian:</p>
            <ul class="list-disc list-inside space-y-0.5 ml-2 text-rose-700 font-medium">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Grid: Settings Form Left (7 cols), Test & Shortcuts Right (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Kolom Kiri: Form Konfigurasi Twilio & 3 Slot Content SID (7 cols) -->
        <div class="lg:col-span-7 space-y-5">
            
            <form action="{{ route('admin.wa-settings.update') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Card 1: Kredensial Akun Twilio -->
                <div class="card-3d p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Kredensial Akun Twilio</h2>
                        <p class="text-[11px] text-slate-400 mt-0.5">Didapat dari Console Twilio (Dashboard Akun Anda).</p>
                    </div>

                    <!-- Mode Pengiriman -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                            Mode Pengiriman Twilio
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Mode Template Resmi -->
                            <label class="border border-slate-200 rounded-xl p-3.5 cursor-pointer hover:border-slate-400 transition-all flex items-start gap-2.5 bg-slate-50/50 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/50 has-[:checked]:ring-1 has-[:checked]:ring-blue-600">
                                <input 
                                    type="radio" 
                                    name="twilio_mode" 
                                    value="template" 
                                    {{ old('twilio_mode', $twilioMode) === 'template' ? 'checked' : '' }}
                                    class="mt-0.5 text-blue-600 focus:ring-blue-600 cursor-pointer"
                                >
                                <div class="space-y-0.5">
                                    <span class="text-xs font-bold text-slate-900 block">Mode Meta Template (Resmi)</span>
                                    <p class="text-[11px] text-slate-500 leading-normal">
                                        Wajib untuk nomor resmi Wonderful / akun Production via Content SID.
                                    </p>
                                </div>
                            </label>

                            <!-- Mode Freeform / Sandbox -->
                            <label class="border border-slate-200 rounded-xl p-3.5 cursor-pointer hover:border-slate-400 transition-all flex items-start gap-2.5 bg-slate-50/50 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/50 has-[:checked]:ring-1 has-[:checked]:ring-blue-600">
                                <input 
                                    type="radio" 
                                    name="twilio_mode" 
                                    value="freeform" 
                                    {{ old('twilio_mode', $twilioMode) === 'freeform' ? 'checked' : '' }}
                                    class="mt-0.5 text-blue-600 focus:ring-blue-600 cursor-pointer"
                                >
                                <div class="space-y-0.5">
                                    <span class="text-xs font-bold text-slate-900 block">Mode Sandbox / Bebas</span>
                                    <p class="text-[11px] text-slate-500 leading-normal">
                                        Cocok untuk uji coba pengembang dengan pesan teks bebas.
                                    </p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                        <!-- Twilio Account SID -->
                        <div>
                            <label for="twilio_sid" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Twilio Account SID <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="twilio_sid" 
                                id="twilio_sid" 
                                value="{{ old('twilio_sid', $twilioSid) }}" 
                                placeholder="ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                                class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                            >
                        </div>

                        <!-- Twilio Auth Token -->
                        <div>
                            <label for="twilio_token" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Twilio Auth Token <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="password" 
                                name="twilio_token" 
                                id="twilio_token" 
                                value="{{ old('twilio_token', $twilioToken) }}" 
                                placeholder="Masukkan Auth Token Twilio"
                                class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                            >
                        </div>
                    </div>

                    <!-- Nomor Pengirim WhatsApp (From) -->
                    <div>
                        <label for="twilio_from" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nomor Pengirim Twilio (From) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="twilio_from" 
                            id="twilio_from" 
                            value="{{ old('twilio_from', $twilioFrom) }}" 
                            placeholder="+14155238886 (sandbox) atau +628xxxxxxxx (resmi)"
                            class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                        >
                        <span class="text-[11px] text-slate-400 mt-1.5 block">
                            Gunakan <code class="font-mono text-slate-600">+14155238886</code> jika masih memakai Twilio Sandbox, atau ganti nomor resmi WhatsApp Business jika sudah live.
                        </span>
                    </div>
                </div>

                <!-- Card 2: 3 Slot Twilio Content SID Resmi Meta -->
                <div class="card-3d p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">3 Slot Twilio Content SID</h2>
                        <p class="text-[11px] text-slate-400 mt-0.5">Kode template resmi yang disetujui Meta di Twilio Content Template Builder.</p>
                    </div>

                    <div class="space-y-4">
                        <!-- Slot 1: Undangan Acara -->
                        <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label for="twilio_invitation_template_id" class="block text-xs font-bold text-slate-900 uppercase tracking-wider">
                                    Slot 1: Undangan Registrasi Acara
                                </label>
                                <span class="text-[10px] font-mono text-slate-500 font-semibold">Tipe: Quick Reply (8 Var)</span>
                            </div>
                            <input 
                                type="text" 
                                name="twilio_invitation_template_id" 
                                id="twilio_invitation_template_id" 
                                value="{{ old('twilio_invitation_template_id', $twilioInvitationTemplateId) }}" 
                                placeholder="HX55189df5f82668658e0c028e8a3892f1"
                                class="input-3d w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-900 focus:outline-none focus:border-blue-600"
                            >
                            <span class="text-[10px] text-slate-400 block">Digunakan saat melakukan broadcast undangan di menu <em>Kirim Undangan</em>.</span>
                        </div>

                        <!-- Slot 2: Tiket QR Media -->
                        <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label for="twilio_template_id" class="block text-xs font-bold text-slate-900 uppercase tracking-wider">
                                    Slot 2: Tiket Presensi QR Code Media
                                </label>
                                <span class="text-[10px] font-mono text-slate-500 font-semibold">Tipe: Media Image (5 Var)</span>
                            </div>
                            <input 
                                type="text" 
                                name="twilio_template_id" 
                                id="twilio_template_id" 
                                value="{{ old('twilio_template_id', $twilioTemplateId) }}" 
                                placeholder="HXb5bb1bdad43f0d1d4198c4ae1c8cc5d9"
                                class="input-3d w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-900 focus:outline-none focus:border-blue-600"
                            >
                            <span class="text-[10px] text-slate-400 block">Digunakan saat mengirim tiket QR masuk di menu <em>Kirim Tiket QR</em> & Dashboard.</span>
                        </div>

                        <!-- Slot 3: Reminder & RSVP -->
                        <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label for="twilio_reminder_template_id" class="block text-xs font-bold text-slate-900 uppercase tracking-wider">
                                    Slot 3: Pengingat & RSVP Kehadiran
                                </label>
                                <span class="text-[10px] font-mono text-slate-500 font-semibold">Tipe: Quick Reply (7 Var)</span>
                            </div>
                            <input 
                                type="text" 
                                name="twilio_reminder_template_id" 
                                id="twilio_reminder_template_id" 
                                value="{{ old('twilio_reminder_template_id', $twilioReminderTemplateId) }}" 
                                placeholder="HXd5eba0c89c4950f3c1edec3740e25f19"
                                class="input-3d w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-900 focus:outline-none focus:border-blue-600"
                            >
                            <span class="text-[10px] text-slate-400 block">Digunakan saat blast pengingat H-1 / Hari-H di menu <em>Kirim Reminder</em>.</span>
                        </div>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="flex items-center justify-end">
                    <button 
                        type="submit" 
                        class="btn-3d-dark px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl border border-slate-900 transition-all shadow-2xs cursor-pointer"
                    >
                        Simpan Pengaturan Twilio
                    </button>
                </div>

            </form>

        </div>

        <!-- Kolom Kanan: Panel Test Pengiriman & Shortcut Editor (5 cols) -->
        <div class="lg:col-span-5 space-y-5">
            
            <!-- Card 1: Uji Coba Pengiriman Twilio (Test Send) -->
            <div class="card-3d p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Uji Coba Pengiriman</h2>
                    <p class="text-[11px] text-slate-400 mt-0.5">Pastikan kredensial & saldo Twilio aktif dengan mengirim pesan tes.</p>
                </div>

                <form action="{{ route('admin.wa-settings.test') }}" method="POST" class="space-y-3.5">
                    @csrf
                    <div>
                        <label for="test_phone" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nomor WhatsApp Tujuan Tester
                        </label>
                        <input 
                            type="tel" 
                            name="test_phone" 
                            id="test_phone" 
                            value="{{ old('test_phone', '083861669565') }}"
                            placeholder="081234567890" 
                            required
                            class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                        >
                        <span class="text-[10px] text-slate-400 mt-1 block">Pastikan nomor tester sudah join sandbox jika memakai mode sandbox.</span>
                    </div>

                    <button 
                        type="submit" 
                        class="btn-3d-blue w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl border border-blue-600 transition-all flex items-center justify-center gap-1.5 shadow-2xs cursor-pointer"
                    >
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span>Kirim Pesan Uji Coba</span>
                    </button>
                </form>
            </div>

            <!-- Card 2: Kelola Pesan & Format Teks (Navigasi Cepat) -->
            <div class="card-3d p-6 space-y-3">
                <div class="border-b border-slate-100 pb-2.5">
                    <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Editor Format Pesan</h2>
                    <p class="text-[11px] text-slate-400 mt-0.5">
                        Format kata-kata teks & template pesan dikelola langsung pada halaman kerja masing-masing:
                    </p>
                </div>

                <div class="space-y-2">
                    <!-- Shortcut 1: Undangan -->
                    <a href="{{ route('admin.invitation') }}" class="p-3.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-between group transition-all">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block group-hover:text-blue-600">1. Editor Undangan Acara</span>
                            <span class="text-[11px] text-slate-500">Sesuaikan kalimat undangan & batas waktu pendaftaran.</span>
                        </div>
                        <span class="text-xs font-bold text-slate-400 group-hover:text-slate-800 transition">→</span>
                    </a>

                    <!-- Shortcut 2: Tiket QR -->
                    <a href="{{ route('admin.tickets') }}" class="p-3.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-between group transition-all">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block group-hover:text-blue-600">2. Editor Tiket Presensi QR</span>
                            <span class="text-[11px] text-slate-500">Sesuaikan kalimat tiket & lampiran QR Code peserta.</span>
                        </div>
                        <span class="text-xs font-bold text-slate-400 group-hover:text-slate-800 transition">→</span>
                    </a>

                    <!-- Shortcut 3: Reminder RSVP -->
                    <a href="{{ route('admin.reminder') }}" class="p-3.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-between group transition-all">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block group-hover:text-blue-600">3. Editor Reminder & RSVP</span>
                            <span class="text-[11px] text-slate-500">Sesuaikan pesan pengingat H-1 dan tombol konfirmasi kehadiran.</span>
                        </div>
                        <span class="text-xs font-bold text-slate-400 group-hover:text-slate-800 transition">→</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
