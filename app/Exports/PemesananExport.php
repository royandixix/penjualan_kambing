<?php

namespace App\Exports;

use App\Models\Pesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PesananExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Pesanan::with('user', 'detailPesanans.kambing')->get()->map(function ($pesanan, $index) {
            // Gabungkan semua detail kambing menjadi satu string
            $detailText = $pesanan->detailPesanans->map(function($detail) {
                return ($detail->kambing->jenis ?? '-') 
                    . ' x ' . $detail->jumlah 
                    . ' = Rp ' . number_format($detail->subtotal,0,',','.');
            })->implode("\n");

            return [
                $index + 1, // No
                $pesanan->user->name ?? '-', // Nama pembeli
                \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y'), // Tanggal
                ucfirst($pesanan->status), // Status
                'Rp ' . number_format($pesanan->total_harga,0,',','.'), // Total Harga
                $detailText // Rincian Kambing
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama Pembeli', 'Tanggal Pesan', 'Status', 'Total Harga', 'Rincian Kambing'];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        // Header
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)
              ->getStartColor()->setARGB('FF4CAF50'); // Hijau
        $sheet->getStyle('A1:F1')->getFont()->getColor()->setARGB('FFFFFFFF'); // Putih
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Border semua sel
        $sheet->getStyle('A1:F'.$highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Zebra stripe baris
        for ($i = 2; $i <= $highestRow; $i++) {
            $bgColor = ($i % 2 == 0) ? 'FFF1F8E9' : 'FFFFFFFF';
            $sheet->getStyle("A$i:F$i")->getFill()->setFillType(Fill::FILL_SOLID)
                  ->getStartColor()->setARGB($bgColor);
        }

        // Alignment
        $sheet->getStyle('A2:A'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // No
        $sheet->getStyle('B2:B'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Nama
        $sheet->getStyle('C2:C'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Tanggal
        $sheet->getStyle('D2:D'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Status
        $sheet->getStyle('E2:E'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Total
        $sheet->getStyle('F2:F'.$highestRow)->getAlignment()->setWrapText(true); // Rincian Kambing

        // Freeze header
        $sheet->freezePane('A2');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 18,
            'D' => 12,
            'E' => 18,
            'F' => 50,
        ];
    }
}
