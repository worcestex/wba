<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(50)
            ->create();


//        $faker = Factory::create();;
//        $x = 0;
//        while ($x <= 100000) {
//            $x++;
//            $contact = new Contact();
//            $contact->team_id = 1;
//            $contact->first_name = $faker->firstName;
//            $contact->last_name = $faker->lastName;
//            $contact->email = $faker->email;
//            $contact->source = 'manual';
//            $contact->save();

//    }
    }
}
