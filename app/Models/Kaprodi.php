<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kaprodi extends Model
{
    protected $table = 'kaprodi';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kompetensi_keahlian()
    {
        return $this->belongsTo(Kompetensi_keahlian::class, 'kompetensi_keahlian_id');
    }
}
