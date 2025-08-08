<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai_pkl extends Model
{
    protected $table = 'nilai_pkl';
    protected $guarded = [];

    function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
}
