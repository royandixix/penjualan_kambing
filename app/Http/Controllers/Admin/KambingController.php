<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kambing;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class KambingController extends Controller
{
    public function index()
    {
        $kambings = Kambing::paginate(10);
        return view('admin.kambing.index', compact('kambings'));
    }

    public function create()
    {
        return view('admin.kambing.tambah');
    }

    public function store(Request $request)
    {
        // Hapus format Rp/kg agar bisa disimpan
        $request->merge([
            'berat' => preg_replace('/[^\d.]/', '', $request->berat),
            'harga' => preg_replace('/[^\d]/', '', $request->harga),
        ]);

        $validated = $request->validate([
            'jenis_kambing' => 'required|string|max:255',
            'kategori' => 'required|in:Kambing Kacang,Kambing Peranakan Etawa',
            'umur' => 'required|integer',
            'berat' => 'required|numeric',
            'jenis_kelamin' => 'required|in:Jantan,Betina',
            'harga' => 'required|numeric',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            // Upload file: tanpa batasi ekstensi, max 5MB
            'foto' => 'nullable|file|max:5120',
        ]);

        // Upload file jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName(); // nama unik
            $validated['foto'] = $file->storeAs('foto_kambing', $filename, 'public');
        }

        Kambing::create($validated);

        return redirect()->route('admin.kambing.index')->with('success', 'Data kambing berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kambing = Kambing::findOrFail($id);
        return view('admin.kambing.edit', compact('kambing'));
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'berat' => preg_replace('/[^\d.]/', '', $request->berat),
            'harga' => preg_replace('/[^\d]/', '', $request->harga),
        ]);

        $validated = $request->validate([
            'jenis_kambing' => 'required|string|max:255',
            'kategori' => 'required|in:Kambing Kacang,Kambing Peranakan Etawa',
            'umur' => 'required|integer',
            'berat' => 'required|numeric',
            'jenis_kelamin' => 'required|in:Jantan,Betina',
            'harga' => 'required|numeric',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|file|max:5120',
        ]);

        $kambing = Kambing::findOrFail($id);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($kambing->foto && Storage::disk('public')->exists($kambing->foto)) {
                Storage::disk('public')->delete($kambing->foto);
            }
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['foto'] = $file->storeAs('foto_kambing', $filename, 'public');
        }

        $kambing->update($validated);

        return redirect()->route('admin.kambing.index')->with('success', 'Data kambing berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kambing = Kambing::findOrFail($id);

        if ($kambing->foto && Storage::disk('public')->exists($kambing->foto)) {
            Storage::disk('public')->delete($kambing->foto);
        }

        $kambing->delete();

        return redirect()->route('admin.kambing.index')->with('success', 'Data kambing berhasil dihapus!');
    }

    public function exportPdf()
    {
        $kambings = Kambing::all();
        $pdf = Pdf::loadView('admin.kambing.laporan_pdf', compact('kambings'));
        return $pdf->stream('laporan_kambing_' . date('Y-m-d') . '.pdf');
    }
}
