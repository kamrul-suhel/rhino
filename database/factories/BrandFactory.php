<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'logo' => $faker->imageUrl(1024, 450),
        'colour' => $faker->hexcolor,
        'company_id' => \App\Company::all()->random()->id
    ];
});
