<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliverySubZone;

class DeliverySubZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeliverySubZone::factory()
            ->count(50)
            ->create();
    }
}
