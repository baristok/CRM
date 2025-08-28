<?php

namespace Modules\Deals\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\ContactServiceInterface;
// use Modules\Deals\Database\Factories\DealFactory;

class Deal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'value',
        'due_date',
        'description',
        'contact_id',
        'deals_title_id',
        'position'
    ];

    public function contact()
    {
        if (!$this->contact_id) {
            return null;
        }
        
        $contactService = app(ContactServiceInterface::class);
        return $contactService->getContactById($this->contact_id);
    }

    // protected static function newFactory(): DealFactory
    // {
    //     // return DealFactory::new();
    // }


}
