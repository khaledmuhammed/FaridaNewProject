<?php

namespace App\Models;

use App\Models\City;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderReceiver extends Model
{

    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }
}
