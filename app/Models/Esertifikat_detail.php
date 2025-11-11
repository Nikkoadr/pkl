<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Esertifikat_detail extends Model
{
    protected $fillable = [
        'esertifikat_id',
        'nilai_disiplin_kerja',
        'nilai_kemajuan_kerja',
        'nilai_kualitas_kerja',
        'nilai_inisiatif_kreatifitas',
        'nilai_perilaku',
        'nilai_sidang_pkl',
        'komentar',
    ];

    public function esertifikat()
    {
        return $this->belongsTo(Esertifikat::class);
    }
}
