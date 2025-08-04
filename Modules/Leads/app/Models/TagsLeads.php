<?php

namespace Modules\Leads\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Leads\Database\Factories\TagsLeadsFactory;

class TagsLeads extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
    ];

    protected static function newFactory(): TagsLeadsFactory
    {
        return TagsLeadsFactory::new();
    }
    
    // Etiketin bağlı olduğu lead'ler
    public function leads()
    {
        return $this->belongsToMany(Leads::class, 'leads_tags', 'tag_id', 'lead_id');
    }
}
