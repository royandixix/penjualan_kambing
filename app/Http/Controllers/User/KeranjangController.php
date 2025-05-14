<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kambing;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        return view('user.keranjang.keranjang');

    }

    public function tambah(Request $request, $id)
    {
        $kambing = Kambing::findOrFail($id);

        $keranjang = session()->get('keranjang', []);
        $keranjang[$id] = [
            "nama" => $kambing->nama,
            "harga" => $kambing->harga,
            "foto" => $kambing->foto,
        ];
        session()->put('keranjang', $keranjang);

        return redirect()->back()->with('success', 'Kambing berhasil ditambahkan ke keranjang!');

        
    }
}
