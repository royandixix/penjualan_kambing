<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Kambing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Notifications\PesananDibuat;
use App\Notifications\PesananUserNotification;
use Carbon\Carbon;

class PesananController extends Controller
{
    /**
     * Halaman checkout untuk user
     */
    public function showCheckout($id, Request $request)
    {
        $metode = $request->metode_bayar;

        if (!$metode) {
            return redirect()->back()->with('error', 'Pilih metode pembayaran terlebih dahulu.');
        }

        $kambing = Kambing::findOrFail($id);

        return view('user.checkout.kambing', compact('kambing', 'metode'));
    }

    /**
     * Proses pembelian kambing oleh user
     */
    public function beli(Request $request, $id)
    {
        $request->validate([
            'metode_bayar' => 'required|in:qris,transfer,cod',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $kambing = Kambing::findOrFail($id);

        // Buat pesanan utama
        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'tanggal_pesan' => Carbon::now(),
            'status' => 'pending',
            'total_harga' => $kambing->harga,
            'metode_bayar' => $request->metode_bayar,
        ]);

        // Buat detail pesanan
        DetailPesanan::create([
            'pesanan_id' => $pesanan->id,
            'kambing_id' => $kambing->id,
            'jumlah' => 1,
            'subtotal' => $kambing->harga,
            'harga_satuan' => $kambing->harga,
        ]);

        // Upload bukti bayar jika ada
        if (in_array($request->metode_bayar, ['qris', 'transfer']) && $request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/bukti_bayar', $filename);

            $pesanan->bukti_bayar = $filename;
            $pesanan->save();
        }

        /**
         * ==============================
         *  NOTIFIKASI UNTUK ADMIN
         * ==============================
         */
        $admins = User::whereRaw('LOWER(role) = ?', ['admin'])->get();
        foreach ($admins as $admin) {
            $admin->notify(new PesananDibuat($pesanan));
        }

        /**
         * ==============================
         *  NOTIFIKASI UNTUK USER
         * ==============================
         */
        Auth::user()->notify(new PesananUserNotification($pesanan));

        return redirect()->route('user.kambing')->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Tampilkan QR Code (opsional)
     */
    public function showQR($id)
    {
        $kambing = Kambing::findOrFail($id);
        $path = storage_path('app/public/qrcode/' . $kambing->qr_filename);

        if (!file_exists($path)) {
            abort(404, 'QR Code tidak ditemukan');
        }

        return response()->file($path);
    }
}
