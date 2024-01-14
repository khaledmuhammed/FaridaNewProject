<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Country extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 
        'name_ar',
    ];

    protected $appends = ['theName'];

    public function cities()
    {
        return $this->hasMany(City::class);
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
