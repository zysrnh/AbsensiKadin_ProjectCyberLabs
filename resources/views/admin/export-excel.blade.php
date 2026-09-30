<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Kehadiran Peserta</title>
<style>
  body {
    font-family: 'Segoe UI', Calibri, Arial, sans-serif;
    color: #0F172A;
  }
  table {
    border-collapse: collapse;
    width: 100%;
  }
  /* Banner Header Utama */
  .title-main {
    background-color: #0F172A;
    color: #FFFFFF;
    font-size: 14pt;
    font-weight: bold;
    text-align: center;
    vertical-align: middle;
    height: 38px;
    border: 1px solid #0F172A;
  }
  .title-sub {
    background-color: #1E293B;
    color: #CBD5E1;
    font-size: 9pt;
    text-align: center;
    vertical-align: middle;
    height: 24px;
    border: 1px solid #1E293B;
  }

  /* Ringkasan Statistik */
  .stat-label {
    background-color: #F1F5F9;
    color: #475569;
    font-size: 9pt;
    font-weight: bold;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #CBD5E1;
    height: 24px;
  }
  .stat-val {
    background-color: #FFFFFF;
    color: #0F172A;
    font-size: 11pt;
    font-weight: bold;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #CBD5E1;
    height: 28px;
  }

  /* Header Kolom Tabel */
  .th-col {
    background-color: #1E293B;
    color: #FFFFFF;
    font-size: 10pt;
    font-weight: bold;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #0F172A;
    height: 32px;
    padding: 6px 10px;
    white-space: nowrap;
  }

  /* Baris Data */
  .td-data {
    font-size: 10pt;
    border: 1px solid #CBD5E1;
    vertical-align: middle;
    padding: 6px 12px;
    height: 28px;
  }
  .td-zebra {
    background-color: #F8FAFC;
    font-size: 10pt;
    border: 1px solid #CBD5E1;
    vertical-align: middle;
    padding: 6px 12px;
    height: 28px;
  }

  .text-center {
    text-align: center;
  }
  .text-bold {
    font-weight: bold;
  }
  .nowrap {
    white-space: nowrap;
  }

  /* Badge Presensi */
  .badge-attended {
    background-color: #DCFCE7;
    color: #15803D;
    font-weight: bold;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #86EFAC;
    white-space: nowrap;
  }
  .badge-unattended {
    background-color: #F1F5F9;
    color: #64748B;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #CBD5E1;
    white-space: nowrap;
  }
</style>
</head>
<body>

<table>
    <!-- 1. Header Banner Acara -->
    <tr>
        <td colspan="6" class="title-main">
            LAPORAN PRESENSI KEHADIRAN PESERTA
        </td>
    </tr>
    <tr>
        <td colspan="6" class="title-sub">
            Kegiatan: {{ $eventSettings['title'] }} | Dicetak: {{ now()->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB
        </td>
    </tr>
    <tr>
        <td colspan="6" style="height: 10px;"></td>
    </tr>

    <!-- 2. Ringkasan Kehadiran Eksekutif -->
    <tr>
        <td colspan="1" class="stat-label">TOTAL PESERTA</td>
        <td colspan="2" class="stat-label">HADIR DI LOKASI</td>
        <td colspan="2" class="stat-label">BELUM HADIR</td>
        <td colspan="1" class="stat-label">PERSENTASE</td>
    </tr>
    <tr>
        <td colspan="1" class="stat-val">{{ number_format($stats['total']) }} Orang</td>
        <td colspan="2" class="stat-val" style="color: #15803D;">{{ number_format($stats['attended']) }} Orang</td>
        <td colspan="2" class="stat-val" style="color: #64748B;">{{ number_format($stats['unattended']) }} Orang</td>
        <td colspan="1" class="stat-val" style="color: #2563EB;">{{ $stats['rate'] }}%</td>
    </tr>
    <tr>
        <td colspan="6" style="height: 12px;"></td>
    </tr>

    <!-- 3. Header 6 Kolom Utama -->
    <thead>
        <tr>
            <th class="th-col" style="width: 45px;" width="45">No</th>
            <th class="th-col" style="width: 240px; text-align: left;" width="240">Nama Lengkap</th>
            <th class="th-col" style="width: 220px; text-align: left;" width="220">Instansi / Perusahaan</th>
            <th class="th-col" style="width: 180px; text-align: left;" width="180">Jabatan</th>
            <th class="th-col" style="width: 140px;" width="140">Status Kehadiran</th>
            <th class="th-col" style="width: 160px;" width="160">Waktu Hadir</th>
        </tr>
    </thead>

    <!-- 4. Baris Data Peserta -->
    <tbody>
        @forelse($participants as $index => $p)
            @php
                $isZebra = $index % 2 === 1;
                $rowClass = $isZebra ? 'td-zebra' : 'td-data';
            @endphp
            <tr>
                <!-- No -->
                <td class="{{ $rowClass }} text-center nowrap">
                    {{ $index + 1 }}
                </td>

                <!-- Nama Lengkap -->
                <td class="{{ $rowClass }} text-bold nowrap">
                    {{ $p->name }}
                </td>

                <!-- Instansi / Perusahaan -->
                <td class="{{ $rowClass }} nowrap">
                    {{ $p->company ?? '-' }}
                </td>

                <!-- Jabatan -->
                <td class="{{ $rowClass }} nowrap">
                    {{ $p->position ?? '-' }}
                </td>

                <!-- Status Kehadiran (Hadir apa Ngga) -->
                @if($p->status === 'attended')
                    <td class="{{ $rowClass }} badge-attended">
                        HADIR
                    </td>
                @else
                    <td class="{{ $rowClass }} badge-unattended">
                        BELUM HADIR
                    </td>
                @endif

                <!-- Jam Kehadiran -->
                <td class="{{ $rowClass }} text-center nowrap">
                    @if($p->status === 'attended' && $p->attended_at)
                        {{ $p->attended_at->timezone('Asia/Jakarta')->format('H:i:s') }} WIB
                    @else
                        -
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="td-data text-center" style="padding: 24px; color: #94A3B8;">
                    Tidak ada data peserta yang ditemukan.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
