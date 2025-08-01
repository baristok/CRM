<?php

namespace Modules\Companies\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompaniesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Companies\Models\Companies::class;

    
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'owner_name' => $this->faker->name,
            'industry_type' => $this->faker->randomElement(['Technology', 'Finance', 'Healthcare', 'Education', 'Retail', 'Manufacturing', 'Other']),
            'website' => $this->faker->url,
            'contact_email' => $this->faker->email,
            'rating' => $this->faker->numberBetween(1, 5),
            'employee_count' => $this->faker->numberBetween(1, 1000),
            'location' => $this->faker->city,
            'since' => $this->faker->date('Y-m-d'),
        ];
    }
}

