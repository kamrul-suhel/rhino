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
        
        
        $country = Countries::create([
            'name'                      => 'USA',
            'country_code'              => 'US',
            'iso_3166_2'              => 'US',
            'iso_3166_3'              => 'USA',
            'driver_seating_position'   => 'left',
        ]);

      
        $country = Countries::create([
            'name'                      => 'France',
            'country_code'              => 'FR',
            'iso_3166_2'              => 'FR',
            'iso_3166_3'              => 'FRA',
            'driver_seating_position'   => 'left',
        ]);

    }
}
