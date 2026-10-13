<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GoogleDriveService
{
    protected Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'timeout' => 120,
            'http_errors' => false,
        ]);
    }

    /**
     * Check if Google Drive backup is enabled.
     */
    public function isEnabled(): bool
    {
        return (bool) config('backup.google_drive.enable', false);
    }

    /**
     * Get path to Service Account JSON credentials.
     */
    public function getCredentialsPath(): string
    {
        $path = config('backup.google_drive.service_account_json');
        if (!$path) {
            $path = storage_path('app/google/service-account.json');
        }
        return $path;
    }

    /**
     * Check if Service Account JSON credentials file exists and is valid.
     */
    public function isConfigured(): bool
    {
        $path = $this->getCredentialsPath();
        if (!file_exists($path)) {
            return false;
        }

        $json = json_decode(file_get_contents($path), true);
        return is_array($json) && !empty($json['client_email']) && !empty($json['private_key']);
    }

    /**
     * Upload a local file to Google Drive.
     */
    public function uploadFile(string $filePath, ?string $customFilename = null): array
    {
        if (!$this->isEnabled()) {
            return [
                'success' => false,
                'status' => 'disabled',
                'message' => 'Integrasi Google Drive dinonaktifkan (GOOGLE_DRIVE_ENABLE=false)',
            ];
        }

        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'status' => 'not_configured',
                'message' => 'Berkas kredensial Google Service Account tidak ditemukan di ' . $this->getCredentialsPath(),
            ];
        }

        if (!file_exists($filePath)) {
            return [
                'success' => false,
                'status' => 'file_not_found',
                'message' => 'File yang akan diunggah tidak ditemukan: ' . $filePath,
            ];
        }

        try {
            $accessToken = $this->getAccessToken();
            $filename = $customFilename ?: basename($filePath);
            $folderId = config('backup.google_drive.folder_id');

            $metadata = [
                'name' => $filename,
            ];
            if (!empty($folderId)) {
                $metadata['parents'] = [$folderId];
            }

            $mimeType = mime_content_type($filePath) ?: 'application/octet-stream';

            $multipart = [
                [
                    'name' => 'metadata',
                    'contents' => json_encode($metadata),
                    'headers' => ['Content-Type' => 'application/json; charset=UTF-8'],
                ],
                [
                    'name' => 'file',
                    'contents' => fopen($filePath, 'r'),
                    'headers' => ['Content-Type' => $mimeType],
                ],
            ];

            $response = $this->httpClient->post('https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink,size,createdTime', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'multipart' => $multipart,
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode((string) $response->getBody(), true);

            if ($statusCode >= 200 && $statusCode < 300 && isset($body['id'])) {
                Log::info("Google Drive upload success: {$filename} (ID: {$body['id']})");
                return [
                    'success' => true,
                    'status' => 'uploaded',
                    'message' => 'Berhasil diunggah ke Google Drive',
                    'file_id' => $body['id'],
                    'web_view_link' => $body['webViewLink'] ?? null,
                    'name' => $body['name'] ?? $filename,
                ];
            }

            $errorMsg = $body['error']['message'] ?? 'Kode respon: ' . $statusCode;
            Log::warning("Google Drive upload failed: {$errorMsg}");

            return [
                'success' => false,
                'status' => 'upload_error',
                'message' => 'Gagal mengunggah ke Google Drive: ' . $errorMsg,
            ];
        } catch (\Throwable $e) {
            Log::error('Google Drive upload exception: ' . $e->getMessage());
            return [
                'success' => false,
                'status' => 'exception',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Generate OAuth2 access token from Service Account credentials using RS256 JWT.
     */
    protected function getAccessToken(): string
    {
        $credPath = $this->getCredentialsPath();
        $creds = json_decode(file_get_contents($credPath), true);

        if (empty($creds['client_email']) || empty($creds['private_key'])) {
            throw new \Exception('Invalid Service Account credentials format.');
        }

        $now = time();
        $tokenUri = $creds['token_uri'] ?? 'https://oauth2.googleapis.com/token';

        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $claims = [
            'iss' => $creds['client_email'],
            'scope' => 'https://www.googleapis.com/auth/drive.file https://www.googleapis.com/auth/drive',
            'aud' => $tokenUri,
            'exp' => $now + 3600,
            'iat' => $now,
        ];

        $encodedHeader = $this->base64UrlEncode(json_encode($header));
        $encodedClaims = $this->base64UrlEncode(json_encode($claims));
        $payload = $encodedHeader . '.' . $encodedClaims;

        $signature = '';
        $privateKey = openssl_pkey_get_private($creds['private_key']);
        if (!$privateKey) {
            throw new \Exception('Private key service account tidak valid atau tidak dapat dibaca.');
        }

        if (!openssl_sign($payload, $signature, $privateKey, OPENSSL_ALGO_SHA256)) {
            throw new \Exception('Gagal membuat digital signature JWT Google Service Account.');
        }

        $jwt = $payload . '.' . $this->base64UrlEncode($signature);

        $response = $this->httpClient->post($tokenUri, [
            'form_params' => [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ],
        ]);

        $body = json_decode((string) $response->getBody(), true);
        if (empty($body['access_token'])) {
            throw new \Exception('Gagal memperoleh access token dari Google: ' . ($body['error_description'] ?? 'Unknown error'));
        }

        return $body['access_token'];
    }

    /**
     * URL-safe Base64 encode.
     */
    protected function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
