<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
//###################  Cast Start ########################

    protected $dates = [
        'created_at',
        'updated_at'
    ];

//###################  Cast End ########################

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product');
    }
}
