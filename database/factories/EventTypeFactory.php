<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EventType;
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

$factory->define(EventType::class, function (Faker $faker) {
    return [
        'image' => $faker->imageUrl(1024, 450),
        'status' => $faker->randomElement([0,1])
    ];
});