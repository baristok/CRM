<?php

namespace Modules\Deals\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DealFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Deals\Models\Deal::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $dealsTitleIds = \Modules\Deals\Models\DealsTitle::pluck('id')->toArray();
        $contactIds = \Modules\Contacts\Models\Contacts::pluck('id')->toArray();
        
        $dealsTitleId = $this->faker->randomElement($dealsTitleIds);
        
        // Bu deals_title için mevcut en yüksek pozisyonu bul ve +1 ekle
        $maxPosition = \Modules\Deals\Models\Deal::where('deals_title_id', $dealsTitleId)->max('position') ?? 0;
        
        return [
            'title' => $this->faker->sentence(3),
            'value' => $this->faker->numberBetween(5000, 100000),
            'due_date' => $this->faker->dateTimeBetween('now', '+3 months'),
            'description' => $this->faker->paragraph(),
            'contact_id' => $this->faker->randomElement($contactIds),
            'deals_title_id' => $dealsTitleId,
            'position' => $maxPosition + 1,
        ];
    }
}

