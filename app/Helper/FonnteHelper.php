<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class FonnteHelper
{
    public static function sendMessage($target, $message)
    {
        $token = env('FONNTE_TOKEN');

        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => $message,
        ]);

        return $response->json();
    }
}
