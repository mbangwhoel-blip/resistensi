<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BackupNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $backupInfo;
    public array $gdriveInfo;

    /**
     * Create a new message instance.
     */
    public function __construct(array $backupInfo, array $gdriveInfo = [])
    {
        $this->backupInfo = $backupInfo;
        $this->gdriveInfo = $gdriveInfo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $date = date('d M Y');
        return new Envelope(
            subject: "[SIMPEL BBLKL] Laporan Backup Database Otomatis - {$date}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.backup_notification',
            with: [
                'backup' => $this->backupInfo,
                'gdrive' => $this->gdriveInfo,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        $filePath = $this->backupInfo['final_path'] ?? null;

        // Lampirkan file backup jika ada dan ukuran di bawah batas email (20 MB)
        if ($filePath && file_exists($filePath)) {
            $fileSize = filesize($filePath);
            $maxAttachmentSize = 20 * 1024 * 1024; // 20 MB

            if ($fileSize <= $maxAttachmentSize) {
                $attachments[] = Attachment::fromPath($filePath)
                    ->as($this->backupInfo['final_filename'] ?? basename($filePath));
            }
        }

        return $attachments;
    }
}
