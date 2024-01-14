<?php

use Illuminate\Database\Seeder;

class FeaturedProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $featured = \App\Models\FeaturedProduct::create([
            'title' => "المنتجات المميزة"
        ]);
        $featured->products()->saveMany(\App\Models\Product::inRandomOrder()->take(5)->get());
        $featured->positions()->save(\App\Models\Position::find(1), ['sort' => 1]);
    }
}
