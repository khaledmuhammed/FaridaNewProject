<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // production seeder
        $admin = factory(App\Models\User::class)->create([
            'first_name' => "Admin",
            'last_name'  => "Admin",
            'email'      => "admin@admin.com",
            'password'   => bcrypt('1234'),
            'city_id'    => 1,
            'role_id'    => 1,
        ]);

        if (App::isLocal()) { // testing seeders
            factory(App\Models\User::class)->create([
                'first_name' => "User",
                'last_name'  => "A",
                'email'      => "user@user.com",
                'password'   => bcrypt('1234'),
                'city_id'    => 1,
                'role_id'    => 3,
            ]);
            // factory(App\Models\User::class, 30)->create();
        }
    }
}
