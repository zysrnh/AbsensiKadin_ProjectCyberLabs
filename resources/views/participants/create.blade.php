@extends('layouts.guest')

@section('title', 'Formulir Pendaftaran Peserta - KADIN')

@section('content')
<div class="w-full max-w-xl px-4 sm:px-6">
    
    <!-- Header Form Bersih -->
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Formulir Pendaftaran</h1>
        <p class="text-xs text-slate-500 mt-1">Lengkapi data diri Anda di bawah ini untuk penerbitan tiket presensi QR Code.</p>
    </div>

    <!-- Alert Error Validasi -->
    @if($errors->any())
        <div class="mb-5 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-sm text-xs">
            <div class="font-bold mb-1 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Mohon periksa kembali isian formulir:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 ml-5 text-rose-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Card Form Clean White Solid Flat -->
    <div class="bg-white border border-slate-200 rounded-sm shadow-xs p-6 sm:p-8">
        <form action="{{ route('participants.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Nama Lengkap -->
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

            <!-- Instansi / Perusahaan -->
            <div>
                <label for="company" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Instansi / Perusahaan <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="company" 
                    id="company" 
                    value="{{ old('company') }}" 
                    required 
                    placeholder="Contoh: PT Sumber Pangan / Kadin Jawa Barat"
                    class="w-full px-3.5 py-2.5 bg-white border {{ $errors->has('company') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} rounded-sm text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                >
            </div>

            <!-- Jabatan / Posisi -->
            <div>
                <label for="position" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Jabatan / Posisi <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="position" 
                    id="position" 
                    value="{{ old('position') }}" 
                    required 
                    placeholder="Contoh: Direktur Utama / Manajer Operasional"
                    class="w-full px-3.5 py-2.5 bg-white border {{ $errors->has('position') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} rounded-sm text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                >
            </div>

            <!-- Baris Grid: Nomor WhatsApp & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nomor WhatsApp -->
                <div>
                    <label for="phone" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nomor WhatsApp <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="tel" 
                        name="phone" 
                        id="phone" 
                        value="{{ old('phone') }}" 
                        required 
                        placeholder="081234567890"
                        class="w-full px-3.5 py-2.5 bg-white border {{ $errors->has('phone') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} rounded-sm text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                    >
                </div>

                <!-- Email -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Email
                        </label>
                        <span class="text-[10px] text-slate-400 font-normal">(opsional)</span>
                    </div>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        placeholder="nama@perusahaan.com"
                        class="w-full px-3.5 py-2.5 bg-white border {{ $errors->has('email') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} rounded-sm text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                    >
                </div>
            </div>

            <!-- Info Box Bersih -->
            <div class="p-3 bg-slate-50 border border-slate-200 rounded-sm text-[11px] text-slate-600 flex items-start gap-2">
                <svg class="w-4 h-4 text-slate-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Setelah registrasi dikirim, Anda akan langsung menerima <strong>Tiket Presensi QR Code</strong> resmi yang dapat disimpan dan ditunjukkan saat tiba di lokasi.</span>
            </div>

            <!-- Tombol Submit Solid Charcoal/Hitam Formal: Kirim Pendaftaran Aja -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm rounded-sm transition-colors cursor-pointer flex items-center justify-center gap-2 border border-slate-900"
                >
                    <span>Kirim Pendaftaran</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
