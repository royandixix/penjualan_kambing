<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // composer require simplesoftwareio/simple-qrcode
use Illuminate\Support\Facades\Log;

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

        // Generate token unik untuk QR
        $qrToken = Str::random(32);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'no_hp'    => $validated['no_hp'] ?? null,
            'alamat'   => $validated['alamat'] ?? null,
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
            'qr_token' => $qrToken,
        ]);

        // Simpan QR code ke storage/public/qr
        $qrPath = "qr/{$user->id}.png";
        Storage::disk('public')->put(
            $qrPath,
            QrCode::format('png')->size(300)->generate($qrToken)
        );

        $qrUrl = asset("storage/" . $qrPath);

        // Konversi nomor WA user ke format +62 jika diawali 0
        $waNumber = $user->no_hp;
        if ($waNumber && substr($waNumber, 0, 1) === '0') {
            $waNumber = '+62' . substr($waNumber, 1);
        }

        // Kirim ke WhatsApp pakai Fonnte API
        if ($waNumber) {
            try {
                $client = new \GuzzleHttp\Client();
                $response = $client->post('https://api.fonnte.com/send', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . env('FONNTE_TOKEN'), // ✅ HARUS pakai "Bearer "
                    ],
                    'form_params' => [
                        'target'  => $waNumber,
                        'message' => "Halo {$user->name},\nTerima kasih sudah daftar!\nBerikut QR Code login kamu:\n$qrUrl",
                    ]
                ]);

                // Log respons API supaya tahu berhasil atau error
                Log::info("Fonnte WA response: " . $response->getBody());
            } catch (\Exception $e) {
                Log::error("Gagal kirim WA: " . $e->getMessage());
            }
        } else {
            Log::warning("Nomor WA kosong, tidak bisa kirim QR: User ID {$user->id}");
        }

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! QR Code sudah dibuat dan dikirim ke WhatsApp.');
    }


    // Proses login normal (pakai name + password)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name'     => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt(['name' => $credentials['name'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user());
        }

        return redirect()->back()->with('error', 'Nama atau password salah.');
    }

    // Proses login dengan QR
    public function loginWithQr(Request $request)
    {
        $request->validate([
            'qr_token' => 'required|string'
        ]);

        $user = User::where('qr_token', $request->qr_token)->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
            return $this->redirectByRole($user);
        }

        return redirect()->back()->with('error', 'QR Code tidak valid.');
    }

    // Helper redirect berdasarkan role
    private function redirectByRole($user)
    {
        if ($user->role === 'Admin') {
            return redirect()->route('admin.kambing.index')->with('success', 'Selamat datang, Admin!');
        } elseif ($user->role === 'Pembeli') {
            return redirect()->route('user.index')->with('success', 'Selamat datang, Pembeli!');
        }

        Auth::logout();
        return redirect()->route('login')->with('error', 'Peran tidak dikenali.');
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
