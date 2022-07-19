<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Lot;


class LotStorageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lotid = Lot::inRandomOrder()->first()->id;
        $userid = User::inRandomOrder()->first()->id;


        return [
            'lot_id' => $lotid,
            'buyer_id' => $userid,
            'expires_at' => $this->faker->dateTimeBetween('0 week', '+2 week'),

            
        ];

    }
}
