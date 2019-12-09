<?php

use App\Vehicle;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Empty the table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Vehicle::truncate();
        \App\VehicleTranslation::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(Vehicle::class, 300)->create();

        $vehicles = Vehicle::all();

        $vehicles->each(function($vehicle){
            $languages = \App\Language::all();

            $languages->each(function($language) use ($vehicle){
                $faker = Faker::create();

                \App\VehicleTranslation::create([
                    'vehicle_id' => $vehicle->id,
                    'language_id' => $language->id,
                    'model' => $faker->text(20),
                ]);
            });
        });
    }
}
