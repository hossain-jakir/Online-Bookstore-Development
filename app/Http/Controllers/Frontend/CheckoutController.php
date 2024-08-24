<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Shop;
use App\Models\User;
use App\Models\Order;
use App\Models\Paypal;
use App\Models\Address;
use App\Models\Country;
use App\Models\CartItem;
use App\Models\Wishlist;
use App\Models\OrderItems;
use App\Models\DeliveryFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class CheckoutController extends MainController
{
    public function index(Request $request)
    {

        $cart = $this->getCart();
        if (!$cart) {
            session()->flash('error', 'Cart is empty');
            return redirect()->route('home')->with('error', 'Cart is empty');
        }

        // check cart has items
        $cartItems = CartItem::where('cart_id', $cart->id)->get();
        if ($cartItems->count() == 0) {
            session()->flash('error', 'Cart is empty. Please add items to cart');
            return redirect()->route('home')->with('error', 'Cart is empty');
        }

        $data = [];
        $data = array_merge($data, $this->frontendItems($request));
        $data['addresses'] = null;

        if (auth()->user()) {
            $data['addresses'] = Address::where('user_id', auth()->user()->id)->where('status', 'active')->where('isDeleted', 'no')->get();
        }

        $data['DeliveryFees'] = DeliveryFee::where('status', 'active')->where('isDeleted', 'no')->get();
        $data['Countries'] = Country::where('status', 'active')->where('isDeleted', 'no')->get();

        // Fetch the cart and coupon details
        $cart = $this->getCart();
        if (!$cart) {
            $cart = new Cart();
        }
        $deliveryFee = $cart->delivery_fee ?? 0;
        $couponDiscount = $cart->coupon_discount ?? 0;

        $cartSubtotal = $this->calculateCartSubtotal($cart->id);
        $cartTotal = $cartSubtotal + $deliveryFee - $couponDiscount;
        $cartTotal = max(0, $cartTotal); // Ensure total is not negative

        $taxAmount = $this->calculateTax($cartSubtotal);

        // Initialize cartList with empty items if no cart is found
        $data['CheckoutCartList'] = [
            'items' => $cart->items ?? [], // Ensure items is an array
            'subtotal' => $cartSubtotal,
            'delivery_fee' => $deliveryFee,
            'coupon_discount' => $couponDiscount,
            'taxAmount' => number_format($taxAmount, 2),
            'total' => $cartTotal + $taxAmount,
        ];

        // dd()

        return view('Frontend.Checkout.index')->with('data', $data);
    }

    private function checkUserAndCreate(Request $request, $sessionId)
    {
        if (Auth::check()) {
            return Auth::user();
        } else {
            // check if user exists with the email
            $user = User::where('email', $request->email)->first();
            if ($user) {
                return null;
            } else {

                $password = $request->password ? Hash::make($request->password) : Hash::make('password');

                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'image' => null,
                    'dob' => null,
                    'email_verified_at' => now(),
                    'status' => 'active',
                    'isDeleted' => 'no',
                    'password' => $password,
                ]);

                if ($user) {

                    // asisgn role to user
                    $user->assignRole('user');

                    // update all the cart items with the user id
                    $cart = Cart::where('session_id', $sessionId)->where('status', 'active')->where('isDeleted', 'no')->first();
                    if ($cart) {
                        // update cart
                        $cart->user_id = $user->id;
                        $cart->save();
                    }

                    // wishlist
                    $wishlist = Wishlist::where('session_id', $sessionId)->where('status', 'active')->where('isDeleted', 'no')->get();
                    foreach ($wishlist as $item) {
                        $item->user_id = $user->id;
                        $item->save();
                    }

                    Auth::login($user);

                    return $user;
                } else {
                    return null;
                }
            }
        }
    }

    private function checkAndCreateAddress(Request $request, $user)
    {
        // dd($request->all(), $user);
        // Retrieve the request data

        $inputAddress = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'address_line_1' => $request->input('address_line_1'),
            'address_line_2' => $request->input('address_line_2'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country_id' => $request->input('country_id'),
            'zip_code' => $request->input('zip_code'),
            'phone_number' => $request->input('phone') ?? $user->phone,
            'email' => $request->input('email') ?? $user->email,
        ];

        // Check if an address with these details already exists for the user
        $existingAddress = Address::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('isDeleted', 'no')
            ->where(function($query) use ($inputAddress) {
                $query->where('first_name', $inputAddress['first_name'])
                    ->where('last_name', $inputAddress['last_name'])
                    ->where('address_line_1', $inputAddress['address_line_1'])
                    ->where('address_line_2', $inputAddress['address_line_2'])
                    ->where('city', $inputAddress['city'])
                    ->where('state', $inputAddress['state'])
                    ->where('country_id', $inputAddress['country_id'])
                    ->where('zip_code', $inputAddress['zip_code'])
                    ->where('phone_number', $inputAddress['phone_number'])
                    ->where('email', $inputAddress['email']);
            })
            ->first();

        // If the address exists, return it
        if ($existingAddress) {
            return $existingAddress;
        }

        // If not, create a new address
        $newAddress = Address::create([
            'user_id' => $user->id,
            'title' => 'Default', // Or any logic you use to set the title
            'first_name' => $inputAddress['first_name'],
            'last_name' => $inputAddress['last_name'],
            'address_line_1' => $inputAddress['address_line_1'],
            'address_line_2' => $inputAddress['address_line_2'] ?? null,
            'city' => $inputAddress['city'],
            'state' => $inputAddress['state'],
            'country_id' => $inputAddress['country_id'],
            'zip_code' => $inputAddress['zip_code'],
            'phone_number' => $inputAddress['phone_number'],
            'email' => $inputAddress['email'],
            'type' => 'shipping',
            'is_default' => true,
            'status' => 'active',
            'isDeleted' => 'no',
        ]);

        return $newAddress;
    }

    public function process(Request $request){
        DB::beginTransaction();

        try {

            $sessionId = session()->getId();

            if(Auth::check()){
                $user = Auth::user();
            }else{
                $user = User::where('email', $request->email)->first();
                if ($user) {
                    session()->flash('error', 'User already exists with this email please login');
                    return redirect()->back()->with('error', 'User already exists')->withInput();
                }

                $user = $this->checkUserAndCreate($request, $sessionId);

                if (!$user) {
                    return redirect()->back()->with('error', 'Failed to create user')->withInput();
                }
            }

            if($request->has('address_id')){
                $address = Address::find($request->address_id);
            }else{

                $request->validate([
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'address_line_1' => 'required|string|max:255',
                    'city' => 'required|string|max:255',
                    'state' => 'required|string|max:255',
                    'country_id' => 'required|exists:countries,id',
                    'zip_code' => 'required|string|max:255',
                    'phone' => 'nullable|string|max:255',
                    'email' => 'nullable|email',
                ]);

                $address = $this->checkAndCreateAddress($request, $user);

                if (!$address) {
                    return redirect()->back()->with('error', 'Failed to create address')->withInput();
                }
            }

            $cart = Cart::where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('session_id', session()->getId());
            })->where('isDeleted', 'no')
            ->orderBy('id', 'desc')
            ->where('status', 'active')->where('isDeleted', 'no')->first();
            if (!$cart) {
                return redirect()->back()->with('error', 'Cart not found')->withInput();
            }

            $order_number = 'OBD'. time() . rand(1000, 9999);

            $cartTotal= 0;
            $itemsOfCart = CartItem::where('cart_id', $cart->id)->get();
            foreach ($itemsOfCart as $item) {
                $cartTotal += $item->quantity * ($item->book->discounted_price ?? $item->book->sale_price);
            }

            $discountAmount = 0;
            $couponAmount = $cart->coupon_discount;
            Log::info('Coupon Amount: ' . $couponAmount);
            $taxAmount = $this->calculateTax($cartTotal);
            $shippingAmount = DeliveryFee::find($cart->delivery_fee_id)->price;
            $subTotal = $cartTotal + $shippingAmount - $couponAmount - $discountAmount;
            $grandTotal = $subTotal + $taxAmount;

            if ($grandTotal < 0) {
                $grandTotal = 0;
            }

            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'shipping_address_id' => $address->id,
                'coupon_id' => $cart->coupon_id,
                'delivery_method_id' => $cart->delivery_fee_id,
                'order_number' => $order_number,
                'total_amount' => $cartTotal,
                'discount_amount' => $discountAmount,
                'coupon_amount' => $couponAmount,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'grand_total' => $grandTotal,
                'paid_amount' => 0,
                'due_amount' => $grandTotal,
                'payment_method' => 'paypal',
                'payment_status' => 'In Progress',
                'shipping_date' => Carbon::now()->addDays(2),
                'delivery_date' => Carbon::now()->addDays(2),
                'shipping_status' => 'pending',
                'status' => 'pending',
                'isDeleted' => 'no',
            ]);

            if (!$order) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to create order')->withInput();
            }

            $cartItems = CartItem::where('cart_id', $cart->id)->get();
            foreach ($cartItems as $item) {
                OrderItems::create([
                    'order_id' => $order->id,
                    'book_id' => $item->book_id,
                    'quantity' => $item->quantity,
                    'price' => $item->book->discounted_price ?? $item->book->sale_price,
                    'total' => $item->quantity * ($item->book->discounted_price ?? $item->book->sale_price),
                    'status' => 'active',
                    'isDeleted' => 'no',
                ]);
            }


            $key = 'order_id_' . Auth::id();
            session()->put($key, $order->id);

            DB::commit();
            return redirect()->route('checkout.paypal.form');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    private function getCart()
    {
        return Cart::where(function ($query) {
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

    private function calculateCartSubtotal($cartId)
    {
        $cart = Cart::find($cartId);
        $items = $cart->items ?? collect();

        return $items->sum(function ($item) {
            return $item->quantity * ($item->book->discounted_price ?? $item->book->sale_price);
        });
    }

    private function calculateTax($subTotal)
    {
        return $subTotal * Shop::first()->tax / 100;
    }

}
