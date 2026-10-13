<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Alamat Email Penerima Backup
    |--------------------------------------------------------------------------
    | File backup dan laporan status otomatis akan dikirimkan ke alamat email
    | berikut setiap pukul 01.00 WIB.
    */
    'email' => env('BACKUP_EMAIL', 'mbang.whoel@gmail.com'),

    /*
    |--------------------------------------------------------------------------
    | Retensi File Backup Lokal (Hari)
    |--------------------------------------------------------------------------
    | File backup di server lokal yang lebih lama dari jumlah hari ini akan
    | dihapus otomatis agar penyimpanan server hosting tidak penuh.
    */
    'retention_days' => (int) env('BACKUP_RETENTION_DAYS', 14),

    /*
    |--------------------------------------------------------------------------
    | Kompresi ZIP
    |--------------------------------------------------------------------------
    | Mengompres file .sql ke file .zip agar ukuran lebih ringkas dan hemat bandwidth.
    */
    'compress' => (bool) env('BACKUP_COMPRESS_ZIP', true),

    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Google Drive API (Service Account)
    |--------------------------------------------------------------------------
    | Menyimpan file backup secara otomatis ke folder Google Drive.
    | Cukup letakkan file service-account.json di storage/app/google/
    | dan isi ID folder tujuan di GOOGLE_DRIVE_FOLDER_ID.
    */
    'google_drive' => [
        'enable' => (bool) env('GOOGLE_DRIVE_ENABLE', false),
        'folder_id' => env('GOOGLE_DRIVE_FOLDER_ID', ''),
        'service_account_json' => env('GOOGLE_DRIVE_SERVICE_ACCOUNT_JSON', storage_path('app/google/service-account.json')),
    ],
];
