<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use App\Region;
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

$factory->define(\App\BrandDealership::class, function (Faker $faker) {
    $brand = Brand::all()->random();
    $regionId = Region::where('brand_id', $brand->id)->get()->random()->id;
    $dealershipId = \App\Dealership::all()->random()->id;

    return [
        'brand_id' => $brand->id,
        'region_id' => $regionId,
        'dealership_id' => $dealershipId
    ];
});
