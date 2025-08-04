<?php

namespace Modules\Contacts\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Contacts\Models\Contacts;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contacts::factory()->count(50)->create();
    }
}
