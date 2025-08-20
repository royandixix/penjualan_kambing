<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kambing;
use Illuminate\Support\Facades\Storage;

class KambingController extends Controller
{
    public function index()
    {
        // Lebih baik gunakan pagination agar lebih ringan
        $kambings = Kambing::paginate(10);
        return view('admin.kambing.index', compact('kambings'));
    }

    public function create()
    {
        return view('admin.kambing.tambah');
    }

    public function store(Request $request)
    {
        // Hilangkan simbol satuan sebelum validasi
        $request->merge([
            'berat' => preg_replace('/[^\d.]/', '', $request->berat),
            'harga' => preg_replace('/[^\d]/', '', $request->harga),
        ]);

        $validated = $request->validate([
            'jenis_kambing'   => 'required|string|max:255',
            'umur'            => 'required|integer',
            'berat'           => 'required|numeric',
            'jenis_kelamin'   => 'required|in:Jantan,Betina', // lebih aman
            'harga'           => 'required|numeric',
            'deskripsi'       => 'nullable|string',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Simpan foto jika ada
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto_kambing', 'public');
        }

        Kambing::create($validated);

        return redirect()->route('admin.kambing.index')
            ->with('success', 'Data kambing berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kambing = Kambing::findOrFail($id);
        return view('admin.kambing.edit', compact('kambing'));
    }

    public function update(Request $request, $id)
    {
        // Hilangkan simbol satuan sebelum validasi
        $request->merge([
            'berat' => preg_replace('/[^\d.]/', '', $request->berat),
            'harga' => preg_replace('/[^\d]/', '', $request->harga),
        ]);

        $validated = $request->validate([
            'jenis_kambing'   => 'required|string|max:255',
            'umur'            => 'required|integer',
            'berat'           => 'required|numeric',
            'jenis_kelamin'   => 'required|in:Jantan,Betina',
            'harga'           => 'required|numeric',
            'deskripsi'       => 'nullable|string',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $kambing = Kambing::findOrFail($id);

        // Update foto jika ada file baru
        if ($request->hasFile('foto')) {
            if ($kambing->foto && Storage::disk('public')->exists($kambing->foto)) {
                Storage::disk('public')->delete($kambing->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto_kambing', 'public');
        }

        $kambing->update($validated);

        return redirect()->route('admin.kambing.index')
            ->with('success', 'Data kambing berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kambing = Kambing::findOrFail($id);

        if ($kambing->foto && Storage::disk('public')->exists($kambing->foto)) {
            Storage::disk('public')->delete($kambing->foto);
        }

        $kambing->delete();

        return redirect()->route('admin.kambing.index')
            ->with('success', 'Data kambing berhasil dihapus!');
    }
}
