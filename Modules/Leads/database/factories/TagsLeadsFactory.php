<?php

namespace Modules\Leads\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagsLeadsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Leads\Models\TagsLeads::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}

