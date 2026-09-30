<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak ID Card Lanyard - C LEVEL 2026</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --ease-expo: cubic-bezier(0.16, 1, 0.3, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }

        /* 3D Depth Card */
        .card-3d {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 
                0 1px 3px rgba(15, 23, 42, 0.03),
                0 8px 20px -4px rgba(15, 23, 42, 0.06),
                0 20px 40px -10px rgba(15, 23, 42, 0.08);
            border-radius: 1.25rem;
        }

        /* Tactile Push Buttons */
        .btn-3d-dark {
            box-shadow: 0 3px 0 #020617, 0 8px 16px -3px rgba(15, 23, 42, 0.3);
            transition: all 0.15s var(--ease-expo);
        }
        .btn-3d-dark:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #020617, 0 12px 22px -3px rgba(15, 23, 42, 0.35);
        }
        .btn-3d-dark:active {
            transform: translateY(2px);
            box-shadow: 0 1px 0 #020617, 0 4px 8px -2px rgba(15, 23, 42, 0.25);
        }

        .btn-3d-white {
            box-shadow: 0 2px 0 #cbd5e1, 0 4px 10px -2px rgba(15, 23, 42, 0.06);
            transition: all 0.15s var(--ease-expo);
        }
        .btn-3d-white:hover {
            transform: translateY(-1.5px);
            box-shadow: 0 4px 0 #cbd5e1, 0 8px 16px -3px rgba(15, 23, 42, 0.1);
        }
        .btn-3d-white:active {
            transform: translateY(1.5px);
            box-shadow: 0 1px 0 #cbd5e1, 0 2px 5px -1px rgba(15, 23, 42, 0.05);
        }

        /* Ukuran standar ID Card Lanyard Plastik B3/B4 (95mm x 135mm) */
        .id-card-box {
            width: 95mm;
            height: 135mm;
            page-break-inside: avoid;
            box-sizing: border-box;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 4px 12px -2px rgba(15, 23, 42, 0.06);
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 8mm;
            }
            body {
                background: transparent !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
            .print-container {
                display: flex !important;
                flex-wrap: wrap !important;
                gap: 5mm !important;
                justify-content: flex-start !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: none !important;
            }
            .id-card-box {
                box-shadow: none !important;
                border: 1px dashed #94a3b8 !important; /* Garis panduan potong gunting */
                border-radius: 0 !important;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-8">

    <!-- Top Action Toolbar (No-Print: Bersih, Konsisten dengan Scanner) -->
    <div class="no-print card-3d max-w-5xl mx-auto mb-8 p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Format Cetak ID Card Peserta</h1>
            <p class="text-xs text-slate-500 mt-0.5">Total: <strong>{{ count($participants) }} ID Card</strong>. Ukuran standar lanyard B3/B4 (95mm × 135mm).</p>
        </div>

        <div class="flex items-center gap-2.5">
            <!-- Tombol Kembali ke Dashboard (Text Only) -->
            <a href="{{ route('admin.dashboard') }}" class="btn-3d-white px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition-all">
                Dashboard
            </a>

            <!-- Tombol Cetak Semua ID Card (Text Only) -->
            <button 
                type="button" 
                onclick="window.print()" 
                class="btn-3d-dark px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl border border-slate-900 transition-all cursor-pointer"
            >
                Cetak Semua ID Card
            </button>
        </div>
    </div>

    <!-- Grid Container Kartu -->
    <div class="print-container max-w-5xl mx-auto flex flex-wrap justify-center gap-6">

        @forelse($participants as $p)
        <!-- Single ID Card Item -->
        <div class="id-card-box flex flex-col justify-between overflow-hidden relative text-slate-900">
            
            <!-- Lubang Tali Lanyard Guide -->
            <div class="w-full pt-3 pb-1 flex flex-col items-center justify-center">
                <div class="w-10 h-2 border border-slate-300 rounded-full bg-slate-100 flex items-center justify-center">
                    <span class="w-3 h-0.5 bg-slate-300 rounded-full"></span>
                </div>
            </div>

            <!-- Header Organisasi -->
            <div class="px-5 pt-2 pb-2.5 text-center">
                <span class="text-[9px] font-black tracking-widest text-slate-400 uppercase block">C LEVEL EXECUTIVE INDONESIA</span>
                <h2 class="text-sm font-black tracking-tight text-slate-900 uppercase mt-0.5">C LEVEL INDONESIA 2026</h2>
            </div>

            <!-- Pita Kategori Peserta (Solid Royal Blue C LEVEL) -->
            <div class="bg-blue-600 text-white text-center py-1.5 px-4 font-black text-xs tracking-wider uppercase">
                {{ !empty($p->position) && str_contains(strtolower($p->position), 'ketua') ? 'TAMU KEHORMATAN' : 'PESERTA' }}
            </div>

            <!-- Konten Utama: Nama, Instansi, Jabatan (Proporsional & Seimbang) -->
            <div class="px-6 py-6 text-center flex-grow flex flex-col justify-center items-center">
                
                <!-- Nama Peserta -->
                <h3 class="text-xl sm:text-2xl font-black text-slate-950 uppercase tracking-tight leading-snug max-w-full break-words">
                    {{ $p->name }}
                </h3>

                <!-- Garis Pemisah Elegan -->
                <div class="w-10 h-0.5 bg-blue-600 my-3.5 rounded-full"></div>

                <!-- Instansi / Perusahaan (Badge Bersih) -->
                <div class="inline-block px-3.5 py-1 bg-slate-100 border border-slate-200/80 rounded-lg text-xs font-bold text-slate-900 uppercase tracking-wider max-w-full truncate">
                    {{ $p->company ?: 'C LEVEL Indonesia' }}
                </div>

                <!-- Jabatan -->
                @if($p->position && $p->position !== '-')
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide mt-2">
                    {{ $p->position }}
                </p>
                @endif

            </div>

            <!-- Footer ID Card Formal Solid Slate-900 -->
            <div class="bg-slate-900 text-white px-4 py-2.5 text-center border-t border-slate-800">
                <p class="text-[9px] font-bold text-slate-200 uppercase tracking-wider leading-tight">
                    {{ $eventSettings['nama_acara'] ?? 'Musyawarah & Temu Bisnis C LEVEL Indonesia 2026' }}
                </p>
                <p class="text-[8px] text-slate-400 mt-0.5 font-medium">
                    {{ $eventSettings['tanggal'] ?? '28 Oktober 2026' }} &bull; {{ $eventSettings['venue'] ?? 'Grand Ballroom C LEVEL Indonesia' }}
                </p>
            </div>

        </div>
        @empty
        <div class="w-full text-center py-16 text-slate-500 card-3d p-8">
            Tidak ada data peserta untuk dicetak.
        </div>
        @endforelse

    </div>

</body>
</html>
