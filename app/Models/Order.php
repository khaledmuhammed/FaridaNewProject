<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $appends = ['total', 'formatted_created_at','currentStatus', 'bankTransferUrl', 'aramexStatus'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Address');
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function getTotalAttribute()
    {
        return $this->total_price;
    }

    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItem');
    }
    
    public function orderReceiver()
    {
        return $this->hasOne('App\Models\OrderReceiver');
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function orderHistory()
    {
        return $this->hasMany(OrderHistory::class);
    }

    public function bankTransfer()
    {
        return $this->hasOne(BankTransfer::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->toDatestring();
    }

    public function getCurrentStatusAttribute()
    {
        return $this->orderHistory->last()['status'];
    }

    public function getBankTransferUrlAttribute()
    {
        $token = hash('sha256', $this->id.$this->username);
        $token = substr($token,0,10);
        return route('bankTransfer.show',[$this->id,$token]);
    }
    
    public function getAramexStatusAttribute()
    {
        if ($this->id > 520) {
            if ($this->currentStatus && $this->currentStatus->id >= Status::$PREPARING && $this->aramexID) {
                return $this->aramexID;
            } else {
                return "لا يوجد";
            }
        }
        return '';
    }
}
