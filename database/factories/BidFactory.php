<?php

namespace Database\Factories;

use App\Models\Bid;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BidFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     *
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $userId = $user->id;

        $lot = Lot::inRandomOrder()->first();
        $lotId = $lot->id;

        return [
            'start_date_time' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'lot_id' => $lotId,
            'bid_amount' => $this->faker->randomFloat(2, 20, 100),
            'currency' => $this->faker->randomElement(['GBP', 'EUR', 'NOK', 'USD', 'BTC']),
            'bid_amount_in_currency' => $this->faker->randomFloat(2, 20, 100),
            'winning_bid' => 0,
            'user_id' => $userId
        ];
    }
}
