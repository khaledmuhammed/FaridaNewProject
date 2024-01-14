<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\Media;

class Manufacturer extends Model implements HasMediaConversions
{
    use HasMediaTrait;

    protected $fillable = [
        'name',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('logo')
             ->width(500)
             ->sharpen(10);
    }

//###################  Relationships Start #################

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

//###################  Relationships End ###################


//###################  Scopes Start ########################

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

//###################  Scopes End ########################
}
