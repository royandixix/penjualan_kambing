<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\KambingExport;
use App\Exports\PelangganExport;
use App\Exports\PesananExport;
use App\Exports\PenjualanExport;

use App\Models\Pesanan;
use App\Models\Kambing;
use App\Models\Pelanggan;
use App\Models\Pembayaran;

class LaporanController extends Controller
{
    // =======================
    // LAPORAN UTAMA
    // =======================
    public function index()
    {
        $pesanans = Pesanan::with(['user', 'detailPesanans.kambing'])->latest()->get();
        return view('admin.laporan.laporan', compact('pesanans'));
    }

    public function cetak()
    {
        $pesanans = Pesanan::with(['user', 'detailPesanans.kambing'])->latest()->get();
        $pdf = Pdf::loadView('admin.laporan.cetak_pdf', compact('pesanans'))
            ->setPaper('A4', 'landscape');
        return $pdf->stream('laporan_pemesanan.pdf');
    }

    // =======================
    // LAPORAN KAMBING
    // =======================
    public function laporanKambing()
    {
        $kambings = Kambing::all();
        return view('admin.laporan.kambing', compact('kambings'));
    }

    // ❌ CETAK SEMUA KAMBING (tetap ada)
    public function cetakKambing()
    {
        $kambings = Kambing::all();
        $pdf = Pdf::loadView('admin.laporan.kambing_pdf', compact('kambings'))
            ->setPaper('A4', 'landscape');
        return $pdf->stream('laporan_kambing.pdf');
    }

    // ✅ CETAK PER ITEM (INI YANG DOSEN MAU)
    public function cetakKambingItem($id)
    {
        $kambing = Kambing::findOrFail($id);

        $pdf = Pdf::loadView('admin.laporan.kambing_item_pdf', compact('kambing'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('kambing_' . $kambing->id . '.pdf');
    }

    public function exportKambingExcel()
    {
        return Excel::download(new KambingExport, 'laporan_kambing.xlsx');
    }

    // =======================
    // LAPORAN PELANGGAN
    // =======================
    public function laporanPelanggan()
    {
        $pelanggans = Pelanggan::all();
        return view('admin.laporan.pelanggan', compact('pelanggans'));
    }

    public function cetakPelangganItem($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $pdf = Pdf::loadView('admin.laporan.pelanggan_item_pdf', compact('pelanggan'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('pelanggan_' . $pelanggan->nama . '.pdf');
    }

    public function cetakPelanggan()
    {
        $pelanggans = Pelanggan::all();
        $pdf = Pdf::loadView('admin.laporan.pelanggan_pdf', compact('pelanggans'))
            ->setPaper('A4', 'portrait');
        return $pdf->stream('laporan_pelanggan.pdf');
    }

    public function exportPelangganExcel()
    {
        return Excel::download(new PelangganExport, 'laporan_pelanggan.xlsx');
    }

    // =======================
    // LAPORAN PEMBAYARAN
    // =======================
    public function laporanPembayaranKambing()
    {
        $pembayarans = Pembayaran::with(['pesanan.user'])->latest()->get();
        return view('admin.laporan.pembayaran_kambing', compact('pembayarans'));
    }

    public function cetakPembayaranKambing()
    {
        $pembayarans = Pembayaran::with(['pesanan.user'])->latest()->get();
        $pdf = Pdf::loadView('admin.laporan.pembayaran_kambing_pdf', compact('pembayarans'))
            ->setPaper('A4', 'landscape');
        return $pdf->stream('laporan_pembayaran.pdf');
    }

    // =======================
    // LAPORAN PEMESANAN
    // =======================
    public function laporanPemesanan()
    {
        $pesanans = Pesanan::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.laporan.pemesanan', compact('pesanans'));
    }

    public function cetakPemesanan()
    {
        $pesanans = Pesanan::with(['user', 'detailPesanans.kambing'])->latest()->get();
        $pdf = Pdf::loadView('admin.laporan.pemesanan_pdf', compact('pesanans'))
            ->setPaper('A4', 'landscape');
        return $pdf->stream('laporan_pemesanan.pdf');
    }

    public function cetakPemesananItem($id)
    {
        $pesanan = Pesanan::with(['user', 'detailPesanans.kambing'])
            ->findOrFail($id);

        $pdf = Pdf::loadView(
            'admin.laporan.pemesanan_item_pdf',
            compact('pesanan')
        )->setPaper('A4', 'portrait');

        return $pdf->stream('pesanan_' . $pesanan->id . '.pdf');
    }

    public function exportPemesananExcel()
    {
        return Excel::download(new PesananExport, 'laporan_pemesanan.xlsx');
    }

    // =======================
    // LAPORAN PENJUALAN
    // =======================
    public function laporanPenjualan()
    {
        $penjualans = Pesanan::with(['user', 'detailPesanans.kambing'])
            ->where('status', 'Selesai')
            ->latest()->get();
        return view('admin.laporan.penjualan', compact('penjualans'));
    }

    public function cetakPenjualan()
    {
        $penjualans = Pesanan::with(['user', 'detailPesanans.kambing'])
            ->where('status', 'Selesai')
            ->latest()->get();
        $pdf = Pdf::loadView('admin.laporan.penjualan_pdf', compact('penjualans'))
            ->setPaper('A4', 'landscape');
        return $pdf->stream('laporan_penjualan.pdf');
    }


    public function cetakPenjualanItem($id)
    {
        $penjualan = Pesanan::with([
            'user',
            'detailPesanans.kambing'
        ])->findOrFail($id);

        $pdf = Pdf::loadView(
            'admin.laporan.penjualan_item_pdf',
            compact('penjualan')
        )->setPaper('A4', 'portrait');

        return $pdf->stream('penjualan_' . $penjualan->id . '.pdf');
    }

    public function exportPenjualanExcel()
    {
        return Excel::download(new PenjualanExport, 'laporan_penjualan.xlsx');
    }
}
