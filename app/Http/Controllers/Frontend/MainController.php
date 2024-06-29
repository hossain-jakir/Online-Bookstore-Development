<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Wishlist;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller{

    protected function frontendItems(){
        $data = [];
        $data['categories'] = Category::where('isDeleted', 'no')->where('status', 'active')->get();
        $data['wishlistCount'] = 0;

        $data['cartList'] = [
            'totalPrice' => 0,
            'count' => 0,
            'items' => []
        ];
        if (auth()->check()) {
            $data['wishlistCount'] = Wishlist::where('user_id', auth()->id())->where('status', 'active')->where('isDeleted', 'no')->count();

            $cartList = Cart::with('book')->where('user_id', auth()->id())->where('isDeleted', 'no')->where('status', 'active')->latest('id')->get();
            foreach ($cartList as $cart) {
                // Generate image path for the book
                $cart->book->image = ImageHelper::generateImage($cart->book->image, 'grid');

                // Determine price to use based on discounted_price or sale_price
                $price = $cart->book->discounted_price ?? $cart->book->sale_price;

                // Calculate total price and count
                $data['cartList']['totalPrice'] += $cart->quantity * $price;
                $data['cartList']['count'] ++;

                // Add item details to the items array
                $data['cartList']['items'][] = [
                    'cart_id' => $cart->id,
                    'book_id' => $cart->book->id,
                    'title' => $cart->book->title,
                    'quantity' => $cart->quantity,
                    'price' => $price, // Use the determined price
                    'total_price' => $cart->quantity * $price,
                    'discounted_price' => $cart->book->discounted_price,
                    'sale_price' => $cart->book->sale_price,
                    'image' => $cart->book->image,
                ];
            }
        }
        return $data;
    }

    /**
     * Clear specific cache keys when necessary
     */
    public function clearCache(){
        Cache::forget('banner_books');
        Cache::forget('banner_small_books');
        Cache::forget('recommended_books');
        Cache::forget('on_sale_books');
        Cache::forget('featured_books');
        Cache::forget('offer_books');
        Cache::forget('latest_books');
        Cache::forget('best_seller_books');

        return 'Cache cleared successfully.';
    }
}
