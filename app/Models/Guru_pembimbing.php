<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru_pembimbing extends Model
{
    protected $table = 'guru_pembimbing';

    protected $guarded = [];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
    public function dudi()
    {
        return $this->belongsTo(Dudi::class);
    }
}
