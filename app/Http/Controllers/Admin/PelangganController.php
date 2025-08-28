<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    // Tampilkan semua pelanggan
    public function index()
    {
        $pelanggan = Pelanggan::all(); // variabel sama dengan yang dipakai di view
        return view('admin.pelanggan.pelanggan', compact('pelanggan'));
    }

    public function create()
    {
        return view('admin.pelanggan.tambah_pelanggan');
    }


    // Simpan data pelanggan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        Pelanggan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'user_id' => $request->user_id ?? null, // jika pakai relasi ke user
        ]);

        return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    // Update data pelanggan
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email,' . $id,
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        $pelanggan->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan berhasil diupdate');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit_pelanggan', compact('pelanggan'));
    }
    




    // Hapus pelanggan
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan berhasil dihapus');
    }
}
