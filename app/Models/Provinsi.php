<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nama_provinsi',
    ];

    protected $appends = [
        'nama_provinsi',
    ];

    /**
     * Mutator untuk kolom 'name' (standar Laravel)
     */
    public function setNameAttribute($value)
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
        $this->attributes['name'] = $val;
    }

    /**
     * Accessor untuk kolom 'name'
     */
    public function getNameAttribute($value)
    {
        $val = trim($value ?? ($this->attributes['name'] ?? ''));
        $lower = strtolower($val);
        if (str_starts_with($lower, 'dki ')) {
            return 'DKI ' . ucwords(substr($lower, 4));
        } elseif (str_starts_with($lower, 'di ')) {
            return 'DI ' . ucwords(substr($lower, 3));
        }
        return ucwords($lower);
    }

    /**
     * Kompatibilitas alias 'nama_provinsi'
     */
    public function getNamaProvinsiAttribute()
    {
        return $this->name;
    }

    public function setNamaProvinsiAttribute($value)
    {
        $this->setNameAttribute($value);
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