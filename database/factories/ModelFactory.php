<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {

    return [
    	'first_name' => $faker->firstName,
    	'last_name' => $faker->lastName,
    	'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'mobile_number' => $faker->phoneNumber,
        'birthdate' => $faker->dateTimeThisCentury->format('Y-m-d'),
        'address' => $faker->streetAddress,
        'gender' => 'male',
        'user_level' => $faker->numberBetween($min = 1, $max = 4),
        'active' => true,
    ];
});
