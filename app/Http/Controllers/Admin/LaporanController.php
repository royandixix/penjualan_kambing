<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
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
}
