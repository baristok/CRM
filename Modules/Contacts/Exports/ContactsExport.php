<?php

namespace Modules\Contacts\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Contacts\Models\Contacts;

class ContactsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Contacts::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'İsim',
            'E-posta',
            'Telefon',
            'Şirket Adı',
            'Pozisyon',
            'Lead Skoru',
            'Etiketler',
            'Son İletişim Tarihi',
            'Oluşturulma Tarihi',
            'Güncellenme Tarihi'
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->email,
            $row->phone,
            $row->company_name,
            $row->designation,
            $row->lead_score,
            $row->tags,
            $row->last_contacted_at,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
