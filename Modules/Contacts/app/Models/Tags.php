<?php

namespace Modules\Contacts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Contacts\Database\Factories\TagsFactory;

class Tags extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
    ];

    protected static function newFactory(): TagsFactory
    {
        return TagsFactory::new();
    }
    
    // Etiketin bağlı olduğu kişiler
    public function contacts()
    {
        return $this->belongsToMany(Contacts::class, 'contacts_tags', 'tag_id', 'contact_id');
    }
}
