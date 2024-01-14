<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $dates    = [
        'created_at',
        'updated_at'
    ];
    protected $fillable = [
        'text',
        'attribute_id',
        'product_id',
    ];


    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function attribute()
    {
        return $this->belongsTo('App\Models\Attribute');
    }
}
