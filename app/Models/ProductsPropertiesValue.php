<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsPropertiesValue extends Model
{
    protected $fillable = ['products_property_id', 'value', 'value_en', 'sort_order'];

    public function property(){
        return $this->belongsTo(ProductsProperty::class, 'products_property_id');
    }
    
    public function products(){
        return $this->belongsToMany(Product::class, 'product_property', 'property_value_id', 'product_id')->withPivot('stock');
    }
}
