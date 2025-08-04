<?php

namespace Modules\Contacts\Database\Seeders;

use Illuminate\Database\Seeder;

class ContactsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            ContactsSeeder::class,
            TagsSeeder::class,
        ]);
    }
}
