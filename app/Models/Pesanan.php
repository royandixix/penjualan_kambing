<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal_pesan',
        'status',
        'total_harga',
        'metode_bayar',
        'bukti_bayar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }
    
    

    public function kambings()
    {
        return $this->belongsToMany(Kambing::class, 'detail_pesanans')
                    ->withPivot('jumlah', 'subtotal', 'harga_satuan');
    }

    public function getTotalHargaFormattedAttribute()
    {
        return 'Rp' . number_format($this->total_harga, 0, ',', '.');
    }
}
