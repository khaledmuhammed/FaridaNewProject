<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProductLabel::class, function (Faker $faker) {
    return [
           'name' => $faker->name,
           'color' => $faker->colorName,
    ];
});
