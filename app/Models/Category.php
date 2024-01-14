<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\Media;

class Category extends Model implements HasMediaConversions
{
    use SoftDeletes;
    use HasMediaTrait;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'name_ar',
        'super_category_id',
        'thumbnail',
        'is_active',
        'is_featured',
    ];

    protected $appends = ['thumbnail', 'theName'];

    protected $with = ['media'];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
             ->height(500)
             ->sharpen(10);
    }

//###################  Relationships Start #################

    public function filters()
    {
        return $this->belongsToMany('App\Models\Filter');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'super_category_id');
    }

    public function categoriesActive()
    {
        return $this->hasMany('App\Models\Category', 'super_category_id')->where('is_active', 1);
    }

    public function superCategory()
    {
        return $this->belongsTo(CategoryWithoutMedia::class, 'super_category_id');
    }

    public function scopeChildrenOf($query, $id)
    {
        return $query->where('super_category_id', $id);
    }

//###################  Relationships End ###################


//###################  Scopes Start ########################

    public function getThumbnailAttribute()
    {
        $thumb = $this->getFirstMediaUrl('category', 'thumb');
        if ($thumb) {
            return $thumb;
        } else {
            $product = $this->products()->whereHas('media')->first();
            if ($product) {
                return $product->large_thumbnail;
            } else {
                return "";
            }
        }
    }

    public function getTheNameAttribute()
    {
        $name = $this->name;

        if (app()->getLocale() == 'ar' && $this->name_ar) {
            $name = $this->name_ar;
        }

        return $name;
    }
//###################  Scopes End ########################

//###################  Attributes Start ########################

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
//###################  Attributes End ########################

}
