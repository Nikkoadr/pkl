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
    ];

    public function tempatPkl()
    {
        return $this->hasMany(Tempat_pkl::class);
    }
}
