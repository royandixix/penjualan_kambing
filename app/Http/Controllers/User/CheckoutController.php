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
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'items' => 'required|array|min:1',
            'metode_bayar' => 'required|string|in:cod,qris,transfer',
            'bukti_bayar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Validasi bukti bayar jika metode perlu
        if (in_array($request->metode_bayar, ['qris', 'transfer']) && !$request->hasFile('bukti_bayar')) {
            return back()->withErrors(['bukti_bayar' => 'Silakan upload bukti pembayaran.'])->withInput();
        }

        $keranjang = session('keranjang', []);
        $items = $request->items;
        $user = Auth::user();
        $total = 0;

        // Upload bukti bayar jika ada
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
            if (isset($keranjang[$id])) {
                $item = $keranjang[$id];

                $kambing = Kambing::find($id);
                if (!$kambing) continue;

                // Validasi stok
                if ($kambing->stok <= 0) {
                    return back()->withErrors(['stok' => "Stok kambing {$kambing->jenis_kambing} habis!"]);
                }

                // Buat detail pesanan
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'kambing_id' => $id,
                    'jumlah' => 1,
                    'subtotal' => $item['harga'],
                ]);

                // Kurangi stok
                $kambing->stok = $kambing->stok - 1;
                $kambing->save();

                $total += $item['harga'];
                unset($keranjang[$id]); // hapus dari keranjang
            }
        }

        // Update total harga pesanan
        $pesanan->update(['total_harga' => $total]);

        // Update atau tambah data pelanggan
        Pelanggan::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama' => $user->name,
                'email' => $user->email,
                'no_hp' => $user->no_hp,
                'alamat' => $user->alamat ?? '-',
            ]
        );

        // Kosongkan keranjang dari item yang diproses
        session(['keranjang' => $keranjang]);

        return redirect()->route('user.keranjang.index')->with('success', 'Checkout berhasil dan stok otomatis berkurang.');
    }
}
