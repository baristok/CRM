<?php

namespace Modules\Leads\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LeadsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Leads\Models\Leads::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

