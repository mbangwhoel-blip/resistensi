<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Data Parameter Uji - PETA RESISTENSI</title>
    <style>
        @page {
            margin: 12mm 12mm 16mm 12mm;
            size: a4 portrait;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 8.5pt;
            line-height: 1.35;
            margin: 0;
            padding: 0;
        }

        /* KOP SURAT */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .kop-table td {
            vertical-align: top;
            padding: 0;
        }
        .kop-logo {
            width: 110px;
            text-align: left;
        }
        .kop-logo img {
            max-width: 110px;
            max-height: 48px;
            height: auto;
        }
        .kop-text {
            text-align: center;
        }
        .kop-spacer {
            width: 110px;
        }
        .kop-title-1 {
            font-size: 8.5pt;
            font-weight: bold;
            color: #334155;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .kop-title-2 {
            font-size: 7.5pt;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
        }
        .kop-title-main {
            font-size: 10.5pt;
            font-weight: 800;
            color: #047857;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 2px;
            margin-bottom: 2px;
        }
        .kop-address {
            font-size: 6.8pt;
            color: #64748b;
            line-height: 1.3;
        }
        .kop-divider {
            border-top: 2px solid #0f172a;
            border-bottom: 0.75px solid #0f172a;
            height: 2px;
            margin-top: 4px;
            margin-bottom: 10px;
        }

        /* JUDUL DOKUMEN */
        .doc-header {
            text-align: center;
            margin-bottom: 12px;
        }
        .doc-title {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        /* INFO METADATA */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .meta-table td {
            padding: 4px 8px;
            font-size: 7.5pt;
            border: 1px solid #e2e8f0;
        }
        .meta-label {
            font-weight: bold;
            color: #475569;
            width: 25%;
        }
        .meta-value {
            color: #0f172a;
            width: 25%;
        }

        /* TABEL DATA */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5pt;
            margin-bottom: 16px;
        }
        .content-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-weight: bold;
            padding: 5px 6px;
            border: 1px solid #0f172a;
            text-transform: uppercase;
            font-size: 7pt;
            text-align: left;
        }
        .content-table td {
            padding: 4.5px 6px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }
        .content-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* BLOK TANDA TANGAN */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            page-break-inside: avoid;
        }
        .signature-table td {
            vertical-align: top;
            padding: 0;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if (!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="Logo BBLKL">
                @endif
            </td>
            <td class="kop-text">
                <div class="kop-title-1">KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</div>
                <div class="kop-title-2">DIREKTORAT JENDERAL KESEHATAN PRIMER DAN KOMUNITAS</div>
                <div class="kop-title-main">BALAI BESAR LABORATORIUM KESEHATAN LINGKUNGAN</div>
                <div class="kop-address">
                    Jl. Hasanudin No. 123, Mangunsari, Sidomukti, Kota Salatiga, Jawa Tengah 50721<br>
                    Telepon: (0298) 327096 | Faksimile: (0298) 327097 | Surat Elektronik: bblkl.salatiga@kemkes.go.id<br>
                    Laman Resmi: https://bblabkesling.go.id/ &bull; SI-RESISTENSI INDONESIA
                </div>
            </td>
            <td class="kop-spacer"></td>
        </tr>
    </table>
    <div class="kop-divider"></div>

    {{-- JUDUL DOKUMEN --}}
    <div class="doc-header">
        <h1 class="doc-title">DAFTAR MASTER DATA PARAMETER UJI RESISTENSI INSEKTISIDA</h1>
    </div>

    {{-- METADATA --}}
    <table class="meta-table">
        <tr>
            <td class="meta-label">Kategori Parameter:</td>
            <td class="meta-value">{{ $filterInfo['tab_label'] }}</td>
            <td class="meta-label">Tanggal Cetak:</td>
            <td class="meta-value">{{ $filterInfo['dicetak_pada'] }}</td>
        </tr>
        <tr>
            <td class="meta-label">Total Data:</td>
            <td class="meta-value"><strong>{{ $filterInfo['total_terfilter'] }} Parameter</strong></td>
            <td class="meta-label">Petugas:</td>
            <td class="meta-value">{{ $filterInfo['user'] }}</td>
        </tr>
    </table>

    {{-- TABEL PARAMETER --}}
    <table class="content-table">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 22%;">Kategori</th>
                <th style="width: 33%;">Nama Parameter / Senyawa</th>
                <th style="width: 30%;">Keterangan &amp; Spesifikasi</th>
                <th style="width: 10%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $item)
                <tr>
                    <td style="text-align: center; font-weight: bold; color: #64748b;">
                        {{ $index + 1 }}
                    </td>
                    <td>
                        @php
                            $katText = match($item->category ?? $item->kategori) {
                                'nyamuk' => 'Jenis Nyamuk',
                                'insektisida' => 'Insektisida',
                                'metode' => 'Metode Pengujian',
                                default => 'Parameter'
                            };
                        @endphp
                        {{ $katText }}
                    </td>
                    <td>
                        <strong>{{ $item->name ?? $item->nama }}</strong>
                    </td>
                    <td style="color: #475569;">
                        {{ $item->description ?? $item->keterangan ?? '-' }}
                    </td>
                    <td style="text-align: center; font-weight: bold; color: {{ ($item->is_active ?? true) ? '#047857' : '#94a3b8' }};">
                        {{ ($item->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 15px; color: #94a3b8;">
                        Tidak ada data parameter uji yang terdaftar.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <table class="signature-table">
        <tr>
            <td style="width: 58%; font-size: 7.2pt; color: #64748b; line-height: 1.4;">
                * Dokumen ini merupakan rekapitulasi data resmi Parameter Uji Resistensi Insektisida Vektor Indonesia (PETA RESISTENSI).<br>
                * Standar nomenklatur vektor, formulasi insektisida, dan metode bioassay mengacu pada pedoman teknis World Health Organization (WHO) &amp; Permenkes RI.
            </td>
            <td style="width: 42%; text-align: center;">
                <div style="font-size: 8pt; color: #334155;">Salatiga, {{ date('d F Y') }}</div>
                <div style="font-size: 8pt; font-weight: bold; color: #0f172a; margin-top: 2px;">
                    Kepala Balai Besar Laboratorium<br>Kesehatan Lingkungan
                </div>
                <div style="height: 50px;"></div>
                <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a; text-decoration: underline;">
                    Akhmad Saikhu, SKM, M.SC.PH
                </div>
                <div style="font-size: 7.5pt; color: #475569;">
                    NIP. 196805251992031004
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
