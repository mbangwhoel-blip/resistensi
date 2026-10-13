<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BackupRestoreController extends Controller
{
    protected string $backupDir;

    public function __construct()
    {
        $this->backupDir = storage_path('app/backups');
        if (!File::exists($this->backupDir)) {
            File::makeDirectory($this->backupDir, 0755, true);
        }
    }

    /**
     * Halaman Backup & Restore
     */
    public function index()
    {
        // Ambil daftar file backup yang ada
        $files = File::files($this->backupDir);
        $backups = [];

        foreach ($files as $file) {
            if (in_array(strtolower($file->getExtension()), ['sql', 'json', 'zip'])) {
                $backups[] = [
                    'filename' => $file->getFilename(),
                    'size' => $this->formatBytes($file->getSize()),
                    'raw_size' => $file->getSize(),
                    'created_at' => date('d M Y H:i:s', $file->getMTime()),
                    'timestamp' => $file->getMTime(),
                    'extension' => strtoupper($file->getExtension())
                ];
            }
        }

        // Urutkan backup terbaru di paling atas
        usort($backups, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        // Info ringkas database
        $stats = [
            'data_uji' => DB::table('data_uji_resistensis')->count(),
            'provinsi' => DB::table('provinsis')->count(),
            'kabupaten' => DB::table('kabupatens')->count(),
            'instansi' => DB::table('instansis')->count(),
            'kategori' => DB::table('kategori_ujis')->count(),
            'users' => DB::table('users')->count(),
            'db_name' => config('database.connections.mysql.database', 'db_simpel'),
            'db_driver' => 'MySQL 8.0 / MariaDB',
        ];

        return view('backup_restore', compact('backups', 'stats'));
    }

    /**
     * Buat Backup SQL Baru
     */
    public function createBackup(Request $request)
    {
        if (Auth::check() && Auth::user()->isViewer()) {
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak: Akun dengan role Viewer hanya memiliki izin melihat data (read-only).');
        }

        try {
            $tables = DB::select('SHOW TABLES');
            $dbName = config('database.connections.mysql.database', 'db_simpel');
            $tableKey = "Tables_in_{$dbName}";

            $sqlDump = "-- =====================================================\n";
            $sqlDump .= "-- SIMPEL BBLKL Database Backup\n";
            $sqlDump .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
            $sqlDump .= "-- Database: {$dbName}\n";
            $sqlDump .= "-- =====================================================\n\n";
            $sqlDump .= "SET FOREIGN_KEY_CHECKS = 0;\n";
            $sqlDump .= "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n\n";

            foreach ($tables as $tableObj) {
                $tableName = $tableObj->$tableKey ?? reset($tableObj);
                if (!$tableName) continue;

                // Create Table DDL
                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
                $createTableSql = $createTable[0]->{'Create Table'} ?? '';

                $sqlDump .= "-- -----------------------------------------------------\n";
                $sqlDump .= "-- Table structure for `{$tableName}`\n";
                $sqlDump .= "-- -----------------------------------------------------\n";
                $sqlDump .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $sqlDump .= $createTableSql . ";\n\n";

                // Table Rows
                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    $sqlDump .= "-- Data for `{$tableName}`\n";
                    foreach ($rows as $row) {
                        $values = [];
                        foreach ((array)$row as $val) {
                            if (is_null($val)) {
                                $values[] = 'NULL';
                            } elseif (is_numeric($val)) {
                                $values[] = $val;
                            } else {
                                $values[] = "'" . addslashes((string)$val) . "'";
                            }
                        }
                        $sqlDump .= "INSERT INTO `{$tableName}` VALUES (" . implode(', ', $values) . ");\n";
                    }
                    $sqlDump .= "\n";
                }
            }

            $sqlDump .= "SET FOREIGN_KEY_CHECKS = 1;\n";

            $filename = "backup_resistensi_" . date('Y-m-d_His') . ".sql";
            $filePath = $this->backupDir . DIRECTORY_SEPARATOR . $filename;

            File::put($filePath, $sqlDump);

            if ($request->has('download')) {
                return response()->download($filePath, $filename);
            }

            return redirect()->route('backup.index')->with('success', "Backup database berhasil dibuat: {$filename} (" . $this->formatBytes(strlen($sqlDump)) . ")");
        } catch (\Throwable $e) {
            return redirect()->route('backup.index')->with('error', "Gagal membuat backup: " . $e->getMessage());
        }
    }

    /**
     * Download File Backup yang Sudah Ada
     */
    public function downloadBackup($filename)
    {
        $cleanFilename = basename($filename);
        if (!preg_match('/^[a-zA-Z0-9_\-\.]+$/', $cleanFilename)) {
            abort(400, 'Format nama file backup tidak valid.');
        }

        $filePath = realpath($this->backupDir . DIRECTORY_SEPARATOR . $cleanFilename);
        $realBackupDir = realpath($this->backupDir);

        if (!$filePath || !$realBackupDir || !str_starts_with($filePath, $realBackupDir) || !File::exists($filePath)) {
            return redirect()->route('backup.index')->with('error', 'File backup tidak ditemukan atau akses ditolak.');
        }

        return response()->download($filePath, $cleanFilename);
    }

    /**
     * Hapus File Backup
     */
    public function deleteBackup($filename)
    {
        if (Auth::check() && Auth::user()->isViewer()) {
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak: Akun dengan role Viewer hanya memiliki izin melihat data (read-only).');
        }

        $cleanFilename = basename($filename);
        if (!preg_match('/^[a-zA-Z0-9_\-\.]+$/', $cleanFilename)) {
            abort(400, 'Format nama file backup tidak valid.');
        }

        $filePath = realpath($this->backupDir . DIRECTORY_SEPARATOR . $cleanFilename);
        $realBackupDir = realpath($this->backupDir);

        if (!$filePath || !$realBackupDir || !str_starts_with($filePath, $realBackupDir) || !File::exists($filePath)) {
            return redirect()->route('backup.index')->with('error', 'File backup tidak ditemukan atau akses ditolak.');
        }

        File::delete($filePath);
        return redirect()->route('backup.index')->with('success', "File backup {$cleanFilename} berhasil dihapus.");
    }

    /**
     * Jalankan Backup Otomatis Sekarang (Manual Trigger via Web)
     */
    public function runAutoBackupNow(Request $request, \App\Services\DatabaseBackupService $backupService, \App\Services\GoogleDriveService $gdriveService)
    {
        if (Auth::check() && Auth::user()->isViewer()) {
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak: Akun dengan role Viewer hanya memiliki izin melihat data (read-only).');
        }

        try {
            $backupInfo = $backupService->createBackup(config('backup.compress', true));
            $gdriveResult = $gdriveService->uploadFile($backupInfo['final_path']);

            $recipient = config('backup.email');
            $mailSent = false;
            $mailError = null;

            if ($recipient) {
                try {
                    \Illuminate\Support\Facades\Mail::to($recipient)->send(new \App\Mail\BackupNotificationMail($backupInfo, $gdriveResult));
                    $mailSent = true;
                } catch (\Throwable $mEx) {
                    $mailError = $mEx->getMessage();
                }
            }

            $msg = "Backup berhasil dibuat: {$backupInfo['final_filename']} ({$backupInfo['formatted_size']}).";
            if ($mailSent) {
                $msg .= " Berkas dan laporan berhasil dikirim ke email {$recipient}.";
            } elseif ($mailError) {
                $msg .= " Namun email gagal dikirim: {$mailError}";
            }

            if (!empty($gdriveResult['success'])) {
                $msg .= " Berhasil diunggah ke Google Drive.";
            }

            return redirect()->route('backup.index')->with('success', $msg);
        } catch (\Throwable $e) {
            return redirect()->route('backup.index')->with('error', 'Gagal memproses backup: ' . $e->getMessage());
        }
    }

    /**
     * Restore Database dari File SQL atau ZIP
     */
    public function restoreBackup(Request $request)
    {
        if (Auth::check() && Auth::user()->isViewer()) {
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak: Akun dengan role Viewer hanya memiliki izin melihat data (read-only).');
        }

        $request->validate([
            'backup_file' => 'required|file|max:51200' // max 50MB
        ]);

        $file = $request->file('backup_file');
        $ext = strtolower($file->getClientOriginalExtension());

        if (!in_array($ext, ['sql', 'zip'])) {
            return redirect()->route('backup.index')->with('error', 'File restore harus berupa format .sql atau .zip.');
        }

        try {
            $sqlContent = '';

            if ($ext === 'zip') {
                $zip = new \ZipArchive();
                if ($zip->open($file->getRealPath()) === true) {
                    for ($i = 0; $i < $zip->numFiles; $i++) {
                        $stat = $zip->statIndex($i);
                        if (str_ends_with(strtolower($stat['name']), '.sql')) {
                            $sqlContent = $zip->getFromIndex($i);
                            break;
                        }
                    }
                    $zip->close();
                }

                if (empty($sqlContent)) {
                    return redirect()->route('backup.index')->with('error', 'File .zip tidak memuat berkas SQL yang valid.');
                }
            } else {
                $sqlContent = file_get_contents($file->getRealPath());
            }

            // Eksekusi SQL
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
            DB::unprepared($sqlContent);
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

            return redirect()->route('backup.index')->with('success', 'Database berhasil dipulihkan (restore) secara penuh dari file: ' . $file->getClientOriginalName());
        } catch (\Throwable $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
            return redirect()->route('backup.index')->with('error', 'Gagal memulihkan database: ' . $e->getMessage());
        }
    }

    protected function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
