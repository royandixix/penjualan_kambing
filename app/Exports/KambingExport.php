<?php

namespace App\Exports;

use App\Models\Kambing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class KambingExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Kambing::all()->map(function($kambing, $index){
            return [
                $index + 1, // No
                $kambing->jenis_kambing,
                $kambing->umur,
                $kambing->berat,
                $kambing->jenis_kelamin,
                'Rp ' . number_format($kambing->harga,0,',','.'), // format harga
                $kambing->stok,
                $kambing->deskripsi,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Jenis Kambing',
            'Umur (bln)',
            'Berat (kg)',
            'Jenis Kelamin',
            'Harga',
            'Stok',
            'Deskripsi',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        // Header
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getFill()->setFillType(Fill::FILL_SOLID)
              ->getStartColor()->setARGB('FF4CAF50'); // hijau
        $sheet->getStyle('A1:H1')->getFont()->getColor()->setARGB('FFFFFFFF'); // putih
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Border semua sel
        $sheet->getStyle('A1:H'.$highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Zebra stripe baris
        for ($i = 2; $i <= $highestRow; $i++) {
            $bgColor = ($i % 2 == 0) ? 'FFF1F8E9' : 'FFFFFFFF'; // hijau muda / putih
            $sheet->getStyle("A$i:H$i")->getFill()->setFillType(Fill::FILL_SOLID)
                  ->getStartColor()->setARGB($bgColor);
        }

        // Alignment
        $sheet->getStyle('A2:A'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // No
        $sheet->getStyle('C2:D'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Umur & Berat
        $sheet->getStyle('F2:F'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Harga
        $sheet->getStyle('G2:G'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Stok
        $sheet->getStyle('H2:H'.$highestRow)->getAlignment()->setWrapText(true); // Wrap Deskripsi

        // Freeze header
        $sheet->freezePane('A2');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 12,
            'D' => 12,
            'E' => 15,
            'F' => 15,
            'G' => 10,
            'H' => 30,
        ];
    }
}