<?php

namespace Modules\Companies\Services;

use App\Contracts\CompanyServiceInterface;
use Modules\Companies\Models\Companies;

class CompanyService implements CompanyServiceInterface
{
    /**
     * Şirket ID'sine göre şirket bilgilerini getirir
     */
    public function getCompanyById(int $companyId): ?array
    {
        $company = Companies::find($companyId);
        
        if (!$company) {
            return null;
        }

        return [
            'id' => $company->id,
            'name' => $company->name,
            'owner_name' => $company->owner_name,
            'industry_type' => $company->industry_type,
            'website' => $company->website,
            'contact_email' => $company->contact_email,
            'rating' => $company->rating,
            'employee_count' => $company->employee_count,
            'location' => $company->location,
            'since' => $company->since,
            'image' => $company->image,
        ];
    }

    /**
     * Tüm şirketleri getirir (dropdown vb. için)
     */
    public function getAllCompanies(): array
    {
        return Companies::select('id', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    /**
     * Şirket ID'sine göre şirket adını getirir
     */
    public function getCompanyNameById(int $companyId): ?string
    {
        $company = Companies::find($companyId);
        return $company ? $company->name : null;
    }
}
