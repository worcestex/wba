<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     *
     * $table->string('contact_number');
     **/
    /*
    $table->string('mobile_number');
    $table->boolean('allowed_to_bid');
    $table->boolean('business_member');
    $table->boolean('no_fees');
    $table->string('address_1');
    $table->string('address_2');
    $table->string('city');
    $table->string('country');
    $table->string('postcode');
    $table->string('bank_account');
    $table->string('iban');
    $table->string('swift_bic');
    $table->string('billing_name');
    $table->string('paypal_email');
    $table->string('transferwise_email');
    $table->string('transferwise_name');
    $table->string('transferwise_iban');
    $table->string('payment_method');
    $table->json('note');
     */


    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'username' => $this->faker->username(),
            'user_id' => $this->faker->numberBetween(10000, 1000000000),
            'contact_number' => $this->faker->phoneNumber(),
            'mobile_number' => $this->faker->phoneNumber(),
            'allowed_to_bid' => $this->faker->boolean(),
            'business_member' => $this->faker->boolean(),
            'no_fees' => $this->faker->boolean(),
            'address_1' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'postcode' => $this->faker->postcode(),
            'bank_account' => $this->faker->postcode(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'billing_address_1' => $this->faker->boolean(50) ? $this->faker->address() : null,
            'billing_address_2' => $this->faker->boolean(50) ? $this->faker->address() : null,
            'billing_postcode' => $this->faker->boolean(50) ? $this->faker->postcode() : null,
            'billing_county' => $this->faker->boolean(50) ? $this->faker->country() : null,

            'is_billing_shipping' => $this->faker->boolean(50) ? $this->faker->boolean() : null,

            'shipping_address_1' => $this->faker->boolean(50) ? $this->faker->address() : null,
            'shipping_address_2' => $this->faker->boolean(50) ? $this->faker->address() : null,
            'shipping_postcode' => $this->faker->boolean(50) ? $this->faker->postcode() : null,
            'shipping_county' => $this->faker->boolean(50) ? $this->faker->country() : null,



        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
