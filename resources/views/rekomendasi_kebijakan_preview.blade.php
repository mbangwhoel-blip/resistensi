<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $activeTemplate === 'kemenkes' ? 'Rekomendasi Standar Teknis Kemenkes RI' : ($activeTemplate === 'laboratorium' ? 'Rekomendasi Teknis Laboratorium WHO 2022' : ($activeTemplate === 'agregat' ? 'Policy Brief Agregat Wilayah & Klaster Kerentanan' : 'Policy Brief Rekomendasi Kebijakan Vektor')) }} - {{ $namaWilayah }} - PETA RESISTENSI</title>

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
            position: relative;
        }

        /* Watermark DRAFT Otomatis Sebelum Disahkan Kepala/Pimpinan BBLKL */
        .watermark-draft-box {
            position: relative;
        }
        .watermark-draft-box::before {
            content: "DRAFT";
            position: absolute;
            top: 48%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-32deg);
            font-size: 110pt;
            font-weight: 900;
            color: rgba(220, 38, 38, 0.08);
            letter-spacing: 16px;
            pointer-events: none;
            z-index: 40;
            user-select: none;
            text-transform: uppercase;
            border: 8px solid rgba(220, 38, 38, 0.08);
            padding: 8px 40px;
            border-radius: 24px;
            line-height: 1;
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
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
            width: 26%;
            display: flex;
            flex-direction: column;
            justify-content: center;
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

        /* Mode Edit Online Styles */
        .custom-notes-section {
            transition: all 0.25s ease;
        }
        .edit-mode-active .custom-notes-section {
            border-color: #0d9488 !important;
            box-shadow: 0 4px 16px rgba(13, 148, 136, 0.16) !important;
            background-color: #f0fdfa !important;
        }
        .edit-mode-active .editable-notes-content {
            outline: 2px dashed #0d9488 !important;
            outline-offset: 3px;
            background-color: #ffffff !important;
            border-radius: 6px;
            padding: 8px 10px;
            cursor: text;
            box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1);
        }
        .edit-mode-active .editable-notes-content:focus {
            outline: 2.5px solid #0d9488 !important;
            box-shadow: 0 0 0 6px rgba(13, 148, 136, 0.2) !important;
        }
        .edit-mode-active .edit-online-badge {
            display: inline-flex !important;
        }
        .edit-mode-active .edit-mode-btn {
            display: inline-flex !important;
        }

        /* CETAK (MEDIA PRINT) */
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }
            .no-print, #editModeNoticeBanner, .edit-mode-btn, .edit-online-badge {
                display: none !important;
            }
            .editable-notes-content {
                outline: none !important;
                box-shadow: none !important;
                background: transparent !important;
                padding: 0 !important;
            }
            .sheet-container {
                width: 100% !important;
                min-height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            .watermark-draft-box::before {
                content: "DRAFT" !important;
                position: fixed !important;
                top: 45% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) rotate(-32deg) !important;
                font-size: 115pt !important;
                font-weight: 900 !important;
                color: rgba(220, 38, 38, 0.09) !important;
                letter-spacing: 16px !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                border: 8px solid rgba(220, 38, 38, 0.09) !important;
                padding: 8px 40px !important;
                border-radius: 24px !important;
                z-index: 9999 !important;
                pointer-events: none !important;
            }

            .page-break {
                page-break-after: always;
                break-after: page;
                height: 0 !important;
                margin: 0 !important;
                border: none !important;
            }

            @page {
                size: A4 portrait;
                margin: 10mm 12mm 12mm 12mm;
            }

            .agr-header {
                margin: 0 !important;
                border-radius: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .agr-notice-banner {
                margin: 0 0 12px 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        /* Template 4: Policy Brief Agregat Wilayah */
        .agr-header {
            background-color: #0d4e56;
            color: #ffffff;
            padding: 16px 20px;
            border-radius: 6px 6px 0 0;
            margin: -16mm -18mm 0 -18mm;
        }
        .agr-tag {
            font-size: 7.8pt;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 3px;
        }
        .agr-title {
            font-size: 15.5pt;
            font-weight: 800;
            line-height: 1.25;
            color: #ffffff;
            margin: 0;
        }
        .agr-subtitle {
            font-size: 8.2pt;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 5px;
        }
        .agr-pill-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
            flex-wrap: wrap;
        }
        .agr-pill {
            display: inline-flex;
            align-items: center;
            padding: 2.5px 11px;
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            background: rgba(0, 0, 0, 0.18);
            color: #ffffff;
            font-size: 7.2pt;
            font-weight: 600;
        }
        .agr-notice-banner {
            background: #fff7ed;
            color: #9a3412;
            padding: 6px 16px;
            font-size: 7pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin: 0 -18mm 12px -18mm;
            border-bottom: 1px solid #fed7aa;
        }
        .agr-sec-heading {
            color: #0d4e56;
            font-size: 11pt;
            font-weight: 800;
            margin: 0 0 2px 0;
            letter-spacing: -0.2px;
        }
        .agr-sec-sub {
            color: #475569;
            font-size: 7.3pt;
            margin: 0 0 8px 0;
            line-height: 1.35;
        }
        .agr-stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 12px;
        }
        .agr-stat-card {
            padding: 7px 10px;
            border-radius: 4px;
        }
        .agr-stat-card .num {
            font-size: 24pt;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 3px;
        }
        .agr-stat-card .lbl {
            font-size: 6.8pt;
            font-weight: 600;
            line-height: 1.25;
        }
        .agr-two-col {
            display: grid;
            grid-template-columns: 53% 47%;
            gap: 12px;
        }
        .agr-matriks-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7pt;
        }
        .agr-matriks-table th {
            font-size: 6.7pt;
            font-weight: 700;
            color: #0f172a;
            padding: 3px 2px;
            text-align: center;
            vertical-align: bottom;
            border-bottom: 1.5px solid #cbd5e1;
            line-height: 1.15;
        }
        .agr-matriks-table td {
            padding: 2px 2px;
            text-align: center;
            border-bottom: 1px solid #f1f5f9;
        }
        .agr-badge-rt {
            display: inline-block;
            width: 25px;
            height: 18px;
            line-height: 18px;
            background: #be123c;
            color: #ffffff;
            font-weight: 800;
            font-size: 6.8pt;
            border-radius: 3px;
        }
        .agr-badge-dr {
            display: inline-block;
            width: 25px;
            height: 18px;
            line-height: 18px;
            background: #ea580c;
            color: #ffffff;
            font-weight: 800;
            font-size: 6.8pt;
            border-radius: 3px;
        }
        .agr-badge-kr {
            display: inline-block;
            width: 25px;
            height: 18px;
            line-height: 18px;
            background: #f59e0b;
            color: #ffffff;
            font-weight: 800;
            font-size: 6.8pt;
            border-radius: 3px;
        }
        .agr-badge-rn {
            display: inline-block;
            width: 25px;
            height: 18px;
            line-height: 18px;
            background: #15803d;
            color: #ffffff;
            font-weight: 800;
            font-size: 6.8pt;
            border-radius: 3px;
        }
        .agr-badge-td {
            display: inline-block;
            width: 25px;
            height: 18px;
            line-height: 18px;
            background: #f1f5f9;
            color: #64748b;
            font-weight: 700;
            font-size: 6.8pt;
            border-radius: 3px;
        }
        .agr-cluster-card {
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            border-radius: 4px;
            padding: 5px 8px;
            margin-bottom: 5px;
        }
        .agr-cluster-title {
            font-size: 7.4pt;
            font-weight: 800;
            color: #0d4e56;
        }
        .agr-cluster-sub {
            font-size: 6.8pt;
            font-weight: 700;
            color: #334155;
            margin-top: 1px;
        }
        .agr-cluster-desc {
            font-size: 6.7pt;
            color: #475569;
            line-height: 1.35;
            margin-top: 2px;
        }
        .agr-bar-row {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
            gap: 8px;
        }
        .agr-bar-label {
            width: 140px;
            font-size: 7.6pt;
            font-weight: 700;
            color: #1e293b;
            flex-shrink: 0;
        }
        .agr-bar-track {
            flex: 1;
            height: 19px;
            background: #e2e8f0;
            border-radius: 3px;
            display: flex;
            overflow: hidden;
            font-size: 6.8pt;
            font-weight: 800;
            color: #ffffff;
            line-height: 19px;
            text-align: center;
        }
        .agr-bar-meta {
            width: 75px;
            text-align: right;
            font-size: 7pt;
            font-weight: 700;
            color: #334155;
            flex-shrink: 0;
        }
        .agr-opsi-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }
        .agr-opsi-card {
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 7px 9px;
            background: #ffffff;
            font-size: 6.8pt;
            line-height: 1.4;
        }
        .agr-opsi-title {
            font-size: 7.8pt;
            font-weight: 800;
            color: #0d4e56;
            margin-bottom: 2px;
        }
        .agr-disclaimer-box {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 6px 10px;
            font-size: 6.8pt;
            color: #334155;
            line-height: 1.4;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    {{-- TOOLBAR ATAS RAPI & RINGKAS (STICKY, 2-TIER TERSTRUKTUR, TIDAK WRAP BERANTAKAN) --}}
    <div class="no-print sticky top-0 z-50 shadow-xl bg-slate-900 border-b border-slate-800">
        {{-- BARIS 1: NAVIGASI KEMBALI, JUDUL DOKUMEN & AKSI PENGESAHAN/CETAK --}}
        <div class="px-4 sm:px-6 py-2.5 flex items-center justify-between gap-3 border-b border-slate-800/80 bg-slate-900/95 backdrop-blur-md">
            {{-- SISI KIRI: TOMBOL KEMBALI + JUDUL DOKUMEN & CAKUPAN --}}
            <div class="flex items-center gap-3 min-w-0">
                <a href="{{ route('rekomendasi.index', request()->all()) }}"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-slate-700 bg-slate-800/90 hover:bg-slate-700 px-3 py-1.5 text-xs font-bold text-slate-200 hover:text-white transition shadow-2xs shrink-0 cursor-pointer"
                   title="Kembali ke Dashboard Rekomendasi Kebijakan">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali</span>
                </a>

                <div class="h-5 w-px bg-slate-700 shrink-0 hidden sm:block"></div>

                <div class="min-w-0">
                    <h1 class="text-xs sm:text-sm font-extrabold text-white truncate leading-tight flex items-center gap-1.5">
                        <span class="text-teal-400">🛡️</span>
                        <span>Pratinjau Dokumen Rekomendasi Kebijakan</span>
                    </h1>
                    <p class="text-[11px] text-slate-400 truncate">
                        Cakupan: <strong class="text-teal-300">{{ $namaWilayah }}</strong> &bull; Periode: {{ $tahunFilter }} &bull; Target: {{ $nyamukFilter }}
                    </p>
                </div>
            </div>

            {{-- SISI KANAN: MODE EDIT ONLINE + STATUS DRAFT/SAH + APPROVE + CETAK DOKUMEN --}}
            <div class="flex items-center gap-2 shrink-0">
                {{-- TOMBOL MODE EDIT ONLINE & SIMPAN MASUKAN --}}
                <div class="inline-flex items-center gap-1.5 bg-slate-800/80 p-1 rounded-xl border border-slate-700">
                    <button type="button"
                            id="btnToggleEditMode"
                            onclick="toggleEditMode()"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-amber-500 hover:bg-amber-400 px-3 py-1.5 text-xs font-bold text-slate-950 shadow transition cursor-pointer active:scale-95"
                            title="Aktifkan mode edit online untuk menambahkan atau mengubah masukan langsung pada template">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        <span id="btnEditLabel">✏️ Edit Online</span>
                    </button>

                    <button type="button"
                            id="btnSaveNotes"
                            onclick="saveNotesOnline()"
                            style="display: none;"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 px-3 py-1.5 text-xs font-bold text-white shadow transition cursor-pointer active:scale-95 animate-pulse"
                            title="Simpan perubahan masukan ke database">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        <span id="btnSaveLabel">💾 Simpan Masukan</span>
                    </button>
                </div>

                {{-- STATUS PENGESAHAN DOKUMEN --}}
                @if($isApproved)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 text-xs font-bold shrink-0">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span class="hidden sm:inline">Disahkan Kepala BBLKL</span>
                        <span class="sm:hidden">SAH</span>
                    </span>
                    <button type="button"
                            onclick="openApproveModal()"
                            class="inline-flex items-center gap-1 rounded-xl border border-emerald-700 bg-emerald-800/80 hover:bg-emerald-700 px-3 py-1.5 text-xs font-bold text-emerald-200 transition cursor-pointer">
                        <span>Perbarui</span>
                    </button>
                    <form method="POST" action="{{ route('rekomendasi.revoke') }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengesahan rekomendasi kebijakan ini? Status dokumen akan kembali menjadi DRAFT.')">
                        @csrf
                        <input type="hidden" name="approval_id" value="{{ $approval->id }}">
                        <input type="hidden" name="doc_hash" value="{{ $docHash }}">
                        <input type="hidden" name="scope_hash" value="{{ $scopeHash }}">
                        <button type="submit"
                                class="inline-flex items-center gap-1 rounded-xl border border-rose-800 bg-rose-950/60 hover:bg-rose-900 px-2.5 py-1.5 text-xs font-bold text-rose-300 transition cursor-pointer"
                                title="Batalkan / Cabut Pengesahan">
                            <span>Cabut</span>
                        </button>
                    </form>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-500/20 text-amber-300 border border-amber-500/40 text-xs font-bold shrink-0">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                        <span>STATUS: DRAFT</span>
                    </span>
                    <button type="button"
                            onclick="openApproveModal()"
                            class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 px-3.5 py-1.5 text-xs font-bold text-white shadow-md transition cursor-pointer active:scale-95">
                        <span>✍️ Approve (Kepala BBLKL)</span>
                    </button>
                @endif

                {{-- TOMBOL CETAK / SIMPAN PDF BROWSER --}}
                <button type="button"
                        onclick="window.print()"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-teal-600 hover:bg-teal-500 px-3.5 py-1.5 text-xs font-bold text-white shadow-md transition cursor-pointer active:scale-95">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span class="hidden sm:inline">Cetak Dokumen</span>
                    <span class="sm:hidden">Cetak</span>
                    <span class="text-[10px] text-teal-200 font-normal hidden md:inline">(Ctrl+P)</span>
                </button>
            </div>
        </div>

        {{-- BARIS 2: TAB SWITCHER 4 FORMAT TEMPLATE LAPORAN (TERPUSAT, RAPI, RINGKAS) --}}
        <div class="px-4 py-1.5 bg-slate-900/95 backdrop-blur-md flex items-center justify-center overflow-x-auto">
            <div class="inline-flex p-1 bg-slate-800/90 rounded-xl border border-slate-700/80 shadow-inner">
                {{-- TAB 1: STANDAR TEKNIS KEMENKES RI --}}
                <a href="{{ route('rekomendasi.preview', array_merge(request()->all(), ['template' => 'kemenkes'])) }}"
                   class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ $activeTemplate === 'kemenkes' ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-700/60' }}"
                   title="Beralih ke format Rekomendasi Standar Teknis Kemenkes RI">
                    <span>📋 Standar Teknis Kemenkes RI</span>
                    @if($activeTemplate === 'kemenkes')
                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                    @endif
                </a>

                {{-- TAB 2: POLICY BRIEF EKSEKUTIF --}}
                <a href="{{ route('rekomendasi.preview', array_merge(request()->all(), ['template' => 'eksekutif'])) }}"
                   class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ $activeTemplate === 'eksekutif' ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-700/60' }}"
                   title="Beralih ke format Policy Brief Eksekutif (Format Awal)">
                    <span>📑 Policy Brief Eksekutif</span>
                    @if($activeTemplate === 'eksekutif')
                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                    @endif
                </a>

                {{-- TAB 3: REKOMENDASI TEKNIS LABORATORIUM --}}
                <a href="{{ route('rekomendasi.preview', array_merge(request()->all(), ['template' => 'laboratorium'])) }}"
                   class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ $activeTemplate === 'laboratorium' ? 'bg-violet-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-700/60' }}"
                   title="Beralih ke format Rekomendasi Teknis Laboratorium (WHO Manual 2022)">
                    <span>🔬 Rekm. Teknis Lab</span>
                    @if($activeTemplate === 'laboratorium')
                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-violet-300 animate-pulse"></span>
                    @endif
                </a>

                {{-- TAB 4: POLICY BRIEF AGREGAT WILAYAH --}}
                <a href="{{ route('rekomendasi.preview', array_merge(request()->all(), ['template' => 'agregat'])) }}"
                   class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ $activeTemplate === 'agregat' ? 'bg-cyan-700 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-700/60' }}"
                   title="Beralih ke format Policy Brief Agregat Wilayah &amp; Klaster Kerentanan">
                    <span>📊 Policy Brief Agregat</span>
                    @if($activeTemplate === 'agregat')
                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-cyan-300 animate-pulse"></span>
                    @endif
                </a>
            </div>
        </div>

        {{-- BARIS 3: BANNER NOTIFIKASI MODE EDIT ONLINE --}}
        <div id="editModeNoticeBanner" style="display: none;" class="px-4 py-2 bg-gradient-to-r from-amber-600/95 via-amber-500/95 to-teal-600/95 text-white text-xs font-semibold flex items-center justify-between border-b border-amber-300/30 shadow-inner">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-white text-amber-700 text-xs font-black shadow-xs">✏️</span>
                <span><strong>Mode Edit Online Aktif:</strong> Anda dapat langsung mengklik dan mengetik masukan, saran, atau arahan pimpinan pada kotak catatan di bawah.</span>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="addBulletPoint()" class="px-2.5 py-1 rounded-lg bg-slate-900/50 hover:bg-slate-900/80 text-white text-[11px] font-bold transition flex items-center gap-1 cursor-pointer">
                    <span>➕ Tambah Butir Catatan</span>
                </button>
                <button type="button" onclick="saveNotesOnline()" class="px-3 py-1 rounded-lg bg-white hover:bg-slate-100 text-slate-900 text-[11px] font-extrabold shadow transition flex items-center gap-1 cursor-pointer">
                    <span>💾 Simpan Masukan</span>
                </button>
                <button type="button" onclick="toggleEditMode()" class="px-2.5 py-1 rounded-lg bg-slate-900/40 hover:bg-slate-900/70 text-white text-[11px] font-medium transition cursor-pointer" title="Selesai dan keluar dari mode edit">
                    ✕ Selesai
                </button>
            </div>
        </div>
    </div>

    {{-- BANNER STATUS DOKUMEN: DRAFT / RESMI DISETUJUI (HANYA DITAMPILKAN DI LAYAR, DI ATAS LEMBAR KERJA CETAK) --}}
    <div class="no-print" style="max-width: 210mm; margin: 16px auto 0 auto; padding: 0 4px;">
        @if(!$isApproved)
            <div style="background:#fffbeb; border:1.5px dashed #f59e0b; border-radius:8px; padding:10px 14px; display:flex; align-items:center; justify-content:space-between; font-size:7.8pt; color:#92400e; box-shadow:0 4px 12px rgba(245, 158, 11, 0.12);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <span style="background:#fef3c7; color:#b45309; font-weight:800; padding:3px 10px; border-radius:6px; border:1px solid #fcd34d; text-transform:uppercase; font-size:7pt; letter-spacing:0.5px; white-space:nowrap;">⚠️ DRAFT LAPORAN</span>
                    <span><strong>PERHATIAN:</strong> Dokumen rekomendasi kebijakan ini berstatus <strong>DRAFT</strong> dan <strong>BELUM DISETUJUI / DISAHKAN OLEH KEPALA BBLKL</strong>. Dokumen ini belum sah sebagai ketetapan operasional resmi.</span>
                </div>
                <span style="font-weight:800; color:#b45309; white-space:nowrap; margin-left:14px; font-size:7pt; text-transform:uppercase;">MENUNGGU PERSETUJUAN PIMPINAN</span>
            </div>
        @else
            <div style="background:#ecfdf5; border:1.5px solid #10b981; border-radius:8px; padding:10px 14px; display:flex; align-items:center; justify-content:space-between; font-size:7.8pt; color:#065f46; box-shadow:0 4px 12px rgba(16, 185, 129, 0.12);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <span style="background:#059669; color:#ffffff; font-weight:800; padding:3px 10px; border-radius:6px; text-transform:uppercase; font-size:7pt; letter-spacing:0.5px; white-space:nowrap;">✅ RESMI &amp; SAH</span>
                    <span>Dokumen Rekomendasi Kebijakan Resmi &bull; <strong>Telah Disetujui &amp; Disahkan Secara Digital oleh Kepala BBLKL Kemenkes RI</strong> pada {{ \Carbon\Carbon::parse($approval->approved_at)->isoFormat('D MMMM Y, HH:mm') }} WIB.</span>
                </div>
                <span style="font-weight:800; color:#047857; white-space:nowrap; margin-left:14px; font-size:7pt;">NO. REG: {{ $approval->nomor_surat }}</span>
            </div>
        @endif
    </div>

    {{-- KONTEN LEMBAR DOKUMEN RESMI --}}
    <div class="sheet-container {{ !$isApproved ? 'watermark-draft-box' : '' }}" style="margin-top: 14px;">

        @if($activeTemplate === 'eksekutif')
        {{-- ======================================================== --}}
        {{-- TEMPLATE 1: POLICY BRIEF EKSEKUTIF (FORMAT AWAL/EKSISTING) --}}
        {{-- ======================================================== --}}

        {{-- 1. KOP SURAT RESMI KEMENKES BBLKL SALATIGA --}}
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="{{ asset('logo_bblkl.png') }}" alt="Logo BBLKL Kemenkes RI" onerror="this.src='{{ asset('kemenkes.png') }}'">
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
                <td class="kop-spacer">
                    {{-- Spacer kanan penyeimbang simetris --}}
                </td>
            </tr>
        </table>

        <div class="kop-divider"></div>

        {{-- 2. JUDUL DOKUMEN POLICY BRIEF --}}
        <div class="doc-header">
            @if(!$isApproved)
                <span class="doc-badge" style="background:#fffbeb; color:#b45309; border:1px solid #fcd34d;">DRAFT POLICY BRIEF &bull; MENUNGGU PERSETUJUAN KEPALA BBLKL</span>
            @else
                <span class="doc-badge" style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0;">LEMBAR REKOMENDASI KEBIJAKAN RESMI DISAHKAN KEPALA BBLKL</span>
            @endif
            <h2 class="doc-title">
                STRATEGI PENGENDALIAN VEKTOR TERPADU & ROTASI INSEKTISIDA BERBASIS KERENTANAN BIOASSAY
            </h2>
            <div class="doc-meta">
                Nomor Registrasi: <strong>{{ $isApproved && !empty($approval->nomor_surat) ? $approval->nomor_surat : 'PB-VEC/BBLKL/' . date('Y') . '/' . strtoupper(substr(md5($namaWilayah . $tahunFilter . $nyamukFilter), 0, 7)) }}</strong> &bull; Klasifikasi: Standar Operasional Pengendalian Vektor
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
            if ($alertLevel === 'SEDANG' || $alertLevel === 'WASPADA' || ($alertColor ?? '') === 'amber') {
                $alertClass = 'alert-banner-waspada';
            } elseif ($alertLevel === 'RENDAH' || $alertLevel === 'TERKENDALI' || ($alertColor ?? '') === 'emerald') {
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
                                <span style="font-weight: 800; color: #0f172a; line-height: 1.15; white-space: nowrap;">{{ $m['nama'] }}</span>
                                <span style="font-size: 5.6pt; color: #64748b; font-weight: 700; margin-top: 1px;">{{ $m['golongan_nama'] }}</span>
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

        {{-- CATATAN, MASUKAN & DISPOSISI KHUSUS PIMPINAN / TIM AHLI (ONLINE EDITABLE) --}}
        <div class="custom-notes-section" style="margin: 12px 0 10px 0; border: 1.5px solid #0d9488; background: #f0fdfa; border-radius: 6px; padding: 9px 13px; page-break-inside: avoid;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; border-bottom: 1px solid #ccfbf1; padding-bottom: 3px;">
                <div style="font-size: 7.6pt; font-weight: 800; color: #0f766e; text-transform: uppercase; letter-spacing: 0.4px; display: flex; align-items: center; gap: 5px;">
                    <span>📝 CATATAN, MASUKAN &amp; DISPOSISI KHUSUS PIMPINAN / TIM AHLI</span>
                </div>
                <div class="edit-online-badge no-print" style="display: none; font-size: 6.2pt; font-weight: 700; color: #0f766e; background: #ccfbf1; border: 1px dashed #0d9488; padding: 2px 7px; border-radius: 4px;">
                    ✏️ Mode Edit Online Aktif — Klik teks di bawah untuk mengubah
                </div>
            </div>
            
            <div id="editableNotesBox" class="editable-notes-content" style="font-size: 7.2pt; line-height: 1.6; color: #1e293b; min-height: 44px; white-space: pre-wrap;">{{ $approval && !empty($approval->notes) ? $approval->notes : "• Penyesuaian formulasi insektisida di wilayah kantong resistensi tinggi wajib dikoordinasikan dengan Pengelola Program P2P Dinas Kesehatan setempat.\n• Prioritaskan aplikasi larvasida biologi (Bti) dan penguatan Gerakan 1 Rumah 1 Jumantik (G1R1J) pada pemukiman padat.\n• Pelaksanaan rotasi MoA insektisida wajib dievaluasi kembali melalui surveilans bioassay berkala." }}</div>

            <div class="no-print" style="margin-top: 6px; padding-top: 4px; border-top: 1px dashed #99f6e4; display: flex; justify-content: space-between; align-items: center; font-size: 6.5pt; color: #0f766e;">
                <div class="flex items-center gap-2">
                    <span>💡 <em>Masukan di atas tersimpan otomatis dan akan tercetak resmi pada dokumen rekomendasi.</em></span>
                    <span class="saveStatusIndicator font-bold text-emerald-700" style="display: none;">✓ Tersimpan</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="addBulletPoint()" class="edit-mode-btn" style="display: none; padding: 2px 7px; background: #0d9488; color: #fff; border-radius: 4px; font-weight: 700; cursor: pointer; border: none; font-size: 6.5pt;">
                        ➕ Tambah Butir
                    </button>
                    <button type="button" onclick="saveNotesOnline()" class="edit-mode-btn" style="display: none; padding: 2px 8px; background: #059669; color: #fff; border-radius: 4px; font-weight: 700; cursor: pointer; border: none; font-size: 6.5pt;">
                        💾 Simpan
                    </button>
                </div>
            </div>
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
                        Salatiga, {{ $isApproved ? \Carbon\Carbon::parse($approval->approved_at)->isoFormat('D MMMM Y') : \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>
                        <strong>Kepala Balai Besar Laboratorium Kesehatan Lingkungan<br>Kemenkes RI Salatiga</strong>
                    </div>
                    @if(!$isApproved)
                        <div style="border:1.5px dashed #f59e0b; background:#fffbeb; padding:7px 14px; border-radius:6px; display:inline-block; text-align:center; min-width:230px; margin:4px 0;">
                            <span style="font-size:7.5pt; font-weight:800; color:#b45309; display:block; text-transform:uppercase;">⚠️ STATUS: DRAFT</span>
                            <span style="font-size:6.8pt; color:#92400e; display:block; margin-top:2px;">Menunggu Pengesahan &amp; Tanda Tangan<br>Kepala BBLKL Kemenkes RI</span>
                            <div style="height:24px;"></div>
                            <span style="font-size:7.5pt; color:#64748b; font-weight:700;">( Belum Disahkan )</span>
                        </div>
                        <div class="text-[6.8pt] text-amber-700 italic mt-0.5">
                            Menunggu persetujuan pimpinan BBLKL
                        </div>
                    @else
                        <div style="border:1.5px solid #059669; background:#f0fdf4; padding:7px 12px; border-radius:6px; display:inline-block; text-align:left; min-width:240px; margin:4px 0;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="font-size:22pt; line-height:1;">🛡️</div>
                                <div>
                                    <div style="font-size:6.5pt; font-weight:800; color:#065f46; letter-spacing:0.4px; text-transform:uppercase;">Disahkan Secara Digital:</div>
                                    <div style="font-size:8.5pt; font-weight:800; color:#0f172a; border-bottom:1px solid #10b981; padding-bottom:1px;">{{ $approval->approver_name }}</div>
                                    <div style="font-size:6.8pt; color:#334155; margin-top:2px;">NIP. {{ $approval->approver_nip ?? '-' }}</div>
                                    <div style="font-size:6.5pt; color:#047857; font-weight:600;">{{ $approval->approver_jabatan }}</div>
                                    <div style="font-size:6pt; color:#64748b; margin-top:2px;">Disahkan: {{ \Carbon\Carbon::parse($approval->approved_at)->isoFormat('D MMMM Y, HH:mm') }} WIB</div>
                                    <div style="font-size:5.8pt; font-family:monospace; color:#059669; font-weight:700;">NO. REG: {{ $approval->nomor_surat }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="text-[6.8pt] text-emerald-700 font-semibold mt-0.5">
                            ✓ Dokumen Sah Terverifikasi Sistem BBLKL
                        </div>
                    @endif
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

        @elseif($activeTemplate === 'kemenkes')
        {{-- ========================================================================= --}}
        {{-- TEMPLATE 2: REKOMENDASI TEKNIS PENGENDALIAN VEKTOR STANDAR KEMENKES RI   --}}
        {{-- BERDASARKAN PERMENKES NO. 2 TAHUN 2023 & JUKNIS PVT KEMENKES RI          --}}
        {{-- ========================================================================= --}}

        {{-- 1. KOP SURAT RESMI KEMENKES BBLKL SALATIGA --}}
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="{{ asset('logo_bblkl.png') }}" alt="Logo BBLKL Kemenkes RI" onerror="this.src='{{ asset('kemenkes.png') }}'">
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

        {{-- 2. JUDUL DOKUMEN REKOMENDASI STANDAR TEKNIS KEMENKES RI --}}
        <div class="doc-header">
            @if(!$isApproved)
                <span class="doc-badge" style="background:#fffbeb; color:#b45309; border:1px solid #fcd34d;">DRAFT STANDAR TEKNIS &bull; MENUNGGU PERSETUJUAN KEPALA BBLKL</span>
            @else
                <span class="doc-badge" style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0;">STANDAR OPERASIONAL PVT RESMI DISAHKAN KEPALA BBLKL</span>
            @endif
            <h2 class="doc-title">
                LEMBAR REKOMENDASI TEKNIS MANAJEMEN RESISTENSI INSEKTISIDA VEKTOR
            </h2>
            <div class="doc-meta">
                Nomor Registrasi: <strong>{{ $isApproved && !empty($approval->nomor_surat) ? $approval->nomor_surat : 'RT-VEC/BBLKL/' . date('Y') . '/' . strtoupper(substr(md5($namaWilayah . $tahunFilter . $nyamukFilter . 'kemenkes'), 0, 7)) }}</strong> &bull; Acuan: Permenkes No. 2/2023 & Manual Resistensi Insektisida WHO (2022)
            </div>
        </div>

        {{-- 3. PARAMETER & METADATA EVALUASI TEKNIS --}}
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
            <tr>
                <td class="info-label">Metode Bioassay</td>
                <td class="info-sep">:</td>
                <td class="info-val">WHO Diagnostic Tube / CDC Bottle Bioassay</td>

                <td class="info-label">Klasifikasi Dokumen</td>
                <td class="info-sep">:</td>
                <td class="info-val">Rekomendasi Teknis Entomologi Kesehatan Lingkungan</td>
            </tr>
        </table>

        {{-- 4. STATUS INDEKS KESIAPSIAGAAN VEKTOR STANDAR KEMENKES --}}
        @php
            $alertClassKemenkes = 'alert-banner-kritis';
            if ($alertLevel === 'SEDANG' || $alertLevel === 'WASPADA' || ($alertColor ?? '') === 'amber') {
                $alertClassKemenkes = 'alert-banner-waspada';
            } elseif ($alertLevel === 'RENDAH' || $alertLevel === 'TERKENDALI' || ($alertColor ?? '') === 'emerald') {
                $alertClassKemenkes = 'alert-banner-terkendali';
            }
        @endphp
        <div class="alert-banner {{ $alertClassKemenkes }}">
            <div class="flex items-center justify-between mb-1">
                <span class="text-[8pt] font-extrabold uppercase tracking-wide">
                    STATUS TINGKAT KESIAPSIAGAAN: <strong>{{ $alertBadgeKemenkes }}</strong>
                </span>
                <span class="text-[7.2pt] font-bold">
                    Standar Referensi: Permenkes RI No. 2/2023 & WHO Insecticide Resistance Manual (2022)
                </span>
            </div>
            <p class="text-[7.8pt] font-medium leading-relaxed m-0">
                {{ $alertSummaryKemenkes }}
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
                    <div class="stat-lbl text-rose-700">{{ $totalResisten }} Titik Resisten (&lt; 90% Mortalitas)</div>
                </td>
                <td style="background-color: #fffbeb; border-color: #fde68a;">
                    <div class="stat-val text-amber-700">{{ $persenToleran }}%</div>
                    <div class="stat-lbl text-amber-700">{{ $totalToleran }} Titik Toleran / Terduga (90–97%)</div>
                </td>
                <td style="background-color: #f0fdf4; border-color: #86efac;">
                    <div class="stat-val text-emerald-700">{{ $persenRentan }}%</div>
                    <div class="stat-lbl text-emerald-700">{{ $totalRentan }} Titik Rentan Efektif (&ge; 98%)</div>
                </td>
            </tr>
        </table>

        {{-- 6. VISUALISASI GRAFIK EPIDEMIOLOGIS RESISTENSI (INLINE SESUAI DATA) --}}
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
                    <span class="legend-item"><span class="legend-dot" style="background:#dc2626;"></span> <strong>Resisten (&lt;90%):</strong> {{ $persenResisten }}% ({{ $totalResisten }} uji)</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#d97706;"></span> <strong>Toleran/Terduga (90–97%):</strong> {{ $persenToleran }}% ({{ $totalToleran }} uji)</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#16a34a;"></span> <strong>Rentan Efektif (&ge;98%):</strong> {{ $persenRentan }}% ({{ $totalRentan }} uji)</span>
                </div>
                <div style="font-size: 6.5pt; color: #64748b; font-weight: 600;">
                    Ambang Rotasi MoA WHO: Resisten &ge; 50% | Ambang Waspada: Toleransi &ge; 10%
                </div>
            </div>

            {{-- GRAFIK 2: KOMPARASI SPEKTRUM PER BAHAN AKTIF INSEKTISIDA --}}
            @if(count($matriksInsektisida) > 0)
                <div style="margin-top: 8px; padding-top: 6px; border-top: 1px dashed #cbd5e1;">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="chart-box-title" style="font-size: 7.2pt;">Grafik 2: Komparasi Kerentanan per Bahan Aktif Insektisida Teruji</span>
                        <span class="chart-box-desc">Proporsi Kematian Vektor terhadap Tiap Senyawa Uji</span>
                    </div>

                    @foreach(array_slice($matriksInsektisida, 0, 7) as $m)
                        <div class="chem-chart-row">
                            <div class="chem-name-col" title="{{ $m['nama'] }} ({{ $m['golongan_nama'] }})">
                                <span style="font-weight: 800; color: #0f172a; line-height: 1.15; white-space: nowrap;">{{ $m['nama'] }}</span>
                                <span style="font-size: 5.6pt; color: #64748b; font-weight: 700; margin-top: 1px;">{{ $m['golongan_nama'] }}</span>
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
                                    <span style="color: #dc2626; font-weight: 800; margin-left: 2px;">[ROTASI]</span>
                                @elseif($m['status_aksi'] === 'PENGAWASAN')
                                    <span style="color: #d97706; font-weight: 800; margin-left: 2px;">[UJI PBO]</span>
                                @else
                                    <span style="color: #16a34a; font-weight: 800; margin-left: 2px;">[EFEKTIF]</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- 7. MATRIKS KEPUTUSAN OPERASIONAL STANDAR TEKNIS KEMENKES --}}
        <div class="sec-title">
            II. MATRIKS KEPUTUSAN TEKNIS OPERASIONAL PENGENDALIAN VEKTOR
        </div>
        <table class="doc-table">
            <thead>
                <tr>
                    <th style="width: 28%;">Kategori Standar Teknis</th>
                    <th style="width: 42%;">Daftar Insektisida / Bahan Aktif Teruji</th>
                    <th style="width: 30%;">Arahan Teknis Entomologi & Regulasi PVT Kemenkes</th>
                </tr>
            </thead>
            <tbody>
                {{-- PRIORITAS PENGALIHAN GOLONGAN / ROTASI --}}
                <tr>
                    <td style="background-color: #fef2f2;">
                        <span class="badge-pill badge-moratorium">🛑 PRIORITAS PENGALIHAN GOLONGAN</span>
                        <div class="text-[6.8pt] text-rose-800 mt-1 font-medium">Mortalitas uji bioassay &lt; 90% (Resistensi &ge; 50% atau kematian rendah).</div>
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
                            <span class="text-slate-400 italic">Tidak ada bahan aktif dalam kategori penurunan kerentanan kritis.</span>
                        @endif
                    </td>
                    <td class="text-rose-900 font-medium">
                        <strong>Prioritaskan pengalihan ke golongan kimia berbeda (Mode of Action - MoA IRAC).</strong> Penggunaan terus menerus mempercepat fiksasi alel mutasi resisten. Pada penanggulangan DBD, alihkan ke adultisida golongan lain saat fokus KLB serta optimalkan biolarvasida Bti & PSN 3M-Plus.
                    </td>
                </tr>

                {{-- PENGAWASAN INTENSIF & UJI PBO --}}
                <tr>
                    <td style="background-color: #fffbeb;">
                        <span class="badge-pill badge-pengawasan">⚠️ PENGAWASAN INTENSIF & UJI PBO</span>
                        <div class="text-[6.8pt] text-amber-800 mt-1 font-medium">Mortalitas 90–97% (toleran/terduga resisten) atau resistensi 15–49%.</div>
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
                            <span class="text-slate-400 italic">Tidak ada senyawa dalam kategori pengawasan intensif.</span>
                        @endif
                    </td>
                    <td class="text-amber-900 font-medium">
                        <strong>Batasi frekuensi dan lakukan uji bioassay lanjutan dengan sinergis Piperonyl Butoxide (PBO)</strong> untuk konfirmasi resistensi metabolik. Lakukan kalibrasi droplet size mesin ULV/fogger (VMD 10–30 µm) dan pastikan takaran dosis aplikasi label.
                    </td>
                </tr>

                {{-- REKOMENDASI TEKNIS OPERASIONAL --}}
                <tr>
                    <td style="background-color: #f0fdf4;">
                        <span class="badge-pill badge-rekomendasi">✅ REKOMENDASI OPERASIONAL (RENTAN)</span>
                        <div class="text-[6.8pt] text-emerald-800 mt-1 font-medium">Mortalitas bioassay &ge; 98% (kerentanan populasi tinggi).</div>
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
                        <strong>Direkomendasikan sebagai pilihan teknis utama operasional lapangan</strong> (Adultisida Fogging/ULV pada penanggulangan fokus KLB Dengue atau IRS pada transmisi Malaria). Gunakan pola rotasi terencana agar efikasi bahan aktif tetap terjaga dalam jangka panjang.
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- 8. REKOMENDASI STRATEGI ROTASI INSEKTISIDA (MoA ROTATION) --}}
        @if(count($strategiRotasiKemenkes) > 0)
            <div class="sec-title">
                III. REKOMENDASI SKEMA ROTASI BAHAN AKTIF (MODE OF ACTION ROTATION - IRAC)
            </div>
            <table class="doc-table">
                <thead>
                    <tr>
                        <th style="width: 28%;">Bahan Berstatus Resistensi Tinggi</th>
                        <th style="width: 32%;">Rekomendasi Golongan / Bahan Pengganti</th>
                        <th style="width: 40%;">Rasional Ilmiah Entomologi & Mekanisme Biologis IRAC</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($strategiRotasiKemenkes as $rotasi)
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
            IV. DETAIL HASIL UJI KERENTANAN & STATUS TEKNIS SEMUA INSEKTISIDA
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
                                <span class="badge-pill badge-moratorium">ROTASI</span>
                            @elseif($m['status_aksi'] === 'PENGAWASAN')
                                <span class="badge-pill badge-pengawasan">UJI PBO</span>
                            @else
                                <span class="badge-pill badge-rekomendasi">EFEKTIF</span>
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

        {{-- 10. PANDUAN STANDAR TEKNIS OPERASIONAL BERDASARKAN REGULASI KEMENKES RI --}}
        <div class="sec-title">
            V. PANDUAN STANDAR TEKNIS OPERASIONAL SESUAI REGULASI KEMENKES RI
        </div>

        {{-- 1. ADULTISIDA --}}
        <div class="action-box">
            <div class="action-box-title text-rose-900">
                <span>🔴 1. INTERVENSI STADIUM DEWASA (ADULTISIDA OPERASIONAL)</span>
            </div>
            <ul class="action-box-list">
                <li><strong>Pengasapan (Fogging / ULV) Khusus Penanggulangan Fokus KLB Dengue:</strong> Berdasarkan Permenkes No. 2 Tahun 2023 (sebagai pengganti Permenkes No. 50/2017 yang telah dicabut), aplikasi thermal fogging atau cold fogging (ULV) hanya dibenarkan untuk pemutusan rantai penularan pada penanggulangan fokus KLB Dengue setelah Penyelidikan Epidemiologi (PE) terbukti positif (ditemukan kasus tambahan dan Angka Bebas Jentik &lt; 95%). Dilarang keras melakukan fogging massal rutin tanpa indikasi epidemiologis.</li>
                <li><strong>Indoor Residual Spraying (IRS) untuk Vektor Malaria (Anopheles spp.):</strong> Pada daerah endemis malaria, intervensi ditujukan melalui penyemprotan residu dinding rumah menggunakan insektisida yang memiliki daya tahan residu teruji (Karbamat / Pyrethroid / Organofosfat) dengan cakupan minimal 85% rumah tersemprot.</li>
                <li><strong>Kalibrasi Peralatan Aplikasi Semprot:</strong> Diameter tetesan semprot (Volume Median Diameter / VMD) mesin ULV wajib terkalibrasi antara 10 – 30 µm dan thermal fogger &lt; 50 µm agar kabut insektisida dapat tersuspensi optimal di udara dan kontak dengan tubuh nyamuk terbang.</li>
            </ul>
        </div>

        {{-- 2. LARVASIDA & LINGKUNGAN --}}
        <div class="action-box">
            <div class="action-box-title text-amber-900">
                <span>🟡 2. INTERVENSI STADIUM PRADEWASA (LARVASIDASI BIOLOGIS & PSN 3M-PLUS)</span>
            </div>
            <ul class="action-box-list">
                <li><strong>Aplikasi Biolarvasida Bti & IGR:</strong> Prioritaskan pembasmian jentik menggunakan larvasida biologis <em>Bacillus thuringiensis israelensis</em> (Bti) dan <em>Insect Growth Regulator</em> (IGR seperti Pyriproxyfen) pada tempat perindukan yang sulit dikuras. Formulasi biologi ini tidak menimbulkan resistensi silang dengan insektisida racun saraf nyamuk dewasa.</li>
                <li><strong>Pemberantasan Sarang Nyamuk (PSN 3M-Plus) & G1R1J:</strong> Gerakan 1 Rumah 1 Jumantik (G1R1J) adalah pilar fundamental pencegahan tular vektor berbasis pemberdayaan masyarakat. Pengendalian mekanis dan fisik lingkungan terbukti paling efektif dan aman tanpa resiko resistensi kimiawi.</li>
                <li><strong>Uji Bioassay Konfirmasi Sinergis PBO:</strong> Untuk wilayah dengan status toleran, wajib dilakukan uji bioassay konfirmasi lanjutan dengan penambahan Piperonyl Butoxide (PBO) guna menguji peranan enzim detoksifikasi sitokrom P450 sebelum melakukan perubahan formulasi.</li>
            </ul>
        </div>

        {{-- 3. PERENCANAAN ANGGARAN & PENGADAAN --}}
        <div class="action-box">
            <div class="action-box-title text-emerald-900">
                <span>🟢 3. REKOMENDASI TEKNIS SPESIFIKASI PENGADAAN & SURVEILANS (APBD / BOK / E-KATALOG)</span>
            </div>
            <ul class="action-box-list">
                <li><strong>Harmonisasi Rencana Kebutuhan Obat & Insektisida (RKOI):</strong> Dinas Kesehatan Provinsi dan Kabupaten/Kota menyusun spesifikasi kebutuhan belanja racun serangga dalam e-Katalog / DAK Fisik / BOK dengan mengacu pada hasil pengujian bioassay lokal ini. Prioritaskan produk yang terdaftar resmi di Komisi Pestisida (Kementan/Kemenkes) dengan formulasi yang terbukti rentan.</li>
                <li><strong>Alokasi Anggaran Surveilans Entomologi Berkala:</strong> Menjamin tersedianya dukungan operasional bagi kegiatan surveilans kerentanan vektor berkala (minimal 1 kali per tahun) oleh Dinas Kesehatan setempat dengan pendampingan teknis dan pengujian laboratorium dari Tim Kerja Surveilans Penyakit, Faktor Risiko Kesehatan dan KLB BBLKL Kemenkes RI Salatiga.</li>
                <li><strong>Landasan Yuridis & Teknis Acuan:</strong> Pelaksanaan pengendalian vektor berpedoman pada Peraturan Menteri Kesehatan RI Nomor 2 Tahun 2023 tentang Peraturan Pelaksanaan PP No. 66/2014 tentang Kesehatan Lingkungan (menggantikan Permenkes No. 50/2017 yang telah dicabut), serta WHO Manual for Monitoring Insecticide Resistance in Mosquito Vectors and Selecting Appropriate Interventions (Edisi 2022).</li>
            </ul>
        </div>

        {{-- CATATAN, MASUKAN & DISPOSISI KHUSUS PIMPINAN / TIM AHLI (ONLINE EDITABLE) --}}
        <div class="custom-notes-section" style="margin: 12px 0 10px 0; border: 1.5px solid #0d9488; background: #f0fdfa; border-radius: 6px; padding: 9px 13px; page-break-inside: avoid;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; border-bottom: 1px solid #ccfbf1; padding-bottom: 3px;">
                <div style="font-size: 7.6pt; font-weight: 800; color: #0f766e; text-transform: uppercase; letter-spacing: 0.4px; display: flex; align-items: center; gap: 5px;">
                    <span>📝 CATATAN, MASUKAN &amp; DISPOSISI KHUSUS PIMPINAN / TIM AHLI</span>
                </div>
                <div class="edit-online-badge no-print" style="display: none; font-size: 6.2pt; font-weight: 700; color: #0f766e; background: #ccfbf1; border: 1px dashed #0d9488; padding: 2px 7px; border-radius: 4px;">
                    ✏️ Mode Edit Online Aktif — Klik teks di bawah untuk mengubah
                </div>
            </div>
            
            <div id="editableNotesBox" class="editable-notes-content" style="font-size: 7.2pt; line-height: 1.6; color: #1e293b; min-height: 44px; white-space: pre-wrap;">{{ $approval && !empty($approval->notes) ? $approval->notes : "• Penyesuaian formulasi insektisida di wilayah kantong resistensi tinggi wajib dikoordinasikan dengan Pengelola Program P2P Dinas Kesehatan setempat.\n• Prioritaskan aplikasi larvasida biologi (Bti) dan penguatan Gerakan 1 Rumah 1 Jumantik (G1R1J) pada pemukiman padat.\n• Pelaksanaan rotasi MoA insektisida wajib dievaluasi kembali melalui surveilans bioassay berkala." }}</div>

            <div class="no-print" style="margin-top: 6px; padding-top: 4px; border-top: 1px dashed #99f6e4; display: flex; justify-content: space-between; align-items: center; font-size: 6.5pt; color: #0f766e;">
                <div class="flex items-center gap-2">
                    <span>💡 <em>Masukan di atas tersimpan otomatis dan akan tercetak resmi pada dokumen rekomendasi.</em></span>
                    <span class="saveStatusIndicator font-bold text-emerald-700" style="display: none;">✓ Tersimpan</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="addBulletPoint()" class="edit-mode-btn" style="display: none; padding: 2px 7px; background: #0d9488; color: #fff; border-radius: 4px; font-weight: 700; cursor: pointer; border: none; font-size: 6.5pt;">
                        ➕ Tambah Butir
                    </button>
                    <button type="button" onclick="saveNotesOnline()" class="edit-mode-btn" style="display: none; padding: 2px 8px; background: #059669; color: #fff; border-radius: 4px; font-weight: 700; cursor: pointer; border: none; font-size: 6.5pt;">
                        💾 Simpan
                    </button>
                </div>
            </div>
        </div>

        {{-- 11. LEMBAR PENGESAHAN & DISPOSISI RESMI --}}
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
                        Salatiga, {{ $isApproved ? \Carbon\Carbon::parse($approval->approved_at)->isoFormat('D MMMM Y') : \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>
                        <strong>Disahkan Oleh:<br>Kepala Balai Besar Laboratorium Kesehatan Lingkungan Salatiga</strong>
                    </div>
                    @if(!$isApproved)
                        <div style="border:1.5px dashed #f59e0b; background:#fffbeb; padding:7px 14px; border-radius:6px; display:inline-block; text-align:center; min-width:230px; margin:4px 0;">
                            <span style="font-size:7.5pt; font-weight:800; color:#b45309; display:block; text-transform:uppercase;">⚠️ STATUS: DRAFT</span>
                            <span style="font-size:6.8pt; color:#92400e; display:block; margin-top:2px;">Menunggu Pengesahan Standar Teknis<br>Kepala BBLKL Kemenkes RI</span>
                            <div style="height:24px;"></div>
                            <span style="font-size:7.5pt; color:#64748b; font-weight:700;">( Belum Disahkan )</span>
                        </div>
                        <div class="text-[6.8pt] text-amber-700 italic mt-0.5">
                            Menunggu persetujuan pimpinan BBLKL
                        </div>
                    @else
                        <div style="border:1.5px solid #059669; background:#f0fdf4; padding:7px 12px; border-radius:6px; display:inline-block; text-align:left; min-width:240px; margin:4px 0;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="font-size:22pt; line-height:1;">🛡️</div>
                                <div>
                                    <div style="font-size:6.5pt; font-weight:800; color:#065f46; letter-spacing:0.4px; text-transform:uppercase;">Disahkan Secara Digital:</div>
                                    <div style="font-size:8.5pt; font-weight:800; color:#0f172a; border-bottom:1px solid #10b981; padding-bottom:1px;">{{ $approval->approver_name }}</div>
                                    <div style="font-size:6.8pt; color:#334155; margin-top:2px;">NIP. {{ $approval->approver_nip ?? '-' }}</div>
                                    <div style="font-size:6.5pt; color:#047857; font-weight:600;">{{ $approval->approver_jabatan }}</div>
                                    <div style="font-size:6pt; color:#64748b; margin-top:2px;">Disahkan: {{ \Carbon\Carbon::parse($approval->approved_at)->isoFormat('D MMMM Y, HH:mm') }} WIB</div>
                                    <div style="font-size:5.8pt; font-family:monospace; color:#059669; font-weight:700;">NO. REG: {{ $approval->nomor_surat }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="text-[6.8pt] text-emerald-700 font-semibold mt-0.5">
                            ✓ Standar Teknis Sah Terverifikasi Sistem BBLKL
                        </div>
                    @endif
                </td>
            </tr>
        </table>

        {{-- 12. FOOTER DOKUMEN --}}
        <div class="doc-footer">
            <span>
                Dokumen resmi Standar Teknis Kemenkes ini diproduksi oleh Sistem Informasi Resistensi Insektisida (SI-RESISTENSI) BBLKL Kemenkes RI.
            </span>
            <span>
                Halaman 1 dari 1 (Dokumen Sah Tanpa Stempel Basah) &bull; Dicetak: {{ date('d/m/Y H:i') }} WIB
            </span>
        </div>

        @elseif($activeTemplate === 'laboratorium')
        {{-- ========================================================================= --}}
        {{-- TEMPLATE 3: REKOMENDASI TEKNIS LABORATORIUM                              --}}
        {{-- SESUAI: WHO Manual for Monitoring Insecticide Resistance in Mosquito      --}}
        {{-- Vectors and Selecting Appropriate Interventions (WHO, Juni 2022)          --}}
        {{-- Kriteria WHO Tube Test: Rentan ≥98% | Kemungkinan Resisten 90-97%        --}}
        {{--                        Dikonfirmasi Resisten <90% mortalitas 24 jam       --}}
        {{-- CATATAN: Dokumen ini adalah KELUARAN LABORATORIUM, bukan penetapan        --}}
        {{-- status wilayah. Penetapan status adalah kewenangan Dirjen P2P/Dinkes.    --}}
        {{-- ========================================================================= --}}

        {{-- KOP SURAT RESMI KEMENKES BBLKL SALATIGA --}}
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="{{ asset('logo_bblkl.png') }}" alt="Logo BBLKL Kemenkes RI" onerror="this.src='{{ asset('kemenkes.png') }}'">
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
                <td class="kop-spacer">
                    {{-- Spacer kanan penyeimbang simetris --}}
                </td>
            </tr>
        </table>
        <div class="kop-divider"></div>

        {{-- JUDUL DOKUMEN --}}
        <div class="doc-header">
            @if(!$isApproved)
                <span class="doc-badge" style="background:#fffbeb; color:#b45309; border:1px solid #fcd34d;">DRAFT LAPORAN LABORATORIUM &bull; MENUNGGU PERSETUJUAN KEPALA BBLKL</span>
            @else
                <span class="doc-badge" style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0;">KELUARAN LABORATORIUM RESMI TELAH DISAHKAN KEPALA BBLKL</span>
            @endif
            <h2 class="doc-title">
                LAPORAN TEKNIS PEMANTAUAN KERENTANAN INSEKTISIDA VEKTOR
            </h2>
        </div>

        {{-- PARAMETER EVALUASI --}}
        <div class="section-box" style="margin-bottom:10px;">
            <div class="section-title" style="color:#5b21b6;">I. PARAMETER EVALUASI DAN CAKUPAN DATA</div>
            <table style="width:100%; font-size:7.5pt; border-collapse:collapse;">
                <tr>
                    <td style="width:50%; padding:2px 4px;"><strong>Cakupan Wilayah:</strong> {{ $namaWilayah }}</td>
                    <td style="width:50%; padding:2px 4px;"><strong>Periode:</strong> {{ $tahunFilter }}</td>
                </tr>
                <tr>
                    <td style="padding:2px 4px;"><strong>Spesies Filter:</strong> {{ $nyamukFilter }}</td>
                    <td style="padding:2px 4px;"><strong>Tanggal Cetak:</strong> {{ date('d F Y') }}</td>
                </tr>
                <tr>
                    <td style="padding:2px 4px;"><strong>Total Pengujian (titik uji):</strong> {{ number_format($totalPemeriksaan) }}</td>
                    <td style="padding:2px 4px;"><strong>Total Sampel Nyamuk:</strong> {{ number_format($totalSampel) }}</td>
                </tr>
                <tr>
                    <td style="padding:2px 4px;"><strong>Rata-rata Sampel per Pengujian:</strong>
                        <span style="color:{{ $rataRataSampelPerUji < 20 ? '#dc2626' : '#16a34a' }}; font-weight:bold;">
                            {{ $rataRataSampelPerUji }} nyamuk/uji
                        </span>
                        @if($rataRataSampelPerUji < 20)
                            <span style="color:#dc2626;"> ⚠ Di bawah minimum WHO (20–25 nyamuk/uji per ulangan)</span>
                        @endif
                    </td>
                    <td style="padding:2px 4px;"><strong>Metode Acuan:</strong> WHO Tube Test &amp; Bottle Bioassay SOP (2022)</td>
                </tr>
            </table>
        </div>

        {{-- CATATAN PENTING --}}
        <div style="background:#f5f3ff; border:1.5px solid #7c3aed; border-radius:5px; padding:7px 10px; margin-bottom:10px; font-size:7.3pt;">
            <strong style="color:#5b21b6;">⚠ CATATAN PENTING INTERPRETASI HASIL:</strong>
            <ol style="margin:4px 0 0 14px; padding:0; line-height:1.6;">
                <li>Dokumen ini merupakan <strong>keluaran laboratorium</strong> berdasarkan data uji bioassay yang tersimpan dalam sistem. Dokumen ini <strong>bukan</strong> penetapan status resistensi wilayah. Penetapan status wilayah dan keputusan operasional adalah kewenangan <strong>Dirjen Pencegahan dan Pengendalian Penyakit (P2P) Kemenkes RI</strong> atau <strong>Dinas Kesehatan</strong> setempat.</li>
                <li>Kriteria WHO Tube Test (24 jam, 2022): <strong>Rentan ≥98%</strong> mortalitas | <strong>Kemungkinan Resisten: 90–97%</strong> mortalitas | <strong>Dikonfirmasi Resisten: &lt;90%</strong> mortalitas. Database menyimpan status interpretatif (Rentan/Toleran/Resisten) yang dipetakan ke kriteria ini.</li>
                <li>Rekomendasi teknis hanya berlaku untuk bahan aktif yang <strong>memiliki data lokal</strong> dalam rentang filter. Bahan tanpa data lokal tidak dapat direkomendasikan.</li>
                <li>Rata-rata {{ $rataRataSampelPerUji }} nyamuk per pengujian. WHO merekomendasikan minimum 20–25 nyamuk per tabung per ulangan, minimum 3 ulangan (WHO Manual 2022, hal. 12). Data dengan sampel sangat kecil perlu konfirmasi.</li>
                <li>Data agregat "Seluruh Spesies" dan "Semua Periode" <strong>tidak boleh dijadikan dasar rekomendasi operasional</strong>. Gunakan filter spesifik per spesies, kabupaten, dan tahun.</li>
                <li>Uji larva (larvasida/Temephos) dan uji imago dewasa (adultisida) menggunakan metode dan kriteria berbeda, <strong>tidak boleh digabungkan</strong> dalam satu kesimpulan.</li>
            </ol>
        </div>

        {{-- MATRIKS PER SPESIES --}}
        <div class="section-box" style="margin-bottom:10px;">
            <div class="section-title" style="color:#5b21b6;">II. MATRIKS HASIL PER SPESIES (Kriteria WHO Tube Test 2022)</div>
            <p style="font-size:7pt; color:#6b7280; margin:2px 0 6px;">Data dikelompokkan per spesies. {{ $nyamukFilter === 'Semua' ? '⚠ Filter spesies = Semua – lihat catatan no. 5 di atas.' : 'Filter spesies aktif: ' . $nyamukFilter }}</p>

            @if(count($matriksPerSpesies) > 0)
                @foreach($matriksPerSpesies as $spesies => $bahanList)
                    <div style="margin-bottom:8px;">
                        <div style="background:#ede9fe; padding:3px 7px; border-radius:4px; font-size:7.5pt; font-weight:800; color:#5b21b6; margin-bottom:4px;">
                            🦟 {{ $spesies }}
                        </div>
                        <table style="width:100%; border-collapse:collapse; font-size:7pt;">
                            <thead>
                                <tr style="background:#f5f3ff;">
                                    <th style="border:1px solid #c4b5fd; padding:3px 5px; text-align:left;">Bahan Aktif</th>
                                    <th style="border:1px solid #c4b5fd; padding:3px 5px; text-align:left;">Golongan / IRAC MoA</th>
                                    <th style="border:1px solid #c4b5fd; padding:3px 5px; text-align:center;">Titik Uji</th>
                                    <th style="border:1px solid #c4b5fd; padding:3px 5px; text-align:center;">∅ Smpl/Uji</th>
                                    <th style="border:1px solid #c4b5fd; padding:3px 5px; text-align:center;">Rentan (%)</th>
                                    <th style="border:1px solid #c4b5fd; padding:3px 5px; text-align:center;">Kmgk Resisten (%)</th>
                                    <th style="border:1px solid #c4b5fd; padding:3px 5px; text-align:center;">Dikonfirmasi Resisten (%)</th>
                                    <th style="border:1px solid #c4b5fd; padding:3px 5px; text-align:center;">Status WHO 2022</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bahanList as $bahan)
                                    @php
                                        $bgRow = $bahan['who_color'] === 'rose' ? '#fff1f2' : ($bahan['who_color'] === 'amber' ? '#fffbeb' : '#f0fdf4');
                                        $txtStatus = $bahan['who_color'] === 'rose' ? '#be123c' : ($bahan['who_color'] === 'amber' ? '#b45309' : '#15803d');
                                    @endphp
                                    <tr style="background:{{ $bgRow }};">
                                        <td style="border:1px solid #ddd; padding:3px 5px; font-weight:700;">{{ $bahan['nama'] }}</td>
                                        <td style="border:1px solid #ddd; padding:3px 5px; font-size:6.5pt; color:#555;">{{ $bahan['golongan_nama'] }}<br><span style="color:#7c3aed;">{{ $bahan['irac_moa'] }}</span></td>
                                        <td style="border:1px solid #ddd; padding:3px 5px; text-align:center;">{{ $bahan['total_uji'] }}</td>
                                        <td style="border:1px solid #ddd; padding:3px 5px; text-align:center; color:{{ $bahan['rata_sampel'] < 20 ? '#dc2626' : '#374151' }};">
                                            {{ $bahan['rata_sampel'] }}
                                            @if($bahan['rata_sampel'] < 20) ⚠ @endif
                                        </td>
                                        <td style="border:1px solid #ddd; padding:3px 5px; text-align:center; color:#15803d; font-weight:700;">{{ $bahan['pct_rentan'] }}%<br><small style="font-weight:400;">({{ $bahan['rentan'] }} uji)</small></td>
                                        <td style="border:1px solid #ddd; padding:3px 5px; text-align:center; color:#b45309; font-weight:700;">{{ $bahan['pct_toleran'] }}%<br><small style="font-weight:400;">({{ $bahan['toleran'] }} uji)</small></td>
                                        <td style="border:1px solid #ddd; padding:3px 5px; text-align:center; color:#be123c; font-weight:700;">{{ $bahan['pct_resisten'] }}%<br><small style="font-weight:400;">({{ $bahan['resisten'] }} uji)</small></td>
                                        <td style="border:1px solid #ddd; padding:3px 5px; text-align:center; color:{{ $txtStatus }}; font-weight:800; font-size:7pt;">{{ $bahan['status_who'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @else
                <div style="text-align:center; padding:15px; color:#9ca3af; font-size:8pt;">Tidak ada data pengujian dalam rentang filter yang dipilih.</div>
            @endif
        </div>

        {{-- INTERPRETASI & CATATAN TEKNIS PER BAHAN (Agregat) --}}
        <div class="section-box" style="margin-bottom:10px;">
            <div class="section-title" style="color:#5b21b6;">III. RINGKASAN STATUS DAN CATATAN TEKNIS</div>

            {{-- A. Dikonfirmasi Resisten --}}
            @if(count($dilarangList) > 0)
            <div style="margin-bottom:6px;">
                <div style="background:#fff1f2; border-left:3px solid #be123c; padding:4px 8px; border-radius:3px; font-size:7.3pt; font-weight:800; color:#be123c; margin-bottom:3px;">❌ DIKONFIRMASI RESISTEN (Proporsi Resisten Dominan – <90% Mortalitas pada Banyak Uji)</div>
                @foreach($dilarangList as $item)
                <div style="background:#fff8f8; border:1px solid #fca5a5; border-radius:3px; padding:4px 7px; margin-bottom:3px; font-size:7pt;">
                    <strong style="color:#be123c;">{{ $item['nama'] }}</strong>
                    <span style="color:#555;"> – {{ $item['golongan_nama'] }} | <span style="color:#7c3aed;">{{ $item['irac_moa'] }}</span></span><br>
                    <span>Resisten: <strong>{{ $item['pctResisten'] }}%</strong> | Kemungkinan Resisten: {{ $item['pctToleran'] }}% | Rentan: {{ $item['pctRentan'] }}% | Total uji: {{ $item['totalUji'] }} | ∅ {{ $item['rataSmpl'] }} smpl/uji</span><br>
                    <span style="color:#b91c1c;"><em>Catatan: Tidak dapat direkomendasikan untuk program operasional. Lakukan bioassay konfirmasi ulang sebelum mempertimbangkan kembali penggunaan bahan ini.</em></span>
                </div>
                @endforeach
            </div>
            @endif

            {{-- B. Kemungkinan Resisten --}}
            @if(count($pengawasanList) > 0)
            <div style="margin-bottom:6px;">
                <div style="background:#fffbeb; border-left:3px solid #b45309; padding:4px 8px; border-radius:3px; font-size:7.3pt; font-weight:800; color:#b45309; margin-bottom:3px;">⚠ KEMUNGKINAN RESISTEN (Mortalitas 90–97% pada Sebagian Uji – Perlu Konfirmasi)</div>
                @foreach($pengawasanList as $item)
                <div style="background:#fffef0; border:1px solid #fcd34d; border-radius:3px; padding:4px 7px; margin-bottom:3px; font-size:7pt;">
                    <strong style="color:#b45309;">{{ $item['nama'] }}</strong>
                    <span style="color:#555;"> – {{ $item['golongan_nama'] }} | <span style="color:#7c3aed;">{{ $item['irac_moa'] }}</span></span><br>
                    <span>Kemungkinan Resisten: <strong>{{ $item['pctToleran'] }}%</strong> | Resisten: {{ $item['pctResisten'] }}% | Rentan: {{ $item['pctRentan'] }}% | Total uji: {{ $item['totalUji'] }} | ∅ {{ $item['rataSmpl'] }} smpl/uji</span><br>
                    <span style="color:#92400e;"><em>Catatan: Lakukan uji bioassay konfirmasi ulang (≥3 ulangan, ≥25 nyamuk/uji). Pertimbangkan uji sinergis PBO untuk identifikasi mekanisme enzymatic detoxification (P450 monooxygenase, esterase).</em></span>
                </div>
                @endforeach
            </div>
            @endif

            {{-- C. Masih Rentan --}}
            @if(count($direkomendasikanList) > 0)
            <div style="margin-bottom:6px;">
                <div style="background:#f0fdf4; border-left:3px solid #15803d; padding:4px 8px; border-radius:3px; font-size:7.3pt; font-weight:800; color:#15803d; margin-bottom:3px;">✅ MASIH RENTAN (Mortalitas ≥98% Dominan – Dapat Dilanjutkan dengan Pemantauan)</div>
                @foreach($direkomendasikanList as $item)
                <div style="background:#f7fef7; border:1px solid #86efac; border-radius:3px; padding:4px 7px; margin-bottom:3px; font-size:7pt;">
                    <strong style="color:#15803d;">{{ $item['nama'] }}</strong>
                    <span style="color:#555;"> – {{ $item['golongan_nama'] }} | <span style="color:#7c3aed;">{{ $item['irac_moa'] }}</span></span><br>
                    <span>Rentan: <strong>{{ $item['pctRentan'] }}%</strong> | Kemungkinan Resisten: {{ $item['pctToleran'] }}% | Resisten: {{ $item['pctResisten'] }}% | Total uji: {{ $item['totalUji'] }} | ∅ {{ $item['rataSmpl'] }} smpl/uji</span><br>
                    <span style="color:#166534;"><em>Catatan: Pertahankan pemantauan berkala kerentanan. Pastikan dosis dan konsentrasi diskriminator sesuai WHO Manual 2022.</em></span>
                </div>
                @endforeach
            </div>
            @endif

            @if(count($dilarangList) === 0 && count($pengawasanList) === 0 && count($direkomendasikanList) === 0)
                <div style="text-align:center; padding:12px; color:#9ca3af; font-size:8pt;">Tidak ada data insektisida dalam filter yang dipilih.</div>
            @endif
        </div>

        {{-- CATATAN ROTASI MoA --}}
        @if(count($dilarangList) > 0)
        <div class="section-box" style="margin-bottom:10px;">
            <div class="section-title" style="color:#5b21b6;">IV. CATATAN TEKNIS ROTASI MODE OF ACTION (MoA)</div>
            <div style="font-size:7.3pt; line-height:1.7; color:#374151;">
                @foreach($strategiRotasi as $rotasi)
                <div style="border:1px solid #ddd; border-radius:4px; padding:5px 8px; margin-bottom:5px; background:#fafafa;">
                    <div><strong style="color:#be123c;">Bahan yang tidak direkomendasikan:</strong> {{ $rotasi['dilarang'] }}</div>
                    <div style="color:#7c3aed; font-size:6.8pt;">IRAC MoA: {{ $rotasi['irac_moa'] }}</div>
                    <div style="margin-top:3px;"><strong>Catatan alternatif:</strong> {{ $rotasi['alternatif'] }}</div>
                    <div style="color:#6b7280; margin-top:2px;"><em>{{ $rotasi['alasan'] }}</em></div>
                </div>
                @endforeach

                <div style="background:#f5f3ff; border:1px solid #c4b5fd; border-radius:4px; padding:6px 9px; margin-top:6px; font-size:7pt;">
                    <strong style="color:#5b21b6;">📌 Keterangan Rotasi MoA (IRAC Insecticide Resistance Management):</strong><br>
                    • Rotasi MoA yang <strong>valid</strong>: Pyrethroid (IRAC 3A) ↔ Organofosfat (IRAC 1B) ↔ Biolarvasida Bti (IRAC 11A)<br>
                    • Rotasi <strong>tidak valid sebagai anti-resistance strategy</strong>: Organofosfat (1B) ↔ Karbamat (1A) — keduanya menginhibisi enzim AChE, hanya berbeda reversibilitas ikatan.<br>
                    • Pyriproxyfen adalah <strong>Juvenile Hormone Analog (JHA, IRAC 7C)</strong> — bukan penghambat sintesis kitin (CSI). Penghambat kitin = Benzoylurea/Diflubenzuron (IRAC 15).<br>
                    • Temephos = larvasida organofosfat untuk stadium pradewasa. Tidak dapat dibandingkan langsung dengan adultisida untuk dewasa.<br>
                    • Sumber: IRAC Mode of Action Classification Scheme v11.0 (2023), WHO Manual for Monitoring Insecticide Resistance in Mosquito Vectors (2022).
                </div>
            </div>
        </div>
        @endif

        {{-- CATATAN, MASUKAN & DISPOSISI KHUSUS PIMPINAN / TIM AHLI (ONLINE EDITABLE) --}}
        <div class="custom-notes-section" style="margin: 12px 0 10px 0; border: 1.5px solid #0d9488; background: #f0fdfa; border-radius: 6px; padding: 9px 13px; page-break-inside: avoid;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; border-bottom: 1px solid #ccfbf1; padding-bottom: 3px;">
                <div style="font-size: 7.6pt; font-weight: 800; color: #0f766e; text-transform: uppercase; letter-spacing: 0.4px; display: flex; align-items: center; gap: 5px;">
                    <span>📝 CATATAN, MASUKAN &amp; DISPOSISI KHUSUS PIMPINAN / TIM AHLI</span>
                </div>
                <div class="edit-online-badge no-print" style="display: none; font-size: 6.2pt; font-weight: 700; color: #0f766e; background: #ccfbf1; border: 1px dashed #0d9488; padding: 2px 7px; border-radius: 4px;">
                    ✏️ Mode Edit Online Aktif — Klik teks di bawah untuk mengubah
                </div>
            </div>
            
            <div id="editableNotesBox" class="editable-notes-content" style="font-size: 7.2pt; line-height: 1.6; color: #1e293b; min-height: 44px; white-space: pre-wrap;">{{ $approval && !empty($approval->notes) ? $approval->notes : "• Penyesuaian formulasi insektisida di wilayah kantong resistensi tinggi wajib dikoordinasikan dengan Pengelola Program P2P Dinas Kesehatan setempat.\n• Prioritaskan aplikasi larvasida biologi (Bti) dan penguatan Gerakan 1 Rumah 1 Jumantik (G1R1J) pada pemukiman padat.\n• Pelaksanaan rotasi MoA insektisida wajib dievaluasi kembali melalui surveilans bioassay berkala." }}</div>

            <div class="no-print" style="margin-top: 6px; padding-top: 4px; border-top: 1px dashed #99f6e4; display: flex; justify-content: space-between; align-items: center; font-size: 6.5pt; color: #0f766e;">
                <div class="flex items-center gap-2">
                    <span>💡 <em>Masukan di atas tersimpan otomatis dan akan tercetak resmi pada dokumen rekomendasi.</em></span>
                    <span class="saveStatusIndicator font-bold text-emerald-700" style="display: none;">✓ Tersimpan</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="addBulletPoint()" class="edit-mode-btn" style="display: none; padding: 2px 7px; background: #0d9488; color: #fff; border-radius: 4px; font-weight: 700; cursor: pointer; border: none; font-size: 6.5pt;">
                        ➕ Tambah Butir
                    </button>
                    <button type="button" onclick="saveNotesOnline()" class="edit-mode-btn" style="display: none; padding: 2px 8px; background: #059669; color: #fff; border-radius: 4px; font-weight: 700; cursor: pointer; border: none; font-size: 6.5pt;">
                        💾 Simpan
                    </button>
                </div>
            </div>
        </div>

        {{-- TANDA TANGAN --}}
        <table class="sig-container" style="margin-top:10px;">
            <tr>
                <td class="sig-cell">
                    <div class="sig-place-date">Salatiga, {{ date('d F Y') }}</div>
                    <div class="sig-title">Penanggung Jawab Pengujian</div>
                    <div class="sig-space"></div>
                    <div class="sig-name">( ________________________ )</div>
                    <div class="sig-sub">Fungsional Entomolog Kesehatan</div>
                </td>
                <td class="sig-cell">
                    <div class="sig-place-date">Salatiga, {{ date('d F Y') }}</div>
                    <div class="sig-title">Kepala Tim Kerja / Koordinator</div>
                    <div class="sig-space"></div>
                    <div class="sig-name">( _________________________ )</div>
                    <div class="sig-sub">Ketua Tim Kerja Surveilans Penyakit,<br>Faktor Risiko Kesehatan dan KLB<br>BBLKL Salatiga</div>
                </td>
                <td class="sig-cell">
                    <div class="sig-place-date">Salatiga, {{ $isApproved ? \Carbon\Carbon::parse($approval->approved_at)->isoFormat('D MMMM Y') : \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</div>
                    <div class="sig-title">Kepala Balai</div>
                    @if(!$isApproved)
                        <div style="border:1.5px dashed #f59e0b; background:#fffbeb; padding:6px 10px; border-radius:6px; display:inline-block; text-align:center; min-width:180px; margin:4px 0;">
                            <span style="font-size:7pt; font-weight:800; color:#b45309; display:block;">⚠️ DRAFT BELUM DISAHKAN</span>
                            <span style="font-size:6.5pt; color:#92400e;">Menunggu Verifikasi &amp; Tanda Tangan</span>
                            <div style="height:18px;"></div>
                            <span style="font-size:7pt; color:#64748b;">( Belum Disahkan )</span>
                        </div>
                    @else
                        <div style="border:1.5px solid #059669; background:#f0fdf4; padding:5px 8px; border-radius:6px; display:inline-block; text-align:left; min-width:190px; margin:4px 0;">
                            <div style="font-size:6pt; font-weight:800; color:#065f46; text-transform:uppercase;">Disahkan Digital:</div>
                            <div style="font-size:7.5pt; font-weight:800; color:#0f172a;">{{ $approval->approver_name }}</div>
                            <div style="font-size:6.2pt; color:#334155;">NIP. {{ $approval->approver_nip ?? '-' }}</div>
                            <div style="font-size:5.8pt; color:#059669; font-weight:700;">REG: {{ $approval->nomor_surat }}</div>
                            <div style="font-size:5.5pt; color:#64748b;">{{ \Carbon\Carbon::parse($approval->approved_at)->isoFormat('D MMM Y, HH:mm') }}</div>
                        </div>
                    @endif
                    <div class="sig-sub" style="margin-top:2px;">Kepala Balai Besar Laboratorium Kesehatan Lingkungan<br>Salatiga</div>
                </td>
            </tr>
        </table>

        {{-- FOOTER --}}
        <div class="doc-footer">
            <span>
                Laporan teknis laboratorium ini diproduksi oleh Sistem Informasi Resistensi Insektisida (SI-RESISTENSI) BBLKL Kemenkes RI.
                Acuan: WHO Manual for Monitoring Insecticide Resistance in Mosquito Vectors (Juni 2022) &bull; IRAC MoA Classification Scheme v11.0 (2023).
            </span>
            <span>
                Halaman 1 dari 1 &bull; Dicetak: {{ date('d/m/Y H:i') }} WIB
            </span>
        </div>

        @elseif($activeTemplate === 'agregat')
        {{-- ========================================================================= --}}
        {{-- TEMPLATE 4: POLICY BRIEF AGREGAT WILAYAH & KLASTER KERENTANAN INSEKTISIDA --}}
        {{-- FORMAT PERSIS SESUAI ACUAN CONTOH DINAS KESEHATAN PROVINSI                --}}
        {{-- ========================================================================= --}}

        {{-- HALAMAN 1: CAKUPAN DATA, MATRIKS KABUPATEN & KLASTER IMPLIKASINYA --}}
        <div class="agr-page-1">

            {{-- 1. HEADER UTAMA (DARK PINE TEAL) --}}
            <div class="agr-header">
                <div class="agr-tag">
                    DINAS KESEHATAN PROVINSI &bull; REKOMENDASI TEKNIS AGREGAT
                </div>
                <h1 class="agr-title">
                    Resistensi Insektisida pada Nyamuk {{ $nyamukFilter === 'Semua' ? 'Vektor (Aedes, Anopheles, Culex)' : $nyamukFilter }}<br>
                    di {{ $selectedProvinsi ? 'Provinsi ' . $selectedProvinsi->name : $namaWilayah }}
                </h1>
                <div class="agr-subtitle">
                    {{ $agregatData['totalKabupatenDiWilayah'] }} kabupaten/kota &bull; Uji tabung WHO &bull; Data {{ $tahunFilter === 'Semua' ? 'Semua Periode Tercatat' : 'Tahun ' . $tahunFilter }}
                </div>
                <div class="agr-pill-container">
                    <span class="agr-pill">
                        Status: {{ $isApproved ? 'RESMI, telah disahkan Kepala BBLKL' : 'DRAF, menunggu verifikasi pakar' }}
                    </span>
                    <span class="agr-pill">
                        Nomor: {{ $isApproved && !empty($approval->nomor_surat) ? $approval->nomor_surat : 'CONTOH-PROV-' . date('Y') . '-' . strtoupper(substr(md5($namaWilayah . $tahunFilter . $nyamukFilter), 0, 4)) }}
                    </span>
                </div>
            </div>

            {{-- 2. BANNER CATATAN AGREGAT (PALE PEACH) --}}
            <div class="agr-notice-banner">
                CATATAN DOKUMEN AGREGAT: Berdasarkan data pengujian bioassay riil sistem SI-RESISTENSI. Rekomendasi teknis operasional pengendalian vektor wilayah.
            </div>

            {{-- 3. BAGIAN: HAL PERTAMA YANG PERLU DIKETAHUI: CAKUPAN DATA --}}
            <div style="margin-bottom: 12px;">
                <h2 class="agr-sec-heading">Hal pertama yang perlu diketahui: cakupan data</h2>
                <div class="agr-sec-sub">
                    Hasil di bawah hanya berlaku untuk kabupaten/kota yang sudah diuji. Tidak diekstrapolasi ke yang belum.
                </div>

                {{-- 4 KARTU METRIK UTAMA --}}
                <div class="agr-stat-grid">
                    <div class="agr-stat-card" style="background:#f1f5f9;">
                        <div class="num" style="color:#1e293b;">{{ $agregatData['totalKabupatenDiWilayah'] }}</div>
                        <div class="lbl" style="color:#475569;">kabupaten/kota total</div>
                    </div>
                    <div class="agr-stat-card" style="background:#e6f4ea;">
                        <div class="num" style="color:#15803d;">{{ $agregatData['jumlahKabupatenBerdata'] }}</div>
                        <div class="lbl" style="color:#166534;">berdata valid ({{ $agregatData['persenKabupatenBerdata'] }}%)</div>
                    </div>
                    <div class="agr-stat-card" style="background:#fffbeb;">
                        <div class="num" style="color:#b45309;">{{ $agregatData['jumlahKabupatenTanpaData'] }}</div>
                        <div class="lbl" style="color:#92400e;">belum ada data sama sekali ({{ $agregatData['persenKabupatenTanpaData'] }}%)</div>
                    </div>
                    <div class="agr-stat-card" style="background:#e0f2fe;">
                        <div class="num" style="color:#0f766e;">{{ count($agregatData['klasterList']) }}</div>
                        <div class="lbl" style="color:#0e7490;">klaster profil kerentanan</div>
                    </div>
                </div>
            </div>

            {{-- 4. KONTEN DUA KOLOM: STATUS TIAP KABUPATEN vs KLASTER DAN IMPLIKASINYA --}}
            <div class="agr-two-col">

                {{-- KOLOM KIRI: STATUS TIAP KABUPATEN --}}
                <div>
                    <h2 class="agr-sec-heading" style="margin-bottom: 6px;">Status tiap kabupaten</h2>
                    <table class="agr-matriks-table">
                        <thead>
                            <tr>
                                <th style="text-align:left; width:28%;">Kabupaten</th>
                                <th style="width:18%;">
                                    Delta-<br>methrin<br>3A
                                </th>
                                <th style="width:18%;">
                                    Mala-<br>thion<br>1B
                                </th>
                                <th style="width:18%;">
                                    Pirimiphos-<br>methyl 1B
                                </th>
                                <th style="width:18%;">
                                    Bendio-<br>carb 1A
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agregatData['matriksKabupaten'] as $kab)
                                <tr>
                                    <td style="text-align:left; font-weight:700; color:#1e293b; padding-left:2px;">
                                        <span>{{ $kab['kode'] }}</span>
                                        <span style="font-weight:400; color:#64748b; font-size:6.2pt; display:block; line-height:1; max-width:95px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $kab['kab_name'] ?? '' }}">
                                            {{ strlen((string)($kab['kab_name'] ?? '')) > 16 ? substr((string)$kab['kab_name'], 0, 15) . '…' : ($kab['kab_name'] ?? '') }}
                                        </span>
                                    </td>
                                    <td>
                                        @php $s1 = $kab['statuses']['deltamethrin'] ?? 'TD'; @endphp
                                        <span class="agr-badge-{{ strtolower($s1) }}">{{ $s1 }}</span>
                                    </td>
                                    <td>
                                        @php $s2 = $kab['statuses']['malathion'] ?? 'TD'; @endphp
                                        <span class="agr-badge-{{ strtolower($s2) }}">{{ $s2 }}</span>
                                    </td>
                                    <td>
                                        @php $s3 = $kab['statuses']['pirimiphos'] ?? 'TD'; @endphp
                                        <span class="agr-badge-{{ strtolower($s3) }}">{{ $s3 }}</span>
                                    </td>
                                    <td>
                                        @php $s4 = $kab['statuses']['bendiocarb'] ?? 'TD'; @endphp
                                        <span class="agr-badge-{{ strtolower($s4) }}">{{ $s4 }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align:center; padding:10px; color:#94a3b8; font-style:italic;">
                                        Belum ada data pengujian bioassay pada rentang filter ini.
                                    </td>
                                </tr>
                            @endforelse

                            {{-- BARIS KABUPATEN LAINNYA TANPA DATA --}}
                            @if($agregatData['jumlahKabupatenTanpaData'] > 0)
                                <tr style="background:#fafafa;">
                                    <td style="text-align:left; font-weight:700; color:#64748b; padding-left:2px;">
                                        {{ $agregatData['jumlahKabupatenTanpaData'] }} lainnya
                                    </td>
                                    <td><span class="agr-badge-td">TD</span></td>
                                    <td><span class="agr-badge-td">TD</span></td>
                                    <td><span class="agr-badge-td">TD</span></td>
                                    <td><span class="agr-badge-td">TD</span></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div style="font-size:6.5pt; color:#475569; margin-top:5px; font-weight:600; line-height:1.35;">
                        <strong>RT</strong> resisten terkonfirmasi &bull; <strong>DR</strong> dugaan resisten &bull; <strong>KR</strong> kemungkinan resisten &bull; <strong>RN</strong> rentan &bull; <strong>TD</strong> tidak cukup data atau tidak diuji
                    </div>
                </div>

                {{-- KOLOM KANAN: KLASTER DAN IMPLIKASINYA --}}
                <div>
                    <h2 class="agr-sec-heading" style="margin-bottom: 6px;">Klaster dan implikasinya</h2>
                    <div style="display:flex; flex-direction:column; gap:6px;">
                        @foreach($agregatData['klasterList'] as $kls)
                            <div class="agr-cluster-card">
                                <div class="agr-cluster-title">
                                    {{ $kls['judul'] }}
                                </div>
                                <div class="agr-cluster-sub">
                                    {{ $kls['ringkasan'] }}
                                </div>
                                <div class="agr-cluster-desc">
                                    {{ $kls['deskripsi'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

        {{-- PAGE BREAK UNTUK CETAK DUA HALAMAN --}}
        <div class="page-break" style="page-break-after: always; height: 18px; border-bottom: 1px dashed #cbd5e1; margin: 16px 0;"></div>

        {{-- HALAMAN 2: GRAFIK STACKED BARS, OPSI PEJABAT, BATAS PENGGUNAAN & PENGESAHAN --}}
        <div class="agr-page-2">

            {{-- 1. BAGIAN: BERAPA BANYAK WILAYAH YANG SUDAH DIKETAHUI, PER BAHAN AKTIF --}}
            <div style="margin-bottom: 12px;">
                <h2 class="agr-sec-heading">Berapa banyak wilayah yang sudah diketahui, per bahan aktif</h2>
                <div class="agr-sec-sub">
                    Setiap batang mewakili {{ $agregatData['totalKabupatenDiWilayah'] }} kabupaten/kota. Abu-abu adalah wilayah tanpa data.
                </div>

                <div style="margin-top: 8px;">
                    @foreach($agregatData['barDataList'] as $b)
                        @php
                            $totalKab = max(1, $b['total_kab']);
                            $pctRt = ($b['rt'] / $totalKab) * 100;
                            $pctDr = ($b['dr'] / $totalKab) * 100;
                            $pctKr = ($b['kr'] / $totalKab) * 100;
                            $pctRn = ($b['rn'] / $totalKab) * 100;
                            $pctTd = ($b['tanpa_data'] / $totalKab) * 100;
                        @endphp
                        <div class="agr-bar-row">
                            <div class="agr-bar-label">{{ $b['nama'] }}</div>
                            <div class="agr-bar-track">
                                @if($b['rt'] > 0)
                                    <div style="width: {{ $pctRt }}%; background: #be123c;" title="RT: {{ $b['rt'] }}">
                                        @if($pctRt >= 5) {{ $b['rt'] }} @endif
                                    </div>
                                @endif
                                @if($b['dr'] > 0)
                                    <div style="width: {{ $pctDr }}%; background: #ea580c;" title="DR: {{ $b['dr'] }}">
                                        @if($pctDr >= 5) {{ $b['dr'] }} @endif
                                    </div>
                                @endif
                                @if($b['kr'] > 0)
                                    <div style="width: {{ $pctKr }}%; background: #f59e0b; color: #78350f;" title="KR: {{ $b['kr'] }}">
                                        @if($pctKr >= 5) {{ $b['kr'] }} @endif
                                    </div>
                                @endif
                                @if($b['rn'] > 0)
                                    <div style="width: {{ $pctRn }}%; background: #15803d;" title="RN: {{ $b['rn'] }}">
                                        @if($pctRn >= 5) {{ $b['rn'] }} @endif
                                    </div>
                                @endif
                                @if($b['tanpa_data'] > 0)
                                    <div style="width: {{ $pctTd }}%; background: #e2e8f0; color: #475569; font-weight: 600;" title="Tanpa Data: {{ $b['tanpa_data'] }}">
                                        {{ $b['tanpa_data'] }} tanpa data
                                    </div>
                                @endif
                            </div>
                            <div class="agr-bar-meta">{{ $b['berdata'] }} berdata</div>
                        </div>
                    @endforeach
                </div>

                <div style="font-size: 6.8pt; color: #64748b; font-style: italic; margin-top: 4px;">
                    Hitungan kabupaten, bukan persentase nyamuk. Warna sama dengan matriks di atas; segmen kecil tanpa angka dapat dibaca di matriks.
                </div>
            </div>

            {{-- 2. BAGIAN: OPSI KEPUTUSAN UNTUK PEJABAT --}}
            <div style="margin-bottom: 12px;">
                <h2 class="agr-sec-heading" style="margin-bottom: 6px;">Opsi keputusan untuk pejabat</h2>
                <div class="agr-opsi-grid">
                    {{-- OPSI A --}}
                    <div class="agr-opsi-card">
                        <div class="agr-opsi-title">Opsi A: perluas surveilans dahulu</div>
                        <p style="margin: 0 0 4px 0; color: #334155;">
                            Uji {{ $agregatData['kabupatenPrioritasCount'] }} kabupaten prioritas sebelum musim penularan, tunda perubahan pengadaan.
                        </p>
                        <div style="color: #475569;">
                            <div><strong>Manfaat:</strong> keputusan berbasis data lebih lengkap.</div>
                            <div><strong>Risiko:</strong> pengadaan tahun ini memakai data terbatas.</div>
                            <div><strong>Prasyarat:</strong> kapasitas laboratorium dan anggaran uji.</div>
                        </div>
                    </div>

                    {{-- OPSI B --}}
                    <div class="agr-opsi-card">
                        <div class="agr-opsi-title">Opsi B: pengadaan berbasis klaster sementara</div>
                        <p style="margin: 0 0 4px 0; color: #334155;">
                            Perencanaan pasokan per klaster untuk {{ $agregatData['jumlahKabupatenBerdata'] }} kabupaten berdata, sambil uji tambahan.
                        </p>
                        <div style="color: #475569;">
                            <div><strong>Manfaat:</strong> respons lebih cepat di wilayah berdata.</div>
                            <div><strong>Risiko:</strong> kabupaten tanpa data tidak terwakili; tekanan seleksi bila satu kelompok dominan.</div>
                            <div><strong>Prasyarat:</strong> keputusan pejabat berwenang dan pemantauan resistensi silang.</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. BAGIAN: BATAS PENGGUNAAN --}}
            <div class="agr-disclaimer-box">
                <strong>Batas penggunaan.</strong> Status tiap kabupaten diambil dari dokumen kabupaten yang terverifikasi, bukan dihitung ulang. Hasil tidak dapat diekstrapolasi ke {{ $agregatData['jumlahKabupatenTanpaData'] }} kabupaten/kota tanpa data. Lokasi uji sering dipilih karena ada kasus, sehingga mungkin tidak mewakili seluruh provinsi. Bioassay menggambarkan kerentanan populasi nyamuk, bukan efikasi di lapangan. Dokumen ini rekomendasi teknis; keputusan program dan pengadaan ada pada pejabat berwenang.
            </div>

            {{-- CATATAN, MASUKAN & DISPOSISI KHUSUS PIMPINAN / TIM AHLI (ONLINE EDITABLE) --}}
            <div class="custom-notes-section" style="margin: 12px 0 10px 0; border: 1.5px solid #0d9488; background: #f0fdfa; border-radius: 6px; padding: 9px 13px; page-break-inside: avoid;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; border-bottom: 1px solid #ccfbf1; padding-bottom: 3px;">
                    <div style="font-size: 7.6pt; font-weight: 800; color: #0f766e; text-transform: uppercase; letter-spacing: 0.4px; display: flex; align-items: center; gap: 5px;">
                        <span>📝 CATATAN, MASUKAN &amp; DISPOSISI KHUSUS PIMPINAN / TIM AHLI</span>
                    </div>
                    <div class="edit-online-badge no-print" style="display: none; font-size: 6.2pt; font-weight: 700; color: #0f766e; background: #ccfbf1; border: 1px dashed #0d9488; padding: 2px 7px; border-radius: 4px;">
                        ✏️ Mode Edit Online Aktif — Klik teks di bawah untuk mengubah
                    </div>
                </div>
                
                <div id="editableNotesBox" class="editable-notes-content" style="font-size: 7.2pt; line-height: 1.6; color: #1e293b; min-height: 44px; white-space: pre-wrap;">{{ $approval && !empty($approval->notes) ? $approval->notes : "• Penyesuaian formulasi insektisida di wilayah kantong resistensi tinggi wajib dikoordinasikan dengan Pengelola Program P2P Dinas Kesehatan setempat.\n• Prioritaskan aplikasi larvasida biologi (Bti) dan penguatan Gerakan 1 Rumah 1 Jumantik (G1R1J) pada pemukiman padat.\n• Pelaksanaan rotasi MoA insektisida wajib dievaluasi kembali melalui surveilans bioassay berkala." }}</div>

                <div class="no-print" style="margin-top: 6px; padding-top: 4px; border-top: 1px dashed #99f6e4; display: flex; justify-content: space-between; align-items: center; font-size: 6.5pt; color: #0f766e;">
                    <div class="flex items-center gap-2">
                        <span>💡 <em>Masukan di atas tersimpan otomatis dan akan tercetak resmi pada dokumen rekomendasi.</em></span>
                        <span class="saveStatusIndicator font-bold text-emerald-700" style="display: none;">✓ Tersimpan</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <button type="button" onclick="addBulletPoint()" class="edit-mode-btn" style="display: none; padding: 2px 7px; background: #0d9488; color: #fff; border-radius: 4px; font-weight: 700; cursor: pointer; border: none; font-size: 6.5pt;">
                            ➕ Tambah Butir
                        </button>
                        <button type="button" onclick="saveNotesOnline()" class="edit-mode-btn" style="display: none; padding: 2px 8px; background: #059669; color: #fff; border-radius: 4px; font-weight: 700; cursor: pointer; border: none; font-size: 6.5pt;">
                            💾 Simpan
                        </button>
                    </div>
                </div>
            </div>

            {{-- 4. BAGIAN: LEMBAR PENGESAHAN TIGA KOLOM --}}
            <table style="width: 100%; border-collapse: collapse; margin-top: 14px; font-size: 7.3pt;">
                <tr>
                    <td style="width: 33.3%; vertical-align: top; padding-right: 8px;">
                        <div style="color: #64748b; font-size: 7pt; margin-bottom: 2px;">Disusun oleh</div>
                        <div style="height: 38px;"></div>
                        <div style="font-weight: 800; color: #1e293b; border-bottom: 1px solid #cbd5e1; padding-bottom: 1px; display: inline-block;">
                            Tim Ahli Entomologi Kesehatan
                        </div>
                        <div style="font-size: 6.8pt; color: #64748b; margin-top: 2px;">
                            BBLKL Kemenkes RI Salatiga
                        </div>
                    </td>
                    <td style="width: 33.3%; vertical-align: top; padding-right: 8px;">
                        <div style="color: #64748b; font-size: 7pt; margin-bottom: 2px;">Diverifikasi pakar entomologi</div>
                        @if($isApproved)
                            <div style="border: 1px solid #10b981; background: #ecfdf5; padding: 4px 7px; border-radius: 4px; display: inline-block; margin-top: 4px;">
                                <div style="font-size: 6.5pt; font-weight: 800; color: #065f46;">✓ TELAH DIVERIFIKASI</div>
                                <div style="font-size: 7.2pt; font-weight: 800; color: #0f172a;">Pakar Entomologi BBLKL</div>
                                <div style="font-size: 6pt; color: #059669;">SI-RESISTENSI INDONESIA</div>
                            </div>
                        @else
                            <div style="height: 38px;"></div>
                            <div style="font-size: 7pt; color: #92400e; font-style: italic;">
                                (belum terisi: DRAF)
                            </div>
                        @endif
                    </td>
                    <td style="width: 33.3%; vertical-align: top;">
                        <div style="color: #64748b; font-size: 7pt; margin-bottom: 2px;">Disampaikan oleh pejabat berwenang</div>
                        @if($isApproved)
                            <div style="border: 1.5px solid #059669; background: #f0fdf4; padding: 5px 8px; border-radius: 5px; display: inline-block; margin-top: 2px;">
                                <div style="font-size: 6.2pt; font-weight: 800; color: #065f46; text-transform: uppercase;">Disahkan Secara Digital:</div>
                                <div style="font-size: 7.8pt; font-weight: 800; color: #0f172a;">{{ $approval->approver_name }}</div>
                                <div style="font-size: 6.5pt; color: #334155;">NIP. {{ $approval->approver_nip ?? '-' }}</div>
                                <div style="font-size: 6pt; color: #047857; font-weight: 600;">{{ $approval->approver_jabatan }}</div>
                                <div style="font-size: 5.8pt; color: #059669; font-weight: 700;">NO. REG: {{ $approval->nomor_surat }}</div>
                            </div>
                        @else
                            <div style="height: 38px;"></div>
                            <div style="font-size: 7pt; color: #92400e; font-style: italic;">
                                (belum terisi: DRAF)
                            </div>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- 5. BAGIAN: RUJUKAN RESMI --}}
            <div style="margin-top: 14px; padding-top: 6px; border-top: 1px solid #e2e8f0; font-size: 6.8pt; color: #64748b; line-height: 1.4;">
                <strong>Rujukan:</strong> WHO, Manual for monitoring insecticide resistance in mosquito vectors (2022) &bull; Permenkes 2/2023 Pasal 33–39 dan 47 &bull; IRAC Mode of Action Classification.
            </div>

        </div>

        @endif

    </div>

    {{-- MODAL APPROVE / PENGESAHAN KEPALA BBLKL DI HALAMAN PREVIEW --}}
    <div id="approveModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/80 backdrop-blur-sm hidden print:hidden p-3 sm:p-4 md:p-6 flex items-center justify-center">
        <div class="relative w-full max-w-xl rounded-2xl bg-white shadow-2xl border border-slate-200 overflow-hidden my-auto max-h-[92vh] flex flex-col animate-in fade-in zoom-in duration-150">
            {{-- HEADER MODAL (STICKY / FIXED AT TOP) --}}
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-100 bg-slate-50/90 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-100 text-teal-700 shrink-0">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-800 leading-tight">
                            Pengesahan Dokumen Rekomendasi Kebijakan
                        </h3>
                        <p class="text-[11px] text-slate-500">
                            Persetujuan &amp; Tanda Tangan Elektronik Kepala/Pimpinan BBLKL
                        </p>
                    </div>
                </div>
                <button type="button"
                        onclick="closeApproveModal()"
                        class="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-200/60 transition cursor-pointer">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- FORM APPROVAL DENGAN SCROLLABLE BODY DAN FIXED FOOTER --}}
            <form action="{{ route('rekomendasi.approve') }}" method="POST" class="flex flex-col flex-1 overflow-hidden m-0">
                @csrf
                <input type="hidden" name="tahun" value="{{ $tahunFilter }}">
                <input type="hidden" name="jenis_nyamuk" value="{{ $nyamukFilter }}">
                <input type="hidden" name="provinsi_id" value="{{ $provinsiFilter }}">
                <input type="hidden" name="kabupaten_id" value="{{ $kabupatenFilter }}">
                <input type="hidden" name="template" value="{{ $activeTemplate }}">
                <input type="hidden" name="nama_wilayah" value="{{ $namaWilayah }}">

                {{-- SCROLLABLE FORM CONTENT --}}
                <div class="p-5 overflow-y-auto space-y-3.5 flex-1">
                    {{-- INFORMASI DOKUMEN --}}
                    <div class="rounded-xl bg-slate-50 border border-slate-200/80 p-3 text-xs">
                        <div class="grid grid-cols-2 gap-2 text-[11px]">
                            <div><strong class="text-slate-500">Wilayah:</strong> <span class="font-bold text-slate-800">{{ $namaWilayah }}</span></div>
                            <div><strong class="text-slate-500">Tahun:</strong> <span class="font-bold text-slate-800">{{ $tahunFilter }}</span></div>
                            <div><strong class="text-slate-500">Vektor:</strong> <span class="font-bold text-slate-800">{{ $nyamukFilter }}</span></div>
                            <div><strong class="text-slate-500">Template Aktif:</strong> <span class="font-bold text-teal-700 uppercase">{{ $activeTemplate }}</span></div>
                        </div>
                    </div>

                    {{-- PILIHAN LINGKUP TEMPLATE --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Lingkup Pengesahan Dokumen *
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center gap-2 p-2.5 rounded-xl border border-teal-200 bg-teal-50/50 cursor-pointer hover:bg-teal-50 transition">
                                <input type="radio" name="lingkup_approval" value="semua_template" checked class="text-teal-600 focus:ring-teal-500">
                                <div class="text-xs">
                                    <strong class="text-slate-800 block leading-tight">Semua Template Dokumen</strong>
                                    <span class="text-[10px] text-slate-500">Kemenkes, Eksekutif, Lab &amp; Agregat</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:bg-slate-50 transition">
                                <input type="radio" name="lingkup_approval" value="template_ini" class="text-teal-600 focus:ring-teal-500">
                                <div class="text-xs">
                                    <strong class="text-slate-800 block leading-tight">Hanya Template Ini</strong>
                                    <span class="text-[10px] text-slate-500">Format: {{ strtoupper($activeTemplate) }}</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- NAMA & NIP KEPALA/PIMPINAN --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Nama Kepala/Pimpinan BBLKL *
                            </label>
                            <input type="text"
                                   name="approver_name"
                                   required
                                   value="{{ $approval->approver_name ?? $defaultKepalaNama }}"
                                   placeholder="Nama Lengkap dan Gelar"
                                   class="w-full h-10 rounded-xl border border-slate-300 bg-white px-3.5 text-xs font-semibold text-slate-800 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 shadow-2xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                NIP Kepala/Pimpinan
                            </label>
                            <input type="text"
                                   name="approver_nip"
                                   value="{{ $approval->approver_nip ?? $defaultKepalaNip }}"
                                   placeholder="NIP. 19xxxxxxxxxxxxxx"
                                   class="w-full h-10 rounded-xl border border-slate-300 bg-white px-3.5 text-xs font-medium text-slate-800 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 shadow-2xs">
                        </div>
                    </div>

                    {{-- JABATAN & NOMOR SURAT --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Jabatan Resmi *
                            </label>
                            <input type="text"
                                   name="approver_jabatan"
                                   required
                                   value="{{ $approval->approver_jabatan ?? $defaultKepalaJabatan }}"
                                   placeholder="Jabatan Resmi Pimpinan"
                                   class="w-full h-10 rounded-xl border border-slate-300 bg-white px-3.5 text-xs font-medium text-slate-800 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 shadow-2xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Nomor Surat / Disposisi Rekomendasi
                            </label>
                            <input type="text"
                                   name="nomor_surat"
                                   value="{{ $approval->nomor_surat ?? $defaultNomorSurat }}"
                                   placeholder="Contoh: LT-VEC/BBLKL/2026/0417"
                                   class="w-full h-10 rounded-xl border border-slate-300 bg-white px-3.5 text-xs font-mono font-medium text-slate-800 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 shadow-2xs">
                        </div>
                    </div>

                    {{-- CATATAN / INSTRUKSI PENGESAHAN --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Catatan / Arahan Pimpinan (Opsional)
                        </label>
                        <textarea name="notes"
                                  rows="2"
                                  placeholder="Arahan tindak lanjut pimpinan..."
                                  class="w-full rounded-xl border border-slate-300 bg-white p-2.5 text-xs text-slate-800 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 shadow-2xs leading-relaxed">{{ $approval->notes ?? 'Rekomendasi teknis kebijakan pengendalian vektor ini telah diverifikasi dan disahkan sebagai rujukan operasional penanggulangan resistensi di wilayah bersangkutan.' }}</textarea>
                    </div>

                    {{-- KETERANGAN RESMI --}}
                    <div class="flex items-start gap-2 text-[11px] text-slate-500">
                        <span class="text-teal-600 font-bold">ℹ️</span>
                        <span>Watermark <strong>"DRAFT"</strong> pada cetak dokumen akan dihilangkan dan digantikan dengan tanda tangan &amp; stempel pengesahan elektronik resmi Kepala BBLKL.</span>
                    </div>
                </div>

                {{-- ACTION BUTTONS (STICKY / FIXED AT BOTTOM) --}}
                <div class="flex items-center justify-end gap-2.5 px-5 py-3.5 border-t border-slate-100 bg-slate-50/90 shrink-0">
                    <button type="button"
                            onclick="closeApproveModal()"
                            class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-100 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-extrabold shadow-md transition active:scale-95 cursor-pointer">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>✅ Setujui &amp; Sahkan Dokumen</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT MODAL & ONLINE EDITING --}}
    <script>
        let isEditMode = false;
        let isDirty = false;

        function toggleEditMode() {
            isEditMode = !isEditMode;
            const body = document.body;
            const btnLabel = document.getElementById('btnEditLabel');
            const btnSave = document.getElementById('btnSaveNotes');
            const banner = document.getElementById('editModeNoticeBanner');
            const box = document.getElementById('editableNotesBox') || document.querySelector('.editable-notes-content');
            const editBadges = document.querySelectorAll('.edit-online-badge');
            const editBtns = document.querySelectorAll('.edit-mode-btn');

            if (isEditMode) {
                body.classList.add('edit-mode-active');
                if (btnLabel) btnLabel.innerHTML = '👁️ Selesai Edit';
                if (btnSave) btnSave.style.display = 'inline-flex';
                if (banner) banner.style.display = 'flex';

                if (box) {
                    box.setAttribute('contenteditable', 'true');
                    box.focus();
                }
                editBadges.forEach(b => b.style.display = 'inline-flex');
                editBtns.forEach(b => b.style.display = 'inline-flex');

                showToast('✏️ Mode Edit Online Aktif. Anda dapat mengetik atau menambah masukan langsung.', 'info');
            } else {
                body.classList.remove('edit-mode-active');
                if (btnLabel) btnLabel.innerHTML = '✏️ Edit Online';
                if (btnSave) btnSave.style.display = 'none';
                if (banner) banner.style.display = 'none';

                if (box) {
                    box.setAttribute('contenteditable', 'false');
                }
                editBadges.forEach(b => b.style.display = 'none');
                editBtns.forEach(b => b.style.display = 'none');

                if (isDirty) {
                    saveNotesOnline();
                }
            }
        }

        function addBulletPoint() {
            const box = document.getElementById('editableNotesBox') || document.querySelector('.editable-notes-content');
            if (!box) return;

            if (!isEditMode) {
                toggleEditMode();
            }

            const current = box.innerText.trim();
            const newBullet = '\n• Rekomendasi Tambahan: ';
            box.innerText = current ? (current + newBullet) : '• Rekomendasi Tambahan: ';
            isDirty = true;

            // Move cursor to end
            box.focus();
            const range = document.createRange();
            range.selectNodeContents(box);
            range.collapse(false);
            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);

            syncNotesToModal(box.innerText);

            const statusIndicators = document.querySelectorAll('.saveStatusIndicator');
            statusIndicators.forEach(ind => {
                ind.style.display = 'inline';
                ind.innerHTML = '● Ada masukan baru (belum tersimpan)...';
                ind.className = 'saveStatusIndicator font-bold text-amber-700';
            });
        }

        function syncNotesToModal(text) {
            const modalTextarea = document.querySelector('textarea[name="notes"]');
            if (modalTextarea) {
                modalTextarea.value = text;
            }
        }

        async function saveNotesOnline() {
            const box = document.getElementById('editableNotesBox') || document.querySelector('.editable-notes-content');
            if (!box) return;

            const notesText = box.innerText.trim();
            const saveBtn = document.getElementById('btnSaveNotes');
            const saveLabel = document.getElementById('btnSaveLabel');
            const statusIndicators = document.querySelectorAll('.saveStatusIndicator');

            if (saveLabel) saveLabel.innerHTML = '⏳ Menyimpan...';
            if (saveBtn) saveBtn.classList.remove('animate-pulse');

            syncNotesToModal(notesText);

            try {
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('tahun', '{{ $tahunFilter }}');
                formData.append('jenis_nyamuk', '{{ $nyamukFilter }}');
                formData.append('provinsi_id', '{{ $provinsiFilter }}');
                formData.append('kabupaten_id', '{{ $kabupatenFilter }}');
                formData.append('template', '{{ $activeTemplate }}');
                formData.append('nama_wilayah', '{{ $namaWilayah }}');
                formData.append('notes', notesText);

                const response = await fetch('{{ route("rekomendasi.save_notes") }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    isDirty = false;
                    try {
                        localStorage.setItem('rekomendasi_notes_{{ $docHash }}', notesText);
                    } catch(e) {}

                    statusIndicators.forEach(ind => {
                        ind.style.display = 'inline';
                        ind.innerHTML = '✓ Tersimpan (' + (data.updated_at || 'Baru saja') + ')';
                        ind.className = 'saveStatusIndicator font-bold text-emerald-700';
                    });

                    showToast('✓ Masukan berhasil disimpan secara online!', 'success');
                } else {
                    showToast('⚠️ Gagal menyimpan: ' + (data.message || 'Terjadi kesalahan'), 'error');
                }
            } catch (err) {
                console.error('Save error:', err);
                try {
                    localStorage.setItem('rekomendasi_notes_{{ $docHash }}', notesText);
                    showToast('Catatan disimpan ke penyimpanan lokal browser (offline).', 'warning');
                } catch(e) {
                    showToast('Gagal menyimpan masukan ke server.', 'error');
                }
            } finally {
                if (saveLabel) saveLabel.innerHTML = '💾 Simpan Masukan';
                if (saveBtn && isEditMode) saveBtn.classList.add('animate-pulse');
            }
        }

        function showToast(message, type = 'info') {
            let toast = document.getElementById('onlineEditToast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'onlineEditToast';
                document.body.appendChild(toast);
            }

            let bgClass = 'bg-teal-600 border-teal-400';
            if (type === 'success') bgClass = 'bg-emerald-600 border-emerald-400';
            if (type === 'error') bgClass = 'bg-rose-600 border-rose-400';
            if (type === 'warning') bgClass = 'bg-amber-600 border-amber-400';

            toast.className = 'fixed bottom-5 right-5 z-[9999] px-4 py-2.5 rounded-xl shadow-2xl text-xs font-bold text-white transition-all duration-300 transform translate-y-0 opacity-100 border no-print flex items-center gap-2 ' + bgClass;
            toast.innerHTML = message;

            clearTimeout(window.__toastTimeout);
            window.__toastTimeout = setTimeout(() => {
                toast.classList.add('translate-y-3', 'opacity-0');
            }, 3500);
        }

        function openApproveModal() {
            const modal = document.getElementById('approveModal');
            if (modal) {
                const box = document.getElementById('editableNotesBox') || document.querySelector('.editable-notes-content');
                if (box) {
                    syncNotesToModal(box.innerText.trim());
                }
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeApproveModal() {
            const modal = document.getElementById('approveModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeApproveModal();
            }
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                saveNotesOnline();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const box = document.getElementById('editableNotesBox') || document.querySelector('.editable-notes-content');
            if (box) {
                box.addEventListener('input', function() {
                    isDirty = true;
                    syncNotesToModal(box.innerText);
                    const statusIndicators = document.querySelectorAll('.saveStatusIndicator');
                    statusIndicators.forEach(ind => {
                        ind.style.display = 'inline';
                        ind.innerHTML = '● Ada perubahan belum tersimpan...';
                        ind.className = 'saveStatusIndicator font-bold text-amber-700';
                    });
                });
            }

            @if(request('edit') == '1' || request('mode') === 'edit')
                setTimeout(function() {
                    if (!isEditMode) {
                        toggleEditMode();
                    }
                }, 300);
            @endif
        });
    </script>
</body>
</html>
