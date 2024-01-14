<?php

use Illuminate\Database\Seeder;

class ProductLabelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      if(App::isLocal()){ // testing seeders
        factory(App\Models\ProductLabel::class, 50)->create();
      }
    }
}
