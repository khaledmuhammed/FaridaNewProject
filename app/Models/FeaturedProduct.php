<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedProduct extends Model
{
    protected $fillable = ['title', 'title_ar'];

    protected $appends = ['theTitle'];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'featured_products_items');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function positions()
    {
        return $this->morphToMany(Position::class, 'positionable');
    }

    public function getTheTitleAttribute()
    {
        $title = $this->title;

        if (app()->getLocale() == 'ar' && $this->title_ar) {
            $title = $this->title_ar;
        }

        return $title;
    }
}
