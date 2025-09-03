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
        'currency',
        'due_date',
        'description',
        'owner_id',
        'owner_type',
        'deals_title_id',
        'position'
    ];

    /**
     * Polymorphic relationship - owner can be Contact or Company
     */
    public function owner()
    {
        return $this->morphTo();
    }

    public function dealsTitle()
    {
        return $this->belongsTo(DealsTitle::class, 'deals_title_id');
    }

    // protected static function newFactory(): DealFactory
    // {
    //     // return DealFactory::new();
    // }


}
