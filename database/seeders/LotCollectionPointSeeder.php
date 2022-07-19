<?php

namespace Database\Seeders;

use App\Models\LotCollectionPoint;
use Illuminate\Database\Seeder;

class LotCollectionPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LotCollectionPoint::factory()
            ->count(50)
            ->create();
    }
}
