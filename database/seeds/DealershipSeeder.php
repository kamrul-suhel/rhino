<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DealershipSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        factory(\App\Dealership::class, 100)->create();

        $dealerships = \App\Dealership::all();

        $dealerships->each(function($dealership){
            $languages = \App\Language::all();
            $faker = Faker::create();

            $languages->each(function($language) use ($dealership, $faker){

                \App\DealershipTranslation::create([
                   'language_id' => $language->id,
                   'dealership_id' => $dealership->id,
                   'name' => $faker->text(20). ' - ' . $language->name,
                   'address_line_1' => $faker->address .' - '. $language->country_code,
                   'address_line_2' => $faker->address .' - '. $language->lanugage_code,
                   'address_line_3' => $faker->address .' - '. $language->name,
                   'address_line_4' => $faker->address,
                   'address_line_5' => $faker->address,
                   'address_line_6' => $faker->address,
                    'postcode' => $faker->postcode
                ]);
            });
        });

    }
}
