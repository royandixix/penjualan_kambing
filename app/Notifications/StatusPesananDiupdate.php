<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;


class StatusPesananDiupdate extends Notification
{
    use Queueable;

    protected $pesanan;

    public function __construct($pesanan)
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
            'pesanan_id' => $this->pesanan->id,
            'status' => $this->pesanan->status,
            'message' => "Status pesanan kamu berubah menjadi: " . ucfirst($this->pesanan->status),
            'tanggal' => now()->format('d-m-Y H:i')
        ];
    }
}
