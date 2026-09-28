<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak ID Card Lanyard - KADIN 2026</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
        }

        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Ukuran standar ID Card Lanyard Plastik B3/B4 (95mm x 135mm) */
        .id-card-box {
            width: 95mm;
            height: 135mm;
            page-break-inside: avoid;
            box-sizing: border-box;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 8mm;
            }
            body {
                background: transparent !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-container {
                display: flex !important;
                flex-wrap: wrap !important;
                gap: 6mm !important;
                justify-content: flex-start !important;
            }
            .id-card-box {
                box-shadow: none !important;
                border: 1px dashed #94a3b8 !important; /* Garis panduan potong */
            }
        }
    </style>
</head>
<body class="p-4 sm:p-8">

    <!-- Top Action Toolbar (Hilang saat cetak) -->
    <div class="no-print max-w-5xl mx-auto mb-6 bg-white border border-slate-200 rounded-sm p-4 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-blue-50 border border-blue-200 rounded-sm mb-1 text-[11px] font-bold uppercase tracking-wider text-blue-800">
                Lanyard ID Card / Name Tag
            </div>
            <h1 class="text-lg font-bold text-slate-900">Format Cetak ID Card Peserta</h1>
            <p class="text-xs text-slate-500">Total: <strong>{{ count($participants) }} ID Card</strong>. Format bersih & formal (Nama, Instansi, Jabatan).</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded-sm border border-slate-300 transition-colors">
                ← Kembali ke Dashboard
            </a>
            <button 
                type="button" 
                onclick="window.print()" 
                class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-sm transition-colors flex items-center gap-2 shadow-sm cursor-pointer"
            >
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak Semua ID Card (Print / PDF)</span>
            </button>
        </div>
    </div>

    <!-- Grid Container Kartu -->
    <div class="print-container max-w-5xl mx-auto flex flex-wrap justify-center gap-6">

        @forelse($participants as $p)
        <!-- Single ID Card Item (Fokus: Nama, Instansi, Jabatan) -->
        <div class="id-card-box bg-white border border-slate-300 rounded-sm shadow-sm flex flex-col justify-between overflow-hidden relative text-slate-900">
            
            <!-- Lubang Tali Lanyard Guide (Garis panduan potong) -->
            <div class="w-full pt-3 flex flex-col items-center justify-center">
                <div class="w-10 h-2.5 border border-slate-300 rounded-full bg-slate-100 flex items-center justify-center">
                    <span class="w-3 h-1 bg-slate-300 rounded-full"></span>
                </div>
            </div>

            <!-- Header Organisasi -->
            <div class="px-4 pt-3 pb-2 text-center border-b border-slate-100">
                <p class="text-[9px] font-extrabold uppercase tracking-widest text-slate-600">KAMAR DAGANG DAN INDUSTRI INDONESIA</p>
                <h2 class="text-sm font-black tracking-tight text-slate-950 uppercase mt-0.5">KADIN INDONESIA 2026</h2>
            </div>

            <!-- Pita Kategori Peserta (Warna Solid Flat) -->
            <div class="bg-blue-900 text-white text-center py-1.5 px-2">
                <span class="text-[11px] font-black tracking-wider uppercase">
                    {{ !empty($p->position) && str_contains(strtolower($p->position), 'ketua') ? 'TAMU KEHORMATAN' : 'PESERTA' }}
                </span>
            </div>

            <!-- Konten Utama: Nama, Instansi, Jabatan (Besar & Jelas Terbaca) -->
            <div class="px-5 py-6 text-center flex-grow flex flex-col justify-center items-center">
                
                <!-- Nama Peserta -->
                <h3 class="text-xl sm:text-2xl font-black text-slate-950 uppercase leading-snug tracking-tight">
                    {{ $p->name }}
                </h3>

                <!-- Garis Pemisah Elegan -->
                <div class="w-12 h-1 bg-blue-900 my-3 rounded-none"></div>

                <!-- Instansi / Perusahaan -->
                <p class="text-sm font-bold text-slate-900 uppercase tracking-wide">
                    {{ $p->company ?: 'KADIN Indonesia' }}
                </p>

                <!-- Jabatan -->
                @if($p->position)
                <p class="text-xs font-semibold text-slate-600 mt-1">
                    {{ $p->position }}
                </p>
                @endif

            </div>

            <!-- Footer ID Card Formal (Tanpa Icon) -->
            <div class="bg-slate-900 text-white px-4 py-2.5 text-center">
                <p class="text-[9px] font-bold text-slate-200 uppercase tracking-wider">
                    {{ $eventSettings['nama_acara'] ?? 'Musyawarah & Temu Bisnis KADIN Indonesia 2026' }}
                </p>
                <p class="text-[8px] text-slate-400 mt-0.5">
                    {{ $eventSettings['tanggal'] ?? '28 Oktober 2026' }} &bull; {{ $eventSettings['venue'] ?? 'Menara Kadin Indonesia' }}
                </p>
            </div>

        </div>
        @empty
        <div class="w-full text-center py-12 text-slate-500 bg-white border border-slate-200 rounded-sm p-6">
            Tidak ada data peserta untuk dicetak.
        </div>
        @endforelse

    </div>

</body>
</html>
