<?php

namespace Modules\Leads\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Leads\Database\Factories\TagsFactory;

class Tags extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): TagsFactory
    // {
    //     return TagsFactory::new();
    // }

    public function leads()
    {
        return $this->belongsToMany(Leads::class, 'leads_tags', 'tag_id', 'lead_id');
    }
}
