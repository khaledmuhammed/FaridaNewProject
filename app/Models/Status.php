<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public static $IGNORED        = 1;
    public static $CANCELED       = 2;
    public static $PENDING        = 3;
    public static $PAYMENT_FAILED = 4;
    public static $VALIDATING     = 5;
    public static $PREPARING      = 6;
    public static $SHIPPING       = 7;
    public static $DELIVERED      = 8;

    protected $fillable = ['name', 'name_ar'];
    protected $appends  = ['theName'];

    public function orderHistory()
    {
        return $this->hasMany(OrderHistory::class);
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
