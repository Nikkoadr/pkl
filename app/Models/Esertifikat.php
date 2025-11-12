<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Esertifikat extends Model
{
    protected $table = 'esertifikat';

    protected $fillable = [
        'nilai_pkl_id',
        'peserta_pkl_id',
        'nomor_sertifikat',
        'tanggal_diterbitkan',
    ];

    public function detail()
    {
        return $this->hasOne(Esertifikat_detail::class);
    }

    public function nilai_pkl()
    {
        return $this->belongsTo(Nilai_pkl::class);
    }
    public function peserta_pkl()
    {
        return $this->belongsTo(Peserta_pkl::class);
    }
}
