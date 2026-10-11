<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Dashboard - SIMPEL BBLKL</title>

    {{-- DARK MODE INITIALIZATION & GLOBAL STYLES --}}
    @include('dark_mode_head')

    {{-- LEAFLET CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        #map {
            width: 100%;
            height: 520px;
            border-radius: 14px;
            z-index: 1;
        }

        @media (max-width: 640px) {
            #map {
                height: 460px;
            }
        }

        /* Label Kabupaten di atas Peta (Sesuai Gambar 3: Badge Putih Rapi & Jelas) */
        .region-map-label {
            background: #ffffff !important;
            border: 1px solid #94a3b8 !important;
            color: #0f172a !important;
            font-weight: 800 !important;
            font-size: 11px !important;
            border-radius: 6px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.15), 0 2px 4px -2px rgba(0, 0, 0, 0.1) !important;
            padding: 3px 8px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.03em !important;
            white-space: nowrap !important;
            pointer-events: none !important;
        }
        .region-map-label::before {
            display: none !important;
        }

        /* Marker Pin Desa / Alamat yang Interaktif */
        .custom-desa-marker-container {
            background: transparent !important;
            border: none !important;
        }
        .desa-pin-marker {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            pointer-events: auto;
            position: relative;
        }
        .desa-pin-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #ffffff;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.45);
            border: 2.5px solid #ffffff;
            transition: transform 0.2s ease;
        }
        .desa-pin-icon span {
            transform: rotate(45deg);
            font-size: 15px;
            line-height: 1;
        }
        .desa-pin-pulse {
            width: 22px;
            height: 8px;
            background: rgba(37, 99, 235, 0.4);
            border-radius: 50%;
            margin-top: 3px;
        }
        .desa-pin-label {
            background: rgba(15, 23, 42, 0.92);
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 6px;
            white-space: nowrap;
            margin-top: 4px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.25);
            letter-spacing: 0.02em;
        }
        .custom-desa-popup .leaflet-popup-content-wrapper {
            border-radius: 14px !important;
            box-shadow: 0 14px 28px -4px rgba(0, 0, 0, 0.22) !important;
            border: 1px solid #cbd5e1 !important;
            padding: 2px !important;
        }

        /* Card Informasi Detail di Kanan Atas Peta (Transparan agar wilayah peta tetap terlihat) */
        .map-detail-panel {
            width: 320px;
            max-width: calc(100vw - 32px);
            max-height: 490px;
            overflow-y: auto;
            background: rgba(255, 255, 255, 0.62) !important;
            backdrop-filter: blur(4px) !important;
            -webkit-backdrop-filter: blur(4px) !important;
            border: 1px solid rgba(203, 213, 225, 0.75) !important;
            border-radius: 14px !important;
            box-shadow: 0 8px 24px -4px rgba(0, 0, 0, 0.12), 0 2px 6px -2px rgba(0, 0, 0, 0.05) !important;
            padding: 12px !important;
            font-size: 11.5px !important;
            color: #0f172a !important;
            pointer-events: none !important;
            transition: all 0.2s ease-in-out;
        }

        .map-detail-panel.is-pinned {
            pointer-events: auto !important;
            background: rgba(255, 255, 255, 0.88) !important;
            backdrop-filter: blur(6px) !important;
            -webkit-backdrop-filter: blur(6px) !important;
        }

        .map-detail-panel:hover {
            background: rgba(255, 255, 255, 0.82) !important;
            backdrop-filter: blur(6px) !important;
            -webkit-backdrop-filter: blur(6px) !important;
        }

        .map-detail-panel::-webkit-scrollbar {
            width: 4px;
        }
        .map-detail-panel::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.6);
            border-radius: 4px;
        }

        /* Legenda Keterangan Status Wilayah di Kiri Bawah (Bottom Left - Transparan) */
        .map-legend-control {
            background: rgba(255, 255, 255, 0.72) !important;
            backdrop-filter: blur(4px) !important;
            -webkit-backdrop-filter: blur(4px) !important;
            border: 1px solid rgba(203, 213, 225, 0.75) !important;
            border-radius: 12px !important;
            box-shadow: 0 8px 20px -4px rgba(0, 0, 0, 0.12) !important;
            padding: 10px 12px !important;
            pointer-events: auto !important;
            transition: background 0.2s ease-in-out;
        }

        .map-legend-control:hover {
            background: rgba(255, 255, 255, 0.88) !important;
        }

        .polygon-tooltip {
            background: rgba(15, 23, 42, 0.92) !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            color: #ffffff !important;
            border-radius: 8px !important;
            padding: 5px 10px !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
        }
        .polygon-tooltip::before {
            display: none !important;
        }

        .custom-map-marker {
            background: transparent !important;
            border: none !important;
        }

        .pin-wrapper {
            position: relative;
            width: 36px;
            height: 48px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        .pin-icon {
            position: relative;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.35));
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .pin-wrapper:hover .pin-icon {
            transform: scale(1.15) translateY(-3px);
            filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.45));
        }

        /* Lingkaran Donut Pin Head */
        .pin-head {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3), inset 0 0 0 1.5px rgba(255, 255, 255, 0.9);
            position: relative;
        }

        /* Bagian Tengah Angka Jumlah Data */
        .pin-center {
            width: 17px;
            height: 17px;
            border-radius: 50%;
            background: #ffffff;
            color: #0f172a;
            font-size: 10px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.1);
            line-height: 1;
        }

        /* Ujung Pointer Segitiga ke Arah Titik Koordinat */
        .pin-pointer {
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 9px solid #334155;
            margin-top: -2px;
        }

        /* Mini Dot Badges di Bawah Pin Jika Multi-Status */
        .pin-status-dots {
            display: flex;
            align-items: center;
            gap: 2.5px;
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(4px);
            padding: 1.5px 4.5px;
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.7);
            margin-top: 2px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.35);
        }

        .pin-dot-mini {
            width: 5.5px;
            height: 5.5px;
            border-radius: 50%;
            display: inline-block;
        }

        .pin-pulse {
            position: absolute;
            top: 36px;
            left: 50%;
            transform: translateX(-50%);
            width: 14px;
            height: 6px;
            border-radius: 50%;
            animation: pin-pulse-anim 2s infinite ease-out;
            pointer-events: none;
        }

        @keyframes pin-pulse-anim {
            0% {
                transform: translateX(-50%) scale(0.6);
                opacity: 0.9;
            }
            100% {
                transform: translateX(-50%) scale(2.6);
                opacity: 0;
            }
        }

        .leaflet-popup-content-wrapper {
            border-radius: 16px !important;
            padding: 2px !important;
            box-shadow: 0 12px 30px -4px rgba(0, 0, 0, 0.18), 0 4px 10px -2px rgba(0, 0, 0, 0.08) !important;
            border: 1px solid #e2e8f0 !important;
        }

        .leaflet-popup-content {
            margin: 12px 14px !important;
            line-height: 1.4 !important;
        }

        .leaflet-container {
            font-family: inherit !important;
        }

        /* ======================================================== */
        /* MODE GELAP (DARK MODE) COMPREHENSIVE STYLES               */
        /* ======================================================== */
        html.dark,
        html.dark body {
            background-color: #0a0f1d !important;
            color: #f1f5f9 !important;
        }

        html.dark main {
            background-color: #0a0f1d !important;
        }

        /* Topbar Header */
        html.dark header.sticky {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.4) !important;
        }
        html.dark header h1 {
            color: #f8fafc !important;
        }
        html.dark header p {
            color: #94a3b8 !important;
        }

        /* Tombol Tema & Dropdown User */
        html.dark #themeToggleBtn {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        html.dark #themeToggleBtn:hover {
            background-color: #334155 !important;
            border-color: #475569 !important;
        }
        html.dark #userDropdownBtn {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        html.dark #userDropdownBtn:hover {
            background-color: #334155 !important;
            border-color: #475569 !important;
        }
        html.dark #userDropdownBtn p.text-slate-800 {
            color: #f8fafc !important;
        }
        html.dark #userDropdownBtn p.text-slate-500 {
            color: #94a3b8 !important;
        }
        html.dark #userDropdownMenu {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.6), 0 8px 10px -6px rgba(0, 0, 0, 0.5) !important;
        }
        html.dark #userDropdownMenu .bg-slate-50\/60,
        html.dark #userDropdownMenu .border-slate-100 {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        html.dark #userDropdownMenu p.text-slate-800 {
            color: #f8fafc !important;
        }
        html.dark #userDropdownMenu p.text-slate-500 {
            color: #94a3b8 !important;
        }
        html.dark #dropdownThemeToggle {
            color: #cbd5e1 !important;
        }
        html.dark #dropdownThemeToggle:hover {
            background-color: #1e293b !important;
        }

        /* Semua Background Putih di Main Menjadi Dark Slate */
        html.dark main .bg-white:not(#themeSwitchThumb),
        html.dark main div.bg-white,
        html.dark main header.bg-white {
            background-color: #0f172a !important;
        }
        html.dark #themeSwitchThumb {
            background-color: #ffffff !important;
        }

        /* Container Card Shadow & Border */
        html.dark main .rounded-xl.border,
        html.dark main .rounded-2xl.border {
            border-color: #1e293b !important;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.35) !important;
        }

        /* Border Halus di Mode Gelap */
        html.dark main .border-slate-100,
        html.dark main .border-slate-200 {
            border-color: #1e293b !important;
        }

        /* Teks Judul, Label, dan Deskripsi */
        html.dark main h1,
        html.dark main h2,
        html.dark main h3,
        html.dark main h4,
        html.dark main .text-slate-900,
        html.dark main .text-slate-800 {
            color: #f8fafc !important;
        }
        html.dark main .text-slate-700 {
            color: #e2e8f0 !important;
        }
        html.dark main .text-slate-600 {
            color: #cbd5e1 !important;
        }
        html.dark main .text-slate-500 {
            color: #94a3b8 !important;
        }
        html.dark main .text-slate-400 {
            color: #94a3b8 !important;
        }
        html.dark main label {
            color: #e2e8f0 !important;
        }
        html.dark main label.cursor-pointer span {
            color: #e2e8f0 !important;
        }

        /* Badges & Pills Contrast di Mode Gelap */
        html.dark main .bg-emerald-50,
        html.dark main .bg-emerald-100 {
            background-color: rgba(16, 185, 129, 0.16) !important;
        }
        html.dark main .text-emerald-700,
        html.dark main .text-emerald-600 {
            color: #4ade80 !important;
        }
        html.dark main .border-emerald-200 {
            border-color: rgba(16, 185, 129, 0.4) !important;
        }

        html.dark main .bg-blue-50,
        html.dark main .bg-blue-100 {
            background-color: rgba(59, 130, 246, 0.18) !important;
        }
        html.dark main .text-blue-700 {
            color: #93c5fd !important;
        }
        html.dark main .text-blue-600 {
            color: #60a5fa !important;
        }
        html.dark main .border-blue-200,
        html.dark main .border-blue-100 {
            border-color: rgba(59, 130, 246, 0.4) !important;
        }

        html.dark main .bg-indigo-50,
        html.dark main .bg-indigo-100 {
            background-color: rgba(99, 102, 241, 0.18) !important;
        }
        html.dark main .text-indigo-700 {
            color: #c7d2fe !important;
        }
        html.dark main .text-indigo-600 {
            color: #a5b4fc !important;
        }

        html.dark main .bg-amber-50,
        html.dark main .bg-amber-100 {
            background-color: rgba(245, 158, 11, 0.18) !important;
        }
        html.dark main .text-amber-700,
        html.dark main .text-amber-600 {
            color: #fde047 !important;
        }
        html.dark main .border-amber-200 {
            border-color: rgba(245, 158, 11, 0.4) !important;
        }

        html.dark main .bg-rose-50,
        html.dark main .bg-rose-100 {
            background-color: rgba(244, 63, 94, 0.18) !important;
        }
        html.dark main .text-rose-700 {
            color: #fda4af !important;
        }
        html.dark main .text-rose-600 {
            color: #fb7185 !important;
        }
        html.dark main .border-rose-200 {
            border-color: rgba(244, 63, 94, 0.4) !important;
        }

        /* Stat Cards Utama di Dashboard */
        html.dark main .grid .text-2xl,
        html.dark main .grid h3.text-2xl {
            color: #ffffff !important;
            font-weight: 800 !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.6) !important;
        }
        html.dark main .grid p.text-slate-500 {
            color: #f1f5f9 !important;
            font-weight: 600 !important;
        }
        html.dark main .grid p.text-emerald-600 {
            color: #4ade80 !important;
            font-weight: 600 !important;
        }
        html.dark main .grid p.text-indigo-600 {
            color: #a5b4fc !important;
            font-weight: 600 !important;
        }
        html.dark main .grid p.text-amber-600 {
            color: #fde047 !important;
            font-weight: 600 !important;
        }
        html.dark main .grid .bg-blue-100.text-blue-600 {
            background-color: rgba(59, 130, 246, 0.24) !important;
            border: 1px solid rgba(96, 165, 250, 0.45) !important;
            color: #93c5fd !important;
        }
        html.dark main .grid .bg-indigo-100.text-indigo-600 {
            background-color: rgba(99, 102, 241, 0.24) !important;
            border: 1px solid rgba(165, 180, 252, 0.45) !important;
            color: #c7d2fe !important;
        }
        html.dark main .grid .bg-emerald-100.text-emerald-600 {
            background-color: rgba(16, 185, 129, 0.24) !important;
            border: 1px solid rgba(110, 231, 183, 0.45) !important;
            color: #86efac !important;
        }
        html.dark main .grid .bg-amber-100.text-amber-600 {
            background-color: rgba(245, 158, 11, 0.24) !important;
            border: 1px solid rgba(253, 224, 71, 0.45) !important;
            color: #fde047 !important;
        }

        /* Kotak Pencarian */
        html.dark #headerSearch,
        html.dark #tableSearchInput {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        html.dark #headerSearch::placeholder,
        html.dark #tableSearchInput::placeholder {
            color: #64748b !important;
        }
        html.dark #headerSearch:focus,
        html.dark #tableSearchInput:focus {
            border-color: #3b82f6 !important;
            background-color: #0f172a !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
        }
        html.dark #headerClearBtn,
        html.dark #tableSearchClearBtn {
            color: #94a3b8 !important;
        }
        html.dark #headerClearBtn:hover,
        html.dark #tableSearchClearBtn:hover {
            color: #f43f5e !important;
        }

        /* Panel Filter Form & Inputs */
        html.dark #filterPanelBody {
            background-color: #0f172a !important;
        }
        html.dark #filterPanelBody select,
        html.dark #filterPanelBody input[type="text"] {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        html.dark #filterPanelBody select option {
            background-color: #0f172a !important;
            color: #f8fafc !important;
        }
        html.dark #filterPanelBody select:disabled {
            background-color: #0b1120 !important;
            border-color: #1e293b !important;
            color: #64748b !important;
        }
        html.dark button[onclick="resetAllFilters()"] {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        html.dark button[onclick="resetAllFilters()"]:hover {
            background-color: #334155 !important;
            color: #ffffff !important;
        }
        html.dark button[onclick="resetMapView()"] {
            background-color: rgba(59, 130, 246, 0.2) !important;
            border-color: rgba(59, 130, 246, 0.45) !important;
            color: #60a5fa !important;
        }
        html.dark button[onclick="resetMapView()"]:hover {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
        }
        html.dark button[title="Buka/Tutup Filter"] {
            background-color: rgba(59, 130, 246, 0.2) !important;
            border-color: rgba(59, 130, 246, 0.45) !important;
            color: #60a5fa !important;
        }
        html.dark button[title="Buka/Tutup Filter"]:hover,
        html.dark .group:hover button[title="Buka/Tutup Filter"] {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
        }
        html.dark #filterCollapseIcon {
            color: #60a5fa !important;
        }
        html.dark button[title="Buka/Tutup Filter"]:hover #filterCollapseIcon,
        html.dark .group:hover #filterCollapseIcon {
            color: #ffffff !important;
        }

        /* Filter Toolbar Peta */
        html.dark #filterJenisNyamuk,
        html.dark #filterInsektisida,
        html.dark #filterMetode,
        html.dark #filterStatus {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        html.dark #filterJenisNyamuk option,
        html.dark #filterInsektisida option,
        html.dark #filterMetode option,
        html.dark #filterStatus option {
            background-color: #0f172a !important;
            color: #f8fafc !important;
        }

        /* Tabel Data Pemeriksaan */
        html.dark #tablePemeriksaanSection {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
        }
        html.dark #tablePemeriksaanSection .border-b {
            border-color: #1e293b !important;
        }
        html.dark #tablePemeriksaanSection .overflow-x-auto {
            background-color: #1e293b !important;
        }
        html.dark #tablePemeriksaanSection thead,
        html.dark #tablePemeriksaanSection thead tr,
        html.dark #tablePemeriksaanSection thead th {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #94a3b8 !important;
        }
        html.dark #tablePemeriksaanSection thead th {
            color: #94a3b8 !important;
        }
        html.dark #tablePemeriksaanSection table {
            border-color: #1e293b !important;
            background-color: #0f172a !important;
        }
        html.dark #tableDataBody {
            background-color: #0f172a !important;
        }
        html.dark #tableDataBody tr {
            border-color: #1e293b !important;
        }
        html.dark #tableDataBody tr:hover {
            background-color: rgba(30, 41, 59, 0.7) !important;
        }
        html.dark #tablePageSizeSelect {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        html.dark div:has(> #tablePageSizeSelect) {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        html.dark #dashboardTablePagination {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
        }
        html.dark #dashboardTablePagination button {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        html.dark #dashboardTablePagination button:hover:not(:disabled) {
            background-color: #334155 !important;
            color: #ffffff !important;
        }
        html.dark button[onclick^="showRowDetailModal"] {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        html.dark button[onclick^="showRowDetailModal"]:hover {
            background-color: #334155 !important;
            color: #60a5fa !important;
            border-color: #60a5fa !important;
        }

        /* Modal Detail */
        html.dark #rowDetailModalCard {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
            color: #f1f5f9 !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7) !important;
        }
        html.dark #rowDetailModalCard .border-b,
        html.dark #rowDetailModalCard .border-t {
            border-color: #1e293b !important;
        }
        html.dark #rowDetailModalCard .bg-gradient-to-r {
            background: linear-gradient(to right, #0f172a, #1e293b) !important;
        }
        html.dark #modalDetailFooter {
            background-color: #0b1120 !important;
        }
        html.dark #modalDetailBody {
            color: #e2e8f0 !important;
        }
        html.dark #modalDetailBody .bg-slate-50,
        html.dark #modalDetailBody .bg-slate-100 {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        html.dark #modalDetailBody .border-slate-100,
        html.dark #modalDetailBody .border-slate-200 {
            border-color: #334155 !important;
        }

        /* Peta Leaflet Dark Mode Tiles (Bebas Watermark & Tanpa Perlu API Key) */
        .leaflet-tile-pane {
            transition: filter 0.35s ease;
        }
        html.dark .leaflet-tile-pane {
            filter: brightness(0.6) invert(1) contrast(3) hue-rotate(200deg) saturate(0.3) brightness(0.7);
        }
        html.dark .leaflet-container {
            background-color: #0b1120 !important;
        }

        html.dark #map {
            border-color: #1e293b !important;
        }
        html.dark .leaflet-bar a {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        html.dark .leaflet-bar a:hover {
            background-color: #334155 !important;
        }
        html.dark .leaflet-container .leaflet-control-attribution {
            background: rgba(15, 23, 42, 0.85) !important;
            color: #94a3b8 !important;
        }
        html.dark .leaflet-container .leaflet-control-attribution a {
            color: #60a5fa !important;
        }
        html.dark .region-map-label {
            background: #1e293b !important;
            border: 1px solid #475569 !important;
            color: #f1f5f9 !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5) !important;
        }
        html.dark .map-detail-panel {
            background: rgba(15, 23, 42, 0.94) !important;
            border: 1px solid rgba(51, 65, 85, 0.95) !important;
            color: #f1f5f9 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.6) !important;
        }
        html.dark .map-detail-panel.is-pinned,
        html.dark .map-detail-panel:hover {
            background: rgba(15, 23, 42, 0.98) !important;
        }
        html.dark .map-detail-panel .text-slate-800 {
            color: #f8fafc !important;
        }
        html.dark .map-detail-panel .text-slate-700 {
            color: #e2e8f0 !important;
        }
        html.dark .map-detail-panel .text-slate-600 {
            color: #cbd5e1 !important;
        }
        html.dark .map-detail-panel .text-slate-500 {
            color: #94a3b8 !important;
        }
        html.dark .map-detail-panel .text-slate-400 {
            color: #94a3b8 !important;
        }
        html.dark .map-detail-panel .border-slate-100,
        html.dark .map-detail-panel .border-slate-200,
        html.dark .map-detail-panel .border-slate-200\/60 {
            border-color: #334155 !important;
        }
        html.dark .map-detail-panel .bg-slate-50 {
            background-color: #1e293b !important;
        }
        /* Badge Provinsi pada Detail Peta (Mode Gelap) */
        html.dark .map-detail-panel .panel-provinsi-badge,
        html.dark .map-detail-panel .bg-blue-100\/80 {
            background-color: #1e3a8a !important;
            color: #93c5fd !important;
            border: 1px solid #3b82f6 !important;
            font-weight: 800 !important;
        }
        /* Kotak Statistik (Total Uji & Sampel Diuji) (Mode Gelap) */
        html.dark .map-detail-panel .panel-stat-box,
        html.dark .map-detail-panel .grid .bg-white\/45 {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        html.dark .map-detail-panel .panel-stat-box .text-slate-800 {
            color: #ffffff !important;
            font-weight: 800 !important;
        }
        html.dark .map-detail-panel .panel-stat-box .text-slate-500 {
            color: #cbd5e1 !important;
            font-weight: 600 !important;
        }
        /* Kotak Hasil Pemeriksaan (Mode Gelap) */
        html.dark .map-detail-panel .panel-results-box,
        html.dark .map-detail-panel .bg-white\/45 {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        html.dark .map-detail-panel .panel-results-box .text-slate-800 {
            color: #f8fafc !important;
        }
        html.dark .map-detail-panel .panel-results-box .text-slate-500,
        html.dark .map-detail-panel .panel-results-box div.text-slate-500 {
            color: #cbd5e1 !important;
        }
        html.dark .map-detail-panel .panel-results-box .text-slate-600 {
            color: #94a3b8 !important;
        }
        html.dark .map-legend-control {
            background: rgba(15, 23, 42, 0.88) !important;
            border: 1px solid rgba(51, 65, 85, 0.9) !important;
            color: #f1f5f9 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.6) !important;
        }
        html.dark .map-legend-control:hover {
            background: rgba(15, 23, 42, 0.95) !important;
        }
        html.dark .map-legend-control .text-slate-800 {
            color: #f8fafc !important;
        }
        html.dark .map-legend-control .text-slate-700 {
            color: #cbd5e1 !important;
        }
        html.dark .leaflet-popup-content-wrapper {
            background: #0f172a !important;
            color: #f1f5f9 !important;
            border: 1px solid #334155 !important;
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.7) !important;
        }
        html.dark .leaflet-popup-tip {
            background: #0f172a !important;
        }
        html.dark .leaflet-popup-content .text-slate-800 {
            color: #f8fafc !important;
        }
        html.dark .leaflet-popup-content .text-slate-700 {
            color: #cbd5e1 !important;
        }
        html.dark .leaflet-popup-content .border-slate-100 {
            border-color: #334155 !important;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800">

    {{-- SIDEBAR --}}
    @include('sidebar')

    {{-- KONTEN DASHBOARD --}}
    <main class="ml-64 min-h-screen">

        {{-- TOPBAR DENGAN PROFIL --}}
        <header class="sticky top-0 z-40 flex items-center justify-between border-b border-slate-200 bg-white px-6 lg:px-8 py-3.5 gap-4 shadow-xs">
            <div class="min-w-0 flex flex-col justify-center">
                <h1 class="text-base sm:text-lg lg:text-xl font-black text-slate-800 tracking-tight leading-snug whitespace-nowrap">
                    Sistem Informasi Resistensi Insektisida Indonesia
                </h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    Balai Besar Laboratorium Kesehatan Lingkungan (BBLKL)
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                {{-- PROFIL PENGGUNA & TOMBOL TEMA TERPADU --}}
                @include('header_profile')
            </div>
        </header>

        {{-- ISI DASHBOARD --}}
        <section class="p-5 sm:p-6">

            {{-- HEADER SELAMAT DATANG SEJAJAR DENGAN KOTAK PENCARIAN --}}
            <div class="mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3.5">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">
                        Selamat Datang 👋
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Ringkasan hasil uji resistensi vektor laboratorium BBLKL
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    {{-- KOTAK PENCARIAN DI DASHBOARD (SEJAJAR DENGAN SELAMAT DATANG) --}}
                    <div class="relative w-64 sm:w-72 lg:w-80">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text"
                               id="headerSearch"
                               oninput="handleSearch(this.value)"
                               placeholder="Cari wilayah, alamat, nyamuk, insektisida..."
                               class="w-full rounded-xl border border-slate-200 bg-white pl-10 pr-8 py-2 text-xs text-slate-700 transition focus:border-blue-500 focus:outline-none shadow-2xs">
                        <button type="button"
                                id="headerClearBtn"
                                onclick="clearSearch()"
                                class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-slate-400 hover:text-slate-600 hidden cursor-pointer font-bold text-xs"
                                title="Hapus kata kunci">
                            ✕
                        </button>
                    </div>

                    <a href="{{ route('input') }}"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white shadow-2xs transition hover:bg-blue-700 shrink-0">
                        <span>+ Input Data Uji</span>
                    </a>
                </div>
            </div>

            {{-- STATISTIK KARTU UTAMA --}}
            <div class="grid grid-cols-1 gap-3.5 md:grid-cols-2 xl:grid-cols-4">

                {{-- TOTAL PEMERIKSAAN --}}
                <div class="rounded-xl border border-slate-200 bg-white p-3.5 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 font-medium">
                                Total Pengujian
                            </p>
                            <h3 class="mt-1 text-2xl font-bold text-slate-800">
                                {{ $totalPemeriksaan }}
                            </h3>
                            <p class="mt-1 text-[11px] font-medium text-emerald-600">
                                Data hasil uji tersimpan
                            </p>
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- TOTAL SAMPEL --}}
                <div class="rounded-xl border border-slate-200 bg-white p-3.5 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 font-medium">
                                Total Sampel Diperiksa
                            </p>
                            <h3 class="mt-1 text-2xl font-bold text-slate-800">
                                {{ number_format($totalSampel) }}
                            </h3>
                            <p class="mt-1 text-[11px] font-medium text-indigo-600">
                                Vektor nyamuk diuji
                            </p>
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- WILAYAH PROVINSI --}}
                <div class="rounded-xl border border-slate-200 bg-white p-3.5 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 font-medium">
                                Wilayah Provinsi
                            </p>
                            <h3 class="mt-1 text-2xl font-bold text-slate-800">
                                {{ $totalProvinsi }}
                            </h3>
                            <p class="mt-1 text-[11px] font-medium text-emerald-600">
                                Provinsi terdata
                            </p>
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21s7-5.4 7-11a7 7 0 10-14 0c0 5.6 7 11 7 11z" />
                                <circle cx="12" cy="10" r="2.5" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- KOTA / KABUPATEN --}}
                <div class="rounded-xl border border-slate-200 bg-white p-3.5 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 font-medium">
                                Kota / Kabupaten
                            </p>
                            <h3 class="mt-1 text-2xl font-bold text-slate-800">
                                {{ $totalKabupaten }}
                            </h3>
                            <p class="mt-1 text-[11px] font-medium text-amber-600">
                                Titik kab/kota terpantau
                            </p>
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            @php
                $provinsis = $provinsis ?? \App\Models\Provinsi::orderBy('nama_provinsi')->get();
                $daftarTahun = $daftarTahun ?? [2026, 2025, 2024];
            @endphp

            {{-- ================================================= --}}
            {{-- PANEL FILTER UTAMA (SESUAI GAMBAR 2: INDIKATOR, PERIODE, LEVEL) --}}
            {{-- ================================================= --}}
            <div class="mt-4 rounded-xl border border-slate-200 bg-white shadow-2xs overflow-hidden">
                {{-- Header Filter dengan Tombol Collapse --}}
                <div class="group flex items-center justify-between px-5 py-3.5 border-b border-slate-100 bg-white hover:bg-slate-50/70 select-none cursor-pointer transition" onclick="toggleFilterPanel()">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xs font-bold text-slate-800 tracking-wider uppercase">
                            FILTER
                        </span>
                        <span class="rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 text-[10px] font-bold">
                            Nasional • Provinsi • Kabupaten
                        </span>
                    </div>
                    <button type="button" class="h-7 w-7 rounded-full border border-blue-200 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 flex items-center justify-center shadow-2xs transition-all cursor-pointer" title="Buka/Tutup Filter">
                        <svg id="filterCollapseIcon" class="h-4 w-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                        </svg>
                    </button>
                </div>

                {{-- Form Filter --}}
                <div id="filterPanelBody" class="p-5 space-y-4">
                    {{-- Row 1: Indikator --}}
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                        <label class="md:col-span-2 text-xs font-bold text-slate-700">Indikator</label>
                        <div class="md:col-span-10">
                            <select id="filterIndikator" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3.5 py-2 text-xs text-slate-700 focus:bg-white focus:border-blue-500 focus:outline-none shadow-2xs transition">
                                <option value="Peta Endemisitas & Resistensi">Peta Endemisitas & Resistensi (Semua Indikator)</option>
                                <option value="Peta Uji Resistensi Insektisida">Peta Uji Resistensi Insektisida</option>
                                <option value="Peta Endemisitas">Peta Endemisitas</option>
                            </select>
                        </div>
                    </div>

                    {{-- Row 2: Periode Laporan --}}
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                        <label class="md:col-span-2 text-xs font-bold text-slate-700">Periode Laporan</label>
                        <div class="md:col-span-10">
                            <select id="filterPeriodeTahun" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3.5 py-2 text-xs text-slate-700 focus:bg-white focus:border-blue-500 focus:outline-none shadow-2xs transition">
                                <option value="">Semua Periode (Pilih Tahun)</option>
                                @foreach ($daftarTahun as $thn)
                                    <option value="{{ $thn }}">{{ $thn }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Row 3: Level --}}
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-start">
                        <label class="md:col-span-2 text-xs font-bold text-slate-700 pt-1.5">Level</label>
                        <div class="md:col-span-10 space-y-3">
                            {{-- Radio Pilihan Level --}}
                            <div class="flex flex-wrap items-center gap-6 text-xs text-slate-700 font-semibold">
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="levelFilter" value="nasional" checked onchange="handleLevelChange('nasional')" class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-slate-300">
                                    <span>Nasional</span>
                                </label>
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="levelFilter" value="provinsi" onchange="handleLevelChange('provinsi')" class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-slate-300">
                                    <span>Provinsi</span>
                                </label>
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="levelFilter" value="kabupaten" onchange="handleLevelChange('kabupaten')" class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-slate-300">
                                    <span>Kabupaten</span>
                                </label>
                            </div>

                            {{-- Pilihan Dropdown Provinsi & Kabupaten --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div class="relative">
                                    <select id="filterProvinsiSelect" onchange="handleProvinsiFilterChange(this.value)" disabled class="w-full rounded-xl border border-slate-200 bg-slate-100 px-3.5 py-2 text-xs text-slate-700 focus:bg-white focus:border-blue-500 focus:outline-none shadow-2xs disabled:opacity-60 disabled:cursor-not-allowed transition">
                                        <option value="">-- Pilih Provinsi --</option>
                                        @foreach ($provinsis as $prov)
                                            <option value="{{ $prov->id }}">{{ $prov->nama_provinsi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="relative">
                                    <select id="filterKabupatenSelect" disabled class="w-full rounded-xl border border-slate-200 bg-slate-100 px-3.5 py-2 text-xs text-slate-700 focus:bg-white focus:border-blue-500 focus:outline-none shadow-2xs disabled:opacity-60 disabled:cursor-not-allowed transition">
                                        <option value="">-- Pilih Kabupaten --</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Tombol Terapkan & Reset (Dipindahkan Tepat di Bawah Kotak Pilih Provinsi) --}}
                            <div class="pt-1 flex items-center gap-2.5">
                                <button type="button" onclick="applyRegionalFilter()" class="inline-flex items-center gap-2 rounded-xl bg-teal-600 hover:bg-teal-700 px-6 py-2.5 text-xs font-bold text-white shadow-xs transition cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Terapkan</span>
                                </button>
                                <button type="button" onclick="resetAllFilters()" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 px-4 py-2.5 text-xs font-semibold text-slate-600 shadow-2xs transition cursor-pointer">
                                    <span>Reset</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KETERANGAN STATUS FILTER DI ATAS PETA (SESUAI GAMBAR 2) --}}
            <div class="mt-4 mb-2 px-1 text-slate-800">
                <h4 id="activeFilterTitle" class="text-sm font-bold text-slate-900 leading-snug">
                    Peta Endemisitas & Resistensi
                </h4>
                <div id="activeFilterLevel" class="text-xs font-semibold text-slate-700 mt-0.5">
                    Level: NASIONAL (Seluruh Indonesia)
                </div>
                <div id="activeFilterPeriode" class="text-xs text-slate-500 mt-0.5">
                    Periode Laporan: Semua Periode
                </div>
            </div>

            {{-- ================================================= --}}
            {{-- MAP SEBARAN PEMERIKSAAN DENGAN FILTER SEJAJAR --}}
            {{-- ================================================= --}}
            <div class="mt-2 rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">

                {{-- FILTER TOOLBAR DI ATAS PETA (PROPORSIONAL PENUH) --}}
                <div class="mb-3.5 flex flex-wrap items-center gap-2.5 border-b border-slate-100 pb-3.5">

                    {{-- JENIS NYAMUK --}}
                    <div class="flex-1 min-w-[150px]">
                        <select id="filterJenisNyamuk" onchange="applyFilters()" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-700 shadow-2xs focus:border-blue-500 focus:outline-none cursor-pointer transition">
                            <option value="">Semua Nyamuk</option>
                            @foreach ($daftarNyamuk as $nyamuk)
                                <option value="{{ $nyamuk }}">{{ $nyamuk }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- INSEKTISIDA --}}
                    <div class="flex-1 min-w-[150px]">
                        <select id="filterInsektisida" onchange="applyFilters()" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-700 shadow-2xs focus:border-blue-500 focus:outline-none cursor-pointer transition">
                            <option value="">Semua Insektisida</option>
                            @foreach ($daftarInsektisida as $ins)
                                <option value="{{ $ins }}">{{ $ins }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- METODE --}}
                    <div class="flex-1 min-w-[140px]">
                        <select id="filterMetode" onchange="applyFilters()" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-700 shadow-2xs focus:border-blue-500 focus:outline-none cursor-pointer transition">
                            <option value="">Semua Metode</option>
                            @foreach ($daftarMetode as $met)
                                <option value="{{ $met }}">{{ $met }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- STATUS RESISTENSI --}}
                    <div class="flex-1 min-w-[150px]">
                        <select id="filterStatus" onchange="applyFilters()" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-700 shadow-2xs focus:border-blue-500 focus:outline-none cursor-pointer transition">
                            <option value="">Semua Status</option>
                            <option value="Resisten">🔴 Resisten</option>
                            <option value="Toleran">🟡 Toleran</option>
                            <option value="Rentan">🟢 Rentan</option>
                        </select>
                    </div>

                    {{-- TOMBOL RESET FILTER & RESET PETA --}}
                    <div class="shrink-0 flex items-center gap-2">
                        <button type="button" onclick="resetAllFilters()" class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:text-slate-800 px-3 py-2 text-xs font-semibold text-slate-600 transition shadow-2xs cursor-pointer whitespace-nowrap" title="Reset Semua Filter">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span>Reset Filter</span>
                        </button>
                        <button type="button" onclick="resetMapView()" class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 hover:bg-blue-600 hover:text-white hover:border-blue-600 px-3 py-2 text-xs font-semibold text-blue-700 transition shadow-2xs cursor-pointer whitespace-nowrap group" title="Kembalikan Tampilan Peta ke Posisi Awal (Seluruh Indonesia)">
                            <svg class="h-3.5 w-3.5 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Reset Peta</span>
                        </button>
                    </div>

                </div>

                {{-- MAP CONTAINER --}}
                <div id="map"></div>



            </div>

            {{-- ================================================= --}}
            {{-- DATA PEMERIKSAAN TERBARU --}}
            {{-- ================================================= --}}
            <div id="tablePemeriksaanSection" class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-2xs scroll-mt-6">

                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-4 py-3">
                    <div class="flex items-center gap-2">
                        <span class="flex h-2 w-2 rounded-full bg-blue-600 ring-4 ring-blue-100"></span>
                        <h3 class="text-sm font-bold text-slate-800" id="tableHeaderTitle">
                            Data Pemeriksaan Terbaru
                        </h3>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5">
                        {{-- KOTAK PENCARIAN TABEL DATA PEMERIKSAAN TERBARU --}}
                        <div class="relative w-52 sm:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text"
                                   id="tableSearchInput"
                                   oninput="handleSearch(this.value)"
                                   placeholder="Cari di tabel pemeriksaan..."
                                   class="w-full rounded-lg border border-slate-200 bg-slate-50/80 pl-8 pr-7 py-1.5 text-xs text-slate-700 transition focus:border-blue-500 focus:bg-white focus:outline-none shadow-2xs">
                            <button type="button"
                                    id="tableSearchClearBtn"
                                    onclick="clearSearch()"
                                    class="absolute inset-y-0 right-0 flex items-center pr-2 text-slate-400 hover:text-rose-500 hidden cursor-pointer font-bold text-xs"
                                    title="Hapus kata kunci pencarian">
                                ✕
                            </button>
                        </div>

                        {{-- KONTROL TAMPIL DATA (PAGE SIZE SELECTOR) --}}
                        <div class="flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1 shadow-2xs">
                            <label for="tablePageSizeSelect" class="text-xs font-semibold text-slate-600 whitespace-nowrap flex items-center gap-1">
                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                                <span>Tampil:</span>
                            </label>
                            <select id="tablePageSizeSelect" onchange="changeTablePageSize(this.value)" class="rounded border border-slate-200 bg-white px-2 py-0.5 text-xs font-bold text-slate-700 shadow-2xs focus:border-blue-500 focus:outline-none cursor-pointer">
                                <option value="5">5 data</option>
                                <option value="10" selected>10 data</option>
                                <option value="25">25 data</option>
                                <option value="50">50 data</option>
                                <option value="100">100 data</option>
                                <option value="all">Semua data</option>
                            </select>
                        </div>

                        <a href="{{ route('input') }}" class="inline-flex items-center gap-1 rounded-lg border border-blue-200 bg-blue-50 hover:bg-blue-100 hover:text-blue-800 px-3 py-1.5 text-xs font-semibold text-blue-700 shadow-2xs transition whitespace-nowrap">
                            <span>Lihat Semua Data</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto bg-slate-50">
                    <table class="w-full text-left text-xs table-fixed">
                        <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 font-bold border-b border-slate-200">
                            <tr>
                                <th class="w-[4%] px-1.5 py-2.5 text-center text-slate-500">No</th>
                                <th class="w-[13%] px-2 py-2.5 whitespace-nowrap">Kab/Prov</th>
                                <th class="w-[16%] px-2 py-2.5 whitespace-nowrap">Alamat / Lokasi</th>
                                <th class="w-[11%] px-1.5 py-2.5 whitespace-nowrap">Jenis Nyamuk</th>
                                <th class="w-[16%] px-2 py-2.5 whitespace-nowrap">Insektisida / Metode</th>
                                <th class="w-[6%] px-1 py-2.5 text-center whitespace-nowrap">Sampel</th>
                                <th class="w-[10%] px-1.5 py-2.5 text-center whitespace-nowrap">Status</th>
                                <th class="w-[9%] px-1 py-2.5 text-center whitespace-nowrap">Periode</th>
                                <th class="w-[15%] px-1.5 py-2.5 text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 bg-white" id="tableDataBody">
                            @forelse ($dataTerbaru as $index => $item)
                                <tr class="hover:bg-blue-50/40 transition" id="row-data-{{ $item->id }}">
                                    <td class="px-1.5 py-2 text-center font-bold text-slate-400 text-xs truncate">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-2 py-2 text-xs truncate">
                                        <div class="font-semibold text-slate-800 leading-tight truncate" title="{{ $item->kabupaten->nama_kabupaten ?? '-' }}">
                                            {{ $item->kabupaten->nama_kabupaten ?? '-' }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 font-normal leading-tight truncate" title="{{ $item->provinsi->nama_provinsi ?? '-' }}">
                                            {{ $item->provinsi->nama_provinsi ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-xs text-slate-700 leading-snug truncate">
                                        @if (!empty($item->alamat))
                                            <span class="inline-flex items-center gap-1 font-medium text-slate-700 max-w-full truncate" title="{{ $item->alamat }}">
                                                <span class="text-blue-500 shrink-0">📍</span>
                                                <span class="truncate">{{ $item->alamat }}</span>
                                            </span>
                                        @else
                                            <span class="italic text-slate-400">Belum diisi</span>
                                        @endif
                                    </td>
                                    <td class="px-1.5 py-2 whitespace-nowrap truncate">
                                        <span class="inline-block rounded-md bg-blue-50 border border-blue-100 px-1.5 py-0.5 text-[11px] font-semibold text-blue-700 truncate max-w-full">
                                            {{ $item->jenis_nyamuk }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-2 text-xs truncate">
                                        <div class="font-semibold text-slate-800 leading-tight truncate" title="{{ $item->insektisida ?? '-' }}">
                                            {{ $item->insektisida ?? '-' }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 font-normal leading-tight truncate" title="{{ $item->metode ?? '-' }}">
                                            {{ $item->metode ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-1 py-2 text-center font-bold text-slate-800 text-xs whitespace-nowrap truncate">
                                        {{ number_format($item->sampel_diperiksa) }}
                                    </td>
                                    <td class="px-1.5 py-2 text-center whitespace-nowrap">
                                        @if ($item->status === 'Resisten')
                                            <span class="inline-flex items-center gap-1 rounded-md bg-rose-50 border border-rose-200 px-1.5 py-0.5 text-[11px] font-bold text-rose-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Resisten
                                            </span>
                                        @elseif (in_array($item->status, ['Toleran/Terduga Resisten', 'Toleran', 'Terduga Resisten']))
                                            <span class="inline-flex items-center gap-1 rounded-md bg-amber-50 border border-amber-200 px-1.5 py-0.5 text-[11px] font-bold text-amber-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Toleran
                                            </span>
                                        @elseif ($item->status === 'Rentan')
                                            <span class="inline-flex items-center gap-1 rounded-md bg-emerald-50 border border-emerald-200 px-1.5 py-0.5 text-[11px] font-bold text-emerald-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Rentan
                                            </span>
                                        @else
                                            <span class="text-xs text-slate-400 italic">-</span>
                                        @endif
                                    </td>
                                    <td class="px-1 py-2 text-center text-[11px] text-slate-500 whitespace-nowrap truncate">
                                        {{ $item->bulan }} {{ $item->tahun }}
                                    </td>
                                    <td class="px-1.5 py-2 text-center whitespace-nowrap">
                                        <div class="inline-flex items-center justify-center gap-1">
                                            <button type="button"
                                                    onclick="showRowDetailModal({{ $item->id }})"
                                                    class="inline-flex items-center gap-0.5 rounded-md border border-slate-200 bg-white px-1.5 py-0.5 text-[11px] font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 hover:border-blue-300 transition shadow-2xs cursor-pointer"
                                                    title="Tampilkan rincian data pemeriksaan ini">
                                                <span>👁️</span>
                                                <span>Detail</span>
                                            </button>
                                            @if ($item->kabupaten && $item->kabupaten->latitude && $item->kabupaten->longitude)
                                                <button type="button"
                                                        onclick="focusOnMap({{ $item->kabupaten->latitude }}, {{ $item->kabupaten->longitude }}, {{ $item->kabupaten->id }})"
                                                        class="inline-flex items-center gap-0.5 rounded-md border border-blue-200 bg-blue-50 px-1.5 py-0.5 text-[11px] font-semibold text-blue-700 hover:bg-blue-600 hover:text-white transition shadow-2xs cursor-pointer"
                                                        title="Lihat titik lokasi ini di peta">
                                                    <span>📍</span>
                                                    <span>Peta</span>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-8 text-center text-xs text-slate-400">
                                        Belum ada data pemeriksaan tersimpan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION CONTAINER UNTUK TABEL DASHBOARD --}}
                <div id="dashboardTablePagination" class="border-t border-slate-100 bg-white px-4 py-2.5"></div>

            </div>

        </section>

    </main>

    {{-- LEAFLET JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- SCRIPT PETA & LOGIKA PENCARIAN DASHBOARD --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Inisialisasi Map Leaflet dengan view Indonesia
            const map = L.map('map', {
                scrollWheelZoom: true
            }).setView([-2.5, 118], 5);

            // Layer Tile Bebas API Key & Tanpa Watermark (OpenStreetMap)
            const mapTileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);

            // Kontrol Tombol Reset View Peta di Leaflet (di bawah tombol zoom)
            const ResetViewControl = L.Control.extend({
                options: { position: 'topleft' },
                onAdd: function() {
                    const container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
                    const btn = L.DomUtil.create('a', 'leaflet-control-reset-view', container);
                    btn.href = '#';
                    btn.title = 'Reset Tampilan Peta (Kembali ke Semula)';
                    btn.role = 'button';
                    btn.setAttribute('aria-label', 'Reset Tampilan Peta');
                    btn.style.display = 'flex';
                    btn.style.alignItems = 'center';
                    btn.style.justifyContent = 'center';
                    btn.style.cursor = 'pointer';
                    btn.innerHTML = `<svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>`;
                    L.DomEvent.disableClickPropagation(btn);
                    L.DomEvent.on(btn, 'click', function(e) {
                        L.DomEvent.preventDefault(e);
                        window.resetMapView();
                    });
                    return container;
                }
            });
            map.addControl(new ResetViewControl());

            window.updateMapTheme = function(isDark) {
                // Mode gelap peta dikendalikan via CSS filter pada leaflet-tile-pane tanpa butuh API key eksternal
            };

            const rawData = @json($data);
            const polygonsLayer = L.layerGroup().addTo(map);
            const markersLayer = L.layerGroup().addTo(map);
            const desaMarkerLayer = L.layerGroup().addTo(map);
            const desaCoordsCache = {};
            const geoCentroidsByNorm = {};
            const markersByKabId = {};
            const kabDataById = {};
            let isDetailPinned = false;
            let pinnedKabId = null;
            let activeTooltipLayer = null;

            let showPolygons = true;
            let showMarkers = true;
            let rawGeojsonData = null;
            let geojsonLayer = null;

            let currentSearch = '';
            let tableCurrentPage = 1;
            let tablePageSize = 10;
            let currentFilteredData = [];
            let currentHasQuery = false;
            let currentHasFilter = false;

            // Escape HTML helper
            function escapeHtml(str) {
                if (str === null || str === undefined) return '';
                return String(str)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            // Konfigurasi status resistensi & palet warna (3 Kategori Standar)
            function getStatusConfig(status) {
                if (status === 'Resisten') {
                    return {
                        label: 'Resisten',
                        badgeText: 'Resisten',
                        color: '#EF4444', // Merah (Rose-500)
                        pulseColor: 'rgba(239, 68, 68, 0.55)',
                        textHex: '#B91C1C',
                        badgeClass: 'bg-rose-50 border-rose-200 text-rose-700',
                        dotClass: 'bg-rose-500',
                        priority: 3
                    };
                } else if (status === 'Toleran/Terduga Resisten' || status === 'Toleran' || status === 'Terduga Resisten') {
                    return {
                        label: 'Toleran/Terduga Resisten',
                        badgeText: 'Toleran/Terduga',
                        color: '#F59E0B', // Kuning/Amber (Amber-500)
                        pulseColor: 'rgba(245, 158, 11, 0.55)',
                        textHex: '#B45309',
                        badgeClass: 'bg-amber-50 border-amber-200 text-amber-700',
                        dotClass: 'bg-amber-500',
                        priority: 2
                    };
                } else if (status === 'Rentan') {
                    return {
                        label: 'Rentan',
                        badgeText: 'Rentan',
                        color: '#10B981', // Hijau (Emerald-500)
                        pulseColor: 'rgba(16, 185, 129, 0.55)',
                        textHex: '#047857',
                        badgeClass: 'bg-emerald-50 border-emerald-200 text-emerald-700',
                        dotClass: 'bg-emerald-500',
                        priority: 1
                    };
                } else {
                    return {
                        label: 'Belum Terdata',
                        badgeText: '-',
                        color: '#64748B', // Slate
                        pulseColor: 'rgba(100, 116, 139, 0.45)',
                        textHex: '#334155',
                        badgeClass: 'bg-slate-50 border-slate-200 text-slate-500',
                        dotClass: 'bg-slate-400',
                        priority: 0
                    };
                }
            }

            // Card Detail Wilayah di pojok kanan atas peta (seperti Gambar 3)
            const infoControl = L.control({ position: 'topright' });
            infoControl.onAdd = function (map) {
                this._div = L.DomUtil.create('div', 'map-detail-panel');
                L.DomEvent.disableClickPropagation(this._div);
                L.DomEvent.disableScrollPropagation(this._div);
                this._div.style.display = 'none';
                return this._div;
            };

            infoControl.renderDefault = function () {
                this._div.classList.remove('is-pinned');
                this._div.style.pointerEvents = 'none';
                this._div.style.display = 'none';
                this._div.innerHTML = '';
            };

            infoControl.renderEmpty = function (rawName) {
                this._div.classList.remove('is-pinned');
                this._div.style.pointerEvents = 'none';
                this._div.style.display = 'block';
                this._div.innerHTML = `
                    <div class="space-y-1.5 text-xs">
                        <div class="flex items-center justify-between pb-1.5 border-b border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">PROVINSI: INDONESIA</span>
                            <span class="text-[10px] text-slate-400 font-medium">Batas Administrasi</span>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KAB/KOTA:</div>
                            <div class="text-sm font-extrabold text-slate-800 leading-tight">
                                KABUPATEN ${escapeHtml(rawName).toUpperCase()}
                            </div>
                        </div>
                        <div class="flex items-center gap-2 pt-1 text-slate-500 text-[11px]">
                            <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                            <span class="italic text-slate-400">Belum ada data hasil uji tersimpan</span>
                        </div>
                    </div>
                `;
            };

            infoControl.renderDetails = function (data, isPinned) {
                const { kabupaten, provinsi, entries, totalEntri, totalSampel, activeStatuses, alamats } = data;

                // Status Wilayah Badge
                let statusBadgeHtml = '';
                if (activeStatuses.length === 1) {
                    const single = activeStatuses[0];
                    statusBadgeHtml = `
                        <span class="inline-flex items-center gap-1 rounded-md px-2 py-0.5 text-[11px] font-bold border ${single.badgeClass}">
                            <span class="h-1.5 w-1.5 rounded-full ${single.dotClass}"></span>
                            ${single.status}
                        </span>
                    `;
                } else if (activeStatuses.length > 1) {
                    const badges = activeStatuses.map(st => `
                        <span class="inline-flex items-center gap-1 rounded px-1.5 py-0.5 text-[10px] font-bold border ${st.badgeClass}">
                            <span class="h-1.5 w-1.5 rounded-full ${st.dotClass}"></span>
                            ${st.count} ${st.label}
                        </span>
                    `).join('');
                    statusBadgeHtml = `
                        <div class="space-y-1">
                            <div class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded bg-indigo-50 border border-indigo-200 text-indigo-700">
                                Multi-Status (${activeStatuses.length} Status)
                            </div>
                            <div class="flex flex-wrap gap-1">
                                ${badges}
                            </div>
                        </div>
                    `;
                } else {
                    statusBadgeHtml = `<span class="text-[11px] text-slate-400 italic">Belum terdata</span>`;
                }

                // Alamat HTML (Tombol Interaktif Menuju Titik Desa di Peta)
                const alamatHtml = alamats && alamats.length > 0
                    ? alamats.map(item => {
                        const countInAlamat = entries.filter(e => (e.alamat || '').trim().toLowerCase() === item.trim().toLowerCase()).length;
                        return `
                            <button type="button"
                                    onclick="focusOnDesaAlamat('${escapeHtml(item).replace(/'/g, "\\'")}', '${kabupaten ? kabupaten.id : ''}', event)"
                                    class="w-full text-left bg-blue-50/70 hover:bg-blue-100 active:bg-blue-200 border border-blue-200 hover:border-blue-300 rounded-lg px-2.5 py-1.5 text-[11px] text-slate-800 font-medium transition cursor-pointer flex items-center justify-between group shadow-2xs"
                                    title="Klik untuk menyorot dan mengarahkan peta ke titik lokasi ${escapeHtml(item)}">
                                <span class="flex items-center gap-1.5 truncate">
                                    <span class="text-xs transition-transform group-hover:scale-125">📍</span>
                                    <span class="truncate font-semibold text-slate-800">${escapeHtml(item)}</span>
                                </span>
                                <span class="flex items-center gap-1 text-[10px] text-blue-600 group-hover:text-blue-800 font-bold shrink-0 ml-1.5 bg-white/80 px-1.5 py-0.5 rounded border border-blue-100">
                                    <span>${countInAlamat > 0 ? countInAlamat + ' uji' : 'Lihat'}</span>
                                    <span class="transition-transform group-hover:translate-x-0.5">→</span>
                                </span>
                            </button>
                        `;
                    }).join('')
                    : `<div class="bg-white/45 border border-slate-200/60 rounded-lg px-2.5 py-1.5 text-[11px] text-slate-600 flex items-center justify-between">
                            <span class="italic text-slate-500">📍 Alamat belum diisi</span>
                            <span class="font-bold text-blue-700 bg-blue-100/60 border border-blue-200/60 px-1.5 py-0.5 rounded text-[10px]">${totalEntri} Data (${totalSampel} Sampel)</span>
                       </div>`;

                // Entries List HTML
                const entriesListHtml = entries.slice(0, 5).map(item => {
                    const itemStatusConf = getStatusConfig(item.status);
                    return `
                        <div class="border-b border-slate-200/60 pb-1.5 mb-1.5 last:border-0 last:mb-0">
                            <div class="flex items-center justify-between text-[11px] mb-0.5">
                                <span class="font-bold text-slate-800">${escapeHtml(item.jenis_nyamuk || '-')}</span>
                                <span class="inline-flex items-center gap-1 rounded px-1.5 py-0.5 text-[9.5px] font-bold border ${itemStatusConf.badgeClass}">
                                    <span class="h-1.5 w-1.5 rounded-full ${itemStatusConf.dotClass}"></span>
                                    ${itemStatusConf.badgeText}
                                </span>
                            </div>
                            <div class="flex items-start justify-between gap-1.5 text-[10px] text-slate-500">
                                <div class="min-w-0 flex-1 leading-snug break-words">
                                    <span class="font-medium">${escapeHtml(item.insektisida || '-')}</span>
                                    <span class="text-slate-400 mx-0.5">•</span>
                                    <span>${escapeHtml(item.metode || '-')}</span>
                                </div>
                                <span class="font-medium text-slate-600 shrink-0 whitespace-nowrap">${Number(item.sampel_diperiksa || 0).toLocaleString()} sampel</span>
                            </div>
                        </div>
                    `;
                }).join('');

                const moreEntriesHtml = entries.length > 5
                    ? `<div class="text-[10px] text-center text-slate-400 italic mt-1">+ ${entries.length - 5} entri lainnya</div>`
                    : '';

                this._div.style.display = 'block';
                if (isPinned) {
                    this._div.classList.add('is-pinned');
                    this._div.style.pointerEvents = 'auto';
                } else {
                    this._div.classList.remove('is-pinned');
                    this._div.style.pointerEvents = 'none';
                }
                this._div.innerHTML = `
                    <div>
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-200/60">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100/80 text-blue-800 uppercase tracking-wide panel-provinsi-badge">
                                    PROVINSI ${escapeHtml(provinsi ? provinsi.nama_provinsi : 'INDONESIA')}
                                </span>
                                ${isPinned ? '<span class="text-[9.5px] font-bold text-teal-700 bg-teal-50/80 border border-teal-200/80 px-1.5 py-0.5 rounded-full">📌 Terpilih</span>' : ''}
                            </div>
                            ${isPinned ? '<button type="button" onclick="window.unpinDetailCard()" class="text-slate-400 hover:text-slate-700 hover:bg-slate-200/60 rounded-full h-5 w-5 flex items-center justify-center font-bold text-xs transition cursor-pointer" title="Tutup Detail">✕</button>' : ''}
                        </div>

                        <div class="space-y-2 text-xs">
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KAB/KOTA:</div>
                                <div class="text-sm font-extrabold text-slate-800 leading-tight">
                                    KABUPATEN ${escapeHtml(kabupaten ? kabupaten.nama_kabupaten : '').toUpperCase()}
                                </div>
                            </div>

                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">STATUS WILAYAH:</div>
                                ${statusBadgeHtml}
                            </div>

                            <div class="pt-1.5 border-t border-slate-200/60">
                                <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">
                                    <span>TITIK LOKASI / ALAMAT:</span>
                                    <span class="text-slate-600 font-semibold">${totalEntri} Pemeriksaan</span>
                                </div>
                                <div class="max-h-28 overflow-y-auto space-y-1 pr-0.5">
                                    ${alamatHtml}
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-1.5 pt-1">
                                <div class="rounded-lg border border-slate-200/60 bg-white/45 p-1.5 text-center panel-stat-box">
                                    <div class="text-sm font-bold text-slate-800">${totalEntri}</div>
                                    <div class="text-[9.5px] text-slate-500 font-medium">Total Uji</div>
                                </div>
                                <div class="rounded-lg border border-slate-200/60 bg-white/45 p-1.5 text-center panel-stat-box">
                                    <div class="text-sm font-bold text-slate-800">${totalSampel.toLocaleString()}</div>
                                    <div class="text-[9.5px] text-slate-500 font-medium">Sampel Diuji</div>
                                </div>
                            </div>

                            <div class="pt-1.5 border-t border-slate-200/60">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">
                                    HASIL PEMERIKSAAN (${totalEntri} DATA):
                                </div>
                                <div class="bg-white/45 border border-slate-200/60 rounded-lg p-2 max-h-36 overflow-y-auto panel-results-box">
                                    ${entriesListHtml}
                                    ${moreEntriesHtml}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            };
            infoControl.addTo(map);

            // Legenda Keterangan Status Resistensi di Peta Dipindahkan ke Sebelah Kiri Bawah (Bottom Left)
            const legendControl = L.control({ position: 'bottomleft' });
            legendControl.onAdd = function (map) {
                const div = L.DomUtil.create('div', 'map-legend-control select-none');
                L.DomEvent.disableClickPropagation(div);
                L.DomEvent.disableScrollPropagation(div);
                div.innerHTML = `
                    <div class="font-bold text-slate-800 text-[11px] mb-1.5 flex items-center justify-between border-b border-slate-100 pb-1">
                        <div class="flex items-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-teal-500"></span>
                            <span>Keterangan Status Wilayah</span>
                        </div>
                    </div>
                    <div class="space-y-1 font-medium text-[10.5px]">
                        <div class="flex items-center gap-2">
                            <span class="h-2.5 w-4 rounded-sm bg-rose-500 shadow-2xs shrink-0 border border-rose-600"></span>
                            <span class="text-slate-700">Resisten (Merah)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="h-2.5 w-4 rounded-sm bg-amber-500 shadow-2xs shrink-0 border border-amber-600"></span>
                            <span class="text-slate-700">Toleran / Terduga (Kuning)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="h-2.5 w-4 rounded-sm bg-emerald-500 shadow-2xs shrink-0 border border-emerald-600"></span>
                            <span class="text-slate-700">Rentan (Hijau)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="h-2.5 w-4 rounded-sm shadow-2xs shrink-0 border border-indigo-400" style="background: linear-gradient(135deg, #EF4444 33%, #F59E0B 33%, #F59E0B 66%, #10B981 66%);"></span>
                            <span class="text-slate-700">Multi-Status</span>
                        </div>
                        <div class="flex items-center gap-2 pt-0.5 border-t border-slate-100/90">
                            <span class="h-2.5 w-4 rounded-sm bg-slate-50 border border-dashed border-slate-300 shrink-0"></span>
                            <span class="text-slate-400 text-[10px]">Belum Ada Data</span>
                        </div>
                    </div>
                `;
                return div;
            };
            legendControl.addTo(map);

            window.showKabupatenDetail = function (kabIdOrNorm, isPin = false) {
                if (!isPin && isDetailPinned) return;

                let foundData = null;
                if (kabDataById[kabIdOrNorm]) {
                    foundData = kabDataById[kabIdOrNorm];
                } else {
                    const norm = normalizeKabName(kabIdOrNorm);
                    for (let id in kabDataById) {
                        const it = kabDataById[id];
                        if (it && it.kabupaten && normalizeKabName(it.kabupaten.nama_kabupaten) === norm) {
                            foundData = it;
                            break;
                        }
                    }
                }

                if (!foundData) return;

                if (isPin) {
                    isDetailPinned = true;
                    pinnedKabId = foundData.kabupaten ? foundData.kabupaten.id : null;
                }

                infoControl.renderDetails(foundData, isPin || isDetailPinned);
            };

            window.unpinDetailCard = function () {
                isDetailPinned = false;
                pinnedKabId = null;
                if (activeTooltipLayer) {
                    try { activeTooltipLayer.closeTooltip(); } catch (e) {}
                    activeTooltipLayer = null;
                }
                if (desaMarkerLayer) {
                    desaMarkerLayer.clearLayers();
                }
                infoControl.renderDefault();
            };

            // Klik pada area kosong peta untuk melepas pin detail card
            map.on('click', function () {
                if (isDetailPinned) {
                    window.unpinDetailCard();
                }
            });

            // Normalisasi nama kabupaten untuk pencocokan akurat dengan GeoJSON
            function normalizeKabName(str) {
                if (!str) return '';
                let s = String(str).toLowerCase().trim();
                s = s.replace(/^(kabupaten|kota|kab\.|adm\.|administrasi)\s+/gi, '');
                s = s.replace(/\s+(kabupaten|kota)$/gi, '');
                if (s.includes('mentawai')) return 'kepulauanmentawai';
                if (s.includes('tanimbar')) return 'malukutenggarabarat';
                if (s.includes('pasangkayu')) return 'mamujuutara';
                if (s.includes('mahakam')) return 'kutaibarat';
                return s.replace(/[^a-z0-9]/g, '');
            }

            // Fungsi Render Poligon Batas Wilayah Berwarna (Choropleth Peta seperti Gambar Contoh)
            function renderGeoJsonPolygons(activeData) {
                if (!rawGeojsonData) return;
                polygonsLayer.clearLayers();

                if (!showPolygons) return;

                // Bangun mapping ringkasan kabupaten berdasarkan data aktif
                const kabSummaryMap = {};
                (activeData || rawData).forEach(item => {
                    const kab = item.kabupaten;
                    if (!kab || !kab.nama_kabupaten) return;
                    const norm = normalizeKabName(kab.nama_kabupaten);
                    if (!kabSummaryMap[norm]) {
                        kabSummaryMap[norm] = {
                            kabupaten: kab,
                            provinsi: item.provinsi,
                            entries: [],
                            rCount: 0,
                            tCount: 0,
                            gCount: 0
                        };
                    }
                    kabSummaryMap[norm].entries.push(item);
                    if (item.status === 'Resisten') kabSummaryMap[norm].rCount++;
                    else if (item.status === 'Rentan') kabSummaryMap[norm].gCount++;
                    else if (item.status === 'Toleran/Terduga Resisten' || item.status === 'Toleran' || item.status === 'Terduga Resisten') kabSummaryMap[norm].tCount++;
                });

                geojsonLayer = L.geoJSON(rawGeojsonData, {
                    style: function (feature) {
                        const rawName = feature.properties ? feature.properties.name : '';
                        const norm = normalizeKabName(rawName);
                        const info = kabSummaryMap[norm];

                        if (info && info.entries.length > 0) {
                            // Wilayah memiliki data -> Beri warna sesuai status (seperti contoh gambar)
                            let fillColor = '#10B981'; // Hijau Rentan
                            let borderColor = '#047857';

                            if (info.rCount > 0 && (info.tCount > 0 || info.gCount > 0)) {
                                fillColor = '#EF4444'; // Resisten merah
                                borderColor = '#B91C1C';
                            } else if (info.rCount > 0) {
                                fillColor = '#EF4444'; // Resisten merah (Rose-500)
                                borderColor = '#B91C1C';
                            } else if (info.tCount > 0) {
                                fillColor = '#EAB308'; // Toleran / Terduga kuning (Yellow-500)
                                borderColor = '#A16207';
                            } else if (info.gCount > 0) {
                                fillColor = '#22C55E'; // Rentan hijau terang (Green-500)
                                borderColor = '#15803D';
                            }

                            return {
                                fillColor: fillColor,
                                weight: 1.8,
                                opacity: 1,
                                color: borderColor,
                                fillOpacity: 0.78,
                                dashArray: ''
                            };
                        } else {
                            // Wilayah tanpa data: warna netral terang dengan garis batas administratif
                            return {
                                fillColor: '#F8FAFC',
                                weight: 0.75,
                                opacity: 0.55,
                                color: '#94A3B8',
                                fillOpacity: 0.15,
                                dashArray: '2, 3'
                            };
                        }
                    },
                    onEachFeature: function (feature, layer) {
                        const rawName = feature.properties ? feature.properties.name : '';
                        const norm = normalizeKabName(rawName);
                        const info = kabSummaryMap[norm];

                        if (layer.getBounds && typeof layer.getBounds === 'function') {
                            try {
                                geoCentroidsByNorm[norm] = layer.getBounds().getCenter();
                            } catch (e) {}
                        }

                        layer.on({
                            mouseover: function (e) {
                                const target = e.target;
                                target.setStyle({
                                    weight: 2.8,
                                    color: '#0284C7',
                                    fillOpacity: info ? 0.92 : 0.45
                                });
                                if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                                    target.bringToFront();
                                }
                                if (info && info.kabupaten) {
                                    showKabupatenDetail(info.kabupaten.id, false);
                                } else {
                                    if (!isDetailPinned) infoControl.renderEmpty(rawName);
                                }
                            },
                            mouseout: function (e) {
                                if (geojsonLayer) {
                                    geojsonLayer.resetStyle(e.target);
                                }
                                if (!isDetailPinned) {
                                    infoControl.renderDefault();
                                }
                            },
                            click: function (e) {
                                L.DomEvent.stopPropagation(e);
                                if (activeTooltipLayer && activeTooltipLayer !== layer) {
                                    try { activeTooltipLayer.closeTooltip(); } catch (err) {}
                                }
                                if (info && info.kabupaten) {
                                    showKabupatenDetail(info.kabupaten.id, true);
                                    layer.openTooltip();
                                    activeTooltipLayer = layer;
                                } else {
                                    if (!isDetailPinned) infoControl.renderEmpty(rawName);
                                }
                                map.fitBounds(e.target.getBounds(), { padding: [50, 50], maxZoom: 10 });
                            }
                        });

                        // Label nama kabupaten di peta (seperti Gambar 3: BANGKA BARAT)
                        layer.bindTooltip(`KAB. ${escapeHtml(rawName).toUpperCase()}`, {
                            direction: 'center',
                            className: 'region-map-label',
                            permanent: false
                        });
                    }
                });

                polygonsLayer.addLayer(geojsonLayer);
            }

            // Muat data GeoJSON batas kabupaten Indonesia
            fetch('{{ asset("geojson/indonesia-kabupaten.json") }}')
                .then(res => res.json())
                .then(data => {
                    rawGeojsonData = data;
                    renderGeoJsonPolygons(currentFilteredData.length > 0 ? currentFilteredData : rawData);
                    renderDashboard(false);
                })
                .catch(err => {
                    console.warn('Gagal memuat file GeoJSON batas kabupaten:', err);
                });

            // Buat Custom Marker Pin: Warna solid jika 1 status, Segmen Conic-Gradient jika Multi-Status
            function createCustomMarkerIcon(entriesOrCount, maybeConfig) {
                let entries = [];
                if (Array.isArray(entriesOrCount)) {
                    entries = entriesOrCount;
                } else if (entriesOrCount && typeof entriesOrCount === 'object' && Array.isArray(entriesOrCount.data)) {
                    entries = entriesOrCount.data;
                }

                const totalEntri = entries.length > 0 ? entries.length : (typeof entriesOrCount === 'number' ? entriesOrCount : 1);

                // Hitung kemunculan masing-masing dari 3 status
                let rCount = 0; // Resisten
                let tCount = 0; // Toleran/Terduga Resisten
                let gCount = 0; // Rentan

                if (entries.length > 0) {
                    entries.forEach(it => {
                        if (it.status === 'Resisten') {
                            rCount++;
                        } else if (it.status === 'Rentan') {
                            gCount++;
                        } else if (it.status === 'Toleran/Terduga Resisten' || it.status === 'Toleran' || it.status === 'Terduga Resisten') {
                            tCount++;
                        }
                    });
                } else if (maybeConfig && maybeConfig.label) {
                    if (maybeConfig.label === 'Resisten') rCount = totalEntri;
                    else if (maybeConfig.label === 'Rentan') gCount = totalEntri;
                    else tCount = totalEntri;
                }

                const activeList = [];
                if (rCount > 0) activeList.push({ key: 'Resisten', count: rCount, color: '#EF4444', label: 'Resisten' });
                if (tCount > 0) activeList.push({ key: 'Toleran/Terduga Resisten', count: tCount, color: '#F59E0B', label: 'Toleran/Terduga' });
                if (gCount > 0) activeList.push({ key: 'Rentan', count: gCount, color: '#10B981', label: 'Rentan' });

                let headBackground = '#64748B';
                let pointerColor = '#334155';
                let pulseColor = 'rgba(100, 116, 139, 0.5)';
                let dotsHtml = '';

                if (activeList.length === 1) {
                    // Tepat 1 Status di Kabupaten ini (Warna Solid)
                    const single = activeList[0];
                    headBackground = single.color;
                    pointerColor = single.color;
                    pulseColor = single.color === '#EF4444'
                        ? 'rgba(239, 68, 68, 0.55)'
                        : (single.color === '#F59E0B' ? 'rgba(245, 158, 11, 0.55)' : 'rgba(16, 185, 129, 0.55)');
                } else if (activeList.length > 1) {
                    // Multi-Status: Buat Conic Gradient berdasarkan proporsi data masing-masing status
                    let currentPct = 0;
                    const gradientParts = [];
                    activeList.forEach(item => {
                        const pct = (item.count / totalEntri) * 100;
                        const nextPct = currentPct + pct;
                        gradientParts.push(`${item.color} ${currentPct.toFixed(1)}% ${nextPct.toFixed(1)}%`);
                        currentPct = nextPct;
                    });
                    headBackground = `conic-gradient(${gradientParts.join(', ')})`;
                    pointerColor = activeList[0].color; // Prioritas ujung pointer segitiga
                    pulseColor = 'rgba(99, 102, 241, 0.55)'; // Radar pulse indigo multi-status

                    // Buat mini dots pill di bawah pin pointer
                    const miniDots = activeList.map(item => `
                        <span class="pin-dot-mini" style="background: ${item.color};" title="${item.label}: ${item.count} data"></span>
                    `).join('');

                    dotsHtml = `
                        <div class="pin-status-dots" title="Kabupaten memiliki ${activeList.length} status berbeda">
                            ${miniDots}
                        </div>
                    `;
                } else {
                    headBackground = '#3B82F6';
                    pointerColor = '#2563EB';
                    pulseColor = 'rgba(37, 99, 235, 0.5)';
                }

                return L.divIcon({
                    className: 'custom-map-marker',
                    html: `
                        <div class="pin-wrapper">
                            <div class="pin-pulse" style="background: ${pulseColor};"></div>
                            <div class="pin-icon">
                                <div class="pin-head" style="background: ${headBackground};">
                                    <div class="pin-center">${totalEntri}</div>
                                </div>
                                <div class="pin-pointer" style="border-top-color: ${pointerColor};"></div>
                                ${dotsHtml}
                            </div>
                        </div>
                    `,
                    iconSize: [36, 48],
                    iconAnchor: [18, 39],
                    popupAnchor: [0, -38]
                });
            }

            // Fungsi render marker peta & perbarui tabel
            function renderDashboard(isInitial = false) {
                markersLayer.clearLayers();
                for (let key in markersByKabId) delete markersByKabId[key];
                for (let key in kabDataById) delete kabDataById[key];
                if (!isDetailPinned) {
                    infoControl.renderDefault();
                }

                const selectedNyamuk = document.getElementById('filterJenisNyamuk')?.value || '';
                const selectedInsektisida = document.getElementById('filterInsektisida')?.value || '';
                const selectedMetode = document.getElementById('filterMetode')?.value || '';
                const selectedStatus = document.getElementById('filterStatus')?.value || '';
                const query = currentSearch.toLowerCase().trim();

                // Filter Regional dari Panel FILTER (Gambar 2)
                const currentLevel = document.querySelector('input[name="levelFilter"]:checked')?.value || 'nasional';
                const selectedProvId = document.getElementById('filterProvinsiSelect')?.value || '';
                const selectedKabId = document.getElementById('filterKabupatenSelect')?.value || '';
                const selectedTahun = document.getElementById('filterPeriodeTahun')?.value || '';
                const selectedIndikator = document.getElementById('filterIndikator')?.value || 'Peta Endemisitas & Resistensi';

                // Perbarui Keterangan Status Filter di Atas Peta (Gambar 2)
                const titleEl = document.getElementById('activeFilterTitle');
                const levelEl = document.getElementById('activeFilterLevel');
                const periodeEl = document.getElementById('activeFilterPeriode');
                if (titleEl) titleEl.textContent = selectedIndikator;
                if (periodeEl) periodeEl.textContent = selectedTahun ? `Periode Laporan: ${selectedTahun}` : 'Periode Laporan: Semua Periode';
                if (levelEl) {
                    if (currentLevel === 'nasional') {
                        levelEl.textContent = 'Level: NASIONAL (Seluruh Indonesia)';
                    } else if (currentLevel === 'provinsi') {
                        const provOpt = document.getElementById('filterProvinsiSelect');
                        const provName = provOpt && provOpt.selectedIndex >= 0 ? provOpt.options[provOpt.selectedIndex].text : '';
                        levelEl.textContent = provName && selectedProvId ? `Level: PROVINSI ${provName.toUpperCase()}` : 'Level: PROVINSI (Semua)';
                    } else if (currentLevel === 'kabupaten') {
                        const provOpt = document.getElementById('filterProvinsiSelect');
                        const kabOpt = document.getElementById('filterKabupatenSelect');
                        const provName = provOpt && provOpt.selectedIndex >= 0 ? provOpt.options[provOpt.selectedIndex].text : '';
                        const kabName = kabOpt && kabOpt.selectedIndex >= 0 ? kabOpt.options[kabOpt.selectedIndex].text : '';
                        if (selectedKabId && kabName) {
                            levelEl.textContent = `Level: ${provName.toUpperCase()} - ${kabName.toUpperCase()}`;
                        } else if (selectedProvId && provName) {
                            levelEl.textContent = `Level: ${provName.toUpperCase()} - SEMUA KABUPATEN`;
                        } else {
                            levelEl.textContent = 'Level: KABUPATEN';
                        }
                    }
                }

                // Filter Data
                const filteredData = rawData.filter(item => {
                    // Filter Parameter Toolbar
                    if (selectedNyamuk && item.jenis_nyamuk !== selectedNyamuk) return false;
                    if (selectedInsektisida && item.insektisida !== selectedInsektisida) return false;
                    if (selectedMetode && item.metode !== selectedMetode) return false;
                    if (selectedStatus) {
                        if (selectedStatus === 'Toleran' || selectedStatus === 'Toleran/Terduga Resisten') {
                            if (!['Toleran', 'Toleran/Terduga Resisten', 'Terduga Resisten'].includes(item.status)) return false;
                        } else if (item.status !== selectedStatus) {
                            return false;
                        }
                    }

                    // Filter Periode Tahun
                    if (selectedTahun && String(item.tahun) !== String(selectedTahun)) return false;

                    // Filter Level Wilayah
                    if (currentLevel === 'provinsi' && selectedProvId) {
                        if (String(item.provinsi_id) !== String(selectedProvId)) return false;
                    } else if (currentLevel === 'kabupaten') {
                        if (selectedKabId && String(item.kabupaten_id) !== String(selectedKabId)) return false;
                        if (!selectedKabId && selectedProvId && String(item.provinsi_id) !== String(selectedProvId)) return false;
                    }

                    // Pencarian Global Query
                    if (query) {
                        const prov = (item.provinsi?.nama_provinsi || '').toLowerCase();
                        const kab = (item.kabupaten?.nama_kabupaten || '').toLowerCase();
                        const alm = (item.alamat || '').toLowerCase();
                        const nyamuk = (item.jenis_nyamuk || '').toLowerCase();
                        const ins = (item.insektisida || '').toLowerCase();
                        const met = (item.metode || '').toLowerCase();
                        const bln = (item.bulan || '').toLowerCase();
                        const thn = String(item.tahun || '').toLowerCase();
                        const stt = (item.status || '').toLowerCase();

                        const isMatch = prov.includes(query) ||
                                        kab.includes(query) ||
                                        alm.includes(query) ||
                                        nyamuk.includes(query) ||
                                        ins.includes(query) ||
                                        met.includes(query) ||
                                        bln.includes(query) ||
                                        thn.includes(query) ||
                                        stt.includes(query);
                        if (!isMatch) return false;
                    }

                    return true;
                });

                // Kelompokkan data per kabupaten untuk Pin Marker Peta
                const groupedData = {};
                filteredData.forEach(item => {
                    const kabupaten = item.kabupaten;
                    if (!kabupaten) return;

                    let lat = kabupaten.latitude !== null ? Number(kabupaten.latitude) : null;
                    let lng = kabupaten.longitude !== null ? Number(kabupaten.longitude) : null;

                    if ((lat === null || lng === null || isNaN(lat) || isNaN(lng)) && kabupaten.nama_kabupaten) {
                        const norm = normalizeKabName(kabupaten.nama_kabupaten);
                        if (geoCentroidsByNorm[norm]) {
                            lat = geoCentroidsByNorm[norm].lat;
                            lng = geoCentroidsByNorm[norm].lng;
                            kabupaten.latitude = lat;
                            kabupaten.longitude = lng;
                        }
                    }

                    if (lat === null || lng === null || isNaN(lat) || isNaN(lng)) {
                        return;
                    }

                    const kabupatenId = kabupaten.id;
                    if (!groupedData[kabupatenId]) {
                        groupedData[kabupatenId] = {
                            kabupaten: kabupaten,
                            provinsi: item.provinsi,
                            data: []
                        };
                    }
                    groupedData[kabupatenId].data.push(item);
                });

                const groups = Object.values(groupedData);
                const markerCoords = [];


                // Render Pin Marker di Peta
                groups.forEach(group => {
                    const kabupaten = group.kabupaten;
                    const provinsi = group.provinsi;
                    const entries = group.data;
                    const totalEntri = entries.length;
                    const totalSampel = entries.reduce((tot, it) => tot + Number(it.sampel_diperiksa || 0), 0);

                    // Rekap status di kabupaten ini
                    let rCount = 0;
                    let tCount = 0;
                    let gCount = 0;

                    entries.forEach(it => {
                        if (it.status === 'Resisten') {
                            rCount++;
                        } else if (it.status === 'Rentan') {
                            gCount++;
                        } else if (it.status === 'Toleran/Terduga Resisten' || it.status === 'Toleran' || it.status === 'Terduga Resisten') {
                            tCount++;
                        }
                    });

                    const activeStatuses = [];
                    if (rCount > 0) activeStatuses.push({ status: 'Resisten', count: rCount, color: '#EF4444', badgeClass: 'bg-rose-50 border-rose-200 text-rose-700', dotClass: 'bg-rose-500', label: 'Resisten' });
                    if (tCount > 0) activeStatuses.push({ status: 'Toleran/Terduga Resisten', count: tCount, color: '#F59E0B', badgeClass: 'bg-amber-50 border-amber-200 text-amber-700', dotClass: 'bg-amber-500', label: 'Toleran/Terduga' });
                    if (gCount > 0) activeStatuses.push({ status: 'Rentan', count: gCount, color: '#10B981', badgeClass: 'bg-emerald-50 border-emerald-200 text-emerald-700', dotClass: 'bg-emerald-500', label: 'Rentan' });

                    const alamats = [
                        ...new Set(
                            entries.map(item => item.alamat ? item.alamat.trim() : '').filter(a => a !== '')
                        )
                    ];

                    // Simpan data kabupaten ke cache untuk akses instan infoControl
                    kabDataById[kabupaten.id] = {
                        kabupaten: kabupaten,
                        provinsi: provinsi,
                        entries: entries,
                        totalEntri: totalEntri,
                        totalSampel: totalSampel,
                        activeStatuses: activeStatuses,
                        alamats: alamats
                    };

                    const lat = Number(kabupaten.latitude);
                    const lng = Number(kabupaten.longitude);
                    markerCoords.push([lat, lng]);

                    const markerIcon = createCustomMarkerIcon(entries);
                    const marker = L.marker([lat, lng], { icon: markerIcon }).addTo(markersLayer);

                    // Label nama kabupaten di peta (seperti Gambar 3)
                    marker.bindTooltip(`KAB. ${escapeHtml(kabupaten.nama_kabupaten).toUpperCase()}`, {
                        direction: 'top',
                        offset: [0, -26],
                        className: 'region-map-label'
                    });

                    marker.on('click', function (e) {
                        L.DomEvent.stopPropagation(e);
                        if (activeTooltipLayer && activeTooltipLayer !== marker) {
                            try { activeTooltipLayer.closeTooltip(); } catch (err) {}
                        }
                        showKabupatenDetail(kabupaten.id, true);
                        marker.openTooltip();
                        activeTooltipLayer = marker;
                        map.flyTo([lat, lng], 10, { duration: 0.8 });
                    });

                    marker.on('mouseover', function () {
                        showKabupatenDetail(kabupaten.id, false);
                    });

                    marker.on('mouseout', function () {
                        if (!isDetailPinned) {
                            infoControl.renderDefault();
                        }
                    });

                    markersByKabId[kabupaten.id] = marker;
                });

                // Render Poligon Batas Wilayah Berwarna (Choropleth Peta)
                renderGeoJsonPolygons(filteredData);
                if (!showMarkers) {
                    markersLayer.clearLayers();
                }

                // Jika ada detail kabupaten yang sedang dipin, perbarui datanya
                if (isDetailPinned && pinnedKabId) {
                    if (kabDataById[pinnedKabId]) {
                        showKabupatenDetail(pinnedKabId, true);
                    } else {
                        window.unpinDetailCard();
                    }
                }

                // Zoom / Fit bounds peta ke koordinat aktif
                if (currentLevel === 'kabupaten' && selectedKabId && markersByKabId[selectedKabId]) {
                    map.flyTo(markersByKabId[selectedKabId].getLatLng(), 9, { duration: 1.2 });
                    setTimeout(() => {
                        showKabupatenDetail(selectedKabId, true);
                        if (markersByKabId[selectedKabId]) {
                            markersByKabId[selectedKabId].openTooltip();
                            activeTooltipLayer = markersByKabId[selectedKabId];
                        }
                    }, 1300);
                } else if (markerCoords.length > 0) {
                    if (markerCoords.length === 1) {
                        map.setView(markerCoords[0], 8);
                    } else {
                        map.fitBounds(markerCoords, { padding: [50, 50], maxZoom: 8 });
                    }
                } else if (!isInitial) {
                    map.setView([-2.5, 118], 5);
                }

                // Perbarui Tabel Data Pemeriksaan Terbaru
                currentFilteredData = filteredData;
                currentHasQuery = !!query;
                currentHasFilter = !!(selectedNyamuk || selectedInsektisida || selectedMetode);
                updateTableContent(currentFilteredData, currentHasQuery, currentHasFilter);
            }

            // Fungsi ganti jumlah baris yang tampil (Page Size)
            window.changeTablePageSize = function(val) {
                if (val === 'all') {
                    tablePageSize = 999999;
                } else {
                    tablePageSize = parseInt(val, 10) || 10;
                }
                tableCurrentPage = 1;

                // Sinkronkan dropdown di header tabel jika ada
                const topSelect = document.getElementById('tablePageSizeSelect');
                if (topSelect && topSelect.value !== String(val)) {
                    topSelect.value = val;
                }

                updateTableContent(currentFilteredData, currentHasQuery, currentHasFilter);
            };

            // Fungsi render baris tabel secara dinamis dengan Pagination & Tampil Data Dinamis
            function updateTableContent(dataItems, hasQuery, hasFilter) {
                const tbody = document.getElementById('tableDataBody');
                const title = document.getElementById('tableHeaderTitle');
                const subtitle = document.getElementById('tableHeaderSubtitle');
                const paginationEl = document.getElementById('dashboardTablePagination');

                const totalItems = dataItems.length;

                if (hasQuery || hasFilter) {
                    title.innerHTML = `Data Pemeriksaan Terbaru <span class="text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-200/80 px-2 py-0.5 rounded-md ml-1.5">${totalItems} ditemukan</span>`;
                } else {
                    title.textContent = 'Data Pemeriksaan Terbaru';
                }
                if (subtitle) {
                    subtitle.textContent = '';
                }

                if (!tbody) return;

                if (totalItems === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-sm text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <span class="text-3xl">🔍</span>
                                    <p class="font-semibold text-slate-600">Tidak ada data yang cocok dengan kriteria pencarian.</p>
                                    <p class="text-xs text-slate-400">Coba ubah kata kunci atau tekan tombol Reset.</p>
                                </div>
                            </td>
                        </tr>
                    `;
                    if (paginationEl) paginationEl.innerHTML = '';
                    return;
                }

                const totalPages = Math.ceil(totalItems / tablePageSize) || 1;
                if (tableCurrentPage > totalPages) tableCurrentPage = totalPages;
                if (tableCurrentPage < 1) tableCurrentPage = 1;

                const startIndex = (tableCurrentPage - 1) * tablePageSize;
                const endIndex = Math.min(startIndex + tablePageSize, totalItems);
                const displayItems = dataItems.slice(startIndex, endIndex);

                tbody.innerHTML = displayItems.map((item, index) => {
                    const rowNumber = startIndex + index + 1;
                    const prov = escapeHtml(item.provinsi ? item.provinsi.nama_provinsi : '-');
                    const kab = escapeHtml(item.kabupaten ? item.kabupaten.nama_kabupaten : '-');
                    const rawAlamat = item.alamat || '';
                    const alamat = rawAlamat
                        ? `<span class="inline-flex items-center gap-1 font-medium text-slate-700 max-w-full truncate" title="${escapeHtml(rawAlamat)}"><span class="text-blue-500 shrink-0">📍</span><span class="truncate">${escapeHtml(rawAlamat)}</span></span>`
                        : `<span class="italic text-slate-400">Belum diisi</span>`;
                    const sampel = Number(item.sampel_diperiksa || 0).toLocaleString();
                    const periode = escapeHtml(`${item.bulan || ''} ${item.tahun || ''}`);
                    const nyamuk = escapeHtml(item.jenis_nyamuk || '-');
                    const insek = escapeHtml(item.insektisida || '-');
                    const metode = escapeHtml(item.metode || '-');

                    let statusBadge = '<span class="text-xs text-slate-400 italic">-</span>';
                    if (item.status === 'Resisten') {
                        statusBadge = '<span class="inline-flex items-center gap-1 rounded-md bg-rose-50 border border-rose-200 px-1.5 py-0.5 text-[11px] font-bold text-rose-700"><span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Resisten</span>';
                    } else if (item.status === 'Toleran' || item.status === 'Toleran/Terduga Resisten' || item.status === 'Terduga Resisten') {
                        statusBadge = '<span class="inline-flex items-center gap-1 rounded-md bg-amber-50 border border-amber-200 px-1.5 py-0.5 text-[11px] font-bold text-amber-700"><span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Toleran</span>';
                    } else if (item.status === 'Rentan') {
                        statusBadge = '<span class="inline-flex items-center gap-1 rounded-md bg-emerald-50 border border-emerald-200 px-1.5 py-0.5 text-[11px] font-bold text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Rentan</span>';
                    }

                    const hasCoords = item.kabupaten && item.kabupaten.latitude && item.kabupaten.longitude;
                    const aksiBtn = `
                        <div class="inline-flex items-center justify-center gap-1">
                            <button type="button"
                                    onclick="showRowDetailModal(${item.id})"
                                    class="inline-flex items-center gap-0.5 rounded-md border border-slate-200 bg-white px-1.5 py-0.5 text-[11px] font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 hover:border-blue-300 transition shadow-2xs cursor-pointer"
                                    title="Tampilkan rincian data pemeriksaan ini">
                                <span>👁️</span>
                                <span>Detail</span>
                            </button>
                            ${hasCoords ? `
                                <button type="button"
                                        onclick="focusOnMap(${Number(item.kabupaten.latitude)}, ${Number(item.kabupaten.longitude)}, ${Number(item.kabupaten.id)})"
                                        class="inline-flex items-center gap-0.5 rounded-md border border-blue-200 bg-blue-50 px-1.5 py-0.5 text-[11px] font-semibold text-blue-700 hover:bg-blue-600 hover:text-white transition shadow-2xs cursor-pointer"
                                        title="Lihat titik lokasi ini di peta">
                                    <span>📍</span>
                                    <span>Peta</span>
                                </button>
                            ` : ''}
                        </div>
                    `;

                    return `
                        <tr class="hover:bg-blue-50/40 transition" id="row-data-${item.id}">
                            <td class="px-1.5 py-2 text-center font-bold text-slate-400 text-xs truncate">${rowNumber}</td>
                            <td class="px-2 py-2 text-xs truncate">
                                <div class="font-semibold text-slate-800 leading-tight truncate" title="${kab}">${kab}</div>
                                <div class="text-[11px] text-slate-500 font-normal leading-tight truncate" title="${prov}">${prov}</div>
                            </td>
                            <td class="px-2 py-2 text-xs text-slate-700 leading-snug truncate">${alamat}</td>
                            <td class="px-1.5 py-2 whitespace-nowrap truncate">
                                <span class="inline-block rounded-md bg-blue-50 border border-blue-100 px-1.5 py-0.5 text-[11px] font-semibold text-blue-700 truncate max-w-full">
                                    ${nyamuk}
                                </span>
                            </td>
                            <td class="px-2 py-2 text-xs truncate">
                                <div class="font-semibold text-slate-800 leading-tight truncate" title="${insek}">${insek}</div>
                                <div class="text-[11px] text-slate-500 font-normal leading-tight truncate" title="${metode}">${metode}</div>
                            </td>
                            <td class="px-1 py-2 text-center font-bold text-slate-800 text-xs whitespace-nowrap truncate">${sampel}</td>
                            <td class="px-1.5 py-2 text-center whitespace-nowrap">${statusBadge}</td>
                            <td class="px-1 py-2 text-center text-[11px] text-slate-500 whitespace-nowrap truncate">${periode}</td>
                            <td class="px-1.5 py-2 text-center whitespace-nowrap">${aksiBtn}</td>
                        </tr>
                    `;
                }).join('');

                // Render Pagination Bar
                if (paginationEl) {
                    if (tablePageSize >= 999999 || totalPages <= 1) {
                        paginationEl.innerHTML = `
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                                <div class="flex flex-wrap items-center gap-2 text-slate-500 font-medium text-xs">
                                    <span>Menampilkan seluruh <strong class="text-slate-800 font-bold">${totalItems}</strong> data</span>
                                </div>
                            </div>
                        `;
                        return;
                    }

                    let pagesHtml = '';
                    if (totalPages <= 7) {
                        for (let p = 1; p <= totalPages; p++) {
                            if (p === tableCurrentPage) {
                                pagesHtml += `<span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-blue-600 text-xs font-bold text-white shadow-2xs">${p}</span>`;
                            } else {
                                pagesHtml += `<button type="button" onclick="goToDashboardTablePage(${p})" class="inline-flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:border-blue-300 hover:text-blue-600 transition cursor-pointer">${p}</button>`;
                            }
                        }
                    } else {
                        const pagesToShow = new Set([1, totalPages, tableCurrentPage]);
                        if (tableCurrentPage > 1) pagesToShow.add(tableCurrentPage - 1);
                        if (tableCurrentPage < totalPages) pagesToShow.add(tableCurrentPage + 1);

                        const sortedPages = Array.from(pagesToShow).sort((a, b) => a - b);
                        let prevP = 0;
                        for (const p of sortedPages) {
                            if (prevP > 0 && p - prevP > 1) {
                                pagesHtml += `<span class="inline-flex h-7 w-7 items-center justify-center text-xs text-slate-400">...</span>`;
                            }
                            if (p === tableCurrentPage) {
                                pagesHtml += `<span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-blue-600 text-xs font-bold text-white shadow-2xs">${p}</span>`;
                            } else {
                                pagesHtml += `<button type="button" onclick="goToDashboardTablePage(${p})" class="inline-flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:border-blue-300 hover:text-blue-600 transition cursor-pointer">${p}</button>`;
                            }
                            prevP = p;
                        }
                    }

                    const prevButton = tableCurrentPage > 1
                        ? `<button type="button" onclick="goToDashboardTablePage(${tableCurrentPage - 1})" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-semibold text-slate-700 shadow-2xs hover:bg-slate-50 hover:border-blue-400 hover:text-blue-600 transition cursor-pointer">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                            <span>Sebelumnya</span>
                           </button>`
                        : `<span class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-400 cursor-not-allowed">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                            <span>Sebelumnya</span>
                           </span>`;

                    const nextButton = tableCurrentPage < totalPages
                        ? `<button type="button" onclick="goToDashboardTablePage(${tableCurrentPage + 1})" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-semibold text-slate-700 shadow-2xs hover:bg-slate-50 hover:border-blue-400 hover:text-blue-600 transition cursor-pointer">
                            <span>Selanjutnya</span>
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                           </button>`
                        : `<span class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-400 cursor-not-allowed">
                            <span>Selanjutnya</span>
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                           </span>`;

                    paginationEl.innerHTML = `
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                            <div class="flex flex-wrap items-center gap-2 text-slate-500 font-medium text-xs">
                                <span>Menampilkan data <strong class="text-slate-800 font-bold">${startIndex + 1}</strong> - <strong class="text-slate-800 font-bold">${endIndex}</strong> dari total <strong class="text-slate-900 font-extrabold">${totalItems}</strong> data</span>
                            </div>
                            <div class="inline-flex items-center gap-1">
                                ${prevButton}
                                <div class="inline-flex items-center gap-1 mx-1">
                                    ${pagesHtml}
                                </div>
                                ${nextButton}
                            </div>
                        </div>
                    `;
                }
            }

            // Fungsi navigasi halaman tabel dashboard
            window.goToDashboardTablePage = function(page) {
                tableCurrentPage = page;
                updateTableContent(currentFilteredData, currentHasQuery, currentHasFilter);
                const tableEl = document.getElementById('tableHeaderTitle');
                if (tableEl) {
                    tableEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            };

            // Fungsi Pencarian Dashboard (Tersinkronisasi Header Atas & Tabel Pemeriksaan)
            window.handleSearch = function(value) {
                currentSearch = value;
                tableCurrentPage = 1;
                const headerSearch = document.getElementById('headerSearch');
                const headerClearBtn = document.getElementById('headerClearBtn');
                const tableSearchInput = document.getElementById('tableSearchInput');
                const tableSearchClearBtn = document.getElementById('tableSearchClearBtn');

                if (headerSearch && headerSearch.value !== value) {
                    headerSearch.value = value;
                }
                if (tableSearchInput && tableSearchInput.value !== value) {
                    tableSearchInput.value = value;
                }

                if (value.trim() !== '') {
                    if (headerClearBtn) headerClearBtn.classList.remove('hidden');
                    if (tableSearchClearBtn) tableSearchClearBtn.classList.remove('hidden');
                } else {
                    if (headerClearBtn) headerClearBtn.classList.add('hidden');
                    if (tableSearchClearBtn) tableSearchClearBtn.classList.add('hidden');
                }

                renderDashboard(false);
            };

            // Hapus kata kunci pencarian
            window.clearSearch = function() {
                window.handleSearch('');
            };

            // Terapkan Filter Dropdown Toolbar Tabel
            window.applyFilters = function() {
                tableCurrentPage = 1;
                renderDashboard(false);
            };

            // Toggle Panel Filter (Buka/Tutup)
            window.toggleFilterPanel = function() {
                const body = document.getElementById('filterPanelBody');
                const icon = document.getElementById('filterCollapseIcon');
                if (!body) return;
                if (body.classList.contains('hidden')) {
                    body.classList.remove('hidden');
                    if (icon) icon.style.transform = 'rotate(0deg)';
                } else {
                    body.classList.add('hidden');
                    if (icon) icon.style.transform = 'rotate(180deg)';
                }
            };

            // Tangani perubahan Level (Nasional, Provinsi, Kabupaten)
            window.handleLevelChange = function(level) {
                const provSelect = document.getElementById('filterProvinsiSelect');
                const kabSelect = document.getElementById('filterKabupatenSelect');
                if (!provSelect || !kabSelect) return;

                if (level === 'nasional') {
                    provSelect.disabled = true;
                    provSelect.value = '';
                    provSelect.classList.add('bg-slate-100', 'cursor-not-allowed', 'opacity-60');
                    provSelect.classList.remove('bg-white', 'cursor-pointer');

                    kabSelect.disabled = true;
                    kabSelect.value = '';
                    kabSelect.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
                    kabSelect.classList.add('bg-slate-100', 'cursor-not-allowed', 'opacity-60');
                    kabSelect.classList.remove('bg-white', 'cursor-pointer');
                } else if (level === 'provinsi') {
                    provSelect.disabled = false;
                    provSelect.classList.remove('bg-slate-100', 'cursor-not-allowed', 'opacity-60');
                    provSelect.classList.add('bg-white', 'cursor-pointer');

                    kabSelect.disabled = true;
                    kabSelect.value = '';
                    kabSelect.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
                    kabSelect.classList.add('bg-slate-100', 'cursor-not-allowed', 'opacity-60');
                    kabSelect.classList.remove('bg-white', 'cursor-pointer');
                } else if (level === 'kabupaten') {
                    provSelect.disabled = false;
                    provSelect.classList.remove('bg-slate-100', 'cursor-not-allowed', 'opacity-60');
                    provSelect.classList.add('bg-white', 'cursor-pointer');

                    if (provSelect.value) {
                        kabSelect.disabled = false;
                        kabSelect.classList.remove('bg-slate-100', 'cursor-not-allowed', 'opacity-60');
                        kabSelect.classList.add('bg-white', 'cursor-pointer');
                    } else {
                        kabSelect.disabled = true;
                        kabSelect.classList.add('bg-slate-100', 'cursor-not-allowed', 'opacity-60');
                        kabSelect.classList.remove('bg-white', 'cursor-pointer');
                    }
                }
            };

            // Cache data koordinat kabupaten hasil fetch
            const kabupatenCoordsCache = {};

            // Muat dinamis daftar Kabupaten saat Provinsi dipilih
            window.handleProvinsiFilterChange = function(provId) {
                const kabSelect = document.getElementById('filterKabupatenSelect');
                const currentLevel = document.querySelector('input[name="levelFilter"]:checked')?.value || 'nasional';
                if (!kabSelect) return;

                if (!provId) {
                    kabSelect.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
                    kabSelect.disabled = true;
                    kabSelect.classList.add('bg-slate-100', 'cursor-not-allowed', 'opacity-60');
                    kabSelect.classList.remove('bg-white', 'cursor-pointer');
                    return;
                }

                kabSelect.innerHTML = '<option value="">Memuat data kabupaten...</option>';
                kabSelect.disabled = true;

                fetch(`/kabupaten/${provId}`)
                    .then(res => res.json())
                    .then(data => {
                        kabSelect.innerHTML = '<option value="">-- Semua / Pilih Kabupaten --</option>';
                        data.forEach(kab => {
                            if (kab.latitude && kab.longitude) {
                                kabupatenCoordsCache[kab.id] = [Number(kab.latitude), Number(kab.longitude)];
                            }
                            const opt = document.createElement('option');
                            opt.value = kab.id;
                            opt.textContent = kab.nama_kabupaten;
                            kabSelect.appendChild(opt);
                        });

                        if (currentLevel === 'kabupaten') {
                            kabSelect.disabled = false;
                            kabSelect.classList.remove('bg-slate-100', 'cursor-not-allowed', 'opacity-60');
                            kabSelect.classList.add('bg-white', 'cursor-pointer');
                        } else {
                            kabSelect.disabled = true;
                            kabSelect.classList.add('bg-slate-100', 'cursor-not-allowed', 'opacity-60');
                            kabSelect.classList.remove('bg-white', 'cursor-pointer');
                        }
                    })
                    .catch(err => {
                        console.error('Gagal mengambil data kabupaten:', err);
                        kabSelect.innerHTML = '<option value="">Gagal memuat kabupaten</option>';
                    });
            };

            // Terapkan Filter Regional (Gambar 2: Indikator, Periode, Level)
            window.applyRegionalFilter = function() {
                tableCurrentPage = 1;
                renderDashboard(false);

                const currentLevel = document.querySelector('input[name="levelFilter"]:checked')?.value || 'nasional';
                const selectedProvId = document.getElementById('filterProvinsiSelect')?.value;
                const selectedKabId = document.getElementById('filterKabupatenSelect')?.value;

                if (currentLevel === 'kabupaten' && selectedKabId && markersByKabId[selectedKabId]) {
                    map.flyTo(markersByKabId[selectedKabId].getLatLng(), 9, { duration: 1.2 });
                    setTimeout(() => {
                        showKabupatenDetail(selectedKabId, true);
                        if (markersByKabId[selectedKabId]) {
                            markersByKabId[selectedKabId].openTooltip();
                            activeTooltipLayer = markersByKabId[selectedKabId];
                        }
                    }, 1300);
                } else if (currentLevel === 'kabupaten' && selectedKabId && kabupatenCoordsCache[selectedKabId]) {
                    map.flyTo(kabupatenCoordsCache[selectedKabId], 9, { duration: 1.2 });
                } else if (currentLevel === 'kabupaten' && selectedKabId) {
                    const matchedItem = rawData.find(d => String(d.kabupaten_id) === String(selectedKabId));
                    if (matchedItem && matchedItem.kabupaten && matchedItem.kabupaten.latitude && matchedItem.kabupaten.longitude) {
                        map.flyTo([Number(matchedItem.kabupaten.latitude), Number(matchedItem.kabupaten.longitude)], 9, { duration: 1.2 });
                    }
                } else if ((currentLevel === 'provinsi' || currentLevel === 'kabupaten') && selectedProvId) {
                    const provItems = rawData.filter(d => String(d.provinsi_id) === String(selectedProvId) && d.kabupaten && d.kabupaten.latitude);
                    if (provItems.length > 0) {
                        const coords = provItems.map(d => [Number(d.kabupaten.latitude), Number(d.kabupaten.longitude)]);
                        if (coords.length === 1) {
                            map.flyTo(coords[0], 8, { duration: 1.2 });
                        } else {
                            map.flyToBounds(coords, { padding: [50, 50], maxZoom: 8, duration: 1.2 });
                        }
                    }
                } else if (currentLevel === 'nasional') {
                    map.flyTo([-2.5, 118], 5, { duration: 1.2 });
                }
            };

            // Reset Semua Filter & Pencarian
            window.resetAllFilters = function() {
                tableCurrentPage = 1;
                window.unpinDetailCard();

                // Reset filter toolbar atas tabel
                if (document.getElementById('filterJenisNyamuk')) document.getElementById('filterJenisNyamuk').value = '';
                if (document.getElementById('filterInsektisida')) document.getElementById('filterInsektisida').value = '';
                if (document.getElementById('filterMetode')) document.getElementById('filterMetode').value = '';
                if (document.getElementById('filterStatus')) document.getElementById('filterStatus').value = '';

                // Reset panel Filter (Gambar 2)
                const radioNasional = document.querySelector('input[name="levelFilter"][value="nasional"]');
                if (radioNasional) radioNasional.checked = true;
                handleLevelChange('nasional');

                const indSelect = document.getElementById('filterIndikator');
                if (indSelect) indSelect.value = 'Peta Endemisitas & Resistensi';

                const thnSelect = document.getElementById('filterPeriodeTahun');
                if (thnSelect) thnSelect.value = '';

                window.handleSearch('');
                if (desaMarkerLayer) {
                    desaMarkerLayer.clearLayers();
                }
                renderDashboard(false);
                window.resetMapView();
            };

            // Fungsi Reset Posisi & Tampilan Peta ke Awal (Seluruh Indonesia)
            window.resetMapView = function() {
                if (map) {
                    map.flyTo([-2.5, 118], 5, { duration: 1.0 });
                }
                if (window.unpinDetailCard) {
                    window.unpinDetailCard();
                }
                if (activeTooltipLayer) {
                    try { activeTooltipLayer.closeTooltip(); } catch (e) {}
                    activeTooltipLayer = null;
                }
                if (desaMarkerLayer) {
                    desaMarkerLayer.clearLayers();
                }
            };

            // Fungsi Menyorot Titik Lokasi Desa / Alamat Tertentu di Peta
            window.focusOnDesaAlamat = async function(desaName, kabId, event) {
                if (event) {
                    event.stopPropagation();
                }

                // Scroll halus ke peta jika posisi layar berada di luar area peta
                const mapEl = document.getElementById('map');
                if (mapEl) {
                    const rect = mapEl.getBoundingClientRect();
                    if (rect.top < 0 || rect.bottom > window.innerHeight) {
                        mapEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }

                // Ambil info kabupaten & provinsi
                const kabData = kabDataById[kabId];
                const matchedItem = rawData.find(d => String(d.kabupaten_id) === String(kabId));
                const kabObj = (kabData && kabData.kabupaten) ? kabData.kabupaten : (matchedItem ? matchedItem.kabupaten : null);
                const provObj = (kabData && kabData.provinsi) ? kabData.provinsi : (matchedItem ? matchedItem.provinsi : null);

                const kabName = kabObj ? kabObj.nama_kabupaten : '';
                const provName = provObj ? provObj.nama_provinsi : '';

                // Filter entri uji khusus di desa/alamat ini
                const desaEntries = rawData.filter(d => 
                    String(d.kabupaten_id) === String(kabId) && 
                    d.alamat && d.alamat.trim().toLowerCase() === String(desaName).trim().toLowerCase()
                );

                const cacheKey = `${desaName.trim().toLowerCase()}_${String(kabId)}`;
                let targetLat = null;
                let targetLng = null;

                const btn = event ? event.currentTarget : null;
                if (btn) btn.classList.add('opacity-60');

                if (desaCoordsCache[cacheKey]) {
                    targetLat = desaCoordsCache[cacheKey][0];
                    targetLng = desaCoordsCache[cacheKey][1];
                } else {
                    // Coba cari koordinat akurat desa via OpenStreetMap Nominatim
                    try {
                        const cleanDesa = desaName.replace(/^(desa|kelurahan|dusun|kampung|adm\.|kota|kab\.)\s+/gi, '').trim();
                        const query = `${cleanDesa} ${kabName} Indonesia`;
                        const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`, {
                            headers: { 'Accept': 'application/json' }
                        }).then(r => r.json());

                        if (Array.isArray(res) && res.length > 0 && res[0].lat && res[0].lon) {
                            targetLat = parseFloat(res[0].lat);
                            targetLng = parseFloat(res[0].lon);
                            desaCoordsCache[cacheKey] = [targetLat, targetLng];
                        }
                    } catch (err) {
                        console.warn('Geocoding desa offline/gagal, menggunakan koordinat wilayah kabupaten:', err);
                    }

                    // Fallback jika tidak ditemukan di Nominatim: gunakan koordinat kabupaten dengan offset halus
                    if (targetLat === null || targetLng === null) {
                        if (kabObj && kabObj.latitude && kabObj.longitude) {
                            let hash = 0;
                            for (let i = 0; i < desaName.length; i++) hash = (hash << 5) - hash + desaName.charCodeAt(i);
                            const offsetLat = ((hash % 100) / 10000) * 1.5;
                            const offsetLng = (((hash >> 3) % 100) / 10000) * 1.5;
                            targetLat = parseFloat(kabObj.latitude) + offsetLat;
                            targetLng = parseFloat(kabObj.longitude) + offsetLng;
                            desaCoordsCache[cacheKey] = [targetLat, targetLng];
                        }
                    }
                }

                if (btn) btn.classList.remove('opacity-60');

                if (targetLat === null || targetLng === null) {
                    alert('Koordinat wilayah tidak tersedia untuk lokasi ini.');
                    return;
                }

                // 1. Bersihkan marker desa sebelumnya
                desaMarkerLayer.clearLayers();

                // 2. Buat Pin Marker Desa Interaktif yang Elegan
                const desaIcon = L.divIcon({
                    className: 'custom-desa-marker-container',
                    html: `
                        <div class="desa-pin-marker">
                            <div class="desa-pin-icon">
                                <span>📍</span>
                            </div>
                            <div class="desa-pin-pulse"></div>
                            <div class="desa-pin-label">📍 ${escapeHtml(desaName)}</div>
                        </div>
                    `,
                    iconSize: [140, 65],
                    iconAnchor: [70, 36],
                    popupAnchor: [0, -38]
                });

                const desaMarker = L.marker([targetLat, targetLng], { icon: desaIcon }).addTo(desaMarkerLayer);

                // 3. Susun Popup Detail untuk Titik Desa
                let statusCountMap = { Resisten: 0, Toleran: 0, Rentan: 0 };
                let totalSampelDesa = 0;
                const nyamukSet = new Set();
                const insekSet = new Set();

                desaEntries.forEach(e => {
                    if (e.status === 'Resisten') statusCountMap.Resisten++;
                    else if (e.status === 'Rentan') statusCountMap.Rentan++;
                    else statusCountMap.Toleran++;

                    totalSampelDesa += Number(e.sampel_diperiksa) || 0;
                    if (e.jenis_nyamuk) nyamukSet.add(e.jenis_nyamuk);
                    if (e.insektisida) insekSet.add(e.insektisida);
                });

                const badgesHtml = [];
                if (statusCountMap.Resisten > 0) badgesHtml.push(`<span class="inline-flex items-center gap-1 rounded bg-rose-50 px-2 py-0.5 text-[10px] font-bold text-rose-700 border border-rose-200">🔴 Resisten: ${statusCountMap.Resisten}</span>`);
                if (statusCountMap.Toleran > 0) badgesHtml.push(`<span class="inline-flex items-center gap-1 rounded bg-amber-50 px-2 py-0.5 text-[10px] font-bold text-amber-700 border border-amber-200">🟡 Toleran: ${statusCountMap.Toleran}</span>`);
                if (statusCountMap.Rentan > 0) badgesHtml.push(`<span class="inline-flex items-center gap-1 rounded bg-emerald-50 px-2 py-0.5 text-[10px] font-bold text-emerald-700 border border-emerald-200">🟢 Rentan: ${statusCountMap.Rentan}</span>`);

                const firstEntryId = desaEntries.length > 0 ? desaEntries[0].id : null;

                const popupHtml = `
                    <div class="p-2 space-y-2 text-xs" style="min-width: 220px; max-width: 270px; font-family: inherit;">
                        <div class="border-b border-slate-200 pb-1.5">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-blue-600">📍 Titik Lokasi / Desa</div>
                            <div class="font-extrabold text-slate-800 text-sm leading-tight">${escapeHtml(desaName)}</div>
                            <div class="text-[10.5px] text-slate-500 font-medium">Kab. ${escapeHtml(kabName)}, ${escapeHtml(provName)}</div>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Status Resistensi:</div>
                            <div class="flex flex-wrap gap-1">
                                ${badgesHtml.join('') || '<span class="text-slate-400 italic">Belum ada data status</span>'}
                            </div>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-2 border border-slate-100 text-[11px] space-y-1">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Jumlah Uji:</span>
                                <span class="font-bold text-slate-800">${desaEntries.length} pemeriksaan</span>
                            </div>
                            ${totalSampelDesa > 0 ? `
                            <div class="flex justify-between">
                                <span class="text-slate-500">Total Sampel:</span>
                                <span class="font-bold text-slate-800">${totalSampelDesa.toLocaleString('id-ID')} ekor</span>
                            </div>` : ''}
                            ${nyamukSet.size > 0 ? `
                            <div class="flex justify-between items-start pt-0.5 border-t border-slate-200/60">
                                <span class="text-slate-500">Nyamuk:</span>
                                <span class="font-semibold text-slate-700 text-right italic">${escapeHtml(Array.from(nyamukSet).join(', '))}</span>
                            </div>` : ''}
                            ${insekSet.size > 0 ? `
                            <div class="flex justify-between items-start">
                                <span class="text-slate-500">Insektisida:</span>
                                <span class="font-semibold text-slate-700 text-right">${escapeHtml(Array.from(insekSet).join(', '))}</span>
                            </div>` : ''}
                        </div>
                        <div class="pt-1 flex flex-col gap-1.5">
                            <button type="button" onclick="focusOnDesaInTable('${escapeHtml(desaName).replace(/'/g, "\\'")}', '${kabId}', true)" class="w-full text-center py-2 px-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white rounded-lg font-bold text-xs shadow-md transition cursor-pointer flex items-center justify-center gap-1.5">
                                <span>📋</span>
                                <span>Lihat di Tabel Pemeriksaan</span>
                                <span>↓</span>
                            </button>
                            ${firstEntryId ? `
                            <button type="button" onclick="showRowDetailModal(${firstEntryId})" class="w-full text-center py-1.5 px-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-semibold text-[11px] border border-slate-200 transition cursor-pointer flex items-center justify-center gap-1">
                                <span>👁️</span>
                                <span>Buka Rincian Lengkap Uji</span>
                            </button>
                            ` : ''}
                        </div>
                    </div>
                `;

                desaMarker.bindPopup(popupHtml, {
                    maxWidth: 280,
                    className: 'custom-desa-popup'
                });

                // 4. Terbang dan zoom ke titik desa dengan durasi halus
                map.flyTo([targetLat, targetLng], 13, { duration: 1.4 });

                // Buka popup desa otomatis saat kamera tiba di lokasi
                setTimeout(() => {
                    desaMarker.openPopup();
                }, 1450);

                // 5. Otomatis saring tabel pemeriksaan di bawah tanpa scroll dulu
                focusOnDesaInTable(desaName, kabId, false);
            };

            // Fungsi Sinkronisasi Filter Tabel Pemeriksaan ke Desa yang Dipilih
            window.focusOnDesaInTable = function(desaName, kabId, shouldScroll = false) {
                const searchNorm = String(desaName || '').trim().toLowerCase();
                let desaEntries = rawData.filter(d => {
                    const matchAlamat = d.alamat && d.alamat.trim().toLowerCase() === searchNorm;
                    const matchKab = !kabId || String(d.kabupaten_id) === String(kabId) || (d.kabupaten && String(d.kabupaten.id) === String(kabId));
                    return matchAlamat && matchKab;
                });

                // Fallback jika exact match tidak menemukan
                if (desaEntries.length === 0) {
                    desaEntries = rawData.filter(d => {
                        const alamatClean = String(d.alamat || '').trim().toLowerCase();
                        return alamatClean && (alamatClean.includes(searchNorm) || searchNorm.includes(alamatClean));
                    });
                }

                if (desaEntries.length > 0) {
                    currentFilteredData = desaEntries;
                    currentHasQuery = true;
                    currentHasFilter = true;
                    tableCurrentPage = 1;
                    updateTableContent(currentFilteredData, true, true);

                    const title = document.getElementById('tableHeaderTitle');
                    const subtitle = document.getElementById('tableHeaderSubtitle');
                    if (title) title.innerHTML = `Data Pemeriksaan: <span class="text-blue-600 font-extrabold">${escapeHtml(desaName)}</span> <span class="text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-200/80 px-2 py-0.5 rounded-md ml-1.5">${desaEntries.length} data</span> <button type="button" onclick="resetAllFilters()" class="text-xs font-bold text-rose-600 hover:underline ml-2 cursor-pointer">✕ Reset</button>`;
                    if (subtitle) subtitle.innerHTML = '';
                }

                // Jika shouldScroll true (diklik dari tombol "Lihat di Tabel Pemeriksaan")
                if (shouldScroll) {
                    const tableEl = document.getElementById('tablePemeriksaanSection');
                    if (tableEl) {
                        tableEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        setTimeout(() => {
                            desaEntries.forEach(item => {
                                const rowEl = document.getElementById(`row-data-${item.id}`);
                                if (rowEl) {
                                    rowEl.classList.add('bg-blue-100', 'ring-2', 'ring-blue-400');
                                    setTimeout(() => {
                                        rowEl.classList.remove('bg-blue-100', 'ring-2', 'ring-blue-400');
                                    }, 2800);
                                }
                            });
                        }, 500);
                    }
                }
            };

            // Fungsi Klik dari Tabel untuk Fokus ke Titik Lokasi di Peta
            window.focusOnMap = function(lat, lng, kabId) {
                // Scroll halus ke elemen peta jika layar berada di bawah
                const mapEl = document.getElementById('map');
                if (mapEl) {
                    mapEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }

                setTimeout(() => {
                    map.flyTo([lat, lng], 10, { duration: 1.2 });
                    setTimeout(() => {
                        showKabupatenDetail(kabId, true);
                        if (markersByKabId[kabId]) {
                            markersByKabId[kabId].openTooltip();
                            activeTooltipLayer = markersByKabId[kabId];
                        }
                    }, 1250);
                }, 300);
            };

            // Fungsi Toggle Layer Peta (Wilayah Poligon Berwarna vs Pin Marker)
            window.toggleMapLayer = function(layerType) {
                if (layerType === 'polygons') {
                    showPolygons = !showPolygons;
                    const btn = document.getElementById('btnTogglePolygons');
                    if (btn) {
                        if (showPolygons) {
                            btn.className = 'rounded-md px-2.5 py-1 text-[11px] font-bold transition bg-white text-teal-700 shadow-2xs flex items-center gap-1.5 cursor-pointer';
                        } else {
                            btn.className = 'rounded-md px-2.5 py-1 text-[11px] font-bold transition text-slate-500 hover:text-slate-800 bg-transparent flex items-center gap-1.5 cursor-pointer';
                        }
                    }
                    if (showPolygons) {
                        renderGeoJsonPolygons(currentFilteredData.length > 0 ? currentFilteredData : rawData);
                    } else {
                        polygonsLayer.clearLayers();
                    }
                } else if (layerType === 'markers') {
                    showMarkers = !showMarkers;
                    const btn = document.getElementById('btnToggleMarkers');
                    if (btn) {
                        if (showMarkers) {
                            btn.className = 'rounded-md px-2.5 py-1 text-[11px] font-bold transition bg-white text-blue-700 shadow-2xs flex items-center gap-1.5 cursor-pointer';
                        } else {
                            btn.className = 'rounded-md px-2.5 py-1 text-[11px] font-bold transition text-slate-500 hover:text-slate-800 bg-transparent flex items-center gap-1.5 cursor-pointer';
                        }
                    }
                    if (showMarkers) {
                        if (!map.hasLayer(markersLayer)) map.addLayer(markersLayer);
                        renderDashboard(false);
                    } else {
                        markersLayer.clearLayers();
                    }
                }
            };

            // Fungsi Menampilkan Modal Detail Data Baris Tabel
            window.showRowDetailModal = function (itemId) {
                const item = rawData.find(x => Number(x.id) === Number(itemId));
                if (!item) return;

                const modal = document.getElementById('rowDetailModal');
                const card = document.getElementById('rowDetailModalCard');
                const body = document.getElementById('modalDetailBody');
                const actions = document.getElementById('modalDetailActions');
                if (!modal || !card || !body) return;

                const prov = escapeHtml(item.provinsi?.nama_provinsi || '-');
                const kab = escapeHtml(item.kabupaten?.nama_kabupaten || '-');
                const alamat = escapeHtml(item.alamat || 'Tidak dicantumkan');
                const nyamuk = escapeHtml(item.jenis_nyamuk || '-');
                const insek = escapeHtml(item.insektisida || '-');
                const metode = escapeHtml(item.metode || '-');
                const sampel = Number(item.sampel_diperiksa || 0).toLocaleString();
                const bulan = escapeHtml(item.bulan || '-');
                const tahun = escapeHtml(item.tahun || '-');
                const mutasi = escapeHtml(item.mutasi || '-');
                const publikasi = escapeHtml(item.publikasi || '-');

                let statusHtml = '';
                if (item.status === 'Resisten') {
                    statusHtml = '<span class="inline-flex items-center gap-1.5 rounded-lg bg-rose-50 border border-rose-200 px-3 py-1 text-xs font-bold text-rose-700"><span class="h-2 w-2 rounded-full bg-rose-500"></span> Resisten</span>';
                } else if (item.status === 'Toleran' || item.status === 'Toleran/Terduga Resisten' || item.status === 'Terduga Resisten') {
                    statusHtml = '<span class="inline-flex items-center gap-1.5 rounded-lg bg-amber-50 border border-amber-200 px-3 py-1 text-xs font-bold text-amber-700"><span class="h-2 w-2 rounded-full bg-amber-500"></span> Toleran</span>';
                } else if (item.status === 'Rentan') {
                    statusHtml = '<span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 border border-emerald-200 px-3 py-1 text-xs font-bold text-emerald-700"><span class="h-2 w-2 rounded-full bg-emerald-500"></span> Rentan</span>';
                } else {
                    statusHtml = '<span class="text-xs text-slate-400 italic">-</span>';
                }

                body.innerHTML = `
                    <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-3.5 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">STATUS HASIL UJI</span>
                            <div class="mt-1">${statusHtml}</div>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">JUMLAH SAMPEL</span>
                            <div class="mt-1 text-base font-extrabold text-slate-800">${sampel} <span class="text-xs font-medium text-slate-500">ekor spesimen</span></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="rounded-lg border border-slate-100 p-2.5 bg-white shadow-2xs">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">PROVINSI</span>
                            <p class="font-bold text-slate-800 mt-0.5">${prov}</p>
                        </div>
                        <div class="rounded-lg border border-slate-100 p-2.5 bg-white shadow-2xs">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">KABUPATEN / KOTA</span>
                            <p class="font-bold text-slate-800 mt-0.5">${kab}</p>
                        </div>
                    </div>

                    <div class="rounded-lg border border-slate-100 p-2.5 bg-white shadow-2xs text-xs">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">ALAMAT / LOKASI UJI</span>
                        <p class="font-medium text-slate-700 mt-0.5 flex items-start gap-1">
                            <span class="text-blue-500 shrink-0">📍</span>
                            <span>${alamat}</span>
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="rounded-lg border border-slate-100 p-2.5 bg-white shadow-2xs">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">SPESIES NYAMUK</span>
                            <p class="font-bold text-blue-700 mt-0.5">${nyamuk}</p>
                        </div>
                        <div class="rounded-lg border border-slate-100 p-2.5 bg-white shadow-2xs">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">INSEKTISIDA</span>
                            <p class="font-bold text-slate-800 mt-0.5">${insek}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="rounded-lg border border-slate-100 p-2.5 bg-white shadow-2xs">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">METODE PEMERIKSAAN</span>
                            <p class="font-semibold text-slate-700 mt-0.5">${metode}</p>
                        </div>
                        <div class="rounded-lg border border-slate-100 p-2.5 bg-white shadow-2xs">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">PERIODE UJI</span>
                            <p class="font-semibold text-slate-700 mt-0.5">${bulan} ${tahun}</p>
                        </div>
                    </div>

                    ${(mutasi && mutasi !== '-') || (publikasi && publikasi !== '-') ? `
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div class="rounded-lg border border-slate-100 p-2.5 bg-white shadow-2xs">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">MUTASI GENETIK</span>
                                <p class="font-medium text-slate-700 mt-0.5">${mutasi || '-'}</p>
                            </div>
                            <div class="rounded-lg border border-slate-100 p-2.5 bg-white shadow-2xs">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">PUBLIKASI / JURNAL</span>
                                <p class="font-medium text-slate-700 mt-0.5">${publikasi || '-'}</p>
                            </div>
                        </div>
                    ` : ''}
                `;

                if (actions) {
                    if (item.kabupaten && item.kabupaten.latitude && item.kabupaten.longitude) {
                        actions.innerHTML = `
                            <button type="button"
                                    onclick="closeRowDetailModal(); focusOnMap(${Number(item.kabupaten.latitude)}, ${Number(item.kabupaten.longitude)}, ${Number(item.kabupaten.id)});"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 px-3.5 py-2 text-xs font-semibold text-white shadow-2xs transition cursor-pointer">
                                <span>📍</span>
                                <span>Sorot di Peta</span>
                            </button>
                        `;
                    } else {
                        actions.innerHTML = '';
                    }
                }

                modal.classList.remove('hidden');
                setTimeout(() => {
                    card.classList.remove('scale-95', 'opacity-0');
                    card.classList.add('scale-100', 'opacity-100');
                }, 10);
            };

            window.closeRowDetailModal = function () {
                const modal = document.getElementById('rowDetailModal');
                const card = document.getElementById('rowDetailModalCard');
                if (!modal || !card) return;

                card.classList.remove('scale-100', 'opacity-100');
                card.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 150);
            };

            // Tutup modal jika tombol Escape ditekan
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    window.closeRowDetailModal();
                }
            });

            // Jalankan inisialisasi awal
            renderDashboard(true);
            setTimeout(() => {
                map.invalidateSize();
            }, 250);

        });
    </script>

    {{-- MODAL DETAIL DATA PEMERIKSAAN UJI RESISTENSI --}}
    <div id="rowDetailModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs transition-opacity duration-200 flex items-center justify-center p-4" onclick="if(event.target === this) closeRowDetailModal();">
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-2xl border border-slate-100 overflow-hidden transform transition-all duration-200 scale-95 opacity-0" id="rowDetailModalCard">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3.5 bg-gradient-to-r from-slate-50 to-white">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-600 font-bold text-sm">
                        🔬
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800" id="modalDetailTitle">
                            Detail Pemeriksaan Uji Resistensi
                        </h4>
                        <p class="text-[11px] text-slate-500" id="modalDetailSubtitle">
                            Informasi lengkap spesimen dan hasil uji laboratorium
                        </p>
                    </div>
                </div>
                <button type="button" onclick="closeRowDetailModal()" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition cursor-pointer" title="Tutup">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-5 space-y-4 max-h-[75vh] overflow-y-auto" id="modalDetailBody">
                {{-- Diisi secara dinamis oleh JavaScript --}}
            </div>

            {{-- Modal Footer --}}
            <div class="flex items-center justify-between border-t border-slate-100 bg-slate-50/70 px-5 py-3" id="modalDetailFooter">
                <button type="button" onclick="closeRowDetailModal()" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition shadow-2xs cursor-pointer">
                    Tutup
                </button>
                <div id="modalDetailActions" class="inline-flex items-center gap-2"></div>
            </div>
        </div>
    </div>

</body>

</html>