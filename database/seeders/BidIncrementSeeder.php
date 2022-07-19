<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\BidIncrement;
use Illuminate\Database\Seeder;

class BidIncrementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bidIncrements = [
            [
                'min_bid' => 0,
                'max_bid' => 24.99,
                'step_size' => 2.50,
            ],
            [
                'min_bid' => 25,
                'max_bid' => 99.99,
                'step_size' => 5,
            ],
            [
                'min_bid' => 100,
                'max_bid' => 249.99,
                'step_size' => 5,
            ],
            [
                'min_bid' => 250,
                'max_bid' => 599.99,
                'step_size' => 10,
            ],
            [
                'min_bid' => 600,
                'max_bid' => 999.99,
                'step_size' => 25,
            ],
            [
                'min_bid' => 1000,
                'max_bid' => 9999999999.99,
                'step_size' => 50,
            ]
        ];

        foreach ($bidIncrements as $bidIncrement) {
            BidIncrement::create($bidIncrement);
        }
    }
}
