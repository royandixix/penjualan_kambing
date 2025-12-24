<?php

namespace App\Exports;

use App\Models\Pesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenjualanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Ambil semua pesanan beserta user dan detail produk
        return Pesanan::with('user', 'detailPesanans.kambing')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pelanggan',
            'Tanggal Jual',
            'Status',
            'Total',
            'Detail Produk'
        ];
    }

    public function map($pesanan): array
    {
        $detailProduk = $pesanan->detailPesanans->map(function ($detail) {
            return ($detail->kambing->jenis_kambing ?? '-') 
                   . ' x ' . $detail->jumlah;
        })->implode(', ');

        return [
            $pesanan->id,
            $pesanan->user->name ?? '-',
            $pesanan->tanggal_pesan->format('d-m-Y'),
            ucfirst($pesanan->status),
            $pesanan->total_harga,
            $detailProduk
        ];
    }
}
