<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $fillable = ['pesanan_id', 'kambing_id', 'jumlah', 'subtotal'];

    public function pesanan() {
        return $this->belongsTo(Pesanan::class);
    }

    public function kambing() {
        return $this->belongsTo(Kambing::class);
    }
}
