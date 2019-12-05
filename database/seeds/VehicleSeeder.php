<?php

use App\Vehicle;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Vehicle::class, 30)->create();

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
