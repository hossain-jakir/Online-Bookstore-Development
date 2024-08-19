<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CartItem;
use App\Models\DeliveryFee;
use App\Services\ServeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends HomeController
{
    public function index(Request $request)
    {
        $data = [];
        $data = array_merge($data, $this->frontendItems($request));

        $data['DeliveryFees'] = DeliveryFee::where('status', 'active')
            ->where('isDeleted', 'no')
            ->get();

        return view('Frontend.cart.index')->with('data', $data);
    }

    public function getCartItems(Request $request)
    {
        $data = [
            'cartList' => [
                'totalPrice' => 0,
                'count' => 0,
                'items' => [],
                'subTotalPrice' => 0,
                'deliveryFee' => 0,
                'couponDiscount' => 0
            ]
        ];

        $cart = Cart::where(function($query) {
                if (auth()->check()) {
                    $query->where('user_id', auth()->id());
                } else {
                    $query->where('session_id', session()->getId());
                }
            })
            ->where('isDeleted', 'no')
            ->where('status', 'active')
            ->latest('id')
            ->first();

        if ($cart) {
            $cartItems = CartItem::with('book')
                ->where('cart_id', $cart->id)
                ->where('isDeleted', 'no')
                ->where('status', 'active')
                ->get();

            foreach ($cartItems as $cartItem) {
                $cartItem->book->image = ServeImage::image($cartItem->book->image, 'grid');

                $price = $cartItem->book->discounted_price ?? $cartItem->book->sale_price;
                $itemTotalPrice = $cartItem->quantity * $price;

                $data['cartList']['totalPrice'] += $itemTotalPrice;
                $data['cartList']['count']++;
                $data['cartList']['items'][] = [
                    'cart_item_id' => $cartItem->id,
                    'book_id' => $cartItem->book->id,
                    'title' => $cartItem->book->title,
                    'quantity' => $cartItem->quantity,
                    'price' => $price,
                    'total_price' => number_format($itemTotalPrice, 2),
                    'discounted_price' => $cartItem->book->discounted_price,
                    'sale_price' => $cartItem->book->sale_price,
                    'image' => $cartItem->book->image,
                ];
            }

            $data['cartList']['subTotalPrice'] = $this->calculateCartSubtotal($cart->id);
            $data['cartList']['deliveryFee'] = DeliveryFee::find($cart->delivery_fee_id)->price ?? 0;
            $data['cartList']['couponDiscount'] = $cart->coupon_discount ?? 0;
            $data['cartList']['totalPrice'] = $data['cartList']['subTotalPrice'] + $data['cartList']['deliveryFee'] - $data['cartList']['couponDiscount'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart items fetched successfully',
            'data' => $data['cartList']
        ]);
    }

    public function store(Request $request)
    {
        $session_id = $request->session()->get('session_id') ?? session()->getId();
        $request->session()->put('session_id', $session_id);

        $bookId = base64_decode($request->book_id);
        if (!$bookId) {
            return response()->json(['success' => false, 'message' => 'Invalid book']);
        }

        // Find the default delivery fee
        $defaultDeliveryFee = DeliveryFee::where('default', 1)
            ->where('status', 'active')
            ->where('isDeleted', 'no')
            ->first();

        // Fetch the cart based on user authentication or session
        $cart = Cart::where(function($query) use ($session_id) {
                if (auth()->check()) {
                    $query->where('user_id', auth()->id());
                } else {
                    $query->where('session_id', $session_id);
                }
            })
            ->where('isDeleted', 'no')
            ->where('status', 'active')
            ->latest('id')
            ->first();

        if (!$cart) {
            $cart = new Cart();
            if (auth()->check()) {
                $cart->user_id = auth()->id();
            } else {
                $cart->session_id = $session_id;
            }
            $cart->total_quantity = 0;
            $cart->total_unique_items = 0;

            // Set the default delivery fee if available
            if ($defaultDeliveryFee) {
                $cart->delivery_fee_id = $defaultDeliveryFee->id;
            }

            $cart->save();
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('book_id', $bookId)
            ->where('isDeleted', 'no')
            ->where('status', 'active')
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
        } else {
            $cartItem = new CartItem();
            $cartItem->cart_id = $cart->id;
            $cartItem->book_id = $bookId;
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            $cart->total_unique_items++;
        }

        if ($cartItem->save()) {
            $cart->total_quantity += $request->quantity;
            $cart->save();
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to add to cart']);
        }

        $price = $cartItem->book->discounted_price ?? $cartItem->book->sale_price;
        $itemTotalPrice = number_format($cartItem->quantity * $price, 2);
        $cartSubtotal = $this->calculateCartSubtotal($cart->id);
        $cartTotal = $this->calculateCartTotal($cart->id, $cart->delivery_fee_id ? DeliveryFee::find($cart->delivery_fee_id)->price : 0);

        return response()->json([
            'success' => true,
            'message' => $cartItem->book->title . ' added to cart successfully',
            'item_total_price' => $itemTotalPrice,
            'cart_subtotal' => number_format($cartSubtotal, 2),
            'cart_total' => number_format($cartTotal, 2)
        ]);
    }

    public function updateQuantity(Request $request)
    {
        $cartItem = CartItem::find($request->cart_id);
        if ($cartItem) {
            $cart = $cartItem->cart;

            if (auth()->check() && $cart->user_id != auth()->id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            } elseif (!$cart->session_id && $cart->session_id != $request->session()->get('session_id')) {
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            }

            $cart->total_quantity += $request->quantity - $cartItem->quantity;
            $cartItem->quantity = $request->quantity;
            $saved = $cartItem->save() && $cart->save();

            if (!$saved) {
                return response()->json(['success' => false, 'message' => 'Failed to update cart item']);
            }

            $price = $cartItem->book->discounted_price ?? $cartItem->book->sale_price;
            $itemTotalPrice = number_format($cartItem->quantity * $price, 2);
            $cartSubtotal = $this->calculateCartSubtotal($cart->id);
            $cartTotal = $this->calculateCartTotal($cart->id, $request->delivery_fee);

            return response()->json([
                'success' => true,
                'message' => $cartItem->book->title . ' quantity updated successfully',
                'item_total_price' => $itemTotalPrice,
                'cart_subtotal' => number_format($cartSubtotal, 2),
                'delivery_fee' => number_format($request->delivery_fee, 2),
                'cart_total' => number_format($cartTotal, 2)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Cart item not found']);
    }

    public function removeItem(Request $request)
    {
        $cartItem = CartItem::find($request->cart_id);
        if ($cartItem) {
            $cart = $cartItem->cart;

            if (auth()->check() && $cart->user_id != auth()->id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            } elseif (!$cart->session_id && $cart->session_id != $request->session()->get('session_id')) {
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            }

            $cart->total_quantity -= $cartItem->quantity;
            $cart->total_unique_items--;

            $cartItem->delete();
            $cart->save();

            $cartSubtotal = $this->calculateCartSubtotal($cart->id);
            $cartTotal = $this->calculateCartTotal($cart->id);

            return response()->json([
                'success' => true,
                'cart_subtotal' => number_format($cartSubtotal, 2),
                'cart_total' => number_format($cartTotal, 2)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Cart item not found']);
    }

    public function updateDeliveryFee(Request $request)
    {
        $request->validate([
            'delivery_fee_id' => 'required|exists:delivery_fees,id',
            'delivery_fee' => 'required|numeric',
        ]);

        $cart = Cart::where(function($query) {
                if (auth()->check()) {
                    $query->where('user_id', auth()->id());
                } else {
                    $query->where('session_id', session()->getId());
                }
            })
            ->where('isDeleted', 'no')
            ->where('status', 'active')
            ->latest('id')
            ->first();

        if ($cart) {
            $cart->delivery_fee_id = $request->delivery_fee_id;
            $cartSave = $cart->save();

            if (!$cartSave) {
                return response()->json(['success' => false, 'message' => 'Failed to update delivery fee']);
            }

            // Get the new delivery fee
            $deliveryFee = DeliveryFee::find($request->delivery_fee_id);
            $newDeliveryFee = $deliveryFee ? $deliveryFee->price : 0;

            // Recalculate the cart subtotal
            $cartSubtotal = $this->calculateCartSubtotal($cart->id);

            // Get current coupon discount
            $couponDiscount = $cart->coupon_discount ?? 0;

            // Calculate the new cart total
            $cartTotal = $cartSubtotal + $newDeliveryFee - $couponDiscount;

            // Ensure the total price is not negative
            $cartTotal = max(0, $cartTotal);

            return response()->json([
                'success' => true,
                'message' => 'Delivery fee updated successfully',
                'delivery_fee' => number_format($newDeliveryFee, 2), // Format delivery fee
                'cart_total' => number_format($cartTotal, 2) // Format total price
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Cart not found']);
    }

    private function getCart()
    {
        return Cart::where(function($query) {
                if (auth()->check()) {
                    $query->where('user_id', auth()->id());
                } else {
                    $query->where('session_id', session()->getId());
                }
            })
            ->where('isDeleted', 'no')
            ->where('status', 'active')
            ->latest('id')
            ->first();
    }

    public function applyCoupon(Request $request)
    {
        $cart = $this->getCart();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart not found.']);
        }

        $couponCode = $request->input('couponCode');
        $deliveryFee = DeliveryFee::find($cart->delivery_fee_id)->price ?? 0;

        $coupon = Coupon::where('code', $couponCode)
            ->where('status', 'active')
            ->where('isDeleted', 'no')
            ->first();

        if ($coupon) {
            $subTotal = $this->calculateCartSubtotal($cart->id);
            $couponDiscount = $this->calculateCouponDiscount($coupon, $subTotal);
            $cart->coupon_code = $couponCode;
            $cart->coupon_discount = $couponDiscount;
            $cart->save();

            $totalPrice = $subTotal + $deliveryFee - $couponDiscount;

            // Ensure the total price is not negative
            $totalPrice = max(0, $totalPrice);

            return response()->json([
                'success' => true,
                'message' => 'Coupon applied successfully.',
                'couponDiscount' => number_format($couponDiscount, 2), // Format coupon discount
                'totalPrice' => number_format($totalPrice, 2) // Format total price
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid coupon code.']);
    }


    public function removeCoupon(Request $request)
    {
        $cart = $this->getCart();

        if ($cart) {
            if ($cart->coupon_code) {
                $cart->coupon_code = null;
                $cart->coupon_discount = 0;
                $cart->save();

                $deliveryFee = DeliveryFee::find($cart->delivery_fee_id)->price ?? 0;
                // Recalculate the total price after removing the coupon
                $totalPrice = $this->calculateCartTotal($cart->id, $deliveryFee);

                // Ensure the total price is not negative
                $totalPrice = max(0, $totalPrice);

                return response()->json([
                    'success' => true,
                    'message' => 'Coupon removed successfully.',
                    'couponDiscount' => 0, // Reset coupon discount
                    'totalPrice' => number_format($totalPrice, 2) // Format total price
                ]);
            }

            return response()->json(['success' => false, 'message' => 'No coupon to remove.']);
        }

        return response()->json(['success' => false, 'message' => 'Cart not found.']);
    }


    private function calculateCouponDiscount($coupon, $subTotal)
    {
        // Initialize $discount to a default value
        $discount = 0;

        // Calculate the discount based on coupon type
        if ($coupon->type === 'percentage') {
            $discount = ($coupon->value / 100) * $subTotal;
            // Ensure that the discount does not exceed the maximum allowed value
            return min($discount, $coupon->max_value ?? $discount);
        } else if ($coupon->type === 'fixed') {
            $discount = $coupon->value;
            // Ensure that the discount does not exceed the maximum allowed value
            return min($discount, $coupon->max_value ?? $discount);
        }

        // Return 0 if the coupon type is not recognized
        return 0;
    }

    private function calculateTotalPrice($cart)
    {
        $subTotalPrice = $cart->subTotalPrice;
        $deliveryFee = $cart->deliveryFee;
        $couponDiscount = $cart->coupon_discount;

        return $subTotalPrice + $deliveryFee - $couponDiscount;
    }


    private function calculateCartSubtotal($cartId)
    {
        $totalPrice = 0;
        $cartItems = CartItem::with('book')
            ->where('cart_id', $cartId)
            ->where('isDeleted', 'no')
            ->where('status', 'active')
            ->get();

        foreach ($cartItems as $cartItem) {
            $price = $cartItem->book->discounted_price ?? $cartItem->book->sale_price;
            $totalPrice += $cartItem->quantity * $price;
        }
        return $totalPrice;
    }

    private function calculateCartTotal($cartId, $deliveryFee = 0)
    {
        $cartSubtotal = $this->calculateCartSubtotal($cartId);
        $total = $cartSubtotal + $deliveryFee;

        // Ensure the total price is not negative
        return max(0, $total);
    }

}
