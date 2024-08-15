<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'total_quantity',
        'total_unique_items',
        'coupon_code',
        'coupon_discount',
        'isCheckedOut',
        'status',
        'isDeleted'
    ];

    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCartItems($userId){
        return Cart::where('user_id', $userId)->where('isDeleted', 'no')->where('status', 'active')->get();
    }

    public function checkSessionIdIsAvailable($session_id){
        $cart = cart::where('session_id', $session_id)->first();
        if($cart){
            return true;
        }else{
            return false;
        }
    }
}
