<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
class CategoryProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      if(App::isLocal()){ // testing seeders
         $products   = \App\Models\Product::all();
         $categories = \App\Models\Category::all();

         $products->each(function ($product) use ($categories) {
            $product->categories()->attach($categories->random(rand(1, 1))->pluck('id'));
         });
       }
    }
}
