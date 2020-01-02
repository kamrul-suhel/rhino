<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Guest;
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

$factory->define(Guest::class, function (Faker $faker) {
    return [
        'event_id' => \App\Event::all()->random()->id,
        'unique' => generateUniqueIdForGuest(),
        'first_name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'language_id' => 40,
        'surname' => $faker->lastName,
        'address_line_1' => $faker->streetAddress,
        'address_line_2' => $faker->streetName,
        'address_line_3' => $faker->citySuffix,
        'address_line_4' => $faker->state,
        'address_line_5' => $faker->buildingNumber,
        'address_line_6' => $faker->country,
        'postcode' => $faker->postcode,
        'landline' => $faker->phoneNumber,
        'mobile' => $faker->phoneNumber,
        'status' => $faker->randomElement([0,1])
    ];
});
