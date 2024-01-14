<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Banner::class, function (Faker $faker) {
    return [
        'title' => $faker->randomElement(['الأكثر مبيعا', 'منتجات جديدة', 'منتجات مميزة']),
        'size'  => $faker->randomElement([3,6,9,12]) ,
    ];
});
