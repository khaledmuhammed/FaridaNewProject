<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLabel extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'color',
    ];

    protected $appends = ['theName'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function getTheNameAttribute()
    {
        $name = $this->name;

        if (app()->getLocale() == 'ar' && $this->name_ar) {
            $name = $this->name_ar;
        }

        return $name;
    }
}
