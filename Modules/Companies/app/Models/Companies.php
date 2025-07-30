<?php

namespace Modules\Companies\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
// use Modules\Companies\Database\Factories\CompaniesFactory;

class Companies extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'image',
        'name',
        'owner_name',
        'industry_type',
        'website',
        'contact_email',
        'rating',
        'employee_count',
        'location',
        'since',
    ];

    // protected static function newFactory(): CompaniesFactory
    // {
    //     // return CompaniesFactory::new();
    // }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'owner_name' => $this->owner_name,
            'industry_type' => $this->industry_type,
            'website' => $this->website,
            'contact_email' => $this->contact_email,
            'location' => $this->location,
        ];
    }

    public function searchableAs()
    {
        return 'companies_index';
    }
}
