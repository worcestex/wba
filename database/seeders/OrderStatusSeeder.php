<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderStatus;


class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::create([
            'status' => 'Registered',
            'email_text' => 'Thank you for registering a lot'
        ]);
        OrderStatus::create([
            'status' => 'On Auction',
            'email_text' => 'Your lot is now on auction'
        ]);
        OrderStatus::create([
            'status' => 'Lot Successful',
            'email_text' => 'Your lot has won, awaiting buyer to purchase'
        ]);
        OrderStatus::create([
            'status' => 'Lot Storage',
            'email_text' => 'Your auction has put into storage'
        ]);
        OrderStatus::create([
            'status' => 'Lot Paid',
            'email_text' => 'Your lot has been paided for'
        ]);
        OrderStatus::create([
            'status' => 'Refunded',
            'email_text' => 'Your lot has been refunded'
        ]);
    }
}
