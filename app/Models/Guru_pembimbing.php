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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function kompetensi_keahlian()
    {
        return $this->belongsTo(Kompetensi_keahlian::class);
    }
}
