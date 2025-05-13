<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PenggunaController extends Controller
{
    
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('admin.pengguna.pengguna', compact('users'));
        
    }

    public function create()
    {
        return view('admin.pengguna.tambah_pengguna');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'no_hp'    => 'required|string|max:20',
            'alamat'   => 'required|string|max:255',
            'role'     => 'required|in:admin,user',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'no_hp'    => $request->no_hp,
            'alamat'   => $request->alamat,
            'role'     => $request->role,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.pengguna.edit_pengguna', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'no_hp'  => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'role'   => 'required|in:admin,user',
        ]);

        $user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
            'role'   => $request->role,
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Data Pengguna Diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus');
    }
}
