<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahun_ajaran extends Model
{
    protected $table = 'tahun_ajaran';
    protected $fillable = ['nama_tahun_ajaran', 'status'];
}
