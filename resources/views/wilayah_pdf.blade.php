<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $tab === 'provinsi' ? 'Master Data Provinsi' : 'Master Data Kabupaten Kota' }} - PETA RESISTENSI</title>
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
            vertical-align: middle;
            padding: 0;
        }
        .kop-logo {
            width: 140px;
            text-align: left;
        }
        .kop-logo img {
            max-width: 140px;
            max-height: 50px;
            height: auto;
        }
        .kop-text {
            text-align: center;
        }
        .kop-title-1 {
            font-size: 8.5pt;
            font-weight: bold;
            color: #334155;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .kop-title-2 {
            font-size: 8pt;
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
            margin-top: 2px;
            margin-bottom: 2px;
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
            margin: 0 0 2px 0;
        }
        .doc-subtitle {
            font-size: 8pt;
            color: #475569;
            font-weight: normal;
            margin: 0;
        }

        /* INFO METADATA */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
        }
        .meta-table td {
            padding: 4px 8px;
            font-size: 7.5pt;
            vertical-align: top;
        }
        .meta-label {
            font-weight: bold;
            color: #475569;
            width: 18%;
        }
        .meta-value {
            color: #0f172a;
            width: 32%;
        }

        /* TABEL DATA */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 8pt;
        }
        .data-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-weight: bold;
            padding: 5px 6px;
            text-align: left;
            border: 1px solid #0f172a;
            font-size: 7.5pt;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .data-table td {
            padding: 4.5px 6px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .province-group-row td {
            background-color: #e2e8f0 !important;
            font-weight: bold;
            color: #0f172a;
            font-size: 8pt;
            padding: 4px 6px;
            text-transform: uppercase;
        }

        .badge-city {
            display: inline-block;
            padding: 1px 4px;
            font-size: 6.5pt;
            font-weight: bold;
            background-color: #e0e7ff;
            color: #3730a3;
            border-radius: 3px;
        }
        .badge-regency {
            display: inline-block;
            padding: 1px 4px;
            font-size: 6.5pt;
            font-weight: bold;
            background-color: #f1f5f9;
            color: #475569;
            border-radius: 3px;
        }

        /* TANDA TANGAN / PENGESAHAN */
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

        /* FOOTER NOMOR HALAMAN */
        .footer-note {
            font-size: 7pt;
            color: #64748b;
            font-style: italic;
            margin-top: 10px;
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT RESMI KEMENKES BBLKL --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="Logo BBLKL">
                @else
                    <div style="font-weight:bold; font-size:12pt; color:#0d9488;">KEMENKES RI</div>
                @endif
            </td>
            <td class="kop-text">
                <div class="kop-title-1">KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</div>
                <div class="kop-title-2">DIREKTORAT JENDERAL PENCEGAHAN DAN PENGENDALIAN PENYAKIT</div>
                <div class="kop-title-main">BALAI BESAR LABORATORIUM KESEHATAN LINGKUNGAN</div>
                <div class="kop-address">
                    Jl. Karang Menjangan No. 22, Surabaya 60285 • Telp: (031) 5021451 • Email: info@bblkl.kemkes.go.id • Web: bblkl.kemkes.go.id
                </div>
            </td>
        </tr>
    </table>
    <div class="kop-divider"></div>

    {{-- JUDUL LAPORAN --}}
    <div class="doc-header">
        <h1 class="doc-title">
            {{ $tab === 'provinsi' ? 'DAFTAR MASTER DATA PROVINSI REPUBLIK INDONESIA' : 'DAFTAR MASTER DATA KABUPATEN / KOTA REPUBLIK INDONESIA' }}
        </h1>
        <p class="doc-subtitle">
            Sistem Informasi Resistensi Insektisida Vektor Indonesia (PETA RESISTENSI) • Data Resmi Kemendagri
        </p>
    </div>

    {{-- KOTAK INFORMASI FILTER & DOKUMEN --}}
    <table class="meta-table">
        <tr>
            <td class="meta-label">Cakupan Wilayah:</td>
            <td class="meta-value"><strong>{{ $filterInfo['provinsi_nama'] }}</strong></td>
            <td class="meta-label">Tanggal Cetak:</td>
            <td class="meta-value">{{ $filterInfo['dicetak_pada'] }}</td>
        </tr>
        <tr>
            <td class="meta-label">Kategori Data:</td>
            <td class="meta-value">{{ $tab === 'provinsi' ? 'Master Provinsi (38 Provinsi)' : 'Master Kabupaten/Kota (514 Kab/Kota)' }}</td>
            <td class="meta-label">Dicetak Oleh:</td>
            <td class="meta-value">{{ $filterInfo['user'] }}</td>
        </tr>
        <tr>
            <td class="meta-label">Total Data Ditampilkan:</td>
            <td class="meta-value"><strong>{{ $filterInfo['total_terfilter'] }} Baris Wilayah</strong></td>
            <td class="meta-label">Status Data:</td>
            <td class="meta-value">Master Data Terverifikasi & Aktif</td>
        </tr>
    </table>

    {{-- TABEL DATA WILAYAH --}}
    @if ($tab === 'provinsi')
        {{-- TABEL PROVINSI --}}
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 30px; text-align: center;">No</th>
                    <th style="width: 45px; text-align: center;">ID</th>
                    <th>Nama Provinsi</th>
                    <th style="width: 110px; text-align: center;">Jumlah Kab/Kota</th>
                    <th style="width: 90px; text-align: center;">Data Uji Terkait</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $index => $prov)
                    <tr>
                        <td style="text-align: center; color: #64748b;">{{ $index + 1 }}</td>
                        <td style="text-align: center; font-weight: bold; color: #475569;">{{ $prov->id }}</td>
                        <td style="font-weight: bold; color: #0f172a;">{{ $prov->name ?? $prov->nama_provinsi }}</td>
                        <td style="text-align: center; font-weight: bold; color: #0284c7;">
                            {{ $prov->kabupatens_count }} Kab/Kota
                        </td>
                        <td style="text-align: center;">
                            {{ $prov->data_uji_resistensi_count ?? 0 }} Data
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 15px; color: #64748b;">
                            Tidak ada data provinsi yang sesuai dengan kriteria pencarian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @else
        {{-- TABEL KABUPATEN / KOTA --}}
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 28px; text-align: center;">No</th>
                    <th>Nama Kabupaten / Kota</th>
                    <th style="width: 140px;">Provinsi</th>
                    <th style="width: 65px; text-align: center;">Tipe</th>
                    <th style="width: 75px; text-align: right;">Latitude</th>
                    <th style="width: 75px; text-align: right;">Longitude</th>
                    <th style="width: 60px; text-align: center;">Data Uji</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $index => $kab)
                    @php
                        $isCity = str_starts_with(strtolower($kab->name), 'kota ');
                    @endphp
                    <tr>
                        <td style="text-align: center; color: #64748b;">{{ $index + 1 }}</td>
                        <td style="font-weight: 600; color: #0f172a;">
                            {{ $kab->name }}
                        </td>
                        <td style="color: #334155;">
                            {{ $kab->provinsi->name ?? '-' }}
                        </td>
                        <td style="text-align: center;">
                            @if ($isCity)
                                <span class="badge-city">KOTA</span>
                            @else
                                <span class="badge-regency">KAB</span>
                            @endif
                        </td>
                        <td style="text-align: right; font-family: monospace; font-size: 7.5pt; color: #475569;">
                            {{ $kab->latitude ? number_format((float)$kab->latitude, 4) : '-' }}
                        </td>
                        <td style="text-align: right; font-family: monospace; font-size: 7.5pt; color: #475569;">
                            {{ $kab->longitude ? number_format((float)$kab->longitude, 4) : '-' }}
                        </td>
                        <td style="text-align: center; font-weight: bold; color: {{ ($kab->data_uji_resistensi_count ?? 0) > 0 ? '#059669' : '#94a3b8' }};">
                            {{ $kab->data_uji_resistensi_count ?? 0 }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 15px; color: #64748b;">
                            Tidak ada data kabupaten/kota yang sesuai dengan kriteria pencarian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    {{-- BLOK PENGESAHAN / TANDA TANGAN RESMI --}}
    <table class="signature-table">
        <tr>
            <td style="width: 60%;">
                <div class="footer-note">
                    * Dokumen dicetak secara elektronik melalui Sistem Informasi Resistensi Insektisida Vektor Indonesia (PETA RESISTENSI).<br>
                    * Data mencakup 38 Provinsi dan 514 Kabupaten/Kota resmi Kementerian Dalam Negeri Republik Indonesia.
                </div>
            </td>
            <td style="width: 40%; text-align: center;">
                <div style="font-size: 8pt; color: #334155; margin-bottom: 50px;">
                    Salatiga, {{ date('d F Y') }}<br>
                    <strong>Kepala Balai Besar Laboratorium Kesehatan Lingkungan</strong>
                </div>
                <div style="font-size: 8.5pt; font-weight: bold; text-decoration: underline; color: #0f172a;">
                    Akhmad Saikhu, SKM, M.SC.PH
                </div>
                <div style="font-size: 7.5pt; color: #475569;">
                    NIP. 196805251992031004
                </div>
            </td>
        </tr>
    </table>

    {{-- DOMPDF NOMOR HALAMAN OTOMATIS --}}
    <script type="text/php">
        if (isset($pdf)) {
            $text = "Halaman {PAGE_NUM} dari {PAGE_COUNT} • Master Data Wilayah PETA RESISTENSI • BBLKL Kemenkes RI";
            $size = 7;
            $font = $fontMetrics->getFont("Helvetica");
            $width = $fontMetrics->get_text_width($text, $font, $size);
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 25;
            $pdf->page_text($x, $y, $text, $font, $size, array(0.4, 0.45, 0.5));
        }
    </script>

</body>
</html>
