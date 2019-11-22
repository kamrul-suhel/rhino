<?php

use App\Brand;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BrandSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        factory(Brand::class, 30)->create();

        $brands = Brand::all();

        $brands->each(function($brand){
            $languages = \App\Language::all();

            $languages->each(function($language) use ($brand){
                $faker = Faker::create();

                \App\BrandTranslation::create([
                    'brand_id' => $brand->id,
                    'language_id' => $language->id,
                    'name' => $faker->text(20) . ' - '.$language->name,
                    'description' => $faker->paragraph . ' - '. $language->name
                ]);
            });
        });
    }
}
