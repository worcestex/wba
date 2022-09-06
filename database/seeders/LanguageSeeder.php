<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'language_code' => 'en',
        ]);
        Language::create([  
                      'language_code' => 'zh',
        ]);
        Language::create([
                        'language_code' => 'fr',
        ]);
        Language::create([
                        'language_code' => 'es',
        ]);
        /*
        Language::factory()
            ->count(5)
            ->create();
            */
            }
}
