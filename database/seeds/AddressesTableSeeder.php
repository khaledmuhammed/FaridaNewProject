<?php

use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      if(App::isLocal()){ // testing seeders
        // factory(App\Models\Address::class, 30)->create();
      }
    }
}
