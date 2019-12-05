<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EventType;
use Carbon\Carbon;
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
    $startDate = Carbon::now()->addDay($faker->randomElement([5,10,15]));
    $endDate = Carbon::create($startDate)->addDay($faker->randomElement([15,20,25]));
    return [
        'dealership_id' => \App\Dealership::all()->random()->id,
        'type_id' => EventType::all()->random()->id,
        'start' => $startDate,
        'end' => $endDate,
        'status' => $faker->randomElement([0,1])
    ];
});
