<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::isLocal()) { // testing seeders
            factory(App\Models\Category::class, 1)->states('super')->create([
                'name' => "القسم الأول"
            ])->each(function (App\Models\Category $sc) {
                factory(App\Models\Category::class, rand(5, 10))->create([
                    'super_category_id' => $sc->id
                ]);
            });
            factory(App\Models\Category::class, 1)->states('super')->create([
                'name' => "القسم الثاني"
            ])->each(function (App\Models\Category $sc) {
                factory(App\Models\Category::class, rand(5, 10))->create([
                    'super_category_id' => $sc->id
                ]);
            });
            factory(App\Models\Category::class, 1)->states('super')->create([
                'name' => "القسم الثالث"
            ])->each(function (App\Models\Category $sc) {
                factory(App\Models\Category::class, rand(5, 10))->create([
                    'super_category_id' => $sc->id
                ]);
            });
            factory(App\Models\Category::class, 1)->states('super')->create([
                'name' => "القسم الرابع"
            ])->each(function (App\Models\Category $sc) {
                factory(App\Models\Category::class, rand(5, 10))->create([
                    'super_category_id' => $sc->id
                ]);
            });

        }
    }
}
