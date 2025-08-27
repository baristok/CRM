<?php

namespace App\Contracts;

interface ContactServiceInterface
{
    /**
     * Contact ID'sine göre contact bilgilerini getirir
     */
    public function getContactById(int $contactId): ?array;

    /**
     * Tüm contactları getirir (dropdown vb. için)
     */
    public function getAllContacts(): array;

    /**
     * Contact ID'sine göre contact adını getirir
     */
    public function getContactNameById(int $contactId): ?string;
}