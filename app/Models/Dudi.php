<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dudi extends Model
{
    protected $table = 'dudi';

    protected $fillable = [
        'nama',
        'alamat',
        'nama_pimpinan',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
