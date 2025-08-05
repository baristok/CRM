<?php

namespace Modules\Leads\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Leads\Database\Factories\LeadsFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Modules\Leads\Models\TagsLeads;

class Leads extends Model
{
    use HasFactory, Searchable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'company_name',
        'lead_score',
        'phone',
        'location',
        'created_date',
        'image',
    ];

    protected static function newFactory(): LeadsFactory
    {
        return LeadsFactory::new();
    }

    public function tags()
    {
        return $this->belongsToMany(TagsLeads::class, 'leads_tags', 'lead_id', 'tag_id');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company_name' => $this->company_name,
            'lead_score' => $this->lead_score,
            'phone' => $this->phone,
            'location' => $this->location,  
        ];
    }

    public function searchableAs(): string
    {
        return 'leads_index';
    }
    
}
