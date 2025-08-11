<?php

namespace Modules\Notes\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotesTagsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Notes\Models\NotesTags::class;

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

