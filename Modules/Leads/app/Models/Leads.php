<?php

namespace Modules\Leads\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Leads\Database\Factories\LeadsFactory;

class Leads extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'company',
        'lead_score',
        'phone',
        'location',
        'created_at',
        'image',
    ];

    protected static function newFactory(): LeadsFactory
    {
        return LeadsFactory::new();
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'leads_tags', 'lead_id', 'tag_id');
    }
}
