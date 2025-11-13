<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta_pkl extends Model
{
    protected $table = 'peserta_pkl';

    protected $guarded = [];

    public function dudi()
    {
        return $this->belongsTo(Dudi::class);
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function nilai_pkl()
    {
        return $this->hasOne(Nilai_pkl::class);
    }

    public function esertifikat()
    {
        return $this->hasOne(Esertifikat::class);
    }
}
