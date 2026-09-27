@extends('layouts.guest')

@section('title', 'Login Administrator - KADIN 2026')

@section('content')
<div class="w-full max-w-sm mx-auto px-4">

    <!-- Card Login Clean Flat Solid -->
    <div class="bg-white border border-slate-200 rounded-sm shadow-xs p-6 sm:p-7">
        
        <!-- Header Brand -->
        <div class="text-center pb-5 mb-5 border-b border-slate-100">
            <span class="px-3 py-1 bg-slate-900 text-white font-black text-xs tracking-widest uppercase rounded-sm inline-block mb-3">
                KADIN ADMIN
            </span>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Portal Masuk Administrator</h1>
            <p class="text-xs text-slate-500 mt-1">Silakan masuk untuk mengelola data kehadiran & sistem acara.</p>
        </div>

        <!-- Alert Notifikasi Flash -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-sm text-xs flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-sm text-xs">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email Input -->
            <div>
                <label for="email" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Alamat Email
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email', 'admin@kadin.id') }}" 
                    required 
                    autofocus
                    placeholder="admin@kadin.id"
                    class="w-full px-3 py-2 bg-white border {{ $errors->has('email') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} rounded-sm text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                >
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Kata Sandi
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required 
                    placeholder="••••••••"
                    class="w-full px-3 py-2 bg-white border {{ $errors->has('password') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} rounded-sm text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors"
                >
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                    <input type="checkbox" name="remember" class="rounded-xs text-slate-900 focus:ring-slate-900 border-slate-300">
                    <span>Ingat sesi masuk</span>
                </label>
            </div>

            <!-- Tombol Submit Solid Charcoal -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors cursor-pointer flex items-center justify-center gap-2 border border-slate-900 shadow-2xs"
                >
                    <span>Masuk ke Dashboard</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>

            <!-- Default Credential Helper Note -->
            <div class="mt-4 p-2.5 bg-slate-50 border border-slate-200 rounded-sm text-[11px] text-slate-500 text-center">
                Akun Default: <span class="font-mono text-slate-700 font-semibold">admin@kadin.id</span> / <span class="font-mono text-slate-700 font-semibold">password</span>
            </div>
        </form>

    </div>

    <!-- Kembali ke Halaman Depan -->
    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-slate-800 transition-colors">
            ← Kembali ke Halaman Pendaftaran
        </a>
    </div>

</div>
@endsection
