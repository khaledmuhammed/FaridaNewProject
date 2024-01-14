<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name'    => 'admin',
                'name_ar' => 'مدير',
            ],
            [
                'name'    => 'employee',
                'name_ar' => 'موظف',
            ],
            [
                'name'    => 'client',
                'name_ar' => 'عميل',
            ]
        ]);

    }
}
