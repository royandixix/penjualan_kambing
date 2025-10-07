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
    /**
     * Menyimpan checkout dan detail pesanan
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'items' => 'required|array|min:1',
            'metode_bayar' => 'required|string|in:cod,qris,transfer',
            'bukti_bayar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Validasi bukti bayar jika metode QRIS atau Transfer
        if (in_array($request->metode_bayar, ['qris', 'transfer']) && !$request->hasFile('bukti_bayar')) {
            return back()->withErrors(['bukti_bayar' => 'Silakan upload bukti pembayaran.'])->withInput();
        }

        $keranjang = session('keranjang', []);
        $items = $request->items;
        $user = Auth::user();
        $total = 0;

        // Upload bukti pembayaran
        $buktiPath = null;
        if ($request->hasFile('bukti_bayar')) {
            $buktiPath = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
        }

        // Simpan pesanan utama
        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'status' => 'menunggu',
            'metode_bayar' => $request->metode_bayar,
            'bukti_bayar' => $buktiPath,
            'total_harga' => 0,
            'tanggal_pesan' => now(),
        ]);

        // Simpan detail item pesanan & kurangi stok
        foreach ($items as $id) {
            if (!isset($keranjang[$id])) continue;

            $item = $keranjang[$id];
            $kambing = Kambing::find($id);
            if (!$kambing) continue;

            // Validasi stok
            if ($kambing->stok <= 0) {
                return back()->withErrors(['stok' => "Stok kambing {$kambing->jenis_kambing} habis!"]);
            }

            // Simpan detail pesanan
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'kambing_id' => $id,
                'jumlah' => 1,
                'subtotal' => $item['harga'],
            ]);

            // Kurangi stok kambing
            $kambing->stok -= 1;
            $kambing->save();

            $total += $item['harga'];

            // Hapus item dari keranjang session
            unset($keranjang[$id]);
        }

        // Update total harga pesanan
        $pesanan->update(['total_harga' => $total]);

        // Simpan atau update data pelanggan
        Pelanggan::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama' => $user->name,
                'email' => $user->email,
                'no_hp' => $user->no_hp,
                'alamat' => $user->alamat ?? '-',
            ]
        );

        // Update session keranjang
        session(['keranjang' => $keranjang]);

        return redirect()->route('user.keranjang.index')
                         ->with('success', 'Checkout berhasil! Stok kambing otomatis berkurang.');
    }
}
