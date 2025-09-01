<?php

namespace Modules\Contacts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Modules\Contacts\Database\Factories\ContactsFactory;
use App\Contracts\CompanyServiceInterface;

class Contacts extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'designation',
        'lead_score',
        // 'tags',   //pivot tablosu için kaldırıldı
        'company_id',
        'image',
    ];

    protected static function newFactory(): ContactsFactory
    {
        return ContactsFactory::new();
    }

    public function company()
    {
        if (!$this->company_id) {
            return null;
        }
        
        $companyService = app(CompanyServiceInterface::class);
        return $companyService->getCompanyById($this->company_id);
    }
    
    /**
     * Sadece şirket adını getirir (performans için)
     */
    public function getCompanyNameAttribute()
    {
        if (!$this->company_id) {
            return null;
        }
        
        $companyService = app(CompanyServiceInterface::class);
        return $companyService->getCompanyNameById($this->company_id);
    }

    // pivot tablosu için: contact_id ve tag_id ile ilişkilendirme yapıyoruz.
    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'contacts_tags', 'contact_id', 'tag_id');
    }

    /**
     * Scout için aranabilir alanları belirtir
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'designation' => $this->designation,
        ];
    }

    /**
     * Scout index adını özelleştirir
     */
    public function searchableAs()
    {
        return 'contacts_index';
    }
    
}
