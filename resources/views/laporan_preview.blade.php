<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pratinjau Cetak Laporan Hasil Uji Resistensi - PETA RESISTENSI</title>

    {{-- FAVICON RESISTENSI (LOGO KEMENKES) --}}
    <link rel="icon" type="image/png" href="{{ asset('kemenkes.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('kemenkes.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('kemenkes.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: #0f172a;
            color: #1e293b;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Lembar Kertas Dokumen */
        .sheet-container {
            width: 297mm;
            min-height: 210mm;
            margin: 20px auto 40px auto;
            background: #ffffff;
            padding: 12mm 14mm;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45);
            border-radius: 6px;
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
            width: 175px;
            text-align: left;
        }
        .kop-logo img {
            max-width: 175px;
            max-height: 60px;
            height: auto;
            display: block;
        }
        .kop-text {
            text-align: center;
        }
        .kop-title-1 {
            font-size: 10pt;
            font-weight: bold;
            color: #334155;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .kop-title-2 {
            font-size: 9pt;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
        }
        .kop-title-main {
            font-size: 12.5pt;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-top: 2px;
            margin-bottom: 2px;
        }
        .kop-address {
            font-size: 7.5pt;
            color: #64748b;
        }
        .kop-divider {
            border-top: 2.5px solid #0f172a;
            border-bottom: 1px solid #0f172a;
            height: 3px;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        /* Judul Laporan */
        .report-header {
            text-align: center;
            margin-bottom: 10px;
        }
        .report-title {
            font-size: 12pt;
            font-weight: 800;
            color: #0284c7;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .report-subtitle {
            font-size: 8.5pt;
            color: #64748b;
            font-weight: 500;
            margin-top: 2px;
        }

        /* Parameter & Info Box */
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }
        .info-grid td {
            padding: 5px 8px;
            font-size: 8pt;
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
            margin-bottom: 10px;
        }
        .stats-table td {
            padding: 6px 10px;
            text-align: center;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
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
            font-size: 12pt;
            font-weight: 800;
            line-height: 1.1;
        }
        .stat-text {
            font-size: 7.5pt;
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
            margin-bottom: 14px;
        }
        .data-table th {
            background-color: #0b132b;
            color: #ffffff;
            font-size: 7.5pt;
            font-weight: bold;
            text-align: center;
            padding: 6px 3px;
            border: 1px solid #0b132b;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            word-wrap: break-word;
            word-break: break-all;
            overflow: hidden;
        }
        .data-table td {
            font-size: 7pt;
            padding: 5px 3.5px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
            word-wrap: break-word;
            word-break: break-all;
            overflow: hidden;
            line-height: 1.3;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Badge Status */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 7pt;
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
            margin-top: 10px;
            page-break-inside: avoid;
        }
        .signature-table td {
            vertical-align: top;
            font-size: 8pt;
        }

        /* Footer halaman */
        .footer-note {
            font-size: 7pt;
            color: #94a3b8;
            border-top: 1px dashed #cbd5e1;
            padding-top: 4px;
            margin-top: 10px;
        }

        /* PENGATURAN CETAK (PRINT MEDIA QUERY) */
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }
            .no-print {
                display: none !important;
            }
            .sheet-container {
                width: 100% !important;
                min-height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            @page {
                size: a4 landscape;
                margin: 10mm 10mm 12mm 10mm;
            }
        }
    </style>
</head>
<body>

    {{-- TOOLBAR ATAS (DILINDUNGI DARI INTERSEP IDM KARENA HALAMAN INI TEXT/HTML) --}}
    <div class="no-print sticky top-0 z-50 bg-slate-900/95 backdrop-blur-md border-b border-slate-800 px-6 py-3.5 flex items-center justify-between shadow-xl">
        <div class="flex items-center gap-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-white font-black text-sm shadow-sm">
                📄
            </span>
            <div>
                <h1 class="text-sm font-extrabold text-white leading-tight">
                    Pratinjau Cetak Laporan
                </h1>
                <p class="text-[11px] text-slate-400">
                    Dokumen siap ditinjau atau dicetak langsung
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            {{-- TOMBOL PRINT BROWSER (BEBAS DARI INTERSEP IDM) --}}
            <button type="button"
                    onclick="window.print()"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 px-5 py-2 text-xs font-bold text-white shadow-md transition cursor-pointer">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Simpan PDF (Ctrl+P)</span>
            </button>

            {{-- TOMBOL UNDUH PDF ASLI JIKA TETAP INGIN MENDOWNLOAD FILE --}}
            <a href="{{ route('laporan.pdf', array_merge(request()->query(), ['mode' => 'download'])) }}"
               class="inline-flex items-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-500 px-4 py-2 text-xs font-bold text-white shadow-md transition cursor-pointer">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Unduh File PDF</span>
            </a>

            {{-- TOMBOL KEMBALI KE FILTER --}}
            <a href="{{ route('laporan.index', request()->query()) }}"
               class="inline-flex items-center gap-1.5 rounded-xl border border-slate-700 bg-slate-800 hover:bg-slate-700 px-3.5 py-2 text-xs font-semibold text-slate-200 transition cursor-pointer">
                <span>✕ Tutup Pratinjau</span>
            </a>
        </div>
    </div>

    {{-- DOKUMEN RESMI (LEMBAR KERTAS A4 LANDSCAPE) --}}
    <div class="sheet-container">

        {{-- KOP SURAT RESMI --}}
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="{{ asset('logo_bblkl.png') }}" alt="Logo BBLKL">
                </td>
                <td class="kop-text">
                    <div class="kop-title-1">KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</div>
                    <div class="kop-title-2">DIREKTORAT JENDERAL KESEHATAN PRIMER DAN KOMUNITAS</div>
                    <div class="kop-title-main">BALAI BESAR LABORATORIUM KESEHATAN LINGKUNGAN</div>
                    <div class="kop-address">
                        Sistem Informasi Resistensi Insektisida Indonesia • Layanan Surveilans Vektor & Uji Resistensi
                    </div>
                </td>
                <td style="width: 175px; text-align: right;">
                    {{-- Spacer kanan --}}
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
                        <span style="font-size: 8pt; font-weight: normal; color: #b91c1c;">({{ $stats['persen_resisten'] }}%)</span>
                    </div>
                    <div class="stat-text" style="color: #991b1b;">Resisten</div>
                </td>
                <td class="stat-card-toleran" style="width: 20%;">
                    <div class="stat-number" style="color: #d97706;">
                        {{ number_format($stats['total_toleran'], 0, ',', '.') }}
                        <span style="font-size: 8pt; font-weight: normal; color: #b45309;">({{ $stats['persen_toleran'] }}%)</span>
                    </div>
                    <div class="stat-text" style="color: #92400e;">Toleran / Terduga</div>
                </td>
                <td class="stat-card-rentan" style="width: 20%;">
                    <div class="stat-number" style="color: #16a34a;">
                        {{ number_format($stats['total_rentan'], 0, ',', '.') }}
                        <span style="font-size: 8pt; font-weight: normal; color: #15803d;">({{ $stats['persen_rentan'] }}%)</span>
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
                    <th style="width: 14%;">Kab/Prov</th>
                    <th style="width: 11%;">Alamat / Lokasi</th>
                    <th style="width: 9%;">Jenis Nyamuk</th>
                    <th style="width: 11%;">Insektisida</th>
                    <th style="width: 8%;">Metode</th>
                    <th style="width: 5%;">Sampel</th>
                    <th style="width: 7%;">Status</th>
                    <th style="width: 8%;">Periode</th>
                    <th style="width: 6.5%;">Mutasi</th>
                    <th style="width: 17%;">Publikasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataUji as $index => $row)
                    @php
                        $statVal = strtolower((string)$row->status);
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $row->kabupaten ? $row->kabupaten->nama_kabupaten : '-' }}</strong>
                            <div style="font-size: 7pt; color: #64748b;">{{ ($row->kabupaten && $row->kabupaten->provinsi) ? $row->kabupaten->provinsi->nama_provinsi : ($row->provinsi ? $row->provinsi->nama_provinsi : '-') }}</div>
                        </td>
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
                        <td style="text-align: center;">
                            <strong>{{ $row->bulan ? $row->bulan : '-' }}</strong>
                            <div style="font-size: 7pt; color: #64748b;">{{ $row->tahun }}</div>
                        </td>
                        <td style="text-align: center;">{{ $row->mutasi ?: '-' }}</td>
                        <td style="font-size: 6.5pt; word-break: break-all; word-wrap: break-word; text-align: left;">
                            @if($row->publikasi && str_starts_with($row->publikasi, 'http'))
                                <a href="{{ $row->publikasi }}" target="_blank" class="text-blue-600 hover:underline">
                                    {{ $row->publikasi }}
                                </a>
                            @else
                                {{ $row->publikasi ?: '-' }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" style="text-align: center; padding: 25px; color: #64748b; font-style: italic;">
                            Tidak ada data hasil uji resistensi yang sesuai dengan kriteria filter yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- KETERANGAN STATUS RESISTENSI STANDAR KEMENKES RI / WHO --}}
        <div style="margin-top: 14px; margin-bottom: 12px; padding: 8px 12px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 7.5pt; color: #334155;">
            <div style="font-weight: bold; margin-bottom: 4px; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px;">
                Keterangan Kategori Status Resistensi Vektor (Standar Kemenkes RI / WHO):
            </div>
            <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                <div><strong style="color: #e11d48;">■ RESISTEN</strong> : Persentase kematian &lt; 90% (Populasi vektor telah kebal/resisten terhadap insektisida).</div>
                <div><strong style="color: #d97706;">■ TOLERAN / TERDUGA RESISTEN</strong> : Persentase kematian 90% - 97% (Indikasi toleransi/resisten, perlu pengujian konfirmasi).</div>
                <div><strong style="color: #059669;">■ RENTAN</strong> : Persentase kematian 98% - 100% (Insektisida masih efektif membunuh vektor).</div>
            </div>
        </div>

        {{-- TANDA TANGAN / PENGESAHAN --}}
        <table class="signature-table">
            <tr>
                <td style="width: 65%;">
                    <div class="footer-note">
                        * Dokumen laporan ini dicetak secara otomatis melalui Sistem Informasi Resistensi Insektisida Indonesia.<br>
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

    </div>

</body>
</html>
