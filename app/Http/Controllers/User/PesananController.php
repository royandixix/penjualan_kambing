<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Kambing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PesananController extends Controller
{
    public function showCheckout($id, Request $request)
    {
        $metode = $request->metode_bayar;

        if (!$metode) {
            return redirect()->back()->with('error', 'Pilih metode pembayaran terlebih dahulu.');
        }

        $kambing = Kambing::findOrFail($id);
        return view('user.checkout.kambing', compact('kambing', 'metode'));
    }

    public function beli(Request $request, $id)
    {
        // Validasi input
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
        ]);

        // Upload bukti bayar jika dibutuhkan
        if (in_array($request->metode_bayar, ['qris', 'transfer']) && $request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/bukti_bayar', $filename);

            // Simpan ke kolom bukti_bayar
            $pesanan->bukti_bayar = $filename;
            $pesanan->save();
        }

        return redirect()->route('user.kambing')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function showQR($id)
    {
        $kambing = Kambing::findOrFail($id);
        $path = storage_path('app/public/qrcode/' . $kambing->qr_filename);

        if (!file_exists($path)) {
            abort(404, 'QR Code tidak ditemukan');
        }

        return response()->file($path);
    }

    // ADMIN - Lihat semua pesanan
    public function index()
    {
        $pesanans = Pesanan::with(['user', 'detailPesanans.kambing'])->latest()->paginate(10);
        return view('admin.pesanan.pesanan', compact('pesanans'));
    }

    // ADMIN - Update status pesanan
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,selesai,ditolak',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->route('admin.pesanan.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
