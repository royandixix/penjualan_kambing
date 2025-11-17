<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kambing extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_kambing',
        'kategori',
        'umur',
        'berat',
        'jenis_kelamin',
        'harga',
        'stok',
        'foto',
        'deskripsi',
    ];

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function pesanans()
    {
        return $this->belongsToMany(Pesanan::class, 'detail_pesanans')
            ->withPivot('jumlah', 'subtotal');
    }
}
