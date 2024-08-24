<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'shipping_address_id',
        'coupon_id',
        'delivery_method_id',
        'order_number',
        'total_amount',
        'discount_amount',
        'coupon_amount',
        'tax_amount',
        'paid_amount',
        'due_amount',
        'shipping_amount',
        'grand_total',
        'payment_method',
        'payment_id',
        'payment_status',
        'shipping_date',
        'delivery_date',
        'shipping_status',
        'paid_at',
        'shipped_at',
        'delivered_at',
        'canceled_at',
        'notes',
        'status',
        'isDeleted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function deliveryMethod()
    {
        return $this->belongsTo(DeliveryFee::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function tracks()
    {
        return $this->hasMany(OrderTrack::class)->orderBy('created_at', 'desc');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('created_at', 'desc');
    }

    public function scopeWhereTimeframe($query, $column, $period)
    {
        if ($period == 'day') {
            return $query->whereDate($column, today());
        }elseif ($period == 'week') {
            return $query->whereBetween($column, [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($period == 'month') {
            return $query->whereMonth($column, now()->month)
                        ->whereYear($column, now()->year);
        } elseif ($period == 'year') {
            return $query->whereYear($column, now()->year);
        }elseif ($period == 'all') {
            return $query;
        }
        return $query;
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'order_id');
    }
}
