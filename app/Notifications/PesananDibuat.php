<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Pesanan;

class PesananDibuat extends Notification
{
    use Queueable;

    protected $pesanan;

    public function __construct(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    /**
     * Channel notifikasi (database saja)
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Data yang disimpan ke database
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'pesanan',
            'title' => 'Pesanan Baru #' . $this->pesanan->id,
            'message' => 'Pesanan baru dari ' . $this->pesanan->user->name . ' dengan total Rp ' . number_format($this->pesanan->total_harga, 0, ',', '.'),
            'pesanan_id' => $this->pesanan->id,
            'url' => route('admin.pesanan.show', $this->pesanan->id)
        ];
    }
}