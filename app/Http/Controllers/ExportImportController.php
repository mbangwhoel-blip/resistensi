<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataUjiResistensi;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\KategoriUji;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportImportController extends Controller
{
    /**
     * Halaman Export Data
     */
    public function exportIndex(Request $request)
    {
        $bulanFilter = $request->get('bulan', 'Semua');
        $tahunFilter = $request->get('tahun', 'Semua');
        $nyamukFilter = $request->get('jenis_nyamuk', '');
        $provinsiFilter = $request->get('provinsi_id', '');
        $perPage = (int)$request->get('per_page', 25);
        if ($perPage <= 0 || $perPage > 200) $perPage = 25;

        $query = DataUjiResistensi::with(['provinsi', 'kabupaten'])->orderBy('id', 'desc');

        if ($bulanFilter && $bulanFilter !== 'Semua') {
            $query->where('bulan', $bulanFilter);
        }

        if ($tahunFilter && $tahunFilter !== 'Semua') {
            $query->where('tahun', (int)$tahunFilter);
        }

        if ($nyamukFilter && $nyamukFilter !== 'Semua') {
            $query->where('jenis_nyamuk', $nyamukFilter);
        }

        if ($provinsiFilter && $provinsiFilter !== 'Semua') {
            $query->where('provinsi_id', $provinsiFilter);
        }

        // Hitung statistik ringkasan dari query terfilter
        $statsQuery = clone $query;
        $totalSemua = (clone $statsQuery)->count();
        $totalSampel = (int)(clone $statsQuery)->sum('sampel_diperiksa');
        $totalResisten = (clone $statsQuery)->whereRaw('LOWER(status) = ?', ['resisten'])->count();
        $totalToleran = (clone $statsQuery)->where(function($q) {
            $q->whereRaw('LOWER(status) LIKE ?', ['%toleran%'])
              ->orWhereRaw('LOWER(status) LIKE ?', ['%terduga%']);
        })->count();
        $totalRentan = (clone $statsQuery)->whereRaw('LOWER(status) = ?', ['rentan'])->count();

        $dataPreview = $query->paginate($perPage)->withQueryString();

        $provinsis = Provinsi::orderBy('nama_provinsi')->get();

        // Ambil daftar tahun dinamis dari database
        $tahunDb = DataUjiResistensi::select('tahun')
            ->distinct()
            ->whereNotNull('tahun')
            ->pluck('tahun')
            ->map(fn($y) => (int)$y)
            ->filter(fn($y) => $y > 2000 && $y < 2100)
            ->toArray();
        $daftarTahun = array_values(array_unique(array_merge([(int)date('Y'), (int)date('Y') - 1], $tahunDb)));
        rsort($daftarTahun);

        // Ambil jenis nyamuk dinamis dari data pengujian
        $nyamukDb = DataUjiResistensi::select('jenis_nyamuk')
            ->distinct()
            ->whereNotNull('jenis_nyamuk')
            ->where('jenis_nyamuk', '!=', '')
            ->orderBy('jenis_nyamuk')
            ->pluck('jenis_nyamuk')
            ->toArray();
        $daftarNyamuk = !empty($nyamukDb) ? $nyamukDb : KategoriUji::where('kategori', 'jenis_nyamuk')->pluck('nama')->toArray();

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
            'perPage'
        ));
    }

    /**
     * Download Hasil Export (CSV / Excel / JSON)
     */
    public function exportDownload(Request $request)
    {
        $format = $request->get('format', 'csv');
        $bulanFilter = $request->get('bulan', 'Semua');
        $tahunFilter = $request->get('tahun', 'Semua');
        $nyamukFilter = $request->get('jenis_nyamuk', '');
        $provinsiFilter = $request->get('provinsi_id', '');

        $query = DataUjiResistensi::with(['provinsi', 'kabupaten'])->orderBy('id', 'asc');

        if ($bulanFilter && $bulanFilter !== 'Semua') {
            $query->where('bulan', $bulanFilter);
        }
        if ($tahunFilter && $tahunFilter !== 'Semua') {
            $query->where('tahun', (int)$tahunFilter);
        }
        if ($nyamukFilter && $nyamukFilter !== 'Semua') {
            $query->where('jenis_nyamuk', $nyamukFilter);
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

        // Export CSV / Excel Compatible
        $fileName = "export_uji_resistensi_{$timestamp}.csv";

        return new StreamedResponse(function () use ($items) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM agar terbaca sempurna di Microsoft Excel (huruf tidak berantakan)
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
                // Cegah CSV Formula Injection jika nilai dimulai dengan karakter formula
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
        $totalData = DataUjiResistensi::count();
        $totalProvinsi = Provinsi::count();
        $totalKabupaten = Kabupaten::count();

        return view('import', compact('totalData', 'totalProvinsi', 'totalKabupaten'));
    }

    /**
     * Download Template CSV untuk Import
     */
    public function downloadTemplate()
    {
        $fileName = 'template_import_simpel_bblk.csv';

        return new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header kolom template sesuai format data resistensi (termasuk publikasi setelah toleran)
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
                'publikasi'
            ]);

            // Baris contoh 1 (Resisten)
            fputcsv($handle, [
                'Jawa Tengah',
                'Kudus',
                'Desa Mejobo, RT 02/RW 01',
                'Ae. aegypti',
                'Deltamethrin',
                'WHO Tube Bioassay',
                '90',
                'Oktober',
                '2026',
                'v',
                '',
                '',
                'Publikasi BBLK 2026'
            ]);

            // Baris contoh 2 (Rentan)
            fputcsv($handle, [
                'Bali',
                'Bangli',
                'Kintamani, Dusun Batur Utara',
                'Ae. aegypti',
                'Cypermethrin',
                'CDC bottle bioassay',
                '25',
                'Oktober',
                '2026',
                '',
                'v',
                '',
                'Jurnal Vektor Penyakit'
            ]);

            // Baris contoh 3 (Toleran - gabungan toleran & terduga resisten)
            fputcsv($handle, [
                'Gorontalo',
                'Boalemo',
                'Puskesmas Tilamuta',
                'Culex sp',
                'Malathion',
                'WHO Tube Bioassay',
                '50',
                'Oktober',
                '2026',
                '',
                '',
                'v',
                'Laporan Surveilans Dinkes'
            ]);

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
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
                    $provObj = Provinsi::where('nama_provinsi', 'LIKE', "%{$provNama}%")->first();
                    if (!$provObj) {
                        $provObj = Provinsi::create(['nama_provinsi' => ucwords(strtolower($provNama))]);
                        $allProvinsi->put(strtolower($provObj->nama_provinsi), $provObj);
                    }
                }

                // Normalisasi dan Pencocokan Kabupaten (abaikan tulisan "kab / kabupaten / kota")
                $cleanedKab = $this->cleanKabupatenName($kabNama);
                $kabObj = null;

                if ($cleanedKab || $kabNama) {
                    if ($provObj) {
                        $kabObj = Kabupaten::where('provinsi_id', $provObj->id)
                            ->where(function ($q) use ($cleanedKab, $kabNama) {
                                $q->whereRaw('LOWER(nama_kabupaten) = ?', [strtolower($cleanedKab)])
                                  ->orWhereRaw('LOWER(nama_kabupaten) = ?', [strtolower($kabNama)])
                                  ->orWhere('nama_kabupaten', 'LIKE', "%{$cleanedKab}%");
                            })->first();
                    }

                    // Jika belum ketemu di provinsinya, cari di seluruh data master kabupaten
                    if (!$kabObj && $cleanedKab) {
                        $kabObj = Kabupaten::whereRaw('LOWER(nama_kabupaten) = ?', [strtolower($cleanedKab)])->first();
                    }

                    if ($kabObj) {
                        $matchedMasterCount++;
                    } else {
                        $newKabCount++;
                        $kabObj = Kabupaten::create([
                            'provinsi_id' => $provObj ? $provObj->id : null,
                            'nama_kabupaten' => ucwords(strtolower($cleanedKab ?: $kabNama)),
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
                    'alamat' => $alamat ?: null,
                    'jenis_nyamuk' => $nyamuk,
                    'insektisida' => $insektisida,
                    'metode' => $metode,
                    'sampel_diperiksa' => max(1, $sampel),
                    'status' => $status,
                    'mutasi' => $mutasiVal ?: null,
                    'publikasi' => $publikasiVal ?: null,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
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
