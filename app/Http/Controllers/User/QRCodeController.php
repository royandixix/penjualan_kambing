<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kambing;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    /**
     * Generate dan simpan QR code untuk kambing berdasarkan ID
     */
    public function generate($id)
    {
        $kambing = Kambing::findOrFail($id);

        $qrData = 'https://example.com/kambing/' . $kambing->id; // Ganti dengan URL real
        $filename = $kambing->id . '.png';

        // Simpan QR code ke storage/app    /public/qrcode
        Storage::disk('public')->put('qrcode/' . $filename, QrCode::format('png')->size(300)->generate($qrData));

        // Simpan nama file ke database (opsional)
        $kambing->qr_filename = $filename;
        $kambing->save();

        return response()->json([
            'message' => 'QR Code berhasil dibuat',
            'filename' => $filename,
            'url' => asset('storage/qrcode/' . $filename)
        ]);
    }

    

    /**
     * Menampilkan gambar QR code dari storage
     */
    public function show($id)
    {
        $kambing = Kambing::findOrFail($id);
        $path = storage_path('app/public/qrcode/' . $kambing->qr_filename);

        if (!file_exists($path)) {
            abort(404, 'QR Code tidak ditemukan.');
        }

        return response()->file($path);
    }



    
}
