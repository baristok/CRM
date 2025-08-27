<?php

namespace Modules\Deals\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DealsTitleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Deals\Models\DealsTitle::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

