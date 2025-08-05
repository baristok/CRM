<?php

namespace Modules\Leads\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Modules\Leads\Models\Leads;
use Illuminate\Support\Facades\Log;

class LeadsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, WithBatchInserts, WithChunkReading
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            return new Leads([
                'name' => $row['musteri_adi'] ?? $row['name'] ?? '',
                'company_name' => $row['sirket_adi'] ?? $row['company_name'] ?? '',
                'lead_score' => (int)($row['musteri_puani'] ?? $row['lead_score'] ?? 0),
                'phone' => $row['telefon'] ?? $row['phone'] ?? '',
                'location' => $row['konum'] ?? $row['location'] ?? '',
                'created_date' => $row['olusturma_tarihi'] ?? $row['created_date'] ?? now(),
                'image' => null, // Resim import edilmez, manuel yüklenir
            ]);
        } catch (\Exception $e) {
            Log::error('LeadsImport Error: ' . $e->getMessage(), [
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
            'musteri_adi' => 'required|string|max:255',
            'sirket_adi' => 'required|max:255',
            'musteri_puani' => 'nullable|integer|min:0|max:100',
            'telefon' => 'required|string|max:20',
            'konum' => 'required|string|max:255',
            'olusturma_tarihi' => 'nullable|date',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'musteri_adi.required' => 'Müşteri adı zorunludur.',
            'musteri_adi.string' => 'Müşteri adı metin olmalıdır.',
            'musteri_adi.max' => 'Müşteri adı en fazla 255 karakter olabilir.',
            
            'sirket_adi.required' => 'Şirket adı zorunludur.',
            'sirket_adi.string' => 'Şirket adı metin olmalıdır.',
            'sirket_adi.max' => 'Şirket adı en fazla 255 karakter olabilir.',
            
            'musteri_puani.integer' => 'Müşteri puanı sayı olmalıdır.',
            'musteri_puani.min' => 'Müşteri puanı en az 0 olmalıdır.',
            'musteri_puani.max' => 'Müşteri puanı en fazla 100 olmalıdır.',
            
            'telefon.required' => 'Telefon numarası zorunludur.',
            'telefon.string' => 'Telefon numarası metin olmalıdır.',
            'telefon.max' => 'Telefon numarası en fazla 20 karakter olabilir.',
            
            'konum.required' => 'Konum zorunludur.',
            'konum.string' => 'Konum metin olmalıdır.',
            'konum.max' => 'Konum en fazla 255 karakter olabilir.',
            
            'olusturma_tarihi.date' => 'Oluşturma tarihi geçerli bir tarih olmalıdır.',
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
        Log::error('LeadsImport Error: ' . $e->getMessage());
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
