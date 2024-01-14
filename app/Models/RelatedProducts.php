<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelatedProducts extends Model
{
    public $incrementing = false;
    protected $primaryKey = [
        'first_product_id',
        'second_product_id'
    ];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

//###################  Relationships Start #################

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }

//###################  Relationships End ###################


//###################  Scopes Start ########################

    public function scopeRelatedTo($query, $product_id)
    {
        return $query->where('first_product_id', $product_id)
                     ->union('second_product_id', $product_id)
                     ->groupBy($product_id);//distinct($product_id)
    }

//###################  Scopes End ########################
}
