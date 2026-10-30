<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use ZipArchive;

class DatabaseBackupService
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
     * Generate SQL dump and optional ZIP archive.
     */
    public function createBackup(bool $compress = true, string $prefix = 'admin'): array
    {
        $dbName = config('database.connections.mysql.database', 'db_simpel');
        $tables = DB::select('SHOW TABLES');
        $tableKey = "Tables_in_{$dbName}";

        $timestamp = date('Y-m-d_His');
        $cleanPrefix = preg_replace('/[^a-zA-Z0-9_\-]/', '_', strtolower(trim($prefix)));
        $cleanPrefix = trim(preg_replace('/_+/', '_', (string)$cleanPrefix), '_') ?: 'admin';
        $baseFilename = "backup_resistensi_{$cleanPrefix}_{$timestamp}";
        $sqlFilename = "{$baseFilename}.sql";
        $sqlPath = $this->backupDir . DIRECTORY_SEPARATOR . $sqlFilename;

        $sqlDump = "-- =====================================================\n";
        $sqlDump .= "-- PETA RESISTENSI Database Backup\n";
        $sqlDump .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
        $sqlDump .= "-- Database: {$dbName}\n";
        $sqlDump .= "-- =====================================================\n\n";
        $sqlDump .= "SET FOREIGN_KEY_CHECKS = 0;\n";
        $sqlDump .= "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n\n";

        $totalTables = 0;
        $totalRows = 0;

        foreach ($tables as $tableObj) {
            $tableName = $tableObj->$tableKey ?? reset($tableObj);
            if (!$tableName) {
                continue;
            }

            $totalTables++;

            // Create Table DDL
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $createTableSql = $createTable[0]->{'Create Table'} ?? '';

            $sqlDump .= "-- -----------------------------------------------------\n";
            $sqlDump .= "-- Table structure for `{$tableName}`\n";
            $sqlDump .= "-- -----------------------------------------------------\n";
            $sqlDump .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sqlDump .= $createTableSql . ";\n\n";

            // Rows
            $rows = DB::table($tableName)->get();
            $totalRows += $rows->count();

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

        File::put($sqlPath, $sqlDump);
        $rawSqlSize = filesize($sqlPath);

        $zipFilename = null;
        $zipPath = null;
        $finalPath = $sqlPath;
        $finalFilename = $sqlFilename;
        $finalSize = $rawSqlSize;

        if ($compress && class_exists(ZipArchive::class)) {
            $zipFilename = "{$baseFilename}.zip";
            $zipPath = $this->backupDir . DIRECTORY_SEPARATOR . $zipFilename;

            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $zip->addFile($sqlPath, $sqlFilename);
                $zip->close();

                if (file_exists($zipPath)) {
                    $finalPath = $zipPath;
                    $finalFilename = $zipFilename;
                    $finalSize = filesize($zipPath);
                }
            }
        }

        // Clean older backups based on retention days
        $this->cleanOldBackups(config('backup.retention_days', 14));

        return [
            'sql_filename' => $sqlFilename,
            'sql_path' => $sqlPath,
            'sql_size' => $rawSqlSize,
            'zip_filename' => $zipFilename,
            'zip_path' => $zipPath,
            'final_filename' => $finalFilename,
            'final_path' => $finalPath,
            'final_size' => $finalSize,
            'formatted_size' => $this->formatBytes($finalSize),
            'tables_count' => $totalTables,
            'rows_count' => $totalRows,
            'database' => $dbName,
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * Generate SQL dump and optional ZIP archive for a specific user's data only.
     */
    public function createUserDataBackup(int $userId, string $userIdentifier, bool $compress = true): array
    {
        $dbName = config('database.connections.mysql.database', 'db_simpel');
        $timestamp = date('Y-m-d_His');
        $cleanIdentifier = preg_replace('/[^a-zA-Z0-9_\-]/', '_', strtolower(trim($userIdentifier)));
        $cleanIdentifier = trim(preg_replace('/_+/', '_', (string)$cleanIdentifier), '_') ?: "user_{$userId}";

        $baseFilename = "backup_resistensi_{$cleanIdentifier}_{$timestamp}";
        $sqlFilename = "{$baseFilename}.sql";
        $sqlPath = $this->backupDir . DIRECTORY_SEPARATOR . $sqlFilename;

        $rows = DB::table('data_uji_resistensis')->where('user_id', $userId)->get();
        $totalRows = $rows->count();

        $recordsJson = json_encode($rows->map(function ($r) {
            $arr = (array)$r;
            unset($arr['id']);
            return $arr;
        })->toArray());

        $sqlDump = "-- =====================================================\n";
        $sqlDump .= "-- PETA RESISTENSI User Data Backup\n";
        $sqlDump .= "-- Scope: User Data Only (data_uji_resistensis)\n";
        $sqlDump .= "-- User ID: {$userId}\n";
        $sqlDump .= "-- User Identifier: {$cleanIdentifier}\n";
        $sqlDump .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
        $sqlDump .= "-- Database: {$dbName}\n";
        $sqlDump .= "-- Total Records: {$totalRows}\n";
        $sqlDump .= "-- DATA_JSON_START\n";
        $sqlDump .= "-- " . base64_encode($recordsJson) . "\n";
        $sqlDump .= "-- DATA_JSON_END\n";
        $sqlDump .= "-- =====================================================\n\n";

        if ($totalRows > 0) {
            $first = (array)$rows[0];
            $columns = array_keys($first);
            $colList = implode('`, `', $columns);

            $sqlDump .= "-- -----------------------------------------------------\n";
            $sqlDump .= "-- Data for `data_uji_resistensis` (Scoped to user_id = {$userId})\n";
            $sqlDump .= "-- -----------------------------------------------------\n";

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
                $sqlDump .= "INSERT INTO `data_uji_resistensis` (`{$colList}`) VALUES (" . implode(', ', $values) . ");\n";
            }
            $sqlDump .= "\n";
        } else {
            $sqlDump .= "-- Catatan: Tidak ada data uji resistensi untuk user_id = {$userId}\n";
        }

        File::put($sqlPath, $sqlDump);
        $rawSqlSize = filesize($sqlPath);

        $zipFilename = null;
        $zipPath = null;
        $finalPath = $sqlPath;
        $finalFilename = $sqlFilename;
        $finalSize = $rawSqlSize;

        if ($compress && class_exists(ZipArchive::class)) {
            $zipFilename = "{$baseFilename}.zip";
            $zipPath = $this->backupDir . DIRECTORY_SEPARATOR . $zipFilename;

            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $zip->addFile($sqlPath, $sqlFilename);
                $zip->close();

                if (file_exists($zipPath)) {
                    $finalPath = $zipPath;
                    $finalFilename = $zipFilename;
                    $finalSize = filesize($zipPath);
                }
            }
        }

        // Bersihkan backup lawas jika ada
        $this->cleanOldBackups(config('backup.retention_days', 14));

        return [
            'sql_filename' => $sqlFilename,
            'sql_path' => $sqlPath,
            'sql_size' => $rawSqlSize,
            'zip_filename' => $zipFilename,
            'zip_path' => $zipPath,
            'final_filename' => $finalFilename,
            'final_path' => $finalPath,
            'final_size' => $finalSize,
            'formatted_size' => $this->formatBytes($finalSize),
            'tables_count' => 1,
            'rows_count' => $totalRows,
            'user_id' => $userId,
            'user_identifier' => $cleanIdentifier,
            'database' => $dbName,
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * Restore user data into data_uji_resistensis without affecting other users or master tables.
     */
    public function restoreUserData(string $sqlContent, int $userId): int
    {
        $restoredCount = 0;

        // 1. Coba decode data JSON terstruktur yang tertanam dalam komentar SQL
        if (preg_match('/-- DATA_JSON_START\s*\n--\s*([a-zA-Z0-9+\/=\s]+)\n-- DATA_JSON_END/s', $sqlContent, $matches)) {
            $base64Data = preg_replace('/\s+/', '', $matches[1]);
            $json = base64_decode($base64Data);
            $records = json_decode($json, true);

            if (is_array($records)) {
                DB::transaction(function () use ($records, $userId, &$restoredCount) {
                    // Hapus data lama milik user ini sebelum memulihkan backup
                    DB::table('data_uji_resistensis')->where('user_id', $userId)->delete();
                    $now = date('Y-m-d H:i:s');
                    foreach ($records as $row) {
                        $data = (array)$row;
                        unset($data['id']);
                        $data['user_id'] = $userId;
                        if (empty($data['created_at'])) $data['created_at'] = $now;
                        if (empty($data['updated_at'])) $data['updated_at'] = $now;
                        DB::table('data_uji_resistensis')->insert($data);
                        $restoredCount++;
                    }
                });
                return $restoredCount;
            }
        }

        // 2. Fallback: Parse INSERT INTO statements untuk data_uji_resistensis
        preg_match_all('/INSERT\s+INTO\s+[`\']?data_uji_resistensis[`\']?\s*(\([^\)]+\))?\s*VALUES\s*\(([^\;]+)\);/i', $sqlContent, $insertMatches, PREG_SET_ORDER);
        if (!empty($insertMatches)) {
            DB::transaction(function () use ($insertMatches, $userId, &$restoredCount) {
                DB::table('data_uji_resistensis')->where('user_id', $userId)->delete();
                foreach ($insertMatches as $m) {
                    $colPart = trim($m[1] ?? '');
                    $valPart = trim($m[2] ?? '');
                    if (!empty($colPart)) {
                        DB::statement("INSERT INTO `data_uji_resistensis` {$colPart} VALUES ({$valPart})");
                        $lastId = DB::getPdo()->lastInsertId();
                        if ($lastId) {
                            DB::table('data_uji_resistensis')->where('id', $lastId)->update(['user_id' => $userId]);
                        }
                        $restoredCount++;
                    }
                }
            });
            return $restoredCount;
        }

        throw new \RuntimeException('Tidak ditemukan catatan data uji resistensi yang valid di dalam berkas backup ini.');
    }

    /**
     * Clean old backups older than given days.
     */
    public function cleanOldBackups(int $retentionDays = 14): int
    {
        if ($retentionDays <= 0) {
            return 0;
        }

        $deletedCount = 0;
        $cutoff = time() - ($retentionDays * 86400);

        $files = File::files($this->backupDir);
        foreach ($files as $file) {
            $ext = strtolower($file->getExtension());
            if (in_array($ext, ['sql', 'zip', 'gz']) && $file->getMTime() < $cutoff) {
                File::delete($file->getPathname());
                $deletedCount++;
            }
        }

        return $deletedCount;
    }

    /**
     * Format bytes to readable string.
     */
    public function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
