<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Pesanan;

class PesananUserNotification extends Notification
{
    use Queueable;

    protected $pesanan;

    public function __construct(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'pesanan_user',
            'title' => 'Pesanan Berhasil Dibuat!',
            'message' => "Pesanan Anda sudah berhasil dibuat dan menunggu konfirmasi admin.",
            'pesanan_id' => $this->pesanan->id,
            'total_harga' => $this->pesanan->total_harga
        ];
    }
}
