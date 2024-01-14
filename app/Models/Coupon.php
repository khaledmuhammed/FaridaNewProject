<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'title',
        'code',
        'type',
        'amount',
        'minimum',
        'usage_limit',
        'start_date',
        'calc',
        'end_date',
        'couponable_type'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function manufacturers()
    {
        return $this->belongsToMany(Manufacturer::class);
    }

    public function categories()
    {
        return $this->belongsToMany(CategoryWithoutMedia::class, 'category_coupon', 'coupon_id', 'category_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'coupon_product', 'coupon_id', 'product_id');
    }

    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class);
    }

}
