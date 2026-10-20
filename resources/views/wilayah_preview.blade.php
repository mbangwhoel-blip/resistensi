<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tab === 'provinsi' ? 'Pratinjau Cetak Master Data Provinsi' : 'Pratinjau Cetak Master Data Kabupaten Kota' }} - PETA RESISTENSI</title>

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

        /* Lembar Kertas Dokumen */
        .sheet-container {
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto 40px auto;
            background: #ffffff;
            padding: 14mm 16mm;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45);
            border-radius: 8px;
        }

        /* Kop Surat */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
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
            border-top: 2px solid #0f172a;
            border-bottom: 0.75px solid #0f172a;
            height: 2.5px;
            margin-top: 4px;
            margin-bottom: 12px;
        }

        /* Tabel Data */
        .preview-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            margin-bottom: 16px;
        }
        .preview-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-weight: 700;
            padding: 6px 8px;
            border: 1px solid #0f172a;
            text-transform: uppercase;
            font-size: 7.5pt;
            letter-spacing: 0.4px;
        }
        .preview-table td {
            padding: 5px 8px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }
        .preview-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* PENGATURAN MEDIA PRINT */
        @media print {
            body {
                background-color: #ffffff !important;
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
            .preview-table {
                page-break-inside: auto;
            }
            .preview-table tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            .preview-table thead {
                display: table-header-group;
            }
            .preview-table tfoot {
                display: table-footer-group;
            }
            .signature-box {
                page-break-inside: avoid;
            }
            @page {
                size: a4 portrait;
                margin: 12mm 12mm 15mm 12mm;
            }
        }
    </style>
</head>
<body>

    {{-- TOOLBAR ATAS (HANYA MUNCUL DI LAYAR BROWSER, HILANG SAAT DICETAK) --}}
    <header class="no-print sticky top-0 z-50 bg-slate-900/95 backdrop-blur-md border-b border-slate-700/80 px-4 sm:px-6 py-2.5 shadow-lg">
        <div class="w-full max-w-7xl mx-auto flex items-center justify-between gap-3 overflow-x-auto">
            
            {{-- SISI KIRI: KEMBALI & INDIKATOR --}}
            <div class="flex items-center gap-2.5 shrink-0">
                <a href="{{ route('wilayah.index', ['tab' => $tab, 'provinsi_id' => $filterInfo['provinsi_id'], 'search' => $filterInfo['search']]) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 text-xs font-semibold transition border border-slate-700 whitespace-nowrap active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Menu Wilayah</span>
                </a>

                <div class="hidden sm:flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-teal-500/20 text-teal-300 border border-teal-500/30 whitespace-nowrap">
                        {{ $tab === 'provinsi' ? 'Daftar 38 Provinsi' : 'Daftar 514 Kab/Kota' }}
                    </span>
                    <span class="text-xs text-slate-400 font-medium whitespace-nowrap">
                        Cakupan: <strong class="text-slate-200">{{ $filterInfo['provinsi_nama'] }}</strong>
                    </span>
                </div>
            </div>

            {{-- SISI TENGAH: SWITCH TAB PREVIEW CEPAT --}}
            <div class="flex items-center gap-1 bg-slate-800/80 p-1 rounded-xl border border-slate-700 shrink-0">
                <a href="{{ route('wilayah.preview', ['tab' => 'kabupaten', 'provinsi_id' => $filterInfo['provinsi_id']]) }}"
                   class="px-3 py-1 text-xs font-semibold rounded-lg transition whitespace-nowrap {{ $tab === 'kabupaten' ? 'bg-teal-600 text-white shadow-xs' : 'text-slate-400 hover:text-white' }}">
                    Kabupaten/Kota
                </a>
                <a href="{{ route('wilayah.preview', ['tab' => 'provinsi']) }}"
                   class="px-3 py-1 text-xs font-semibold rounded-lg transition whitespace-nowrap {{ $tab === 'provinsi' ? 'bg-teal-600 text-white shadow-xs' : 'text-slate-400 hover:text-white' }}">
                    Provinsi (38)
                </a>
            </div>

            {{-- SISI KANAN: TOMBOL CETAK & PDF --}}
            <div class="flex items-center gap-2 shrink-0">
                {{-- TOMBOL UNDUH PDF (DOMPDF) --}}
                <a href="{{ route('wilayah.pdf', ['tab' => $tab, 'provinsi_id' => $filterInfo['provinsi_id'], 'search' => $filterInfo['search'], 'mode' => 'download']) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white text-xs font-semibold transition border border-slate-700 shadow-sm whitespace-nowrap active:scale-95"
                   title="Unduh file PDF resmi">
                    <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Unduh PDF</span>
                </a>

                {{-- TOMBOL CETAK BROWSER / SIMPAN PDF (WINDOW.PRINT) --}}
                <button type="button"
                        onclick="window.print()"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-bold transition shadow-md cursor-pointer hover:shadow-teal-500/20 whitespace-nowrap active:scale-95"
                        title="Cetak langsung atau simpan sebagai PDF tanpa terganggu IDM">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span>Cetak / Simpan PDF</span>
                </button>
            </div>
        </div>
    </header>

    {{-- LEMBAR KERTAS DOKUMEN CETAK --}}
    <main class="sheet-container">

        {{-- KOP SURAT RESMI KEMENKES BBLKL --}}
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

        {{-- JUDUL DOKUMEN --}}
        <div class="text-center mb-4">
            <h1 class="text-sm sm:text-base font-extrabold uppercase text-slate-900 tracking-wide">
                {{ $tab === 'provinsi' ? 'DAFTAR MASTER DATA PROVINSI REPUBLIK INDONESIA' : 'DAFTAR MASTER DATA KABUPATEN / KOTA REPUBLIK INDONESIA' }}
            </h1>
        </div>

        {{-- METADATA INFO CETAK --}}
        <div class="mb-4 rounded-lg border border-slate-200 bg-slate-50/70 p-3 text-[11px] grid grid-cols-2 sm:grid-cols-4 gap-2">
            <div>
                <span class="text-slate-500 block text-[10px] font-semibold uppercase">Cakupan Wilayah</span>
                <span class="font-bold text-slate-800">{{ $filterInfo['provinsi_nama'] }}</span>
            </div>
            <div>
                <span class="text-slate-500 block text-[10px] font-semibold uppercase">Total Data</span>
                <span class="font-bold text-slate-800">{{ $filterInfo['total_terfilter'] }} Baris</span>
            </div>
            <div>
                <span class="text-slate-500 block text-[10px] font-semibold uppercase">Tanggal Cetak</span>
                <span class="font-medium text-slate-700">{{ $filterInfo['dicetak_pada'] }}</span>
            </div>
            <div>
                <span class="text-slate-500 block text-[10px] font-semibold uppercase">Petugas Penanggung Jawab</span>
                <span class="font-medium text-slate-700">{{ $filterInfo['user'] }}</span>
            </div>
        </div>

        {{-- TABEL DATA --}}
        @if ($tab === 'provinsi')
            {{-- TABEL MASTER PROVINSI --}}
            <table class="preview-table">
                <thead>
                    <tr>
                        <th class="w-10 text-center">No</th>
                        <th class="w-16 text-center">Kode ID</th>
                        <th>Nama Provinsi</th>
                        <th class="w-32 text-center">Jumlah Kab/Kota</th>
                        <th class="w-28 text-center">Data Uji Terhubung</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $prov)
                        <tr>
                            <td class="text-center text-slate-500 font-medium">{{ $index + 1 }}</td>
                            <td class="text-center font-bold text-slate-600">{{ $prov->id }}</td>
                            <td class="font-bold text-slate-800">{{ $prov->name ?? $prov->nama_provinsi }}</td>
                            <td class="text-center font-semibold text-blue-700">
                                {{ $prov->kabupatens_count }} Kabupaten / Kota
                            </td>
                            <td class="text-center text-slate-700">
                                {{ $prov->data_uji_resistensi_count ?? 0 }} Data
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-slate-400">
                                Tidak ada data provinsi yang cocok dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            {{-- TABEL MASTER KABUPATEN / KOTA --}}
            <table class="preview-table">
                <thead>
                    <tr>
                        <th class="w-10 text-center">No</th>
                        <th>Nama Kabupaten / Kota</th>
                        <th class="w-44">Provinsi</th>
                        <th class="w-16 text-center">Tipe</th>
                        <th class="w-24 text-right">Latitude</th>
                        <th class="w-24 text-right">Longitude</th>
                        <th class="w-20 text-center">Data Uji</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $kab)
                        @php
                            $isCity = str_starts_with(strtolower($kab->name), 'kota ');
                        @endphp
                        <tr>
                            <td class="text-center text-slate-500 font-medium">{{ $index + 1 }}</td>
                            <td class="font-semibold text-slate-900">{{ $kab->name }}</td>
                            <td class="text-slate-700">{{ $kab->provinsi->name ?? '-' }}</td>
                            <td class="text-center">
                                @if ($isCity)
                                    <span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-800">KOTA</span>
                                @else
                                    <span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">KAB</span>
                                @endif
                            </td>
                            <td class="text-right font-mono text-[11px] text-slate-600">
                                {{ $kab->latitude ? number_format((float)$kab->latitude, 4) : '-' }}
                            </td>
                            <td class="text-right font-mono text-[11px] text-slate-600">
                                {{ $kab->longitude ? number_format((float)$kab->longitude, 4) : '-' }}
                            </td>
                            <td class="text-center font-bold text-xs {{ ($kab->data_uji_resistensi_count ?? 0) > 0 ? 'text-emerald-700' : 'text-slate-400' }}">
                                {{ $kab->data_uji_resistensi_count ?? 0 }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-slate-400">
                                Tidak ada data kabupaten/kota yang cocok dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif

        {{-- BLOK PENGESAHAN / TANDA TANGAN KEPALA BBLKL --}}
        <div class="signature-box mt-8 pt-4 border-t border-slate-200 flex justify-between items-start text-xs text-slate-700">
            <div class="max-w-md text-[11px] text-slate-500 leading-relaxed">
                <p>* Dokumen ini merupakan rekapitulasi data resmi dari Master Data Wilayah pada Sistem Informasi Resistensi Insektisida Vektor Indonesia (PETA RESISTENSI).</p>
                <p class="mt-1">* Standar pembagian wilayah mengikuti ketetapan Kementerian Dalam Negeri Republik Indonesia (Total 38 Provinsi & 514 Kabupaten/Kota).</p>
            </div>
            <div class="text-center pr-6">
                <p>Salatiga, {{ date('d F Y') }}</p>
                <p class="font-bold text-slate-900 mt-1">Kepala Balai Besar Laboratorium Kesehatan Lingkungan</p>
                <div class="h-16"></div>
                <p class="font-extrabold text-slate-900 underline text-sm">Akhmad Saikhu, SKM, M.SC.PH</p>
                <p class="text-[11px] text-slate-600">NIP. 196805251992031004</p>
            </div>
        </div>

    </main>

    {{-- KEYBOARD SHORTCUT CTRL+P --}}
    <script>
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });

        // Auto print jika ada parameter print=1 atau mode=print
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('print') === '1' || urlParams.get('mode') === 'print') {
            window.addEventListener('load', function() {
                setTimeout(function() {
                    window.print();
                }, 500);
            });
        }
    </script>

</body>
</html>
