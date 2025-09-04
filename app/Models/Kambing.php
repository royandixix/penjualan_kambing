<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kambing extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_kambing',
        'umur',
        'berat',
        'jenis_kelamin',
        'harga',
        'stok',   // harus sesuai nama kolom di DB
        'foto',
        'deskripsi',
        'metode_bayar',
    ];
    
    // Relasi: satu kambing punya banyak detail pesanan
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    // Relasi many-to-many ke pesanan (via tabel pivot detail_pesanans)
    public function pesanans()
    {
        return $this->belongsToMany(Pesanan::class, 'detail_pesanans')
                    ->withPivot('jumlah', 'subtotal');
    }

    
}
