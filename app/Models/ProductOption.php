<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\Media;

class ProductOption extends Model implements HasMediaConversions
{
    use SoftDeletes;
    use HasMediaTrait;

    protected $dates = [
        'deleted_at',
        'created_at'
    ];

    protected $casts = [
        'price'                => 'decimal',
        'price_after_discount' => 'decimal',
        'points'               => 'integer',
    ];

    protected $fillable = [
        'name',
        'type',
        'product_id',
        'product_code',
        'original_price',
        'price_after_discount',
        'quantity',
        'bought',
        'availability',
        'availability_date'
    ];

    protected $appends = ['finalPrice'];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
             ->height(500)
             ->sharpen(10);
        $this->addMediaConversion('tiny')
             ->height(100)
             ->sharpen(10);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function type()
    {
        return $this->belongsTo(OptionType::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFinalPriceAttribute()
    {
        return $this->price_after_discount ? $this->price_after_discount : $this->original_price;
    }
}
