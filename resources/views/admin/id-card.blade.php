<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cetak ID Card Lanyard - Wonderful 2026</title>
    
    <!-- Google Fonts: Koleksi Lengkap Font ID Card & Event -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Cinzel:wght@500;600;700;800;900&family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;700;900&family=Inter:wght@400;500;600;700;800;900&family=Kanit:wght@400;500;600;700;800;900&family=Manrope:wght@400;500;600;700;800&family=Merriweather:wght@400;700;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@400;600;700;800;900&family=Oswald:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&family=Playfair+Display:wght@400;600;700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&family=Raleway:wght@400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&family=Space+Grotesk:wght@400;500;600;700&family=Space+Mono:wght@400;700&family=Syne:wght@500;600;700;800&family=Urbanist:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert2 for Toast & Confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Cropper.js for Precise Image Cropping -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <style>
        :root {
            --ease-expo: cubic-bezier(0.16, 1, 0.3, 1);

            --id-card-bg-color: {{ $idCardConfig['bg_color'] ?? '#ffffff' }};
            --id-card-bg-image: {{ !empty($idCardConfig['background_image']) ? 'url("' . $idCardConfig['background_image'] . '")' : 'none' }};
            --id-card-bg-opacity: {{ isset($idCardConfig['bg_opacity']) ? ($idCardConfig['bg_opacity'] / 100) : '1' }};
            --id-card-bg-size: {{ $idCardConfig['bg_size'] ?? 'cover' }};
            --id-card-bg-position: {{ $idCardConfig['bg_position'] ?? 'center' }};

            --id-card-font-family: '{{ $idCardConfig['font_family'] ?? 'Plus Jakarta Sans' }}', sans-serif;

            --id-header-title-color: {{ $idCardConfig['header_title_color'] ?? '#0f172a' }};
            --id-header-sub-color: {{ $idCardConfig['header_sub_color'] ?? '#94a3b8' }};
            --id-lanyard-hole-bg: {{ $idCardConfig['lanyard_hole_bg'] ?? '#f1f5f9' }};
            --id-lanyard-hole-border: {{ $idCardConfig['lanyard_hole_border'] ?? '#cbd5e1' }};

            --id-name-size: {{ $idCardConfig['name_size'] ?? '22' }}px;
            --id-name-color: {{ $idCardConfig['name_color'] ?? '#020617' }};
            --id-name-weight: {{ $idCardConfig['name_weight'] ?? '900' }};
            --id-name-transform: {{ $idCardConfig['name_transform'] ?? 'uppercase' }};
            --id-name-margin-top: {{ $idCardConfig['name_margin_top'] ?? '0' }}px;

            --id-company-size: {{ $idCardConfig['company_size'] ?? '11' }}px;
            --id-company-color: {{ $idCardConfig['company_color'] ?? '#0f172a' }};
            --id-company-display: {{ (isset($idCardConfig['show_company']) && !$idCardConfig['show_company']) ? 'none' : 'inline-block' }};
            --id-company-style: {{ $idCardConfig['company_style'] ?? 'badge' }};
            --id-company-bg: {{ $idCardConfig['company_bg'] ?? '#f1f5f9' }};

            --id-position-size: {{ $idCardConfig['position_size'] ?? '11' }}px;
            --id-position-color: {{ $idCardConfig['position_color'] ?? '#64748b' }};
            --id-position-display: {{ (isset($idCardConfig['show_position']) && !$idCardConfig['show_position']) ? 'none' : 'block' }};

            --id-ribbon-bg: {{ $idCardConfig['ribbon_bg'] ?? '#2563eb' }};
            --id-ribbon-color: {{ $idCardConfig['ribbon_color'] ?? '#ffffff' }};
            --id-ribbon-display: {{ (isset($idCardConfig['show_ribbon']) && !$idCardConfig['show_ribbon']) ? 'none' : 'block' }};

            --id-header-display: {{ (isset($idCardConfig['show_header']) && !$idCardConfig['show_header']) ? 'none' : 'block' }};
            --id-lanyard-display: {{ (isset($idCardConfig['show_lanyard_hole']) && !$idCardConfig['show_lanyard_hole']) ? 'none' : 'flex' }};
            --id-divider-display: {{ (isset($idCardConfig['show_divider']) && !$idCardConfig['show_divider']) ? 'none' : 'block' }};
            --id-footer-display: {{ (isset($idCardConfig['show_footer']) && !$idCardConfig['show_footer']) ? 'none' : 'block' }};

            --id-content-y-offset: {{ $idCardConfig['content_y_offset'] ?? '0' }}px;
            --id-text-align: {{ $idCardConfig['text_align'] ?? 'center' }};

            --id-text-backdrop: {{ $idCardConfig['text_backdrop'] ?? 'none' }};
            --id-text-shadow: {{ (isset($idCardConfig['text_shadow']) && $idCardConfig['text_shadow']) ? '0 1px 3px rgba(0,0,0,0.45)' : 'none' }};
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        /* Custom Dropdown Stylings (Menghilangkan panah default browser yang kaku) */
        .select-custom {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23475569' stroke-width='2.2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.1rem 1.1rem;
            padding-right: 2.5rem !important;
            cursor: pointer;
        }

        /* Dark Workspace Theme */
        body.dark-workspace {
            background-color: #090d16 !important;
            color: #f8fafc !important;
        }
        body.dark-workspace .card-3d {
            background: #0f172a !important;
            border-color: rgba(51, 65, 85, 0.8) !important;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.5) !important;
        }
        body.dark-workspace .card-3d .border-b {
            border-color: #1e293b !important;
        }
        body.dark-workspace .card-3d .bg-slate-50,
        body.dark-workspace .card-3d .bg-slate-50\/50,
        body.dark-workspace .card-3d .bg-slate-50\/70,
        body.dark-workspace .card-3d .bg-slate-100\/60 {
            background-color: #131c31 !important;
        }
        body.dark-workspace .card-3d .bg-blue-50\/40 {
            background-color: #13233e !important;
            border-color: #1e3a68 !important;
        }
        body.dark-workspace .card-3d h1,
        body.dark-workspace .card-3d h2,
        body.dark-workspace .card-3d h3,
        body.dark-workspace .card-3d label,
        body.dark-workspace .card-3d strong,
        body.dark-workspace .card-3d .text-slate-900,
        body.dark-workspace .card-3d .text-slate-800,
        body.dark-workspace .card-3d .text-slate-700 {
            color: #f1f5f9 !important;
        }
        body.dark-workspace .card-3d p,
        body.dark-workspace .card-3d .text-slate-500,
        body.dark-workspace .card-3d .text-slate-600 {
            color: #94a3b8 !important;
        }
        body.dark-workspace .card-3d .border-slate-200,
        body.dark-workspace .card-3d .border-slate-200\/90,
        body.dark-workspace .card-3d .border-slate-200\/60 {
            border-color: #1e293b !important;
        }
        body.dark-workspace .select-custom {
            background-color: #19243b !important;
            border-color: #334155 !important;
            color: #ffffff !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2.2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 0.75rem center !important;
            background-size: 1.1rem 1.1rem !important;
        }
        body.dark-workspace .card-3d input[type="text"] {
            background-color: #19243b !important;
            border-color: #334155 !important;
            color: #ffffff !important;
            background-image: none !important;
        }
        body.dark-workspace .select-custom option,
        body.dark-workspace .select-custom optgroup {
            background-color: #0f172a !important;
            color: #ffffff !important;
        }
        body.dark-workspace .card-3d input[type="range"] {
            background-color: #334155 !important;
        }
        body.dark-workspace .btn-3d-white {
            background-color: #19243b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
            box-shadow: 0 2px 0 #0b1120, 0 4px 10px -2px rgba(0, 0, 0, 0.3) !important;
        }
        body.dark-workspace .btn-3d-white:hover {
            background-color: #22304d !important;
            border-color: #475569 !important;
            color: #ffffff !important;
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
            transition: transform 0.25s var(--ease-expo), box-shadow 0.25s var(--ease-expo);
        }

        /* Tactile Physical Push Buttons */
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

        .btn-3d-blue {
            box-shadow: 0 3px 0 #1d4ed8, 0 8px 16px -3px rgba(37, 99, 235, 0.35);
            transition: all 0.15s var(--ease-expo);
        }
        .btn-3d-blue:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #1d4ed8, 0 12px 22px -3px rgba(37, 99, 235, 0.4);
        }
        .btn-3d-blue:active {
            transform: translateY(2px);
            box-shadow: 0 1px 0 #1d4ed8, 0 4px 8px -2px rgba(37, 99, 235, 0.25);
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
            box-sizing: border-box;
            background-color: var(--id-card-bg-color);
            border: 1px solid #cbd5e1;
            border-radius: 1rem;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-family: var(--id-card-font-family);
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.12), 0 8px 10px -6px rgba(15, 23, 42, 0.06);
            transition: background-color 0.2s ease, box-shadow 0.2s ease;
        }

        /* Layer Background Image Kustom */
        .id-card-bg-layer {
            position: absolute;
            inset: 0;
            background-image: var(--id-card-bg-image);
            background-size: var(--id-card-bg-size);
            background-position: var(--id-card-bg-position);
            background-repeat: no-repeat;
            opacity: var(--id-card-bg-opacity);
            pointer-events: none;
            z-index: 1;
        }

        /* Layer Konten Teks */
        .id-card-content-layer {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Middle Content Wrapper */
        .id-card-middle-content {
            transform: translateY(var(--id-content-y-offset));
            text-align: var(--id-text-align);
            transition: transform 0.1s ease;
        }

        /* Plat Pelindung Keterbacaan Teks */
        .text-backdrop-plate {
            transition: all 0.15s ease;
        }
        .text-backdrop-plate.plate-none {
            background: transparent;
            padding: 0;
            border-radius: 0;
            box-shadow: none;
            border: none;
        }
        .text-backdrop-plate.plate-frosted-light {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(8px);
            padding: 12px 14px;
            border-radius: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
            width: 100%;
        }
        .text-backdrop-plate.plate-frosted-dark {
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(8px);
            padding: 12px 14px;
            border-radius: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            width: 100%;
        }
        .text-backdrop-plate.plate-frosted-dark .id-card-name {
            color: #ffffff !important;
        }
        .text-backdrop-plate.plate-frosted-dark .id-card-position {
            color: #cbd5e1 !important;
        }

        /* Dynamic styles */
        .id-card-lanyard-hole {
            display: var(--id-lanyard-display) !important;
        }
        .id-card-lanyard-hole-pill {
            background-color: var(--id-lanyard-hole-bg) !important;
            border-color: var(--id-lanyard-hole-border) !important;
        }
        .id-card-header-block {
            display: var(--id-header-display) !important;
        }
        .id-card-header-subtitle {
            color: var(--id-header-sub-color) !important;
        }
        .id-card-header-title {
            color: var(--id-header-title-color) !important;
        }
        .id-card-ribbon {
            display: var(--id-ribbon-display) !important;
            background-color: var(--id-ribbon-bg) !important;
            color: var(--id-ribbon-color) !important;
        }
        .id-card-name {
            font-size: var(--id-name-size) !important;
            color: var(--id-name-color) !important;
            font-weight: var(--id-name-weight) !important;
            text-transform: var(--id-name-transform) !important;
            margin-top: var(--id-name-margin-top) !important;
            text-shadow: var(--id-text-shadow) !important;
            line-height: 1.25;
        }
        .id-card-divider {
            display: var(--id-divider-display) !important;
            background-color: var(--id-ribbon-bg) !important;
        }
        .id-card-company {
            display: var(--id-company-display) !important;
            font-size: var(--id-company-size) !important;
            color: var(--id-company-color) !important;
        }
        .id-card-company.style-badge {
            background-color: var(--id-company-bg) !important;
            border: 1px solid rgba(203, 213, 225, 0.8);
            padding: 3px 10px;
            border-radius: 0.5rem;
        }
        .id-card-company.style-plain {
            background-color: transparent !important;
            border: none !important;
            padding: 0 !important;
            box-shadow: none !important;
        }
        .id-card-position {
            display: var(--id-position-display) !important;
            font-size: var(--id-position-size) !important;
            color: var(--id-position-color) !important;
            text-shadow: var(--id-text-shadow) !important;
        }
        .id-card-footer-block {
            display: var(--id-footer-display) !important;
        }

        /* Custom Scrollbar for Editor */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 6px;
        }
        body.dark-workspace .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
        }

        /* Modal Backdrop */
        .crop-modal-backdrop {
            background-color: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(4px);
        }

        /* Print Settings: 1 Kartu per Halaman (Page Break per Card) */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }
            html, body {
                background: transparent !important;
                padding: 0 !important;
                margin: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
            .print-wrapper {
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                display: block !important;
            }
            .print-container {
                display: block !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: none !important;
            }
            .id-card-page-wrapper {
                width: 100vw !important;
                height: 100vh !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                page-break-after: always !important;
                break-after: page !important;
                box-sizing: border-box !important;
                padding: 10mm !important;
            }
            .id-card-page-wrapper:last-child {
                page-break-after: auto !important;
                break-after: auto !important;
            }
            .id-card-box {
                box-shadow: none !important;
                border: 1px dashed #94a3b8 !important;
                border-radius: 0 !important;
                margin: 0 auto !important;
                background-color: var(--id-card-bg-color) !important;
            }
            .id-card-bg-layer {
                opacity: var(--id-card-bg-opacity) !important;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-6 lg:p-8 min-h-screen">

    <!-- Top Action Toolbar (No-Print: Gaya Card-3D Dashboard Luar) -->
    <div class="no-print card-3d max-w-7xl mx-auto mb-6 p-4 sm:p-5 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3.5 w-full md:w-auto">
            <!-- Tombol Kembali ke Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="btn-3d-white px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition-all flex items-center gap-1.5 flex-shrink-0">
                &larr; Dashboard
            </a>
            <div>
                <h1 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">Format Cetak & Kustomisasi ID Card</h1>
                <p class="text-xs text-slate-500 mt-0.5">Total: <strong class="text-slate-800">{{ count($participants) }} ID Card</strong> &bull; Format cetak: <strong>1 Kartu per Halaman</strong> (Lanyard B3/B4 95mm &times; 135mm)</p>
            </div>
        </div>

        <div class="flex items-center gap-2 w-full md:w-auto justify-end flex-wrap">
            <!-- Toggle Dark / Light Mode Workspace -->
            <button 
                type="button" 
                id="btnToggleWorkspaceTheme"
                onclick="toggleWorkspaceTheme()" 
                class="btn-3d-white px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition-all flex items-center gap-1.5 cursor-pointer"
                title="Ganti Mode Tampilan Layar (Cerah / Gelap)"
            >
                <span id="workspaceThemeIcon">&#9790;</span>
                <span id="workspaceThemeText">Mode Gelap Layar</span>
            </button>

            <!-- Toggle Editor Panel Button -->
            <button 
                type="button" 
                id="btnToggleEditor"
                onclick="toggleEditorPanel()"
                class="btn-3d-white px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition-all cursor-pointer"
            >
                <span id="editorToggleText">Sembunyikan Editor</span>
            </button>

            <!-- Tombol Reset Default -->
            <button 
                type="button" 
                onclick="resetSettings()" 
                class="btn-3d-white px-3 py-2 bg-white hover:bg-red-50 text-slate-600 hover:text-red-600 font-bold text-xs rounded-xl border border-slate-200 transition-all cursor-pointer"
            >
                Reset Default
            </button>

            <!-- Tombol Simpan Pengaturan -->
            <button 
                type="button" 
                id="btnSaveSettings"
                onclick="saveSettings()" 
                class="btn-3d-blue px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl border border-blue-600 transition-all cursor-pointer flex items-center gap-1.5"
            >
                <span id="saveBtnText">Simpan Pengaturan</span>
            </button>

            <!-- Tombol Cetak Semua ID Card -->
            <button 
                type="button" 
                onclick="window.print()" 
                class="btn-3d-dark px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl border border-slate-900 transition-all cursor-pointer flex items-center gap-1.5"
            >
                Cetak Semua ID Card
            </button>
        </div>
    </div>

    <!-- Main Workspace: Editor Panel (Left) & Preview/Print Cards (Right) -->
    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-6 items-start">

        <!-- ========================================== -->
        <!-- LIVE CUSTOMIZER PANEL (No-Print)          -->
        <!-- ========================================== -->
        <aside id="editorPanel" class="no-print w-full lg:w-96 flex-shrink-0 card-3d p-0 overflow-hidden sticky top-6 max-h-[calc(100vh-3rem)] flex flex-col">
            <!-- Header Panel -->
            <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h2 class="text-xs font-black text-slate-900 uppercase tracking-wider">Editor Desain ID Card</h2>
                    <p class="text-[10px] text-slate-500 mt-0.5">Live update serentak ke semua kartu</p>
                </div>
                <span class="text-[10px] bg-blue-50 text-blue-700 font-bold px-2.5 py-1 rounded-full border border-blue-200/60">Live Editor</span>
            </div>

            <!-- Quick Theme Presets: 1-Klik Mode Cerah vs Mode Gelap -->
            <div class="px-4 py-3 bg-slate-100/60 border-b border-slate-200/60">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-black uppercase tracking-wider text-slate-700">Preset Tema Kartu (1-Klik)</span>
                    <span class="text-[10px] text-slate-500">Cepat & Otomatis</span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <!-- Tombol Preset Kartu Mode Cerah -->
                    <button 
                        type="button" 
                        onclick="applyCardPreset('light')"
                        id="btnPresetLight"
                        class="btn-3d-white py-2 px-3 bg-white border border-slate-200 rounded-xl font-bold text-xs text-slate-800 flex items-center justify-center gap-2 hover:bg-slate-50 transition-all cursor-pointer ring-2 ring-blue-500 ring-offset-1"
                    >
                        <span class="w-3 h-3 rounded-full bg-white border border-slate-400"></span>
                        <span>Mode Cerah</span>
                    </button>
                    <!-- Tombol Preset Kartu Mode Gelap -->
                    <button 
                        type="button" 
                        onclick="applyCardPreset('dark')"
                        id="btnPresetDark"
                        class="btn-3d-dark py-2 px-3 bg-slate-900 border border-slate-900 rounded-xl font-bold text-xs text-white flex items-center justify-center gap-2 hover:bg-slate-800 transition-all cursor-pointer"
                    >
                        <span class="w-3 h-3 rounded-full bg-blue-500 border border-blue-300"></span>
                        <span>Mode Gelap</span>
                    </button>
                </div>
            </div>

            <!-- Tab Buttons (Gaya Dashboard Luar) -->
            <div class="flex border-b border-slate-100 bg-slate-50/70 p-1.5 gap-1 text-[11px] font-bold">
                <button type="button" onclick="switchTab('tab-bg')" id="btn-tab-bg" class="flex-1 py-2 text-center rounded-xl bg-white text-blue-600 shadow-sm border border-slate-200/80 transition-all">
                    Background
                </button>
                <button type="button" onclick="switchTab('tab-text')" id="btn-tab-text" class="flex-1 py-2 text-center rounded-xl text-slate-600 hover:text-slate-900 border border-transparent transition-all">
                    Font & Teks
                </button>
                <button type="button" onclick="switchTab('tab-layout')" id="btn-tab-layout" class="flex-1 py-2 text-center rounded-xl text-slate-600 hover:text-slate-900 border border-transparent transition-all">
                    Posisi & Layout
                </button>
            </div>

            <!-- Tab Contents (Scrollable dengan ruang bawah lega pb-24 agar tidak terpotong tombol Simpan) -->
            <div class="p-5 pb-24 overflow-y-auto custom-scrollbar flex-grow space-y-4 text-xs">

                <!-- ================= TAB 1: BACKGROUND & CROP ================= -->
                <div id="tab-bg" class="space-y-4">
                    <!-- Upload & Crop Custom Background Image -->
                    <div class="border border-slate-200/90 rounded-xl p-3.5 bg-slate-50/70 space-y-2.5">
                        <div class="flex items-center justify-between">
                            <label class="font-bold text-slate-900 text-xs">Gambar Background Lanyard</label>
                            <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-200/60">Rasio 95 : 135</span>
                        </div>
                        <p class="text-[10px] text-slate-500 leading-relaxed">
                            Upload desain background sendiri (Canva/Photoshop), lalu potong / crop bagian yang pas.
                        </p>
                        
                        <div class="flex items-center gap-2 flex-wrap pt-1">
                            <input 
                                type="file" 
                                id="inputBgImage" 
                                accept="image/png, image/jpeg, image/jpg, image/webp" 
                                class="hidden" 
                                onchange="handleFileSelectForCrop(event)"
                            >
                            <!-- Tombol Pilih Gambar -->
                            <button 
                                type="button" 
                                onclick="document.getElementById('inputBgImage').click()" 
                                class="btn-3d-dark px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl border border-slate-900 flex items-center gap-1.5"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                Pilih Gambar
                            </button>

                            <!-- Tombol Crop / Potong Ulang -->
                            <button 
                                type="button" 
                                id="btnReCrop"
                                onclick="openCropModalWithCurrent()" 
                                class="btn-3d-blue px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl border border-blue-600 flex items-center gap-1.5 {{ !empty($idCardConfig['background_image']) ? '' : 'hidden' }}"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.242-4.243 3 3 0 004.242 4.243z"/></svg>
                                Potong / Crop
                            </button>

                            <!-- Tombol Hapus Gambar -->
                            <button 
                                type="button" 
                                id="btnRemoveBg" 
                                onclick="removeBgImage()" 
                                class="btn-3d-white px-3 py-1.5 bg-white hover:bg-red-50 text-red-600 font-bold text-xs rounded-xl border border-slate-200 {{ !empty($idCardConfig['background_image']) ? '' : 'hidden' }}"
                            >
                                Hapus
                            </button>
                        </div>

                        <!-- Image Preview Status -->
                        <div id="bgPreviewContainer" class="mt-2.5 {{ !empty($idCardConfig['background_image']) ? '' : 'hidden' }}">
                            <div class="flex items-center gap-2.5 text-[11px] text-slate-700 bg-white border border-slate-200/80 rounded-xl p-2 shadow-xs">
                                <img id="bgPreviewThumb" src="{{ $idCardConfig['background_image'] ?? '' }}" alt="Thumb" class="w-8 h-10 object-cover rounded-lg border border-slate-200">
                                <span class="truncate flex-1 font-semibold text-slate-700" id="bgFileName">Gambar background aktif</span>
                            </div>
                        </div>
                    </div>

                    <!-- Background Opacity Slider -->
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label for="sliderBgOpacity" class="font-bold text-slate-700">Transparansi / Opacity Gambar</label>
                            <span id="labelBgOpacity" class="font-mono text-slate-500 text-[11px] font-bold">{{ $idCardConfig['bg_opacity'] ?? 100 }}%</span>
                        </div>
                        <input 
                            type="range" 
                            id="sliderBgOpacity" 
                            min="10" 
                            max="100" 
                            value="{{ $idCardConfig['bg_opacity'] ?? 100 }}" 
                            oninput="updateBgOpacity(this.value)"
                            class="w-full h-2 bg-slate-200 rounded-lg accent-blue-600 cursor-pointer"
                        >
                    </div>

                    <!-- Background Display Mode (Custom Dropdown) -->
                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">Mode Ukuran Gambar</label>
                        <select id="selectBgSize" onchange="updateBgSize(this.value)" class="select-custom w-full border border-slate-200 rounded-xl p-2.5 bg-white text-xs font-semibold focus:border-blue-600 focus:outline-none shadow-xs">
                            <option value="cover" {{ ($idCardConfig['bg_size'] ?? 'cover') === 'cover' ? 'selected' : '' }}>Cover (Penuhi seluruh kartu)</option>
                            <option value="contain" {{ ($idCardConfig['bg_size'] ?? '') === 'contain' ? 'selected' : '' }}>Contain (Sesuai rasio gambar)</option>
                            <option value="100% 100%" {{ ($idCardConfig['bg_size'] ?? '') === '100% 100%' ? 'selected' : '' }}>Stretch (Peregangan 100% 100%)</option>
                        </select>
                    </div>

                    <!-- Background Solid Color -->
                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">Warna Dasar Kartu</label>
                        <div class="flex items-center gap-2">
                            <input 
                                type="color" 
                                id="pickerBgColor" 
                                value="{{ $idCardConfig['bg_color'] ?? '#ffffff' }}" 
                                oninput="updateBgColor(this.value)"
                                class="w-9 h-9 p-0.5 border border-slate-200 rounded-xl cursor-pointer shadow-xs"
                            >
                            <input 
                                type="text" 
                                id="textBgColor" 
                                value="{{ $idCardConfig['bg_color'] ?? '#ffffff' }}" 
                                onchange="updateBgColor(this.value)"
                                class="flex-1 border border-slate-200 rounded-xl p-2 font-mono text-xs uppercase shadow-xs focus:border-blue-600 focus:outline-none"
                            >
                        </div>
                        <!-- Quick Color Swatches -->
                        <div class="flex gap-2 mt-2">
                            <button type="button" onclick="updateBgColor('#ffffff')" class="w-6 h-6 bg-white border border-slate-300 rounded-lg shadow-xs" title="Putih"></button>
                            <button type="button" onclick="updateBgColor('#0f172a')" class="w-6 h-6 bg-slate-900 border border-slate-700 rounded-lg shadow-xs" title="Slate 900"></button>
                            <button type="button" onclick="updateBgColor('#1e3a8a')" class="w-6 h-6 bg-blue-900 border border-blue-950 rounded-lg shadow-xs" title="Navy"></button>
                            <button type="button" onclick="updateBgColor('#fef3c7')" class="w-6 h-6 bg-amber-100 border border-amber-300 rounded-lg shadow-xs" title="Krem"></button>
                            <button type="button" onclick="updateBgColor('#000000')" class="w-6 h-6 bg-black border border-slate-800 rounded-lg shadow-xs" title="Hitam"></button>
                        </div>
                    </div>
                </div>

                <!-- ================= TAB 2: FONT, TEKS & KONTRAS ================= -->
                <div id="tab-text" class="space-y-4 hidden">
                    <!-- Global Font Family (Lengkap: 21 Font Populer) -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="font-bold text-slate-700">Jenis Font (21 Koleksi)</label>
                            <span class="text-[10px] text-blue-600 font-bold bg-blue-50 px-2 py-0.5 rounded">Google Fonts</span>
                        </div>
                        <select id="selectFontFamily" onchange="updateFontFamily(this.value)" class="select-custom w-full border border-slate-200 rounded-xl p-2.5 bg-white text-xs font-semibold focus:border-blue-600 focus:outline-none shadow-xs">
                            <optgroup label="Modern Sans (Bersih & Elegan)">
                                <option value="Plus Jakarta Sans" {{ ($idCardConfig['font_family'] ?? 'Plus Jakarta Sans') === 'Plus Jakarta Sans' ? 'selected' : '' }}>Plus Jakarta Sans (Default)</option>
                                <option value="Inter" {{ ($idCardConfig['font_family'] ?? '') === 'Inter' ? 'selected' : '' }}>Inter (Clean & Netral)</option>
                                <option value="Montserrat" {{ ($idCardConfig['font_family'] ?? '') === 'Montserrat' ? 'selected' : '' }}>Montserrat (Tegas & Modern)</option>
                                <option value="Poppins" {{ ($idCardConfig['font_family'] ?? '') === 'Poppins' ? 'selected' : '' }}>Poppins (Geometris Elegan)</option>
                                <option value="Outfit" {{ ($idCardConfig['font_family'] ?? '') === 'Outfit' ? 'selected' : '' }}>Outfit (Sleek & Futuristik)</option>
                                <option value="Manrope" {{ ($idCardConfig['font_family'] ?? '') === 'Manrope' ? 'selected' : '' }}>Manrope (Modern Semi-Rounded)</option>
                                <option value="Urbanist" {{ ($idCardConfig['font_family'] ?? '') === 'Urbanist' ? 'selected' : '' }}>Urbanist (Minimalist Premium)</option>
                                <option value="DM Sans" {{ ($idCardConfig['font_family'] ?? '') === 'DM Sans' ? 'selected' : '' }}>DM Sans (Solid Corporate)</option>
                                <option value="Raleway" {{ ($idCardConfig['font_family'] ?? '') === 'Raleway' ? 'selected' : '' }}>Raleway (Artistik & Ringan)</option>
                                <option value="Nunito" {{ ($idCardConfig['font_family'] ?? '') === 'Nunito' ? 'selected' : '' }}>Nunito (Friendly & Soft)</option>
                                <option value="Roboto" {{ ($idCardConfig['font_family'] ?? '') === 'Roboto' ? 'selected' : '' }}>Roboto (Standar Android)</option>
                            </optgroup>
                            <optgroup label="Event, Headline & Bold (Favorit Lanyard)">
                                <option value="Bebas Neue" {{ ($idCardConfig['font_family'] ?? '') === 'Bebas Neue' ? 'selected' : '' }}>Bebas Neue (Tinggi & Sangat Tegas)</option>
                                <option value="Oswald" {{ ($idCardConfig['font_family'] ?? '') === 'Oswald' ? 'selected' : '' }}>Oswald (Kompak & Elegan)</option>
                                <option value="Kanit" {{ ($idCardConfig['font_family'] ?? '') === 'Kanit' ? 'selected' : '' }}>Kanit (Tebal & Modern Event)</option>
                                <option value="Syne" {{ ($idCardConfig['font_family'] ?? '') === 'Syne' ? 'selected' : '' }}>Syne (Avant-Garde & High-End)</option>
                            </optgroup>
                            <optgroup label="Formal, Luxury & Serif (Eksekutif & Tamu Kehormatan)">
                                <option value="Playfair Display" {{ ($idCardConfig['font_family'] ?? '') === 'Playfair Display' ? 'selected' : '' }}>Playfair Display (Serif Mewah)</option>
                                <option value="Cinzel" {{ ($idCardConfig['font_family'] ?? '') === 'Cinzel' ? 'selected' : '' }}>Cinzel (Klasik Resmi / Sertifikat)</option>
                                <option value="Merriweather" {{ ($idCardConfig['font_family'] ?? '') === 'Merriweather' ? 'selected' : '' }}>Merriweather (Serif Elegan)</option>
                                <option value="Cormorant Garamond" {{ ($idCardConfig['font_family'] ?? '') === 'Cormorant Garamond' ? 'selected' : '' }}>Cormorant Garamond (Klasik Tradisional)</option>
                            </optgroup>
                            <optgroup label="Tech & Monospace">
                                <option value="Space Grotesk" {{ ($idCardConfig['font_family'] ?? '') === 'Space Grotesk' ? 'selected' : '' }}>Space Grotesk (Tech Startup)</option>
                                <option value="Space Mono" {{ ($idCardConfig['font_family'] ?? '') === 'Space Mono' ? 'selected' : '' }}>Space Mono (Digital / Kode)</option>
                            </optgroup>
                        </select>
                    </div>

                    <!-- Keterbacaan Teks di atas Gambar (Backdrop Plate & Shadow) -->
                    <div class="border border-blue-200/80 bg-blue-50/40 rounded-xl p-3.5 space-y-2.5">
                        <span class="block font-black text-slate-900 text-[11px] uppercase tracking-wider border-b border-blue-200/60 pb-1">
                            Proteksi Keterbacaan Teks
                        </span>
                        <p class="text-[10px] text-slate-600 leading-normal">
                            Gunakan plat pelindung agar teks nama tetap kontras dan terbaca jelas di atas gambar latar apa pun:
                        </p>

                        <!-- Pilihan Plat Pelindung Teks (Custom Dropdown) -->
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Lapisan Plat Teks (Backdrop)</label>
                            <select id="selectTextBackdrop" onchange="updateTextBackdrop(this.value)" class="select-custom w-full border border-slate-200 rounded-xl p-2 bg-white text-[11px] font-semibold focus:border-blue-600 focus:outline-none shadow-xs">
                                <option value="none" {{ ($idCardConfig['text_backdrop'] ?? 'none') === 'none' ? 'selected' : '' }}>Transparan Polos (Tanpa Plat)</option>
                                <option value="frosted-light" {{ ($idCardConfig['text_backdrop'] ?? '') === 'frosted-light' ? 'selected' : '' }}>Kaca Putih Semi-Transparan (Rekomendasi)</option>
                                <option value="frosted-dark" {{ ($idCardConfig['text_backdrop'] ?? '') === 'frosted-dark' ? 'selected' : '' }}>Kaca Gelap Semi-Transparan (Dark Plate)</option>
                            </select>
                        </div>

                        <!-- Toggle Text Shadow -->
                        <label class="flex items-center justify-between cursor-pointer pt-1">
                            <span class="text-[11px] font-bold text-slate-700">Bayangan Teks (Text Shadow)</span>
                            <input 
                                type="checkbox" 
                                id="toggleTextShadow" 
                                {{ (!empty($idCardConfig['text_shadow'])) ? 'checked' : '' }} 
                                onchange="updateTextShadow(this.checked)"
                                class="w-4 h-4 rounded accent-blue-600 cursor-pointer"
                            >
                        </label>
                    </div>

                    <!-- Pengaturan Nama Peserta -->
                    <div class="border border-slate-200/90 rounded-xl p-3.5 bg-slate-50/70 space-y-3">
                        <span class="block font-black text-slate-900 text-[11px] uppercase tracking-wider border-b border-slate-200 pb-1">Nama Peserta</span>
                        
                        <!-- Slider Ukuran Font Nama -->
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <label for="sliderNameSize" class="font-bold text-slate-700">Ukuran Font Nama</label>
                                <span id="labelNameSize" class="font-mono text-slate-600 text-[11px] font-bold">{{ $idCardConfig['name_size'] ?? 22 }}px</span>
                            </div>
                            <input 
                                type="range" 
                                id="sliderNameSize" 
                                min="14" 
                                max="36" 
                                value="{{ $idCardConfig['name_size'] ?? 22 }}" 
                                oninput="updateNameSize(this.value)"
                                class="w-full h-2 bg-slate-200 rounded-lg accent-blue-600 cursor-pointer"
                            >
                        </div>

                        <!-- Warna Teks Nama -->
                        <div class="flex items-center justify-between">
                            <label class="font-bold text-slate-700">Warna Teks Nama</label>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="color" 
                                    id="pickerNameColor" 
                                    value="{{ $idCardConfig['name_color'] ?? '#020617' }}" 
                                    oninput="updateNameColor(this.value)"
                                    class="w-7 h-7 p-0.5 border border-slate-200 rounded-lg cursor-pointer shadow-xs"
                                >
                                <span id="labelNameColorHex" class="font-mono text-[10px] text-slate-600 uppercase font-semibold">{{ $idCardConfig['name_color'] ?? '#020617' }}</span>
                            </div>
                        </div>

                        <!-- Ketebalan & Format Huruf Nama (Custom Dropdowns) -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Ketebalan</label>
                                <select id="selectNameWeight" onchange="updateNameWeight(this.value)" class="select-custom w-full border border-slate-200 rounded-xl p-2 bg-white text-[11px] font-semibold focus:border-blue-600 focus:outline-none shadow-xs">
                                    <option value="600" {{ ($idCardConfig['name_weight'] ?? '') === '600' ? 'selected' : '' }}>Semi-Bold (600)</option>
                                    <option value="700" {{ ($idCardConfig['name_weight'] ?? '') === '700' ? 'selected' : '' }}>Bold (700)</option>
                                    <option value="800" {{ ($idCardConfig['name_weight'] ?? '') === '800' ? 'selected' : '' }}>Extra Bold (800)</option>
                                    <option value="900" {{ ($idCardConfig['name_weight'] ?? '900') === '900' ? 'selected' : '' }}>Black (900)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Kapitalisasi</label>
                                <select id="selectNameTransform" onchange="updateNameTransform(this.value)" class="select-custom w-full border border-slate-200 rounded-xl p-2 bg-white text-[11px] font-semibold focus:border-blue-600 focus:outline-none shadow-xs">
                                    <option value="uppercase" {{ ($idCardConfig['name_transform'] ?? 'uppercase') === 'uppercase' ? 'selected' : '' }}>HURUF BESAR</option>
                                    <option value="capitalize" {{ ($idCardConfig['name_transform'] ?? '') === 'capitalize' ? 'selected' : '' }}>Huruf Kapital Depan</option>
                                    <option value="none" {{ ($idCardConfig['name_transform'] ?? '') === 'none' ? 'selected' : '' }}>Sesuai Input Asli</option>
                                </select>
                            </div>
                        </div>

                        <!-- Jarak Geser Vertikal Nama -->
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <label for="sliderNameMargin" class="font-bold text-slate-700">Margin Atas Nama</label>
                                <span id="labelNameMargin" class="font-mono text-slate-600 text-[11px] font-bold">{{ $idCardConfig['name_margin_top'] ?? 0 }}px</span>
                            </div>
                            <input 
                                type="range" 
                                id="sliderNameMargin" 
                                min="-20" 
                                max="40" 
                                value="{{ $idCardConfig['name_margin_top'] ?? 0 }}" 
                                oninput="updateNameMargin(this.value)"
                                class="w-full h-2 bg-slate-200 rounded-lg accent-blue-600 cursor-pointer"
                            >
                        </div>
                    </div>

                    <!-- Pengaturan Instansi / Perusahaan -->
                    <div class="border border-slate-200/90 rounded-xl p-3.5 bg-slate-50/70 space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-1">
                            <span class="font-black text-slate-900 text-[11px] uppercase tracking-wider">Instansi / Perusahaan</span>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    id="toggleShowCompany" 
                                    {{ (!isset($idCardConfig['show_company']) || $idCardConfig['show_company']) ? 'checked' : '' }} 
                                    onchange="updateToggleShowCompany(this.checked)"
                                    class="w-4 h-4 rounded accent-blue-600 cursor-pointer"
                                >
                                <span class="text-[10px] font-bold text-slate-700">Tampilkan</span>
                            </label>
                        </div>

                        <div id="companyControls" class="space-y-2.5 {{ (!isset($idCardConfig['show_company']) || $idCardConfig['show_company']) ? '' : 'opacity-40 pointer-events-none' }}">
                            <div class="flex justify-between items-center">
                                <label for="sliderCompanySize" class="font-bold text-slate-700">Ukuran Font</label>
                                <span id="labelCompanySize" class="font-mono text-slate-600 text-[11px] font-bold">{{ $idCardConfig['company_size'] ?? 11 }}px</span>
                            </div>
                            <input 
                                type="range" 
                                id="sliderCompanySize" 
                                min="8" 
                                max="18" 
                                value="{{ $idCardConfig['company_size'] ?? 11 }}" 
                                oninput="updateCompanySize(this.value)"
                                class="w-full h-2 bg-slate-200 rounded-lg accent-blue-600 cursor-pointer"
                            >

                            <div class="grid grid-cols-2 gap-2 pt-1">
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Tampilan</label>
                                    <select id="selectCompanyStyle" onchange="updateCompanyStyle(this.value)" class="select-custom w-full border border-slate-200 rounded-xl p-2 bg-white text-[11px] font-semibold focus:border-blue-600 focus:outline-none shadow-xs">
                                        <option value="badge" {{ ($idCardConfig['company_style'] ?? 'badge') === 'badge' ? 'selected' : '' }}>Badge Kotak</option>
                                        <option value="plain" {{ ($idCardConfig['company_style'] ?? '') === 'plain' ? 'selected' : '' }}>Teks Polos</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Warna Teks</label>
                                    <div class="flex items-center gap-1.5">
                                        <input 
                                            type="color" 
                                            id="pickerCompanyColor" 
                                            value="{{ $idCardConfig['company_color'] ?? '#0f172a' }}" 
                                            oninput="updateCompanyColor(this.value)"
                                            class="w-full h-8 p-0.5 border border-slate-200 rounded-xl cursor-pointer shadow-xs"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengaturan Jabatan -->
                    <div class="border border-slate-200/90 rounded-xl p-3.5 bg-slate-50/70 space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-1">
                            <span class="font-black text-slate-900 text-[11px] uppercase tracking-wider">Jabatan Peserta</span>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    id="toggleShowPosition" 
                                    {{ (!isset($idCardConfig['show_position']) || $idCardConfig['show_position']) ? 'checked' : '' }} 
                                    onchange="updateToggleShowPosition(this.checked)"
                                    class="w-4 h-4 rounded accent-blue-600 cursor-pointer"
                                >
                                <span class="text-[10px] font-bold text-slate-700">Tampilkan</span>
                            </label>
                        </div>

                        <div id="positionControls" class="space-y-2.5 {{ (!isset($idCardConfig['show_position']) || $idCardConfig['show_position']) ? '' : 'opacity-40 pointer-events-none' }}">
                            <div class="flex justify-between items-center">
                                <label for="sliderPositionSize" class="font-bold text-slate-700">Ukuran Font</label>
                                <span id="labelPositionSize" class="font-mono text-slate-600 text-[11px] font-bold">{{ $idCardConfig['position_size'] ?? 11 }}px</span>
                            </div>
                            <input 
                                type="range" 
                                id="sliderPositionSize" 
                                min="8" 
                                max="18" 
                                value="{{ $idCardConfig['position_size'] ?? 11 }}" 
                                oninput="updatePositionSize(this.value)"
                                class="w-full h-2 bg-slate-200 rounded-lg accent-blue-600 cursor-pointer"
                            >

                            <div class="flex items-center justify-between pt-1">
                                <label class="font-bold text-slate-700">Warna Teks Jabatan</label>
                                <input 
                                    type="color" 
                                    id="pickerPositionColor" 
                                    value="{{ $idCardConfig['position_color'] ?? '#64748b' }}" 
                                    oninput="updatePositionColor(this.value)"
                                    class="w-7 h-7 p-0.5 border border-slate-200 rounded-lg cursor-pointer shadow-xs"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= TAB 3: POSISI & LAYOUT ================= -->
                <div id="tab-layout" class="space-y-4 hidden">
                    
                    <!-- Vertical Offset Slider -->
                    <div class="border border-blue-200/90 bg-blue-50/40 rounded-xl p-3.5 space-y-2">
                        <div class="flex justify-between items-center">
                            <label for="sliderContentY" class="font-black text-slate-900 text-xs">Geser Posisi Teks Naik/Turun</label>
                            <span id="labelContentY" class="font-mono font-bold text-blue-700 text-xs bg-white px-2 py-0.5 rounded-md border border-blue-200 shadow-xs">{{ $idCardConfig['content_y_offset'] ?? 0 }}px</span>
                        </div>
                        <p class="text-[10px] text-slate-500 leading-relaxed">
                            Paskan posisi nama & jabatan dengan area kosong template gambar Anda.
                        </p>
                        <input 
                            type="range" 
                            id="sliderContentY" 
                            min="-100" 
                            max="100" 
                            value="{{ $idCardConfig['content_y_offset'] ?? 0 }}" 
                            oninput="updateContentY(this.value)"
                            class="w-full h-2.5 bg-slate-200 rounded-lg accent-blue-600 cursor-pointer"
                        >
                        <div class="flex justify-between text-[9px] text-slate-400 font-mono font-semibold">
                            <span>-100px (Naik)</span>
                            <span>0px (Netral)</span>
                            <span>+100px (Turun)</span>
                        </div>
                    </div>

                    <!-- Text Alignment -->
                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">Perataan Teks Konten</label>
                        <div class="grid grid-cols-3 gap-1.5">
                            <button 
                                type="button" 
                                onclick="updateTextAlign('left')" 
                                id="btnAlignLeft"
                                class="py-2 border rounded-xl font-bold text-xs transition-all {{ ($idCardConfig['text_align'] ?? 'center') === 'left' ? 'btn-3d-dark bg-slate-900 text-white border-slate-900' : 'btn-3d-white bg-white text-slate-700 border-slate-200' }}"
                            >
                                Rata Kiri
                            </button>
                            <button 
                                type="button" 
                                onclick="updateTextAlign('center')" 
                                id="btnAlignCenter"
                                class="py-2 border rounded-xl font-bold text-xs transition-all {{ ($idCardConfig['text_align'] ?? 'center') === 'center' ? 'btn-3d-dark bg-slate-900 text-white border-slate-900' : 'btn-3d-white bg-white text-slate-700 border-slate-200' }}"
                            >
                                Rata Tengah
                            </button>
                            <button 
                                type="button" 
                                onclick="updateTextAlign('right')" 
                                id="btnAlignRight"
                                class="py-2 border rounded-xl font-bold text-xs transition-all {{ ($idCardConfig['text_align'] ?? 'center') === 'right' ? 'btn-3d-dark bg-slate-900 text-white border-slate-900' : 'btn-3d-white bg-white text-slate-700 border-slate-200' }}"
                            >
                                Rata Kanan
                            </button>
                        </div>
                    </div>

                    <!-- Toggle Komponen Bawaan -->
                    <div class="border border-slate-200/90 rounded-xl p-3.5 bg-slate-50/70 space-y-2.5">
                        <span class="block font-black text-slate-900 text-[11px] uppercase tracking-wider border-b border-slate-200 pb-1">
                            Toggle Elemen Bawaan
                        </span>
                        <p class="text-[10px] text-slate-500 leading-normal">
                            Bila menggunakan background gambar lengkap dari Canva, sembunyikan elemen bawaan ini:
                        </p>

                        <!-- Toggle Lubang Lanyard -->
                        <label class="flex items-center justify-between cursor-pointer py-1.5 border-b border-slate-200/60">
                            <span class="text-xs font-bold text-slate-700">Lubang Tali Lanyard</span>
                            <input 
                                type="checkbox" 
                                id="toggleLanyard" 
                                {{ (!isset($idCardConfig['show_lanyard_hole']) || $idCardConfig['show_lanyard_hole']) ? 'checked' : '' }} 
                                onchange="updateToggleElement('lanyard', this.checked)"
                                class="w-4 h-4 rounded accent-blue-600 cursor-pointer"
                            >
                        </label>

                        <!-- Toggle Header Acara -->
                        <label class="flex items-center justify-between cursor-pointer py-1.5 border-b border-slate-200/60">
                            <span class="text-xs font-bold text-slate-700">Header Atas Acara</span>
                            <input 
                                type="checkbox" 
                                id="toggleHeader" 
                                {{ (!isset($idCardConfig['show_header']) || $idCardConfig['show_header']) ? 'checked' : '' }} 
                                onchange="updateToggleElement('header', this.checked)"
                                class="w-4 h-4 rounded accent-blue-600 cursor-pointer"
                            >
                        </label>

                        <!-- Toggle Pita Kategori -->
                        <div class="py-1.5 border-b border-slate-200/60 space-y-2">
                            <label class="flex items-center justify-between cursor-pointer">
                                <span class="text-xs font-bold text-slate-700">Pita Kategori Peserta</span>
                                <input 
                                    type="checkbox" 
                                    id="toggleRibbon" 
                                    {{ (!isset($idCardConfig['show_ribbon']) || $idCardConfig['show_ribbon']) ? 'checked' : '' }} 
                                    onchange="updateToggleElement('ribbon', this.checked)"
                                    class="w-4 h-4 rounded accent-blue-600 cursor-pointer"
                                >
                            </label>
                            
                            <!-- Ribbon Color Picker -->
                            <div id="ribbonColorControl" class="flex items-center justify-between pl-2 {{ (!isset($idCardConfig['show_ribbon']) || $idCardConfig['show_ribbon']) ? '' : 'hidden' }}">
                                <span class="text-[11px] text-slate-500 font-medium">Warna Pita:</span>
                                <div class="flex items-center gap-1.5">
                                    <input 
                                        type="color" 
                                        id="pickerRibbonBg" 
                                        value="{{ $idCardConfig['ribbon_bg'] ?? '#2563eb' }}" 
                                        oninput="updateRibbonBg(this.value)"
                                        class="w-6 h-6 p-0.5 border border-slate-200 rounded cursor-pointer"
                                    >
                                    <button type="button" onclick="updateRibbonBg('#2563eb')" class="w-5 h-5 bg-blue-600 rounded" title="Biru"></button>
                                    <button type="button" onclick="updateRibbonBg('#dc2626')" class="w-5 h-5 bg-red-600 rounded" title="Merah"></button>
                                    <button type="button" onclick="updateRibbonBg('#d97706')" class="w-5 h-5 bg-amber-600 rounded" title="Emas"></button>
                                    <button type="button" onclick="updateRibbonBg('#0f172a')" class="w-5 h-5 bg-slate-900 rounded" title="Hitam"></button>
                                </div>
                            </div>
                        </div>

                        <!-- Toggle Garis Pemisah -->
                        <label class="flex items-center justify-between cursor-pointer py-1.5 border-b border-slate-200/60">
                            <span class="text-xs font-bold text-slate-700">Garis Pemisah (Divider)</span>
                            <input 
                                type="checkbox" 
                                id="toggleDivider" 
                                {{ (!isset($idCardConfig['show_divider']) || $idCardConfig['show_divider']) ? 'checked' : '' }} 
                                onchange="updateToggleElement('divider', this.checked)"
                                class="w-4 h-4 rounded accent-blue-600 cursor-pointer"
                            >
                        </label>

                        <!-- Toggle Footer Bawah -->
                        <label class="flex items-center justify-between cursor-pointer py-1.5">
                            <span class="text-xs font-bold text-slate-700">Footer Bawah Acara</span>
                            <input 
                                type="checkbox" 
                                id="toggleFooter" 
                                {{ (!isset($idCardConfig['show_footer']) || $idCardConfig['show_footer']) ? 'checked' : '' }} 
                                onchange="updateToggleElement('footer', this.checked)"
                                class="w-4 h-4 rounded accent-blue-600 cursor-pointer"
                            >
                        </label>
                    </div>

                </div>

            </div>

            <!-- Footer Panel: Status & Actions (Fixed Sticky di Bawah) -->
            <div class="p-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[11px] relative z-10 shadow-sm">
                <span id="saveStatusIndicator" class="text-slate-500 font-semibold">Siap dicetak</span>
                <button 
                    type="button" 
                    onclick="saveSettings()" 
                    class="btn-3d-blue px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl border border-blue-600"
                >
                    Simpan
                </button>
            </div>
        </aside>

        <!-- ========================================== -->
        <!-- CANVAS PRINT / ID CARDS PREVIEW           -->
        <!-- ========================================== -->
        <main class="print-wrapper flex-grow w-full flex flex-col items-center">
            
            <div class="print-container w-full flex flex-wrap justify-center gap-8">
                @forelse($participants as $p)
                <!-- Single ID Card Page Wrapper -->
                <div class="id-card-page-wrapper">
                    <div class="id-card-box">
                        
                        <!-- Layer Background Image Kustom -->
                        <div class="id-card-bg-layer"></div>

                        <!-- Layer Konten Teks & Elemen Kartu -->
                        <div class="id-card-content-layer">
                            
                            <!-- 1. Top Section: Lubang Lanyard, Header, dan Pita -->
                            <div>
                                <!-- Lubang Tali Lanyard Guide -->
                                <div class="id-card-lanyard-hole w-full pt-3 pb-1 flex flex-col items-center justify-center">
                                    <div class="id-card-lanyard-hole-pill w-10 h-2 border border-slate-300 rounded-full bg-slate-100 flex items-center justify-center">
                                        <span class="w-3 h-0.5 bg-slate-300 rounded-full"></span>
                                    </div>
                                </div>

                                <!-- Header Organisasi -->
                                <div class="id-card-header-block px-5 pt-2 pb-2 text-center">
                                    <span class="id-card-header-subtitle text-[9px] font-black tracking-widest text-slate-400 uppercase block">EXECUTIVE ROUNDTABLE</span>
                                    <h2 class="id-card-header-title text-sm font-black tracking-tight text-slate-900 uppercase mt-0.5">WONDERFUL 2026</h2>
                                </div>

                                <!-- Pita Kategori Peserta -->
                                <div class="id-card-ribbon text-center py-1.5 px-4 font-black text-xs tracking-wider uppercase">
                                    {{ !empty($p->position) && str_contains(strtolower($p->position), 'ketua') ? 'TAMU KEHORMATAN' : 'PESERTA' }}
                                </div>
                            </div>

                            <!-- 2. Middle Section: Nama, Instansi, Jabatan (Konten Utama dengan Pelindung Keterbacaan) -->
                            <div class="id-card-middle-content px-5 py-4 flex-grow flex flex-col justify-center items-center">
                                
                                <div class="text-backdrop-plate {{ ($idCardConfig['text_backdrop'] ?? 'none') === 'frosted-light' ? 'plate-frosted-light' : (($idCardConfig['text_backdrop'] ?? '') === 'frosted-dark' ? 'plate-frosted-dark' : 'plate-none') }} flex flex-col items-center justify-center">
                                    <!-- Nama Peserta -->
                                    <h3 class="id-card-name max-w-full break-words">
                                        {{ $p->name }}
                                    </h3>

                                    <!-- Garis Pemisah Elegan -->
                                    <div class="id-card-divider w-10 h-0.5 my-3 rounded-full"></div>

                                    <!-- Instansi / Perusahaan -->
                                    <div class="id-card-company {{ ($idCardConfig['company_style'] ?? 'badge') === 'plain' ? 'style-plain' : 'style-badge' }} max-w-full truncate font-bold uppercase tracking-wider">
                                        {{ $p->company ?: 'Wonderful' }}
                                    </div>

                                    <!-- Jabatan -->
                                    @if($p->position && $p->position !== '-')
                                    <p class="id-card-position font-semibold uppercase tracking-wide mt-2">
                                        {{ $p->position }}
                                    </p>
                                    @endif
                                </div>

                            </div>

                            <!-- 3. Bottom Section: Footer Acara -->
                            <div class="id-card-footer-block bg-slate-900 text-white px-4 py-2.5 text-center border-t border-slate-800">
                                <p class="text-[9px] font-bold text-slate-200 uppercase tracking-wider leading-tight">
                                    {{ $eventSettings['nama_acara'] ?? 'The Executive Roundtable — From AI Ambition to Enterprise Impact' }}
                                </p>
                                <p class="text-[8px] text-slate-400 mt-0.5 font-medium">
                                    {{ $eventSettings['tanggal'] ?? '27 Oktober 2026' }} &bull; {{ $eventSettings['venue'] ?? 'SCBD Area' }}
                                </p>
                            </div>

                        </div>

                    </div>
                </div>
                @empty
                <div class="w-full text-center py-16 text-slate-500 card-3d p-8">
                    Tidak ada data peserta untuk dicetak.
                </div>
                @endforelse
            </div>

        </main>
    </div>

    <!-- ========================================== -->
    <!-- MODAL CROPPER.JS (GAYA CARD-3D DASHBOARD) -->
    <!-- ========================================== -->
    <div id="cropModal" class="no-print fixed inset-0 z-50 flex items-center justify-center p-4 crop-modal-backdrop hidden">
        <div class="card-3d w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden p-0 border border-slate-200 shadow-2xl">
            <!-- Modal Header -->
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
                <div>
                    <h3 class="text-sm font-black text-slate-900">Potong / Crop Gambar Background</h3>
                    <p class="text-[11px] text-slate-500 mt-0.5">Rasio otomatis disesuaikan dengan kartu lanyard B3/B4 (95 × 135 mm)</p>
                </div>
                <button type="button" onclick="closeCropModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center font-bold text-base transition-colors cursor-pointer">&times;</button>
            </div>

            <!-- Modal Body (Cropper Viewport) -->
            <div class="p-4 flex-grow overflow-hidden flex flex-col items-center justify-center bg-slate-950">
                <div class="w-full max-h-[52vh] flex items-center justify-center overflow-hidden rounded-xl">
                    <img id="cropperImage" src="" alt="Crop Source" class="max-w-full block">
                </div>
            </div>

            <!-- Modal Toolbar Controls -->
            <div class="bg-white border-t border-slate-100 px-5 py-3.5 flex items-center justify-between flex-wrap gap-3 text-xs">
                <!-- Ratio Selection -->
                <div class="flex items-center gap-1.5">
                    <span class="font-bold text-slate-600">Rasio:</span>
                    <button type="button" id="btnRatioLanyard" onclick="setCropRatio(95/135)" class="btn-3d-dark px-3 py-1.5 bg-slate-900 text-white font-bold rounded-xl border border-slate-900">95:135 (Lanyard)</button>
                    <button type="button" id="btnRatioFree" onclick="setCropRatio(NaN)" class="btn-3d-white px-3 py-1.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl">Bebas</button>
                </div>

                <!-- Zoom & Rotate Actions -->
                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="cropper && cropper.zoom(0.1)" class="btn-3d-white w-8 h-8 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl flex items-center justify-center" title="Zoom In">+</button>
                    <button type="button" onclick="cropper && cropper.zoom(-0.1)" class="btn-3d-white w-8 h-8 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl flex items-center justify-center" title="Zoom Out">-</button>
                    <button type="button" onclick="cropper && cropper.rotate(90)" class="btn-3d-white px-2.5 h-8 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl flex items-center justify-center" title="Putar 90&deg;">&#8635; 90&deg;</button>
                    <button type="button" onclick="cropper && cropper.reset()" class="btn-3d-white px-2.5 h-8 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl text-[11px]">Reset</button>
                </div>

                <!-- Apply Actions -->
                <div class="flex items-center gap-2">
                    <button type="button" onclick="closeCropModal()" class="btn-3d-white px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl">
                        Batal
                    </button>
                    <button type="button" onclick="applyCroppedImage()" class="btn-3d-blue px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl border border-blue-600 flex items-center gap-1.5">
                        <span>Terapkan Hasil Crop</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Customization & Cropper Script -->
    <script>
        // State Konfigurasi
        const state = {
            bg_color: "{{ $idCardConfig['bg_color'] ?? '#ffffff' }}",
            background_image: "{{ $idCardConfig['background_image'] ?? '' }}",
            bg_opacity: {{ $idCardConfig['bg_opacity'] ?? 100 }},
            bg_size: "{{ $idCardConfig['bg_size'] ?? 'cover' }}",
            bg_position: "{{ $idCardConfig['bg_position'] ?? 'center' }}",
            font_family: "{{ $idCardConfig['font_family'] ?? 'Plus Jakarta Sans' }}",
            header_title_color: "{{ $idCardConfig['header_title_color'] ?? '#0f172a' }}",
            header_sub_color: "{{ $idCardConfig['header_sub_color'] ?? '#94a3b8' }}",
            lanyard_hole_bg: "{{ $idCardConfig['lanyard_hole_bg'] ?? '#f1f5f9' }}",
            lanyard_hole_border: "{{ $idCardConfig['lanyard_hole_border'] ?? '#cbd5e1' }}",
            name_size: {{ $idCardConfig['name_size'] ?? 22 }},
            name_color: "{{ $idCardConfig['name_color'] ?? '#020617' }}",
            name_weight: "{{ $idCardConfig['name_weight'] ?? '900' }}",
            name_transform: "{{ $idCardConfig['name_transform'] ?? 'uppercase' }}",
            name_margin_top: {{ $idCardConfig['name_margin_top'] ?? 0 }},
            show_company: {{ (!isset($idCardConfig['show_company']) || $idCardConfig['show_company']) ? 'true' : 'false' }},
            company_size: {{ $idCardConfig['company_size'] ?? 11 }},
            company_color: "{{ $idCardConfig['company_color'] ?? '#0f172a' }}",
            company_style: "{{ $idCardConfig['company_style'] ?? 'badge' }}",
            company_bg: "{{ $idCardConfig['company_bg'] ?? '#f1f5f9' }}",
            show_position: {{ (!isset($idCardConfig['show_position']) || $idCardConfig['show_position']) ? 'true' : 'false' }},
            position_size: {{ $idCardConfig['position_size'] ?? 11 }},
            position_color: "{{ $idCardConfig['position_color'] ?? '#64748b' }}",
            show_lanyard_hole: {{ (!isset($idCardConfig['show_lanyard_hole']) || $idCardConfig['show_lanyard_hole']) ? 'true' : 'false' }},
            show_header: {{ (!isset($idCardConfig['show_header']) || $idCardConfig['show_header']) ? 'true' : 'false' }},
            show_ribbon: {{ (!isset($idCardConfig['show_ribbon']) || $idCardConfig['show_ribbon']) ? 'true' : 'false' }},
            ribbon_bg: "{{ $idCardConfig['ribbon_bg'] ?? '#2563eb' }}",
            ribbon_color: "{{ $idCardConfig['ribbon_color'] ?? '#ffffff' }}",
            show_divider: {{ (!isset($idCardConfig['show_divider']) || $idCardConfig['show_divider']) ? 'true' : 'false' }},
            show_footer: {{ (!isset($idCardConfig['show_footer']) || $idCardConfig['show_footer']) ? 'true' : 'false' }},
            content_y_offset: {{ $idCardConfig['content_y_offset'] ?? 0 }},
            text_align: "{{ $idCardConfig['text_align'] ?? 'center' }}",
            text_backdrop: "{{ $idCardConfig['text_backdrop'] ?? 'none' }}",
            text_shadow: {{ !empty($idCardConfig['text_shadow']) ? 'true' : 'false' }},
        };

        // File/Blob siap upload
        let pendingBgFile = null;
        let cropper = null;
        let rawImageSource = "{{ $idCardConfig['background_image'] ?? '' }}";

        // ==========================================
        // 1-KLIK PRESET KARTU: MODE CERAH & MODE GELAP
        // ==========================================
        function applyCardPreset(mode) {
            const btnLight = document.getElementById('btnPresetLight');
            const btnDark = document.getElementById('btnPresetDark');

            if (mode === 'light') {
                // Preset Cerah
                state.bg_color = '#ffffff';
                state.name_color = '#020617';
                state.header_title_color = '#0f172a';
                state.header_sub_color = '#94a3b8';
                state.lanyard_hole_bg = '#f1f5f9';
                state.lanyard_hole_border = '#cbd5e1';
                state.company_color = '#0f172a';
                state.company_bg = '#f1f5f9';
                state.position_color = '#64748b';
                state.ribbon_bg = '#2563eb';
                state.ribbon_color = '#ffffff';
                state.text_backdrop = 'none';
                state.text_shadow = false;

                // Update input values di form
                document.getElementById('pickerBgColor').value = '#ffffff';
                document.getElementById('textBgColor').value = '#ffffff';
                document.getElementById('pickerNameColor').value = '#020617';
                document.getElementById('labelNameColorHex').innerText = '#020617';
                document.getElementById('pickerCompanyColor').value = '#0f172a';
                document.getElementById('pickerPositionColor').value = '#64748b';
                document.getElementById('pickerRibbonBg').value = '#2563eb';
                document.getElementById('selectTextBackdrop').value = 'none';
                document.getElementById('toggleTextShadow').checked = false;

                // Ring indikator
                btnLight.classList.add('ring-2', 'ring-blue-500', 'ring-offset-1');
                btnDark.classList.remove('ring-2', 'ring-blue-500', 'ring-offset-1');

                Swal.fire({
                    icon: 'success',
                    title: 'Preset Mode Cerah Diterapkan',
                    text: 'Tampilan kartu diubah ke tema putih bersih.',
                    timer: 1200,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            } else if (mode === 'dark') {
                // Preset Gelap Elegan
                state.bg_color = '#0f172a';
                state.name_color = '#ffffff';
                state.header_title_color = '#ffffff';
                state.header_sub_color = '#94a3b8';
                state.lanyard_hole_bg = '#1e293b';
                state.lanyard_hole_border = '#334155';
                state.company_color = '#ffffff';
                state.company_bg = '#1e293b';
                state.position_color = '#94a3b8';
                state.ribbon_bg = '#1d4ed8';
                state.ribbon_color = '#ffffff';
                state.text_backdrop = 'frosted-dark';
                state.text_shadow = true;

                // Update input values di form
                document.getElementById('pickerBgColor').value = '#0f172a';
                document.getElementById('textBgColor').value = '#0f172a';
                document.getElementById('pickerNameColor').value = '#ffffff';
                document.getElementById('labelNameColorHex').innerText = '#FFFFFF';
                document.getElementById('pickerCompanyColor').value = '#ffffff';
                document.getElementById('pickerPositionColor').value = '#94a3b8';
                document.getElementById('pickerRibbonBg').value = '#1d4ed8';
                document.getElementById('selectTextBackdrop').value = 'frosted-dark';
                document.getElementById('toggleTextShadow').checked = true;

                // Ring indikator
                btnDark.classList.add('ring-2', 'ring-blue-500', 'ring-offset-1');
                btnLight.classList.remove('ring-2', 'ring-blue-500', 'ring-offset-1');

                Swal.fire({
                    icon: 'success',
                    title: 'Preset Mode Gelap Diterapkan',
                    text: 'Tampilan kartu diubah ke tema dark elegant.',
                    timer: 1200,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }

            applyStyles();
        }

        // ==========================================
        // TOGGLE DARK / LIGHT WORKSPACE THEME
        // ==========================================
        function toggleWorkspaceTheme() {
            const body = document.body;
            const icon = document.getElementById('workspaceThemeIcon');
            const text = document.getElementById('workspaceThemeText');

            if (body.classList.contains('dark-workspace')) {
                body.classList.remove('dark-workspace');
                icon.innerHTML = '&#9790;';
                text.innerText = 'Mode Gelap Layar';
                localStorage.setItem('id_card_workspace_theme', 'light');
            } else {
                body.classList.add('dark-workspace');
                icon.innerHTML = '&#9788;';
                text.innerText = 'Mode Cerah Layar';
                localStorage.setItem('id_card_workspace_theme', 'dark');
            }
        }

        // Tab Switching
        function switchTab(tabId) {
            ['tab-bg', 'tab-text', 'tab-layout'].forEach(id => {
                const el = document.getElementById(id);
                const btn = document.getElementById('btn-' + id);
                if (id === tabId) {
                    el.classList.remove('hidden');
                    btn.classList.add('bg-white', 'text-blue-600', 'shadow-sm', 'border-slate-200/80');
                    btn.classList.remove('text-slate-600', 'border-transparent');
                } else {
                    el.classList.add('hidden');
                    btn.classList.remove('bg-white', 'text-blue-600', 'shadow-sm', 'border-slate-200/80');
                    btn.classList.add('text-slate-600', 'border-transparent');
                }
            });
        }

        // Toggle Panel Editor
        function toggleEditorPanel() {
            const panel = document.getElementById('editorPanel');
            const text = document.getElementById('editorToggleText');
            if (panel.classList.contains('hidden')) {
                panel.classList.remove('hidden');
                text.innerText = 'Sembunyikan Editor';
            } else {
                panel.classList.add('hidden');
                text.innerText = 'Buka Editor';
            }
        }

        // Apply All State variables to CSS Root Variables
        function applyStyles() {
            const root = document.documentElement;
            
            root.style.setProperty('--id-card-bg-color', state.bg_color);
            root.style.setProperty('--id-card-bg-image', state.background_image ? `url("${state.background_image}")` : 'none');
            root.style.setProperty('--id-card-bg-opacity', state.bg_opacity / 100);
            root.style.setProperty('--id-card-bg-size', state.bg_size);
            root.style.setProperty('--id-card-bg-position', state.bg_position);

            root.style.setProperty('--id-card-font-family', `'${state.font_family}', sans-serif`);

            root.style.setProperty('--id-header-title-color', state.header_title_color);
            root.style.setProperty('--id-header-sub-color', state.header_sub_color);
            root.style.setProperty('--id-lanyard-hole-bg', state.lanyard_hole_bg);
            root.style.setProperty('--id-lanyard-hole-border', state.lanyard_hole_border);

            root.style.setProperty('--id-name-size', `${state.name_size}px`);
            root.style.setProperty('--id-name-color', state.name_color);
            root.style.setProperty('--id-name-weight', state.name_weight);
            root.style.setProperty('--id-name-transform', state.name_transform);
            root.style.setProperty('--id-name-margin-top', `${state.name_margin_top}px`);

            root.style.setProperty('--id-company-size', `${state.company_size}px`);
            root.style.setProperty('--id-company-color', state.company_color);
            root.style.setProperty('--id-company-display', state.show_company ? 'inline-block' : 'none');
            root.style.setProperty('--id-company-bg', state.company_bg);

            root.style.setProperty('--id-position-size', `${state.position_size}px`);
            root.style.setProperty('--id-position-color', state.position_color);
            root.style.setProperty('--id-position-display', state.show_position ? 'block' : 'none');

            root.style.setProperty('--id-ribbon-bg', state.ribbon_bg);
            root.style.setProperty('--id-ribbon-color', state.ribbon_color);
            root.style.setProperty('--id-ribbon-display', state.show_ribbon ? 'block' : 'none');

            root.style.setProperty('--id-lanyard-display', state.show_lanyard_hole ? 'flex' : 'none');
            root.style.setProperty('--id-header-display', state.show_header ? 'block' : 'none');
            root.style.setProperty('--id-divider-display', state.show_divider ? 'block' : 'none');
            root.style.setProperty('--id-footer-display', state.show_footer ? 'block' : 'none');

            root.style.setProperty('--id-content-y-offset', `${state.content_y_offset}px`);
            root.style.setProperty('--id-text-align', state.text_align);

            root.style.setProperty('--id-text-shadow', state.text_shadow ? '0 1px 3px rgba(0,0,0,0.5)' : 'none');

            // Update company style class
            document.querySelectorAll('.id-card-company').forEach(el => {
                if (state.company_style === 'plain') {
                    el.classList.remove('style-badge');
                    el.classList.add('style-plain');
                } else {
                    el.classList.remove('style-plain');
                    el.classList.add('style-badge');
                }
            });

            // Update backdrop plate class
            document.querySelectorAll('.text-backdrop-plate').forEach(el => {
                el.classList.remove('plate-none', 'plate-frosted-light', 'plate-frosted-dark');
                if (state.text_backdrop === 'frosted-light') {
                    el.classList.add('plate-frosted-light');
                } else if (state.text_backdrop === 'frosted-dark') {
                    el.classList.add('plate-frosted-dark');
                } else {
                    el.classList.add('plate-none');
                }
            });
        }

        // ==========================================
        // CROPPER.JS INTEGRATION
        // ==========================================
        function handleFileSelectForCrop(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                rawImageSource = e.target.result;
                openCropModal(e.target.result);
            };
            reader.readAsDataURL(file);
        }

        function openCropModalWithCurrent() {
            if (!rawImageSource) return;
            openCropModal(rawImageSource);
        }

        function openCropModal(imageSrc) {
            const modal = document.getElementById('cropModal');
            const cropImage = document.getElementById('cropperImage');
            
            cropImage.src = imageSrc;
            modal.classList.remove('hidden');

            if (cropper) {
                cropper.destroy();
            }

            // Init Cropper dengan rasio Lanyard 95:135
            setTimeout(() => {
                cropper = new Cropper(cropImage, {
                    aspectRatio: 95 / 135,
                    viewMode: 1,
                    autoCropArea: 1,
                    responsive: true,
                    checkCrossOrigin: false,
                    background: false,
                });
            }, 100);
        }

        function setCropRatio(ratio) {
            if (!cropper) return;
            cropper.setAspectRatio(ratio);
            const btnLanyard = document.getElementById('btnRatioLanyard');
            const btnFree = document.getElementById('btnRatioFree');
            if (isNaN(ratio)) {
                btnFree.className = 'btn-3d-dark px-3 py-1.5 bg-slate-900 text-white font-bold rounded-xl border border-slate-900';
                btnLanyard.className = 'btn-3d-white px-3 py-1.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl';
            } else {
                btnLanyard.className = 'btn-3d-dark px-3 py-1.5 bg-slate-900 text-white font-bold rounded-xl border border-slate-900';
                btnFree.className = 'btn-3d-white px-3 py-1.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl';
            }
        }

        function closeCropModal() {
            const modal = document.getElementById('cropModal');
            modal.classList.add('hidden');
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            document.getElementById('inputBgImage').value = '';
        }

        function applyCroppedImage() {
            if (!cropper) return;

            // Dapatkan canvas hasil crop resolusi tinggi (950 x 1350 px = 10x ratio)
            const canvas = cropper.getCroppedCanvas({
                width: 950,
                height: 1350,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            if (!canvas) return;

            const croppedDataUrl = canvas.toDataURL('image/jpeg', 0.92);
            state.background_image = croppedDataUrl;

            // Simpan blob untuk form data upload
            canvas.toBlob(blob => {
                pendingBgFile = new File([blob], 'id_card_background_cropped.jpg', { type: 'image/jpeg' });
            }, 'image/jpeg', 0.92);

            // Update UI preview
            document.getElementById('bgPreviewThumb').src = croppedDataUrl;
            document.getElementById('bgFileName').innerText = 'Gambar hasil crop (95:135)';
            document.getElementById('bgPreviewContainer').classList.remove('hidden');
            document.getElementById('btnReCrop').classList.remove('hidden');
            document.getElementById('btnRemoveBg').classList.remove('hidden');

            applyStyles();
            closeCropModal();

            Swal.fire({
                icon: 'success',
                title: 'Gambar Berhasil Dipotong!',
                text: 'Background ID Card sudah diperbarui sesuai potongan.',
                timer: 1500,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }

        function removeBgImage() {
            pendingBgFile = null;
            rawImageSource = '';
            state.background_image = '';
            document.getElementById('inputBgImage').value = '';
            document.getElementById('bgPreviewContainer').classList.add('hidden');
            document.getElementById('btnReCrop').classList.add('hidden');
            document.getElementById('btnRemoveBg').classList.add('hidden');
            applyStyles();
        }

        // Live Handlers: Background Controls
        function updateBgOpacity(val) {
            state.bg_opacity = parseInt(val, 10);
            document.getElementById('labelBgOpacity').innerText = val + '%';
            applyStyles();
        }

        function updateBgSize(val) {
            state.bg_size = val;
            applyStyles();
        }

        function updateBgColor(val) {
            state.bg_color = val;
            document.getElementById('pickerBgColor').value = val;
            document.getElementById('textBgColor').value = val;
            applyStyles();
        }

        // Live Handlers: Typography & Text
        function updateFontFamily(val) {
            state.font_family = val;
            applyStyles();
        }

        function updateTextBackdrop(val) {
            state.text_backdrop = val;
            applyStyles();
        }

        function updateTextShadow(checked) {
            state.text_shadow = checked;
            applyStyles();
        }

        function updateNameSize(val) {
            state.name_size = parseInt(val, 10);
            document.getElementById('labelNameSize').innerText = val + 'px';
            applyStyles();
        }

        function updateNameColor(val) {
            state.name_color = val;
            document.getElementById('labelNameColorHex').innerText = val;
            applyStyles();
        }

        function updateNameWeight(val) {
            state.name_weight = val;
            applyStyles();
        }

        function updateNameTransform(val) {
            state.name_transform = val;
            applyStyles();
        }

        function updateNameMargin(val) {
            state.name_margin_top = parseInt(val, 10);
            document.getElementById('labelNameMargin').innerText = val + 'px';
            applyStyles();
        }

        function updateToggleShowCompany(checked) {
            state.show_company = checked;
            const ctrl = document.getElementById('companyControls');
            if (checked) {
                ctrl.classList.remove('opacity-40', 'pointer-events-none');
            } else {
                ctrl.classList.add('opacity-40', 'pointer-events-none');
            }
            applyStyles();
        }

        function updateCompanySize(val) {
            state.company_size = parseInt(val, 10);
            document.getElementById('labelCompanySize').innerText = val + 'px';
            applyStyles();
        }

        function updateCompanyStyle(val) {
            state.company_style = val;
            applyStyles();
        }

        function updateCompanyColor(val) {
            state.company_color = val;
            applyStyles();
        }

        function updateToggleShowPosition(checked) {
            state.show_position = checked;
            const ctrl = document.getElementById('positionControls');
            if (checked) {
                ctrl.classList.remove('opacity-40', 'pointer-events-none');
            } else {
                ctrl.classList.add('opacity-40', 'pointer-events-none');
            }
            applyStyles();
        }

        function updatePositionSize(val) {
            state.position_size = parseInt(val, 10);
            document.getElementById('labelPositionSize').innerText = val + 'px';
            applyStyles();
        }

        function updatePositionColor(val) {
            state.position_color = val;
            applyStyles();
        }

        // Live Handlers: Layout & Offsets
        function updateContentY(val) {
            state.content_y_offset = parseInt(val, 10);
            document.getElementById('labelContentY').innerText = (val > 0 ? '+' : '') + val + 'px';
            applyStyles();
        }

        function updateTextAlign(val) {
            state.text_align = val;
            ['left', 'center', 'right'].forEach(align => {
                const btn = document.getElementById('btnAlign' + align.charAt(0).toUpperCase() + align.slice(1));
                if (align === val) {
                    btn.className = 'py-2 border rounded-xl font-bold text-xs transition-all btn-3d-dark bg-slate-900 text-white border-slate-900';
                } else {
                    btn.className = 'py-2 border rounded-xl font-bold text-xs transition-all btn-3d-white bg-white text-slate-700 border-slate-200';
                }
            });
            applyStyles();
        }

        function updateToggleElement(type, checked) {
            if (type === 'lanyard') state.show_lanyard_hole = checked;
            if (type === 'header') state.show_header = checked;
            if (type === 'ribbon') {
                state.show_ribbon = checked;
                const ctrl = document.getElementById('ribbonColorControl');
                if (checked) ctrl.classList.remove('hidden');
                else ctrl.classList.add('hidden');
            }
            if (type === 'divider') state.show_divider = checked;
            if (type === 'footer') state.show_footer = checked;
            applyStyles();
        }

        function updateRibbonBg(val) {
            state.ribbon_bg = val;
            document.getElementById('pickerRibbonBg').value = val;
            applyStyles();
        }

        // ==========================================
        // SAVE & RESET ACTIONS
        // ==========================================
        async function saveSettings() {
            const btn = document.getElementById('btnSaveSettings');
            const btnText = document.getElementById('saveBtnText');
            const indicator = document.getElementById('saveStatusIndicator');
            
            btn.disabled = true;
            btnText.innerText = 'Menyimpan...';
            indicator.innerText = 'Menyimpan ke server...';

            try {
                const formData = new FormData();
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                
                // Append all state properties
                Object.keys(state).forEach(key => {
                    formData.append(key, state[key]);
                });

                // Append file if newly cropped/uploaded
                if (pendingBgFile) {
                    formData.append('background_image_file', pendingBgFile);
                }

                const response = await fetch("{{ route('admin.participants.id-cards.settings.save') }}", {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const resData = await response.json();

                if (resData.success) {
                    if (resData.config && resData.config.background_image) {
                        state.background_image = resData.config.background_image;
                        rawImageSource = resData.config.background_image;
                    }
                    pendingBgFile = null;

                    // Simpan juga ke localStorage
                    localStorage.setItem('id_card_config_wonderful', JSON.stringify(state));

                    indicator.innerText = 'Tersimpan permanen!';
                    indicator.classList.add('text-emerald-600');

                    Swal.fire({
                        icon: 'success',
                        title: 'Pengaturan Disimpan!',
                        text: 'Format dan background ID Card berhasil disimpan ke database.',
                        timer: 1800,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                } else {
                    throw new Error(resData.message || 'Gagal menyimpan');
                }
            } catch (err) {
                console.error(err);
                indicator.innerText = 'Gagal menyimpan';
                indicator.classList.add('text-red-600');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
                    text: err.message || 'Terjadi kesalahan saat menyimpan pengaturan.',
                });
            } finally {
                btn.disabled = false;
                btnText.innerText = 'Simpan Pengaturan';
            }
        }

        async function resetSettings() {
            const result = await Swal.fire({
                title: 'Reset Format ID Card?',
                text: 'Format akan dikembalikan ke setelan bawaan awal.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal'
            });

            if (!result.isConfirmed) return;

            try {
                const response = await fetch("{{ route('admin.participants.id-cards.settings.reset') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({})
                });

                localStorage.removeItem('id_card_config_wonderful');
                
                Swal.fire({
                    icon: 'success',
                    title: 'Reset Berhasil',
                    text: 'Format ID Card kembali ke default.',
                    timer: 1200,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            } catch (err) {
                console.error(err);
                window.location.reload();
            }
        }

        // Initialize on Load
        document.addEventListener('DOMContentLoaded', () => {
            // Restore saved workspace theme
            const savedWorkspaceTheme = localStorage.getItem('id_card_workspace_theme');
            if (savedWorkspaceTheme === 'dark') {
                document.body.classList.add('dark-workspace');
                const icon = document.getElementById('workspaceThemeIcon');
                const text = document.getElementById('workspaceThemeText');
                if (icon) icon.innerHTML = '&#9788;';
                if (text) text.innerText = 'Mode Cerah Layar';
            }

            // Sync initial preset ring
            if (state.bg_color === '#0f172a') {
                const btnDark = document.getElementById('btnPresetDark');
                const btnLight = document.getElementById('btnPresetLight');
                if (btnDark) btnDark.classList.add('ring-2', 'ring-blue-500', 'ring-offset-1');
                if (btnLight) btnLight.classList.remove('ring-2', 'ring-blue-500', 'ring-offset-1');
            }

            applyStyles();
        });
    </script>
</body>
</html>
