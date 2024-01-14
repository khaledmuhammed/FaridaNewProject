<?php

use Illuminate\Database\Seeder;

class DailyDealTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      if(App::isLocal()){ // testing seeders
        // factory(App\Models\DailyDeal::class, 60)->create();
      }
    }
}
