<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;
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

        // Buat user baru
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
        \Illuminate\Support\Facades\Storage::disk('public')->put(
            $qrPath,
            QrCode::format('png')->size(300)->generate($qrToken)
        );

        // Ambil URL ngrok terbaru dari API lokal
        $ngrokBaseUrl = $this->getNgrokUrl() ?: 'http://localhost:8000';
        $qrUrl = $ngrokBaseUrl . "/storage/qr/{$user->id}.png";

        // Konversi nomor WA ke format internasional (tanpa +)
        $waNumber = $user->no_hp;
        if ($waNumber && substr($waNumber, 0, 1) === '0') {
            $waNumber = '62' . substr($waNumber, 1);
        }

        if ($waNumber) {
            try {
                $client = new Client();

                // Kirim pesan WA via Fonnte (teks + link QR)
                $response = $client->post('https://api.fonnte.com/send', [
                    'headers' => [
                        'Authorization' => env('FONNTE_TOKEN'),
                    ],
                    'form_params' => [
                        'target'  => $waNumber,
                        'message' => "Halo {$user->name},\n\nSelamat! Kamu sudah berhasil mendaftar di sistem Kamberu.\n\nUntuk mempermudah login, kami sudah membuatkan QR Code khusus untuk akunmu. Kamu bisa klik link berikut untuk melihat QR Code login langsung dari HP atau device lain:\n\n$qrUrl\n\nQR Code ini bersifat pribadi, jangan bagikan ke orang lain.\n\nTerima kasih telah mendaftar, semoga pengalamanmu menyenangkan!\n\n— Tim Kamberu",
                    ],
                ]);

                Log::info("WA berhasil dikirim ke {$waNumber}, User ID: {$user->id}");
            } catch (\Exception $e) {
                Log::error("Gagal kirim WA ke {$waNumber}, User ID {$user->id}: " . $e->getMessage());
            }
        } else {
            Log::warning("Nomor WA kosong, tidak bisa kirim QR: User ID {$user->id}");
        }

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! QR Code sudah dibuat dan dikirim ke WhatsApp.');
    }

    // Ambil URL ngrok terbaru dari API lokal
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

    // Proses login normal
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
        $request->validate(['qr_token' => 'required|string']);
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
