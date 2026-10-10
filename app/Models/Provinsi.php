<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_provinsi',
    ];

    public function setNamaProvinsiAttribute($value)
    {
        $val = trim($value ?? '');
        $lower = strtolower($val);
        if (str_starts_with($lower, 'dki ')) {
            $val = 'DKI ' . ucwords(substr($lower, 4));
        } elseif (str_starts_with($lower, 'di ')) {
            $val = 'DI ' . ucwords(substr($lower, 3));
        } else {
            $val = ucwords($lower);
        }
        $this->attributes['nama_provinsi'] = $val;
    }

    public function getNamaProvinsiAttribute($value)
    {
        $val = trim($value ?? '');
        $lower = strtolower($val);
        if (str_starts_with($lower, 'dki ')) {
            return 'DKI ' . ucwords(substr($lower, 4));
        } elseif (str_starts_with($lower, 'di ')) {
            return 'DI ' . ucwords(substr($lower, 3));
        }
        return ucwords($lower);
    }

    public function kabupatens()
    {
        return $this->hasMany(Kabupaten::class);
    }

    public function dataUjiResistensi()
    {
        return $this->hasMany(DataUjiResistensi::class);
    }
}