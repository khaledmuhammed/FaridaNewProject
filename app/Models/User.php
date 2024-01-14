<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $fillable = ['first_name', 'last_name', 'email', 'mobile', 'gender', 'city_id', 'role_id', 'password',];
    protected $hidden   = ['password', 'remember_token',];
    protected $dates    = ['created_at', 'deleted_at'];


    //  ################starte relations##############

    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }

    public function cartItems()
    {
        return $this->hasMany('App\Models\CartItem');
    }

    public function wishlistItem()
    {
        return $this->hasMany('App\Models\WishlistItem');
    }

    public function rating()
    {
        return $this->hasMany('App\Models\Rating');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function whenAvailableProducts()
    {
        return $this->belongsToMany(Product::class, 'when_available');
    }

    // #################  END  ##########################


    //  ################starte attributes##############
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    // #################  END  ##########################

    //  ################start Scopes ##############

    public function scopeClients($query)
    {
        return $query->where('role_id', Role::$CLIENT);
    }

    // #################  END  ##########################

    public function routeNotificationForSms()
    {
        return $this->mobile;
    }

}
