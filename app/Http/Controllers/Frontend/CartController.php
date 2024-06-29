<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends MainController
{
    public function index(){
        $data =[];
        $data = array_merge($data, $this->frontendItems());
        // dd($data);
        return view('frontend.cart.index')->with('data', $data);
    }

    public function getCartItems(){
        $data['cartList'] = [
            'totalPrice' => 0,
            'count' => 0,
            'items' => []
        ];
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

        return response()->json([
            'success' => true,
            'message' => 'Cart items fetched successfully',
            'data' => $data['cartList']
        ]);

    }

    public function store(Request $request){
        $bookId = base64_decode($request->book_id);
        $cart = Cart::where('book_id', $bookId)->where('user_id', auth()->id())->where('isDeleted', 'no')->where('status', 'active')->first();
        if ($cart) {
            $cart->quantity += $request->quantity;
            $saved = $cart->save();
            if (!$saved) {
                return response()->json(['success' => false, 'message' => 'Failed to add to cart']);
            }
        } else {
            $cart = new Cart();
            $cart->book_id = $bookId;
            $cart->user_id = auth()->id();
            $cart->quantity = $request->quantity;
            $saved = $cart->save();

            if (!$saved) {
                return response()->json(['success' => false, 'message' => 'Failed to add to cart']);
            }
        }

        // Assuming you have methods to calculate these values
        $price = $cart->book->discounted_price ? $cart->book->discounted_price : $cart->book->sale_price;
        $itemTotalPrice = number_format($cart->quantity * $price, 2);
        $cartSubtotal = $this->calculateCartSubtotal();
        $cartTotal = $this->calculateCartTotal();

        return response()->json([
            'success' => true,
            'message' => $cart->book->title . ' added to cart successfully',
            'item_total_price' => $itemTotalPrice,
            'cart_subtotal' => number_format($cartSubtotal, 2),
            'cart_total' => number_format($cartTotal, 2)
        ]);
    }

    public function updateQuantity(Request $request){
        $cart = Cart::find($request->cart_id);
        if ($cart && $cart->user_id == auth()->id()) {
            $cart->quantity = $request->quantity;
            $saved = $cart->save();

            if (!$saved) {
                return response()->json(['success' => false, 'message' => 'Failed to update cart item']);
            }

            // Assuming you have methods to calculate these values
            $price = $cart->book->discounted_price ? $cart->book->discounted_price : $cart->book->sale_price;
            $itemTotalPrice = number_format($cart->quantity * $price, 2);
            $cartSubtotal = $this->calculateCartSubtotal();
            $cartTotal = $this->calculateCartTotal();

            return response()->json([
                'success' => true,
                'message' => $cart->book->title . ' added to cart successfully',
                'item_total_price' => $itemTotalPrice,
                'cart_subtotal' => number_format($cartSubtotal, 2),
                'cart_total' => number_format($cartTotal, 2)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Cart item not found']);
    }

    public function removeItem(Request $request){
        $cart = Cart::find($request->cart_id);
        if ($cart && $cart->user_id == auth()->id()) {
            $cart->delete();

            // Assuming you have methods to calculate these values
            $cartSubtotal = $this->calculateCartSubtotal();
            $cartTotal = $this->calculateCartTotal();

            return response()->json([
                'success' => true,
                'cart_subtotal' => $cartSubtotal,
                'cart_total' => $cartTotal
            ]);
        }

        return response()->json(['success' => false]);
    }

    private function calculateCartSubtotal(){
        $totalPrice = 0;
        $cartList = Cart::with('book')->where('user_id', auth()->id())->where('isDeleted', 'no')->where('status', 'active')->latest('id')->get();
        foreach ($cartList as $cart) {
            $price = $cart->book->discounted_price ? $cart->book->discounted_price : $cart->book->sale_price;
            $totalPrice += $cart->quantity * $price;
        }
        return $totalPrice;
    }

    private function calculateCartTotal(){
        $cartSubtotal = $this->calculateCartSubtotal();
        return (float) $cartSubtotal;
    }
}
