<?php

use Illuminate\Database\Seeder;
use ErnySans\Laraworld\Models\Countries;
use Faker\Factory as Faker;

class CountriesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        // Empty the table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Countries::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get all from the JSON file
        $JSON_countries = Countries::allJSON();

        $faker = Faker::create();
        $count = 0;

        foreach ($JSON_countries as $country) {

            if ( $country['region_code'] == "150"){ // Onlys adds European countries

                $country = Countries::create([
                    'name'                      => ((isset($country['name'])) ? $country['name'] : null),
                    'country_code'              => ((isset($country['iso_3166_2'])) ? $country['country_code'] : null),
                    'iso_3166_2'              => ((isset($country['iso_3166_2'])) ? $country['country_code'] : null),
                    'iso_3166_3'              => ((isset($country['iso_3166_3'])) ? $country['country_code'] : null),
                    'driver_seating_position'   => $faker->randomElement(['right', 'left']),
                ]);
            }

        }

    }
}
