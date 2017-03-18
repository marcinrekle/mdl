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
    static $password;
    return [
        'name' 			=> $faker->name,
        'email' 		=> $faker->safeEmail,
        'password' 		=> bcrypt('haslo'),
        'social_id' 	=> $faker->numberBetween($min = 100000, $max = 9999999),
        'avatar' 		=> $faker->imageUrl($width = 30, $height = 30),
        'remember_token'=> str_random(10),
        'social_token' 	=> str_random(10),
        'confirmed'     => '1',
        'confirm_code'  => str_random(16)
    ];
});
