<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\VatRate;


class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $vat_rate_id = VatRate::inRandomOrder()->first()->id;
        //$buyer_id = User::inRandomOrder()->first()->id;
        //$order_status_id = OrderStatus::inRandomOrder()->first()->id;


        return [
            'order_id' => $this->faker->numberBetween(1, 50),
            
            'payment_method' => $this->faker->randomElement(['Cheque', 'Cash', 'Visa']),
            'shipping_service' => $this->faker->name(),
            'starting_price' => $this->faker->randomFloat(2, 20, 100),
            'number_of_boxes' => $this->faker->numberBetween(1, 50),
            'billing_country' =>  $this->faker->country(),
            'cost' => $this->faker->randomFloat(2, 20, 100),
            'is_shipped' => $this->faker->boolean(),
            'shipment_details' => $this->faker->text(),
            'is_confirmation_sent' => $this->faker->boolean(),
            'delivery_cost' => $this->faker->randomFloat(2, 20, 100),
            'vat_amount' => $this->faker->randomFloat(2, 20, 100),
            'total_amount' => $this->faker->randomFloat(2, 20, 100),
            'is_payment_confirmed' => $this->faker->boolean(),
            'client_ip' => $this->faker->ipv4(),



            'vat_percentage_id' => $vat_rate_id,
            'buyer_id'=> $this->faker->numberBetween(1, 50),
            'order_status_id' => $this->faker->numberBetween(1, 50)
        ];
    }
}
