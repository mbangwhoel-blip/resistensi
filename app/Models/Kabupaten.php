<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    protected $fillable = [
        'provinsi_id',
        'nama_kabupaten',
        'latitude',
        'longitude',
    ];

    public function setNamaKabupatenAttribute($value)
    {
        $val = trim($value ?? '');
        $val = ucwords(strtolower($val));
        $val = preg_replace_callback('/-([a-z])/', function ($matches) {
            return '-' . strtoupper($matches[1]);
        }, $val);
        $this->attributes['nama_kabupaten'] = $val;
    }

    public function getNamaKabupatenAttribute($value)
    {
        $val = trim($value ?? '');
        $val = ucwords(strtolower($val));
        $val = preg_replace_callback('/-([a-z])/', function ($matches) {
            return '-' . strtoupper($matches[1]);
        }, $val);
        return $val;
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function dataUjiResistensi()
    {
        return $this->hasMany(DataUjiResistensi::class);
    }
}