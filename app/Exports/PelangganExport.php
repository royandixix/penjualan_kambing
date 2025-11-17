<?php

namespace App\Exports;

use App\Models\Pelanggan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PelangganExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Pelanggan::all()->map(function ($p, $index) {
            return [
                $index + 1,
                $p->nama,
                $p->email,
                $p->no_hp,
                $p->alamat,
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'Email', 'No HP', 'Alamat'];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        // Header
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getFill()->setFillType(Fill::FILL_SOLID)
              ->getStartColor()->setARGB('FF4CAF50'); // hijau
        $sheet->getStyle('A1:E1')->getFont()->getColor()->setARGB('FFFFFFFF'); // putih
        $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Border semua sel
        $sheet->getStyle('A1:E'.$highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Zebra stripe baris
        for ($i = 2; $i <= $highestRow; $i++) {
            $bgColor = ($i % 2 == 0) ? 'FFF1F8E9' : 'FFFFFFFF';
            $sheet->getStyle("A$i:E$i")->getFill()->setFillType(Fill::FILL_SOLID)
                  ->getStartColor()->setARGB($bgColor);
        }

        // Alignment
        $sheet->getStyle('A2:A'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // No
        $sheet->getStyle('B2:B'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C2:C'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D2:D'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E2:E'.$highestRow)->getAlignment()->setWrapText(true); // Alamat

        // Freeze header
        $sheet->freezePane('A2');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 25,
            'D' => 15,
            'E' => 40,
        ];
    }
}
