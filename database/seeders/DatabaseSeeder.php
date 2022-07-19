<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Lot;
use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            AuctionSeeder::class,
            BidIncrementSeeder::class,
            DeliveryZoneSeeder::class,
            DeliverySubZoneSeeder::class,
            VatRateSeeder::class,
            LotSeeder::class,
            LotCollectionPointSeeder::class,
            ContactSeeder::class,
            LotPickUpMethodSeeder::class,
            LotRulesSeeder::class,
            LotStorageSeeder::class,
            LanguageSeeder::class,
            OrderSeeder::class,
            OrderStatusSeeder::class,
        ]);

        if (User::first() && Auction::first()) {
            $this->call([
                LotSeeder::class
            ]);
        }

        if (Lot::first()) {
            $this->call([
                BidSeeder::class
            ]);
        }

        if (Lot::first() && Bid::first()) {
            $this->call([
                WinningBidSeeder::class
            ]);
        }

    }
}
