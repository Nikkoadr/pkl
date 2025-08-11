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

}
