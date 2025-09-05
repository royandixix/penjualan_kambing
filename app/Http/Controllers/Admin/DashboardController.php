<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Kambing;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin
     */
    public function index()
    {
        // 1. Total pesanan per bulan (tahun ini)
        $pesananPerBulan = Pesanan::select(
            DB::raw('MONTH(tanggal_pesan) as bulan'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('tanggal_pesan', date('Y'))
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

        // Ubah angka bulan menjadi nama bulan
        $bulan = $pesananPerBulan->pluck('bulan')->map(function($m){
            return date('F', mktime(0, 0, 0, $m, 1));
        });
        $totalPesanan = $pesananPerBulan->pluck('total');

        // 2. Stok kambing per jenis
        $stokKambing = Kambing::select('jenis_kambing', DB::raw('SUM(stok) as total_stok'))
                            ->groupBy('jenis_kambing')
                            ->get();

        // Kirim ke view dashboard
        return view('admin.dashboard', compact('bulan','totalPesanan','stokKambing'));
    }
}
