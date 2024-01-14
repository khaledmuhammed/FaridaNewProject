<?php

use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      if(App::isLocal()){ // testing seeders
        // factory(App\Models\Coupon::class, 10)->create();
      }
    }
}
