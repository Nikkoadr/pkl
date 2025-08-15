<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    protected $table = 'logbook';
    protected $guarded = [];
    function peserta_pkl()
    {
        return $this->belongsTo(Peserta_pkl::class);
    }

}
