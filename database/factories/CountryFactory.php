<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Country::class, function (Faker $faker) {
    return [
        'name'       => $faker->country,
        'name_ar'    => $faker->country,
    ];
});
