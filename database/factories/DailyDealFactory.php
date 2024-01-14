<?php

use Faker\Generator as Faker;

$factory->define(App\Models\DailyDeal::class, function (Faker $faker) {
    return [
            'price'      => rand(1,100),
            'quantity'   => rand(1,100),
            'start_date' => $faker->date,
            'end_date'   => $faker->date,
            'product_id' => rand(1,10),

    ];
});
