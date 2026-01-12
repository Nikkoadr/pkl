<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Esertifikat extends Model
{
    protected $table = 'esertifikat';

    protected $fillable = [
        'peserta_pkl_id',
        'nomor_sertifikat',
        'tanggal_diterbitkan',
    ];

    public function peserta_pkl()
    {
        return $this->belongsTo(Peserta_pkl::class);
    }

    public function nilai_pkl()
    {
        return $this->hasOneThrough(
            Nilai_pkl::class,
            Peserta_pkl::class,
            'id',
            'peserta_pkl_id',
            'peserta_pkl_id',
            'id'
        );
    }

    protected static function booted()
    {
        static::saving(function ($esertifikat) {
            if ($esertifikat->isDirty('nomor_sertifikat')) {
                $esertifikat->hash = hash(
                    'sha256',
                    $esertifikat->nomor_sertifikat . config('app.key')
                );
            }
        });
    }
}
