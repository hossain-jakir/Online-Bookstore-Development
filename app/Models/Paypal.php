<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paypal extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'paypal_id',
        'payer_id',
        'payer_first_name',
        'payer_last_name',
        'payer_email',
        'status',
        'amount',
        'currency',
        'paypal_fee',
        'paypal_fee_currency',
        'net_amount',
        'net_amount_currency',
        'payment_source',
        'purchase_units',
        'payer',
        'user_id',
        'order_id',
    ];

    protected $casts = [
        'payment_source' => 'array',
        'purchase_units' => 'array',
        'payer' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getAmountAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getPaypalFeeAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getNetAmountAttribute($value)
    {
        return number_format($value, 2);
    }
}
