<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

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

    // Proses registrasi user baru
    public function register(Request $request)
    {
        // Validasi data input (hapus min:6 dari password)
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'no_hp'    => 'nullable|string|max:20',
            'alamat'   => 'nullable|string|max:255',
            'password' => 'required|confirmed', // <--- di sini
            'role'     => 'required|in:Admin,Pembeli',
        ]);

        // Generate token unik untuk QR code
        $qrToken = Str::random(32);

        // Simpan user baru ke database
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'no_hp'    => $validated['no_hp'] ?? null,
            'alamat'   => $validated['alamat'] ?? null,
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
            'qr_token' => $qrToken,
        ]);

        // Generate dan simpan QR code ke storage/app/public/qr/{user_id}.png pakai GD renderer
        $qrPath = "qr/{$user->id}.png";
        Storage::disk('public')->put(
            $qrPath,
            QrCode::size(300)->generate($qrToken)
        );
        

        // Ambil URL ngrok terbaru dari API lokal, fallback ke APP_URL
        $ngrokBaseUrl = $this->getNgrokUrl() ?: env('APP_URL', url('/'));
        $qrUrl = $ngrokBaseUrl . "/storage/{$qrPath}";

        // Konversi nomor WA ke format internasional (tanpa +)
        $waNumber = $user->no_hp;
        if ($waNumber && substr($waNumber, 0, 1) === '0') {
            $waNumber = '62' . substr($waNumber, 1);
        }

        // Kirim pesan WhatsApp dengan QR code URL
        if ($waNumber) {
            try {
                $client = new Client();

                $response = $client->post('https://api.fonnte.com/send', [
                    'headers' => [
                        'Authorization' => env('FONNTE_TOKEN'),
                    ],
                    'form_params' => [
                        'target'  => $waNumber,
                        'message' => "Halo {$user->name},\n\nSelamat! Kamu sudah berhasil mendaftar di sistem Kamberu.\n\nQR Code login kamu bisa diakses melalui link ini:\n$qrUrl\n\nJangan bagikan QR Code ini ke orang lain ya.\n\nTerima kasih!",
                    ],
                ]);

                Log::info("WA Response untuk {$waNumber}, User ID {$user->id}: " . $response->getBody()->getContents());

            } catch (\Exception $e) {
                Log::error("Gagal kirim WA ke {$waNumber}, User ID {$user->id}: " . $e->getMessage());
            }
        } else {
            Log::warning("Nomor WA kosong, tidak bisa kirim QR: User ID {$user->id}");
        }

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! QR Code sudah dibuat dan dikirim ke WhatsApp.');
    }

    // Ambil URL ngrok dari API lokal (opsional)
    private function getNgrokUrl()
    {
        try {
            $client = new Client();
            $response = $client->get('http://127.0.0.1:4040/api/tunnels');
            $data = json_decode($response->getBody()->getContents(), true);

            foreach ($data['tunnels'] as $tunnel) {
                if (strpos($tunnel['public_url'], 'https://') === 0) {
                    return $tunnel['public_url'];
                }
            }
        } catch (\Exception $e) {
            Log::error("Gagal ambil URL ngrok: " . $e->getMessage());
        }
        return null;
    }

    // Proses login username + password
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name'     => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['name' => $credentials['name'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user());
        }

        return redirect()->back()->with('error', 'Nama atau password salah.');
    }

    // Proses login dengan QR token
    public function loginWithQr(Request $request)
    {
        $request->validate([
            'qr_token' => 'required|string',
        ]);

        $user = User::where('qr_token', $request->qr_token)->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
            return $this->redirectByRole($user);
        }

        return redirect()->back()->with('error', 'QR Code tidak valid.');
    }

    // Helper redirect berdasarkan role user
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

    // Logout user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
