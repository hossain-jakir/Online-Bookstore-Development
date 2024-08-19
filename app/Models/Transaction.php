<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'user_id',
        'order_id',
        'gateway',
        'status',
        'currency',
        'amount',
        'reference',
        'description',
        'billed_at',
    ];

    protected $casts = [
        'billed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function isCredit()
    {
        return $this->type === 'credit';
    }

    public function isDebit()
    {
        return $this->type === 'debit';
    }
}
