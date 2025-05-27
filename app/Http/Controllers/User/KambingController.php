<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kambing;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;

class KambingController extends Controller
{
    // Tampilkan semua kambing ke halaman user
    public function index()
    {
        $kambings = Kambing::all();
        return view('user.kambing.kambing', compact('kambings'));
    }

    // Tambah kambing ke keranjang
    public function tambahKeKeranjang($id)
    {
        $kambing = Kambing::findOrFail($id);

        Keranjang::create([
            'user_id'    => Auth::id(),
            'kambing_id' => $kambing->id,
            'jumlah'     => 1,
        ]);

        return back()->with('success', 'Kambing berhasil ditambahkan ke keranjang.');
    }

    // Arahkan user ke halaman checkout dengan metode yang dipilih
    public function beli(Request $request, $id)
    {
        $request->validate([
            'metode_bayar' => 'required|in:qris,transfer,cod',
        ]);

        $kambing = Kambing::findOrFail($id);
        $metode  = $request->metode_bayar;

        return redirect()->route('user.checkout', [
            'id'     => $kambing->id,
            'metode' => $metode,
        ]);
    }
}
