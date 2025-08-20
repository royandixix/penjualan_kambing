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
        'bukti_bayar', // ✅ bukti bayar ada di pesanan
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke detail pesanan
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    // Relasi ke kambing (melalui detail_pesanans)
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
