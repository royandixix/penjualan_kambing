<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $fillable = [
        'pesanan_id',
        'kambing_id',
        'jumlah',
        'subtotal',
        'harga_satuan',
        'bukti_bayar',
    ];

    // Relasi ke tabel pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    // Relasi ke tabel kambing
    public function kambing()
    {
        return $this->belongsTo(Kambing::class);
    }
}
