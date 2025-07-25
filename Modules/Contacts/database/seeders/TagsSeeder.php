<?php

namespace Modules\Contacts\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Contacts\Models\Tags;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tags::factory()->count(10)->create();
    }
}
