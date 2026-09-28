@extends('layouts.admin')

@section('title', 'Dashboard Pendaftar - Kadin 2026')
@section('page_title', 'Dashboard Pendaftar')

@section('content')

<div class="space-y-6">

    <!-- Top Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-blue-50 border border-blue-200 rounded-sm mb-1 text-[10px] font-bold uppercase tracking-wider text-blue-800">
                Pusat Kontrol & Presensi
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Dashboard Pendaftar</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pantau data peserta, kelola pengiriman WhatsApp, cetak ID card lanyard, dan verifikasi kehadiran.</p>
        </div>

        <div class="flex items-center flex-wrap gap-2">
            <!-- Cetak ID Card Massal -->
            <a href="{{ route('admin.participants.id-cards.bulk', request()->query()) }}" target="_blank" class="px-3 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-900 font-semibold text-xs rounded-sm border border-indigo-200 transition-colors flex items-center gap-1.5 cursor-pointer shadow-2xs">
                <svg class="w-4 h-4 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                </svg>
                <span>Cetak ID Card Massal</span>
            </a>

            <!-- Download CSV -->
            <a href="{{ route('admin.export.csv') }}" class="px-3 py-2 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded-sm border border-slate-300 transition-colors flex items-center gap-1.5 cursor-pointer shadow-2xs">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Export CSV</span>
            </a>

            <!-- Buka Scanner QR -->
            <a href="{{ route('admin.scan') }}" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors flex items-center gap-1.5 shadow-2xs">
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                <span>Buka Scanner QR</span>
            </a>

            <!-- Tambah Peserta Manual -->
            <a href="{{ route('participants.create') }}" target="_blank" class="px-3.5 py-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs rounded-sm transition-colors flex items-center gap-1.5 shadow-2xs">
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
        <div class="p-4 bg-white border border-slate-200 rounded-sm shadow-2xs flex flex-col justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Pendaftar</span>
                <div class="flex items-baseline justify-between mt-1">
                    <span class="text-2xl font-bold text-slate-900">{{ number_format($stats['total']) }}</span>
                    <span class="text-[11px] font-medium text-slate-500">{{ $stats['today_registered'] }} hari ini</span>
                </div>
            </div>
            <div class="mt-3 w-full bg-slate-100 h-1.5 rounded-none">
                <div class="bg-slate-900 h-1.5" style="width: 100%"></div>
            </div>
        </div>

        <!-- Presensi di Lokasi (Sudah Hadir) -->
        <div class="p-4 bg-white border border-slate-200 rounded-sm shadow-2xs flex flex-col justify-between">
            <div>
                <span class="text-xs font-semibold text-emerald-700 uppercase tracking-wider block">Hadir di Lokasi</span>
                <div class="flex items-baseline justify-between mt-1">
                    <span class="text-2xl font-bold text-emerald-700">{{ number_format($stats['attended']) }}</span>
                    <span class="text-[11px] font-medium text-slate-500">{{ $stats['registered'] }} belum hadir</span>
                </div>
            </div>
            <div class="mt-3 w-full bg-slate-100 h-1.5 rounded-none">
                <div class="bg-emerald-600 h-1.5" style="width: {{ $stats['attendance_rate'] }}%"></div>
            </div>
        </div>

        <!-- Status RSVP WhatsApp (Layout 3 Kolom Rapi) -->
        <div class="p-4 bg-white border border-slate-200 rounded-sm shadow-2xs flex flex-col justify-between">
            <div>
                <span class="text-xs font-semibold text-blue-800 uppercase tracking-wider block">Konfirmasi RSVP (WA)</span>
                <div class="grid grid-cols-3 gap-1.5 mt-2 text-center">
                    <div class="bg-emerald-50 border border-emerald-200 px-1 py-1 rounded-xs">
                        <span class="text-xs font-bold text-emerald-800 block">{{ $stats['rsvp_attending'] }}</span>
                        <span class="text-[9px] font-bold text-emerald-700 uppercase block">Hadir</span>
                    </div>
                    <div class="bg-rose-50 border border-rose-200 px-1 py-1 rounded-xs">
                        <span class="text-xs font-bold text-rose-800 block">{{ $stats['rsvp_declined'] }}</span>
                        <span class="text-[9px] font-bold text-rose-700 uppercase block">Batal</span>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 px-1 py-1 rounded-xs">
                        <span class="text-xs font-bold text-slate-700 block">{{ $stats['rsvp_pending'] }}</span>
                        <span class="text-[9px] font-bold text-slate-500 uppercase block">Menunggu</span>
                    </div>
                </div>
            </div>
            <span class="text-[10px] text-slate-400 mt-2 block">Dihimpun dari tombol RSVP WhatsApp</span>
        </div>

        <!-- Persentase Kehadiran -->
        <div class="p-4 bg-white border border-slate-200 rounded-sm shadow-2xs flex flex-col justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Tingkat Kehadiran</span>
                <div class="flex items-baseline justify-between mt-1">
                    <span class="text-2xl font-bold text-slate-900">{{ $stats['attendance_rate'] }}%</span>
                    <span class="text-[11px] font-medium text-slate-500">{{ $stats['attended'] }} / {{ $stats['total'] }}</span>
                </div>
            </div>
            <div class="mt-3 w-full bg-slate-100 h-1.5 rounded-none">
                <div class="bg-blue-600 h-1.5" style="width: {{ $stats['attendance_rate'] }}%"></div>
            </div>
        </div>

    </div>

    <!-- Filter & Search Toolbar Clean Flat -->
    <div class="bg-white border border-slate-200 rounded-sm p-3.5 shadow-2xs">
        <form action="{{ route('admin.dashboard') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            
            <!-- Input Cari -->
            <div class="sm:col-span-4">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama, instansi, WhatsApp, token..." 
                    class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 text-xs text-slate-900 rounded-sm focus:outline-none focus:border-slate-900 focus:bg-white transition-colors"
                >
            </div>

            <!-- Filter Status Presensi -->
            <div class="sm:col-span-3">
                <select 
                    name="status" 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs text-slate-800 rounded-sm focus:outline-none focus:border-slate-900 focus:bg-white transition-colors"
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
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs text-slate-800 rounded-sm focus:outline-none focus:border-slate-900 focus:bg-white transition-colors"
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
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 text-xs text-slate-800 rounded-sm focus:outline-none focus:border-slate-900 focus:bg-white transition-colors"
                >
                    <option value="">Semua Tanggal</option>
                    <option value="today" {{ request('date') === 'today' ? 'selected' : '' }}>Daftar Hari Ini</option>
                </select>
            </div>

            <!-- Submit Button & Reset -->
            <div class="sm:col-span-1 flex items-center space-x-1.5">
                <button 
                    type="submit" 
                    class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors cursor-pointer text-center"
                >
                    Cari
                </button>
                @if(request('search') || request('status') || request('rsvp') || request('date'))
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
                        <th class="py-3 px-3 w-10 text-center text-slate-400">No</th>
                        <th class="py-3 px-4">Nama Lengkap</th>
                        <th class="py-3 px-4">Instansi & Jabatan</th>
                        <th class="py-3 px-4 whitespace-nowrap">WhatsApp</th>
                        <th class="py-3 px-4 whitespace-nowrap">Kode Tiket</th>
                        <th class="py-3 px-4 whitespace-nowrap">Presensi & RSVP</th>
                        <th class="py-3 px-4 text-center whitespace-nowrap">Aksi</th>
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
                            <span class="text-[11px] text-slate-500">{{ $item->position ?: '-' }}</span>
                        </td>

                        <!-- WhatsApp -->
                        <td class="py-3.5 px-4 font-mono font-medium text-slate-800 whitespace-nowrap">
                            {{ $item->phone }}
                        </td>

                        <!-- Kode Tiket QR (Utuh 1 baris tidak terpotong) -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5">
                                <span class="px-2 py-1 bg-slate-100 border border-slate-300 text-slate-900 font-mono font-bold text-xs rounded-sm tracking-wider">
                                    {{ $item->qr_token }}
                                </span>
                                <a 
                                    href="{{ route('participants.card', $item->qr_token) }}" 
                                    target="_blank"
                                    class="text-slate-400 hover:text-blue-600 transition p-1" 
                                    title="Pratinjau E-Ticket"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        </td>

                        <!-- Presensi di Lokasi & Status RSVP (Rapi Terpisah) -->
                        <td class="py-3 px-4 whitespace-nowrap">
                            <div class="space-y-1.5">
                                <!-- Status Kehadiran Fisik -->
                                <div class="flex items-center gap-1.5">
                                    @if($item->status === 'attended')
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-800 border border-emerald-200 text-[10px] font-bold uppercase rounded-xs">
                                            Hadir {{ $item->attended_at ? $item->attended_at->format('H:i') : '' }}
                                        </span>
                                        <form action="{{ route('admin.participants.toggle', $item) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-[10px] text-slate-400 hover:text-rose-600 underline cursor-pointer" title="Batalkan presensi">
                                                (batal)
                                            </button>
                                        </form>
                                    @else
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-bold uppercase rounded-xs">
                                            Belum Hadir
                                        </span>
                                        <form action="{{ route('admin.participants.toggle', $item) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-1.5 py-0.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-[10px] font-bold rounded-xs cursor-pointer transition" title="Tandai Hadir Manual">
                                                + Hadirkan
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <!-- Status Konfirmasi RSVP -->
                                <div>
                                    @if($item->rsvp_status === 'attending')
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-emerald-50 text-[10px] font-bold text-emerald-800 border border-emerald-200 rounded-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            RSVP: Pasti Hadir
                                        </span>
                                    @elseif($item->rsvp_status === 'declined')
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-rose-50 text-[10px] font-bold text-rose-800 border border-rose-200 rounded-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                            RSVP: Berhalangan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-slate-50 text-[10px] font-medium text-slate-500 border border-slate-200 rounded-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            RSVP: Belum Respon
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Aksi Buttons (Rapi & Tambah Tombol ID Card) -->
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center space-x-1">
                                
                                <!-- Cetak ID Card Lanyard -->
                                <a 
                                    href="{{ route('admin.participants.id-card', $item) }}" 
                                    target="_blank"
                                    class="px-2 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-800 font-semibold text-[11px] rounded-sm border border-indigo-200 transition-colors flex items-center gap-1 shadow-2xs"
                                    title="Cetak ID Card Lanyard (Gantungan)"
                                >
                                    <svg class="w-3.5 h-3.5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                    <span>ID Card</span>
                                </a>

                                <!-- Buka Tiket QR -->
                                <a 
                                    href="{{ route('participants.card', $item->qr_token) }}" 
                                    target="_blank"
                                    class="px-2 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold text-[11px] rounded-sm border border-slate-300 transition-colors flex items-center gap-1"
                                    title="Lihat Tiket QR"
                                >
                                    <span>Tiket</span>
                                </a>

                                <!-- Kirim via WhatsApp Web Button -->
                                <a 
                                    href="{{ $item->whatsapp_blast_url }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="px-2 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-[11px] rounded-sm transition-colors flex items-center space-x-1 shadow-2xs"
                                    title="Kirim tiket via WhatsApp Web manual"
                                >
                                    <span>WA Web</span>
                                </a>

                                <!-- Kirim via Twilio API -->
                                <form action="{{ route('admin.participants.twilio', $item) }}" method="POST" class="inline" onsubmit="return confirmTwilio(event, '{{ $item->name }}')">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="px-2 py-1.5 bg-blue-700 hover:bg-blue-800 text-white font-semibold text-[11px] rounded-sm transition-colors flex items-center space-x-1 shadow-2xs cursor-pointer"
                                        title="Kirim WhatsApp otomatis via API Twilio"
                                    >
                                        <span>Twilio</span>
                                    </button>
                                </form>

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
                            Tidak ada data peserta yang cocok dengan filter pencarian.
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

    function confirmTwilio(e, name) {
        e.preventDefault();
        const form = e.target;
        Swal.fire({
            title: 'Kirim via Twilio?',
            text: `Kirim pesan WhatsApp presensi ke "${name}" via API Twilio?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1d4ed8',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Kirim Twilio',
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
