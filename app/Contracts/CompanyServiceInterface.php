<?php

namespace App\Contracts;

interface CompanyServiceInterface
{
    /**
     * Şirket ID'sine göre şirket bilgilerini getirir
     */
    public function getCompanyById(int $companyId): ?array;

    /**
     * Tüm şirketleri getirir (dropdown vb. için)
     */
    public function getAllCompanies(): array;

    /**
     * Şirket ID'sine göre şirket adını getirir
     */
    public function getCompanyNameById(int $companyId): ?string;
}
