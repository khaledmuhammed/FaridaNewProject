<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Position::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['main menu','Submenu','Side menu']),
        'name_ar' => $faker->randomElement(['القائمة الرئيسية','القائمة الفرعية','القائمة الجانبية']),
    ];
});
