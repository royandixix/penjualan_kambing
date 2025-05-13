<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = ['user_id', 'tanggal_pesan', 'status', 'total_harga'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function detail_pesanans() {
        return $this->hasMany(DetailPesanan::class);
    }
}