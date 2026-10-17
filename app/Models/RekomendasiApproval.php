<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiApproval extends Model
{
    use HasFactory;

    protected $table = 'rekomendasi_approvals';

    protected $fillable = [
        'doc_hash',
        'filter_scope',
        'template',
        'tahun',
        'jenis_nyamuk',
        'provinsi_id',
        'kabupaten_id',
        'nama_wilayah',
        'status',
        'user_id',
        'approver_name',
        'approver_nip',
        'approver_jabatan',
        'nomor_surat',
        'notes',
        'verification_token',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isApproved(): bool
    {
        return strtolower((string)$this->status) === 'approved';
    }

    /**
     * Hitung Doc Hash untuk spesifik template & filter
     */
    public static function makeDocHash(string $tahun, string $jenisNyamuk, $provinsiId, $kabupatenId, string $template): string
    {
        $payload = sprintf(
            'th:%s|ny:%s|pr:%s|kb:%s|tmpl:%s',
            trim((string)$tahun),
            strtolower(trim((string)$jenisNyamuk)),
            trim((string)$provinsiId),
            trim((string)$kabupatenId),
            strtolower(trim((string)$template))
        );
        return md5($payload);
    }

    /**
     * Hitung Scope Hash untuk kombinasi filter wilayah/tahun/spesies
     */
    public static function makeScopeHash(string $tahun, string $jenisNyamuk, $provinsiId, $kabupatenId): string
    {
        $payload = sprintf(
            'th:%s|ny:%s|pr:%s|kb:%s',
            trim((string)$tahun),
            strtolower(trim((string)$jenisNyamuk)),
            trim((string)$provinsiId),
            trim((string)$kabupatenId)
        );
        return md5($payload);
    }

    /**
     * Cari status approval yang aktif untuk filter & template ini
     */
    public static function findActiveApproval(string $tahun, string $jenisNyamuk, $provinsiId, $kabupatenId, string $template = 'kemenkes')
    {
        $docHash = self::makeDocHash($tahun, $jenisNyamuk, $provinsiId, $kabupatenId, $template);
        $scopeHash = self::makeScopeHash($tahun, $jenisNyamuk, $provinsiId, $kabupatenId);

        return self::where(function ($q) use ($docHash, $scopeHash) {
            $q->where('doc_hash', $docHash)
              ->orWhere(function ($sub) use ($scopeHash) {
                  $sub->where('filter_scope', $scopeHash)->where('template', 'all');
              });
        })
        ->where('status', 'approved')
        ->latest('approved_at')
        ->first();
    }
}
