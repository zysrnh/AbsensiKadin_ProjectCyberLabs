@extends('layouts.app')

@section('title', 'Scanner Absensi QR - Kadin 2026')

@push('styles')
<style>
    #reader video {
        object-fit: cover !important;
        border-radius: 0 !important;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-block px-2.5 py-0.5 bg-blue-100 text-blue-800 font-bold text-xs uppercase tracking-wider mb-1 rounded-none">
                Pos Kedatangan / Resepsionis
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Scanner Absensi Kehadiran QR</h1>
            <p class="text-xs text-slate-500 mt-0.5">Arahkan kamera ke tiket QR peserta atau ketikkan kode token untuk memverifikasi kehadiran.</p>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('participants.index') }}" class="px-3.5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold text-xs uppercase tracking-wider rounded-none border border-slate-300 transition">
                Data Peserta
            </a>
            <a href="{{ route('participants.create') }}" class="px-3.5 py-2 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs uppercase tracking-wider rounded-none border border-blue-800 transition">
                + Tambah Peserta
            </a>
        </div>
    </div>

    <!-- Main Grid: Scanner Left (7 cols), Recent Attendance Right (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Column: Camera Scanner & Manual Input -->
        <div class="lg:col-span-7 space-y-4">
            
            <!-- Camera Scanner Box Flat -->
            <div class="bg-white border-2 border-slate-900 rounded-none p-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 bg-emerald-500 animate-pulse"></span>
                        <span>Kamera Scanner Aktif</span>
                    </span>
                    <button 
                        type="button" 
                        id="toggleCameraBtn" 
                        class="px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider bg-slate-800 hover:bg-slate-900 text-white border border-slate-900 cursor-pointer"
                    >
                        Nyalakan Kamera
                    </button>
                </div>

                <!-- Viewfinder Div -->
                <div id="reader" class="w-full bg-slate-900 min-h-[300px] flex items-center justify-center border border-slate-300 text-white text-xs">
                    <span class="text-slate-400">Klik "Nyalakan Kamera" untuk mulai scanning</span>
                </div>

                <div class="mt-3 p-2 bg-slate-50 border border-slate-200 text-[11px] text-slate-500 text-center">
                    Pastikan QR Code tiket peserta berada di dalam kotak bidik scanner kamera.
                </div>
            </div>

            <!-- Manual Token Input Box Flat -->
            <div class="bg-white border border-slate-300 rounded-none p-4">
                <div class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-2">
                    Input Token Manual / Gunakan Barcode Scanner Fisik
                </div>
                <form id="manualScanForm" class="flex gap-2">
                    <input 
                        type="text" 
                        id="manualTokenInput" 
                        placeholder="Contoh: KD26-A8F9B2C1" 
                        class="flex-grow px-3.5 py-2.5 bg-slate-50 border border-slate-300 text-xs font-mono font-bold text-slate-900 rounded-none focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700 uppercase"
                    >
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs uppercase tracking-wider rounded-none border border-blue-800 transition cursor-pointer"
                    >
                        Verifikasi
                    </button>
                </form>
            </div>

        </div>

        <!-- Right Column: Recent Attendances Log -->
        <div class="lg:col-span-5">
            <div class="bg-white border border-slate-300 rounded-none overflow-hidden h-full flex flex-col">
                <div class="bg-slate-900 text-white p-3 border-b border-slate-900 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider">Kehadiran Baru Saja Terverifikasi</span>
                    <span class="text-[10px] text-slate-400 font-mono">Live Monitor</span>
                </div>

                <div class="p-3 divide-y divide-slate-100 overflow-y-auto flex-grow max-h-[500px]" id="recentAttendedList">
                    @forelse($recentAttended as $attendee)
                    <div class="py-2.5 flex items-center justify-between text-xs">
                        <div>
                            <span class="font-bold text-slate-900 block">{{ $attendee->name }}</span>
                            <span class="text-[11px] text-slate-500">{{ $attendee->institution ?? 'Kadin' }}</span>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-[10px] uppercase rounded-none block">
                                {{ $attendee->attended_at ? $attendee->attended_at->format('H:i:s') : 'Hadir' }}
                            </span>
                            <span class="text-[10px] font-mono text-slate-400">{{ $attendee->qr_token }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="py-12 text-center text-slate-400 text-xs" id="emptyPlaceholder">
                        Belum ada peserta yang hadir hari ini.
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

    // Toggle Camera
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
            toggleBtn.className = 'px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider bg-rose-700 hover:bg-rose-800 text-white border border-rose-800 cursor-pointer';
        }).catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Kamera Gagal Dibuka',
                text: 'Pastikan browser memiliki izin akses kamera atau gunakan input token manual.',
                confirmButtonColor: '#0f172a'
            });
        });
    }

    function stopCamera() {
        if (html5QrCode && isCameraRunning) {
            html5QrCode.stop().then(() => {
                isCameraRunning = false;
                toggleBtn.textContent = 'Nyalakan Kamera';
                toggleBtn.className = 'px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider bg-slate-800 hover:bg-slate-900 text-white border border-slate-900 cursor-pointer';
                document.getElementById('reader').innerHTML = '<span class="text-slate-400">Klik "Nyalakan Kamera" untuk mulai scanning</span>';
            });
        }
    }

    // When QR successfully scanned by Camera
    function onScanSuccess(decodedText) {
        if (isProcessing) return;
        isProcessing = true;
        processAttendance(decodedText);
    }

    // Manual input submit
    manualForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const token = manualInput.value.trim();
        if (!token) return;
        if (isProcessing) return;
        isProcessing = true;
        processAttendance(token);
    });

    // Send Verification Request to Server
    function processAttendance(token) {
        // Play subtle beep sound or vibration
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
                // Success
                Swal.fire({
                    icon: 'success',
                    title: 'Absensi Berhasil!',
                    html: data.message,
                    timer: 2500,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-none border-2 border-slate-900'
                    }
                });

                // Add to recent attendances list UI
                addRecentAttendee(data.participant);

            } else if (status === 409) {
                // Already attended
                Swal.fire({
                    icon: 'warning',
                    title: 'Sudah Pernah Absen',
                    html: data.message,
                    confirmButtonColor: '#0f172a',
                    confirmButtonText: 'Tutup',
                    customClass: {
                        popup: 'rounded-none border-2 border-slate-900',
                        confirmButton: 'rounded-none font-bold uppercase text-xs'
                    }
                });
            } else {
                // Not found or error
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak Ditemukan',
                    text: data.message || 'QR Code tidak terdaftar.',
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'Tutup',
                    customClass: {
                        popup: 'rounded-none border-2 border-slate-900',
                        confirmButton: 'rounded-none font-bold uppercase text-xs'
                    }
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error Koneksi',
                text: 'Terjadi masalah koneksi ke server.',
                confirmButtonColor: '#0f172a'
            });
        })
        .finally(() => {
            // Resume scanning after 2 seconds
            setTimeout(() => {
                isProcessing = false;
            }, 2000);
        });
    }

    function addRecentAttendee(p) {
        const placeholder = document.getElementById('emptyPlaceholder');
        if (placeholder) placeholder.remove();

        const row = document.createElement('div');
        row.className = 'py-2.5 flex items-center justify-between text-xs bg-emerald-50/70 p-2 border border-emerald-200 mb-2 transition';
        row.innerHTML = `
            <div>
                <span class="font-bold text-slate-900 block">${p.name}</span>
                <span class="text-[11px] text-slate-500">${p.institution || 'Kadin'}</span>
            </div>
            <div class="text-right">
                <span class="px-2 py-0.5 bg-emerald-600 text-white font-bold text-[10px] uppercase rounded-none block">
                    ${p.time}
                </span>
                <span class="text-[10px] font-mono text-slate-400">${p.qr_token}</span>
            </div>
        `;

        recentList.insertBefore(row, recentList.firstChild);
    }
</script>
@endpush
