<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

// Import semua model
use App\Models\Pesanan;
use App\Models\Kambing;
use App\Models\Pelanggan;
use App\Models\Pembayaran;

class LaporanController extends Controller
{
    // =======================
    // Laporan Utama
    // =======================
    public function index()
    {
        $pesanans = Pesanan::with(['user', 'detailPesanans.kambing'])
            ->latest()
            ->get();

        return view('admin.laporan.laporan', compact('pesanans'));
    }

    public function cetak()
    {
        $pesanans = Pesanan::with(['user', 'detailPesanans.kambing'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.laporan.cetak_pdf', compact('pesanans'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('laporan_pemesanan.pdf');
    }

    // =======================
    // Laporan Kambing
    // =======================
    public function laporanKambing()
    {
        $kambings = Kambing::all();
        return view('admin.laporan.kambing', compact('kambings'));
    }

    public function cetakKambing()
    {
        $kambings = Kambing::all();

        $pdf = Pdf::loadView('admin.laporan.kambing_pdf', compact('kambings'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('laporan_kambing.pdf');
    }

    // =======================
    // Laporan Pelanggan
    // =======================
    public function laporanPelanggan()
    {
        $pelanggans = Pelanggan::all();
        return view('admin.laporan.pelanggan', compact('pelanggans'));
    }

    public function cetakPelanggan()
    {
        $pelanggans = Pelanggan::all();

        $pdf = Pdf::loadView('admin.laporan.pelanggan_pdf', compact('pelanggans'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('laporan_pelanggan.pdf');
    }

    // =======================
    // Laporan Pembayaran
    // =======================
    public function laporanPembayaranKambing()
    {
        $pembayarans = Pembayaran::with(['pesanan.user'])
            ->latest()
            ->get();

        return view('admin.laporan.pembayaran_kambing', compact('pembayarans'));
    }

    public function cetakPembayaranKambing()
    {
        $pembayarans = Pembayaran::with(['pesanan.user'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.laporan.pembayaran_kambing_pdf', compact('pembayarans'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('laporan_pembayaran.pdf');
    }

    // =======================
    // Laporan Pemesanan
    // =======================
    public function laporanPemesanan()
    {
        $pesanans = Pesanan::orderBy('created_at', 'desc')->paginate(10);


        return view('admin.laporan.pemesanan', compact('pesanans'));
    }

    public function cetakPemesanan()
    {
        $pesanans = Pesanan::with(['user', 'detailPesanans.kambing'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.laporan.pemesanan_pdf', compact('pesanans'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('laporan_pemesanan.pdf');
    }

    // =======================
    // Laporan Penjualan
    // =======================
    public function laporanPenjualan()
    {
        $penjualans = Pesanan::with(['user', 'detailPesanans.kambing'])
            ->where('status', 'Selesai')
            ->latest()
            ->get();
    
        // pakai file penjualan.blade.php langsung
        return view('admin.laporan.penjualan', compact('penjualans'));
    }
    


    public function cetakPenjualan()
{
    $penjualans = Pesanan::with(['user', 'detailPesanans.kambing'])
        ->where('status', 'Selesai')
        ->latest()
        ->get();

    $pdf = Pdf::loadView('admin.laporan.penjualan_pdf', compact('penjualans'))
        ->setPaper('A4', 'landscape');

    return $pdf->stream('laporan_penjualan.pdf');
}

    
}