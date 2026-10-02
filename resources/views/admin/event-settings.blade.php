@extends('layouts.admin')

@section('title', 'Pengaturan Acara - Wonderful 2026')
@section('page_title', 'Pengaturan Acara')

@section('content')
<div class="space-y-6 max-w-5xl">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pengaturan Informasi Acara</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kustomisasi informasi kegiatan yang tampil di halaman depan pendaftaran (Flyer, Waktu, Lokasi, Dresscode, dan Peta).</p>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('participants.create') }}" target="_blank" class="btn-3d-white px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition-all flex items-center gap-1.5 shadow-2xs">
                <span>Lihat Halaman Depan</span>
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
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
            <p class="font-bold mb-1">Terjadi kesalahan pengisian formulir:</p>
            <ul class="list-disc list-inside space-y-0.5 ml-2 text-rose-700 font-medium">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Setting Acara -->
    <form action="{{ route('admin.event-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Card 1: Visual & Identitas Acara -->
        <div class="card-3d p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">1. Flyer & Identitas Acara</h2>
                <p class="text-[11px] text-slate-400 mt-0.5">Unggah poster visual kegiatan dan tentukan judul resmi acara.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                <!-- Preview Flyer -->
                <div class="md:col-span-4">
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                        Flyer / Poster Acara
                    </label>
                    <div class="border border-slate-200 rounded-xl p-3.5 bg-slate-50 text-center space-y-2.5">
                        <input type="hidden" name="remove_flyer" id="removeFlyerInput" value="0">

                        <!-- Gambar Preview / Placeholder -->
                        <div id="flyerPreviewContainer" class="relative overflow-hidden rounded-xl border border-slate-200 bg-slate-100 min-h-[180px] max-h-[260px] flex items-center justify-center p-2">
                            <img 
                                id="flyerPreviewImage" 
                                src="{{ !empty($settings['event_flyer']) ? asset($settings['event_flyer']) : '' }}" 
                                alt="Flyer Acara" 
                                class="{{ empty($settings['event_flyer']) ? 'hidden' : '' }} w-full h-auto max-h-[240px] object-contain rounded-lg shadow-2xs"
                            >
                            
                            <div id="flyerPlaceholder" class="{{ !empty($settings['event_flyer']) ? 'hidden' : '' }} w-full py-10 flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-10 h-10 text-slate-300 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs font-semibold text-slate-500">Belum ada flyer</span>
                                <span class="text-[10px] text-slate-400 mt-0.5">Pilih file gambar untuk pratinjau</span>
                            </div>
                        </div>

                        <!-- Info File Terpilih & Tombol Batal/Hapus -->
                        <div id="flyerActionRow" class="flex items-center justify-between text-[11px] px-1 {{ empty($settings['event_flyer']) ? 'hidden' : '' }}">
                            <span id="flyerFileName" class="text-slate-600 font-mono truncate max-w-[160px] text-left">
                                {{ !empty($settings['event_flyer']) ? basename($settings['event_flyer']) : '' }}
                            </span>
                            <button 
                                type="button" 
                                id="btnRemoveFlyer" 
                                onclick="removeCurrentFlyer()" 
                                class="text-rose-600 hover:text-rose-700 font-bold hover:underline cursor-pointer"
                            >
                                Hapus Flyer
                            </button>
                        </div>

                        <!-- Input File -->
                        <div>
                            <input 
                                type="file" 
                                name="flyer_file" 
                                id="flyerFileInput" 
                                accept="image/jpeg,image/png,image/webp,image/jpg,image/avif" 
                                onchange="handleFlyerSelect(this)"
                                class="text-xs text-slate-600 w-full file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800 cursor-pointer"
                            >
                        </div>
                        <span class="text-[10px] text-slate-400 block">Format: JPG, PNG, WEBP, AVIF (Maksimal 10MB)</span>

                        <!-- Opsi Penyesuaian Tampilan Flyer di Halaman Regis -->
                        <div class="pt-2.5 text-left border-t border-slate-200 space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                                Proporsi Tampilan di Halaman Regis
                            </label>
                            <div class="space-y-1.5">
                                <label class="flex items-start gap-2 p-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 cursor-pointer transition-colors">
                                    <input 
                                        type="radio" 
                                        name="event_flyer_fit" 
                                        value="contain" 
                                        {{ ($settings['event_flyer_fit'] ?? 'contain') === 'contain' ? 'checked' : '' }}
                                        class="mt-0.5 text-blue-600 focus:ring-blue-500"
                                    >
                                    <div class="min-w-0">
                                        <span class="font-bold text-slate-800 block text-[11px]">Tampil Utuh (Bebas Terpotong)</span>
                                        <span class="text-[10px] text-slate-400 block leading-tight">Flyer muncul penuh dari ujung atas hingga bawah tanpa ada gambar/teks terpotong.</span>
                                    </div>
                                </label>
                                <label class="flex items-start gap-2 p-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 cursor-pointer transition-colors">
                                    <input 
                                        type="radio" 
                                        name="event_flyer_fit" 
                                        value="cover" 
                                        {{ ($settings['event_flyer_fit'] ?? '') === 'cover' ? 'checked' : '' }}
                                        class="mt-0.5 text-blue-600 focus:ring-blue-500"
                                    >
                                    <div class="min-w-0">
                                        <span class="font-bold text-slate-800 block text-[11px]">Isi Penuh Wadah (Potong Sisi)</span>
                                        <span class="text-[10px] text-slate-400 block leading-tight">Mengisi seluruh wadah kartu, tepi flyer dapat terpotong jika rasio gambar berbeda.</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Input Detail Judul & Penyelenggara -->
                <div class="md:col-span-8 space-y-4">
                    <div>
                        <label for="event_title" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Judul / Nama Acara <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="event_title" 
                            id="event_title" 
                            value="{{ old('event_title', $settings['event_title']) }}" 
                            required 
                            class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                        >
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="event_organizer" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Penyelenggara (Diselenggarakan Oleh)
                            </label>
                            <input 
                                type="text" 
                                name="event_organizer" 
                                id="event_organizer" 
                                value="{{ old('event_organizer', $settings['event_organizer']) }}" 
                                placeholder="Contoh: Wonderful & Executive Board"
                                class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                            >
                            <span class="text-[10px] text-slate-400 mt-1 block">Tampil pada bagian "Diselenggarakan Oleh" di halaman depan pendaftaran.</span>
                        </div>

                        <div>
                            <label for="event_dresscode" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Dresscode Acara <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="event_dresscode" 
                                id="event_dresscode" 
                                value="{{ old('event_dresscode', $settings['event_dresscode']) }}" 
                                required 
                                placeholder="Contoh: Batik Formal / Pakaian Bisnis" 
                                class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="event_description" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Deskripsi / Tentang Acara
                        </label>
                        <textarea 
                            name="event_description" 
                            id="event_description" 
                            rows="3" 
                            class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all leading-relaxed" 
                            placeholder="Jelaskan gambaran umum kegiatan..."
                        >{{ old('event_description', $settings['event_description']) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Jadwal, Tempat, & Peta -->
        <div class="card-3d p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">2. Jadwal, Lokasi & Peta Lokasi</h2>
                <p class="text-[11px] text-slate-400 mt-0.5">Atur waktu pelaksanaan, nama gedung, serta integrasi peta Google Maps.</p>
            </div>

            <!-- Jadwal Waktu -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="event_date" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tanggal Acara <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="event_date" 
                        id="event_date" 
                        value="{{ old('event_date', $settings['event_date']) }}" 
                        required 
                        placeholder="Contoh: 28 Oktober 2026" 
                        class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                    >
                </div>

                <div>
                    <label for="event_time" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Jam / Waktu Pelaksanaan <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="event_time" 
                        id="event_time" 
                        value="{{ old('event_time', $settings['event_time']) }}" 
                        required 
                        placeholder="Contoh: 08:30 - 16:30 WIB" 
                        class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                    >
                </div>
            </div>

            <!-- Lokasi Gedung -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="event_venue_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Gedung / Ballroom <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="event_venue_name" 
                        id="event_venue_name" 
                        value="{{ old('event_venue_name', $settings['event_venue_name']) }}" 
                        required 
                        placeholder="Contoh: SCBD Area" 
                        class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                    >
                </div>

                <div>
                    <label for="event_maps_url" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tautan Google Maps Langsung (Link URL)
                    </label>
                    <input 
                        type="url" 
                        name="event_maps_url" 
                        id="event_maps_url" 
                        value="{{ old('event_maps_url', $settings['event_maps_url']) }}" 
                        placeholder="https://maps.google.com/?q=..." 
                        class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                    >
                </div>
            </div>

            <div>
                <label for="event_venue_address" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Alamat Lengkap Venue <span class="text-rose-500">*</span>
                </label>
                <textarea 
                    name="event_venue_address" 
                    id="event_venue_address" 
                    rows="2" 
                    required 
                    class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all leading-relaxed" 
                    placeholder="Contoh: SCBD Area, Jakarta Selatan"
                >{{ old('event_venue_address', $settings['event_venue_address']) }}</textarea>
            </div>

            <!-- Embed Iframe Google Maps -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="event_maps_iframe" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Kode Embed Iframe Google Maps (Opsional)
                    </label>
                    <span class="text-[10px] text-slate-400">Salin dari Google Maps > Share > Embed a map</span>
                </div>
                <textarea 
                    name="event_maps_iframe" 
                    id="event_maps_iframe" 
                    rows="3" 
                    class="input-3d w-full px-3.5 py-2.5 bg-slate-50 font-mono text-xs text-slate-800 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-600 focus:bg-white transition-all" 
                    placeholder="Contoh: <iframe src=&quot;https://www.google.com/maps/embed?...&quot; ...></iframe>"
                >{{ old('event_maps_iframe', $settings['event_maps_iframe']) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Jika diisi, peta Google Maps interaktif akan langsung tayang di landing page acara.</p>
            </div>
        </div>

        <!-- Card 3: Tampilan Layar Sambutan TV (Display Mode) -->
        <div class="card-3d p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">3. Tampilan Layar Sambutan TV (Display Mode)</h2>
                    <p class="text-[11px] text-slate-400 mt-0.5">Kustomisasi teks sambutan standby pada layar besar stage / foyer sebelum tamu melakukan tap tiket QR.</p>
                </div>
                <a href="{{ route('admin.display') }}" target="_blank" class="text-[11px] font-bold text-blue-600 hover:underline flex items-center gap-1">
                    <span>Buka Layar Display</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="display_welcome_text" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Teks Pembuka Sambutan (Baris 1)
                    </label>
                    <input 
                        type="text" 
                        name="display_welcome_text" 
                        id="display_welcome_text" 
                        value="{{ old('display_welcome_text', $settings['display_welcome_text'] ?? 'Selamat Datang di') }}" 
                        placeholder="Contoh: Selamat Datang di" 
                        class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                    >
                </div>

                <div>
                    <label for="display_event_title" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Judul Utama di Layar TV (Baris 2)
                    </label>
                    <input 
                        type="text" 
                        name="display_event_title" 
                        id="display_event_title" 
                        value="{{ old('display_event_title', $settings['display_event_title'] ?? 'Wonderful 2026') }}" 
                        placeholder="Contoh: Wonderful 2026" 
                        class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all"
                    >
                </div>
            </div>

            <div>
                <label for="display_instruction_text" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Teks Petunjuk / Keterangan di Layar
                </label>
                <textarea 
                    name="display_instruction_text" 
                    id="display_instruction_text" 
                    rows="2" 
                    class="input-3d w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white transition-all leading-relaxed" 
                    placeholder="Contoh: Silakan arahkan tiket QR Anda pada meja registrasi. Layar ini akan otomatis menampilkan verifikasi kehadiran secara real-time."
                >{{ old('display_instruction_text', $settings['display_instruction_text'] ?? 'Silakan arahkan tiket QR Anda pada meja registrasi. Layar ini akan otomatis menampilkan verifikasi kehadiran secara real-time.') }}</textarea>
            </div>
        </div>

        <!-- Tombol Aksi Simpan Solid Charcoal -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <button 
                type="submit" 
                class="btn-3d-dark px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl border border-slate-900 transition-all cursor-pointer flex items-center gap-2 shadow-2xs"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Simpan Perubahan Acara</span>
            </button>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
    function handleFlyerSelect(input) {
        const file = input.files && input.files[0];
        const previewImg = document.getElementById('flyerPreviewImage');
        const placeholder = document.getElementById('flyerPlaceholder');
        const actionRow = document.getElementById('flyerActionRow');
        const fileNameEl = document.getElementById('flyerFileName');
        const removeInput = document.getElementById('removeFlyerInput');

        if (!file) return;

        // Validasi ukuran sisi klien (10MB)
        const maxSize = 10 * 1024 * 1024;
        if (file.size > maxSize) {
            Swal.fire({
                icon: 'warning',
                title: 'Ukuran File Terlalu Besar',
                text: `Ukuran file flyer Anda adalah ${(file.size / (1024 * 1024)).toFixed(1)} MB. Batas maksimal yang diperbolehkan adalah 10 MB.`,
                confirmButtonColor: '#0f172a'
            });
            input.value = '';
            return;
        }

        // Tampilkan instant preview via URL.createObjectURL
        const objectUrl = URL.createObjectURL(file);
        previewImg.src = objectUrl;
        previewImg.classList.remove('hidden');
        placeholder.classList.add('hidden');

        // Tampilkan info file
        actionRow.classList.remove('hidden');
        const sizeFormatted = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
        fileNameEl.textContent = `${file.name} (${sizeFormatted})`;
        removeInput.value = '0';
    }

    function removeCurrentFlyer() {
        const input = document.getElementById('flyerFileInput');
        const previewImg = document.getElementById('flyerPreviewImage');
        const placeholder = document.getElementById('flyerPlaceholder');
        const actionRow = document.getElementById('flyerActionRow');
        const removeInput = document.getElementById('removeFlyerInput');

        input.value = '';
        previewImg.src = '';
        previewImg.classList.add('hidden');
        placeholder.classList.remove('hidden');
        actionRow.classList.add('hidden');
        removeInput.value = '1';
    }
</script>
@endpush
