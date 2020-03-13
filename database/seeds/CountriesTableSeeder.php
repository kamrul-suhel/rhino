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

        $country = Countries::create([
            'name'                      => 'United Kingdom',
            'country_code'              => 'GB',
            'iso_3166_2'              => 'GB',
            'iso_3166_3'              => 'GBR',
            'driver_seating_position'   => 'right',
        ]);

    }
}
