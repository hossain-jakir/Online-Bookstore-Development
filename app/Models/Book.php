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

    public function reviews(){
        return $this->hasMany(Review::class, 'book_id');
    }

    public function orders(){
        return $this->hasMany(Order::class, 'book_id');
    }

    public function orderItems(){
        return $this->hasMany(OrderItems::class, 'book_id');
    }

    public function cartItems(){
        return $this->hasMany(Cart::class, 'book_id');
    }

    public function cartItemsCount(){
        return $this->cartItems()->count();
    }

    public function wishlistItemsCount(){
        return $this->wishlistItems()->count();
    }

    public function reviewsCount(){
        return $this->reviews()->count();
    }

    public function ordersCount(){
        return $this->orders()->count();
    }

    // Accessor for final price after applying discount
    public function getFinalPriceAttribute()
    {
        if ($this->discount_type === 'percentage') {
            return $this->sale_price - ($this->sale_price * ($this->discounted_price / 100));
        }

        return $this->sale_price - $this->discounted_price;
    }

    // Scope to filter only available books
    public function scopeAvailable($query)
    {
        return $query->where('availability', 1)->where('isDeleted', 'no');
    }

    // Scope to filter featured books
    public function scopeFeatured($query)
    {
        return $query->where('featured', 1)->where('isDeleted', 'no');
    }

    // Scope to filter books on sale
    public function scopeOnSale($query)
    {
        return $query->where('on_sale', 1)->where('isDeleted', 'no');
    }

    // Scope to filter books with free delivery
    public function scopeFreeDelivery($query)
    {
        return $query->where('free_delivery', 1)->where('isDeleted', 'no');
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
        }

        return $query;
    }

}
