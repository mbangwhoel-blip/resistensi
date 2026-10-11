<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    protected $fillable = [
        'provinsi_id',
        'province_id',
        'name',
        'nama_kabupaten',
        'latitude',
        'longitude',
    ];

    protected $appends = [
        'nama_kabupaten',
        'province_id',
    ];

    /**
     * Mutator untuk kolom 'name' (standar Laravel)
     */
    public function setNameAttribute($value)
    {
        $val = trim($value ?? '');
        $val = ucwords(strtolower($val));
        $val = preg_replace_callback('/-([a-z])/', function ($matches) {
            return '-' . strtoupper($matches[1]);
        }, $val);
        $this->attributes['name'] = $val;
    }

    /**
     * Accessor untuk kolom 'name'
     */
    public function getNameAttribute($value)
    {
        $val = trim($value ?? ($this->attributes['name'] ?? ''));
        $val = ucwords(strtolower($val));
        $val = preg_replace_callback('/-([a-z])/', function ($matches) {
            return '-' . strtoupper($matches[1]);
        }, $val);
        return $val;
    }

    /**
     * Kompatibilitas alias 'nama_kabupaten'
     */
    public function getNamaKabupatenAttribute()
    {
        return $this->name;
    }

    public function setNamaKabupatenAttribute($value)
    {
        $this->setNameAttribute($value);
    }

    public function getProvinceIdAttribute()
    {
        return $this->attributes['provinsi_id'] ?? null;
    }

    public function setProvinceIdAttribute($value)
    {
        $this->attributes['provinsi_id'] = $value;
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function province()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function dataUjiResistensi()
    {
        return $this->hasMany(DataUjiResistensi::class);
    }
}