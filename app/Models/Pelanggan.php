<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari default "pelanggans"
    protected $table = 'pelanggans';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'no_hp',
        'email',
    ];

    // Jika ingin relasi dengan tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
