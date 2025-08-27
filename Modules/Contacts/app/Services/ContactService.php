<?php

namespace Modules\Contacts\Services;

use App\Contracts\ContactServiceInterface;
use Modules\Contacts\Models\Contacts;

class ContactService implements ContactServiceInterface
{
    /**
     * Contact ID'sine göre contact bilgilerini getirir
     */
    public function getContactById(int $contactId): ?array
    {
        $contact = Contacts::find($contactId);
        
        if (!$contact) {
            return null;
        }

        return [
            'id' => $contact->id,
            'name' => $contact->name,
            'email' => $contact->email,
            'phone' => $contact->phone,
            'company_name' => $contact->company_name,
            'designation' => $contact->designation,
            'lead_score' => $contact->lead_score,
            'company_id' => $contact->company_id,
            'image' => $contact->image,
        ];
    }

    /**
     * Tüm contactları getirir (dropdown vb. için)
     */
    public function getAllContacts(): array
    {
        return Contacts::select('id', 'company_name', 'contact_email')
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    /**
     * Contact ID'sine göre contact adını getirir
     */
    public function getContactNameById(int $contactId): ?string
    {
        $contact = Contacts::find($contactId);
        return $contact ? $contact->name : null;
    }
}
