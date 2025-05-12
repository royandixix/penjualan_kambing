<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Kambing extends Model
{
    protected $fillable = [
        'nama',
        'umur',
        'berat',
        'jenis_kelamin',
        'harga',
        'foto',
        'deskripsi',
    ];

}
