<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Package extends Model implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'name_en',
        'price',
        'quantity',
        'searched',
        'bought',
        'availability',
        'availability_date',
        'shipping_free',
        'payment_free',
        'description',
        'description_en',
        'only_saudi',
    ];

    protected $appends = ['type', 'originalPrice', 'thumbnail', 'theName', 'theDescription'];


    public function intoPackages()
    {
        return $this->belongsToMany('App\Models\Product', 'into_package')->select(['id', 'name', 'original_price',
            'price_after_discount', 'product_code', 'into_package_quantity']);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'into_package');
    }

    public function getTypeAttribute()
    {
        return 'package';
    }

    public function orderItems()
    {
        return $this->morphMany(OrderItem::class, 'orderable');
    }
    public function getMaxQuantityAttribute()
    {
        // $ordersCount = $this->orderItems()->whereHas('order', function ($q) {
        //     $q->whereHas('orderHistory', function ($k) {
        //         //TODO: Make sure this condition is right and enough
        //         $k->where('status_id', '>', Status::$CANCELED);
        //     });
        // })->sum('count');

        // return $this->quantity - $ordersCount;
        return $this->quantity;
    }

    public function getOriginalPriceAttribute() 
    {
        $price = 0;
        foreach ($this->intoPackages as $product) {
            $price += $product->original_price * $product->into_package_quantity;
        }

        return $price;
    }

    public function getThumbnailAttribute() 
    {
        return $this->getFirstMedia('image') ? $this->getFirstMedia('image')->getUrl() : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXp7vG6vsG3u77s8fTCxsnn7O/f5OfP09bFyczM0dO8wMPk6ezY3eDh5unJzdDR1tlr0sxZAAACVUlEQVR4nO3b23KDIBRA0QgmsaLx//+2KmPi/YJMPafZ6619sOzARJjq7QYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAuJyN4+qMZcUri+BV3WQ22iIxSRTGFBITbRGpr218Ckx0EQPrxMfVPRP25QvNaT4xFTeJ1g/sJ4K8/aTuVxdNNJ99/Q0RQWlELtN7xGH9+8KYH1ZEX1hY770C9186Cm2R1TeONGj/paHQury7OwbsvzQUlp/9jakOJ2ooPLf/kl9on4Mtan50EhUUDvfgh8cqv/AxKlw+Cc3vPeUXjg+Kr4VCm+Vbl5LkeKHNTDKbKL9w3yr1B8q5RPmFu75puhPzTKKCwh13i2aJJguJ8gt33PG7GZxN1FC4tWvrB04TNRRu7Lw/S3Q2UUPh+ulpOIPTRB2FKyfgaeAoUUvhkvESnSYqL5ybwVGi7sKlwH6i6sL5JTpKVFZYlr0flmewTbyvX+piC8NyiXHvH9YD37OoqtA1v+wS15ZofxY1FTo/cJ+4NYNJd9BSVOi6kTeJOwLVFbrPyJ3dXqL6Cl1/7G7HDGordMOx7+hTVui2arQXBgVqKgwLVFQYGKinMDRQTWFwoJrC8AfcKLwUhRRSeL3vKkyDVaNLSdIf1snXEBQUyrlUTBQeIbPQD6uK8Zx3+yyHKbf/5N+y/gn78K/Rj/ZmY64Omhg9gHFaJu59i+EDGKf1/tshRxlxEoW+2uXS868EeflDYmDNltUzgkpqXyPGzULyK6QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8DV+AUrRI7QWHsWNAAAAAElFTkSuQmCC';
    }

    public function getTheNameAttribute()
    {
        $name = $this->name;

        if (app()->getLocale() == 'en' && $this->name_en) {
            $name = $this->name_en;
        }

        return $name;
    }

    public function getTheDescriptionAttribute()
    {
        $description = $this->description;

        if (app()->getLocale() == 'en' && $this->description_en) {
            $description = $this->description_en;
        }

        return $description;
    }
}
