<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUjiResistensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'bulan',
        'tahun',
        'provinsi_id',
        'kabupaten_id',
        'alamat',
        'jenis_nyamuk',
        'insektisida',
        'metode',
        'sampel_diperiksa',
        'status',
        'mutasi',
        'publikasi',
    ];

    /**
     * Accessor agar format status selalu konsisten berawalan kapital (Resisten, Rentan, Toleran)
     */
    public function getStatusAttribute($value)
    {
        if (!$value) return null;
        $val = strtolower(trim($value));
        if (in_array($val, ['toleran', 'terduga resisten', 'terduga', 'toleran/terduga resisten'])) {
            return 'Toleran';
        }
        return ucfirst($val);
    }

    /**
     * Mutator agar status selalu disimpan sesuai enum MySQL ('resisten', 'rentan', 'toleran')
     * dan otomatis menyatukan isian terduga resisten ke kolom toleran
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

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
}