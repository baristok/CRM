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
        'tags',
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
    
}
