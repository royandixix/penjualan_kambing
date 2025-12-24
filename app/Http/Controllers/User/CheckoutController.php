<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Pelanggan;
use App\Models\Kambing;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{


    public function index(Request $request)
    {
        $keranjang = session('keranjang', []);
        $items = Kambing::whereIn('id', array_keys($keranjang))->get();

        return view('user.checkout.index', [
            'items' => $items
        ]);
    }

    /**
     * Menyimpan checkout dan detail pesanan
     */
   public function store(Request $request)
{
    $request->validate([
        'items' => 'required|array|min:1',
        'metode_bayar' => 'required|string|in:cod,qris,transfer',
        'bukti_bayar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    if (in_array($request->metode_bayar, ['qris', 'transfer']) && !$request->hasFile('bukti_bayar')) {
        return back()->withErrors(['bukti_bayar' => 'Silakan upload bukti pembayaran.'])->withInput();
    }

    $keranjang = session('keranjang', []);
    $items = $request->items;
    $user = Auth::user();
    $total = 0;

    $buktiPath = null;
    if ($request->hasFile('bukti_bayar')) {
        $buktiPath = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
    }

    $pesanan = Pesanan::create([
        'user_id' => $user->id,
        'status' => 'menunggu',
        'metode_bayar' => $request->metode_bayar,
        'bukti_bayar' => $buktiPath,
        'total_harga' => 0,
        'tanggal_pesan' => now(),
    ]);

    foreach ($items as $id => $itemData) {
        if (!isset($keranjang[$id])) continue;

        $item = $keranjang[$id];
        $kambing = Kambing::find($id);
        if (!$kambing) continue;

        $qty = intval($itemData['quantity'] ?? 1);

        if ($kambing->stok < $qty) {
            return back()->withErrors(['stok' => "Stok kambing {$kambing->jenis_kambing} tidak cukup!"]);
        }

        DetailPesanan::create([
            'pesanan_id' => $pesanan->id,
            'kambing_id' => $id,
            'jumlah' => $qty,
            'subtotal' => $item['harga'] * $qty,
        ]);

        $kambing->stok -= $qty;
        $kambing->save();

        $total += $item['harga'] * $qty;

        unset($keranjang[$id]);
    }

    $pesanan->update(['total_harga' => $total]);

    Pelanggan::updateOrCreate(
        ['user_id' => $user->id],
        [
            'nama' => $user->name,
            'email' => $user->email,
            'no_hp' => $user->no_hp,
            'alamat' => $user->alamat ?? '-',
        ]
    );

    session(['keranjang' => $keranjang]);

    return redirect()->route('user.keranjang.index')
        ->with('success', 'Checkout berhasil! Stok kambing otomatis berkurang.');
}

}
