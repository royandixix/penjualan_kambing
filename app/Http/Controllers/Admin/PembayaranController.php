<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Menampilkan daftar semua pembayaran yang telah dilakukan.
     */
    public function index()
    {
        $pembayarans = Pesanan::with('user')
            ->whereNotNull('metode_bayar') // Hanya yang sudah melakukan pembayaran
            ->latest()
            ->get();

        return view('admin.pembayaran.pembayaran', compact('pembayarans'));
    }

    /**
     * Menampilkan detail dari satu pembayaran.
     */
    public function show($id)
{
    $pembayaran = Pesanan::with('user', 'detailPesanans.kambing')->findOrFail($id);
    return view('admin.pembayaran.show', compact('pembayaran'));
}


    public function create()
    {
        $user = User::all();
        return view('admin.pembayaran.tambah_pembayaran', ['users' => $user]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_pesan' => 'required|date',
            'metode_bayar' => 'required|string|max:255',
            'status' => 'required|in:menunggu,selesai,gagal',
            'total_harga' => 'required|numeric|min:0',
            'bukti_bayar' => 'nullable|image|max:2048',
        ]);

        $pembayaran = new Pesanan();
        $pembayaran->user_id = $request->user_id;
        $pembayaran->tanggal_pesan = $request->tanggal_pesan;
        $pembayaran->metode_bayar = $request->metode_bayar;
        $pembayaran->status = $request->status;
        $pembayaran->total_harga = $request->total_harga;

        // Upload bukti bayar
        if ($request->hasFile('bukti_bayar')) {
            $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
            $pembayaran->bukti_bayar = $path;
        }

        $pembayaran->save();

        return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran berhasil disimpan.');
    }
}
