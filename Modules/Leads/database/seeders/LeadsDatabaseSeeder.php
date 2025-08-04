<?php

namespace Modules\Leads\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Leads\Models\Leads;
use Modules\Leads\Models\TagsLeads;

class LeadsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Leads::factory()->count(100)->create();
        TagsLeads::factory()->count(10)->create();
    }
}
