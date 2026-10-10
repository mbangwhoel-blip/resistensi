<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Uji Resistensi Vektor - SIMPEL BBLKL</title>
    <style>
        @page {
            margin: 10mm 10mm 12mm 10mm;
            size: a4 landscape;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 8.5pt;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .kop-table td {
            vertical-align: middle;
            padding: 0;
        }
        .kop-logo {
            width: 75px;
            text-align: left;
        }
        .kop-logo img {
            max-width: 75px;
            max-height: 50px;
            height: auto;
        }
        .kop-text {
            text-align: center;
        }
        .kop-title-1 {
            font-size: 9pt;
            font-weight: bold;
            color: #334155;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .kop-title-2 {
            font-size: 8.5pt;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
        }
        .kop-title-main {
            font-size: 11pt;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-top: 1px;
            margin-bottom: 1px;
        }
        .kop-address {
            font-size: 7pt;
            color: #64748b;
        }
        .kop-divider {
            border-top: 2px solid #0f172a;
            border-bottom: 0.75px solid #0f172a;
            height: 2px;
            margin-top: 4px;
            margin-bottom: 8px;
        }

        /* Judul Laporan */
        .report-header {
            text-align: center;
            margin-bottom: 8px;
        }
        .report-title {
            font-size: 11pt;
            font-weight: 800;
            color: #0284c7;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .report-subtitle {
            font-size: 8pt;
            color: #64748b;
            font-weight: 500;
            margin-top: 1px;
        }

        /* Parameter & Info Box */
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
        }
        .info-grid td {
            padding: 4px 7px;
            font-size: 7.5pt;
            vertical-align: top;
        }
        .info-label {
            color: #64748b;
            font-weight: bold;
            width: 11%;
        }
        .info-val {
            color: #0f172a;
            font-weight: 600;
            width: 22%;
        }

        /* Statistik Summary Cards / Bar */
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .stats-table td {
            padding: 5px 8px;
            text-align: center;
            border: 1px solid #cbd5e1;
        }
        .stat-card-total {
            background-color: #f1f5f9;
        }
        .stat-card-resisten {
            background-color: #fef2f2;
            border-color: #fca5a5 !important;
        }
        .stat-card-toleran {
            background-color: #fffbeb;
            border-color: #fde68a !important;
        }
        .stat-card-rentan {
            background-color: #f0fdf4;
            border-color: #86efac !important;
        }
        .stat-number {
            font-size: 11pt;
            font-weight: 800;
            line-height: 1.1;
        }
        .stat-text {
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-top: 2px;
        }

        /* Tabel Data Utama */
        .data-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .data-table th {
            background-color: #0b132b;
            color: #ffffff;
            font-size: 7pt;
            font-weight: bold;
            text-align: center;
            padding: 5px 2px;
            border: 1px solid #0b132b;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            word-wrap: break-word;
            word-break: break-all;
            overflow: hidden;
        }
        .data-table td {
            font-size: 6.8pt;
            padding: 4px 2.5px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
            word-wrap: break-word;
            word-break: break-all;
            overflow: hidden;
            line-height: 1.25;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Badge Status */
        .badge {
            display: inline-block;
            padding: 1.5px 5px;
            border-radius: 3px;
            font-size: 6.8pt;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }
        .badge-resisten {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #f87171;
        }
        .badge-toleran {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fbbf24;
        }
        .badge-rentan {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #4ade80;
        }

        /* Tanda Tangan */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            page-break-inside: avoid;
        }
        .signature-table td {
            vertical-align: top;
            font-size: 8pt;
        }
        .sig-box {
            width: 250px;
            text-align: center;
            float: right;
        }

        /* Footer halaman */
        .footer-note {
            font-size: 6.8pt;
            color: #94a3b8;
            border-top: 1px dashed #cbd5e1;
            padding-top: 3px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT RESMI --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo BBLKL">
                @endif
            </td>
            <td class="kop-text">
                <div class="kop-title-1">KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</div>
                <div class="kop-title-2">DIREKTORAT JENDERAL PENCEGAHAN DAN PENGENDALIAN PENYAKIT</div>
                <div class="kop-title-main">BALAI BESAR LABORATORIUM KESEHATAN LINGKUNGAN</div>
                <div class="kop-address">
                    Sistem Informasi Manajemen Pemeriksaan Laboratorium (SIMPEL BBLKL) • Layanan Surveilans Vektor & Uji Resistensi
                </div>
            </td>
            <td style="width: 75px; text-align: right;">
                {{-- Spacer seimbang kanan --}}
            </td>
        </tr>
    </table>
    <div class="kop-divider"></div>

    {{-- JUDUL LAPORAN --}}
    <div class="report-header">
        <div class="report-title">LAPORAN HASIL UJI RESISTENSI INSEKTISIDA VEKTOR</div>
        <div class="report-subtitle">
            Dokumen Rekapitulasi Data Pengujian Resistensi Laboratorium Nasional
        </div>
    </div>

    {{-- PARAMETER FILTER AKTIF --}}
    <table class="info-grid">
        <tr>
            <td class="info-label">Provinsi:</td>
            <td class="info-val">{{ $filterInfo['provinsi'] }}</td>
            <td class="info-label">Tahun:</td>
            <td class="info-val">{{ $filterInfo['tahun'] }}</td>
            <td class="info-label">Jenis Nyamuk:</td>
            <td class="info-val">{{ $filterInfo['jenis_nyamuk'] }}</td>
        </tr>
        <tr>
            <td class="info-label">Kabupaten/Kota:</td>
            <td class="info-val">{{ $filterInfo['kabupaten'] }}</td>
            <td class="info-label">Bulan:</td>
            <td class="info-val">{{ $filterInfo['bulan'] }}</td>
            <td class="info-label">Insektisida:</td>
            <td class="info-val">{{ $filterInfo['insektisida'] }}</td>
        </tr>
        <tr>
            <td class="info-label">Status Uji:</td>
            <td class="info-val">{{ $filterInfo['status'] }}</td>
            <td class="info-label">Dicetak Pada:</td>
            <td class="info-val">{{ $filterInfo['dicetak_pada'] }}</td>
            <td class="info-label">Dicetak Oleh:</td>
            <td class="info-val">{{ $filterInfo['user'] }}</td>
        </tr>
    </table>

    {{-- STATISTIK HASIL PEMERIKSAAN --}}
    <table class="stats-table">
        <tr>
            <td class="stat-card-total" style="width: 20%;">
                <div class="stat-number" style="color: #0f172a;">{{ number_format($stats['total_pemeriksaan'], 0, ',', '.') }}</div>
                <div class="stat-text" style="color: #475569;">Total Pemeriksaan</div>
            </td>
            <td class="stat-card-total" style="width: 20%;">
                <div class="stat-number" style="color: #2563eb;">{{ number_format($stats['total_sampel'], 0, ',', '.') }}</div>
                <div class="stat-text" style="color: #1e40af;">Total Nyamuk Diuji</div>
            </td>
            <td class="stat-card-resisten" style="width: 20%;">
                <div class="stat-number" style="color: #dc2626;">
                    {{ number_format($stats['total_resisten'], 0, ',', '.') }}
                    <span style="font-size: 7.5pt; font-weight: normal; color: #b91c1c;">({{ $stats['persen_resisten'] }}%)</span>
                </div>
                <div class="stat-text" style="color: #991b1b;">Resisten</div>
            </td>
            <td class="stat-card-toleran" style="width: 20%;">
                <div class="stat-number" style="color: #d97706;">
                    {{ number_format($stats['total_toleran'], 0, ',', '.') }}
                    <span style="font-size: 7.5pt; font-weight: normal; color: #b45309;">({{ $stats['persen_toleran'] }}%)</span>
                </div>
                <div class="stat-text" style="color: #92400e;">Toleran / Terduga</div>
            </td>
            <td class="stat-card-rentan" style="width: 20%;">
                <div class="stat-number" style="color: #16a34a;">
                    {{ number_format($stats['total_rentan'], 0, ',', '.') }}
                    <span style="font-size: 7.5pt; font-weight: normal; color: #15803d;">({{ $stats['persen_rentan'] }}%)</span>
                </div>
                <div class="stat-text" style="color: #166534;">Rentan</div>
            </td>
        </tr>
    </table>

    {{-- TABEL DATA UTAMA --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 3.5%;">No</th>
                <th style="width: 7.5%;">Periode</th>
                <th style="width: 8.5%;">Provinsi</th>
                <th style="width: 9.5%;">Kabupaten / Kota</th>
                <th style="width: 9.5%;">Desa / Alamat</th>
                <th style="width: 8.5%;">Jenis Vektor</th>
                <th style="width: 11%;">Insektisida</th>
                <th style="width: 8%;">Metode</th>
                <th style="width: 5%;">Sampel</th>
                <th style="width: 7%;">Status</th>
                <th style="width: 5.5%;">Mutasi</th>
                <th style="width: 16.5%;">Publikasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataUji as $index => $row)
                @php
                    $statVal = strtolower((string)$row->status);
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center;">
                        {{ $row->bulan ? $row->bulan : '-' }} {{ $row->tahun }}
                    </td>
                    <td>{{ $row->provinsi ? $row->provinsi->nama_provinsi : '-' }}</td>
                    <td>{{ $row->kabupaten ? $row->kabupaten->nama_kabupaten : '-' }}</td>
                    <td>{{ $row->alamat ? $row->alamat : '-' }}</td>
                    <td style="font-style: italic;">{{ $row->jenis_nyamuk ?: '-' }}</td>
                    <td>{{ $row->insektisida ?: '-' }}</td>
                    <td style="text-align: center;">{{ $row->metode ?: '-' }}</td>
                    <td style="text-align: right; font-weight: bold;">
                        {{ $row->sampel_diperiksa ? number_format($row->sampel_diperiksa, 0, ',', '.') : '0' }}
                    </td>
                    <td style="text-align: center;">
                        @if($statVal === 'resisten')
                            <span class="badge badge-resisten">Resisten</span>
                        @elseif($statVal === 'toleran')
                            <span class="badge badge-toleran">Toleran</span>
                        @elseif($statVal === 'rentan')
                            <span class="badge badge-rentan">Rentan</span>
                        @else
                            <span class="badge">{{ ucfirst($statVal ?: '-') }}</span>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $row->mutasi ?: '-' }}</td>
                    <td style="font-size: 6.2pt; word-break: break-all; word-wrap: break-word; text-align: left;">
                        {{ $row->publikasi ?: '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" style="text-align: center; padding: 20px; color: #64748b; font-style: italic;">
                        Tidak ada data hasil uji resistensi yang sesuai dengan kriteria filter yang dipilih.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN / PENGESAHAN --}}
    <table class="signature-table">
        <tr>
            <td style="width: 65%;">
                <div class="footer-note">
                    * Dokumen laporan ini dicetak secara otomatis melalui Sistem Informasi Manajemen Pemeriksaan Laboratorium (SIMPEL BBLKL).<br>
                    * Data merupakan arsip resmi surveilans resistensi vektor Balai Besar Laboratorium Kesehatan Lingkungan - Kementerian Kesehatan RI.
                </div>
            </td>
            <td style="width: 35%; text-align: center;">
                <div style="font-size: 8pt; color: #475569; margin-bottom: 2px;">
                    Dicetak di BBLKL, {{ date('d F Y') }}
                </div>
                <div style="font-size: 8pt; font-weight: bold; color: #0f172a; margin-bottom: 45px;">
                    Penanggung Jawab Teknis Pengujian,
                </div>
                <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a; text-decoration: underline;">
                    {{ auth()->check() ? auth()->user()->name : 'Petugas Laboratorium' }}
                </div>
                <div style="font-size: 7.5pt; color: #64748b;">
                    NIP. .....................................................
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
