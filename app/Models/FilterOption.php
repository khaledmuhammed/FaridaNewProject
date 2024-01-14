<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilterOption extends Model
{
    protected $fillable = ['name', 'name_ar', 'filter_id'];

    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
