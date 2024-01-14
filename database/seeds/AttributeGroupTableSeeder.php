<?php

use Illuminate\Database\Seeder;

class AttributeGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      if(App::isLocal()){ // testing seeders
         factory(App\Models\AttributeGroup::class, 40)->create();
       }
    }
}
