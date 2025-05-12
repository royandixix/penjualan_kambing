<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kambing;

class KambingController extends Controller
{
    public function index()
    {
        $kambings = Kambing::all();
        return view('admin.kambing.index', compact('kambings'));
    }

    public function create()
    {
        return view('admin.kambing.tambah');
    }

    public function store(Request $request)
    {
        // Bersihkan input berat dan harga dari simbol atau satuan
        $request->merge([
            'berat' => preg_replace('/[^\d.]/', '', $request->berat), // hanya angka dan titik
            'harga' => preg_replace('/[^\d]/', '', $request->harga),  // hanya angka
        ]);

        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer',
            'berat' => 'required|numeric',
            'jenis_kelamin' => 'required|string',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto_kambing', 'public');
        }

        // Simpan data ke database
        Kambing::create($validated);

        return redirect()->route('admin.kambing.index')->with('success', 'Data kambing berhasil ditambahkan!');
    }
}
