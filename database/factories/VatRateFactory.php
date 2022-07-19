<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VatRateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {


        return [

            'rate' => $this->faker->randomFloat(2, 20, 100),


            
        ];
    }
}
