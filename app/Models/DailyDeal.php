<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyDeal extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at',
        'start_date',
        'end_date',
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'price',
        'quantity',
        'start_date',
        'end_date',
        'product_id'
    ];

    protected $casts = [
        'price'    => 'decimal',
        'quantity' => 'integer',
    ];

//###################  Relationships Start #################

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

//###################  Relationships End ###################


//###################  Scopes Start ########################

    public function scopeCurrntDeals($query)
    {
        return $query->where('start_date', '<=', Carbon::now())->where('end_date', '>', Carbon::now());
    }

//###################  Scopes End ########################
}
