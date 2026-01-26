<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai_pkl extends Model
{
    protected $table = 'nilai_pkl';
    protected $guarded = [];

    function peserta_pkl()
    {
        return $this->belongsTo(Peserta_pkl::class);
    }

    public function esertifikat()
    {
        return $this->hasOne(Esertifikat::class, 'peserta_pkl_id', 'peserta_pkl_id');
    }
}
