<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FastOrder extends Model
{
    protected $fillable = [
        'name',
        'mobile',
        'city_id',
        'district',
        'details',
        'status',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
