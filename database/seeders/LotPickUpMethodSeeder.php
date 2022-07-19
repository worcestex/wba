<?php

namespace Database\Seeders;

use App\Models\LotPickUpMethod;
use Illuminate\Database\Seeder;

class LotPickupMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LotPickUpMethod::factory()
            ->count(50)
            ->create();
    }
}
