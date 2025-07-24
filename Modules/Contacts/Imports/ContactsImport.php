<?php

namespace Modules\Contacts\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Modules\Contacts\Models\Contacts;

class ContactsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Contacts([
            'name'              => $row['isim'],
            'email'             => $row['e_posta'],
            'phone'             => $row['telefon'],
            'company_name'      => $row['sirket_adi'] ?? null,
            'designation'       => $row['pozisyon'] ?? null,
            'lead_score'        => $row['lead_skoru'] ?? null,
            'tags'              => $row['etiketler'] ?? null,
            'last_contacted_at' => $row['son_iletisim_tarihi'] ?? null,
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'isim'      => 'required',
            'e_posta'   => 'required|email',
            'telefon'   => 'required',
            'sirket_adi'=> 'nullable',
            'pozisyon'  => 'nullable',
            'lead_skoru'=> 'nullable',
            'etiketler' => 'nullable',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'isim.required'     => 'İsim alanı zorunludur.',
            'e_posta.required'  => 'E-posta alanı zorunludur.',
            'e_posta.email'     => 'Geçerli bir e-posta adresi giriniz.',
            'telefon.required'  => 'Telefon alanı zorunludur.',
        ];
    }
}
