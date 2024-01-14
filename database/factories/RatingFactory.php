<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Rating::class, function (Faker $faker) {
    return [
            'rating'      => rand(1,5),
            'comment'     => $faker->randomElement(['It is good','it is very good','It is a nice
','fantastic']),
            'approved'    => rand(1,0),
            'user_id'     =>  2,
            'product_id'  =>  $faker->unique()->numberBetween(1,5),
    ];
});
