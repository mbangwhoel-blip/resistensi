<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DataUjiResistensi;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\KategoriUji;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ExportImportController extends Controller
{
    /**
     * Halaman Export Data
     */
    public function exportIndex(Request $request)
    {
        if (Auth::check() && Auth::user()->isViewer()) {
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak: Akun dengan role Viewer hanya memiliki izin melihat data (tidak dapat mengekspor data).');
        }

        $bulanFilter = $request->get('bulan', 'Semua');
        $tahunFilter = $request->get('tahun', 'Semua');
        $nyamukFilter = $request->get('jenis_nyamuk', '');
        $provinsiFilter = $request->get('provinsi_id', '');
        $perPageRaw = $request->get('per_page', 25);
        if ($perPageRaw === 'all' || (int)$perPageRaw >= 999999) {
            $perPage = 999999;
        } elseif (in_array((int)$perPageRaw, [5, 10, 25, 50, 100])) {
            $perPage = (int)$perPageRaw;
        } else {
            $perPage = 25;
        }

        $query = DataUjiResistensi::with(['provinsi', 'kabupaten'])->orderBy('id', 'desc');

        if ($bulanFilter && $bulanFilter !== 'Semua') {
            $query->where('month', $bulanFilter);
        }

        if ($tahunFilter && $tahunFilter !== 'Semua') {
            $query->where('year', (int)$tahunFilter);
        }

        if ($nyamukFilter && $nyamukFilter !== 'Semua') {
            $query->where('mosquito_type', $nyamukFilter);
        }

        if ($provinsiFilter && $provinsiFilter !== 'Semua') {
            $query->where('provinsi_id', $provinsiFilter);
        }

        // Hitung statistik ringkasan dari query terfilter
        $statsQuery = clone $query;
        $totalSemua = (clone $statsQuery)->count();
        $totalSampel = (int)(clone $statsQuery)->sum('sample_count');
        $totalResisten = (clone $statsQuery)->whereRaw('LOWER(status) = ?', ['resisten'])->count();
        $totalToleran = (clone $statsQuery)->where(function($q) {
            $q->whereRaw('LOWER(status) LIKE ?', ['%toleran%'])
              ->orWhereRaw('LOWER(status) LIKE ?', ['%terduga%']);
        })->count();
        $totalRentan = (clone $statsQuery)->whereRaw('LOWER(status) = ?', ['rentan'])->count();

        $dataPreview = $query->paginate($perPage)->withQueryString();

        $provinsis = Provinsi::orderBy('name')->get();

        // Ambil daftar tahun dinamis dari database
        $tahunDb = DataUjiResistensi::select('year')
            ->distinct()
            ->whereNotNull('year')
            ->pluck('year')
            ->map(fn($y) => (int)$y)
            ->filter(fn($y) => $y > 2000 && $y < 2100)
            ->toArray();
        $daftarTahun = array_values(array_unique(array_merge([(int)date('Y'), (int)date('Y') - 1], $tahunDb)));
        rsort($daftarTahun);

        // Ambil jenis nyamuk dinamis dari data pengujian
        $nyamukDb = DataUjiResistensi::select('mosquito_type')
            ->distinct()
            ->whereNotNull('mosquito_type')
            ->where('mosquito_type', '!=', '')
            ->orderBy('mosquito_type')
            ->pluck('mosquito_type')
            ->toArray();
        $daftarNyamuk = !empty($nyamukDb) ? $nyamukDb : KategoriUji::where('category', 'nyamuk')->pluck('name')->toArray();

        $daftarBulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return view('export', compact(
            'dataPreview',
            'totalSemua',
            'totalSampel',
            'totalResisten',
            'totalToleran',
            'totalRentan',
            'provinsis',
            'daftarTahun',
            'daftarNyamuk',
            'daftarBulan',
            'bulanFilter',
            'tahunFilter',
            'nyamukFilter',
            'provinsiFilter',
            'perPage',
            'perPageRaw'
        ));
    }

    /**
     * Download Hasil Export (CSV / Excel / JSON)
     */
    public function exportDownload(Request $request)
    {
        if (Auth::check() && Auth::user()->isViewer()) {
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak: Akun dengan role Viewer hanya memiliki izin melihat data (tidak dapat mengekspor data).');
        }

        $format = strtolower($request->get('format', 'xlsx'));
        $bulanFilter = $request->get('bulan', 'Semua');
        $tahunFilter = $request->get('tahun', 'Semua');
        $nyamukFilter = $request->get('jenis_nyamuk', '');
        $provinsiFilter = $request->get('provinsi_id', '');

        $query = DataUjiResistensi::with(['provinsi', 'kabupaten'])->orderBy('id', 'asc');

        if ($bulanFilter && $bulanFilter !== 'Semua') {
            $query->where('month', $bulanFilter);
        }
        if ($tahunFilter && $tahunFilter !== 'Semua') {
            $query->where('year', (int)$tahunFilter);
        }
        if ($nyamukFilter && $nyamukFilter !== 'Semua') {
            $query->where('mosquito_type', $nyamukFilter);
        }
        if ($provinsiFilter && $provinsiFilter !== 'Semua') {
            $query->where('provinsi_id', $provinsiFilter);
        }

        $items = $query->get();
        $timestamp = date('Ymd_His');

        // Export JSON
        if ($format === 'json') {
            $fileName = "export_uji_resistensi_{$timestamp}.json";
            $jsonData = $items->map(function ($item, $index) {
                $st = strtolower(trim((string)$item->status));
                $isResisten = ($st === 'resisten');
                $isRentan = ($st === 'rentan');
                $isToleran = str_contains($st, 'toleran') || str_contains($st, 'terduga');

                return [
                    'no' => $index + 1,
                    'provinsi' => $item->provinsi ? $item->provinsi->nama_provinsi : '-',
                    'kabupaten' => $item->kabupaten ? $item->kabupaten->nama_kabupaten : '-',
                    'alamat' => $item->alamat ?? '-',
                    'jenis_nyamuk' => $item->jenis_nyamuk ?? '-',
                    'insektisida' => $item->insektisida ?? '-',
                    'metode' => $item->metode ?? '-',
                    'sampel_diperiksa' => (int)($item->sampel_diperiksa ?? 0),
                    'bulan' => $item->bulan ?? '-',
                    'tahun' => (int)($item->tahun ?? 0),
                    'resisten' => $isResisten ? 'v' : '',
                    'rentan' => $isRentan ? 'v' : '',
                    'toleran' => $isToleran ? 'v' : '',
                    'mutasi' => $item->mutasi ?? '-',
                    'publikasi' => $item->publikasi ?? '-',
                    'status' => $item->status ?? '-'
                ];
            });

            return response()->json([
                'generated_at' => now()->toIso8601String(),
                'total_records' => $items->count(),
                'data' => $jsonData
            ], 200, [
                'Content-Disposition' => "attachment; filename=\"{$fileName}\""
            ]);
        }

        // Export Excel Native (.xlsx) dengan kolom rapi, lebar auto, border & warna header
        if ($format === 'xlsx' || $format === 'excel') {
            $fileName = "export_uji_resistensi_{$timestamp}.xlsx";

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Data Resistensi');

            // Header kolom
            $headers = [
                'No', 'Provinsi', 'Kabupaten', 'Alamat', 'Jenis Nyamuk',
                'Insektisida', 'Metode', 'Sampel Diperiksa', 'Bulan', 'Tahun',
                'Resisten', 'Rentan', 'Toleran', 'Mutasi', 'Publikasi'
            ];

            foreach ($headers as $hIdx => $h) {
                $colLetter = Coordinate::stringFromColumnIndex($hIdx + 1);
                $sheet->setCellValue($colLetter . '1', $h);
            }

            // Data baris
            $rowIdx = 2;
            foreach ($items as $index => $item) {
                $st = strtolower(trim((string)$item->status));
                $isResisten = ($st === 'resisten');
                $isRentan = ($st === 'rentan');
                $isToleran = str_contains($st, 'toleran') || str_contains($st, 'terduga');

                $sheet->setCellValue('A' . $rowIdx, $index + 1);
                $sheet->setCellValue('B' . $rowIdx, $item->provinsi ? $item->provinsi->nama_provinsi : '-');
                $sheet->setCellValue('C' . $rowIdx, $item->kabupaten ? $item->kabupaten->nama_kabupaten : '-');
                $sheet->setCellValue('D' . $rowIdx, $item->alamat ?: '-');
                $sheet->setCellValue('E' . $rowIdx, $item->jenis_nyamuk ?: '-');
                $sheet->setCellValue('F' . $rowIdx, $item->insektisida ?: '-');
                $sheet->setCellValue('G' . $rowIdx, $item->metode ?: '-');
                $sheet->setCellValue('H' . $rowIdx, (int)($item->sampel_diperiksa ?? 0));
                $sheet->setCellValue('I' . $rowIdx, $item->bulan ?: '-');
                $sheet->setCellValue('J' . $rowIdx, (int)($item->tahun ?? 0));
                $sheet->setCellValue('K' . $rowIdx, $isResisten ? 'v' : '');
                $sheet->setCellValue('L' . $rowIdx, $isRentan ? 'v' : '');
                $sheet->setCellValue('M' . $rowIdx, $isToleran ? 'v' : '');
                $sheet->setCellValue('N' . $rowIdx, $item->mutasi ?: '-');
                $sheet->setCellValue('O' . $rowIdx, $item->publikasi ?: '-');

                $sheet->getRowDimension($rowIdx)->setRowHeight(21);
                $rowIdx++;
            }

            $lastRow = max(2, $rowIdx - 1);

            // Style Header Row (1)
            $sheet->getStyle('A1:O1')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 11,
                    'name' => 'Calibri',
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0F766E'], // Teal Gelap Kemenkes
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);
            $sheet->getRowDimension(1)->setRowHeight(28);

            // Style Data Rows
            if ($lastRow >= 2) {
                $sheet->getStyle("A2:O{$lastRow}")->applyFromArray([
                    'font' => ['size' => 10, 'name' => 'Calibri'],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                ]);

                // Alignment Center untuk Kolom Angka dan Flag
                $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("H2:N{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Zebra striping untuk baris genap
                for ($r = 2; $r <= $lastRow; $r++) {
                    if ($r % 2 === 0) {
                        $sheet->getStyle("A{$r}:O{$r}")->getFill()->applyFromArray([
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'F8FAFC'],
                        ]);
                    }
                }
            }

            // Border seluruh tabel
            $sheet->getStyle("A1:O{$lastRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CBD5E1'],
                    ],
                ],
            ]);

            // Set Lebar Kolom Proporsional & Rapi
            $colWidths = [
                'A' => 8,  // No
                'B' => 20, // Provinsi
                'C' => 20, // Kabupaten
                'D' => 30, // Alamat
                'E' => 18, // Jenis Nyamuk
                'F' => 20, // Insektisida
                'G' => 24, // Metode
                'H' => 18, // Sampel
                'I' => 14, // Bulan
                'J' => 12, // Tahun
                'K' => 12, // Resisten
                'L' => 12, // Rentan
                'M' => 12, // Toleran
                'N' => 15, // Mutasi
                'O' => 26, // Publikasi
            ];
            foreach ($colWidths as $colLetter => $width) {
                $sheet->getColumnDimension($colLetter)->setWidth($width);
            }

            // Freeze Pane agar header tetap terlihat saat scroll
            $sheet->freezePane('A2');

            return response()->streamDownload(function () use ($spreadsheet) {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            }, $fileName, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Cache-Control' => 'max-age=0',
            ]);
        }

        // Export CSV / Excel Compatible
        $fileName = "export_uji_resistensi_{$timestamp}.csv";

        return new StreamedResponse(function () use ($items) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM agar terbaca sempurna di Microsoft Excel
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header kolom sesuai format data resistensi lengkap
            fputcsv($handle, [
                'No',
                'Provinsi',
                'Kabupaten',
                'Alamat',
                'Jenis Nyamuk',
                'Insektisida',
                'Metode',
                'Sampel Diperiksa',
                'Bulan',
                'Tahun',
                'Resisten',
                'Rentan',
                'Toleran',
                'Mutasi',
                'Publikasi'
            ]);

            $sanitizeCsv = function ($val) {
                if (is_null($val)) return '-';
                $str = (string)$val;
                if (strlen($str) > 0 && in_array($str[0], ['=', '+', '-', '@', "\t", "\r"])) {
                    return "'" . $str;
                }
                return $str;
            };

            foreach ($items as $index => $item) {
                $st = strtolower(trim((string)$item->status));
                $isResisten = ($st === 'resisten');
                $isRentan = ($st === 'rentan');
                $isToleran = str_contains($st, 'toleran') || str_contains($st, 'terduga');

                fputcsv($handle, [
                    $index + 1,
                    $sanitizeCsv($item->provinsi ? $item->provinsi->nama_provinsi : '-'),
                    $sanitizeCsv($item->kabupaten ? $item->kabupaten->nama_kabupaten : '-'),
                    $sanitizeCsv($item->alamat ?? '-'),
                    $sanitizeCsv($item->jenis_nyamuk ?? '-'),
                    $sanitizeCsv($item->insektisida ?? '-'),
                    $sanitizeCsv($item->metode ?? '-'),
                    (int)($item->sampel_diperiksa ?? 0),
                    $sanitizeCsv($item->bulan ?? '-'),
                    (int)($item->tahun ?? 0),
                    $isResisten ? 'v' : '',
                    $isRentan ? 'v' : '',
                    $isToleran ? 'v' : '',
                    $sanitizeCsv($item->mutasi ?? '-'),
                    $sanitizeCsv($item->publikasi ?? '-')
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ]);
    }

    /**
     * Halaman Import Data
     */
    public function importIndex()
    {
        if (Auth::check() && Auth::user()->isViewer()) {
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak: Akun dengan role Viewer hanya memiliki izin melihat data (read-only).');
        }

        $totalData = DataUjiResistensi::count();
        $totalProvinsi = Provinsi::count();
        $totalKabupaten = Kabupaten::count();

        return view('import', compact('totalData', 'totalProvinsi', 'totalKabupaten'));
    }

    /**
     * Download Template (Excel .XLSX atau .CSV) untuk Import
     */
    public function downloadTemplate(Request $request)
    {
        $format = strtolower($request->get('format', 'xlsx'));

        if ($format === 'csv') {
            $fileName = 'template_import_simpel_bblk.csv';

            return new StreamedResponse(function () {
                $handle = fopen('php://output', 'w');
                // UTF-8 BOM
                fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

                // Header kolom template (14 kolom lengkap tanpa data dummy)
                fputcsv($handle, [
                    'provinsi',
                    'kabupaten',
                    'alamat',
                    'jenis_nyamuk',
                    'insektisida',
                    'metode',
                    'sampel_diperiksa',
                    'bulan',
                    'tahun',
                    'resisten',
                    'rentan',
                    'toleran',
                    'mutasi',
                    'publikasi'
                ]);

                fclose($handle);
            }, 200, [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            ]);
        }

        // Default: Format Excel (.xlsx) dengan kolom rapi, warna header, dan auto-width (tanpa data dummy)
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Data Resistensi');

        // Headers
        $headers = [
            'provinsi', 'kabupaten', 'alamat', 'jenis_nyamuk', 'insektisida',
            'metode', 'sampel_diperiksa', 'bulan', 'tahun',
            'resisten', 'rentan', 'toleran', 'mutasi', 'publikasi'
        ];

        foreach ($headers as $hIdx => $header) {
            $colLetter = Coordinate::stringFromColumnIndex($hIdx + 1);
            $sheet->setCellValue($colLetter . '1', $header);
        }

        // Style Header Row (1)
        $sheet->getStyle('A1:N1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
                'name' => 'Calibri',
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E40AF'], // Royal Blue Kemenkes
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Siapkan grid tabel kosong yang rapi untuk 50 baris isian pertama
        $maxEmptyRows = 50;
        $sheet->getStyle("A2:N{$maxEmptyRows}")->applyFromArray([
            'font' => [
                'size' => 10,
                'name' => 'Calibri',
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        for ($r = 2; $r <= $maxEmptyRows; $r++) {
            $sheet->getRowDimension($r)->setRowHeight(22);
            // Center align kolom sampel (G), bulan (H), tahun (I), resisten (J), rentan (K), toleran (L), mutasi (M)
            $sheet->getStyle("G{$r}:M{$r}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Border Thin untuk Seluruh Tabel (Header + Grid Kosong)
        $sheet->getStyle("A1:N{$maxEmptyRows}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CBD5E1'],
                ],
            ],
        ]);

        // Set Lebar Kolom Proporsional & Rapi
        $minWidths = [
            'A' => 18, // provinsi
            'B' => 18, // kabupaten
            'C' => 30, // alamat
            'D' => 18, // jenis_nyamuk
            'E' => 20, // insektisida
            'F' => 24, // metode
            'G' => 18, // sampel_diperiksa
            'H' => 14, // bulan
            'I' => 12, // tahun
            'J' => 12, // resisten
            'K' => 12, // rentan
            'L' => 12, // toleran
            'M' => 14, // mutasi
            'N' => 26  // publikasi
        ];
        foreach ($minWidths as $col => $w) {
            $sheet->getColumnDimension($col)->setWidth($w);
        }

        // Freeze Panes A2
        $sheet->freezePane('A2');

        $fileName = 'template_import_simpel_bblk.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Normalisasi nama kabupaten (menghilangkan awalan/akhiran Kab, Kab., Kabupaten, Kota)
     */
    private function cleanKabupatenName($name)
    {
        if (!$name) return '';
        $name = trim($name);
        // Hapus prefiks seperti "Kabupaten", "Kab.", "Kab", "Kota" (case-insensitive)
        $cleaned = preg_replace('/^(kabupaten|kab\.?|kota)\s+/i', '', $name);
        // Hapus juga sufiks jika ada (misal "Kudus Kab")
        $cleaned = preg_replace('/\s+(kabupaten|kab\.?|kota)$/i', '', $cleaned);
        return trim($cleaned);
    }

    /**
     * Memeriksa apakah suatu sel berisi tanda centang / nilai bernilai benar
     */
    private function isTruthyMark($val)
    {
        if (is_null($val)) return false;
        $str = strtolower(trim((string)$val));
        if ($str === '' || in_array($str, ['-', '0', 'tidak', 'no', 'false', 'none'])) {
            return false;
        }
        return in_array($str, ['v', 'x', '1', 'ya', 'yes', 'true', '+', 'ok', 'resisten', 'rentan', 'toleran', 'terduga resisten']) || strlen($str) > 0;
    }

    /**
     * Parser berkas XLSX (Excel) menggunakan ZipArchive bawaan PHP
     */
    private function parseXlsxSheets($filePath)
    {
        if (!class_exists('ZipArchive')) {
            return [];
        }

        $zip = new \ZipArchive();
        if ($zip->open($filePath) !== true) {
            return [];
        }

        // Baca Shared Strings
        $sharedStrings = [];
        if (($index = $zip->locateName('xl/sharedStrings.xml')) !== false) {
            $xml = simplexml_load_string($zip->getFromIndex($index));
            if ($xml) {
                foreach ($xml->si as $si) {
                    $t = '';
                    if (isset($si->t)) {
                        $t = (string)$si->t;
                    } elseif (isset($si->r)) {
                        foreach ($si->r as $r) {
                            $t .= (string)$r->t;
                        }
                    }
                    $sharedStrings[] = $t;
                }
            }
        }

        $sheetsData = [];
        $wbXmlStr = $zip->getFromName('xl/workbook.xml');
        $relsXmlStr = $zip->getFromName('xl/_rels/workbook.xml.rels');

        if ($wbXmlStr && $relsXmlStr) {
            $wbXml = simplexml_load_string($wbXmlStr);
            $relsXml = simplexml_load_string($relsXmlStr);

            $relMap = [];
            foreach ($relsXml->Relationship as $rel) {
                $relMap[(string)$rel['Id']] = (string)$rel['Target'];
            }

            foreach ($wbXml->sheets->sheet as $s) {
                $sName = (string)$s['name'];
                $rAttrs = $s->attributes('r', true);
                $rId = isset($rAttrs['id']) ? (string)$rAttrs['id'] : (string)$s->attributes('http://schemas.openxmlformats.org/officeDocument/2006/relationships')['id'];
                $target = 'xl/' . ($relMap[$rId] ?? '');

                $sheetXmlStr = $zip->getFromName($target);
                if (!$sheetXmlStr) continue;

                $sheetXml = simplexml_load_string($sheetXmlStr);
                if (!$sheetXml || !isset($sheetXml->sheetData->row)) continue;

                $rows = [];
                foreach ($sheetXml->sheetData->row as $row) {
                    $rowArray = [];
                    foreach ($row->c as $c) {
                        $ref = (string)$c['r'];
                        preg_match('/([A-Z]+)(\d+)/', $ref, $m);
                        $colLetter = $m[1] ?? 'A';
                        $colIdx = 0;
                        for ($k = 0; $k < strlen($colLetter); $k++) {
                            $colIdx = $colIdx * 26 + ord($colLetter[$k]) - 0x40;
                        }
                        $colIdx -= 1;

                        $type = (string)$c['t'];
                        $val = (string)$c->v;
                        if ($type === 's' && is_numeric($val)) {
                            $val = $sharedStrings[(int)$val] ?? '';
                        }
                        $rowArray[$colIdx] = trim($val);
                    }

                    if (!empty($rowArray) && array_filter($rowArray, 'strlen')) {
                        $maxCol = max(array_keys($rowArray));
                        $filled = [];
                        for ($k = 0; $k <= $maxCol; $k++) {
                            $filled[$k] = $rowArray[$k] ?? '';
                        }
                        $rows[] = $filled;
                    }
                }

                if (!empty($rows)) {
                    $sheetsData[$sName] = $rows;
                }
            }
        }

        $zip->close();
        return $sheetsData;
    }

    /**
     * Proses File Import (Mendukung .CSV, .TXT, dan .XLSX / Excel)
     */
    public function importProcess(Request $request)
    {
        if (Auth::check() && Auth::user()->isViewer()) {
            return redirect()->back()->with('error', 'Akses Ditolak: Akun dengan role Viewer hanya memiliki izin melihat data (read-only) tanpa hak akses menambah/mengimpor data.');
        }

        $request->validate([
            'file' => 'required|file|max:20480' // max 20MB
        ]);

        $file = $request->file('file');
        $ext = strtolower($file->getClientOriginalExtension());

        if (!in_array($ext, ['csv', 'txt', 'xlsx', 'xls'])) {
            return redirect()->back()->with('error', 'Format file harus berupa Excel (.xlsx) atau CSV (.csv / .txt).');
        }

        $path = $file->getRealPath();
        $sheetGroups = [];

        if ($ext === 'xlsx') {
            $sheetGroups = $this->parseXlsxSheets($path);
            if (empty($sheetGroups)) {
                return redirect()->back()->with('error', 'Gagal membaca berkas Excel atau berkas kosong.');
            }
        } else {
            // CSV atau TXT
            $content = file_get_contents($path);
            if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
                $content = substr($content, 3);
            }

            $lines = preg_split('/\r\n|\r|\n/', trim($content));
            if (count($lines) < 2) {
                return redirect()->back()->with('error', 'File CSV kosong atau hanya berisi baris header.');
            }

            $firstLine = $lines[0];
            $delimiter = strpos($firstLine, ';') !== false ? ';' : ',';

            $rows = [];
            foreach ($lines as $line) {
                if (trim($line) === '') continue;
                $row = str_getcsv($line, $delimiter);
                $rows[] = $row;
            }

            $sheetGroups['CSV'] = $rows;
        }

        // Cache master data provinsi & kabupaten
        $allProvinsi = Provinsi::all()->keyBy(function ($item) {
            return strtolower(trim($item->nama_provinsi));
        });

        $bulanMap = [
            'january' => 'Januari', 'february' => 'Februari', 'march' => 'Maret',
            'april' => 'April', 'may' => 'Mei', 'june' => 'Juni',
            'july' => 'Juli', 'august' => 'Agustus', 'september' => 'September',
            'october' => 'Oktober', 'november' => 'November', 'december' => 'Desember'
        ];

        $provAliases = [
            'ntt' => 'Nusa Tenggara Timur',
            'ntb' => 'Nusa Tenggara Barat',
            'diy' => 'DI Yogyakarta',
            'yogyakarta' => 'DI Yogyakarta',
            'dki' => 'DKI Jakarta'
        ];

        $importedCount = 0;
        $skippedCount = 0;
        $matchedMasterCount = 0;
        $newKabCount = 0;

        foreach ($sheetGroups as $sheetName => $parsedRows) {
            if (empty($parsedRows)) continue;

            // Cari baris header di 15 baris pertama
            $headerRowIdx = -1;
            $colIndex = [];

            foreach (array_slice($parsedRows, 0, 15, true) as $rIdx => $rData) {
                $joined = strtolower(implode(' ', $rData));
                if (str_contains($joined, 'prov') && (str_contains($joined, 'kab') || str_contains($joined, 'kota') || str_contains($joined, 'nyamuk') || str_contains($joined, 'resisten'))) {
                    $headerRowIdx = $rIdx;
                    foreach ($rData as $cIdx => $cName) {
                        $cn = strtolower(trim($cName));
                        if (str_contains($cn, 'prov')) $colIndex['provinsi'] = $cIdx;
                        elseif (str_contains($cn, 'kab') || str_contains($cn, 'kota')) $colIndex['kabupaten'] = $cIdx;
                        elseif (str_contains($cn, 'alam') || str_contains($cn, 'lokas')) $colIndex['alamat'] = $cIdx;
                        elseif (str_contains($cn, 'nyamuk') || str_contains($cn, 'spesies')) $colIndex['jenis_nyamuk'] = $cIdx;
                        elseif (str_contains($cn, 'insek')) $colIndex['insektisida'] = $cIdx;
                        elseif (str_contains($cn, 'metod')) $colIndex['metode'] = $cIdx;
                        elseif (str_contains($cn, 'sampel') || str_contains($cn, 'jumlah')) $colIndex['sampel_diperiksa'] = $cIdx;
                        elseif (str_contains($cn, 'bulan')) $colIndex['bulan'] = $cIdx;
                        elseif (str_contains($cn, 'tahun')) $colIndex['tahun'] = $cIdx;
                        elseif (str_contains($cn, 'resisten') && !str_contains($cn, 'terduga')) $colIndex['resisten'] = $cIdx;
                        elseif (str_contains($cn, 'rentan')) $colIndex['rentan'] = $cIdx;
                        elseif (str_contains($cn, 'toleran')) $colIndex['toleran'] = $cIdx;
                        elseif (str_contains($cn, 'terduga')) $colIndex['terduga_resisten'] = $cIdx;
                        elseif (str_contains($cn, 'mutasi')) $colIndex['mutasi'] = $cIdx;
                        elseif (str_contains($cn, 'publikasi')) $colIndex['publikasi'] = $cIdx;
                        elseif (str_contains($cn, 'status')) $colIndex['status'] = $cIdx;
                    }
                    break;
                }
            }

            if ($headerRowIdx === -1) {
                // Lewati sheet tanpa header yang cocok
                continue;
            }

            for ($r = $headerRowIdx + 1; $r < count($parsedRows); $r++) {
                $row = $parsedRows[$r];
                $provNama = isset($colIndex['provinsi']) && isset($row[$colIndex['provinsi']]) ? trim($row[$colIndex['provinsi']]) : '';
                $kabNama = isset($colIndex['kabupaten']) && isset($row[$colIndex['kabupaten']]) ? trim($row[$colIndex['kabupaten']]) : '';

                if (!$provNama && !$kabNama) {
                    $skippedCount++;
                    continue;
                }

                $alamat = isset($colIndex['alamat']) && isset($row[$colIndex['alamat']]) ? trim($row[$colIndex['alamat']]) : null;
                $nyamuk = isset($colIndex['jenis_nyamuk']) && isset($row[$colIndex['jenis_nyamuk']]) && trim($row[$colIndex['jenis_nyamuk']]) !== '' ? trim($row[$colIndex['jenis_nyamuk']]) : 'Ae. aegypti';
                $insektisida = isset($colIndex['insektisida']) && isset($row[$colIndex['insektisida']]) && trim($row[$colIndex['insektisida']]) !== '' ? trim($row[$colIndex['insektisida']]) : 'Deltamethrin';
                $metode = isset($colIndex['metode']) && isset($row[$colIndex['metode']]) && trim($row[$colIndex['metode']]) !== '' ? trim($row[$colIndex['metode']]) : 'WHO Tube Bioassay';
                
                $sampelRaw = isset($colIndex['sampel_diperiksa']) && isset($row[$colIndex['sampel_diperiksa']]) ? $row[$colIndex['sampel_diperiksa']] : '1';
                $sampel = (int)round((float)preg_replace('/[^0-9.]/', '', $sampelRaw) ?: 1);

                $bulan = isset($colIndex['bulan']) && isset($row[$colIndex['bulan']]) && trim($row[$colIndex['bulan']]) !== '' ? trim($row[$colIndex['bulan']]) : date('F');
                if (isset($bulanMap[strtolower($bulan)])) {
                    $bulan = $bulanMap[strtolower($bulan)];
                }

                $tahunRaw = isset($colIndex['tahun']) && isset($row[$colIndex['tahun']]) ? $row[$colIndex['tahun']] : date('Y');
                $tahun = (int)round((float)preg_replace('/[^0-9.]/', '', $tahunRaw) ?: date('Y'));

                // Resolusi Status Resistensi
                $status = null;
                $resistenMarked = isset($colIndex['resisten']) && isset($row[$colIndex['resisten']]) && $this->isTruthyMark($row[$colIndex['resisten']]);
                $rentanMarked = isset($colIndex['rentan']) && isset($row[$colIndex['rentan']]) && $this->isTruthyMark($row[$colIndex['rentan']]);
                $toleranMarked = isset($colIndex['toleran']) && isset($row[$colIndex['toleran']]) && $this->isTruthyMark($row[$colIndex['toleran']]);
                $terdugaMarked = isset($colIndex['terduga_resisten']) && isset($row[$colIndex['terduga_resisten']]) && $this->isTruthyMark($row[$colIndex['terduga_resisten']]);

                if ($resistenMarked) {
                    $status = 'Resisten';
                } elseif ($rentanMarked) {
                    $status = 'Rentan';
                } elseif ($toleranMarked || $terdugaMarked) {
                    // Sesuai instruksi: kolom toleran dan terduga resisten untuk isiannya dimasukkan ke kolom toleran saja
                    $status = 'Toleran';
                } elseif (isset($colIndex['mutasi']) && isset($row[$colIndex['mutasi']])) {
                    $mVal = strtolower(trim($row[$colIndex['mutasi']]));
                    $status = ($mVal === 'ya') ? 'Resisten' : (($mVal === 'tidak') ? 'Rentan' : null);
                } elseif (isset($colIndex['status']) && isset($row[$colIndex['status']])) {
                    $sVal = strtolower(trim($row[$colIndex['status']]));
                    if (in_array($sVal, ['toleran', 'terduga resisten', 'terduga', 'toleran/terduga resisten', 'toleran / terduga resisten'])) {
                        $status = 'Toleran';
                    } elseif ($sVal === 'resisten') {
                        $status = 'Resisten';
                    } elseif ($sVal === 'rentan') {
                        $status = 'Rentan';
                    }
                }

                // Normalisasi Nama Provinsi
                $provKey = strtolower($provNama);
                if (isset($provAliases[$provKey])) {
                    $provNama = $provAliases[$provKey];
                    $provKey = strtolower($provNama);
                }

                $provObj = $allProvinsi->get($provKey);
                if (!$provObj && $provNama) {
                    $provObj = Provinsi::where('name', 'LIKE', "%{$provNama}%")->first();
                    if (!$provObj) {
                        $provObj = Provinsi::create(['name' => ucwords(strtolower($provNama))]);
                        $allProvinsi->put(strtolower($provObj->name ?? $provObj->nama_provinsi), $provObj);
                    }
                }

                // Normalisasi dan Pencocokan Kabupaten / Kota
                $isKotaInput = preg_match('/^(kota|kotamadya)\s+/i', trim($kabNama));
                $cleanedKab = $this->cleanKabupatenName($kabNama);
                $kabObj = null;

                if ($cleanedKab || $kabNama) {
                    if ($provObj) {
                        // 1. Prioritas utama: Cocokkan persis nama lengkap (misal "Kota Semarang" atau "Kabupaten Semarang")
                        $kabObj = Kabupaten::where('provinsi_id', $provObj->id)
                            ->whereRaw('LOWER(name) = ?', [strtolower(trim($kabNama))])
                            ->first();

                        // 2. Jika input adalah Kota, cocokkan dengan "Kota <nama>"
                        if (!$kabObj && $isKotaInput) {
                            $kabObj = Kabupaten::where('provinsi_id', $provObj->id)
                                ->whereRaw('LOWER(name) = ?', ['kota ' . strtolower($cleanedKab)])
                                ->first();
                        }

                        // 3. Jika input bukan Kota, coba cocokkan dengan "Kabupaten <nama>"
                        if (!$kabObj && !$isKotaInput) {
                            $kabObj = Kabupaten::where('provinsi_id', $provObj->id)
                                ->whereRaw('LOWER(name) = ?', ['kabupaten ' . strtolower($cleanedKab)])
                                ->first();
                        }

                        // 4. Fallback nama bersih
                        if (!$kabObj) {
                            $kabObj = Kabupaten::where('provinsi_id', $provObj->id)
                                ->where(function ($q) use ($cleanedKab) {
                                    $q->whereRaw('LOWER(name) = ?', [strtolower($cleanedKab)])
                                      ->orWhere('name', 'LIKE', "%{$cleanedKab}%");
                                })->first();
                        }
                    }

                    // Jika belum ketemu di provinsinya, cari di seluruh data master kabupaten
                    if (!$kabObj && $cleanedKab) {
                        if ($isKotaInput) {
                            $kabObj = Kabupaten::whereRaw('LOWER(name) = ?', ['kota ' . strtolower($cleanedKab)])->first();
                        } else {
                            $kabObj = Kabupaten::whereRaw('LOWER(name) = ?', ['kabupaten ' . strtolower($cleanedKab)])->first();
                        }
                        if (!$kabObj) {
                            $kabObj = Kabupaten::whereRaw('LOWER(name) = ?', [strtolower($cleanedKab)])->first();
                        }
                    }

                    if ($kabObj) {
                        $matchedMasterCount++;
                    } else {
                        $newKabCount++;
                        $kabObj = Kabupaten::create([
                            'provinsi_id' => $provObj ? $provObj->id : null,
                            'name' => ucwords(strtolower($cleanedKab ?: $kabNama)),
                            'latitude' => null,
                            'longitude' => null
                        ]);
                    }
                }

                $mutasiVal = isset($colIndex['mutasi']) && isset($row[$colIndex['mutasi']]) ? trim($row[$colIndex['mutasi']]) : null;
                $publikasiVal = isset($colIndex['publikasi']) && isset($row[$colIndex['publikasi']]) ? trim($row[$colIndex['publikasi']]) : null;

                // Simpan Data Uji Resistensi
                DataUjiResistensi::create([
                    'provinsi_id' => $provObj ? $provObj->id : null,
                    'kabupaten_id' => $kabObj ? $kabObj->id : null,
                    'address' => $alamat ?: null,
                    'mosquito_type' => $nyamuk,
                    'insecticide' => $insektisida,
                    'method' => $metode,
                    'sample_count' => max(1, $sampel),
                    'status' => $status,
                    'mutation' => $mutasiVal ?: null,
                    'publication' => $publikasiVal ?: null,
                    'month' => $bulan,
                    'year' => $tahun,
                    'no' => (string)($importedCount + 1)
                ]);

                $importedCount++;
            }
        }

        $message = "Berhasil mengimpor {$importedCount} data uji resistensi ke sistem SIMPEL BBLKL.";
        if ($matchedMasterCount > 0) {
            $message .= " ({$matchedMasterCount} data kabupaten berhasil disinkronkan dengan data master).";
        }
        if ($newKabCount > 0) {
            $message .= " ({$newKabCount} kabupaten baru ditambahkan ke master wilayah).";
        }

        return redirect()->route('input', ['bulan' => 'Semua', 'tahun' => 'Semua'])->with('success', $message);
    }
}
