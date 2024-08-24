<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'start_date',
        'end_date',
        'description',
        'conditions',
        'status',
        'isDeleted',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function getDiscount($total)
    {
        if ($this->type == 'fixed') {
            return $this->value;
        } else {
            return ($this->value / 100) * $total;
        }
    }

    public function isExpired()
    {
        return now() > $this->end_date;
    }

    public function isAvailable()
    {
        return $this->status == 'active' && !$this->isExpired();
    }

}
