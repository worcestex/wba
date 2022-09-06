<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\User;

use App\Models\VatRate;
use App\Models\BidIncrement;
use Illuminate\Database\Eloquent\Factories\Factory;

class LotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $auction = Auction::inRandomOrder()->first();
        $auctionId = $auction->id;
        $seller = User::inRandomOrder()->first();
        $sellerId = $seller->id;
        $bidIncrementId = BidIncrement::inRandomOrder()->first()->id;
        
        $numImages = rand(0,4);
        $imageArray = [];
        for($image = 0; $image < $numImages; $image++){
            $imageUrl = "https://raw.githubusercontent.com/WhiskeyProject/whiskey-api/master/whiskey_images/".rand(1,500).'.png';
            array_push($imageArray,$imageUrl);
        }
        
        return [
            'serial_number' => $this->faker->randomNumber(5, true),
            'auction_id' => $auctionId,
            'seller_id' => $sellerId,

            'bid_increment_id' => $bidIncrementId,
            'name' => $this->faker->name(),
            'distillery' => $this->faker->name(),
            'distillery_status' => $this->faker->name(),
            'country' => $this->faker->name(),
            'region' => $this->faker->name(),
            'size' => strval($this->faker->numberBetween(50, 150)),
            'type' => $this->faker->name(),
            'age' => strval($this->faker->randomDigit()),
            'number_of_bottles' => $this->faker->randomDigit(),
            'fill_level' => $this->faker->randomElement(['low', 'medium', 'high']),
            'strength' => $this->faker->randomFloat(1, 30, 65),
            'shipping_weight' => $this->faker->randomFloat(2, 0, 25),
            'starting_price' => $this->faker->randomFloat(2, 20, 100),
            'images' => $imageArray
        ];
    }
}
