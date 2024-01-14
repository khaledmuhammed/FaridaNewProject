<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankTransfer extends Model
{
    protected $fillable = [
        'account_owner',
        'account_number',
        'bank_name',
        'amount',
        'date',
        'notes',
        'order_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
