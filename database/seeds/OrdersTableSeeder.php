<?php

use App\Models\User;
use App\Models\OrderHistory;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::isLocal()) { // testing seeders
            // factory(App\Models\Order::class, 20)->create();

            // $clients = User::inRandomOrder()->with('addresses')->whereHas('addresses')->clients()->get();

            // $clients->each(function (User $user) {
            //     factory(App\Models\Order::class, rand(0, 5))->create([
            //         'city_id'         => $user->addresses()->inRandomOrder()->value('city_id'),
            //         'address_details' => $user->addresses()->inRandomOrder()->value('details'),
            //         'username'        => $user->name,
            //         'email'           => $user->email,
            //         'mobile'          => $user->mobile,
            //         'user_id'         => $user->id,
            //         'address_id'      => $user->addresses()->inRandomOrder()->value('id'),
            //     ])->each(function (\App\Models\Order $order) {
            //         factory(App\Models\OrderItem::class, rand(2, 5))->create([
            //             'order_id'       => $order->id,
            //             'orderable_id'   => \App\Models\Product::inRandomOrder()->value('id'),
            //             'orderable_type' => \App\Models\Product::class,
            //         ]);
            //     })->each(function (\App\Models\Order $order) {
            //         for($i = 0; $i < rand(1, 3); $i++) {
            //             $orderHistory             = new OrderHistory();
            //             $orderHistory->notes      = 'رقم الشحنة : 1321212';
            //             $orderHistory->order_id   = $order->id;
            //             $orderHistory->status_id  = \App\Models\Status::inRandomOrder()->value('id');
            //             $orderHistory->sent_email = rand(0, 1);
            //             $orderHistory->sent_sms   = rand(0, 1);
            //             $orderHistory->save();
            //         }
            //     });

            // });

        }
    }
}
