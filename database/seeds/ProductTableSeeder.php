<?php

//use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::isLocal()) { // testing seeders
            $faker = Faker\Factory::create();;
            factory(App\Models\Product::class, 5)->create()->each(function ($product) use ($faker) {
                $product->addMedia($faker->image('storage/app/public/', 500, 500, 'food'))->toMediaCollection('images');
                // $product->addMedia($faker->image('storage/app/public/', 500, 500, 'food'))->toMediaCollection('images');
                // $product->addMedia($faker->image('storage/app/public/', 500, 500, 'food'))->toMediaCollection('images');
                // factory(App\Models\ProductOption::class, rand(0, 4))->create([
                //     'product_id' => $product->id,
                // ]);
            });
        }
    }
}
