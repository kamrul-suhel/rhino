<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
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

$factory->define(\App\Dealership::class, function (Faker $faker) {
    $startTime = rand(1,54000);
    $endTime = rand($startTime,54000);
    return [
        'group_id' => \App\Group::all()->random()->id,
        'region_id' => \App\Region::all()->random()->id,
        'longitude' => $faker->longitude,
        'latitude' => $faker->latitude,
        'monday_start' => $faker->time('H:i:s', $startTime),
        'monday_end' => $faker->time('H:i:s', $endTime),
        'tuesday_start' => $faker->time('H:i:s', $startTime),
        'tuesday_end' => $faker->time('H:i:s', $endTime),
        'wednesday_start' => $faker->time('H:i:s', $startTime),
        'wednesday_end' => $faker->time('H:i:s', $endTime),
        'thursday_start' => $faker->time('H:i:s', $startTime),
        'thursday_end' => $faker->time('H:i:s', $endTime),
        'friday_start' => $faker->time('H:i:s', $startTime),
        'friday_end' => $faker->time('H:i:s', $endTime),
        'saturday_start' => $faker->time('H:i:s', $startTime),
        'saturday_end' => $faker->time('H:i:s', $endTime),
        'sunday_start' => $faker->time('H:i:s', $startTime),
        'sunday_end' => $faker->time('H:i:s', $endTime)
    ];
});
