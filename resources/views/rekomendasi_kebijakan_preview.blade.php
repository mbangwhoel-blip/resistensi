<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policy Brief Rekomendasi Kebijakan Vektor - {{ $namaWilayah }} - PETA RESISTENSI</title>

    {{-- FAVICON --}}
    <link rel="icon" type="image/png" href="{{ asset('kemenkes.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('kemenkes.png') }}">

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

        /* Lembar Kertas Dokumen Formal */
        .sheet-container {
            width: 210mm;
            min-height: 297mm;
            margin: 24px auto 40px auto;
            background: #ffffff;
            padding: 16mm 18mm;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45);
            border-radius: 6px;
        }

        /* Kop Surat Resmi BBLKL */
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
            width: 135px;
            text-align: left;
            vertical-align: top;
            padding-top: 1px;
        }
        .kop-logo img {
            max-width: 135px;
            max-height: 48px;
            height: auto;
            display: block;
            margin: 0;
        }
        .kop-text {
            text-align: center;
            vertical-align: top;
            padding: 0 4px;
        }
        .kop-spacer {
            width: 135px;
            text-align: right;
            vertical-align: top;
        }
        .kop-title-1 {
            font-size: 9.2pt;
            font-weight: 700;
            color: #334155;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            white-space: nowrap;
            line-height: 1.25;
            margin: 0;
        }
        .kop-title-2 {
            font-size: 8.2pt;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            white-space: nowrap;
            line-height: 1.25;
            margin: 1px 0;
        }
        .kop-title-main {
            font-size: 10.5pt;
            font-weight: 800;
            color: #047857;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            white-space: nowrap;
            line-height: 1.25;
            margin: 1px 0 2px 0;
        }
        .kop-address {
            font-size: 7.2pt;
            color: #64748b;
            line-height: 1.35;
            margin-top: 2px;
        }
        .kop-divider {
            border-top: 2.5px solid #047857;
            border-bottom: 1px solid #0f172a;
            height: 3px;
            margin-top: 6px;
            margin-bottom: 14px;
        }

        /* Judul Dokumen Policy Brief */
        .doc-header {
            text-align: center;
            margin-bottom: 14px;
        }
        .doc-badge {
            display: inline-block;
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            border-radius: 9999px;
            font-size: 7pt;
            font-weight: 800;
            padding: 2px 10px;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .doc-title {
            font-size: 11.5pt;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            line-height: 1.35;
        }
        .doc-meta {
            font-size: 8pt;
            color: #64748b;
            margin-top: 2px;
        }

        /* Tabel Parameter Metadata */
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }
        .info-grid td {
            padding: 5px 10px;
            font-size: 8pt;
            vertical-align: middle;
            border-bottom: 1px solid #edf2f7;
        }
        .info-label {
            color: #64748b;
            font-weight: 700;
            width: 18%;
        }
        .info-sep {
            width: 2%;
            color: #94a3b8;
            font-weight: 600;
        }
        .info-val {
            color: #0f172a;
            font-weight: 700;
            width: 30%;
        }

        /* Alert Status Banner */
        .alert-banner {
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 14px;
            border-left: 5px solid;
            page-break-inside: avoid;
        }
        .alert-banner-kritis {
            background-color: #fef2f2;
            border-color: #dc2626;
            color: #991b1b;
        }
        .alert-banner-waspada {
            background-color: #fffbeb;
            border-color: #d97706;
            color: #92400e;
        }
        .alert-banner-terkendali {
            background-color: #f0fdf4;
            border-color: #16a34a;
            color: #166534;
        }

        /* Statistik Cards */
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            page-break-inside: avoid;
        }
        .stats-table td {
            padding: 6px 8px;
            text-align: center;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            width: 25%;
        }
        .stat-val {
            font-size: 13pt;
            font-weight: 800;
            line-height: 1.1;
        }
        .stat-lbl {
            font-size: 7.2pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-top: 2px;
        }

        /* Visualisasi Grafik Inline Policy Brief */
        .chart-box {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background-color: #f8fafc;
            padding: 9px 12px;
            margin-bottom: 12px;
            page-break-inside: avoid;
        }
        .chart-box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
        }
        .chart-box-title {
            font-size: 7.8pt;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .chart-box-desc {
            font-size: 6.8pt;
            color: #64748b;
            font-weight: 600;
        }
        .spectrum-bar {
            width: 100%;
            height: 18px;
            border-radius: 4px;
            overflow: hidden;
            display: flex;
            background-color: #e2e8f0;
            margin-bottom: 5px;
        }
        .spectrum-seg {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 6.8pt;
            font-weight: 800;
            color: #ffffff;
            white-space: nowrap;
        }
        .chart-legend {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 6.8pt;
            color: #475569;
            margin-top: 4px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 2px;
            display: inline-block;
        }
        .chem-chart-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
            font-size: 7pt;
        }
        .chem-name-col {
            width: 25%;
            font-weight: 700;
            color: #0f172a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .chem-bar-col {
            flex: 1;
            height: 13px;
            border-radius: 3px;
            overflow: hidden;
            display: flex;
            background-color: #e2e8f0;
        }
        .chem-stat-col {
            width: 18%;
            text-align: right;
            font-size: 6.8pt;
            font-weight: 700;
        }

        /* Section Title */
        .sec-title {
            font-size: 9pt;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-bottom: 1.5px solid #0f172a;
            padding-bottom: 3px;
            margin-top: 14px;
            margin-bottom: 8px;
            page-break-inside: avoid;
            page-break-after: avoid;
        }

        /* Tabel Data Formatted */
        .doc-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            page-break-inside: auto;
        }
        .doc-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 7.5pt;
            font-weight: 700;
            text-align: center;
            padding: 5px 6px;
            border: 1px solid #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.2px;
        }
        .doc-table td {
            font-size: 7.2pt;
            padding: 4.5px 6px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
            line-height: 1.3;
        }
        .doc-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .doc-table tr {
            page-break-inside: avoid;
        }

        /* Badges */
        .badge-pill {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 6.8pt;
            font-weight: 800;
            text-transform: uppercase;
            text-align: center;
        }
        .badge-moratorium {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #f87171;
        }
        .badge-pengawasan {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fbbf24;
        }
        .badge-rekomendasi {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #4ade80;
        }

        /* Kotak Aksi Kebijakan */
        .action-box {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 10px;
            margin-bottom: 8px;
            background-color: #fafafa;
            page-break-inside: avoid;
        }
        .action-box-title {
            font-size: 8pt;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .action-box-list {
            margin: 0;
            padding-left: 18px;
            font-size: 7.5pt;
            color: #334155;
            line-height: 1.45;
        }
        .action-box-list li {
            margin-bottom: 3px;
        }

        /* Tanda Tangan Resmi */
        .sig-container {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            page-break-inside: avoid;
        }
        .sig-container td {
            vertical-align: top;
            font-size: 8pt;
            padding: 0 10px;
        }

        /* Footer Halaman */
        .doc-footer {
            margin-top: 18px;
            padding-top: 6px;
            border-top: 1px dashed #cbd5e1;
            font-size: 6.8pt;
            color: #94a3b8;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* CETAK (MEDIA PRINT) */
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
                size: A4 portrait;
                margin: 12mm 14mm 14mm 14mm;
            }
        }
    </style>
</head>
<body>

    {{-- TOOLBAR ATAS (HANYA DITAMPILKAN DI LAYAR, DISEMBUNYIKAN SAAT CETAK) --}}
    <div class="no-print sticky top-0 z-50 bg-slate-900/95 backdrop-blur-md border-b border-slate-800 px-6 py-3.5 flex items-center justify-between shadow-xl">
        <div class="flex items-center gap-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-600 text-white font-black text-sm shadow-sm">
                🛡️
            </span>
            <div>
                <h1 class="text-sm font-extrabold text-white leading-tight">
                    Pratinjau Lembar Rekomendasi Kebijakan (Policy Brief)
                </h1>
                <p class="text-[11px] text-slate-400">
                    Cakupan: <strong class="text-teal-300">{{ $namaWilayah }}</strong> &bull; Periode: {{ $tahunFilter }} &bull; Target: {{ $nyamukFilter }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            {{-- TOMBOL KEMBALI KE DASHBOARD --}}
            <a href="{{ route('rekomendasi.index', request()->all()) }}"
               class="inline-flex items-center gap-1.5 rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-2 text-xs font-bold text-slate-200 hover:bg-slate-700 hover:text-white transition cursor-pointer">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>

            {{-- TOMBOL CETAK / SIMPAN PDF BROWSER --}}
            <button type="button"
                    onclick="window.print()"
                    class="inline-flex items-center gap-2 rounded-xl bg-teal-600 hover:bg-teal-500 px-5 py-2 text-xs font-bold text-white shadow-md transition cursor-pointer active:scale-95">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak Dokumen (Ctrl+P)</span>
            </button>
        </div>
    </div>

    {{-- KONTEN LEMBAR DOKUMEN RESMI --}}
    <div class="sheet-container">

        {{-- 1. KOP SURAT RESMI KEMENKES BBLKL SALATIGA --}}
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="{{ asset('logo_bblkl.png') }}" alt="Logo BBLKL Kemenkes RI" onerror="this.src='{{ asset('kemenkes.png') }}'">
                </td>
                <td class="kop-text">
                    <div class="kop-title-1">KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</div>
                    <div class="kop-title-2">DIREKTORAT JENDERAL KESEHATAN PRIMER DAN KOMUNITAS</div>
                    <div class="kop-title-main">BALAI BESAR LABORATORIUM KESEHATAN LINGKUNGAN SALATIGA</div>
                    <div class="kop-address">
                        Jl. Hasanudin No. 123, Mangunsari, Sidomukti, Kota Salatiga, Jawa Tengah 50721<br>
                        Telepon: (0298) 327096 | Faksimile: (0298) 327097 | Surat Elektronik: bblkl.salatiga@kemkes.go.id<br>
                        Laman Resmi: https://bblabkesling.go.id/ &bull; SI-RESISTENSI INDONESIA
                    </div>
                </td>
                <td class="kop-spacer">
                    {{-- Spacer kanan penyeimbang simetris --}}
                </td>
            </tr>
        </table>

        <div class="kop-divider"></div>

        {{-- 2. JUDUL DOKUMEN POLICY BRIEF --}}
        <div class="doc-header">
            <span class="doc-badge">LEMBAR REKOMENDASI KEBIJAKAN RESMI (POLICY BRIEF)</span>
            <h2 class="doc-title">
                STRATEGI PENGENDALIAN VEKTOR TERPADU & ROTASI INSEKTISIDA BERBASIS KERENTANAN BIOASSAY
            </h2>
            <div class="doc-meta">
                Nomor Registrasi: <strong>PB-VEC/BBLKL/{{ date('Y') }}/{{ strtoupper(substr(md5($namaWilayah . $tahunFilter . $nyamukFilter), 0, 7)) }}</strong> &bull; Klasifikasi: Standar Operasional Pengendalian Vektor
            </div>
        </div>

        {{-- 3. PARAMETER & METADATA EVALUASI --}}
        <table class="info-grid">
            <tr>
                <td class="info-label">Cakupan Wilayah</td>
                <td class="info-sep">:</td>
                <td class="info-val">{{ $namaWilayah }}</td>

                <td class="info-label">Periode Surveilans</td>
                <td class="info-sep">:</td>
                <td class="info-val">{{ $tahunFilter === 'Semua' ? 'Semua Periode Tercatat' : 'Tahun Anggaran ' . $tahunFilter }}</td>
            </tr>
            <tr>
                <td class="info-label">Spesies Target</td>
                <td class="info-sep">:</td>
                <td class="info-val">{{ $nyamukFilter === 'Semua' ? 'Seluruh Spesies Vektor Uji' : $nyamukFilter }}</td>

                <td class="info-label">Tanggal Terbit</td>
                <td class="info-sep">:</td>
                <td class="info-val">{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</td>
            </tr>
        </table>

        {{-- 4. STATUS INDEKS KEWASPADAAN VEKTOR (ALERT LEVEL) --}}
        @php
            $alertClass = 'alert-banner-kritis';
            if ($alertLevel === 'WASPADA') {
                $alertClass = 'alert-banner-waspada';
            } elseif ($alertLevel === 'TERKENDALI') {
                $alertClass = 'alert-banner-terkendali';
            }
        @endphp
        <div class="alert-banner {{ $alertClass }}">
            <div class="flex items-center justify-between mb-1">
                <span class="text-[8pt] font-extrabold uppercase tracking-wide">
                    STATUS TINGKAT KESIAPSIAGAAN (ALERT LEVEL): <strong>{{ $alertBadge }}</strong>
                </span>
                <span class="text-[7.2pt] font-bold">
                    Standar Referensi: WHO Vector Resistance Monitoring & Kemenkes RI
                </span>
            </div>
            <p class="text-[7.8pt] font-medium leading-relaxed m-0">
                {{ $alertSummary }}
            </p>
            @if(!empty($catatanBukti))
                <div class="text-[6.8pt] mt-1 pt-1 border-t border-current/20 italic opacity-90">
                    💡 {{ $catatanBukti }}
                </div>
            @endif
        </div>

        {{-- 5. KARTU STATISTIK KERENTANAN --}}
        <table class="stats-table">
            <tr>
                <td style="background-color: #f1f5f9; border-color: #cbd5e1;">
                    <div class="stat-val text-slate-800">{{ number_format($totalPemeriksaan) }}</div>
                    <div class="stat-lbl text-slate-600">Total Uji Bioassay ({{ number_format($totalSampel) }} Nyamuk)</div>
                </td>
                <td style="background-color: #fef2f2; border-color: #fca5a5;">
                    <div class="stat-val text-rose-700">{{ $persenResisten }}%</div>
                    <div class="stat-lbl text-rose-700">{{ $totalResisten }} Titik Terbukti Resisten</div>
                </td>
                <td style="background-color: #fffbeb; border-color: #fde68a;">
                    <div class="stat-val text-amber-700">{{ $persenToleran }}%</div>
                    <div class="stat-lbl text-amber-700">{{ $totalToleran }} Titik Toleran / Terduga</div>
                </td>
                <td style="background-color: #f0fdf4; border-color: #86efac;">
                    <div class="stat-val text-emerald-700">{{ $persenRentan }}%</div>
                    <div class="stat-lbl text-emerald-700">{{ $totalRentan }} Titik Masih Rentan Efektif</div>
                </td>
            </tr>
        </table>

        {{-- 6. VISUALISASI GRAFIK EPIDEMIOLOGIS RESISTENSI (INLINE 100% SESUAI DATA) --}}
        <div class="sec-title">
            I. PROFIL VISUAL EPIDEMIOLOGIS KERENTANAN VEKTOR & AMBANG WHO
        </div>

        <div class="chart-box">
            <div class="chart-box-header">
                <span class="chart-box-title">Grafik 1: Distribusi Proporsi Status Kerentanan Wilayah (WHO Benchmark)</span>
                <span class="chart-box-desc">Total Basis: {{ number_format($totalPemeriksaan) }} Uji Bioassay ({{ number_format($totalSampel) }} Ekor Nyamuk Teruji)</span>
            </div>

            {{-- SPECTRUM HORIZONTAL STACKED BAR --}}
            <div class="spectrum-bar">
                @if($persenResisten > 0)
                    <div class="spectrum-seg" style="width: {{ $persenResisten }}%; background-color: #dc2626;" title="Resisten: {{ $persenResisten }}%">
                        @if($persenResisten >= 7) {{ $persenResisten }}% Resisten @endif
                    </div>
                @endif
                @if($persenToleran > 0)
                    <div class="spectrum-seg" style="width: {{ $persenToleran }}%; background-color: #d97706;" title="Toleran: {{ $persenToleran }}%">
                        @if($persenToleran >= 7) {{ $persenToleran }}% Toleran @endif
                    </div>
                @endif
                @if($persenRentan > 0)
                    <div class="spectrum-seg" style="width: {{ $persenRentan }}%; background-color: #16a34a;" title="Rentan: {{ $persenRentan }}%">
                        @if($persenRentan >= 7) {{ $persenRentan }}% Rentan @endif
                    </div>
                @endif
            </div>

            <div class="chart-legend">
                <div class="flex items-center gap-4">
                    <span class="legend-item"><span class="legend-dot" style="background:#dc2626;"></span> <strong>Resisten:</strong> {{ $persenResisten }}% ({{ $totalResisten }} uji)</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#d97706;"></span> <strong>Toleran/Terduga:</strong> {{ $persenToleran }}% ({{ $totalToleran }} uji)</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#16a34a;"></span> <strong>Rentan Efektif:</strong> {{ $persenRentan }}% ({{ $totalRentan }} uji)</span>
                </div>
                <div style="font-size: 6.5pt; color: #64748b; font-weight: 600;">
                    Ambang Moratorium WHO: Resisten &ge; 50% | Ambang Waspada: Toleransi &ge; 10%
                </div>
            </div>

            {{-- GRAFIK 2: KOMPARASI SPEKTRUM PER BAHAN AKTIF INSEKTISIDA --}}
            @if(count($matriksInsektisida) > 0)
                <div style="margin-top: 8px; padding-top: 6px; border-top: 1px dashed #cbd5e1;">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="chart-box-title" style="font-size: 7.2pt;">Grafik 2: Komparasi Kerentanan per Bahan Aktif Insektisida Teruji</span>
                        <span class="chart-box-desc">Proporsi Kematian Vektor terhadap Tiap Senyawa</span>
                    </div>

                    @foreach(array_slice($matriksInsektisida, 0, 7) as $m)
                        <div class="chem-chart-row">
                            <div class="chem-name-col" title="{{ $m['nama'] }} ({{ $m['golongan_nama'] }})">
                                {{ $m['nama'] }}
                                <span style="font-size: 5.6pt; color: #64748b; font-weight: normal;">[{{ $m['golongan_nama'] }}]</span>
                            </div>
                            <div class="chem-bar-col">
                                @if($m['persen_resisten'] > 0)
                                    <div style="width: {{ $m['persen_resisten'] }}%; background-color: #dc2626; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 5.8pt; color: #fff; font-weight: bold;" title="Resisten {{ $m['persen_resisten'] }}%">
                                        @if($m['persen_resisten'] >= 14) {{ $m['persen_resisten'] }}% @endif
                                    </div>
                                @endif
                                @if($m['persen_toleran'] > 0)
                                    <div style="width: {{ $m['persen_toleran'] }}%; background-color: #d97706; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 5.8pt; color: #fff; font-weight: bold;" title="Toleran {{ $m['persen_toleran'] }}%">
                                        @if($m['persen_toleran'] >= 14) {{ $m['persen_toleran'] }}% @endif
                                    </div>
                                @endif
                                @if($m['persen_rentan'] > 0)
                                    <div style="width: {{ $m['persen_rentan'] }}%; background-color: #16a34a; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 5.8pt; color: #fff; font-weight: bold;" title="Rentan {{ $m['persen_rentan'] }}%">
                                        @if($m['persen_rentan'] >= 14) {{ $m['persen_rentan'] }}% @endif
                                    </div>
                                @endif
                            </div>
                            <div class="chem-stat-col">
                                <span style="color: #64748b; font-size: 6.2pt;">{{ $m['total_uji'] }} uji</span>
                                @if($m['status_aksi'] === 'MORATORIUM')
                                    <span style="color: #dc2626; font-weight: 800; margin-left: 2px;">[STOP]</span>
                                @elseif($m['status_aksi'] === 'PENGAWASAN')
                                    <span style="color: #d97706; font-weight: 800; margin-left: 2px;">[PANTAU]</span>
                                @else
                                    <span style="color: #16a34a; font-weight: 800; margin-left: 2px;">[REKOM]</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- 7. MATRIKS KEPUTUSAN PENGGUNAAN INSEKTISIDA --}}
        <div class="sec-title">
            II. MATRIKS KEPUTUSAN OPERASIONAL PENGGUNAAN INSEKTISIDA
        </div>
        <table class="doc-table">
            <thead>
                <tr>
                    <th style="width: 28%;">Kategori Kebijakan</th>
                    <th style="width: 42%;">Daftar Insektisida / Senyawa Terkena Kebijakan</th>
                    <th style="width: 30%;">Instruksi Teknis Pelaksanaan Lapangan</th>
                </tr>
            </thead>
            <tbody>
                {{-- DILARANG / MORATORIUM --}}
                <tr>
                    <td style="background-color: #fef2f2;">
                        <span class="badge-pill badge-moratorium">🛑 MORATORIUM SEGERA (DILARANG)</span>
                        <div class="text-[6.8pt] text-rose-800 mt-1 font-medium">Tingkat resistensi &ge; 50% atau kematian uji bioassay &lt; 90% dominan.</div>
                    </td>
                    <td>
                        @if(count($dilarangList) > 0)
                            <div class="space-y-1">
                                @foreach($dilarangList as $item)
                                    <div class="flex items-center justify-between text-[7.2pt]">
                                        <strong class="text-rose-900">{{ $item['nama'] }}</strong>
                                        <span class="text-rose-700 font-bold">Resisten {{ $item['pctResisten'] }}% ({{ $item['totalUji'] }} uji)</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-slate-400 italic">Tidak ada senyawa dalam status moratorium kritis.</span>
                        @endif
                    </td>
                    <td class="text-rose-900 font-medium">
                        <strong>Hentikan segera penggunaan fogging / spraying</strong> menggunakan senyawa ini. Penggunaan berkelanjutan mempercepat seleksi gen resisten dan memboroskan anggaran tanpa membunuh vektor.
                    </td>
                </tr>

                {{-- PENGAWASAN KETAT / BATASI --}}
                <tr>
                    <td style="background-color: #fffbeb;">
                        <span class="badge-pill badge-pengawasan">⚠️ PENGAWASAN KETAT (BATASI)</span>
                        <div class="text-[6.8pt] text-amber-800 mt-1 font-medium">Kematian 90–97% (toleran/terduga resisten) atau resistensi 15–49%.</div>
                    </td>
                    <td>
                        @if(count($pengawasanList) > 0)
                            <div class="space-y-1">
                                @foreach($pengawasanList as $item)
                                    <div class="flex items-center justify-between text-[7.2pt]">
                                        <strong class="text-amber-900">{{ $item['nama'] }}</strong>
                                        <span class="text-amber-700 font-bold">Toleran {{ $item['pctToleran'] }}% ({{ $item['totalUji'] }} uji)</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-slate-400 italic">Tidak ada senyawa dalam kategori pengawasan ketat.</span>
                        @endif
                    </td>
                    <td class="text-amber-900 font-medium">
                        <strong>Batasi frekuensi aplikasi.</strong> Lakukan uji bioassay konfirmasi ulang dengan sinergis PBO. Jangan gunakan terus-menerus tanpa rotasi senyawa golongan berbeda.
                    </td>
                </tr>

                {{-- REKOMENDASI UTAMA --}}
                <tr>
                    <td style="background-color: #f0fdf4;">
                        <span class="badge-pill badge-rekomendasi">✅ REKOMENDASI UTAMA (EFEKTIF)</span>
                        <div class="text-[6.8pt] text-emerald-800 mt-1 font-medium">Kematian uji &ge; 98% (rentan &ge; 80% dari total pengujian).</div>
                    </td>
                    <td>
                        @if(count($direkomendasikanList) > 0)
                            <div class="space-y-1">
                                @foreach($direkomendasikanList as $item)
                                    <div class="flex items-center justify-between text-[7.2pt]">
                                        <strong class="text-emerald-900">{{ $item['nama'] }}</strong>
                                        <span class="text-emerald-700 font-bold">Rentan {{ $item['pctRentan'] }}% ({{ $item['totalUji'] }} uji)</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-slate-400 italic">Belum ada senyawa dengan tingkat kerentanan mutlak &gt;80%.</span>
                        @endif
                    </td>
                    <td class="text-emerald-900 font-medium">
                        <strong>Direkomendasikan sebagai senjata utama pengendalian vektor</strong> (fokus KLB / intervensi rutin). Tetap kombinasikan dengan biolarvasida agar efikasi bertahan lama.
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- 8. REKOMENDASI STRATEGI ROTASI INSEKTISIDA (MoA ROTATION) --}}
        @if(count($strategiRotasi) > 0)
            <div class="sec-title">
                III. REKOMENDASI PASANGAN ROTASI BAHAN AKTIF (MODE OF ACTION ROTATION)
            </div>
            <table class="doc-table">
                <thead>
                    <tr>
                        <th style="width: 30%;">Bahan Berstatus Resistensi Tinggi</th>
                        <th style="width: 30%;">Alternatif Rekomendasi Pengganti</th>
                        <th style="width: 40%;">Rasional Ilmiah & Mekanisme Biologis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($strategiRotasi as $rotasi)
                        <tr>
                            <td class="font-bold text-rose-800 bg-rose-50/50">
                                🛑 {{ $rotasi['dilarang'] }}
                            </td>
                            <td class="font-bold text-emerald-800 bg-emerald-50/50">
                                🔄 {{ $rotasi['alternatif'] }}
                            </td>
                            <td class="text-slate-700">
                                {{ $rotasi['alasan'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- 9. TABEL DETAIL SEMUA INSEKTISIDA TERUJI --}}
        <div class="sec-title">
            IV. DETAIL HASIL UJI KERENTANAN & STATUS KEBIJAKAN SEMUA INSEKTISIDA
        </div>
        <table class="doc-table">
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 25%;">Nama Insektisida</th>
                    <th style="width: 18%;">Golongan Kimia</th>
                    <th style="width: 9%;">Total Uji</th>
                    <th style="width: 12%;">% Resisten</th>
                    <th style="width: 12%;">% Toleran</th>
                    <th style="width: 12%;">% Rentan</th>
                    <th style="width: 8%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($matriksInsektisida as $idx => $m)
                    <tr>
                        <td class="text-center font-bold text-slate-600">{{ $idx + 1 }}</td>
                        <td>
                            <strong class="text-slate-900">{{ $m['nama'] }}</strong>
                            @if(!empty($m['formulasi']))
                                <div class="text-[6.2pt] text-slate-500 font-normal leading-tight mt-0.5">{{ $m['formulasi'] }}</div>
                            @endif
                        </td>
                        <td class="text-slate-600 text-[6.8pt]">
                            {{ $m['golongan_nama'] }}
                        </td>
                        <td class="text-center font-bold text-slate-700">
                            {{ $m['total_uji'] }}
                        </td>
                        <td class="text-center font-bold text-rose-700 {{ $m['resisten'] > 0 ? 'bg-rose-50' : '' }}">
                            {{ $m['persen_resisten'] }}% <span class="text-[6.5pt] font-normal text-slate-500">({{ $m['resisten'] }})</span>
                        </td>
                        <td class="text-center font-bold text-amber-700 {{ $m['toleran'] > 0 ? 'bg-amber-50' : '' }}">
                            {{ $m['persen_toleran'] }}% <span class="text-[6.5pt] font-normal text-slate-500">({{ $m['toleran'] }})</span>
                        </td>
                        <td class="text-center font-bold text-emerald-700 {{ $m['rentan'] > 0 ? 'bg-emerald-50' : '' }}">
                            {{ $m['persen_rentan'] }}% <span class="text-[6.5pt] font-normal text-slate-500">({{ $m['rentan'] }})</span>
                        </td>
                        <td class="text-center">
                            @if($m['status_aksi'] === 'MORATORIUM')
                                <span class="badge-pill badge-moratorium">STOP</span>
                            @elseif($m['status_aksi'] === 'PENGAWASAN')
                                <span class="badge-pill badge-pengawasan">PANTAU</span>
                            @else
                                <span class="badge-pill badge-rekomendasi">REKOM</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-slate-400 italic">
                            Belum ada rekaman data uji resistensi untuk parameter yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- 10. PROTOKOL & RENCANA AKSI STRATEGIS KEBIJAKAN --}}
        <div class="sec-title">
            V. PROTOKOL & RENCANA AKSI STRATEGIS KEBIJAKAN PENGENDALIAN VEKTOR
        </div>

        {{-- TINGKAT 1 --}}
        <div class="action-box">
            <div class="action-box-title text-rose-900">
                <span>🔴 TINGKAT 1: AKSI CEPAT TANGGAP DARURAT (0 – 30 HARI)</span>
            </div>
            <ul class="action-box-list">
                <li><strong>Hentikan Segera Pengasapan (Fogging) Berulang dengan Pyrethroid</strong> di wilayah yang memiliki status resisten tinggi guna mencegah kegagalan program dan pembengkakan resistensi populasi nyamuk.</li>
                <li><strong>Alihkan Pengendalian ke Stadium Larva:</strong> Kerahkan kader Jumantik untuk Gerakan 1 Rumah 1 Jumantik (G1R1J) serta aplikasi larvasida biologis (Bti) dan Insect Growth Regulator (IGR) yang belum menimbulkan resistensi silang.</li>
                <li><strong>Penanganan Fokus Kasus DB/Malaria:</strong> Apabila terjadi lonjakan kasus di zona resisten, gunakan insektisida dari golongan Organofosfat (seperti Malathion/Pirimiphos-methyl) dengan pengawasan ketat dosis kalibrasi alat ULV/fog machine.</li>
            </ul>
        </div>

        {{-- TINGKAT 2 --}}
        <div class="action-box">
            <div class="action-box-title text-amber-900">
                <span>🟡 TINGKAT 2: INTERVENSI TAKTIS & SURVEILANS BERKALA (1 – 6 BULAN)</span>
            </div>
            <ul class="action-box-list">
                <li><strong>Terapkan Protokol Rotasi MoA Resmi:</strong> Lakukan pergiliran insektisida setiap 6-12 bulan antar golongan kimia dengan mekanisme target reseptor saraf yang berbeda (Sodium Channel Modulator ↔ Acetylcholinesterase Inhibitor).</li>
                <li><strong>Surveilans Uji Bioassay Ulang Konfirmasi:</strong> Dinas Kesehatan Kabupaten/Kota wajib mengirimkan sampel nyamuk F1 lapangan secara periodik ke BBLKL Salatiga untuk pengujian kerentanan berkala dan uji mekanisme enzimatis/biomolekuler (KDR).</li>
                <li><strong>Penerapan Insektisida dengan Sinergis:</strong> Bila senyawa pyrethroid masih dibutuhkan dalam formulasi LLINs atau IRS, wajib menggunakan formulasi kombinasi sinergis Piperonyl Butoxide (PBO) untuk menonaktifkan enzim detoksifikasi sitokrom P450.</li>
            </ul>
        </div>

        {{-- TINGKAT 3 --}}
        <div class="action-box">
            <div class="action-box-title text-emerald-900">
                <span>🟢 TINGKAT 3: PERENCANAAN ANGGARAN & REGULASI STRATEGIS (APBD / APBN / DAK BOK)</span>
            </div>
            <ul class="action-box-list">
                <li><strong>Sinkronisasi Pengadaan Bahan Kimia Insektisida:</strong> Pengadaan racun serangga pada e-Katalog APBD/APBN/BOK Dinkes WAJIB mencocokkan spesifikasi bahan dengan data rekomendasi resmi Peta Resistensi BBLKL Kemenkes RI (dilarang belanja racun yang berstatus moratorium).</li>
                <li><strong>Penguatan Alokasi Operasional Pemantauan Resistensi:</strong> Menyediakan pos anggaran khusus dalam APBD untuk kegiatan surveilans entomologi, kalibrasi alat semprot, serta monitoring resistensi sebelum musim penularan DBD/Malaria.</li>
                <li><strong>Penerbitan Surat Edaran Kewaspadaan Dini:</strong> Mengajukan Surat Edaran (SE) Bupati/Walikota/Gubernur kepada seluruh Camat dan Puskesmas mengenai moratorium insektisida resisten dan penguatan PSN 3M-Plus serentak.</li>
            </ul>
        </div>

        {{-- 10. LEMBAR PENGESAHAN & DISPOSISI RESMI --}}
        <table class="sig-container">
            <tr>
                <td style="width: 50%;">
                    <div class="text-[7.5pt] text-slate-600 mb-1">
                        Mengetahui / Rekomendasi Disposisi Teknis:<br>
                        <strong>Dinas Kesehatan Wilayah Setempat</strong>
                    </div>
                    <div style="height: 48px;"></div>
                    <div class="text-[8pt] font-extrabold text-slate-800 border-b border-slate-400 pb-0.5 inline-block">
                        ( ................................................................ )
                    </div>
                    <div class="text-[7pt] text-slate-500 mt-0.5">
                        NIP. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </td>
                <td style="width: 50%; text-align: right;">
                    <div class="text-[7.5pt] text-slate-600 mb-1">
                        Salatiga, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>
                        <strong>Tim Kerja Vektor & Entomologi Kesehatan Lingkungan<br>BBLKL Kemenkes RI Salatiga</strong>
                    </div>
                    <div style="height: 48px;"></div>
                    <div class="text-[8pt] font-extrabold text-slate-800 border-b border-slate-400 pb-0.5 inline-block">
                        TIM AHLI ENTOMOLOGI KESEHATAN
                    </div>
                    <div class="text-[7pt] text-slate-500 mt-0.5">
                        Sistem Informasi Resistensi Insektisida Indonesia
                    </div>
                </td>
            </tr>
        </table>

        {{-- 11. FOOTER DOKUMEN --}}
        <div class="doc-footer">
            <span>
                Dokumen resmi ini diproduksi secara otomatis oleh Sistem Informasi Resistensi Insektisida (SI-RESISTENSI) BBLKL Kemenkes RI.
            </span>
            <span>
                Halaman 1 dari 1 (Dokumen Sah Tanpa Stempel Basah) &bull; Dicetak: {{ date('d/m/Y H:i') }} WIB
            </span>
        </div>

    </div>

</body>
</html>
