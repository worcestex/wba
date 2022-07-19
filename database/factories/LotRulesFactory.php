<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LotRulesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'field' => $this->faker->name(),
            'priority' => $this->faker->numberBetween(0, 5),
            
        ];

    }
}
