<?php
namespace App\Exports;

use App\Models\Update;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UpdatesExport implements WithMultipleSheets
{
    /**
     * Return an array of sheets to export.
     *
     * @return array
     */
    public function sheets(): array
    {
        return [
            'Last 7 Days' => new UpdatePerPeriod(7, 'Updates in Last 7 Days'),
            'Last 12 Days' => new UpdatePerPeriod(12, 'Updates in Last 12 Days'),
            'Last 30 Days' => new UpdatePerPeriod(30, 'Updates in Last 30 Days'),
            'Last 90 Days' => new UpdatePerPeriod(90, 'Updates in Last 90 Days'),
        ];
    }
}

class UpdatePerPeriod implements FromCollection, WithHeadings, WithColumnWidths, WithTitle
{
    protected $days;
    protected $title;

    public function __construct($days, $title)
    {
        $this->days = $days;
        $this->title = $title;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        
        $dateAgo = Carbon::now()->subDays($this->days);

        
        return Update::all()
                    ->makeHidden(['created_at', 'updated_at']);
    }

    /**
     * Define the headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return ['ID', 'Visitors', 'Time','Date'];
    }

    /**
     * Set the widths for the columns.
     *
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 10,  
            'B' => 15,  
            'C' => 15,
            'D' => 10,    
        ];
    }

    /**
     * Set the sheet title.
     *
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * Insert a custom title row at the top of each sheet and center it.
     *
     * @param  \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet  $sheet
     * @return void
     */
    public function sheet(Worksheet $sheet)
    {
        
        $sheet->setCellValue('A1', $this->title);
        $sheet->mergeCells('A1:E1');  
        
        
        $sheet->getStyle('A1')->getFont()->setBold(true);
        
        
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        
        
        $sheet->getRowDimension(1)->setRowHeight(20);

        
        $sheet->fromArray($this->headings(), null, 'A2');
    }
}
