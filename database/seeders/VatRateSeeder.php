<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VatRate;


class VatRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VatRate::factory()
            ->count(50)
            ->create();
    }
}
