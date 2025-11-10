<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function kaprodi()
    {
        return $this->hasOne(Kaprodi::class, 'guru_id');
    }
    public function guru_pembimbing()
    {
        return $this->hasMany(Guru_pembimbing::class, 'guru_id');
    }
}
