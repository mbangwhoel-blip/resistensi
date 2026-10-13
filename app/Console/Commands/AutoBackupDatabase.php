<?php

namespace App\Console\Commands;

use App\Mail\BackupNotificationMail;
use App\Services\DatabaseBackupService;
use App\Services\GoogleDriveService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AutoBackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:auto {--no-email : Lewati pengiriman email} {--no-gdrive : Lewati upload ke Google Drive}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Buat backup database otomatis, unggah ke Google Drive, dan kirimkan ke email penerima';

    /**
     * Execute the console command.
     */
    public function handle(DatabaseBackupService $backupService, GoogleDriveService $gdriveService): int
    {
        $this->info('=====================================================');
        $this->info('SIMPEL BBLKL - Eksekusi Backup Database Otomatis');
        $this->info('Waktu: ' . date('Y-m-d H:i:s') . ' WIB');
        $this->info('=====================================================');

        try {
            // 1. Eksekusi Backup Database
            $this->info('1. Membuat dump basis data dan mengompresi file...');
            $backupInfo = $backupService->createBackup(config('backup.compress', true));

            $this->info("   ✓ Berkas dibuat: {$backupInfo['final_filename']}");
            $this->info("   ✓ Ukuran berkas: {$backupInfo['formatted_size']}");
            $this->info("   ✓ Total tabel: {$backupInfo['tables_count']} tabel | Data: {$backupInfo['rows_count']} baris");

            Log::info("Backup database berhasil dibuat: {$backupInfo['final_filename']} ({$backupInfo['formatted_size']})");

            // 2. Unggah ke Google Drive (jika aktif)
            $gdriveResult = [
                'success' => false,
                'status' => 'skipped',
                'message' => 'Upload ke Google Drive dinonaktifkan',
            ];

            if (!$this->option('no-gdrive')) {
                $this->info('2. Memproses unggah ke Google Drive...');
                $gdriveResult = $gdriveService->uploadFile($backupInfo['final_path']);

                if ($gdriveResult['success']) {
                    $this->info("   ✓ Berhasil diunggah ke Google Drive! ID: " . ($gdriveResult['file_id'] ?? '-'));
                } else {
                    $this->warn("   ℹ Info Google Drive: " . ($gdriveResult['message'] ?? 'Belum aktif'));
                }
            } else {
                $this->info('2. Upload Google Drive dilewati (--no-gdrive).');
            }

            // 3. Kirimkan Notifikasi dan Lampiran ke Email
            if (!$this->option('no-email')) {
                $recipient = config('backup.email');
                if (!empty($recipient)) {
                    $this->info("3. Mengirimkan berkas backup ke email: {$recipient}...");
                    try {
                        Mail::to($recipient)->send(new BackupNotificationMail($backupInfo, $gdriveResult));
                        $this->info("   ✓ Email berhasil dikirimkan ke {$recipient}");
                        Log::info("Backup database berhasil dikirimkan ke email {$recipient}");
                    } catch (\Throwable $mailEx) {
                        $this->error("   ✕ Gagal mengirimkan email: " . $mailEx->getMessage());
                        Log::warning("Gagal mengirim email backup ke {$recipient}: " . $mailEx->getMessage());
                    }
                } else {
                    $this->warn('3. Alamat email penerima (BACKUP_EMAIL) belum disetel di .env.');
                }
            } else {
                $this->info('3. Pengiriman email dilewati (--no-email).');
            }

            $this->info('=====================================================');
            $this->info('Proses backup otomatis selesai dengan sukses!');
            $this->info('=====================================================');

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Terjadi kesalahan saat memproses backup otomatis: ' . $e->getMessage());
            Log::error('Kesalahan backup otomatis: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return Command::FAILURE;
        }
    }
}
