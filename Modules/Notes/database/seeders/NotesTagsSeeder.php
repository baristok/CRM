<?php

namespace Modules\Notes\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Notes\Models\NotesTags;

class NotesTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([]);
        NotesTags::factory()->count(10)->create();
    }
}
