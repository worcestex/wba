<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Lot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WinningBidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lots = Lot::all();

        foreach ($lots as $lot) {
            $bid = $lot->bids()->orderBy('bid_amount', 'DESC')->first();
            if ($bid){
                $bid->update(['winning_bid' => true]);
            }
        }

    }
}
