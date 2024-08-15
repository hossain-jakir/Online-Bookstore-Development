<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'book_id',
        'quantity',
        'isCheckedOut',
        'status',
        'isDeleted'
    ];

    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function cart(){
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function getCartItems($userId){
        return CartItem::where('user_id', $userId)->where('isDeleted', 'no')->where('status', 'active')->get();
    }

    public function checkSessionIdIsAvailable($session_id){
        $cart = CartItem::where('session_id', $session_id)->first();
        if($cart){
            return true;
        }else{
            return false;
        }
    }
}
