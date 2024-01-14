<?php

use Illuminate\Database\Seeder;


class ProductAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      if(App::isLocal()){ // testing seeders
        factory(App\Models\ProductAttribute::class, 50)->create();
      }
    }
}
