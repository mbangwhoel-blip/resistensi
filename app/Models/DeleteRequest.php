<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeleteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_uji_resistensi_id',
        'reason',
        'alasan',
        'status',
    ];

    protected $appends = [
        'alasan',
    ];

    public function getAlasanAttribute()
    {
        return $this->attributes['reason'] ?? ($this->attributes['alasan'] ?? null);
    }

    public function setAlasanAttribute($value)
    {
        $this->attributes['reason'] = $value;
    }

    public function dataUjiResistensi()
    {
        return $this->belongsTo(
            DataUjiResistensi::class,
            'data_uji_resistensi_id'
        );
    }
}