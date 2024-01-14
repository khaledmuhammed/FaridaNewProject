<?php

use Faker\Generator as Faker;

  $factory->state(App\Models\Category::class, 'super',function (Faker $faker) {
      return [
          'super_category_id' => null,
          'thumbnail' => $faker->randomElement(['https://goo.gl/JMFEjX']),
          'is_active' => rand(0,1),
      ];
  });

  $factory->define(App\Models\Category::class, function (Faker $faker) {
      return [
          'name' => $faker->name,
          'thumbnail' => $faker->randomElement(['https://goo.gl/JMFEjX']),
          'is_active' => rand(0,1),
      ];
  });
