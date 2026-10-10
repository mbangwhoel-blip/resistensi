<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriUji extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori',
        'nama',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeNyamuk($query)
    {
        return $query->where('kategori', 'nyamuk');
    }

    public function scopeInsektisida($query)
    {
        return $query->where('kategori', 'insektisida');
    }

    public function scopeMetode($query)
    {
        return $query->where('kategori', 'metode');
    }

    public function getKategoriLabelAttribute()
    {
        return match ($this->kategori) {
            'nyamuk' => 'Jenis Nyamuk',
            'insektisida' => 'Insektisida',
            'metode' => 'Metode Pengendalian',
            default => ucfirst($this->kategori),
        };
    }
}
