<?php

namespace Modules\Companies\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Modules\Companies\Models\Companies;
use Illuminate\Support\Facades\Log;

class CompaniesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, WithBatchInserts, WithChunkReading
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            return new Companies([
                'name' => $row['sirket_adi'] ?? $row['name'] ?? '',
                'owner_name' => $row['sahip_adi'] ?? $row['owner_name'] ?? '',
                'industry_type' => $row['sektor_turu'] ?? $row['industry_type'] ?? '',
                'website' => $row['website'] ?? '',
                'contact_email' => $row['iletisim_e_postasi'] ?? $row['contact_email'] ?? '',
                'rating' => (int)($row['degerlendirme'] ?? $row['rating'] ?? 0),
                'employee_count' => (int)($row['calisan_sayisi'] ?? $row['employee_count'] ?? 0),
                'location' => $row['konum'] ?? $row['location'] ?? '',
                'since' => (string)($row['kurulus_tarihi'] ?? $row['since'] ?? ''),
                'image' => null, // Resim import edilmez, manuel yüklenir
            ]);
        } catch (\Exception $e) {
            Log::error('CompaniesImport Error: ' . $e->getMessage(), [
                'row' => $row,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'sirket_adi' => 'required|string|max:255',
            'sahip_adi' => 'required|string|max:255',
            'sektor_turu' => 'required|string|max:255',
            'website' => 'nullable|string|max:255',
            'iletisim_e_postasi' => 'required|email|max:255',
            'degerlendirme' => 'nullable|integer|min:0|max:5',
            'calisan_sayisi' => 'required|integer|min:0',
            'konum' => 'required|string|max:255',
            'kurulus_tarihi' => ['required', 'integer', 'digits:4'],
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'sirket_adi.required' => 'Şirket adı zorunludur.',
            'sirket_adi.string' => 'Şirket adı metin olmalıdır.',
            'sirket_adi.max' => 'Şirket adı en fazla 255 karakter olabilir.',
            
            'sahip_adi.required' => 'Sahip adı zorunludur.',
            'sahip_adi.string' => 'Sahip adı metin olmalıdır.',
            'sahip_adi.max' => 'Sahip adı en fazla 255 karakter olabilir.',
            
            'sektor_turu.required' => 'Sektör türü zorunludur.',
            'sektor_turu.string' => 'Sektör türü metin olmalıdır.',
            'sektor_turu.max' => 'Sektör türü en fazla 255 karakter olabilir.',
            
            'website.string' => 'Website metin olmalıdır.',
            'website.max' => 'Website en fazla 255 karakter olabilir.',
            
            'iletisim_e_postasi.required' => 'İletişim e-postası zorunludur.',
            'iletisim_e_postasi.email' => 'Geçerli bir e-posta adresi giriniz.',
            'iletisim_e_postasi.max' => 'E-posta adresi en fazla 255 karakter olabilir.',
            
            'degerlendirme.integer' => 'Değerlendirme sayı olmalıdır.',
            'degerlendirme.min' => 'Değerlendirme en az 0 olmalıdır.',
            'degerlendirme.max' => 'Değerlendirme en fazla 5 olmalıdır.',
            
            'calisan_sayisi.required' => 'Çalışan sayısı zorunludur.',
            'calisan_sayisi.integer' => 'Çalışan sayısı sayı olmalıdır.',
            'calisan_sayisi.min' => 'Çalışan sayısı en az 0 olmalıdır.',
            
            'konum.required' => 'Konum zorunludur.',
            'konum.string' => 'Konum metin olmalıdır.',
            'konum.max' => 'Konum en fazla 255 karakter olabilir.',
            
            'kurulus_tarihi.required' => 'Kuruluş tarihi zorunludur.',
            'kurulus_tarihi.integer' => 'Kuruluş tarihi sayı olmalıdır.',
            'kurulus_tarihi.min' => 'Kuruluş tarihi en az 0 olmalıdır.',
            'kurulus_tarihi.max' => 'Kuruluş tarihi en fazla 4 olmalıdır.',
        ];
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 1000; // 1000 kayıt batch halinde işlenir
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000; // 1000 kayıt chunk halinde okunur
    }

    /**
     * Hata durumunda ne yapılacağı
     */
    public function onError(\Throwable $e)
    {
        Log::error('CompaniesImport Error: ' . $e->getMessage());
    }

    /**
     * Başlık satırını atla
     */
    public function headingRow(): int
    {
        return 1;
    }

    /**
     * Başlık eşleştirmeleri
     */
    public function headingRowFormatter($heading)
    {
        return strtolower(str_replace(' ', '_', $heading));
    }
}
