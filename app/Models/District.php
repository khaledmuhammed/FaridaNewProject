<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'city_id',
        'district_zone_id',
        'is_active'
    ];

    protected $appends = ['theName','districtZoneShippingPrice'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function districtZone()
    {
        return $this->belongsTo(DistrictZone::class);
    }

    public function getTheNameAttribute()
    {
        $name = $this->name;
        
        if (app()->getLocale() == 'ar' && $this->name_ar) {
            $name = $this->name_ar;
        }
        
        return $name;
    }

    public function getDistrictZoneShippingPriceAttribute()
    {
        return $this->districtZone->shipping_price;
    }
}
