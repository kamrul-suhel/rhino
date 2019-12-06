<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Vehicle;
use Faker\Generator as Faker;

$factory->define(Vehicle::class, function (Faker $faker) {
    return [
        'brand_id' => \App\Brand::all()->random()->id,
        'driver_seating_position_left_image' => $faker->imageUrl(1024, 450, 'transport'),
        'driver_seating_position_right_image' => $faker->imageUrl(1024, 450, 'transport'),
    ];
});
