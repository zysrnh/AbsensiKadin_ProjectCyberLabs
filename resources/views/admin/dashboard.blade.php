@extends('layouts.admin')

@section('title', 'Dashboard Pendaftar - Kadin 2026')

@section('content')
<div class="space-y-6">

    <!-- Top Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-slate-100 border border-slate-200 rounded-sm mb-1 text-[11px] font-bold uppercase tracking-wider text-slate-700">
                Pusat Kontrol Presensi
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Dashboard Pendaftar</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pantau data peserta, kelola blast tiket WhatsApp, dan verifikasi kehadiran secara real-time.</p>
        </div>

        <div class="flex items-center flex-wrap gap-2">
            <!-- Download CSV -->
            <a href="{{ route('admin.export.csv') }}" class="px-3 py-2 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded-sm border border-slate-300 transition-colors flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Export CSV</span>
            </a>

            <!-- Buka Scanner QR -->
            <a href="{{ route('admin.scan') }}" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                <span>Buka Scanner QR</span>
            </a>

            <!-- Tambah Peserta Manual -->
            <a href="{{ route('participants.create') }}" target="_blank" class="px-3.5 py-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs rounded-sm transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>+ Pendaftar Baru</span>
            </a>
        </div>
    </div>

    <!-- 4 Metrik Statistik Clean & Flat -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Pendaftar -->
        <div class="p-4 bg-white border border-slate-200 rounded-sm shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Pendaftar</span>
            <div class="flex items-baseline justify-between mt-1">
                <span class="text-2xl font-bold text-slate-900">{{ number_format($stats['total']) }}</span>
                <span class="text-[11px] font-medium text-slate-500">{{ $stats['today_registered'] }} hari ini</span>
            </div>
            <div class="mt-2 w-full bg-slate-100 h-1.5 rounded-none">
                <div class="bg-slate-900 h-1.5" style="width: 100%"></div>
            </div>
        </div>

        <!-- Sudah Hadir -->
        <div class="p-4 bg-white border border-slate-200 rounded-sm shadow-2xs">
            <span class="text-xs font-semibold text-emerald-700 uppercase tracking-wider block">Sudah Hadir</span>
            <div class="flex items-baseline justify-between mt-1">
                <span class="text-2xl font-bold text-emerald-700">{{ number_format($stats['attended']) }}</span>
                <span class="text-[11px] font-medium text-emerald-700">Tervalidasi</span>
            </div>
            <div class="mt-2 w-full bg-slate-100 h-1.5 rounded-none">
                <div class="bg-emerald-600 h-1.5" style="width: {{ $stats['attendance_rate'] }}%"></div>
            </div>
        </div>

        <!-- Belum Hadir -->
        <div class="p-4 bg-white border border-slate-200 rounded-sm shadow-2xs">
            <span class="text-xs font-semibold text-amber-700 uppercase tracking-wider block">Belum Hadir</span>
            <div class="flex items-baseline justify-between mt-1">
                <span class="text-2xl font-bold text-amber-700">{{ number_format($stats['registered']) }}</span>
                <span class="text-[11px] font-medium text-amber-700">Menunggu</span>
            </div>
            <div class="mt-2 w-full bg-slate-100 h-1.5 rounded-none">
                <div class="bg-amber-500 h-1.5" style="width: {{ 100 - $stats['attendance_rate'] }}%"></div>
            </div>
        </div>

        <!-- Persentase Kehadiran -->
        <div class="p-4 bg-white border border-slate-200 rounded-sm shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Tingkat Kehadiran</span>
            <div class="flex items-baseline justify-between mt-1">
                <span class="text-2xl font-bold text-slate-900">{{ $stats['attendance_rate'] }}%</span>
                <span class="text-[11px] font-medium text-slate-500">{{ $stats['attended'] }} / {{ $stats['total'] }}</span>
            </div>
            <div class="mt-2 w-full bg-slate-100 h-1.5 rounded-none">
                <div class="bg-blue-600 h-1.5" style="width: {{ $stats['attendance_rate'] }}%"></div>
            </div>
        </div>

    </div>

    <!-- Filter & Search Toolbar Clean Flat -->
    <div class="bg-white border border-slate-200 rounded-sm p-3.5 shadow-2xs">
        <form action="{{ route('admin.dashboard') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            
            <!-- Input Cari -->
            <div class="sm:col-span-6">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama, instansi, jabatan, nomor WhatsApp, atau kode tiket..." 
                    class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 text-xs text-slate-900 rounded-sm focus:outline-none focus:border-slate-900 focus:bg-white"
                >
            </div>

            <!-- Filter Status -->
            <div class="sm:col-span-3">
                <select 
                    name="status" 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs text-slate-800 rounded-sm focus:outline-none focus:border-slate-900 focus:bg-white"
                >
                    <option value="">Semua Status Presensi</option>
                    <option value="registered" {{ request('status') === 'registered' ? 'selected' : '' }}>Belum Hadir</option>
                    <option value="attended" {{ request('status') === 'attended' ? 'selected' : '' }}>Sudah Hadir</option>
                </select>
            </div>

            <!-- Filter Tanggal -->
            <div class="sm:col-span-2">
                <select 
                    name="date" 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs text-slate-800 rounded-sm focus:outline-none focus:border-slate-900 focus:bg-white"
                >
                    <option value="">Semua Tanggal</option>
                    <option value="today" {{ request('date') === 'today' ? 'selected' : '' }}>Hari Ini</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="sm:col-span-1 flex items-center space-x-1.5">
                <button 
                    type="submit" 
                    class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors cursor-pointer text-center"
                >
                    Cari
                </button>
                @if(request('search') || request('status') || request('date'))
                    <a href="{{ route('admin.dashboard') }}" class="px-2.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-sm border border-slate-200" title="Reset filter">
                        ✕
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Data Table Pendaftar Clean Flat -->
    <div class="bg-white border border-slate-200 rounded-sm overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-50 text-slate-700 uppercase text-[11px] font-semibold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-3 w-12 text-center text-slate-400">No</th>
                        <th class="py-3 px-4">Nama Lengkap</th>
                        <th class="py-3 px-4">Instansi & Jabatan</th>
                        <th class="py-3 px-4">WhatsApp</th>
                        <th class="py-3 px-4">Kode Tiket</th>
                        <th class="py-3 px-4">Status Presensi</th>
                        <th class="py-3 px-4 text-center">Aksi / Blast WA</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-800">
                    @forelse($participants as $index => $item)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <!-- No -->
                        <td class="py-3.5 px-3 text-center text-slate-400 font-mono">
                            {{ $participants->firstItem() + $index }}
                        </td>

                        <!-- Nama & Email -->
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-slate-900 block">{{ $item->name }}</span>
                            @if($item->email)
                                <span class="text-[11px] text-slate-400 font-mono">{{ $item->email }}</span>
                            @else
                                <span class="text-[10px] text-slate-300 italic">tanpa email</span>
                            @endif
                        </td>

                        <!-- Instansi & Jabatan -->
                        <td class="py-3.5 px-4">
                            <span class="font-semibold text-slate-900 block">{{ $item->company }}</span>
                            <span class="text-[11px] text-slate-500">{{ $item->position }}</span>
                        </td>

                        <!-- WhatsApp -->
                        <td class="py-3.5 px-4 font-mono font-medium text-slate-800">
                            {{ $item->phone }}
                        </td>

                        <!-- Kode Tiket QR -->
                        <td class="py-3.5 px-4 font-mono font-bold text-slate-900">
                            <span class="px-2 py-0.5 bg-slate-100 border border-slate-200 text-slate-800 rounded-sm">
                                {{ $item->qr_token }}
                            </span>
                        </td>

                        <!-- Status Presensi & Quick Toggle -->
                        <td class="py-3.5 px-4">
                            @if($item->status === 'attended')
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold uppercase rounded-sm inline-block">
                                        Hadir {{ $item->attended_at ? $item->attended_at->format('H:i') : '' }}
                                    </span>
                                    <form action="{{ route('admin.participants.toggle', $item) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-[10px] text-slate-400 hover:text-slate-700 underline cursor-pointer" title="Batal Hadir">
                                            (batal)
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-bold uppercase rounded-sm inline-block">
                                        Belum Hadir
                                    </span>
                                    <form action="{{ route('admin.participants.toggle', $item) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-[10px] font-semibold text-blue-600 hover:text-blue-800 underline cursor-pointer" title="Tandai Hadir Manual">
                                            Hadirkan
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>

                        <!-- Aksi Buttons -->
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center space-x-1.5">
                                
                                <!-- Blast WhatsApp Button -->
                                <a 
                                    href="{{ $item->whatsapp_blast_url }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-[11px] rounded-sm transition-colors flex items-center space-x-1 shadow-2xs"
                                    title="Kirim tiket QR ke WhatsApp peserta ini"
                                >
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.299.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.353.101.173.45 0.742.966 1.202.664.591 1.224.774 1.397.86.173.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086.159.058 1.011.477 1.184.564.173.087.289.13.332.202.043.073.043.419-.101.824z"/>
                                    </svg>
                                    <span>Blast WA</span>
                                </a>

                                <!-- Buka Tiket QR -->
                                <a 
                                    href="{{ route('participants.card', $item->qr_token) }}" 
                                    target="_blank"
                                    class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-medium text-[11px] rounded-sm border border-slate-300 transition-colors"
                                    title="Lihat Tiket QR"
                                >
                                    Tiket QR
                                </a>

                                <!-- Hapus Button -->
                                <form action="{{ route('admin.participants.destroy', $item) }}" method="POST" onsubmit="return confirmDelete(event, '{{ $item->name }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="px-2 py-1.5 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-400 font-bold text-[11px] rounded-sm border border-slate-200 transition-colors cursor-pointer"
                                        title="Hapus peserta"
                                    >
                                        ✕
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            Tidak ada data peserta yang cocok dengan pencarian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($participants->hasPages())
        <div class="p-3 border-t border-slate-200 bg-slate-50">
            {{ $participants->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
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
                popup: 'rounded-sm border border-slate-200',
                confirmButton: 'rounded-sm font-semibold text-xs',
                cancelButton: 'rounded-sm font-semibold text-xs'
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
