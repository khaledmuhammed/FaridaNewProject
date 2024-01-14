<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Position extends Model
{
    protected $fillable = ['name', 'name_ar'];

    public function banners()
    {
        return $this->morphedByMany(Banner::class, 'positionable', 'positionables', 'position_id', 'positionable_id')->withPivot('sort');
    }

    public function featuredProducts()
    {
        return $this->morphedByMany(FeaturedProduct::class, 'positionable', 'positionables')->withPivot('sort');

    }

}
