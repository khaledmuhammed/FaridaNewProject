<?php

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

$factory->define(App\Models\Coupon::class, function (Faker $faker) {
    return [
        'code'            => str_random(10),
        'title'           => $faker->name,
        'calc'            => $faker->randomElement(['fixed', 'percent']),
        'amount'          => 20,
        'couponable_type' => $faker->randomElement([\App\Models\Product::class, \App\Models\Category::class,
            \App\Models\Manufacturer::class]),
        'type'            => $faker->randomElement(['product', 'order']),
        'minimum'         => rand(2, 30),
        'usage_limit'     => 100,
        'start_date'      => now()->subDay(),
        'end_date'        => now()->addDays(30),
    ];
});
