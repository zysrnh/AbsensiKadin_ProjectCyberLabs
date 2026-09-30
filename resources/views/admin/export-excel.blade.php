<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--[if gte mso 9]>
<xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name>Laporan Presensi C-Level</x:Name>
    <x:WorksheetOptions>
     <x:DisplayGridlines/>
     <x:Print>
      <x:ValidPrinterInfo/>
      <x:PaperSizeIndex>9</x:PaperSizeIndex>
      <x:HorizontalResolution>600</x:HorizontalResolution>
      <x:VerticalResolution>600</x:VerticalResolution>
     </x:Print>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
 </x:ExcelWorkbook>
</xml>
<![endif]-->
<style>
  body {
    font-family: 'Segoe UI', Calibri, Arial, sans-serif;
    color: #0F172A;
  }
  table {
    border-collapse: collapse;
    width: 100%;
  }
  .title-main {
    background-color: #0F172A;
    color: #FFFFFF;
    font-size: 15pt;
    font-weight: bold;
    text-align: center;
    vertical-align: middle;
    height: 40px;
    border: 1px solid #0F172A;
  }
  .title-sub {
    background-color: #1E293B;
    color: #CBD5E1;
    font-size: 10pt;
    text-align: center;
    vertical-align: middle;
    height: 24px;
    border: 1px solid #1E293B;
  }
  .stat-head {
    background-color: #E2E8F0;
    color: #334155;
    font-size: 9pt;
    font-weight: bold;
    text-align: center;
    border: 1px solid #CBD5E1;
    padding: 6px;
  }
  .stat-val {
    background-color: #FFFFFF;
    color: #0F172A;
    font-size: 11pt;
    font-weight: bold;
    text-align: center;
    border: 1px solid #CBD5E1;
    padding: 6px;
  }
  .th-header {
    background-color: #2563EB;
    color: #FFFFFF;
    font-size: 10pt;
    font-weight: bold;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #1D4ED8;
    height: 32px;
    padding: 6px 8px;
  }
  .td-row {
    font-size: 10pt;
    border: 1px solid #CBD5E1;
    vertical-align: middle;
    padding: 6px 8px;
  }
  .td-zebra {
    background-color: #F8FAFC;
    font-size: 10pt;
    border: 1px solid #CBD5E1;
    vertical-align: middle;
    padding: 6px 8px;
  }
  .text-center {
    text-align: center;
  }
  .text-bold {
    font-weight: bold;
  }
  .text-mono {
    font-family: 'Consolas', 'Courier New', monospace;
    font-weight: bold;
    mso-number-format: "\@";
  }
  .text-phone {
    mso-number-format: "\@";
    text-align: left;
  }
  .badge-attended {
    background-color: #DCFCE7;
    color: #15803D;
    font-weight: bold;
    text-align: center;
    border: 1px solid #86EFAC;
  }
  .badge-unattended {
    background-color: #F1F5F9;
    color: #64748B;
    text-align: center;
    border: 1px solid #CBD5E1;
  }
  .badge-rsvp-attending {
    background-color: #D1FAE5;
    color: #047857;
    font-weight: bold;
    text-align: center;
    border: 1px solid #6EE7B7;
  }
  .badge-rsvp-declined {
    background-color: #FFE4E6;
    color: #BE123C;
    font-weight: bold;
    text-align: center;
    border: 1px solid #FDA4AF;
  }
  .badge-rsvp-pending {
    background-color: #FEF3C7;
    color: #B45309;
    text-align: center;
    border: 1px solid #FCD34D;
  }
</style>
</head>
<body>

<table>
    <!-- Judul Header Utama -->
    <tr>
        <td colspan="12" class="title-main">
            LAPORAN PRESENSI PESERTA — C LEVEL INDONESIA 2026
        </td>
    </tr>
    <tr>
        <td colspan="12" class="title-sub">
            Acara: {{ $eventSettings['title'] }} | Tanggal Ekspor: {{ now()->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB
        </td>
    </tr>
    <tr>
        <td colspan="12" style="height: 12px;"></td>
    </tr>

    <!-- Ringkasan Statistik Singkat -->
    <tr>
        <td colspan="3" class="stat-head">TOTAL PENDAFTAR</td>
        <td colspan="3" class="stat-head">HADIR DI LOKASI</td>
        <td colspan="3" class="stat-head">BELUM HADIR</td>
        <td colspan="3" class="stat-head">TINGKAT KEHADIRAN</td>
    </tr>
    <tr>
        <td colspan="3" class="stat-val">{{ number_format($stats['total']) }} Orang</td>
        <td colspan="3" class="stat-val" style="color: #15803D;">{{ number_format($stats['attended']) }} Orang</td>
        <td colspan="3" class="stat-val" style="color: #64748B;">{{ number_format($stats['unattended']) }} Orang</td>
        <td colspan="3" class="stat-val" style="color: #2563EB;">{{ $stats['rate'] }}%</td>
    </tr>
    <tr>
        <td colspan="12" style="height: 14px;"></td>
    </tr>

    <!-- Header Kolom Data -->
    <thead>
        <tr>
            <th class="th-header" style="width: 45px;">No</th>
            <th class="th-header" style="width: 120px;">Kode Tiket QR</th>
            <th class="th-header" style="width: 220px;">Nama Lengkap</th>
            <th class="th-header" style="width: 200px;">Instansi / Perusahaan</th>
            <th class="th-header" style="width: 160px;">Jabatan</th>
            <th class="th-header" style="width: 140px;">Nomor WhatsApp</th>
            <th class="th-header" style="width: 180px;">Email</th>
            <th class="th-header" style="width: 130px;">Status Presensi</th>
            <th class="th-header" style="width: 150px;">Waktu Presensi</th>
            <th class="th-header" style="width: 150px;">Status RSVP</th>
            <th class="th-header" style="width: 150px;">Waktu RSVP</th>
            <th class="th-header" style="width: 150px;">Waktu Pendaftaran</th>
        </tr>
    </thead>

    <!-- Isi Data Baris -->
    <tbody>
        @forelse($participants as $index => $p)
            @php
                $isZebra = $index % 2 === 1;
                $rowClass = $isZebra ? 'td-zebra' : 'td-row';
            @endphp
            <tr>
                <td class="{{ $rowClass }} text-center">{{ $index + 1 }}</td>
                <td class="{{ $rowClass }} text-mono text-center">{{ $p->qr_token }}</td>
                <td class="{{ $rowClass }} text-bold">{{ $p->name }}</td>
                <td class="{{ $rowClass }}">{{ $p->company ?? '-' }}</td>
                <td class="{{ $rowClass }}">{{ $p->position ?? '-' }}</td>
                <td class="{{ $rowClass }} text-phone">{{ $p->phone }}</td>
                <td class="{{ $rowClass }}">{{ $p->email ?? '-' }}</td>
                
                <!-- Status Presensi -->
                @if($p->status === 'attended')
                    <td class="{{ $rowClass }} badge-attended">HADIR</td>
                @else
                    <td class="{{ $rowClass }} badge-unattended">BELUM HADIR</td>
                @endif

                <td class="{{ $rowClass }} text-center">
                    {{ $p->attended_at ? $p->attended_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') : '-' }}
                </td>

                <!-- Status RSVP -->
                @if($p->rsvp_status === 'attending')
                    <td class="{{ $rowClass }} badge-rsvp-attending">KONFIRMASI HADIR</td>
                @elseif($p->rsvp_status === 'declined')
                    <td class="{{ $rowClass }} badge-rsvp-declined">BERHALANGAN</td>
                @else
                    <td class="{{ $rowClass }} badge-rsvp-pending">MENUNGGU</td>
                @endif

                <td class="{{ $rowClass }} text-center">
                    {{ $p->rsvp_at ? $p->rsvp_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') : '-' }}
                </td>
                <td class="{{ $rowClass }} text-center">
                    {{ $p->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="12" class="td-row text-center" style="padding: 20px; color: #94A3B8;">
                    Tidak ada data peserta yang ditemukan.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
