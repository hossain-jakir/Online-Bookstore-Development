<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'logo', 'favicon', 'address', 'phone', 'email',
        'latitude', 'longitude', 'short_description', 'website',
        'facebook', 'twitter', 'instagram', 'linkedin', 'whatsapp'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
