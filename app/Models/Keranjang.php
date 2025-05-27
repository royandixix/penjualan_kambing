<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $fillable = [
        'user_id',
        'kambing_id',
        'jumlah',
    ];

    public function kambing()
    {
        return $this->belongsTo(Kambing::class);
    }
}
