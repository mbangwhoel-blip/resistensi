<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Backup Database Otomatis</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0 0 6px 0;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .header p {
            margin: 0;
            font-size: 13px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .status-badge {
            display: inline-block;
            background: #ecfdf5;
            color: #065f46;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid #a7f3d0;
            margin-bottom: 20px;
        }
        .info-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
        }
        .info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .info-label {
            color: #64748b;
            font-weight: 500;
        }
        .info-value {
            color: #0f172a;
            font-weight: 600;
            text-align: right;
        }
        .btn {
            display: inline-block;
            background: #2563eb;
            color: #ffffff !important;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 10px;
        }
        .footer {
            background: #f8fafc;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 11px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PETA RESISTENSI</h1>
            <p>Sistem Informasi Monitoring Vektor & Resistensi Insektisida</p>
        </div>

        <div class="content">
            <div style="text-align: center;">
                <span class="status-badge">✓ Backup Database Berhasil Dibuat</span>
            </div>

            <p style="font-size: 14px; line-height: 1.5; margin-top: 0;">
                Halo Administrator,<br>
                Proses pencadangan (backup) otomatis basis data aplikasi Peta Resistensi telah selesai dieksekusi dengan rincian sebagai berikut:
            </p>

            <div class="info-card">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; font-weight: 500;">Nama Berkas</td>
                        <td style="padding: 8px 0; color: #0f172a; font-weight: 600; text-align: right; font-family: monospace;">{{ $backup['final_filename'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; font-weight: 500; border-top: 1px solid #f1f5f9;">Ukuran Berkas</td>
                        <td style="padding: 8px 0; color: #0f172a; font-weight: 600; text-align: right; border-top: 1px solid #f1f5f9;">{{ $backup['formatted_size'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; font-weight: 500; border-top: 1px solid #f1f5f9;">Database</td>
                        <td style="padding: 8px 0; color: #0f172a; font-weight: 600; text-align: right; border-top: 1px solid #f1f5f9;">{{ $backup['database'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; font-weight: 500; border-top: 1px solid #f1f5f9;">Total Tabel</td>
                        <td style="padding: 8px 0; color: #0f172a; font-weight: 600; text-align: right; border-top: 1px solid #f1f5f9;">{{ $backup['tables_count'] ?? 0 }} Tabel</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; font-weight: 500; border-top: 1px solid #f1f5f9;">Total Data (Baris)</td>
                        <td style="padding: 8px 0; color: #0f172a; font-weight: 600; text-align: right; border-top: 1px solid #f1f5f9;">{{ number_format($backup['rows_count'] ?? 0) }} Baris</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; font-weight: 500; border-top: 1px solid #f1f5f9;">Waktu Selesai</td>
                        <td style="padding: 8px 0; color: #0f172a; font-weight: 600; text-align: right; border-top: 1px solid #f1f5f9;">{{ $backup['created_at'] ?? date('Y-m-d H:i:s') }} WIB</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; font-weight: 500; border-top: 1px solid #f1f5f9;">Status Google Drive</td>
                        <td style="padding: 8px 0; font-weight: 600; text-align: right; border-top: 1px solid #f1f5f9;">
                            @if (!empty($gdrive['success']))
                                <span style="color: #059669;">✓ Berhasil Terunggah</span>
                            @else
                                <span style="color: #64748b;">{{ $gdrive['message'] ?? 'Tidak diaktifkan' }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            @if (!empty($gdrive['web_view_link']))
                <div style="text-align: center; margin: 20px 0;">
                    <a href="{{ $gdrive['web_view_link'] }}" target="_blank" class="btn">
                        Buka File di Google Drive
                    </a>
                </div>
            @endif

            <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 12px 16px; font-size: 12px; color: #1e40af;">
                💡 <strong>Catatan:</strong> Berkas backup telah dilampirkan langsung pada email ini (dalam format arsip .ZIP terkompresi). Anda dapat langsung mengunduh dan menyimpannya sebagai arsip cadangan.
            </div>
        </div>

        <div class="footer">
            Pesan ini dikirim secara otomatis oleh penjadwal tugas Peta Resistensi (Pukul 01.00 WIB).<br>
            © {{ date('Y') }} Balai Besar Laboratorium Kesehatan Lingkungan (BBLKL). All rights reserved.
        </div>
    </div>
</body>
</html>
