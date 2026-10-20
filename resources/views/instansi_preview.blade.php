<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pratinjau Cetak Master Data Unit / Instansi - PETA RESISTENSI</title>

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
                <a href="{{ route('instansi.index', ['search' => $filterInfo['search'], 'kategori' => $kategori, 'provinsi_id' => $provinsiId]) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 text-xs font-semibold transition border border-slate-700 whitespace-nowrap active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Master Instansi</span>
                </a>

                <div class="hidden sm:flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-teal-500/20 text-teal-300 border border-teal-500/30 whitespace-nowrap">
                        Master Data Unit / Instansi
                    </span>
                    <span class="text-xs text-slate-400 font-medium whitespace-nowrap">
                        Kategori: <strong class="text-slate-200">{{ $filterInfo['kategori'] }}</strong>
                    </span>
                </div>
            </div>

            {{-- SISI KANAN: TOMBOL UNDUH PDF & CETAK --}}
            <div class="flex items-center gap-2 shrink-0">
                {{-- TOMBOL UNDUH PDF (DOMPDF) --}}
                <a href="{{ route('instansi.pdf', ['search' => $filterInfo['search'], 'kategori' => $kategori, 'provinsi_id' => $provinsiId, 'mode' => 'download']) }}"
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
                        title="Cetak langsung atau simpan sebagai PDF">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span>Cetak / Simpan PDF</span>
                </button>
            </div>

        </div>
    </header>

    {{-- LEMBAR UTAMA DOKUMEN CETAK --}}
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
                DAFTAR MASTER DATA UNIT / INSTANSI KESEHATAN
            </h1>
        </div>

        {{-- METADATA INFO CETAK --}}
        <div class="mb-4 rounded-lg border border-slate-200 bg-slate-50/70 p-3 text-[11px] grid grid-cols-2 sm:grid-cols-4 gap-2">
            <div>
                <span class="text-slate-500 block text-[10px] font-semibold uppercase">Kategori Unit</span>
                <span class="font-bold text-slate-800">{{ $filterInfo['kategori'] }}</span>
            </div>
            <div>
                <span class="text-slate-500 block text-[10px] font-semibold uppercase">Total Instansi</span>
                <span class="font-bold text-slate-800">{{ $filterInfo['total_terfilter'] }} Unit</span>
            </div>
            <div>
                <span class="text-slate-500 block text-[10px] font-semibold uppercase">Cakupan Wilayah</span>
                <span class="font-medium text-slate-700">{{ $filterInfo['provinsi_nama'] }}</span>
            </div>
            <div>
                <span class="text-slate-500 block text-[10px] font-semibold uppercase">Tanggal Cetak</span>
                <span class="font-medium text-slate-700">{{ $filterInfo['dicetak_pada'] }}</span>
            </div>
        </div>

        {{-- TABEL DATA INSTANSI --}}
        <table class="preview-table">
            <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th style="width: 12%;">Kode Unit</th>
                    <th style="width: 28%;">Nama Unit / Instansi</th>
                    <th style="width: 18%;">Kategori</th>
                    <th style="width: 20%;">Wilayah (Provinsi/Kab)</th>
                    <th style="width: 17%;">Kontak &amp; PJ</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $index => $item)
                    <tr>
                        <td style="text-align: center; font-weight: bold; color: #64748b;">
                            {{ $index + 1 }}
                        </td>
                        <td class="font-mono text-slate-700 text-[10px]">
                            {{ $item->unit_code ?? '-' }}
                        </td>
                        <td>
                            <strong class="text-slate-900">{{ $item->nama_instansi }}</strong>
                            @if (!empty($item->address))
                                <div class="text-[10px] text-slate-500 mt-0.5 line-clamp-1">{{ $item->address }}</div>
                            @endif
                        </td>
                        <td>
                            @php
                                $katBadge = match(true) {
                                    str_contains($item->category ?? '', 'BKK') || str_contains($item->category ?? '', 'Kekarantinaan') => 'bg-teal-50 text-teal-800 border-teal-300',
                                    str_contains($item->category ?? '', 'Balai') || str_contains($item->category ?? '', 'Lab') => 'bg-emerald-50 text-emerald-800 border-emerald-300',
                                    str_contains($item->category ?? '', 'Dinas') => 'bg-amber-50 text-amber-800 border-amber-300',
                                    str_contains($item->category ?? '', 'Sakit') || str_contains($item->category ?? '', 'Puskesmas') => 'bg-purple-50 text-purple-800 border-purple-300',
                                    default => 'bg-slate-100 text-slate-700 border-slate-300'
                                };
                            @endphp
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold border {{ $katBadge }}">
                                {{ $item->category ?? '-' }}
                            </span>
                        </td>
                        <td class="text-slate-700">
                            <div>{{ $item->provinsi?->nama_provinsi ?? '-' }}</div>
                            @if (!empty($item->kabupaten?->nama_kabupaten))
                                <div class="text-[10px] text-slate-500">{{ $item->kabupaten?->nama_kabupaten }}</div>
                            @endif
                        </td>
                        <td class="text-slate-700 text-[10px]">
                            @if (!empty($item->person_in_charge))
                                <div class="font-medium text-slate-800">PJ: {{ $item->person_in_charge }}</div>
                            @endif
                            @if (!empty($item->phone))
                                <div class="text-slate-500">Telp: {{ $item->phone }}</div>
                            @endif
                            @if (!empty($item->email))
                                <div class="text-slate-500">{{ $item->email }}</div>
                            @endif
                            @if (empty($item->person_in_charge) && empty($item->phone) && empty($item->email))
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-slate-400">
                            Tidak ada data unit/instansi yang sesuai dengan filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- BLOK PENGESAHAN / TANDA TANGAN KEPALA BBLKL --}}
        <div class="signature-box mt-8 pt-4 border-t border-slate-200 flex justify-between items-start text-xs text-slate-700">
            <div class="max-w-md text-[11px] text-slate-500 leading-relaxed">
                <p>* Dokumen ini merupakan rekapitulasi data resmi Master Data Unit / Instansi Kesehatan pada Sistem Informasi Resistensi Insektisida Vektor Indonesia (PETA RESISTENSI).</p>
                <p class="mt-1">* Unit terdaftar mencakup Balai Kekarantinaan Kesehatan, Laboratorium Lingkungan, Dinas Kesehatan, dan Fasilitas Pelayanan Kesehatan se-Indonesia.</p>
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
