<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit_code',
        'category',
        'provinsi_id',
        'kabupaten_id',
        'address',
        'phone',
        'email',
        'person_in_charge',
        // Alias kompatibilitas
        'nama_instansi',
        'kode_unit',
        'kategori',
        'alamat',
        'telepon',
        'penanggung_jawab',
    ];

    protected $appends = [
        'nama_instansi',
        'kode_unit',
        'kategori',
        'alamat',
        'telepon',
        'penanggung_jawab',
    ];

    public function getNamaInstansiAttribute()
    {
        return $this->attributes['name'] ?? null;
    }

    public function setNamaInstansiAttribute($value)
    {
        $this->attributes['name'] = $value;
    }

    public function getKodeUnitAttribute()
    {
        return $this->attributes['unit_code'] ?? null;
    }

    public function setKodeUnitAttribute($value)
    {
        $this->attributes['unit_code'] = $value;
    }

    public function getKategoriAttribute()
    {
        return $this->attributes['category'] ?? null;
    }

    public function setKategoriAttribute($value)
    {
        $this->attributes['category'] = $value;
    }

    public function getAlamatAttribute()
    {
        return $this->attributes['address'] ?? null;
    }

    public function setAlamatAttribute($value)
    {
        $this->attributes['address'] = $value;
    }

    public function getTeleponAttribute()
    {
        return $this->attributes['phone'] ?? null;
    }

    public function setTeleponAttribute($value)
    {
        $this->attributes['phone'] = $value;
    }

    public function getPenanggungJawabAttribute()
    {
        return $this->attributes['person_in_charge'] ?? null;
    }

    public function setPenanggungJawabAttribute($value)
    {
        $this->attributes['person_in_charge'] = $value;
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }
}
