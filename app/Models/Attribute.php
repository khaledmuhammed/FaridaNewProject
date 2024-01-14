<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'attribute_group_id',
    ];

//###################  Relationships Start #################

    public function attributeGroup()
    {
        return $this->belongsTo('App\Models\AttributeGroup');
    }

    public function productAttributes()
    {
        return $this->belongsToMany('App\Models\Product', 'product_attributes');
    }

//###################  Relationships End ###################


//###################  Scopes Start ########################

    public function ScopeAttributeGroup($query, $attribute_group_id)
    {
        return $query->where('attribute_group_id', $attribute_group_id);
    }

//###################  Scopes End ########################
}
