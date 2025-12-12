<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Notifications\StatusPesananDiupdate;

class PesananController extends Controller
{
    /**
     * ADMIN – daftar semua pesanan
     */
    public function index()
    {
        $pesanans = Pesanan::with(['user', 'detailPesanans.kambing'])
            ->latest()
            ->paginate(10);

        return view('admin.pesanan.pesanan', compact('pesanans'));
    }

    /**
     * ADMIN – update status pesanan
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,selesai,ditolak',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $request->status;
        $pesanan->save();

        // Kirim notifikasi ke user
        if ($pesanan->user) {
            $pesanan->user->notify(new StatusPesananDiupdate($pesanan));
        }

        return redirect()->route('admin.pesanan.index')
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }


    /**
     * ADMIN – detail pesanan
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'detailPesanans.kambing'])
            ->findOrFail($id);

        return view('admin.pesanan.show', compact('pesanan'));
    }
}
