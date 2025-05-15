<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    // public function index()
    // {
    //     $pesanans = Pesanan::with('user')->latest()->get();
    //     return view('admin.pesanan.pesanan' ,compact('pesanans'));
    // }
    public function index()
    {
        $pesanans = Pesanan::with('user')->latest()->get();
        return view('admin.pesanan.pesanan', compact('pesanans'));
    }
    public function show($id)
    {
        $pesanan = Pesanan::with('user', 'detail_pesanans.kambing')->findOrFail($id);
        return view('admin.pesanan.show', compact('pesanan'));
    }
}
