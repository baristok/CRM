<?php

namespace Modules\Deals\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Deals\Database\Factories\DealsTitleFactory;

class DealsTitle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'default_title'  //true ya da false olacak eğer default ise seederdakileri değilse elle oluşturulmuş title olacak  
    ];

    // protected static function newFactory(): DealsTitleFactory
    // {
    //     // return DealsTitleFactory::new();
    // }

    public function getTitleAttribute()
    {
        return match ($this->id) {
            1 => __('deals.need_to_contact'),
            2 => __('deals.contact_initiated'),
            3 => __('deals.needs_identified'),
            4 => __('deals.meeting_arranged'),
            5 => __('deals.offer_accepted'),
            default => $this->name // Eğer default title değilse name'i döndür
        };
    }

    public function getTitleBadgeClassAttribute()
    {
        return match ($this->id) {
            1 => 'bg-danger-subtle',
            2 => 'bg-success-subtle',
            3 => 'bg-warning-subtle',
            4 => 'bg-info-subtle',
            5 => 'bg-primary-subtle',
            default => 'bg-dark-subtle'
        };
    }

    /**
     * Get the translation key for this deals title
     */
    public function getTranslationKeyAttribute()
    {
        return match ($this->id) {
            1 => 'deals.need_to_contact',
            2 => 'deals.contact_initiated',
            3 => 'deals.needs_identified',
            4 => 'deals.meeting_arranged',
            5 => 'deals.offer_accepted',
            default => null
        };
    }

}
