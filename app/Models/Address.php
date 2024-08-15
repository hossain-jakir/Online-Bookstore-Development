<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'first_name',
        'last_name',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country_id',
        'zip_code',
        'phone_number',
        'email',
        'type',
        'is_default',
        'status',
        'isDeleted'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFullAddressAttribute()
    {
        return $this->address_line_1 . ' ' . $this->address_line_2 . ' ' . $this->city . ' ' . $this->state . ' ' . $this->zip_code;
    }

    public function getFullAddressHtmlAttribute()
    {
        return $this->address_line_1 . '<br>' . $this->address_line_2 . '<br>' . $this->city . '<br>' . $this->state . '<br>' . $this->zip_code;
    }
}
