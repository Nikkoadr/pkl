<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    protected $table = 'logbook';
    protected $guarded = [];
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function dudi()
    {
        return $this->belongsTo(Dudi::class);
    }
    public function guru_pembimbing()
    {
        return $this->hasOne(Guru_pembimbing::class, 'dudi_id', 'dudi_id');
    }
}
