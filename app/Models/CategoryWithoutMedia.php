<?php

namespace App\Models;

class CategoryWithoutMedia extends Category
{
    protected $appends = [];
    protected $with    = [];
    protected $table   = "categories";

    public function categories()
    {
        return $this->hasMany('App\Models\CategoryWithoutMedia', 'super_category_id');
    }

    public function getThumbnailAttribute()
    {
        return "";
    }
}
