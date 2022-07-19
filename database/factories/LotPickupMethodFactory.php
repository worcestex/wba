<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LotPickupMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'has_date_picker' => $this->faker->boolean(),
            'has_collection_points' => $this->faker->boolean(),
            'sends_reminder' => $this->faker->boolean(),
            'reminder' => $this->faker->text(),

            
        ];

    }
}
