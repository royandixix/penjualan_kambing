<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kambing;
use Illuminate\Support\Facades\Auth;

class KambingController extends Controller
{
    /**
     * Tampilkan semua kambing ke halaman user
     */
    public function index()
    {
        $kambings = Kambing::all();
        return view('user.kambing.kambing', compact('kambings'));
    }

    /**
     * Tambah kambing ke keranjang (menggunakan session)
     */
    public function tambahKeKeranjang(Request $request, $id)
    {
        $kambing = Kambing::findOrFail($id);

        // Ambil keranjang dari session
        $keranjang = session('keranjang', []);

        // Jika item sudah ada di keranjang, tambah quantity
        if (isset($keranjang[$id])) {
            $keranjang[$id]['quantity'] += 1;
        } else {
            $keranjang[$id] = [
                'id' => $kambing->id,
                'nama' => $kambing->nama,
                'harga' => $kambing->harga,
                'quantity' => 1,
            ];
        }

        session(['keranjang' => $keranjang]);

        return back()->with('success', "Kambing '{$kambing->nama}' berhasil ditambahkan ke keranjang.");
    }

    /**
     * Beli sekarang: arahkan ke checkout
     */
    public function beli(Request $request, $id)
    {
        $request->validate([
            'metode_bayar' => 'required|in:qris,transfer,cod',
        ]);

        $kambing = Kambing::findOrFail($id);

        // Masukkan item ke keranjang session sementara
        $keranjang = session('keranjang', []);
        $keranjang[$id] = [
            'id' => $kambing->id,
            'nama' => $kambing->nama,
            'harga' => $kambing->harga,
            'quantity' => 1,
        ];
        session(['keranjang' => $keranjang]);

        // Arahkan ke halaman checkout
        return redirect()->route('user.checkout.index')
            ->with('success', "Siap melakukan checkout '{$kambing->nama}'");
    }
}
