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
        return [];
    }
}

