<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dudi extends Model
{
    protected $table = 'dudi';

    protected $fillable = [
        'nomor_kepegawaian',
        'nama_dudi',
        'alamat_dudi',
        'no_telp_dudi',
        'nama_pimpinan_dudi',
        'kuota',
        'jabatan_pimpinan',
        'kompetensi_keahlian_id',
    ];

    public function peserta_pkl()
    {
        return $this->hasMany(Peserta_pkl::class);
    }

    public function kompetensi_keahlian()
    {
        return $this->belongsTo(Kompetensi_keahlian::class, 'kompetensi_keahlian_id');
    }
}
