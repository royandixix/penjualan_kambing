<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    /**
     * Tampilkan semua pesanan untuk admin.
     */
    public function index()
    {
        $pesanans = Pesanan::with(['user', 'detailPesanans.kambing'])
            ->latest()
            ->paginate(10); // gunakan pagination untuk performa

        return view('admin.pesanan.pesanan', compact('pesanans'));
    }

    /**
     * Tampilkan detail dari satu pesanan.
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'detailPesanans.kambing'])
            ->findOrFail($id);

        return view('admin.pesanan.show', compact('pesanan'));
    }

    /**
     * Hapus satu pesanan beserta detail dan file bukti bayarnya.
     */
    public function destroy($id)
    {
        $pesanan = Pesanan::with('detailPesanans')->findOrFail($id);

        // Hapus file bukti bayar jika ada
        $path = 'public/bukti_bayar/' . $pesanan->bukti_bayar;
        if ($pesanan->bukti_bayar && Storage::exists($path)) {
            Storage::delete($path);
        }

        // Hapus semua detail pesanan
        $pesanan->detailPesanans()->delete();

        // Hapus pesanan utama
        $pesanan->delete();

        return redirect()
            ->route('admin.pesanan.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,ditolak',
        ]);
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->route('admin.pesanan.index')->with('success', 'Status pesanan diperbarui.');
    }
}
