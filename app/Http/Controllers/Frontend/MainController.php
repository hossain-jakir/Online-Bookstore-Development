<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\User;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\DeliveryFee;
use App\Helpers\ImageHelper;
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

        $data['wishlistCount'] = 0;
        $data['cartList'] = [
            'subTotalPrice' => 0,
            'deliveryFee' => 0,
            'totalPrice' => 0,
            'count' => 0,
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
        $cartList = Cart::with('book')
        ->where(function($query) use ($request){
            if(auth()->check()){
                $query->where('user_id', auth()->id());
            }else{
                $query->where('session_id', $request->session()->get('session_id'));
            }
        })
        ->where('isDeleted', 'no')->where('status', 'active')->latest('id')->get();
        foreach ($cartList as $cart) {
            // Generate image path for the book
            $cart->book->image = ImageHelper::generateImage($cart->book->image, 'grid');

            // Determine price to use based on discounted_price or sale_price
            $price = $cart->book->discounted_price ?? $cart->book->sale_price;

            // Calculate total price and count
            $data['cartList']['subTotalPrice'] += $cart->quantity * $price;
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
        $itemCount = count($data['cartList']['items']);
        $deliveryFee = $itemCount > 0 ? DeliveryFee::where('status', 'active')->where('isDeleted', 'no')->where('default', '1')->first()->price : 0;
        $data['cartList']['deliveryFee'] = $deliveryFee;
        $data['cartList']['totalPrice'] += $data['cartList']['deliveryFee'];

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
