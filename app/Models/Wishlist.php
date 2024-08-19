<?php

namespace App\Models;

use App\Services\ServeImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'book_id',
        'quantity',
        'status',
        'isDeleted'
    ];

    public function book(){
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getBookImageAttribute($type = 'grid'){
        return ServeImage::image($this->book->image, $type);
    }
}
