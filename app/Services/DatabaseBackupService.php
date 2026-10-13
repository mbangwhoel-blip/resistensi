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
    public function createBackup(bool $compress = true): array
    {
        $dbName = config('database.connections.mysql.database', 'db_simpel');
        $tables = DB::select('SHOW TABLES');
        $tableKey = "Tables_in_{$dbName}";

        $timestamp = date('Y-m-d_His');
        $baseFilename = "backup_resistensi_{$timestamp}";
        $sqlFilename = "{$baseFilename}.sql";
        $sqlPath = $this->backupDir . DIRECTORY_SEPARATOR . $sqlFilename;

        $sqlDump = "-- =====================================================\n";
        $sqlDump .= "-- SIMPEL BBLKL Database Backup\n";
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
