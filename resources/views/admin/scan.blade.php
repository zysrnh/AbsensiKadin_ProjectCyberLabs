@extends('layouts.admin')

@section('title', 'Scanner Presensi QR - Admin C Level 2026')
@section('page_title', 'Scanner Presensi')

@push('styles')
<style>
    #reader {
        border: none !important;
    }
    #reader video {
        object-fit: cover !important;
        border-radius: 0.875rem !important;
    }
    #reader__scan_region {
        background: transparent !important;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">

    <!-- Top Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 border border-blue-200/80 rounded-full mb-1.5 text-[11px] font-bold uppercase tracking-wider text-blue-800">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                <span>Pos Presensi Masuk</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Scanner Presensi Kehadiran</h1>
            <p class="text-xs text-slate-500 mt-0.5">Arahkan kamera ke tiket QR peserta atau ketikkan kode tiket untuk memverifikasi kehadiran.</p>
        </div>

        <div class="flex items-center flex-wrap gap-2">
            <!-- Tombol Buka Layar Sambutan TV -->
            <a href="{{ route('admin.display') }}" target="_blank" class="btn-3d-white px-3.5 py-2 bg-white hover:bg-slate-50 text-indigo-900 font-bold text-xs rounded-xl border border-indigo-200 flex items-center gap-1.5 shadow-2xs transition-all" title="Buka tampilan TV untuk layar panggung / sambutan">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span>Mode Layar TV ↗</span>
            </a>

            <!-- Tombol Kembali ke Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="btn-3d-white px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 flex items-center gap-1.5 shadow-2xs transition-all">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Tambah Peserta Baru -->
            <a href="{{ route('participants.create') }}" target="_blank" class="btn-3d-blue px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl flex items-center gap-1.5 border border-blue-600 shadow-2xs transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Peserta</span>
            </a>
        </div>
    </div>

    <!-- Main Grid: Scanner Left (7 cols), Recent Attendance Right (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Column: Camera Scanner & Manual Input -->
        <div class="lg:col-span-7 space-y-5">
            
            <!-- Camera Scanner Card -->
            <div class="card-3d p-5 space-y-4">
                <div class="flex items-center justify-between pb-3.5 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Pemindai Kamera</h2>
                    </div>
                    <button 
                        type="button" 
                        id="toggleCameraBtn" 
                        class="btn-3d-dark px-3.5 py-1.5 text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white rounded-xl cursor-pointer border border-slate-900 transition-all flex items-center gap-1.5"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span id="toggleCameraText">Nyalakan Kamera</span>
                    </button>
                </div>

                <!-- Viewfinder Div -->
                <div id="reader" class="w-full bg-slate-50 min-h-[320px] flex flex-col items-center justify-center border-2 border-dashed border-slate-200 rounded-2xl text-slate-500 p-4 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 mb-3 shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-slate-700">Kamera Belum Aktif</span>
                    <span class="text-[11px] text-slate-400 mt-0.5">Klik tombol <strong>"Nyalakan Kamera"</strong> di atas untuk memindai QR code tiket.</span>
                </div>

                <div class="flex items-center justify-center gap-2 pt-1 text-[11px] text-slate-400">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Pastikan QR Code tiket berada tepat di tengah area pemindaian.</span>
                </div>
            </div>

            <!-- Manual Token Input Box -->
            <div class="card-3d p-5 space-y-3">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    <label for="manualTokenInput" class="text-xs font-bold uppercase tracking-wider text-slate-800">
                        Input Kode Tiket Manual / Barcode Scanner Fisik
                    </label>
                </div>
                <form id="manualScanForm" class="flex gap-2.5">
                    <input 
                        type="text" 
                        id="manualTokenInput" 
                        placeholder="Contoh: KD26-A8F9B2C1" 
                        class="input-3d flex-grow px-4 py-2.5 bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-slate-900 rounded-xl focus:outline-none focus:border-blue-600 focus:bg-white uppercase tracking-wider transition-all"
                    >
                    <button 
                        type="submit" 
                        class="btn-3d-dark px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl border border-slate-900 transition-all cursor-pointer flex items-center gap-1.5 shrink-0"
                    >
                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Verifikasi</span>
                    </button>
                </form>
                <p class="text-[11px] text-slate-400">Tekan Enter atau klik Verifikasi setelah memasukkan kode tiket.</p>
            </div>

        </div>

        <!-- Right Column: Recent Attendances Log -->
        <div class="lg:col-span-5">
            <div class="card-3d overflow-hidden flex flex-col min-h-[500px]">
                <div class="bg-slate-50/80 p-4 border-b border-slate-200/80 flex items-center justify-between">
                    <div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Presensi Baru Terverifikasi</h2>
                        <span class="text-[11px] text-slate-400">Riwayat presensi peserta hari ini</span>
                    </div>
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/80 font-bold text-[10px] uppercase rounded-full flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Live</span>
                    </span>
                </div>

                <div class="p-4 space-y-2.5 overflow-y-auto flex-grow max-h-[580px]" id="recentAttendedList">
                    @forelse($recentAttended as $attendee)
                    <div class="p-3 bg-white hover:bg-slate-50/80 border border-slate-100 rounded-xl flex items-center justify-between gap-3 transition-colors shadow-2xs">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-full bg-slate-100 text-slate-700 font-bold text-xs flex items-center justify-center shrink-0 border border-slate-200">
                                {{ strtoupper(substr($attendee->name, 0, 1)) }}
                            </div>
                            <div class="truncate">
                                <span class="font-bold text-slate-900 block text-xs truncate">{{ $attendee->name }}</span>
                                <span class="text-[11px] text-slate-500 block truncate">{{ $attendee->company ?? 'C Level' }}</span>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 font-bold text-[10px] uppercase rounded-lg inline-block">
                                {{ $attendee->attended_at ? $attendee->attended_at->timezone('Asia/Jakarta')->format('H:i:s') . ' WIB' : 'Hadir' }}
                            </span>
                            <span class="text-[10px] font-mono text-slate-400 block mt-1 tracking-wider">{{ $attendee->qr_token }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="py-16 text-center text-slate-400 text-xs" id="emptyPlaceholder">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mx-auto mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span>Belum ada peserta yang presensi hari ini.</span>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let html5QrCode = null;
    let isCameraRunning = false;
    let isProcessing = false;

    const toggleBtn = document.getElementById('toggleCameraBtn');
    const toggleText = document.getElementById('toggleCameraText');
    const manualForm = document.getElementById('manualScanForm');
    const manualInput = document.getElementById('manualTokenInput');
    const recentList = document.getElementById('recentAttendedList');

    toggleBtn.addEventListener('click', function() {
        if (isCameraRunning) {
            stopCamera();
        } else {
            startCamera();
        }
    });

    function startCamera() {
        html5QrCode = new Html5Qrcode("reader");
        const config = { fps: 10, qrbox: { width: 250, height: 250 } };

        html5QrCode.start(
            { facingMode: "environment" },
            config,
            onScanSuccess
        ).then(() => {
            isCameraRunning = true;
            toggleText.textContent = 'Matikan Kamera';
            toggleBtn.className = 'btn-3d-dark px-3.5 py-1.5 text-xs font-bold bg-rose-600 hover:bg-rose-700 text-white rounded-xl cursor-pointer border border-rose-600 transition-all flex items-center gap-1.5';
        }).catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Kamera Gagal',
                text: 'Pastikan browser memiliki izin akses kamera atau gunakan input manual.',
                confirmButtonColor: '#0f172a',
                customClass: {
                    popup: 'rounded-2xl border border-slate-200',
                    confirmButton: 'rounded-xl font-bold text-xs px-4 py-2'
                }
            });
        });
    }

    function stopCamera() {
        if (html5QrCode && isCameraRunning) {
            html5QrCode.stop().then(() => {
                isCameraRunning = false;
                toggleText.textContent = 'Nyalakan Kamera';
                toggleBtn.className = 'btn-3d-dark px-3.5 py-1.5 text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white rounded-xl cursor-pointer border border-slate-900 transition-all flex items-center gap-1.5';
                document.getElementById('reader').innerHTML = `
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 mb-3 shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-slate-700">Kamera Belum Aktif</span>
                    <span class="text-[11px] text-slate-400 mt-0.5">Klik tombol <strong>"Nyalakan Kamera"</strong> di atas untuk memindai QR code tiket.</span>
                `;
            });
        }
    }

    function onScanSuccess(decodedText) {
        if (isProcessing) return;
        isProcessing = true;
        processAttendance(decodedText);
    }

    manualForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const token = manualInput.value.trim();
        if (!token) return;
        if (isProcessing) return;
        isProcessing = true;
        processAttendance(token);
    });

    function processAttendance(token) {
        if (navigator.vibrate) navigator.vibrate(100);

        fetch("{{ route('participants.scan.verify') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ qr_token: token })
        })
        .then(res => res.json().then(data => ({ status: res.status, data })))
        .then(({ status, data }) => {
            manualInput.value = '';

            if (status === 200 && data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Presensi Berhasil',
                    html: data.message,
                    timer: 1600,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-2xl border border-slate-200'
                    }
                });
                addRecentAttendee(data.participant);

            } else if (status === 409) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sudah Pernah Hadir',
                    html: data.message,
                    confirmButtonColor: '#0f172a',
                    confirmButtonText: 'Tutup',
                    customClass: {
                        popup: 'rounded-2xl border border-slate-200',
                        confirmButton: 'rounded-xl font-bold text-xs px-4 py-2'
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak Ditemukan',
                    text: data.message || 'QR Code tidak terdaftar.',
                    confirmButtonColor: '#0f172a',
                    confirmButtonText: 'Tutup',
                    customClass: {
                        popup: 'rounded-2xl border border-slate-200',
                        confirmButton: 'rounded-xl font-bold text-xs px-4 py-2'
                    }
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Koneksi Terganggu',
                text: 'Terjadi masalah koneksi.',
                confirmButtonColor: '#0f172a',
                customClass: {
                    popup: 'rounded-2xl border border-slate-200',
                    confirmButton: 'rounded-xl font-bold text-xs px-4 py-2'
                }
            });
        })
        .finally(() => {
            setTimeout(() => {
                isProcessing = false;
            }, 1200);
        });
    }

    function addRecentAttendee(p) {
        const placeholder = document.getElementById('emptyPlaceholder');
        if (placeholder) placeholder.remove();

        const initial = (p.name || 'P').charAt(0).toUpperCase();

        const row = document.createElement('div');
        row.className = 'p-3 bg-emerald-50/70 border border-emerald-200/80 rounded-xl flex items-center justify-between gap-3 transition-all duration-300 shadow-2xs mb-2.5 animate-pulse';
        row.innerHTML = `
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shrink-0 border border-emerald-700 shadow-2xs">
                    ${initial}
                </div>
                <div class="truncate">
                    <span class="font-bold text-slate-900 block text-xs truncate">${p.name}</span>
                    <span class="text-[11px] text-emerald-700 font-semibold block truncate">${p.company || 'C Level'}</span>
                </div>
            </div>
            <div class="text-right shrink-0">
                <span class="px-2.5 py-1 bg-emerald-600 text-white font-bold text-[10px] uppercase rounded-lg inline-block shadow-2xs">
                    ${p.time || 'Hadir'}
                </span>
                <span class="text-[10px] font-mono text-slate-500 block mt-1 tracking-wider">${p.qr_token}</span>
            </div>
        `;

        recentList.insertBefore(row, recentList.firstChild);

        setTimeout(() => {
            row.classList.remove('animate-pulse');
        }, 1500);
    }
</script>
@endpush
