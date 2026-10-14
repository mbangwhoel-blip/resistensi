<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriUji extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'name',
        'description',
        'is_active',
        // Alias kompatibilitas
        'kategori',
        'nama',
        'keterangan',
    ];

    protected $appends = [
        'kategori',
        'nama',
        'keterangan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getKategoriAttribute()
    {
        return $this->attributes['category'] ?? null;
    }

    public function setKategoriAttribute($value)
    {
        $this->attributes['category'] = $value;
    }

    public function getNamaAttribute()
    {
        return $this->attributes['name'] ?? null;
    }

    public function setNamaAttribute($value)
    {
        $this->attributes['name'] = $value;
    }

    public function getKeteranganAttribute()
    {
        return $this->attributes['description'] ?? null;
    }

    public function setKeteranganAttribute($value)
    {
        $this->attributes['description'] = $value;
    }

    public function scopeNyamuk($query)
    {
        return $query->where('category', 'nyamuk');
    }

    public function scopeInsektisida($query)
    {
        return $query->where('category', 'insektisida');
    }

    public function scopeMetode($query)
    {
        return $query->where('category', 'metode');
    }

    public function getKategoriLabelAttribute()
    {
        $cat = $this->category ?? $this->kategori;
        return match ($cat) {
            'nyamuk' => 'Jenis Nyamuk',
            'insektisida' => 'Insektisida',
            'metode' => 'Metode Pengendalian',
            default => ucfirst($cat ?? ''),
        };
    }

    /**
     * Cari atau daftarkan parameter baru ke master data secara otomatis
     */
    public static function firstOrCreateCategory(string $category, string $name, ?string $description = null)
    {
        $cleanName = trim($name);
        if ($cleanName === '') {
            return null;
        }

        $existing = self::where('category', $category)
            ->whereRaw('LOWER(name) = ?', [strtolower($cleanName)])
            ->first();

        if ($existing) {
            return $existing;
        }

        return self::create([
            'category' => $category,
            'name' => $cleanName,
            'description' => $description ?: 'Ditambahkan otomatis dari sistem pengujian laboratorium',
            'is_active' => true,
        ]);
    }
}
