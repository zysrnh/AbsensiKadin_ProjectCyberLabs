<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cetak ID Card Lanyard - Wonderful 2026</title>
    
    <!-- Google Fonts Multi-Family: Plus Jakarta Sans, Inter, Montserrat, Poppins, Roboto, Outfit, Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800;900&family=Playfair+Display:wght@400;600;700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert2 for Toast & Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --id-card-bg-color: {{ $idCardConfig['bg_color'] ?? '#ffffff' }};
            --id-card-bg-image: {{ !empty($idCardConfig['background_image']) ? 'url("' . $idCardConfig['background_image'] . '")' : 'none' }};
            --id-card-bg-opacity: {{ isset($idCardConfig['bg_opacity']) ? ($idCardConfig['bg_opacity'] / 100) : '1' }};
            --id-card-bg-size: {{ $idCardConfig['bg_size'] ?? 'cover' }};
            --id-card-bg-position: {{ $idCardConfig['bg_position'] ?? 'center' }};

            --id-card-font-family: '{{ $idCardConfig['font_family'] ?? 'Plus Jakarta Sans' }}', sans-serif;

            --id-name-size: {{ $idCardConfig['name_size'] ?? '22' }}px;
            --id-name-color: {{ $idCardConfig['name_color'] ?? '#020617' }};
            --id-name-weight: {{ $idCardConfig['name_weight'] ?? '900' }};
            --id-name-transform: {{ $idCardConfig['name_transform'] ?? 'uppercase' }};
            --id-name-margin-top: {{ $idCardConfig['name_margin_top'] ?? '0' }}px;

            --id-company-size: {{ $idCardConfig['company_size'] ?? '11' }}px;
            --id-company-color: {{ $idCardConfig['company_color'] ?? '#0f172a' }};
            --id-company-display: {{ (isset($idCardConfig['show_company']) && !$idCardConfig['show_company']) ? 'none' : 'inline-block' }};
            --id-company-style: {{ $idCardConfig['company_style'] ?? 'badge' }};

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
        }

        body {
            font-family: var(--id-card-font-family);
            background-color: #f1f5f9;
            color: #0f172a;
        }

        /* Ukuran standar ID Card Lanyard Plastik B3/B4 (95mm x 135mm) */
        .id-card-box {
            width: 95mm;
            height: 135mm;
            box-sizing: border-box;
            background-color: var(--id-card-bg-color);
            border: 1px solid #cbd5e1;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-family: var(--id-card-font-family);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        }

        /* Background image overlay layer */
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

        /* Content layer */
        .id-card-content-layer {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Content Wrapper */
        .id-card-middle-content {
            transform: translateY(var(--id-content-y-offset));
            text-align: var(--id-text-align);
            transition: transform 0.1s ease;
        }

        /* Dynamic styles applied from CSS variables */
        .id-card-lanyard-hole {
            display: var(--id-lanyard-display) !important;
        }
        .id-card-header-block {
            display: var(--id-header-display) !important;
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
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 3px 10px;
            border-radius: 4px;
        }
        .id-card-company.style-plain {
            background-color: transparent !important;
            border: none !important;
            padding: 0 !important;
        }
        .id-card-position {
            display: var(--id-position-display) !important;
            font-size: var(--id-position-size) !important;
            color: var(--id-position-color) !important;
        }
        .id-card-footer-block {
            display: var(--id-footer-display) !important;
        }

        /* Custom Scrollbar for Editor */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #94a3b8;
        }

        /* Print Settings: 1 Kartu per Halaman (Page Break per Card) */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }
            html, body {
                background: #ffffff !important;
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
                border: 1px dashed #94a3b8 !important; /* Garis panduan potong gunting */
                margin: 0 auto !important;
                background-color: var(--id-card-bg-color) !important;
            }
            .id-card-bg-layer {
                opacity: var(--id-card-bg-opacity) !important;
            }
        }
    </style>
</head>
<body class="min-h-screen">

    <!-- Top Action Toolbar (No-Print) -->
    <header class="no-print bg-slate-900 border-b border-slate-800 text-white sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3.5 flex flex-col md:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-3 w-full md:w-auto">
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white text-xs font-semibold rounded-none border border-slate-700 transition-colors flex items-center gap-1.5">
                    &larr; Dashboard
                </a>
                <div>
                    <h1 class="text-sm font-bold text-white tracking-wide">Format Cetak & Kustomisasi ID Card</h1>
                    <p class="text-[11px] text-slate-400">Total: <strong class="text-white">{{ count($participants) }} Peserta</strong> | Standar Lanyard B3/B4 (95mm × 135mm)</p>
                </div>
            </div>

            <div class="flex items-center gap-2 w-full md:w-auto justify-end flex-wrap">
                <!-- Toggle Editor Panel Button -->
                <button 
                    type="button" 
                    id="btnToggleEditor"
                    onclick="toggleEditorPanel()"
                    class="px-3.5 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white font-medium text-xs rounded-none border border-slate-700 transition-colors cursor-pointer"
                >
                    <span id="editorToggleText">Sembunyikan Panel Editor</span>
                </button>

                <!-- Tombol Reset Default -->
                <button 
                    type="button" 
                    onclick="resetSettings()" 
                    class="px-3.5 py-1.5 bg-slate-800 hover:bg-red-950 text-slate-300 hover:text-red-400 font-medium text-xs rounded-none border border-slate-700 hover:border-red-900 transition-colors cursor-pointer"
                >
                    Reset Default
                </button>

                <!-- Tombol Simpan Pengaturan -->
                <button 
                    type="button" 
                    id="btnSaveSettings"
                    onclick="saveSettings()" 
                    class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-none border border-blue-600 transition-colors cursor-pointer flex items-center gap-1.5"
                >
                    <span id="saveBtnText">Simpan Pengaturan</span>
                </button>

                <!-- Tombol Cetak Semua ID Card -->
                <button 
                    type="button" 
                    onclick="window.print()" 
                    class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-none border border-emerald-600 transition-colors cursor-pointer flex items-center gap-1.5"
                >
                    Cetak Semua ID Card
                </button>
            </div>
        </div>
    </header>

    <!-- Main Workspace: Editor Panel (Left) & Preview/Print Cards (Right) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 flex flex-col lg:flex-row gap-6 items-start">

        <!-- ========================================== -->
        <!-- LIVE CUSTOMIZER PANEL (No-Print)          -->
        <!-- ========================================== -->
        <aside id="editorPanel" class="no-print w-full lg:w-96 flex-shrink-0 bg-white border border-slate-300 shadow-sm rounded-none sticky top-20 max-h-[calc(100vh-6rem)] flex flex-col overflow-hidden">
            <!-- Header Panel -->
            <div class="bg-slate-100 border-b border-slate-200 px-4 py-3 flex items-center justify-between">
                <div>
                    <h2 class="text-xs font-black text-slate-900 uppercase tracking-wider">Editor Desain ID Card</h2>
                    <p class="text-[10px] text-slate-500">Live preview langsung terupdate</p>
                </div>
                <span class="text-[10px] bg-blue-100 text-blue-800 font-bold px-2 py-0.5 border border-blue-200">Kustomisasi</span>
            </div>

            <!-- Tab Buttons -->
            <div class="flex border-b border-slate-200 bg-slate-50 text-[11px] font-bold">
                <button type="button" onclick="switchTab('tab-bg')" id="btn-tab-bg" class="flex-1 py-2.5 text-center border-b-2 border-blue-600 text-blue-600 bg-white">
                    Background
                </button>
                <button type="button" onclick="switchTab('tab-text')" id="btn-tab-text" class="flex-1 py-2.5 text-center border-b-2 border-transparent text-slate-600 hover:text-slate-900">
                    Font & Teks
                </button>
                <button type="button" onclick="switchTab('tab-layout')" id="btn-tab-layout" class="flex-1 py-2.5 text-center border-b-2 border-transparent text-slate-600 hover:text-slate-900">
                    Posisi & Layout
                </button>
            </div>

            <!-- Tab Contents (Scrollable) -->
            <div class="p-4 overflow-y-auto custom-scrollbar flex-grow space-y-4 text-xs">

                <!-- ================= TAB 1: BACKGROUND ================= -->
                <div id="tab-bg" class="space-y-4">
                    <!-- Upload Custom Background Image -->
                    <div class="border border-slate-200 p-3 bg-slate-50">
                        <label class="block font-bold text-slate-800 mb-1">Gambar Background Kustom</label>
                        <p class="text-[10px] text-slate-500 mb-2 leading-relaxed">
                            Upload file desain ID card sendiri (dari Canva/Photoshop, rasio 95x135 mm).
                        </p>
                        
                        <div class="flex items-center gap-2">
                            <input 
                                type="file" 
                                id="inputBgImage" 
                                accept="image/png, image/jpeg, image/jpg" 
                                class="hidden" 
                                onchange="handleBgImageUpload(event)"
                            >
                            <button 
                                type="button" 
                                onclick="document.getElementById('inputBgImage').click()" 
                                class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs border border-slate-900"
                            >
                                Pilih Gambar
                            </button>
                            <button 
                                type="button" 
                                id="btnRemoveBg" 
                                onclick="removeBgImage()" 
                                class="px-3 py-1.5 bg-white hover:bg-red-50 text-red-600 font-semibold text-xs border border-red-200 {{ !empty($idCardConfig['background_image']) ? '' : 'hidden' }}"
                            >
                                Hapus Gambar
                            </button>
                        </div>

                        <!-- Image Preview Status -->
                        <div id="bgPreviewContainer" class="mt-2.5 {{ !empty($idCardConfig['background_image']) ? '' : 'hidden' }}">
                            <div class="flex items-center gap-2 text-[11px] text-slate-700 bg-white border border-slate-200 p-1.5">
                                <img id="bgPreviewThumb" src="{{ $idCardConfig['background_image'] ?? '' }}" alt="Thumb" class="w-8 h-10 object-cover border border-slate-200">
                                <span class="truncate flex-1 font-medium" id="bgFileName">Gambar background aktif</span>
                            </div>
                        </div>
                    </div>

                    <!-- Background Opacity Slider -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="sliderBgOpacity" class="font-bold text-slate-700">Transparansi / Opacity Gambar</label>
                            <span id="labelBgOpacity" class="font-mono text-slate-500 text-[11px]">{{ $idCardConfig['bg_opacity'] ?? 100 }}%</span>
                        </div>
                        <input 
                            type="range" 
                            id="sliderBgOpacity" 
                            min="10" 
                            max="100" 
                            value="{{ $idCardConfig['bg_opacity'] ?? 100 }}" 
                            oninput="updateBgOpacity(this.value)"
                            class="w-full h-1.5 bg-slate-200 accent-blue-600 cursor-pointer"
                        >
                    </div>

                    <!-- Background Display Mode -->
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Mode Pemasangan Gambar</label>
                        <select id="selectBgSize" onchange="updateBgSize(this.value)" class="w-full border border-slate-300 p-2 bg-white text-xs font-medium focus:border-blue-600 focus:outline-none">
                            <option value="cover" {{ ($idCardConfig['bg_size'] ?? 'cover') === 'cover' ? 'selected' : '' }}>Cover (Penuhi seluruh kartu)</option>
                            <option value="contain" {{ ($idCardConfig['bg_size'] ?? '') === 'contain' ? 'selected' : '' }}>Contain (Sesuai rasio asli)</option>
                            <option value="100% 100%" {{ ($idCardConfig['bg_size'] ?? '') === '100% 100%' ? 'selected' : '' }}>Stretch (Peregangan 100% 100%)</option>
                        </select>
                    </div>

                    <!-- Background Solid Color -->
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Warna Dasar Kartu</label>
                        <div class="flex items-center gap-2">
                            <input 
                                type="color" 
                                id="pickerBgColor" 
                                value="{{ $idCardConfig['bg_color'] ?? '#ffffff' }}" 
                                oninput="updateBgColor(this.value)"
                                class="w-8 h-8 p-0 border border-slate-300 cursor-pointer"
                            >
                            <input 
                                type="text" 
                                id="textBgColor" 
                                value="{{ $idCardConfig['bg_color'] ?? '#ffffff' }}" 
                                onchange="updateBgColor(this.value)"
                                class="flex-1 border border-slate-300 p-1.5 font-mono text-xs uppercase"
                            >
                        </div>
                        <!-- Quick Color Swatches -->
                        <div class="flex gap-1.5 mt-2">
                            <button type="button" onclick="updateBgColor('#ffffff')" class="w-5 h-5 bg-white border border-slate-400" title="Putih"></button>
                            <button type="button" onclick="updateBgColor('#0f172a')" class="w-5 h-5 bg-slate-900 border border-slate-700" title="Slate 900"></button>
                            <button type="button" onclick="updateBgColor('#1e3a8a')" class="w-5 h-5 bg-blue-900 border border-blue-950" title="Navy"></button>
                            <button type="button" onclick="updateBgColor('#fef3c7')" class="w-5 h-5 bg-amber-100 border border-amber-300" title="Krem"></button>
                            <button type="button" onclick="updateBgColor('#000000')" class="w-5 h-5 bg-black border border-slate-800" title="Hitam"></button>
                        </div>
                    </div>
                </div>

                <!-- ================= TAB 2: FONT & TEKS ================= -->
                <div id="tab-text" class="space-y-4 hidden">
                    <!-- Global Font Family -->
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Jenis Font (Font Family)</label>
                        <select id="selectFontFamily" onchange="updateFontFamily(this.value)" class="w-full border border-slate-300 p-2 bg-white text-xs font-semibold focus:border-blue-600 focus:outline-none">
                            <option value="Plus Jakarta Sans" {{ ($idCardConfig['font_family'] ?? 'Plus Jakarta Sans') === 'Plus Jakarta Sans' ? 'selected' : '' }}>Plus Jakarta Sans (Default)</option>
                            <option value="Montserrat" {{ ($idCardConfig['font_family'] ?? '') === 'Montserrat' ? 'selected' : '' }}>Montserrat (Tegas / Modern)</option>
                            <option value="Inter" {{ ($idCardConfig['font_family'] ?? '') === 'Inter' ? 'selected' : '' }}>Inter (Clean / Netral)</option>
                            <option value="Poppins" {{ ($idCardConfig['font_family'] ?? '') === 'Poppins' ? 'selected' : '' }}>Poppins (Elegan / Bulat)</option>
                            <option value="Roboto" {{ ($idCardConfig['font_family'] ?? '') === 'Roboto' ? 'selected' : '' }}>Roboto (Standar)</option>
                            <option value="Outfit" {{ ($idCardConfig['font_family'] ?? '') === 'Outfit' ? 'selected' : '' }}>Outfit (Futuristik)</option>
                            <option value="Playfair Display" {{ ($idCardConfig['font_family'] ?? '') === 'Playfair Display' ? 'selected' : '' }}>Playfair Display (Serif / Formal)</option>
                        </select>
                    </div>

                    <!-- Pengaturan Nama Peserta -->
                    <div class="border border-slate-200 p-3 bg-slate-50 space-y-3">
                        <span class="block font-black text-slate-900 text-[11px] uppercase tracking-wider border-b border-slate-200 pb-1">Nama Peserta</span>
                        
                        <!-- Slider Ukuran Font Nama -->
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <label for="sliderNameSize" class="font-bold text-slate-700">Ukuran Font Nama</label>
                                <span id="labelNameSize" class="font-mono text-slate-500 text-[11px]">{{ $idCardConfig['name_size'] ?? 22 }}px</span>
                            </div>
                            <input 
                                type="range" 
                                id="sliderNameSize" 
                                min="14" 
                                max="36" 
                                value="{{ $idCardConfig['name_size'] ?? 22 }}" 
                                oninput="updateNameSize(this.value)"
                                class="w-full h-1.5 bg-slate-200 accent-blue-600 cursor-pointer"
                            >
                        </div>

                        <!-- Warna Teks Nama -->
                        <div class="flex items-center justify-between">
                            <label class="font-bold text-slate-700">Warna Teks Nama</label>
                            <div class="flex items-center gap-1.5">
                                <input 
                                    type="color" 
                                    id="pickerNameColor" 
                                    value="{{ $idCardConfig['name_color'] ?? '#020617' }}" 
                                    oninput="updateNameColor(this.value)"
                                    class="w-6 h-6 p-0 border border-slate-300 cursor-pointer"
                                >
                                <span id="labelNameColorHex" class="font-mono text-[10px] text-slate-600 uppercase">{{ $idCardConfig['name_color'] ?? '#020617' }}</span>
                            </div>
                        </div>

                        <!-- Ketebalan & Format Huruf Nama -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Ketebalan</label>
                                <select id="selectNameWeight" onchange="updateNameWeight(this.value)" class="w-full border border-slate-300 p-1.5 bg-white text-[11px] font-medium">
                                    <option value="600" {{ ($idCardConfig['name_weight'] ?? '') === '600' ? 'selected' : '' }}>Semi-Bold (600)</option>
                                    <option value="700" {{ ($idCardConfig['name_weight'] ?? '') === '700' ? 'selected' : '' }}>Bold (700)</option>
                                    <option value="800" {{ ($idCardConfig['name_weight'] ?? '') === '800' ? 'selected' : '' }}>Extra Bold (800)</option>
                                    <option value="900" {{ ($idCardConfig['name_weight'] ?? '900') === '900' ? 'selected' : '' }}>Black (900)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Kapitalisasi</label>
                                <select id="selectNameTransform" onchange="updateNameTransform(this.value)" class="w-full border border-slate-300 p-1.5 bg-white text-[11px] font-medium">
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
                                <span id="labelNameMargin" class="font-mono text-slate-500 text-[11px]">{{ $idCardConfig['name_margin_top'] ?? 0 }}px</span>
                            </div>
                            <input 
                                type="range" 
                                id="sliderNameMargin" 
                                min="-20" 
                                max="40" 
                                value="{{ $idCardConfig['name_margin_top'] ?? 0 }}" 
                                oninput="updateNameMargin(this.value)"
                                class="w-full h-1.5 bg-slate-200 accent-blue-600 cursor-pointer"
                            >
                        </div>
                    </div>

                    <!-- Pengaturan Instansi / Perusahaan -->
                    <div class="border border-slate-200 p-3 bg-slate-50 space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-1">
                            <span class="font-black text-slate-900 text-[11px] uppercase tracking-wider">Instansi / Perusahaan</span>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    id="toggleShowCompany" 
                                    {{ (!isset($idCardConfig['show_company']) || $idCardConfig['show_company']) ? 'checked' : '' }} 
                                    onchange="updateToggleShowCompany(this.checked)"
                                    class="accent-blue-600"
                                >
                                <span class="text-[10px] font-semibold text-slate-600">Tampilkan</span>
                            </label>
                        </div>

                        <div id="companyControls" class="space-y-2.5 {{ (!isset($idCardConfig['show_company']) || $idCardConfig['show_company']) ? '' : 'opacity-40 pointer-events-none' }}">
                            <div class="flex justify-between items-center">
                                <label for="sliderCompanySize" class="font-bold text-slate-700">Ukuran Font</label>
                                <span id="labelCompanySize" class="font-mono text-slate-500 text-[11px]">{{ $idCardConfig['company_size'] ?? 11 }}px</span>
                            </div>
                            <input 
                                type="range" 
                                id="sliderCompanySize" 
                                min="8" 
                                max="18" 
                                value="{{ $idCardConfig['company_size'] ?? 11 }}" 
                                oninput="updateCompanySize(this.value)"
                                class="w-full h-1.5 bg-slate-200 accent-blue-600 cursor-pointer"
                            >

                            <div class="grid grid-cols-2 gap-2 pt-1">
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Tampilan</label>
                                    <select id="selectCompanyStyle" onchange="updateCompanyStyle(this.value)" class="w-full border border-slate-300 p-1.5 bg-white text-[11px] font-medium">
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
                                            class="w-full h-7 p-0 border border-slate-300 cursor-pointer"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengaturan Jabatan -->
                    <div class="border border-slate-200 p-3 bg-slate-50 space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-1">
                            <span class="font-black text-slate-900 text-[11px] uppercase tracking-wider">Jabatan Peserta</span>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    id="toggleShowPosition" 
                                    {{ (!isset($idCardConfig['show_position']) || $idCardConfig['show_position']) ? 'checked' : '' }} 
                                    onchange="updateToggleShowPosition(this.checked)"
                                    class="accent-blue-600"
                                >
                                <span class="text-[10px] font-semibold text-slate-600">Tampilkan</span>
                            </label>
                        </div>

                        <div id="positionControls" class="space-y-2.5 {{ (!isset($idCardConfig['show_position']) || $idCardConfig['show_position']) ? '' : 'opacity-40 pointer-events-none' }}">
                            <div class="flex justify-between items-center">
                                <label for="sliderPositionSize" class="font-bold text-slate-700">Ukuran Font</label>
                                <span id="labelPositionSize" class="font-mono text-slate-500 text-[11px]">{{ $idCardConfig['position_size'] ?? 11 }}px</span>
                            </div>
                            <input 
                                type="range" 
                                id="sliderPositionSize" 
                                min="8" 
                                max="18" 
                                value="{{ $idCardConfig['position_size'] ?? 11 }}" 
                                oninput="updatePositionSize(this.value)"
                                class="w-full h-1.5 bg-slate-200 accent-blue-600 cursor-pointer"
                            >

                            <div class="flex items-center justify-between pt-1">
                                <label class="font-bold text-slate-700">Warna Teks Jabatan</label>
                                <input 
                                    type="color" 
                                    id="pickerPositionColor" 
                                    value="{{ $idCardConfig['position_color'] ?? '#64748b' }}" 
                                    oninput="updatePositionColor(this.value)"
                                    class="w-6 h-6 p-0 border border-slate-300 cursor-pointer"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= TAB 3: POSISI & LAYOUT ================= -->
                <div id="tab-layout" class="space-y-4 hidden">
                    
                    <!-- Vertical Offset Slider (Paling penting untuk align dengan template custom!) -->
                    <div class="border border-blue-200 bg-blue-50/50 p-3">
                        <div class="flex justify-between items-center mb-1">
                            <label for="sliderContentY" class="font-black text-slate-900 text-xs">Geser Posisi Teks Naik/Turun</label>
                            <span id="labelContentY" class="font-mono font-bold text-blue-700 text-xs">{{ $idCardConfig['content_y_offset'] ?? 0 }}px</span>
                        </div>
                        <p class="text-[10px] text-slate-500 mb-2">
                            Paskan posisi nama & jabatan dengan area kosong gambar background template Anda.
                        </p>
                        <input 
                            type="range" 
                            id="sliderContentY" 
                            min="-80" 
                            max="80" 
                            value="{{ $idCardConfig['content_y_offset'] ?? 0 }}" 
                            oninput="updateContentY(this.value)"
                            class="w-full h-2 bg-slate-200 accent-blue-600 cursor-pointer"
                        >
                        <div class="flex justify-between text-[9px] text-slate-400 mt-1 font-mono">
                            <span>-80px (Naik)</span>
                            <span>0px (Netral)</span>
                            <span>+80px (Turun)</span>
                        </div>
                    </div>

                    <!-- Text Alignment -->
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Perataan Teks Konten</label>
                        <div class="grid grid-cols-3 gap-1.5">
                            <button 
                                type="button" 
                                onclick="updateTextAlign('left')" 
                                id="btnAlignLeft"
                                class="py-1.5 border border-slate-300 font-semibold text-xs {{ ($idCardConfig['text_align'] ?? 'center') === 'left' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700' }}"
                            >
                                Rata Kiri
                            </button>
                            <button 
                                type="button" 
                                onclick="updateTextAlign('center')" 
                                id="btnAlignCenter"
                                class="py-1.5 border border-slate-300 font-semibold text-xs {{ ($idCardConfig['text_align'] ?? 'center') === 'center' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700' }}"
                            >
                                Rata Tengah
                            </button>
                            <button 
                                type="button" 
                                onclick="updateTextAlign('right')" 
                                id="btnAlignRight"
                                class="py-1.5 border border-slate-300 font-semibold text-xs {{ ($idCardConfig['text_align'] ?? 'center') === 'right' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700' }}"
                            >
                                Rata Kanan
                            </button>
                        </div>
                    </div>

                    <!-- Toggle Komponen Bawaan (Matikan jika template background sudah punya desain sendiri) -->
                    <div class="border border-slate-200 p-3 bg-slate-50 space-y-2.5">
                        <span class="block font-black text-slate-900 text-[11px] uppercase tracking-wider border-b border-slate-200 pb-1">
                            Toggle Elemen Bawaan
                        </span>
                        <p class="text-[10px] text-slate-500 leading-normal">
                            Bila menggunakan template background lengkap dari canva, sembunyikan elemen bawaan di bawah ini:
                        </p>

                        <!-- Toggle Lubang Lanyard -->
                        <label class="flex items-center justify-between cursor-pointer py-1 border-b border-slate-200/60">
                            <span class="text-xs font-semibold text-slate-700">Lubang Tali Lanyard</span>
                            <input 
                                type="checkbox" 
                                id="toggleLanyard" 
                                {{ (!isset($idCardConfig['show_lanyard_hole']) || $idCardConfig['show_lanyard_hole']) ? 'checked' : '' }} 
                                onchange="updateToggleElement('lanyard', this.checked)"
                                class="accent-blue-600"
                            >
                        </label>

                        <!-- Toggle Header Acara -->
                        <label class="flex items-center justify-between cursor-pointer py-1 border-b border-slate-200/60">
                            <span class="text-xs font-semibold text-slate-700">Header Atas Acara</span>
                            <input 
                                type="checkbox" 
                                id="toggleHeader" 
                                {{ (!isset($idCardConfig['show_header']) || $idCardConfig['show_header']) ? 'checked' : '' }} 
                                onchange="updateToggleElement('header', this.checked)"
                                class="accent-blue-600"
                            >
                        </label>

                        <!-- Toggle Pita Kategori -->
                        <div class="py-1 border-b border-slate-200/60 space-y-2">
                            <label class="flex items-center justify-between cursor-pointer">
                                <span class="text-xs font-semibold text-slate-700">Pita Kategori Peserta</span>
                                <input 
                                    type="checkbox" 
                                    id="toggleRibbon" 
                                    {{ (!isset($idCardConfig['show_ribbon']) || $idCardConfig['show_ribbon']) ? 'checked' : '' }} 
                                    onchange="updateToggleElement('ribbon', this.checked)"
                                    class="accent-blue-600"
                                >
                            </label>
                            
                            <!-- Ribbon Color Picker -->
                            <div id="ribbonColorControl" class="flex items-center justify-between pl-2 {{ (!isset($idCardConfig['show_ribbon']) || $idCardConfig['show_ribbon']) ? '' : 'hidden' }}">
                                <span class="text-[11px] text-slate-500">Warna Pita:</span>
                                <div class="flex items-center gap-1.5">
                                    <input 
                                        type="color" 
                                        id="pickerRibbonBg" 
                                        value="{{ $idCardConfig['ribbon_bg'] ?? '#2563eb' }}" 
                                        oninput="updateRibbonBg(this.value)"
                                        class="w-5 h-5 p-0 border border-slate-300 cursor-pointer"
                                    >
                                    <button type="button" onclick="updateRibbonBg('#2563eb')" class="w-4 h-4 bg-blue-600" title="Biru"></button>
                                    <button type="button" onclick="updateRibbonBg('#dc2626')" class="w-4 h-4 bg-red-600" title="Merah"></button>
                                    <button type="button" onclick="updateRibbonBg('#d97706')" class="w-4 h-4 bg-amber-600" title="Emas"></button>
                                    <button type="button" onclick="updateRibbonBg('#0f172a')" class="w-4 h-4 bg-slate-900" title="Hitam"></button>
                                </div>
                            </div>
                        </div>

                        <!-- Toggle Garis Pemisah -->
                        <label class="flex items-center justify-between cursor-pointer py-1 border-b border-slate-200/60">
                            <span class="text-xs font-semibold text-slate-700">Garis Pemisah (Divider)</span>
                            <input 
                                type="checkbox" 
                                id="toggleDivider" 
                                {{ (!isset($idCardConfig['show_divider']) || $idCardConfig['show_divider']) ? 'checked' : '' }} 
                                onchange="updateToggleElement('divider', this.checked)"
                                class="accent-blue-600"
                            >
                        </label>

                        <!-- Toggle Footer Bawah -->
                        <label class="flex items-center justify-between cursor-pointer py-1">
                            <span class="text-xs font-semibold text-slate-700">Footer Bawah Acara</span>
                            <input 
                                type="checkbox" 
                                id="toggleFooter" 
                                {{ (!isset($idCardConfig['show_footer']) || $idCardConfig['show_footer']) ? 'checked' : '' }} 
                                onchange="updateToggleElement('footer', this.checked)"
                                class="accent-blue-600"
                            >
                        </label>
                    </div>

                </div>

            </div>

            <!-- Footer Panel: Status & Actions -->
            <div class="p-3 bg-slate-100 border-t border-slate-200 flex items-center justify-between text-[11px]">
                <span id="saveStatusIndicator" class="text-slate-500 font-medium">Siap dicetak</span>
                <button 
                    type="button" 
                    onclick="saveSettings()" 
                    class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white font-bold"
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
                        
                        <!-- Layer Background Image Kustom (Opacity terisolasi di layer ini) -->
                        <div class="id-card-bg-layer"></div>

                        <!-- Layer Konten Teks & Elemen Kartu -->
                        <div class="id-card-content-layer">
                            
                            <!-- 1. Top Section: Lubang Lanyard, Header, dan Pita -->
                            <div>
                                <!-- Lubang Tali Lanyard Guide -->
                                <div class="id-card-lanyard-hole w-full pt-3 pb-1 flex flex-col items-center justify-center">
                                    <div class="w-10 h-2 border border-slate-300 rounded-full bg-slate-100 flex items-center justify-center">
                                        <span class="w-3 h-0.5 bg-slate-300 rounded-full"></span>
                                    </div>
                                </div>

                                <!-- Header Organisasi -->
                                <div class="id-card-header-block px-5 pt-2 pb-2.5 text-center">
                                    <span class="text-[9px] font-black tracking-widest text-slate-400 uppercase block">EXECUTIVE ROUNDTABLE</span>
                                    <h2 class="text-sm font-black tracking-tight text-slate-900 uppercase mt-0.5">WONDERFUL 2026</h2>
                                </div>

                                <!-- Pita Kategori Peserta -->
                                <div class="id-card-ribbon text-center py-1.5 px-4 font-black text-xs tracking-wider uppercase">
                                    {{ !empty($p->position) && str_contains(strtolower($p->position), 'ketua') ? 'TAMU KEHORMATAN' : 'PESERTA' }}
                                </div>
                            </div>

                            <!-- 2. Middle Section: Nama, Instansi, Jabatan (Konten Utama) -->
                            <div class="id-card-middle-content px-6 py-4 flex-grow flex flex-col justify-center items-center">
                                
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
                <div class="w-full text-center py-16 text-slate-500 bg-white border border-slate-200 p-8">
                    Tidak ada data peserta untuk dicetak.
                </div>
                @endforelse
            </div>

        </main>
    </div>

    <!-- Live Customization Script -->
    <script>
        // State Konfigurasi
        const state = {
            bg_color: "{{ $idCardConfig['bg_color'] ?? '#ffffff' }}",
            background_image: "{{ $idCardConfig['background_image'] ?? '' }}",
            bg_opacity: {{ $idCardConfig['bg_opacity'] ?? 100 }},
            bg_size: "{{ $idCardConfig['bg_size'] ?? 'cover' }}",
            bg_position: "{{ $idCardConfig['bg_position'] ?? 'center' }}",
            font_family: "{{ $idCardConfig['font_family'] ?? 'Plus Jakarta Sans' }}",
            name_size: {{ $idCardConfig['name_size'] ?? 22 }},
            name_color: "{{ $idCardConfig['name_color'] ?? '#020617' }}",
            name_weight: "{{ $idCardConfig['name_weight'] ?? '900' }}",
            name_transform: "{{ $idCardConfig['name_transform'] ?? 'uppercase' }}",
            name_margin_top: {{ $idCardConfig['name_margin_top'] ?? 0 }},
            show_company: {{ (!isset($idCardConfig['show_company']) || $idCardConfig['show_company']) ? 'true' : 'false' }},
            company_size: {{ $idCardConfig['company_size'] ?? 11 }},
            company_color: "{{ $idCardConfig['company_color'] ?? '#0f172a' }}",
            company_style: "{{ $idCardConfig['company_style'] ?? 'badge' }}",
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
        };

        // File object jika ada file baru diupload
        let pendingBgFile = null;

        // Tab Switching
        function switchTab(tabId) {
            ['tab-bg', 'tab-text', 'tab-layout'].forEach(id => {
                const el = document.getElementById(id);
                const btn = document.getElementById('btn-' + id);
                if (id === tabId) {
                    el.classList.remove('hidden');
                    btn.classList.add('border-blue-600', 'text-blue-600', 'bg-white');
                    btn.classList.remove('border-transparent', 'text-slate-600');
                } else {
                    el.classList.add('hidden');
                    btn.classList.remove('border-blue-600', 'text-blue-600', 'bg-white');
                    btn.classList.add('border-transparent', 'text-slate-600');
                }
            });
        }

        // Toggle Panel Editor
        function toggleEditorPanel() {
            const panel = document.getElementById('editorPanel');
            const text = document.getElementById('editorToggleText');
            if (panel.classList.contains('hidden')) {
                panel.classList.remove('hidden');
                text.innerText = 'Sembunyikan Panel Editor';
            } else {
                panel.classList.add('hidden');
                text.innerText = 'Buka Panel Editor';
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

            root.style.setProperty('--id-name-size', `${state.name_size}px`);
            root.style.setProperty('--id-name-color', state.name_color);
            root.style.setProperty('--id-name-weight', state.name_weight);
            root.style.setProperty('--id-name-transform', state.name_transform);
            root.style.setProperty('--id-name-margin-top', `${state.name_margin_top}px`);

            root.style.setProperty('--id-company-size', `${state.company_size}px`);
            root.style.setProperty('--id-company-color', state.company_color);
            root.style.setProperty('--id-company-display', state.show_company ? 'inline-block' : 'none');

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
        }

        // Live Handlers: Background
        function handleBgImageUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            pendingBgFile = file;
            const reader = new FileReader();
            reader.onload = function(e) {
                state.background_image = e.target.result;
                document.getElementById('bgPreviewThumb').src = e.target.result;
                document.getElementById('bgFileName').innerText = file.name;
                document.getElementById('bgPreviewContainer').classList.remove('hidden');
                document.getElementById('btnRemoveBg').classList.remove('hidden');
                applyStyles();
            };
            reader.readAsDataURL(file);
        }

        function removeBgImage() {
            pendingBgFile = null;
            state.background_image = '';
            document.getElementById('inputBgImage').value = '';
            document.getElementById('bgPreviewContainer').classList.add('hidden');
            document.getElementById('btnRemoveBg').classList.add('hidden');
            applyStyles();
        }

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
                    btn.classList.add('bg-slate-900', 'text-white', 'border-slate-900');
                    btn.classList.remove('bg-white', 'text-slate-700');
                } else {
                    btn.classList.remove('bg-slate-900', 'text-white', 'border-slate-900');
                    btn.classList.add('bg-white', 'text-slate-700');
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

        // ====================================================
        // SAVE & RESET ACTIONS
        // ====================================================
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

                // Append file if newly uploaded
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
            applyStyles();
        });
    </script>
</body>
</html>
