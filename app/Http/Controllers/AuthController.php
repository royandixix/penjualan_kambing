<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'no_hp'    => 'nullable|string|max:20',
            'alamat'   => 'nullable|string|max:255',
            'password' => 'required|confirmed',
            'role'     => 'required|in:Admin,Pembeli',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'no_hp'    => $validated['no_hp'] ?? null,
            'alamat'   => $validated['alamat'] ?? null,
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil, silakan login!');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name'     => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt(['name' => $credentials['name'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'Admin') {
                return redirect()->route('admin.kambing.index')->with('success', 'Selamat datang, Admin!');
            } elseif ($user->role === 'Pembeli') {
                return redirect()->route('user.index')->with('success', 'Selamat datang, Pembeli!');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Peran tidak dikenali.');
            }
        }

        return redirect()->back()->with('error', 'Nama atau password salah.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
