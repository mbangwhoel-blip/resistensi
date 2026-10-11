<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUjiResistensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'month',
        'year',
        'provinsi_id',
        'kabupaten_id',
        'province_id',
        'regency_id',
        'address',
        'mosquito_type',
        'insecticide',
        'method',
        'sample_count',
        'status',
        'mutation',
        'publication',
        // Alias backward-compatibility
        'bulan',
        'tahun',
        'alamat',
        'jenis_nyamuk',
        'insektisida',
        'metode',
        'sampel_diperiksa',
        'mutasi',
        'publikasi',
    ];

    protected $appends = [
        'bulan',
        'tahun',
        'alamat',
        'jenis_nyamuk',
        'insektisida',
        'metode',
        'sampel_diperiksa',
        'mutasi',
        'publikasi',
    ];

    // =========================================================================
    // KOMPATIBILITAS ALIAS (DUAL-SUPPORT BRIDGE)
    // =========================================================================

    public function getBulanAttribute()
    {
        return $this->attributes['month'] ?? ($this->attributes['bulan'] ?? null);
    }

    public function setBulanAttribute($value)
    {
        $this->attributes['month'] = $value;
    }

    public function getTahunAttribute()
    {
        return $this->attributes['year'] ?? ($this->attributes['tahun'] ?? null);
    }

    public function setTahunAttribute($value)
    {
        $this->attributes['year'] = $value;
    }

    public function getAlamatAttribute()
    {
        return $this->attributes['address'] ?? ($this->attributes['alamat'] ?? null);
    }

    public function setAlamatAttribute($value)
    {
        $this->attributes['address'] = $value;
    }

    public function getJenisNyamukAttribute()
    {
        return $this->attributes['mosquito_type'] ?? ($this->attributes['jenis_nyamuk'] ?? null);
    }

    public function setJenisNyamukAttribute($value)
    {
        $this->attributes['mosquito_type'] = $value;
    }

    public function getInsektisidaAttribute()
    {
        return $this->attributes['insecticide'] ?? ($this->attributes['insektisida'] ?? null);
    }

    public function setInsektisidaAttribute($value)
    {
        $this->attributes['insecticide'] = $value;
    }

    public function getMetodeAttribute()
    {
        return $this->attributes['method'] ?? ($this->attributes['metode'] ?? null);
    }

    public function setMetodeAttribute($value)
    {
        $this->attributes['method'] = $value;
    }

    public function getSampelDiperiksaAttribute()
    {
        return $this->attributes['sample_count'] ?? ($this->attributes['sampel_diperiksa'] ?? null);
    }

    public function setSampelDiperiksaAttribute($value)
    {
        $this->attributes['sample_count'] = $value;
    }

    public function getMutasiAttribute()
    {
        return $this->attributes['mutation'] ?? ($this->attributes['mutasi'] ?? null);
    }

    public function setMutasiAttribute($value)
    {
        $this->attributes['mutation'] = $value;
    }

    public function getPublikasiAttribute()
    {
        return $this->attributes['publication'] ?? ($this->attributes['publikasi'] ?? null);
    }

    public function setPublikasiAttribute($value)
    {
        $this->attributes['publication'] = $value;
    }

    public function getProvinceIdAttribute()
    {
        return $this->attributes['provinsi_id'] ?? null;
    }

    public function setProvinceIdAttribute($value)
    {
        $this->attributes['provinsi_id'] = $value;
    }

    public function getRegencyIdAttribute()
    {
        return $this->attributes['kabupaten_id'] ?? null;
    }

    public function setRegencyIdAttribute($value)
    {
        $this->attributes['kabupaten_id'] = $value;
    }

    /**
     * Accessor agar format status selalu konsisten berawalan kapital (Resisten, Rentan, Toleran)
     */
    public function getStatusAttribute($value)
    {
        $raw = $value ?? ($this->attributes['status'] ?? null);
        if (!$raw) return null;
        $val = strtolower(trim($raw));
        if (in_array($val, ['toleran', 'terduga resisten', 'terduga', 'toleran/terduga resisten'])) {
            return 'Toleran';
        }
        return ucfirst($val);
    }

    /**
     * Mutator agar status selalu disimpan sesuai standar ('resisten', 'rentan', 'toleran')
     */
    public function setStatusAttribute($value)
    {
        if (!$value) {
            $this->attributes['status'] = 'rentan';
            return;
        }

        $val = strtolower(trim($value));
        if (in_array($val, ['toleran', 'terduga resisten', 'terduga', 'toleran/terduga resisten', 'toleran / terduga resisten'])) {
            $this->attributes['status'] = 'toleran';
        } elseif ($val === 'resisten') {
            $this->attributes['status'] = 'resisten';
        } elseif ($val === 'rentan') {
            $this->attributes['status'] = 'rentan';
        } else {
            $this->attributes['status'] = 'toleran';
        }
    }

    // =========================================================================
    // RELASI
    // =========================================================================

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function province()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }

    public function regency()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }
}