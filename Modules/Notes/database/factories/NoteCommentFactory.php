<?php

namespace Modules\Notes\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NoteCommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Notes\Models\NoteComment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

