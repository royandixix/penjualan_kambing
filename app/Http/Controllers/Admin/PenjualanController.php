<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Pesanan::with('user', 'kambings')->get(); // plural
        return view('admin.penjualan.penjualan', compact('penjualans'));
    }


    // Tampilkan detail penjualan
    public function show($id)
    {
        $penjualan = Pesanan::with('user', 'detailPesanans.kambing')->findOrFail($id);
        return view('admin.penjualan.show', compact('penjualan'));
    }

    // Update status penjualan
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,dikonfirmasi,selesai',
        ]);

        $penjualan = Pesanan::findOrFail($id);
        $penjualan->status = $request->status;
        $penjualan->save();

        return redirect()->route('admin.penjualan.index')->with('success', 'Status penjualan berhasil diupdate');
    }

    // Hapus penjualan
    public function destroy($id)
    {
        $penjualan = Pesanan::findOrFail($id);
        $penjualan->delete();

        return redirect()->route('admin.penjualan.index')->with('success', 'Penjualan berhasil dihapus');
    }
}
