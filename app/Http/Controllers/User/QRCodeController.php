<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kambing;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    // Generate QR code berdasarkan ID kambing dan simpan di storage
    public function generate($id)
    {
        $kambing = Kambing::findOrFail($id);

        $qrData = url('/kambing/' . $kambing->id); // URL yang ingin di-QR-kan
        $filename = $kambing->id . '.png';

        // Simpan QR code di storage/app/public/qrcode
        Storage::disk('public')->put('qrcode/' . $filename, QrCode::format('png')->size(300)->renderer('gd')->generate($qrData));


        // Simpan nama file di DB (opsional)
        $kambing->qr_filename = $filename;
        $kambing->save();

        return response()->json([
            'message' => 'QR Code berhasil dibuat',
            'filename' => $filename,
            'url' => asset('storage/qrcode/' . $filename),
        ]);
    }

    // Tampilkan gambar QR code dari storage
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
