<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kompetensi_keahlian extends Model
{
    protected $table = 'kompetensi_keahlian';

    protected $fillable = [
        'nama_kompetensi',
        'deskripsi',
    ];

}
