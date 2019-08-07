<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->slug,
        'description' => $faker->text,
        'defaults' => '{"cost_course":"$faker->numberBetween($min = 50, $max = 5000)","hours":"$faker->numberBetween($min = 28, $max = 32)","old_hours":"0","cost_doctor":"200"}',
    ];
});
