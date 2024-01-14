<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'price',
        'is_active',
    ];

    protected $appends = ['theName'];

    public function cashOnDeliveryCities()
    {
        return $this->cities()->wherePivot('has_cash_on_delivery', true);
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, config('database.connections.mysql.database') . '.city_shipping_method');
    }

    public function getTheNameAttribute()
    {
        $name = $this->name;

        if (app()->getLocale() == 'ar' && $this->name_ar) {
            $name = $this->name_ar;
        }

        return $name;
    }
}
