<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function tahun_ajaran()
    {
        return $this->belongsTo(Tahun_ajaran::class, 'tahun_ajaran_id');
    }
    public function peserta_pkl()
    {
        return $this->hasOne(Peserta_pkl::class);
    }
    public function dudi()
    {
        return $this->belongsTo(Dudi::class);
    }
}
