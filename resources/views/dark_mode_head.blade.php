{{-- FAVICON RESISTENSI (LOGO KEMENKES) --}}
<link rel="icon" type="image/png" href="{{ asset('kemenkes.png') }}">
<link rel="shortcut icon" type="image/png" href="{{ asset('kemenkes.png') }}">
<link rel="apple-touch-icon" href="{{ asset('kemenkes.png') }}">

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
    html.dark table thead,
    html.dark table thead tr,
    html.dark table thead th {
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
    html.dark .bg-emerald-100,
    html.dark .bg-emerald-50\/90,
    html.dark .bg-emerald-50\/80,
    html.dark .bg-emerald-50\/70,
    html.dark .bg-emerald-50\/40 {
        background-color: rgba(16, 185, 129, 0.16) !important;
    }
    html.dark .bg-emerald-200,
    html.dark .bg-emerald-200\/80 {
        background-color: rgba(5, 150, 105, 0.32) !important;
        border: 1px solid rgba(52, 211, 153, 0.55) !important;
    }
    html.dark .text-emerald-900 {
        color: #d1fae5 !important;
    }
    html.dark .text-emerald-800 {
        color: #a7f3d0 !important;
    }
    html.dark .text-emerald-700,
    html.dark .text-emerald-600,
    html.dark .text-emerald-500 {
        color: #4ade80 !important;
    }
    html.dark .text-emerald-600\/80 {
        color: #86efac !important;
    }
    html.dark .border-emerald-200,
    html.dark .border-emerald-300,
    html.dark .border-emerald-200\/80 {
        border-color: rgba(16, 185, 129, 0.4) !important;
    }

    /* Blue / Info */
    html.dark .bg-blue-50,
    html.dark .bg-blue-100,
    html.dark .bg-blue-50\/40,
    html.dark .bg-blue-50\/50,
    html.dark .bg-blue-50\/70 {
        background-color: rgba(59, 130, 246, 0.18) !important;
    }
    html.dark .bg-blue-200,
    html.dark .bg-blue-200\/80 {
        background-color: rgba(29, 78, 216, 0.32) !important;
        border: 1px solid rgba(96, 165, 250, 0.55) !important;
    }
    html.dark .text-blue-900 {
        color: #ffffff !important;
    }
    html.dark .text-blue-800 {
        color: #dbeafe !important;
    }
    html.dark .text-blue-700 {
        color: #93c5fd !important;
    }
    html.dark .text-blue-600 {
        color: #60a5fa !important;
    }
    html.dark .border-blue-200,
    html.dark .border-blue-100,
    html.dark .border-blue-300,
    html.dark .border-blue-200\/60 {
        border-color: rgba(59, 130, 246, 0.4) !important;
    }

    /* Amber / Toleran */
    html.dark .bg-amber-50,
    html.dark .bg-amber-100,
    html.dark .bg-amber-50\/50,
    html.dark .bg-amber-50\/40,
    html.dark .bg-amber-50\/70,
    html.dark .bg-amber-50\/80,
    html.dark .bg-amber-50\/90,
    html.dark [class*="bg-amber-50"] {
        background-color: rgba(245, 158, 11, 0.18) !important;
    }
    html.dark .bg-amber-200,
    html.dark .bg-amber-200\/80,
    html.dark .bg-amber-200\/70 {
        background-color: rgba(217, 119, 6, 0.32) !important;
        border: 1px solid rgba(251, 191, 36, 0.55) !important;
    }
    html.dark .text-amber-900,
    html.dark .text-amber-950 {
        color: #fef3c7 !important;
    }
    html.dark .text-amber-800 {
        color: #fde68a !important;
    }
    html.dark .text-amber-700,
    html.dark .text-amber-600,
    html.dark .text-amber-500 {
        color: #fde047 !important;
    }
    html.dark .text-amber-600\/80 {
        color: #fde047 !important;
    }
    html.dark .border-amber-200,
    html.dark .border-amber-300,
    html.dark .border-amber-400,
    html.dark .border-amber-200\/80,
    html.dark .border-amber-300\/80,
    html.dark .border-amber-400\/80 {
        border-color: rgba(245, 158, 11, 0.45) !important;
    }

    /* Banner Hak Akses Viewer (Mode Gelap: Kontras Tinggi, Tajam & Sangat Jelas) */
    html.dark .viewer-alert-banner,
    html.dark #viewerBanner {
        background-color: #0f172a !important;
        border: 1px solid rgba(245, 158, 11, 0.55) !important;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.6) !important;
    }
    html.dark .viewer-alert-banner .viewer-banner-title,
    html.dark #viewerBanner .viewer-banner-title {
        color: #fef08a !important;
        font-weight: 800 !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.7);
    }
    html.dark .viewer-alert-banner .viewer-banner-desc,
    html.dark #viewerBanner .viewer-banner-desc {
        color: #f8fafc !important;
        font-weight: 500 !important;
    }
    html.dark .viewer-alert-banner .viewer-banner-icon,
    html.dark #viewerBanner .viewer-banner-icon {
        background-color: rgba(245, 158, 11, 0.22) !important;
        border: 1px solid rgba(251, 191, 36, 0.55) !important;
        color: #fde047 !important;
    }
    html.dark .viewer-alert-banner .viewer-banner-badge,
    html.dark #viewerBanner .viewer-banner-badge {
        background-color: rgba(245, 158, 11, 0.25) !important;
        border: 1px solid rgba(251, 191, 36, 0.65) !important;
        color: #fef08a !important;
        font-weight: 900 !important;
    }

    /* Rose / Resisten */
    html.dark .bg-rose-50,
    html.dark .bg-rose-100,
    html.dark .bg-rose-50\/50,
    html.dark .bg-rose-50\/40,
    html.dark .bg-rose-50\/70 {
        background-color: rgba(244, 63, 94, 0.18) !important;
    }
    html.dark .bg-rose-200,
    html.dark .bg-rose-200\/80 {
        background-color: rgba(225, 29, 72, 0.32) !important;
        border: 1px solid rgba(251, 113, 133, 0.55) !important;
    }
    html.dark .text-rose-900 {
        color: #ffe4e6 !important;
    }
    html.dark .text-rose-800 {
        color: #fecdd3 !important;
    }
    html.dark .text-rose-700 {
        color: #fda4af !important;
    }
    html.dark .text-rose-600,
    html.dark .text-rose-500 {
        color: #fb7185 !important;
    }
    html.dark .text-rose-600\/80 {
        color: #fca5a5 !important;
    }
    html.dark .border-rose-200,
    html.dark .border-rose-300,
    html.dark .border-rose-200\/80 {
        border-color: rgba(244, 63, 94, 0.4) !important;
    }

    /* Indigo & Purple */
    html.dark .bg-indigo-50,
    html.dark .bg-indigo-100,
    html.dark .bg-purple-50 {
        background-color: rgba(129, 140, 248, 0.18) !important;
    }
    html.dark .text-indigo-900 {
        color: #ffffff !important;
    }
    html.dark .text-indigo-800 {
        color: #e0e7ff !important;
    }
    html.dark .text-indigo-700 {
        color: #c7d2fe !important;
    }
    html.dark .text-indigo-600,
    html.dark .text-indigo-600\/80,
    html.dark .text-purple-600,
    html.dark .text-purple-700 {
        color: #a5b4fc !important;
    }
    html.dark .border-indigo-100,
    html.dark .border-indigo-200,
    html.dark .border-purple-200 {
        border-color: rgba(129, 140, 248, 0.4) !important;
    }

    /* ======================================================== */
    /* 10-A. KARTU STATISTIK & KPI (STAT CARDS) - HIGH CONTRAST */
    /* ======================================================== */

    /* Container Kotak Stat Card Utama */
    html.dark .grid > .rounded-xl.border,
    html.dark .grid > .rounded-2xl.border,
    html.dark #kpiSection > div,
    html.dark .stat-card,
    html.dark .kpi-card {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.45) !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    html.dark .grid > .rounded-xl.border:hover,
    html.dark .grid > .rounded-2xl.border:hover,
    html.dark #kpiSection > div:hover {
        border-color: #475569 !important;
        box-shadow: 0 8px 25px -4px rgba(0, 0, 0, 0.6) !important;
    }

    /* Wadah Warna Lembut Stat Card di Mode Gelap */
    html.dark .grid > div.bg-blue-50\/40,
    html.dark .grid > div.bg-blue-50\/50,
    html.dark #kpiSection > div.bg-blue-50\/40,
    html.dark #kpiSection > div.bg-blue-50\/50 {
        background-color: rgba(30, 58, 138, 0.28) !important;
        border-color: rgba(96, 165, 250, 0.45) !important;
    }
    html.dark .grid > div.bg-rose-50\/50,
    html.dark #kpiSection > div.bg-rose-50\/50 {
        background-color: rgba(159, 18, 57, 0.26) !important;
        border-color: rgba(251, 113, 133, 0.45) !important;
    }
    html.dark .grid > div.bg-amber-50\/50,
    html.dark #kpiSection > div.bg-amber-50\/50 {
        background-color: rgba(146, 64, 14, 0.26) !important;
        border-color: rgba(251, 191, 36, 0.45) !important;
    }
    html.dark .grid > div.bg-emerald-50\/50,
    html.dark #kpiSection > div.bg-emerald-50\/50 {
        background-color: rgba(6, 95, 70, 0.26) !important;
        border-color: rgba(52, 211, 153, 0.45) !important;
    }
    html.dark .grid > div.bg-indigo-50\/50,
    html.dark #kpiSection > div.bg-indigo-50\/50 {
        background-color: rgba(49, 46, 129, 0.28) !important;
        border-color: rgba(129, 140, 248, 0.45) !important;
    }

    /* Nilai / Angka Besar Stat Card (Crisp Pure White / Sangat Jelas) */
    html.dark .grid .text-2xl,
    html.dark .grid .text-2xl.font-bold,
    html.dark .grid .text-2xl.font-black,
    html.dark .grid .text-2xl.font-extrabold,
    html.dark .grid h3.text-xl,
    html.dark #kpiSection .text-2xl,
    html.dark #kpiSection .text-2xl.font-black {
        color: #ffffff !important;
        font-weight: 800 !important;
        letter-spacing: -0.02em !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.6) !important;
    }

    /* Judul Kategori / Label Stat Card (Terang & Mudah Dibaca) */
    html.dark .grid p.text-slate-500,
    html.dark .grid span.text-slate-500,
    html.dark .grid p.text-xs.font-medium,
    html.dark #kpiSection span.text-slate-500 {
        color: #f1f5f9 !important;
        font-weight: 600 !important;
    }

    /* Label Kartu Halaman Input (Item | Filter Periode / Tahun) */
    html.dark .grid p.uppercase.text-slate-400 {
        color: #f1f5f9 !important;
        font-weight: 700 !important;
    }
    html.dark .grid p.uppercase.text-slate-400 span.text-slate-300 {
        color: #64748b !important;
    }
    html.dark .grid p.uppercase.text-slate-400 span.text-slate-500 {
        color: #93c5fd !important;
        font-weight: 600 !important;
    }

    /* Label Berwarna Khusus Stat Card */
    html.dark .grid span.text-blue-700,
    html.dark #kpiSection span.text-blue-700 {
        color: #93c5fd !important;
        font-weight: 800 !important;
    }
    html.dark .grid span.text-rose-700,
    html.dark #kpiSection span.text-rose-700 {
        color: #fda4af !important;
        font-weight: 800 !important;
    }
    html.dark .grid span.text-amber-700,
    html.dark #kpiSection span.text-amber-700 {
        color: #fde047 !important;
        font-weight: 800 !important;
    }
    html.dark .grid span.text-emerald-700,
    html.dark #kpiSection span.text-emerald-700 {
        color: #86efac !important;
        font-weight: 800 !important;
    }
    html.dark .grid span.text-indigo-700,
    html.dark #kpiSection span.text-indigo-700 {
        color: #c7d2fe !important;
        font-weight: 800 !important;
    }

    /* Sub-keterangan / Deskripsi di Bawah Angka Stat Card */
    html.dark .grid div.text-\[11px\].text-slate-400,
    html.dark .grid span.text-\[11px\].text-slate-400,
    html.dark .grid p.text-\[11px\].text-slate-400,
    html.dark #kpiSection div.text-\[11px\].text-slate-400 {
        color: #cbd5e1 !important;
        font-weight: 500 !important;
    }
    html.dark .grid .text-rose-600\/80,
    html.dark #kpiSection .text-rose-600\/80 {
        color: #fca5a5 !important;
        font-weight: 600 !important;
    }
    html.dark .grid .text-amber-600\/80,
    html.dark #kpiSection .text-amber-600\/80 {
        color: #fde047 !important;
        font-weight: 600 !important;
    }
    html.dark .grid .text-emerald-600\/80,
    html.dark #kpiSection .text-emerald-600\/80 {
        color: #86efac !important;
        font-weight: 600 !important;
    }
    html.dark .grid p.text-emerald-600,
    html.dark .grid div.text-emerald-600,
    html.dark #kpiSection .text-emerald-600 {
        color: #4ade80 !important;
        font-weight: 600 !important;
    }
    html.dark .grid p.text-indigo-600,
    html.dark .grid div.text-indigo-600,
    html.dark #kpiSection .text-indigo-600 {
        color: #a5b4fc !important;
        font-weight: 600 !important;
    }
    html.dark .grid p.text-amber-600,
    html.dark .grid div.text-amber-600,
    html.dark #kpiSection .text-amber-600 {
        color: #fde047 !important;
        font-weight: 600 !important;
    }
    html.dark .grid p.text-blue-600,
    html.dark .grid div.text-blue-600,
    html.dark #kpiSection .text-blue-600 {
        color: #93c5fd !important;
        font-weight: 600 !important;
    }

    /* Kotak Ikon / Icon Badges pada Stat Card */
    html.dark .grid .bg-blue-100.text-blue-600,
    html.dark .grid .bg-blue-50.text-blue-600,
    html.dark .grid .bg-blue-100.text-blue-700 {
        background-color: rgba(59, 130, 246, 0.24) !important;
        border: 1px solid rgba(96, 165, 250, 0.45) !important;
        color: #93c5fd !important;
    }
    html.dark .grid .bg-indigo-100.text-indigo-600,
    html.dark .grid .bg-indigo-50.text-indigo-600,
    html.dark .grid .bg-indigo-100.text-indigo-700 {
        background-color: rgba(99, 102, 241, 0.24) !important;
        border: 1px solid rgba(165, 180, 252, 0.45) !important;
        color: #c7d2fe !important;
    }
    html.dark .grid .bg-emerald-100.text-emerald-600,
    html.dark .grid .bg-emerald-50.text-emerald-600,
    html.dark .grid .bg-emerald-100.text-emerald-700 {
        background-color: rgba(16, 185, 129, 0.24) !important;
        border: 1px solid rgba(110, 231, 183, 0.45) !important;
        color: #86efac !important;
    }
    html.dark .grid .bg-amber-100.text-amber-600,
    html.dark .grid .bg-amber-50.text-amber-600,
    html.dark .grid .bg-amber-100.text-amber-700 {
        background-color: rgba(245, 158, 11, 0.24) !important;
        border: 1px solid rgba(253, 224, 71, 0.45) !important;
        color: #fde047 !important;
    }
    html.dark .grid .bg-rose-100.text-rose-600,
    html.dark .grid .bg-rose-50.text-rose-600 {
        background-color: rgba(244, 63, 94, 0.24) !important;
        border: 1px solid rgba(253, 164, 175, 0.45) !important;
        color: #fca5a5 !important;
    }
    html.dark .grid .bg-slate-100.text-slate-600 {
        background-color: rgba(51, 65, 85, 0.5) !important;
        border: 1px solid rgba(148, 163, 184, 0.35) !important;
        color: #e2e8f0 !important;
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
    html.dark .bg-gradient-to-br.from-blue-50.to-indigo-50,
    html.dark .bg-gradient-to-r.from-blue-50\/80.to-indigo-50\/80,
    html.dark [class*="from-blue-50"][class*="to-indigo-50"],
    html.dark [class*="from-blue-50/80"][class*="to-indigo-50/80"] {
        background: linear-gradient(to right, rgba(30, 58, 138, 0.4), rgba(49, 46, 129, 0.4)) !important;
        background-color: #0f172a !important;
        border-color: #1e3a8a !important;
    }
    html.dark [class*="from-blue-50"] h4,
    html.dark [class*="from-blue-50/80"] h4 {
        color: #f8fafc !important;
    }
    html.dark [class*="from-blue-50"] p,
    html.dark [class*="from-blue-50/80"] p {
        color: #cbd5e1 !important;
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
    html.dark .map-legend-control .text-slate-900,
    html.dark .map-legend-control .text-slate-800 {
        color: #f8fafc !important;
    }
    html.dark .map-legend-control .text-slate-700,
    html.dark .map-legend-control .text-slate-600 {
        color: #cbd5e1 !important;
    }
    html.dark .map-legend-control .text-slate-500 {
        color: #94a3b8 !important;
    }
    html.dark .map-legend-control .border-slate-200\/80,
    html.dark .map-legend-control .border-slate-100 {
        border-color: #334155 !important;
    }
    html.dark .map-legend-control .bg-rose-50 {
        background-color: rgba(136, 19, 55, 0.35) !important;
        border-color: rgba(225, 29, 72, 0.5) !important;
        color: #fda4af !important;
    }
    html.dark .map-legend-control .bg-amber-50 {
        background-color: rgba(120, 53, 15, 0.35) !important;
        border-color: rgba(217, 119, 6, 0.5) !important;
        color: #fde68a !important;
    }
    html.dark .map-legend-control .bg-emerald-50 {
        background-color: rgba(6, 78, 59, 0.35) !important;
        border-color: rgba(16, 185, 129, 0.5) !important;
        color: #a7f3d0 !important;
    }
    html.dark .map-legend-control .bg-indigo-50 {
        background-color: rgba(49, 46, 129, 0.35) !important;
        border-color: rgba(99, 102, 241, 0.5) !important;
        color: #c7d2fe !important;
    }
    html.dark .map-legend-control .bg-slate-50 {
        background-color: rgba(30, 41, 59, 0.6) !important;
        border-color: #475569 !important;
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

    /* 20. Navigasi Paginasi Terpadu (Sesuai Desain Dashboard di Mode Gelap) */
    html.dark nav[role="navigation"],
    html.dark #dashboardTablePagination {
        color: #94a3b8 !important;
    }

    /* Container pembungkus bar paginasi */
    html.dark div:has(> nav[role="navigation"]),
    html.dark .pagination-nav,
    html.dark #dashboardTablePagination {
        background-color: #0f172a !important;
        border-color: #1e293b !important;
    }

    /* Teks ringkasan informasi data */
    html.dark nav[role="navigation"] .text-slate-500,
    html.dark #dashboardTablePagination .text-slate-500 {
        color: #94a3b8 !important;
    }
    html.dark nav[role="navigation"] strong,
    html.dark #dashboardTablePagination strong {
        color: #f8fafc !important;
    }

    /* Tombol Paginasi Biasa (Sebelumnya, Selanjutnya, Nomor Halaman Inaktif) */
    html.dark nav[role="navigation"] a,
    html.dark #dashboardTablePagination button {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.4) !important;
    }
    html.dark nav[role="navigation"] a:hover,
    html.dark #dashboardTablePagination button:hover {
        background-color: #334155 !important;
        border-color: #3b82f6 !important;
        color: #60a5fa !important;
    }

    /* Tombol Paginasi Disabled (Sebelumnya / Selanjutnya di Halaman Pertama / Terakhir) */
    html.dark nav[role="navigation"] span.cursor-not-allowed,
    html.dark #dashboardTablePagination span.cursor-not-allowed {
        background-color: rgba(30, 41, 59, 0.6) !important;
        border-color: #334155 !important;
        color: #64748b !important;
    }

    /* Nomor Halaman Aktif (Biru Menonjol) */
    html.dark nav[role="navigation"] span.bg-blue-600,
    html.dark #dashboardTablePagination span.bg-blue-600 {
        background-color: #2563eb !important;
        color: #ffffff !important;
        border-color: #2563eb !important;
        box-shadow: 0 2px 8px -1px rgba(37, 99, 235, 0.5) !important;
    }

    /* Titik-titik Pemisah (...) */
    html.dark nav[role="navigation"] span:not(.cursor-not-allowed):not(.bg-blue-600),
    html.dark #dashboardTablePagination span:not(.cursor-not-allowed):not(.bg-blue-600) {
        color: #64748b !important;
    }

    /* Dropdown "Tampil per hal" pada Dashboard */
    html.dark #dashboardTablePagination select {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }

    /* 21. Logo & Icon Import Data Selalu Putih pada Mode Gelap */
    html.dark button[onclick*="modalImportExcel"],
    html.dark a[href*="modalImportExcel"] {
        background-color: rgba(6, 78, 59, 0.6) !important;
        border-color: rgba(16, 185, 129, 0.5) !important;
        color: #ffffff !important;
    }
    html.dark button[onclick*="modalImportExcel"] svg,
    html.dark button[onclick*="modalImportExcel"] span,
    html.dark button[onclick*="modalImportExcel"]:hover svg,
    html.dark #modalImportExcel .flex.h-10.w-10 svg,
    html.dark #modalImportExcel .w-11.h-11 svg,
    html.dark #modalImportExcel .h-11.w-11 svg,
    html.dark #modalImportExcel svg[stroke="currentColor"],
    html.dark #modalImportExcel svg path {
        color: #ffffff !important;
        stroke: #ffffff !important;
    }
    html.dark #modalImportExcel .flex.h-10.w-10 {
        background-color: #064e3b !important;
        border-color: #059669 !important;
        color: #ffffff !important;
    }

    /* 23. Dropdown Tampil X Data pada Header Tabel (Dashboard & Input) */
    html.dark #tablePageSizeSelect,
    html.dark #tablePageSizeSelect option {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    html.dark div:has(> label[for="tablePageSizeSelect"]) {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    html.dark label[for="tablePageSizeSelect"] {
        color: #cbd5e1 !important;
    }
    html.dark label[for="tablePageSizeSelect"] svg {
        color: #94a3b8 !important;
    }

    /* 24. Tetap Cetak Terang saat Print */
    @media print {
        html.dark,
        html.dark body,
        html.dark main {
            background-color: #ffffff !important;
            color: #000000 !important;
        }
    }
</style>
