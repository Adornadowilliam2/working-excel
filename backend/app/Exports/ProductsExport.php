<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ProductsExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Product::all()->makeHidden(['created_at', 'updated_at']);
    }

    public function headings(): array
    {
        return ['ID', 'Link', 'Content', 'Remarks', 'Views', 'Comment', 'Like', 'Link Clicked', 'Share', 'Save'];
    }

    public function styles(Worksheet $sheet)
    {
        
        $sheet->getStyle('A1:J1')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,  
                'vertical' => Alignment::VERTICAL_CENTER,      
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],  
                ],
            ],
        ]);

        
        $sheet->getStyle('A2:J' . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,  
                'vertical' => Alignment::VERTICAL_CENTER,      
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],  
                ],
            ],
        ]);

        return [];
    }
}
