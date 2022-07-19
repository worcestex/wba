<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $starts_at = Carbon::createFromTimestamp($this->faker->dateTimeBetween('-1 weeks', '+1 weeks')->getTimeStamp()) ;
        $ends_at = Carbon::createFromTimestamp($this->faker->dateTimeBetween('+2 weeks', '+4 weeks')->getTimeStamp()) ;

        
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'start_date_time' => $starts_at,
            'end_date_time' => $ends_at,
            'lots' => $this->faker->numberBetween(50, 550),
            'views' => $this->faker->numberBetween(50, 150),
            'is_active' => $this->faker->boolean()
        ];
    }
}
