<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController extends Controller
{
    /**
     * Tampilkan daftar penjualan
     */
    public function index()
    {
        $penjualans = Pesanan::with('user', 'detailPesanans.kambing')->get();
        return view('admin.penjualan.penjualan', compact('penjualans'));
    }

    /**
     * Tampilkan detail penjualan tertentu
     */
    public function show($id)
    {
        $penjualan = Pesanan::with('user', 'detailPesanans.kambing')->findOrFail($id);
        return view('admin.penjualan.show', compact('penjualan'));
    }

    /**
     * Update status penjualan
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,dikonfirmasi,selesai,lunas,pending',
        ]);

        $penjualan = Pesanan::findOrFail($id);
        $penjualan->status = $request->status;
        $penjualan->save();

        return redirect()->route('admin.penjualan.index')->with('success', 'Status penjualan berhasil diupdate');
    }

    /**
     * Hapus penjualan
     */
    public function destroy($id)
    {
        $penjualan = Pesanan::findOrFail($id);
        $penjualan->delete();

        return redirect()->route('admin.penjualan.index')->with('success', 'Penjualan berhasil dihapus');
    }

    /**
     * Export laporan penjualan ke PDF
     * Preview di browser/tab baru
     */
    public function exportPdf()
    {
        $penjualans = Pesanan::with('user', 'detailPesanans.kambing')->get();

        $pdf = Pdf::loadView('admin.penjualan.laporan_pdf', compact('penjualans'));

        return $pdf->stream('laporan_penjualan_' . date('Y-m-d') . '.pdf');
    }
}
