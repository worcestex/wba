<?php

namespace Database\Seeders;

use App\Models\LotRules;
use Illuminate\Database\Seeder;

class LotRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LotRules::factory()
            ->count(50)
            ->create();
    }
}
