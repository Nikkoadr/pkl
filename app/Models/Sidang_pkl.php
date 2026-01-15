<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sidang_pkl extends Model
{
    protected $table = 'sidang_pkl';

    protected $guarded = [];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function peserta_pkl()
    {
        return $this->belongsTo(Peserta_pkl::class);
    }
}
