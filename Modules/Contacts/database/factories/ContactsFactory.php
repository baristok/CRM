<?php

namespace Modules\Contacts\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Contacts\Models\Contacts::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'company_name' => $this->faker->company(),
            'designation' => $this->faker->jobTitle(),
            'lead_score' => $this->faker->numberBetween(1, 100),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

