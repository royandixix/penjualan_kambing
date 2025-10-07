<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kambing;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    /**
     * Menampilkan halaman keranjang
     */
    public function index()
    {
        return view('user.keranjang.keranjang');
    }

    /**
     * Menampilkan halaman checkout
     */
    public function checkout()
    {
        $keranjang = session('keranjang', []);
        $total = array_sum(array_column($keranjang, 'harga'));

        return view('user.checkout', compact('keranjang', 'total'));
    }

    /**
     * Menambahkan kambing ke keranjang
     */
    public function tambah(Request $request, $id)
{
    $kambing = Kambing::findOrFail($id);

    $keranjang = session()->get('keranjang', []);
    $keranjang[$id] = [
    'nama' => $kambing->nama,
    'harga' => $kambing->harga,
    'foto' => $kambing->foto,
    'jenis_kambing' => $kambing->jenis_kambing ?? '-',
    'berat' => $kambing->berat ?? 0,
    'umur' => $kambing->umur ?? 0,
    'alamat' => $kambing->alamat ?? '-',
    'jumlah' => $keranjang[$id]['jumlah'] ?? 1, // default 1
];


    session()->put('keranjang', $keranjang);

    return redirect()->back()->with('success', 'Kambing berhasil ditambahkan ke keranjang!');
}


    /**
     * Menghapus item dari keranjang
     */
    public function hapus($id)
    {
        $keranjang = session()->get('keranjang');

        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);
        }

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
