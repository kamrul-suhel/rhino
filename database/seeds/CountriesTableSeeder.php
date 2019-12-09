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

        foreach ($JSON_countries as $country) {
            $country = Countries::create([
                'capital'           => ((isset($country['capital'])) ? $country['capital'] : null),
                'citizenship'       => ((isset($country['citizenship'])) ? $country['citizenship'] : null),
                'country_code'      => ((isset($country['country_code'])) ? $country['country_code'] : null),
                'currency'          => ((isset($country['currency'])) ? $country['currency'] : null),
                'currency_code'     => ((isset($country['currency_code'])) ? $country['currency_code'] : null),
                'currency_sub_unit' => ((isset($country['currency_sub_unit'])) ? $country['currency_sub_unit'] : null),
                'full_name'         => ((isset($country['full_name'])) ? $country['full_name'] : null),
                'iso_3166_2'        => ((isset($country['iso_3166_2'])) ? $country['iso_3166_2'] : null),
                'iso_3166_3'        => ((isset($country['iso_3166_3'])) ? $country['iso_3166_3'] : null),
                'name'              => ((isset($country['name'])) ? $country['name'] : null),
                'region_code'       => ((isset($country['region_code'])) ? $country['region_code'] : null),
                'sub_region_code'   => ((isset($country['sub_region_code'])) ? $country['sub_region_code'] : null),
                'eea'               => (bool)$country['eea'],
                'calling_code'      => ((isset($country['calling_code'])) ? $country['calling_code'] : null),
                'driver_seating_position'      => $faker->randomElement(['right', 'left']),
                'currency_symbol'   => ((isset($country['currency_symbol'])) ? $country['currency_symbol'] : null),
            ]);
        }
    }
}
