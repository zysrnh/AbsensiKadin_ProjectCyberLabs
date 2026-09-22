@extends('layouts.admin')

@section('title', 'Scanner Presensi QR - Admin Kadin 2026')

@push('styles')
<style>
    #reader video {
        object-fit: cover !important;
        border-radius: 2px !important;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-slate-100 border border-slate-200 rounded-sm mb-1 text-[11px] font-bold uppercase tracking-wider text-slate-700">
                Pos Presensi Masuk
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Scanner Presensi Kehadiran</h1>
            <p class="text-xs text-slate-500 mt-0.5">Arahkan kamera ke tiket QR peserta atau ketikkan kode tiket untuk memverifikasi kehadiran.</p>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-800 font-semibold text-xs rounded-sm border border-slate-300 transition-colors">
                ← Kembali ke Dashboard
            </a>
            <a href="{{ route('participants.create') }}" target="_blank" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors">
                + Tambah Peserta
            </a>
        </div>
    </div>

    <!-- Main Grid: Scanner Left (7 cols), Recent Attendance Right (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Column: Camera Scanner & Manual Input -->
        <div class="lg:col-span-7 space-y-4">
            
            <!-- Camera Scanner Box Clean Flat -->
            <div class="bg-white border border-slate-200 rounded-sm p-4 shadow-xs">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                        <span>Pemindai Kamera</span>
                    </span>
                    <button 
                        type="button" 
                        id="toggleCameraBtn" 
                        class="px-3 py-1 text-xs font-semibold bg-slate-900 hover:bg-slate-800 text-white rounded-sm cursor-pointer transition-colors"
                    >
                        Nyalakan Kamera
                    </button>
                </div>

                <!-- Viewfinder Div -->
                <div id="reader" class="w-full bg-slate-100 min-h-[300px] flex items-center justify-center border border-slate-200 rounded-sm text-slate-500 text-xs">
                    <span>Klik "Nyalakan Kamera" untuk mulai scanning</span>
                </div>

                <p class="mt-2 text-[11px] text-slate-400 text-center">Pastikan QR Code tiket berada tepat di tengah area pemindaian.</p>
            </div>

            <!-- Manual Token Input Box Clean -->
            <div class="bg-white border border-slate-200 rounded-sm p-4 shadow-xs">
                <label for="manualTokenInput" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-2">
                    Input Kode Tiket Manual / Barcode Scanner Fisik
                </label>
                <form id="manualScanForm" class="flex gap-2">
                    <input 
                        type="text" 
                        id="manualTokenInput" 
                        placeholder="Contoh: KD26-A8F9B2C1" 
                        class="flex-grow px-3.5 py-2 bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-slate-900 rounded-sm focus:outline-none focus:border-slate-900 focus:bg-white uppercase"
                    >
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors cursor-pointer"
                    >
                        Verifikasi
                    </button>
                </form>
            </div>

        </div>

        <!-- Right Column: Recent Attendances Log Clean -->
        <div class="lg:col-span-5">
            <div class="bg-white border border-slate-200 rounded-sm overflow-hidden h-full flex flex-col shadow-xs">
                <div class="bg-slate-50 p-3.5 border-b border-slate-200 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-800">Presensi Baru Terverifikasi</span>
                    <span class="text-[10px] text-slate-400 font-mono">Live</span>
                </div>

                <div class="p-3 divide-y divide-slate-100 overflow-y-auto flex-grow max-h-[500px]" id="recentAttendedList">
                    @forelse($recentAttended as $attendee)
                    <div class="py-2.5 flex items-center justify-between text-xs">
                        <div>
                            <span class="font-bold text-slate-900 block">{{ $attendee->name }}</span>
                            <span class="text-[11px] text-slate-500">{{ $attendee->company ?? 'Kadin' }}</span>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-[10px] uppercase rounded-sm block">
                                {{ $attendee->attended_at ? $attendee->attended_at->format('H:i:s') : 'Hadir' }}
                            </span>
                            <span class="text-[10px] font-mono text-slate-400">{{ $attendee->qr_token }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="py-12 text-center text-slate-400 text-xs" id="emptyPlaceholder">
                        Belum ada peserta yang presensi hari ini.
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
            toggleBtn.textContent = 'Matikan Kamera';
            toggleBtn.className = 'px-3 py-1 text-xs font-semibold bg-rose-600 hover:bg-rose-700 text-white rounded-sm cursor-pointer transition-colors';
        }).catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Kamera Gagal',
                text: 'Pastikan browser memiliki izin akses kamera atau gunakan input manual.',
                confirmButtonColor: '#0f172a'
            });
        });
    }

    function stopCamera() {
        if (html5QrCode && isCameraRunning) {
            html5QrCode.stop().then(() => {
                isCameraRunning = false;
                toggleBtn.textContent = 'Nyalakan Kamera';
                toggleBtn.className = 'px-3 py-1 text-xs font-semibold bg-slate-900 hover:bg-slate-800 text-white rounded-sm cursor-pointer transition-colors';
                document.getElementById('reader').innerHTML = '<span>Klik "Nyalakan Kamera" untuk mulai scanning</span>';
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
                    timer: 2500,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-sm border border-slate-200'
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
                        popup: 'rounded-sm border border-slate-200',
                        confirmButton: 'rounded-sm font-semibold text-xs'
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
                        popup: 'rounded-sm border border-slate-200',
                        confirmButton: 'rounded-sm font-semibold text-xs'
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
                confirmButtonColor: '#0f172a'
            });
        })
        .finally(() => {
            setTimeout(() => {
                isProcessing = false;
            }, 2000);
        });
    }

    function addRecentAttendee(p) {
        const placeholder = document.getElementById('emptyPlaceholder');
        if (placeholder) placeholder.remove();

        const row = document.createElement('div');
        row.className = 'py-2.5 flex items-center justify-between text-xs bg-emerald-50/50 p-2.5 border border-emerald-100 rounded-sm mb-2 transition-colors';
        row.innerHTML = `
            <div>
                <span class="font-bold text-slate-900 block">${p.name}</span>
                <span class="text-[11px] text-slate-500">${p.company || 'Kadin'}</span>
            </div>
            <div class="text-right">
                <span class="px-2 py-0.5 bg-emerald-600 text-white font-bold text-[10px] uppercase rounded-sm block">
                    ${p.time}
                </span>
                <span class="text-[10px] font-mono text-slate-400">${p.qr_token}</span>
            </div>
        `;

        recentList.insertBefore(row, recentList.firstChild);
    }
</script>
@endpush
