<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PesananBaruNotification extends Notification
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

    public function toArray($notifiable)
    {
        return [
            'type' => 'pesanan',
            'title' => 'Pesanan Baru #' . $this->pesanan->id,
            'message' => 'Pesanan baru dari ' . $this->pesanan->user->name . ' dengan total Rp ' . number_format($this->pesanan->total, 0, ',', '.'),
            'pesanan_id' => $this->pesanan->id,
            'url' => route('admin.pesanan.show', $this->pesanan->id)
        ];
    }
}