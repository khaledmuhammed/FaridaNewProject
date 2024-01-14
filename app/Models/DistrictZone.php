<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistrictZone extends Model
{
    protected $fillable = [
        'name',
        'city_id',
        'shipping_price',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}

