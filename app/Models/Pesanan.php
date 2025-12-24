<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal_pesan',
        'status',
        'total_harga',
        'metode_bayar',
        'bukti_bayar', // bukti bayar ada di pesanan
    ];

    /**
     * Pastikan tanggal_pesan otomatis menjadi Carbon instance
     */
    protected $casts = [
        'tanggal_pesan' => 'datetime',
    ];

    /**
     * Relasi ke user (pelanggan)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke detail pesanan
     */
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    /**
     * Relasi ke kambing melalui detail pesanan
     */
    public function kambings()
    {
        return $this->belongsToMany(Kambing::class, 'detail_pesanans')
                    ->withPivot('jumlah', 'subtotal', 'harga_satuan');
    }

    /**
     * Format total harga menjadi Rupiah
     */
    public function getTotalHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }
}
