<?php

namespace Modules\Leads\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Modules\Leads\Models\Leads;

class LeadsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $leads;

    public function __construct($leads = null)
    {
        $this->leads = $leads ?? Leads::all();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->leads;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Müşteri Adı',
            'Şirket Adı',
            'Lead Skoru',
            'Telefon',
            'Konum',
            'Oluşturulma Tarihi',
            'Güncellenme Tarihi'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->company_name ?? '-',
            $row->lead_score ?? '-',
            $row->phone ?? '-',
            $row->location ?? '-',
            $row->created_at->format('d.m.Y H:i:s'),
            $row->updated_at->format('d.m.Y H:i:s'),
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Başlık satırı için stil
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            // Tüm hücreler için border
            'A1:H' . ($sheet->getHighestRow()) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
        ];
    }

    // /**
    //  * Belirli tarih aralığındaki lead'leri export etmek için
    //  */
    // public static function exportByDateRange($startDate, $endDate)
    // {
    //     $leads = Leads::whereBetween('created_at', [$startDate, $endDate])->get();
    //     return new self($leads);
    // }

    // /**
    //  * Belirli lead skoruna sahip lead'leri export etmek için
    //  */
    // public static function exportByLeadScore($leadScore)
    // {
    //     $leads = Leads::where('lead_score', $leadScore)->get();
    //     return new self($leads);
    // }

    // /**
    //  * Belirli konumdaki lead'leri export etmek için
    //  */
    // public static function exportByLocation($location)
    // {
    //     $leads = Leads::where('location', 'LIKE', "%{$location}%")->get();
    //     return new self($leads);
    // }

    // /**
    //  * Belirli şirket adına sahip lead'leri export etmek için
    //  */
    // public static function exportByCompanyName($companyName)
    // {
    //     $leads = Leads::where('company_name', 'LIKE', "%{$companyName}%")->get();
    //     return new self($leads);
    // }

    // /**
    //  * Yüksek skorlu lead'leri export etmek için (skor 7 ve üzeri)
    //  */
    // public static function exportHighScoreLeads()
    // {
    //     $leads = Leads::where('lead_score', '>=', 7)->get();
    //     return new self($leads);
    // }

    // /**
    //  * Düşük skorlu lead'leri export etmek için (skor 3 ve altı)
    //  */
    // public static function exportLowScoreLeads()
    // {
    //     $leads = Leads::where('lead_score', '<=', 3)->get();
    //     return new self($leads);
    // }
}