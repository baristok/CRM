<?php

namespace Modules\Contacts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Modules\Contacts\Database\Factories\ContactsFactory;

class Contacts extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'designation',
        'lead_score',
        // 'tags',   //pivot tablosu için kaldırıldı
        'image',
    ];

    // protected static function newFactory(): ContactsFactory
    // {
    //     // return ContactsFactory::new();
    // }

    // kullanıcıyı kontrol ediyor
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    // pivot tablosu için: contact_id ve tag_id ile ilişkilendirme yapıyoruz.
    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'contacts_tags', 'contact_id', 'tag_id');
    }
    
}
