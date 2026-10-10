{{-- SCRIPT INISIALISASI TEMA ANTI-FLICKER (ANTI-FOUC) & STYLES GLOBAL DARK MODE --}}
<script>
    (function() {
        try {
            const savedTheme = localStorage.getItem('simpel_theme');
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        } catch (e) {
            console.error('Error reading theme preference:', e);
        }
    })();
</script>

<style id="simpel-global-dark-mode">
    /* ======================================================== */
    /* SIMPEL BBLKL - GLOBAL DARK MODE STYLESHEET               */
    /* ======================================================== */

    /* 1. Latar Belakang & Halaman Utama */
    html.dark,
    html.dark body {
        background-color: #0a0f1d !important;
        color: #f1f5f9 !important;
    }

    html.dark main {
        background-color: #0a0f1d !important;
        color: #f1f5f9 !important;
    }

    /* 2. Topbar / Sticky Header */
    html.dark header.sticky,
    html.dark header {
        background-color: #0f172a !important;
        border-color: #1e293b !important;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.4) !important;
    }
    html.dark header h1,
    html.dark header h2,
    html.dark header h3 {
        color: #f8fafc !important;
    }
    html.dark header p {
        color: #94a3b8 !important;
    }

    /* 3. Semua Kartu Putih Menjadi Dark Slate */
    html.dark main .bg-white:not(#themeSwitchThumb),
    html.dark div.bg-white:not(#themeSwitchThumb),
    html.dark section .bg-white:not(#themeSwitchThumb),
    html.dark [id^="modal"] .bg-white,
    html.dark .modal-content,
    html.dark #rowDetailModalCard {
        background-color: #0f172a !important;
    }

    /* Switch Thumb Tetap Putih */
    html.dark #themeSwitchThumb {
        background-color: #ffffff !important;
    }

    /* 4. Container Card Border & Shadow */
    html.dark .rounded-xl.border,
    html.dark .rounded-2xl.border,
    html.dark .rounded-3xl.border {
        border-color: #1e293b !important;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.35) !important;
    }

    /* 5. Border Halus */
    html.dark .border-slate-100,
    html.dark .border-slate-200,
    html.dark .border-slate-200\/80,
    html.dark .border-slate-200\/70,
    html.dark .border-slate-300 {
        border-color: #1e293b !important;
    }

    /* 6. Latar Belakang Slate Ringan (Secondary Cards, Table Headers, Form Bars) */
    html.dark .bg-slate-50,
    html.dark .bg-slate-100,
    html.dark .bg-slate-50\/80,
    html.dark .bg-slate-50\/70,
    html.dark .bg-slate-50\/60,
    html.dark .bg-slate-50\/40,
    html.dark [id^="modal"] .bg-slate-50,
    html.dark [id^="modal"] .bg-slate-100 {
        background-color: #1e293b !important;
    }

    /* 7. Warna Teks, Label & Tipografi */
    html.dark h1,
    html.dark h2,
    html.dark h3,
    html.dark h4,
    html.dark h5,
    html.dark h6,
    html.dark .text-slate-900,
    html.dark .text-slate-800,
    html.dark [id^="modal"] .text-slate-900,
    html.dark [id^="modal"] .text-slate-800 {
        color: #f8fafc !important;
    }
    html.dark .text-slate-700,
    html.dark [id^="modal"] .text-slate-700 {
        color: #e2e8f0 !important;
    }
    html.dark .text-slate-600,
    html.dark [id^="modal"] .text-slate-600 {
        color: #cbd5e1 !important;
    }
    html.dark .text-slate-500,
    html.dark [id^="modal"] .text-slate-500 {
        color: #94a3b8 !important;
    }
    html.dark .text-slate-400,
    html.dark [id^="modal"] .text-slate-400 {
        color: #94a3b8 !important;
    }
    html.dark label {
        color: #e2e8f0 !important;
    }
    html.dark label span {
        color: #e2e8f0 !important;
    }

    /* 8. Form Controls: Input, Select, Textarea */
    html.dark input[type="text"],
    html.dark input[type="search"],
    html.dark input[type="number"],
    html.dark input[type="date"],
    html.dark input[type="email"],
    html.dark input[type="password"],
    html.dark select,
    html.dark textarea {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    html.dark select option {
        background-color: #0f172a !important;
        color: #f8fafc !important;
    }
    html.dark input::placeholder,
    html.dark textarea::placeholder {
        color: #64748b !important;
    }
    html.dark input:focus,
    html.dark select:focus,
    html.dark textarea:focus {
        border-color: #3b82f6 !important;
        background-color: #0f172a !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
    }
    html.dark input:disabled,
    html.dark select:disabled,
    html.dark textarea:disabled {
        background-color: #0b1120 !important;
        border-color: #1e293b !important;
        color: #64748b !important;
    }

    /* 9. Tabel & Baris Data */
    html.dark table {
        border-color: #1e293b !important;
    }
    html.dark table thead {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }
    html.dark table thead th {
        color: #94a3b8 !important;
        border-color: #334155 !important;
    }
    html.dark table tbody tr {
        border-color: #1e293b !important;
    }
    html.dark table tbody tr:hover {
        background-color: rgba(30, 41, 59, 0.7) !important;
    }
    html.dark table tbody td {
        border-color: #1e293b !important;
    }
    html.dark .divide-slate-100 > * + *,
    html.dark .divide-slate-200 > * + * {
        border-color: #1e293b !important;
    }

    /* 10. Badges, Pills & Status Cards */
    /* Emerald / Rentan */
    html.dark .bg-emerald-50,
    html.dark .bg-emerald-100 {
        background-color: rgba(16, 185, 129, 0.15) !important;
    }
    html.dark .text-emerald-700,
    html.dark .text-emerald-600 {
        color: #34d399 !important;
    }
    html.dark .border-emerald-200,
    html.dark .border-emerald-300 {
        border-color: rgba(16, 185, 129, 0.35) !important;
    }

    /* Blue / Info */
    html.dark .bg-blue-50,
    html.dark .bg-blue-100,
    html.dark .bg-blue-50\/40,
    html.dark .bg-blue-50\/70 {
        background-color: rgba(59, 130, 246, 0.15) !important;
    }
    html.dark .text-blue-900,
    html.dark .text-blue-800,
    html.dark .text-blue-700,
    html.dark .text-blue-600 {
        color: #60a5fa !important;
    }
    html.dark .border-blue-200,
    html.dark .border-blue-100,
    html.dark .border-blue-300,
    html.dark .border-blue-200\/60 {
        border-color: rgba(59, 130, 246, 0.35) !important;
    }

    /* Amber / Toleran */
    html.dark .bg-amber-50,
    html.dark .bg-amber-100,
    html.dark .bg-amber-50\/50,
    html.dark .bg-amber-50\/40 {
        background-color: rgba(245, 158, 11, 0.15) !important;
    }
    html.dark .text-amber-800,
    html.dark .text-amber-700,
    html.dark .text-amber-600 {
        color: #fbbf24 !important;
    }
    html.dark .border-amber-200,
    html.dark .border-amber-300 {
        border-color: rgba(245, 158, 11, 0.35) !important;
    }

    /* Rose / Resisten */
    html.dark .bg-rose-50,
    html.dark .bg-rose-100,
    html.dark .bg-rose-50\/50,
    html.dark .bg-rose-50\/40 {
        background-color: rgba(244, 63, 94, 0.15) !important;
    }
    html.dark .text-rose-800,
    html.dark .text-rose-700,
    html.dark .text-rose-600 {
        color: #fb7185 !important;
    }
    html.dark .border-rose-200,
    html.dark .border-rose-300 {
        border-color: rgba(244, 63, 94, 0.35) !important;
    }

    /* Indigo & Purple */
    html.dark .bg-indigo-50,
    html.dark .bg-purple-50 {
        background-color: rgba(129, 140, 248, 0.15) !important;
    }
    html.dark .text-indigo-700,
    html.dark .text-indigo-600,
    html.dark .text-purple-600,
    html.dark .text-purple-700 {
        color: #a5b4fc !important;
    }
    html.dark .border-indigo-100,
    html.dark .border-indigo-200,
    html.dark .border-purple-200 {
        border-color: rgba(129, 140, 248, 0.35) !important;
    }

    /* 11. Tombol Netral & Secondary */
    html.dark button.bg-white,
    html.dark a.bg-white,
    html.dark button.border-slate-200,
    html.dark a.border-slate-200 {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    html.dark button.bg-white:hover,
    html.dark a.bg-white:hover,
    html.dark button.border-slate-200:hover,
    html.dark a.border-slate-200:hover {
        background-color: #334155 !important;
        color: #ffffff !important;
    }
    html.dark button.bg-slate-800 {
        background-color: #3b82f6 !important;
        color: #ffffff !important;
    }
    html.dark button.bg-slate-800:hover {
        background-color: #2563eb !important;
    }

    /* 12. Dropzone Upload Berkas */
    html.dark .border-dashed.border-slate-300 {
        border-color: #475569 !important;
        background-color: #1e293b !important;
    }
    html.dark .border-dashed.border-slate-300:hover {
        border-color: #60a5fa !important;
        background-color: rgba(30, 58, 138, 0.2) !important;
    }

    /* 13. Navigasi Tab Aktif & Kartu Gradient */
    html.dark a.border-blue-600.bg-white {
        background-color: #0f172a !important;
        color: #60a5fa !important;
        border-color: #3b82f6 !important;
    }
    html.dark .bg-gradient-to-br.from-blue-50.to-indigo-50 {
        background: linear-gradient(to bottom right, rgba(30, 58, 138, 0.3), rgba(49, 46, 129, 0.3)) !important;
        border-color: #1e3a8a !important;
    }

    /* 14. Pagination */
    html.dark nav[role="navigation"] button,
    html.dark nav[role="navigation"] a,
    html.dark nav[role="navigation"] span,
    html.dark #dashboardTablePagination {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    html.dark nav[role="navigation"] a:hover,
    html.dark nav[role="navigation"] button:hover:not(:disabled) {
        background-color: #334155 !important;
        color: #ffffff !important;
    }

    /* 15. Header User & Theme Toggle Buttons */
    html.dark #themeToggleBtn,
    html.dark #userDropdownBtn {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    html.dark #themeToggleBtn:hover,
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

    /* 16. Modal Dialogs */
    html.dark [id^="modal"] {
        background-color: rgba(15, 23, 42, 0.75) !important;
    }
    html.dark [id^="modal"] .border-b,
    html.dark [id^="modal"] .border-t {
        border-color: #1e293b !important;
    }
    html.dark #modalDetailFooter {
        background-color: #0b1120 !important;
    }

    /* 17. Peta Leaflet Dark Mode Tiles */
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
        background: rgba(15, 23, 42, 0.88) !important;
        border: 1px solid rgba(51, 65, 85, 0.9) !important;
        color: #f1f5f9 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.6) !important;
    }
    html.dark .map-detail-panel.is-pinned,
    html.dark .map-detail-panel:hover {
        background: rgba(15, 23, 42, 0.95) !important;
    }
    html.dark .map-detail-panel .text-slate-800 {
        color: #f8fafc !important;
    }
    html.dark .map-detail-panel .border-slate-100 {
        border-color: #334155 !important;
    }
    html.dark .map-detail-panel .bg-slate-50 {
        background-color: #1e293b !important;
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

    /* 18. Scrollbar Custom Dark */
    html.dark ::-webkit-scrollbar-track {
        background: #0a0f1d;
    }
    html.dark ::-webkit-scrollbar-thumb {
        background: #334155;
        border-radius: 4px;
    }
    html.dark ::-webkit-scrollbar-thumb:hover {
        background: #475569;
    }

    /* 19. Tetap Cetak Terang saat Print */
    @media print {
        html.dark,
        html.dark body,
        html.dark main {
            background-color: #ffffff !important;
            color: #000000 !important;
        }
    }
</style>
