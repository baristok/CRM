<?php

namespace Modules\Deals\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Deals\Models\DealsTitle;
class DealsTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->defaultTitles();
    }

    public function defaultTitles()
    {
        $defaultTitles = [
            ['name' => 'Need to Contact', 'default_title' => true],
            ['name' => 'Contact Initiated', 'default_title' => true],
            ['name' => 'Needs Identified', 'default_title' => true],
            ['name' => 'Meeting Arranged', 'default_title' => true],
            ['name' => 'Proposal Sent', 'default_title' => true],
        ];

        foreach ($defaultTitles as $title) {
            DealsTitle::updateOrCreate(
                ['name' => $title['name']],
                $title
            );
        }
    }
}
