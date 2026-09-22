@extends('layouts.app')

@section('title', 'Data Peserta & Blast WhatsApp - Kadin 2026')

@section('content')
<div class="space-y-6">

    <!-- Top Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-block px-2.5 py-0.5 bg-blue-100 text-blue-800 font-bold text-xs uppercase tracking-wider mb-1 rounded-none">
                Panel Panitia
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Data Peserta & Blast WhatsApp</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola pendaftar, blast tiket QR ke nomor WhatsApp peserta, dan pantau status kehadiran.</p>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('participants.create') }}" class="px-4 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs uppercase tracking-wider rounded-none border border-blue-800 transition flex items-center gap-1.5 shadow-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Peserta</span>
            </a>
            <a href="{{ route('participants.scan') }}" class="px-4 py-2.5 bg-slate-900 hover:bg-black text-white font-bold text-xs uppercase tracking-wider rounded-none border border-slate-900 transition flex items-center gap-1.5 shadow-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                <span>Scanner Absensi</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards Solid Flat -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-4 bg-white border border-slate-300 rounded-none">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Terdaftar</span>
            <p class="text-2xl font-black text-slate-900 mt-1">{{ number_format($stats['total']) }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Semua peserta terinput</p>
        </div>

        <div class="p-4 bg-white border border-slate-300 rounded-none">
            <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Sudah Hadir</span>
            <p class="text-2xl font-black text-emerald-800 mt-1">{{ number_format($stats['attended']) }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Telah scan absensi QR</p>
        </div>

        <div class="p-4 bg-white border border-slate-300 rounded-none">
            <span class="text-xs font-bold text-amber-700 uppercase tracking-wider">Belum Hadir</span>
            <p class="text-2xl font-black text-amber-800 mt-1">{{ number_format($stats['registered']) }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Menunggu kedatangan</p>
        </div>
    </div>

    <!-- Filter & Search Toolbar Flat -->
    <div class="bg-white border border-slate-300 rounded-none p-4">
        <form action="{{ route('participants.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
            
            <!-- Search Field (Col 7) -->
            <div class="md:col-span-7">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama, email, no whatsapp, token QR..." 
                    class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 text-xs text-slate-900 rounded-none focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700"
                >
            </div>

            <!-- Status Filter (Col 3) -->
            <div class="md:col-span-3">
                <select 
                    name="status" 
                    class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 text-xs text-slate-800 rounded-none focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700"
                >
                    <option value="">Semua Status Kehadiran</option>
                    <option value="registered" {{ request('status') === 'registered' ? 'selected' : '' }}>Belum Hadir (Registered)</option>
                    <option value="attended" {{ request('status') === 'attended' ? 'selected' : '' }}>Sudah Hadir (Attended)</option>
                </select>
            </div>

            <!-- Submit Button (Col 2) -->
            <div class="md:col-span-2 flex items-center space-x-2">
                <button 
                    type="submit" 
                    class="w-full py-2 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs uppercase tracking-wider rounded-none border border-slate-900 transition"
                >
                    Filter
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('participants.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-none border border-slate-300" title="Reset filter">
                        ✕
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Data Table Flat Solid -->
    <div class="bg-white border border-slate-300 rounded-none overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-900 text-white uppercase text-[11px] tracking-wider border-b border-slate-900">
                    <tr>
                        <th class="py-3 px-3 w-12 text-center">No</th>
                        <th class="py-3 px-4">Nama Peserta</th>
                        <th class="py-3 px-4">Kontak WhatsApp</th>
                        <th class="py-3 px-4">Instansi / Perusahaan</th>
                        <th class="py-3 px-4">Token QR</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi / Blast WA</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-800">
                    @forelse($participants as $index => $item)
                    <tr class="hover:bg-slate-50 transition">
                        <!-- No -->
                        <td class="py-3 px-3 text-center text-slate-400 font-mono">
                            {{ $participants->firstItem() + $index }}
                        </td>

                        <!-- Nama & Email -->
                        <td class="py-3 px-4">
                            <span class="font-bold text-slate-900 block">{{ $item->name }}</span>
                            <span class="text-[11px] text-slate-500 font-mono">{{ $item->email }}</span>
                        </td>

                        <!-- WhatsApp -->
                        <td class="py-3 px-4 font-mono font-bold text-slate-800">
                            {{ $item->phone_number }}
                        </td>

                        <!-- Instansi -->
                        <td class="py-3 px-4 text-slate-700">
                            {{ $item->institution ?? '-' }}
                        </td>

                        <!-- Token QR -->
                        <td class="py-3 px-4 font-mono font-bold text-blue-700">
                            {{ $item->qr_token }}
                        </td>

                        <!-- Status -->
                        <td class="py-3 px-4">
                            @if($item->status === 'attended')
                                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 border border-emerald-300 text-[10px] font-bold uppercase rounded-none inline-block">
                                    Hadir {{ $item->attended_at ? $item->attended_at->format('H:i') : '' }}
                                </span>
                            @else
                                <span class="px-2 py-0.5 bg-amber-100 text-amber-800 border border-amber-300 text-[10px] font-bold uppercase rounded-none inline-block">
                                    Belum Hadir
                                </span>
                            @endif
                        </td>

                        <!-- Aksi Buttons -->
                        <td class="py-3 px-4 text-center">
                            <div class="flex items-center justify-center space-x-1.5">
                                <!-- Blast WhatsApp Button Solid Green -->
                                <a 
                                    href="{{ $item->whatsapp_blast_url }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] uppercase tracking-wider rounded-none border border-emerald-700 transition flex items-center space-x-1"
                                    title="Kirim tiket QR ke WhatsApp peserta ini"
                                >
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.299.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.353.101.173.45 0.742.966 1.202.664.591 1.224.774 1.397.86.173.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086.159.058 1.011.477 1.184.564.173.087.289.13.332.202.043.073.043.419-.101.824z"/>
                                    </svg>
                                    <span>Blast WA</span>
                                </a>

                                <!-- Lihat Tiket -->
                                <a 
                                    href="{{ route('participants.card', $item->qr_token) }}" 
                                    class="px-2.5 py-1.5 bg-blue-700 hover:bg-blue-800 text-white font-bold text-[11px] uppercase tracking-wider rounded-none border border-blue-800 transition"
                                    title="Buka tiket QR"
                                >
                                    Tiket QR
                                </a>

                                <!-- Hapus Button -->
                                <form action="{{ route('participants.destroy', $item) }}" method="POST" onsubmit="return confirmDelete(event, '{{ $item->name }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="px-2 py-1.5 bg-slate-200 hover:bg-rose-600 hover:text-white text-slate-700 font-bold text-[11px] rounded-none border border-slate-300 transition cursor-pointer"
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
                        <td colspan="7" class="py-8 text-center text-slate-400">
                            Belum ada data peserta yang terdaftar. <a href="{{ route('participants.create') }}" class="text-blue-700 font-bold underline">Tambah peserta pertama</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($participants->hasPages())
        <div class="p-4 border-t border-slate-200 bg-slate-50">
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
            text: `Yakin ingin menghapus data "${name}"? Tindakan ini tidak dapat dibatalkan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#475569',
            confirmButtonText: 'Ya, Hapus Data',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-none border-2 border-slate-900',
                confirmButton: 'rounded-none font-bold uppercase text-xs',
                cancelButton: 'rounded-none font-bold uppercase text-xs'
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
