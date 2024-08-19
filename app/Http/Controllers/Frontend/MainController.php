<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Book;
use App\Models\Cart;
use App\Models\User;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\DeliveryFee;
use App\Services\ServeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller{

    protected function frontendItems(Request $request){

        $this->_checkSession($request);

        $data = [];
        $data['categories'] = Category::select('categories.id', 'categories.name', 'categories.slug', 'categories.description', 'categories.status', 'categories.isDeleted', 'categories.created_at', 'categories.updated_at', DB::raw('COUNT(book_categories.book_id) as book_count'))
            ->join('book_categories', 'categories.id', '=', 'book_categories.category_id')
            ->where('categories.isDeleted', 'no')
            ->where('categories.status', 'active')
            ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.description', 'categories.status', 'categories.isDeleted', 'categories.created_at', 'categories.updated_at')
            ->orderBy('book_count', 'desc')
            ->get();

        $data['authors'] = User::select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.phone','users.image', 'users.status', 'users.isDeleted', 'users.created_at', 'users.updated_at', DB::raw('COUNT(books.author_id) as book_count'))
            ->join('books', 'users.id', '=', 'books.author_id')
            ->where('users.isDeleted', 'no')
            ->where('users.status', 'active')
            ->groupBy('users.id', 'users.first_name' , 'users.last_name' , 'users.email', 'users.phone', 'users.image', 'users.status', 'users.isDeleted', 'users.created_at', 'users.updated_at')
            ->orderBy('book_count', 'desc')
            ->get();

        $cacheKey = 'happy_customer_data';
        //remember the cache for 10 minutes
        $data['happyCustomerData'] = Cache::remember($cacheKey, 30, function () {
            return [
                'happyCustomerCount' => User::whereHas('roles', function($q){
                    $q->where('name', 'user');
                })->where('status', 'active')->where('isDeleted', 'no')->count(),
                'totalBookCount' => Book::where('status', 'published')->where('isDeleted', 'no')->count(),
                'totalStoreCount' => 1,
                'totalWriter' => User::whereHas('roles', function($q){
                    $q->where('name', 'author');
                })->where('status', 'active')->where('isDeleted', 'no')->count(),
            ];
        });

        $data['shop'] = Cache::remember('shop_data', 60*24, function () {
            return DB::table('shops')->first();
        });

        $data['wishlistCount'] = 0;
        $data['cartList'] = [
            'subTotalPrice' => 0,
            'deliveryFee' => 0,
            'totalPrice' => 0,
            'couponDiscount' => 0,
            'count' => 0,
            'cart' => null,
            'items' => []
        ];
        if(auth()->check() || $request->session()->has('session_id')){
            $data['wishlistCount'] = Wishlist::where(function($query) use ($request){
                if(auth()->check()){
                    $query->where('user_id', auth()->id());
                }else{
                    $query->where('session_id', $request->session()->get('session_id'));
                }
            })->where('status', 'active')->where('isDeleted', 'no')->count();
        }

        // Fetch the cart based on user authentication or session
        $cart = Cart::where(function ($query) use ($request) {
            if (auth()->check()) {
                $query->where('user_id', auth()->id());
            } else {
                $query->where('session_id', $request->session()->get('session_id'));
            }
        })
            ->where('isDeleted', 'no')
            ->where('status', 'active')
            ->latest('id')
            ->first();

        if ($cart) {

            $data['cartList']['cart'] = $cart;

            $cartItems = CartItem::with('book')
                ->where('cart_id', $cart->id)
                ->where('isDeleted', 'no')
                ->where('status', 'active')
                ->get();

            foreach ($cartItems as $cartItem) {
                // Generate image path for the book
                $cartItem->book->image = ServeImage::image($cartItem->book->image, 'grid');

                // Determine price to use based on discounted_price or sale_price
                $price = $cartItem->book->discounted_price ?? $cartItem->book->sale_price;

                // Calculate total price and count
                $data['cartList']['subTotalPrice'] += $cartItem->quantity * $price;
                $data['cartList']['totalPrice'] += $cartItem->quantity * $price;
                $data['cartList']['count']++;

                // Add item details to the items array
                $data['cartList']['items'][] = [
                    'cart_item_id' => $cartItem->id,
                    'book_id' => $cartItem->book->id,
                    'title' => $cartItem->book->title,
                    'quantity' => $cartItem->quantity,
                    'price' => $price, // Use the determined price
                    'total_price' => $cartItem->quantity * $price,
                    'discounted_price' => $cartItem->book->discounted_price,
                    'sale_price' => $cartItem->book->sale_price,
                    'image' => $cartItem->book->image,
                ];
            }

            // Get coupon discount
            $couponDiscount = $cart->coupon_discount ?? 0; // Assuming `coupon_discount` is a field in the Cart model

            // Calculate total price
            $deliveryFee = $cart->delivery_fee_id ? DeliveryFee::find($cart->delivery_fee_id)->price : DeliveryFee::where('isDefault', 'yes')->first()->price;
            $data['cartList']['totalPrice'] = $data['cartList']['subTotalPrice'] + $deliveryFee - $couponDiscount;

            // Add coupon discount to data
            $data['cartList']['couponDiscount'] = $couponDiscount;
            $data['cartList']['totalPrice'] = max(0,number_format($data['cartList']['totalPrice'], 2));
            $data['cartList']['subTotalPrice'] = number_format($data['cartList']['subTotalPrice'], 2);
            $data['cartList']['deliveryFee'] = number_format($deliveryFee, 2);

        }
        return $data;
    }

    private function _checkSession(Request $request){

        if(!$request->session()->has('session_id')){

            $session_id = $request->session()->getId();

            $cart = new cart();
            $checkSessionId = $cart->checkSessionIdIsAvailable($session_id);
            if($checkSessionId){
                $request->session()->regenerate();
                $session_id = $request->session()->getId();
                // dd('regenerate: '.$session_id);
            }
            $request->session()->put('session_id', $session_id);
            // dd($request->session()->get('session_id'));
        }
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
