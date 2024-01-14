<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'name_ar', 'country_id'];

    protected $appends = ['theName'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }

    public function shippingMethods()
    {
        return $this->belongsToMany(ShippingMethod::class, config('database.connections.mysql.database') . '.city_shipping_method');
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
