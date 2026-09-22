@extends('layouts.app')

@section('title', 'Form Registrasi Peserta - Kadin 2026')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header Page -->
    <div class="mb-6">
        <div class="inline-block px-2.5 py-1 bg-blue-100 text-blue-800 font-bold text-xs uppercase tracking-wider mb-2 rounded-none">
            Registrasi Kehadiran
        </div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Form Pendaftaran Peserta Kadin 2026</h1>
        <p class="text-sm text-slate-600 mt-1">
            Silakan lengkapi formulir di bawah ini. Tiket QR Code dan konfirmasi kehadiran akan disiapkan untuk blast WhatsApp.
        </p>
    </div>

    <!-- Card Form Solid Flat -->
    <div class="bg-white border border-slate-300 rounded-none p-6 sm:p-8 shadow-none">
        <form action="{{ route('participants.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Field 1: Nama Lengkap -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
                    Nama Lengkap <span class="text-rose-600">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name') }}" 
                    placeholder="Contoh: Budi Santoso, S.E."
                    required
                    class="w-full px-3.5 py-2.5 bg-slate-50 border {{ $errors->has('name') ? 'border-rose-500 bg-rose-50/50' : 'border-slate-300' }} text-slate-900 text-sm rounded-none focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700 transition"
                >
                @error('name')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Field 2: Email -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
                    Alamat Email <span class="text-rose-600">*</span>
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email') }}" 
                    placeholder="nama@perusahaan.com"
                    required
                    class="w-full px-3.5 py-2.5 bg-slate-50 border {{ $errors->has('email') ? 'border-rose-500 bg-rose-50/50' : 'border-slate-300' }} text-slate-900 text-sm rounded-none focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700 transition"
                >
                @error('email')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Field 3: Nomor WhatsApp / Telepon -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="phone_number" class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                        Nomor WhatsApp / Telepon <span class="text-rose-600">*</span>
                    </label>
                    <span class="text-[11px] font-semibold text-emerald-700">Untuk blast WA</span>
                </div>
                <div class="relative">
                    <input 
                        type="text" 
                        name="phone_number" 
                        id="phone_number" 
                        value="{{ old('phone_number') }}" 
                        placeholder="Contoh: 08123456789 atau 628123456789"
                        required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border {{ $errors->has('phone_number') ? 'border-rose-500 bg-rose-50/50' : 'border-slate-300' }} text-slate-900 text-sm rounded-none focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700 transition"
                    >
                </div>
                <p class="mt-1 text-xs text-slate-500">Nomor ini akan digunakan sebagai target pengiriman tiket QR via WhatsApp.</p>
                @error('phone_number')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Field 4: Instansi / Perusahaan / Jabatan (Opsional) -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="institution" class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                        Instansi / Perusahaan / Jabatan
                    </label>
                    <span class="text-[11px] text-slate-400 font-medium">(Opsional)</span>
                </div>
                <input 
                    type="text" 
                    name="institution" 
                    id="institution" 
                    value="{{ old('institution') }}" 
                    placeholder="Contoh: PT Sumber Rezeki / Bidang Perdagangan"
                    class="w-full px-3.5 py-2.5 bg-slate-50 border {{ $errors->has('institution') ? 'border-rose-500' : 'border-slate-300' }} text-slate-900 text-sm rounded-none focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700 transition"
                >
                @error('institution')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Field 5: Catatan Tambahan (Opsional) -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="notes" class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                        Catatan Tambahan
                    </label>
                    <span class="text-[11px] text-slate-400 font-medium">(Opsional)</span>
                </div>
                <textarea 
                    name="notes" 
                    id="notes" 
                    rows="2" 
                    placeholder="Tambahkan keterangan jika ada..."
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-none focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700 transition"
                >{{ old('notes') }}</textarea>
            </div>

            <!-- Notice Box Flat -->
            <div class="p-3 bg-blue-50 border border-blue-200 text-xs text-blue-900 flex items-start space-x-2">
                <svg class="w-4 h-4 text-blue-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Setelah pendaftaran disimpan, sistem akan langsung membuat <strong>Tiket QR Code</strong> resmi yang siap di-blast ke WhatsApp peserta.</span>
            </div>

            <!-- Submit Button -->
            <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-3">
                <button 
                    type="submit" 
                    class="w-full sm:w-auto px-6 py-3 bg-blue-700 hover:bg-blue-800 text-white font-bold text-sm uppercase tracking-wider rounded-none border border-blue-800 cursor-pointer transition shadow-none"
                >
                    Simpan & Buat Tiket QR
                </button>

                <a href="{{ route('participants.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 uppercase tracking-wider underline">
                    Lihat Daftar Peserta →
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
