<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'author_id',
        'isbn',
        'edition_language',
        'publication_date',
        'publisher',
        'pages',
        'lessons',
        'rating',
        'min_age',
        'quantity',
        'purchase_price',
        'sale_price',
        'discounted_price',
        'discount_type',
        'image',
        'availability',
        'featured',
        'on_sale',
        'free_delivery',
        'status',
    ];

    public function author(){
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(){
        return $this->belongsToMany(Category::class, 'book_categories', 'book_id', 'category_id');
    }

    public function tag(){
        return $this->belongsToMany(Tag::class, 'book_tags', 'book_id', 'tag_id');
    }

    public function wishlistItems(){
        return $this->hasMany(Wishlist::class, 'book_id');
    }

}
