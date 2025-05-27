<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal_pesan',
        'status',
        'total_harga', // ← field ini
        'metode_bayar', 
        'bukti_bayar',
    ];
    
    // Relasi ke User (pembeli)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke detail pesanans (1 pesanan memiliki banyak detail)
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
        
    }

    // Relasi many-to-many ke kambing lewat tabel pivot detail_pesanans
    public function kambings()
    {
        return $this->belongsToMany(Kambing::class, 'detail_pesanans')
                    ->withPivot('jumlah', 'subtotal');
    }
    
}
