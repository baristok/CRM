<?php

namespace Modules\Contacts\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Companies\Models\Companies;

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
            // Barış, eğer company_id'yi rastgele var olan şirketlerden almak istiyorsan şöyle yapabilirsin:
            'company_id' => Companies::inRandomOrder()->first()?->id ?? 1,
            'designation' => $this->faker->jobTitle(),
            'lead_score' => $this->faker->numberBetween(1, 100),
            // 'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
        ];
    }
}

