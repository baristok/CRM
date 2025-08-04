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
        return [
            'name' => $this->faker->name(),
            'company' => $this->faker->company(),
            'lead_score' => $this->faker->numberBetween(1, 100),
            'phone' => $this->faker->numerify('05#########'),
            'location' => $this->faker->city(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

