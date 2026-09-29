@extends('layouts.admin')

@section('title', 'Dashboard Pendaftar - C Level 2026')
@section('page_title', 'Dashboard Pendaftar')

@section('content')

<div class="space-y-6">

    <!-- Top Header & Action Buttons -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 pb-2 border-b border-slate-200/80">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-0.5 bg-blue-50 border border-blue-200/60 rounded-full mb-1.5 text-[10px] font-extrabold uppercase tracking-wider text-blue-700 shadow-2xs">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                <span>Pusat Kontrol & Presensi</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Dashboard Pendaftar</h1>
            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                Pantau data peserta, kelola pengiriman WhatsApp, cetak ID card lanyard, dan verifikasi kehadiran secara real-time.
            </p>
        </div>

        <div class="flex items-center flex-wrap gap-2.5">
            <!-- Cetak ID Card Massal -->
            <a href="{{ route('admin.participants.id-cards.bulk', request()->query()) }}" target="_blank" class="btn-3d-white px-3.5 py-2.5 bg-white hover:bg-slate-50 text-indigo-900 font-bold text-xs rounded-xl border border-indigo-200/80 flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                </svg>
                <span>Cetak ID Card Massal</span>
            </a>

            <!-- Download CSV -->
            <a href="{{ route('admin.export.csv') }}" class="btn-3d-white px-3.5 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Export CSV</span>
            </a>

            <!-- Buka Scanner QR -->
            <a href="{{ route('admin.scan') }}" class="btn-3d-dark px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl flex items-center gap-2 border border-slate-900 cursor-pointer">
                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                <span>Buka Scanner QR</span>
            </a>

            <!-- Tambah Peserta Manual -->
            <a href="{{ route('participants.create') }}" target="_blank" class="btn-3d-blue px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl flex items-center gap-2 border border-blue-600 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>+ Pendaftar Baru</span>
            </a>
        </div>
    </div>

    <!-- 4 Metrik Statistik 3D Elevation Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        
        <!-- 1. Total Pendaftar -->
        <div class="card-3d p-5 flex flex-col justify-between relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Total Pendaftar</span>
                    <div class="flex items-baseline gap-2 mt-1.5">
                        <span class="text-3xl font-black text-slate-900">{{ number_format($stats['total']) }}</span>
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-200/80 rounded-full text-[10px] font-bold">
                            +{{ $stats['today_registered'] }} hari ini
                        </span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: 100%"></div>
                </div>
                <span class="text-[10px] text-slate-400 mt-1.5 block">Basis database pendaftar resmi</span>
            </div>
        </div>

        <!-- 2. Presensi di Lokasi (Sudah Hadir) -->
        <div class="card-3d p-5 flex flex-col justify-between relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider block">Hadir di Lokasi</span>
                    <div class="flex items-baseline gap-2 mt-1.5">
                        <span class="text-3xl font-black text-emerald-600">{{ number_format($stats['attended']) }}</span>
                        <span class="text-xs font-semibold text-slate-400">
                            dari {{ number_format($stats['total']) }}
                        </span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-2 rounded-full transition-all duration-500" style="width: {{ $stats['attendance_rate'] }}%"></div>
                </div>
                <span class="text-[10px] text-slate-500 mt-1.5 block">
                    <strong class="text-slate-700">{{ $stats['registered'] }}</strong> peserta belum hadir
                </span>
            </div>
        </div>

        <!-- 3. Status RSVP WhatsApp (3 Kolom Modern) -->
        <div class="card-3d p-5 flex flex-col justify-between relative overflow-hidden">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-bold text-slate-700 uppercase tracking-wider block">Konfirmasi RSVP</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                </div>
                <div class="grid grid-cols-3 gap-2 text-center mt-1">
                    <div class="bg-emerald-50/70 border border-emerald-200/80 px-1 py-1.5 rounded-xl">
                        <span class="text-sm font-black text-emerald-700 block leading-tight">{{ $stats['rsvp_attending'] }}</span>
                        <span class="text-[9px] font-extrabold text-emerald-600 uppercase block mt-0.5">Hadir</span>
                    </div>
                    <div class="bg-rose-50/70 border border-rose-200/80 px-1 py-1.5 rounded-xl">
                        <span class="text-sm font-black text-rose-700 block leading-tight">{{ $stats['rsvp_declined'] }}</span>
                        <span class="text-[9px] font-extrabold text-rose-600 uppercase block mt-0.5">Batal</span>
                    </div>
                    <div class="bg-slate-100/70 border border-slate-200/80 px-1 py-1.5 rounded-xl">
                        <span class="text-sm font-black text-slate-700 block leading-tight">{{ $stats['rsvp_pending'] }}</span>
                        <span class="text-[9px] font-extrabold text-slate-500 uppercase block mt-0.5">Menunggu</span>
                    </div>
                </div>
            </div>
            <span class="text-[10px] text-slate-400 mt-3 pt-2.5 border-t border-slate-100 block">Dihimpun dari tombol RSVP WhatsApp</span>
        </div>

        <!-- 4. Persentase Kehadiran -->
        <div class="card-3d p-5 flex flex-col justify-between relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Tingkat Kehadiran</span>
                    <div class="flex items-baseline gap-2 mt-1.5">
                        <span class="text-3xl font-black text-slate-900">{{ $stats['attendance_rate'] }}%</span>
                        <span class="text-xs font-semibold text-slate-400">
                            ({{ $stats['attended'] }}/{{ $stats['total'] }})
                        </span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-slate-900 h-2 rounded-full transition-all duration-500" style="width: {{ $stats['attendance_rate'] }}%"></div>
                </div>
                <span class="text-[10px] text-slate-400 mt-1.5 block">Rasio kehadiran terhadap total pendaftar</span>
            </div>
        </div>

    </div>

    <!-- Filter & Search Toolbar Modern 3D -->
    <div class="card-3d p-4">
        <form action="{{ route('admin.dashboard') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            
            <!-- Input Cari -->
            <div class="sm:col-span-4 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama, instansi, WhatsApp, token..." 
                    class="input-3d w-full pl-10 pr-3.5 py-2.5 bg-slate-50/60 hover:bg-white focus:bg-white border border-slate-300 focus:border-slate-900 text-xs text-slate-900 rounded-xl focus:outline-none transition-all"
                >
            </div>

            <!-- Filter Status Presensi -->
            <div class="sm:col-span-3">
                <select 
                    name="status" 
                    class="input-3d w-full px-3 py-2.5 bg-slate-50/60 hover:bg-white focus:bg-white border border-slate-300 focus:border-slate-900 text-xs text-slate-800 rounded-xl focus:outline-none transition-all cursor-pointer"
                >
                    <option value="">Semua Presensi di Lokasi</option>
                    <option value="registered" {{ request('status') === 'registered' ? 'selected' : '' }}>Belum Hadir</option>
                    <option value="attended" {{ request('status') === 'attended' ? 'selected' : '' }}>Sudah Hadir</option>
                </select>
            </div>

            <!-- Filter Status RSVP -->
            <div class="sm:col-span-2">
                <select 
                    name="rsvp" 
                    class="input-3d w-full px-3 py-2.5 bg-slate-50/60 hover:bg-white focus:bg-white border border-slate-300 focus:border-slate-900 text-xs text-slate-800 rounded-xl focus:outline-none transition-all cursor-pointer"
                >
                    <option value="">Semua Status RSVP</option>
                    <option value="attending" {{ request('rsvp') === 'attending' ? 'selected' : '' }}>Pasti Hadir</option>
                    <option value="declined" {{ request('rsvp') === 'declined' ? 'selected' : '' }}>Berhalangan</option>
                    <option value="pending" {{ request('rsvp') === 'pending' ? 'selected' : '' }}>Belum Respon</option>
                </select>
            </div>

            <!-- Filter Tanggal -->
            <div class="sm:col-span-2">
                <select 
                    name="date" 
                    class="input-3d w-full px-3 py-2.5 bg-slate-50/60 hover:bg-white focus:bg-white border border-slate-300 focus:border-slate-900 text-xs text-slate-800 rounded-xl focus:outline-none transition-all cursor-pointer"
                >
                    <option value="">Semua Tanggal</option>
                    <option value="today" {{ request('date') === 'today' ? 'selected' : '' }}>Daftar Hari Ini</option>
                </select>
            </div>

            <!-- Submit Button & Reset -->
            <div class="sm:col-span-1 flex items-center space-x-1.5">
                <button 
                    type="submit" 
                    class="btn-3d-dark w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition-all cursor-pointer text-center border border-slate-900"
                >
                    Cari
                </button>
                @if(request('search') || request('status') || request('rsvp') || request('date'))
                    <a href="{{ route('admin.dashboard') }}" class="btn-3d-white p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-xl border border-slate-200 transition-all flex items-center justify-center shrink-0" title="Reset filter">
                        ✕
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Data Table Pendaftar Smooth & Polished -->
    <div class="card-3d">
        <div class="overflow-x-auto min-h-[360px] pb-28">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-50/90 text-slate-600 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center text-slate-400">No</th>
                        <th class="py-3.5 px-5">Nama Lengkap</th>
                        <th class="py-3.5 px-5">Instansi & Jabatan</th>
                        <th class="py-3.5 px-5 whitespace-nowrap">WhatsApp</th>
                        <th class="py-3.5 px-5 whitespace-nowrap">Presensi & RSVP</th>
                        <th class="py-3.5 px-5 text-center whitespace-nowrap w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-800">
                    @forelse($participants as $index => $item)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <!-- No -->
                        <td class="py-4 px-4 text-center text-slate-400 font-mono text-xs font-bold">
                            {{ $participants->firstItem() + $index }}
                        </td>

                        <!-- Nama & Email + Kode Tiket Chip -->
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                    {{ strtoupper(substr($item->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <span class="font-bold text-slate-900 block leading-tight text-xs hover:text-blue-600 transition-colors">
                                        {{ $item->name }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <!-- Instansi & Jabatan -->
                        <td class="py-4 px-5">
                            <span class="font-bold text-slate-900 block text-xs">{{ $item->company }}</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">{{ $item->position ?: '-' }}</span>
                        </td>

                        <!-- WhatsApp -->
                        <td class="py-4 px-5 font-mono font-bold text-slate-800 whitespace-nowrap">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->phone) }}" target="_blank" class="hover:text-emerald-600 transition-colors inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span>{{ $item->phone }}</span>
                            </a>
                        </td>

                        <!-- Presensi di Lokasi & Status RSVP (Dot Minimalis & Bersih) -->
                        <td class="py-3.5 px-5 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <!-- Status Kehadiran Fisik -->
                                <div>
                                    @if($item->status === 'attended')
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/80 rounded-full text-[11px] font-bold shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            <span>Hadir ({{ $item->attended_at ? $item->attended_at->format('d M, H:i') : '' }})</span>
                                        </div>
                                    @else
                                        <form action="{{ route('admin.participants.toggle', $item) }}" method="POST" class="inline">
                                            @csrf
                                            <button 
                                                type="submit" 
                                                class="w-3.5 h-3.5 rounded-full bg-blue-500 hover:bg-blue-600 hover:scale-125 transition-transform cursor-pointer inline-flex items-center justify-center ring-4 ring-blue-100" 
                                                title="Belum Hadir • Klik untuk Tandai Hadir"
                                            ></button>
                                        </form>
                                    @endif
                                </div>

                                <!-- Status RSVP Minimalis (Dot Tanpa Teks) -->
                                <div>
                                    @if($item->rsvp_status === 'attending')
                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block ring-2 ring-emerald-100" title="RSVP: Pasti Hadir"></span>
                                    @elseif($item->rsvp_status === 'declined')
                                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500 inline-block ring-2 ring-rose-100" title="RSVP: Batal Hadir"></span>
                                    @else
                                        <span class="w-2.5 h-2.5 rounded-full bg-slate-300 inline-block ring-2 ring-slate-100" title="RSVP: Menunggu Respon"></span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Aksi Dropdown Menu Rapi Tepat di Bawah Tombol -->
                        <td class="py-3.5 px-5 text-center whitespace-nowrap">
                            <div class="relative inline-block text-left">
                                <button 
                                    type="button" 
                                    onclick="toggleRowDropdown(event, 'action-dropdown-{{ $item->id }}')" 
                                    class="btn-3d-white px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-800 font-bold text-xs rounded-xl border border-slate-200 flex items-center gap-1.5 cursor-pointer shadow-xs"
                                    title="Pilihan Aksi"
                                >
                                    <span>Aksi</span>
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <!-- Dropdown Card Tepat di Bawah Tombol Aksi -->
                                <div 
                                    id="action-dropdown-{{ $item->id }}" 
                                    class="row-dropdown-menu hidden absolute right-0 top-full mt-1.5 w-52 bg-white border border-slate-200 rounded-xl shadow-xl z-50 py-1 text-xs text-slate-700 divide-y divide-slate-100 text-left"
                                >
                                    <!-- Aksi Presensi Langsung di Dropdown -->
                                    <div class="py-1">
                                        @if($item->status === 'attended')
                                            <form action="{{ route('admin.participants.toggle', $item) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full text-left flex items-center gap-2 px-3 py-1.5 hover:bg-rose-50 hover:text-rose-900 text-rose-600 transition-colors font-medium cursor-pointer">
                                                    <svg class="w-3.5 h-3.5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    <span>Batalkan Hadir</span>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.participants.toggle', $item) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full text-left flex items-center gap-2 px-3 py-1.5 hover:bg-blue-50 hover:text-blue-900 text-blue-600 transition-colors font-medium cursor-pointer">
                                                    <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    <span>Tandai Hadir</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <!-- ID Card & Tiket -->
                                    <div class="py-1">
                                        <a href="{{ route('admin.participants.id-card', $item) }}" target="_blank" class="flex items-center gap-2 px-3 py-1.5 hover:bg-indigo-50 hover:text-indigo-900 transition-colors font-medium">
                                            <svg class="w-3.5 h-3.5 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                            </svg>
                                            <span>Cetak ID Card</span>
                                        </a>
                                        <a href="{{ route('participants.card', $item->qr_token) }}" target="_blank" class="flex items-center gap-2 px-3 py-1.5 hover:bg-slate-50 hover:text-slate-900 transition-colors font-medium">
                                            <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <span>Lihat Tiket QR</span>
                                        </a>
                                    </div>

                                    <!-- WhatsApp Blast & Web -->
                                    <div class="py-1">
                                        <form action="{{ route('admin.participants.twilio', $item) }}" method="POST" onsubmit="return confirmTwilio(event, '{{ $item->name }}')">
                                            @csrf
                                            <button type="submit" class="w-full text-left flex items-center gap-2 px-3 py-1.5 hover:bg-blue-50 hover:text-blue-900 transition-colors font-medium cursor-pointer">
                                                <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                </svg>
                                                <span>Kirim WA Blast</span>
                                            </button>
                                        </form>
                                        <a href="{{ $item->whatsapp_blast_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-3 py-1.5 hover:bg-emerald-50 hover:text-emerald-900 transition-colors font-medium">
                                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            <span>Kirim WA Web</span>
                                        </a>
                                    </div>

                                    <!-- Hapus Peserta -->
                                    <div class="py-1">
                                        <form action="{{ route('admin.participants.destroy', $item) }}" method="POST" onsubmit="return confirmDelete(event, '{{ $item->name }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-left flex items-center gap-2 px-3 py-1.5 text-rose-600 hover:bg-rose-50 transition-colors font-medium cursor-pointer">
                                                <svg class="w-3.5 h-3.5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                <span>Hapus Peserta</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <span class="text-sm font-medium">Tidak ada data peserta yang cocok dengan filter pencarian.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($participants->hasPages())
        <div class="p-4 border-t border-slate-200/80 bg-slate-50/50">
            {{ $participants->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Handler Dropdown Menu Baris Aksi (Tepat di bawah tombol tombol)
    window.toggleRowDropdown = function(e, id) {
        e.stopPropagation();
        const menu = document.getElementById(id);
        const allMenus = document.querySelectorAll('.row-dropdown-menu');
        
        allMenus.forEach(m => {
            if (m.id !== id) m.classList.add('hidden');
        });

        if (menu) {
            menu.classList.toggle('hidden');
        }
    };

    // Tutup dropdown jika klik di luar
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.row-dropdown-menu') && !e.target.closest('button')) {
            document.querySelectorAll('.row-dropdown-menu').forEach(m => m.classList.add('hidden'));
        }
    });

    function confirmDelete(e, name) {
        e.preventDefault();
        const form = e.target;
        Swal.fire({
            title: 'Hapus Peserta?',
            text: `Yakin ingin menghapus data "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0f172a',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-2xl border border-slate-200 shadow-xl',
                confirmButton: 'rounded-xl font-bold text-xs px-4 py-2',
                cancelButton: 'rounded-xl font-bold text-xs px-4 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
        return false;
    }

    function confirmTwilio(e, name) {
        e.preventDefault();
        const form = e.target;
        Swal.fire({
            title: 'Kirim WA Blast?',
            text: `Kirim pesan WhatsApp presensi otomatis via WA Blast ke "${name}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Kirim WA Blast',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-2xl border border-slate-200 shadow-xl',
                confirmButton: 'rounded-xl font-bold text-xs px-4 py-2',
                cancelButton: 'rounded-xl font-bold text-xs px-4 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
        return false;
    }
</script>
@endpush
