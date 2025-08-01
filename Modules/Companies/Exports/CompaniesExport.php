<?php

namespace Modules\Companies\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Modules\Companies\Models\Companies;

class CompaniesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $companies;

    public function __construct($companies = null)
    {
        $this->companies = $companies ?? Companies::all();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->companies;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Şirket Adı',
            'Sahip Adı',
            'Sektör Türü',
            'Website',
            'İletişim E-postası',
            'Değerlendirme',
            'Çalışan Sayısı',
            'Konum',
            'Kuruluş Tarihi',
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
            $row->owner_name,
            $row->industry_type,
            $row->website ?? '-',
            $row->contact_email,
            $row->rating,
            $row->employee_count,
            $row->location,
            $row->since,
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
            'A1:L' . ($sheet->getHighestRow()) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Belirli tarih aralığındaki şirketleri export etmek için
     */
    public static function exportByDateRange($startDate, $endDate)
    {
        $companies = Companies::whereBetween('created_at', [$startDate, $endDate])->get();
        return new self($companies);
    }

    /**
     * Belirli sektördeki şirketleri export etmek için
     */
    public static function exportByIndustry($industryType)
    {
        $companies = Companies::where('industry_type', $industryType)->get();
        return new self($companies);
    }

    /**
     * Belirli konumdaki şirketleri export etmek için
     */
    public static function exportByLocation($location)
    {
        $companies = Companies::where('location', 'LIKE', "%{$location}%")->get();
        return new self($companies);
    }

    /**
     * Değerlendirmeye göre şirketleri export etmek için
     */
    public static function exportByRating($rating)
    {
        $companies = Companies::where('rating', $rating)->get();
        return new self($companies);
    }
}
