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
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'no_hp'    => 'required|string|max:20',
            'alamat'   => 'nullable|string|max:255',
            'password' => 'required|confirmed',
        ]);

        // QR Token unik
        $qrToken = Str::random(40);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'no_hp'    => $validated['no_hp'],
            'alamat'   => $validated['alamat'] ?? null,
            'password' => Hash::make($validated['password']),
            'role'     => 'Pembeli', // default
            'qr_token' => $qrToken,
        ]);

        // Simpan QR Token dalam file SVG
        $qrSvg = QrCode::format('svg')->size(300)->generate($qrToken);
        $qrPath = "qr/qr_{$user->id}.svg";
        Storage::disk('public')->put($qrPath, $qrSvg);

        $baseUrl = config('app.url');
        $linkQr = $baseUrl . "/show-qr/" . $user->id;

        // Format nomor WA
        $waNumber = $this->formatPhone($user->no_hp);

        // Kirim ke WhatsApp via Fonnte
        if ($waNumber) {
            try {
                $client = new Client();
                $client->post('https://api.fonnte.com/send', [
                    'headers' => ['Authorization' => env('FONNTE_TOKEN')],
                    'form_params' => [
                        'target'  => $waNumber,
                        'message' => "✅ Registrasi Berhasil!\n\n".
                                      "Halo *{$user->name}* 👋\n\n".
                                      "Silakan gunakan QR berikut untuk login ke sistem:\n".
                                      "{$linkQr}\n\n".
                                      "📌 Simpan link ini ya, untuk kemudahan login!"
                    ]
                ]);
                Log::info("WA terkirim ke $waNumber");
            } catch (\Exception $e) {
                Log::error("Gagal kirim WA: " . $e->getMessage());
            }
        }

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! QR dikirim via WhatsApp ✅');
    }

    private function formatPhone($phone)
    {
        if (!$phone) return null;
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        return $phone;
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name'     => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user());
        }

        return back()->with('error', 'Nama atau password salah!');
    }

    // QR Login
    public function loginWithQr(Request $request)
    {
        $request->validate([
            'qr_token' => 'required|string',
        ]);

        $user = User::where('qr_token', $request->qr_token)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid!'
            ], 400);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil!',
            'redirect' => $user->role === 'Admin'
                ? route('admin.dashboard')
                : route('user.index')
        ]);
    }

    private function redirectByRole($user)
    {
        return $user->role === 'Admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil ✅');
    }

    // Tampilkan QR ke user
    public function showLink($id)
    {
        $user = User::findOrFail($id);

        $qrSvg = QrCode::format('svg')
            ->size(300)
            ->generate($user->qr_token);

        return view('qrcode.show', compact('qrSvg', 'user'));
    }
}
