<?php

use App\CountyTranslation;
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
            'country_code'              => 'GB',
            'driver_seating_position'   => 'right',
        ]);
        CountyTranslation::create([
           'name'=> 'United Kingdom',
           'language_id' => 1,
           'country_id' => $country->id
        ]);

    }
}
