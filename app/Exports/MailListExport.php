<?php

namespace App\Exports;

use App\Models\{User, Order};
use Maatwebsite\Excel\Concerns\FromCollection;

class MailListExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $users  = User::select('first_name', 'email', 'mobile')->distinct()->get();
        $orders = Order::select('username', 'email', 'mobile')->distinct()->get();
        $users->merge($orders);
        return $users;
    }
}
