<?php

namespace Database\Seeders;

use App\Models\LotStorage;
use Illuminate\Database\Seeder;

class LotStorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LotStorage::factory()
            ->count(50)
            ->create();
    }
}
