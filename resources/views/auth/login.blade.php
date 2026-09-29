@extends('layouts.guest')

@section('title', 'Login Administrator - C LEVEL 2026')

@push('styles')
<style>
    :root {
        --ease-expo: cubic-bezier(0.16, 1, 0.3, 1);
        --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* Kinetic Smooth Entrance Animation */
    @keyframes kineticReveal {
        0% {
            opacity: 0;
            transform: translateY(28px) scale(0.97);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Ambient Subtle Floating Accent */
    @keyframes floatSlow {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-6px) rotate(2deg);
        }
    }

    /* Multi-layered 3D Elevation Shadow System (Sama dengan Beranda) */
    .login-card-3d {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.95);
        box-shadow: 
            0 2px 4px rgba(15, 23, 42, 0.03),
            0 12px 24px -4px rgba(15, 23, 42, 0.08),
            0 28px 60px -12px rgba(15, 23, 42, 0.14),
            0 45px 85px -20px rgba(15, 23, 42, 0.08);
        border-radius: 1.5rem; /* rounded-2xl smooth */
        animation: kineticReveal 0.65s var(--ease-expo) forwards;
        transition: transform 0.35s var(--ease-expo), box-shadow 0.35s var(--ease-expo);
    }

    .login-card-3d:hover {
        box-shadow: 
            0 4px 8px rgba(15, 23, 42, 0.04),
            0 16px 32px -4px rgba(15, 23, 42, 0.10),
            0 36px 70px -12px rgba(15, 23, 42, 0.18),
            0 55px 95px -20px rgba(15, 23, 42, 0.12);
    }

    /* 3D Tactile Buttons (Efek Tombol Fisik Timbul & Push-down) */
    .btn-3d-dark {
        box-shadow: 0 4px 0 #020617, 0 10px 20px -3px rgba(15, 23, 42, 0.35);
        transition: all 0.15s var(--ease-expo);
    }
    .btn-3d-dark:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 #020617, 0 14px 26px -4px rgba(15, 23, 42, 0.4);
    }
    .btn-3d-dark:active {
        transform: translateY(3px);
        box-shadow: 0 1px 0 #020617, 0 4px 10px -2px rgba(15, 23, 42, 0.25);
    }

    /* 3D Inset Input Fields */
    .input-3d {
        box-shadow: inset 0 2px 4px rgba(15, 23, 42, 0.04);
        transition: all 0.2s var(--ease-expo);
    }
    .input-3d:focus {
        box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.02), 0 0 0 4px rgba(15, 23, 42, 0.08);
    }

    .anim-float {
        animation: floatSlow 6s ease-in-out infinite;
    }
</style>
@endpush

@section('content')
<div class="w-full max-w-md mx-auto px-4 py-4 sm:py-8">

    <!-- Card Login dengan 3D Depth, Smooth Rounded & Realistic Shadow -->
    <div class="login-card-3d p-7 sm:p-9 relative overflow-hidden">
        
        <!-- Header Brand & Badge -->
        <div class="text-center pb-6 mb-6 border-b border-slate-100 relative">
            
            <!-- Badge Brand Pill Halus -->
            <div class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-slate-900 text-white font-extrabold text-[11px] tracking-wider uppercase rounded-full mb-3 shadow-xs">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                <span>C LEVEL ADMIN</span>
            </div>

            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Portal Administrator</h1>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                Silakan masuk untuk mengelola data kehadiran & sistem acara.
            </p>
        </div>

        <!-- Alert Notifikasi Flash -->
        @if(session('success'))
            <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-center gap-2.5 shadow-xs">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs space-y-1 shadow-xs">
                @foreach($errors->all() as $error)
                    <p class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $error }}</span>
                    </p>
                @endforeach
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email Input -->
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-bold text-slate-700 tracking-wide">
                    Alamat Email
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        placeholder="nama@email.com"
                        class="input-3d w-full pl-10 pr-3.5 py-2.5 bg-slate-50/50 hover:bg-white focus:bg-white border {{ $errors->has('email') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300 focus:border-slate-900' }} rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none transition-all"
                    >
                </div>
            </div>

            <!-- Password Input -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-xs font-bold text-slate-700 tracking-wide">
                        Kata Sandi
                    </label>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required 
                        placeholder="Masukkan kata sandi"
                        class="input-3d w-full pl-10 pr-10 py-2.5 bg-slate-50/50 hover:bg-white focus:bg-white border {{ $errors->has('password') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300 focus:border-slate-900' }} rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none transition-all"
                    >
                    <button 
                        type="button" 
                        id="togglePassword" 
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 transition-colors cursor-pointer"
                        title="Tampilkan / Sembunyikan Kata Sandi"
                    >
                        <!-- Eye Icon (Show) -->
                        <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <!-- Eye Slash Icon (Hide) -->
                        <svg id="eyeSlashIcon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2.5 cursor-pointer text-slate-600 select-none font-medium">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded text-slate-900 focus:ring-slate-900 border-slate-300 cursor-pointer">
                    <span>Ingat sesi masuk</span>
                </label>
            </div>

            <!-- Tombol Submit 3D Tactile (Sama dengan Beranda) -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    class="btn-3d-dark w-full py-3 px-4 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm tracking-wide rounded-xl cursor-pointer flex items-center justify-center gap-2.5 border border-slate-900"
                >
                    <span>Masuk ke Dashboard</span>
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </form>

    </div>

    <!-- Tombol Kembali ke Halaman Depan dengan Desain Pill Halus -->
    <div class="text-center mt-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold text-slate-500 hover:text-slate-900 hover:bg-white hover:shadow-xs transition-all">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Halaman Pendaftaran</span>
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');

        if (toggleBtn && passwordInput && eyeIcon && eyeSlashIcon) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                eyeIcon.classList.toggle('hidden', isPassword);
                eyeSlashIcon.classList.toggle('hidden', !isPassword);
            });
        }
    });
</script>
@endpush
