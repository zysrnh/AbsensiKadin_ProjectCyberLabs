@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-950 py-10 px-4 sm:px-6 lg:px-8 flex flex-col justify-center items-center">
    <div class="w-full max-w-xl">
        <!-- Header Brand & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-lg bg-blue-600 text-white font-bold text-xl mb-3 shadow-md">
                KADIN
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">Form Pendaftaran Peserta</h1>
            <p class="text-sm text-slate-400 mt-1.5">Silakan isi data diri Anda di bawah ini dengan benar</p>
        </div>

        <!-- Alert Error / Success -->
        @if(session('success'))
            <div class="mb-5 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card Form Halus -->
        <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-2xl p-6 sm:p-8 space-y-5">
            <form action="{{ route('participants.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Nama Lengkap <span class="text-rose-400">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}" 
                        required 
                        placeholder="Contoh: Budi Santoso, S.E."
                        class="w-full px-4 py-2.5 bg-slate-950/70 border border-slate-700/80 rounded-lg text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors"
                    >
                </div>

                <!-- Instansi / Perusahaan -->
                <div>
                    <label for="company" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Instansi / Perusahaan <span class="text-rose-400">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="company" 
                        id="company" 
                        value="{{ old('company') }}" 
                        required 
                        placeholder="Nama instansi, organisasi, atau perusahaan"
                        class="w-full px-4 py-2.5 bg-slate-950/70 border border-slate-700/80 rounded-lg text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors"
                    >
                </div>

                <!-- Jabatan -->
                <div>
                    <label for="position" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Jabatan / Posisi <span class="text-rose-400">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="position" 
                        id="position" 
                        value="{{ old('position') }}" 
                        required 
                        placeholder="Contoh: Direktur Utama / Staf Ahli"
                        class="w-full px-4 py-2.5 bg-slate-950/70 border border-slate-700/80 rounded-lg text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors"
                    >
                </div>

                <!-- Grid Kontak (WhatsApp & Email) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                            Nomor WhatsApp <span class="text-rose-400">*</span>
                        </label>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phone" 
                            value="{{ old('phone') }}" 
                            required 
                            placeholder="081234567890"
                            class="w-full px-4 py-2.5 bg-slate-950/70 border border-slate-700/80 rounded-lg text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors"
                        >
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                            Email <span class="text-slate-500 font-normal lowercase">(opsional)</span>
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            value="{{ old('email') }}" 
                            placeholder="nama@perusahaan.com"
                            class="w-full px-4 py-2.5 bg-slate-950/70 border border-slate-700/80 rounded-lg text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors"
                        >
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-3">
                    <button 
                        type="submit" 
                        class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-semibold text-sm rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-150 flex items-center justify-center gap-2"
                    >
                        <span>Kirim Pendaftaran</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center text-xs text-slate-500 mt-6">
            &copy; {{ date('Y') }} KADIN. Hak Cipta Dilindungi.
        </p>
    </div>
</div>
@endsection
