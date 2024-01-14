<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{


    protected $fillable = ['name', 'name_ar'];

//###################  Relationships Start #################

    public function categories()
    {
        return $this->belongsTo(CategoryWithoutMedia::class);
    }

    public function options()
    {
        return $this->hasMany(FilterOption::class);
    }

//###################  Relationships End ###################


//###################  Scopes Start ########################

    public function scopeCategory($query, $category_id)
    {
        return $query->where('category_id', $category_id);
    }

    public function scopeForCategories($query, $category_ids)
    {
        return $query->join('category_filter', function ($join) use ($category_ids) {
            $join->on('filters.id', '=', 'category_filter.filter_id')
                 ->whereIn('category_filter.category_id', $category_ids);
        });
    }

//###################  Scopes End ########################
}
