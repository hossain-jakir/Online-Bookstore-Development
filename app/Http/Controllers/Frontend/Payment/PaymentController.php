<?php

namespace App\Http\Controllers\Frontend\Payment;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Paypal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\MainController;
use App\Models\CartItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends MainController
{
    public function showPaymentForm(Request $request)
    {
        $order_id = session('order_id_'.Auth::id());
        return view('Frontend.Checkout.paypal_form', compact('order_id'));
    }

    public function showPaymentDueForm(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'order_number' => 'required|exists:orders,order_number',
        ]);
        $order_id = $request->order_id;
        $order_number = $request->order_number;

        $order = Order::where('id', $order_id)
            ->where('order_number', $order_number)
            ->where('user_id', Auth::id())
            ->first();

        if(!$order){
            session()->flash('error', 'Order not found.');
            return redirect()->route('checkout.paypal.cancel');
        }

        $order_id = $order_id;
        return view('Frontend.Checkout.paypal_due_form', compact('order_id'));
    }

    public function paypalDuePay(Request $request){
        try{
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            if($request->order_id){
                $order = Order::find($request->order_id);
                if(!$order){
                    return redirect()->route('checkout.paypal.cancel');
                }
            }else{
                return redirect()->route('checkout.paypal.cancel');
            }

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context"=> [
                    "return_url"=> route('checkout.paypal.due.success'),
                    "cancel_url"=> route('checkout.paypal.cancel')
                ],
                "purchase_units" => [
                    [
                        "amount"=>[
                            "currency_code"=> "GBP",
                            "value"=> $order->due_amount,
                        ],
                        "reference_id" => $order->id
                    ]
                ]
            ]);

            if(isset($response['id']) && $response['id'] !=null){
                $paypalkey = 'paypal_id_'.Auth::id();
                session([$paypalkey => $response['id']]);

                foreach($response['links'] as $link){

                    if($link['rel'] == 'self'){
                        Paypal::UpdateOrCreate([
                            'token' => $response['id'] ?? null,
                            'paypal_id' => $response['id'] ?? null,
                            'status' => $response['status'] ?? null,
                            'user_id' => Auth::id(),
                            'order_id' => $order->id,
                        ]);
                    }

                    if($link['rel'] == 'approve'){
                        return redirect()->away($link['href']);
                    }
                }
            }else{
                return redirect()->route('checkout.paypal.cancel');
            }
        }catch(\Exception $e){
            dd($e->getMessage());
            Log::error($e->getMessage());
            return redirect()->route('checkout.paypal.cancel');
        }
    }

    public function paypalDueSuccess(Request $request){
        $data = [];
        $data = array_merge($data, $this->frontendItems($request));

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        $paidAmount = $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['gross_amount']['value'];

        // update paypal where paypal_id = $response['id']
        Paypal::where('paypal_id', $response['id'])->update([
            'payer_id' => $response['payer']['payer_id'] ?? null,
            'payer_first_name' => $response['payer']['name']['given_name'] ?? null,
            'payer_last_name' => $response['payer']['name']['surname'] ?? null,
            'payer_email' => $response['payer']['email_address'] ?? null,
            'status' => $response['status'] ?? null,
            'amount' => $paidAmount ?? null,
            'currency' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['gross_amount']['currency_code'] ?? null,
            'paypal_fee' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value'] ?? null,
            'paypal_fee_currency' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['currency_code'] ?? null,
            'net_amount' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value'] ?? null,
            'net_amount_currency' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['currency_code'] ?? null,

            'payment_source' => $response['payment_source'] ? json_encode($response['payment_source']) : null,
            'purchase_units' => $response['purchase_units'] ? json_encode($response['purchase_units']) : null,
            'payer' => $response['payer'] ? json_encode($response['payer']) : null,
        ]);

        // find order
        $order = Order::where('id', $response['purchase_units'][0]['reference_id'])->first();

        $order->update([
            'paid_amount' => $order->paid_amount + $paidAmount,
            'due_amount' => $order->due_amount - $paidAmount,
            'payment_status' => $order->due_amount - $paidAmount == 0 ? 'paid' : 'partial',
            'status' => 'processing',
            'payment_id' => $response['id'],
            'paid_at' => now(),
        ]);

        // Transaction table insert
        Transaction::create([
            'type' => 'credit',
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'gateway' => 'paypal',
            'status' => 'completed',
            'currency' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['gross_amount']['currency_code'] ?? null,
            'amount' => $paidAmount ?? null,
            'reference' => $response['id'] ?? null,
            'description' => 'Due Payment for order '.$order->order_number,
            'billed_at' => now(),
        ]);

        // create transaction for paypal fee
        Transaction::create([
            'type' => 'debit',
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'gateway' => 'paypal',
            'status' => 'completed',
            'currency' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['currency_code'] ?? null,
            'amount' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value'] ?? null,
            'reference' => $response['id'] ?? null,
            'description' => 'Paypal fee for order '.$order->order_number,
            'billed_at' => now(),
        ]);

        session()->forget('order_id_'.Auth::id());
        session()->forget('paypal_id_'.Auth::id());

        return view('Frontend.Checkout.success', [
            'order' => $order,
            'response' => $response,
            'data' => $data
        ]);
    }


    public function paypal(Request $request){
        try{
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            if($request->order_id){
                $order = Order::find($request->order_id);
                if(!$order){
                    return redirect()->route('checkout.paypal.cancel');
                }
            }else{
                return redirect()->route('checkout.paypal.cancel');
            }

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context"=> [
                    "return_url"=> route('checkout.paypal.success'),
                    "cancel_url"=> route('checkout.paypal.cancel')
                ],
                "purchase_units" => [
                    [
                        "amount"=>[
                            "currency_code"=> "GBP",
                            "value"=> $order->grand_total,
                        ],
                        "reference_id" => $order->id,
                    ]
                ]
            ]);

            if(isset($response['id']) && $response['id'] !=null){
                $paypalkey = 'paypal_id_'.Auth::id();
                session([$paypalkey => $response['id']]);

                foreach($response['links'] as $link){

                    if($link['rel'] == 'self'){
                        Paypal::UpdateOrCreate([
                            'token' => $response['id'] ?? null,
                            'paypal_id' => $response['id'] ?? null,
                            'status' => $response['status'] ?? null,
                            'user_id' => Auth::id(),
                            'order_id' => $order->id,
                        ]);
                    }

                    if($link['rel'] == 'approve'){
                        return redirect()->away($link['href']);
                    }
                }
            }else{
                return redirect()->route('checkout.paypal.cancel');
            }
        }catch(\Exception $e){
            dd($e->getMessage());
            Log::error($e->getMessage());
            return redirect()->route('checkout.paypal.cancel');
        }
    }

    public function paypalSuccess(Request $request){
        $data = [];
        $data = array_merge($data, $this->frontendItems($request));

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        $paidAmount = $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['gross_amount']['value'];

        // update paypal where paypal_id = $response['id']
        Paypal::where('paypal_id', $response['id'])->update([
            'payer_id' => $response['payer']['payer_id'] ?? null,
            'payer_first_name' => $response['payer']['name']['given_name'] ?? null,
            'payer_last_name' => $response['payer']['name']['surname'] ?? null,
            'payer_email' => $response['payer']['email_address'] ?? null,
            'status' => $response['status'] ?? null,
            'amount' => $paidAmount ?? null,
            'currency' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['gross_amount']['currency_code'] ?? null,
            'paypal_fee' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value'] ?? null,
            'paypal_fee_currency' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['currency_code'] ?? null,
            'net_amount' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value'] ?? null,
            'net_amount_currency' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['currency_code'] ?? null,

            'payment_source' => $response['payment_source'] ? json_encode($response['payment_source']) : null,
            'purchase_units' => $response['purchase_units'] ? json_encode($response['purchase_units']) : null,
            'payer' => $response['payer'] ? json_encode($response['payer']) : null,
        ]);

        // find order
        $order = Order::where('id', $response['purchase_units'][0]['reference_id'])->first();

        $order->update([
            'paid_amount' => $paidAmount,
            'due_amount' => $order->grand_total - $paidAmount,
            'payment_status' => 'paid',
            'status' => 'processing',
            'payment_id' => $response['id'],
            'shipping_status' => 'processing',
            'paid_at' => now(),
        ]);

        // delete cart
        CartItem::where('cart_id', Cart::where('user_id', Auth::id())->latest('id')->first()->id)->delete();
        Cart::where('user_id', Auth::id())->latest('id')->first()->delete();

        // create order track
        $order->tracks()->create([
            'status' => 'processing',
            'message' => 'Order is processing, please wait for the confirmation email. Thank you for shopping with us.',
        ]);

        // Transaction table insert
        Transaction::create([
            'type' => 'credit',
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'gateway' => 'paypal',
            'status' => 'completed',
            'currency' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['gross_amount']['currency_code'] ?? null,
            'amount' => $paidAmount ?? null,
            'reference' => $response['id'] ?? null,
            'description' => 'Payment for order '.$order->order_number,
            'billed_at' => now(),
        ]);

        // create transaction for paypal fee
        Transaction::create([
            'type' => 'debit',
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'gateway' => 'paypal',
            'status' => 'completed',
            'currency' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['currency_code'] ?? null,
            'amount' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value'] ?? null,
            'reference' => $response['id'] ?? null,
            'description' => 'Paypal fee for order '.$order->order_number,
            'billed_at' => now(),
        ]);

        session()->forget('order_id_'.Auth::id());
        session()->forget('paypal_id_'.Auth::id());

        return view('Frontend.Checkout.success', [
            'order' => $order,
            'response' => $response,
            'data' => $data
        ]);
    }

    public function paypalCancel(Request $request){

        $data = [];
        $data = array_merge($data, $this->frontendItems($request));

        $error = null;
        $response = null;

        try{
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            if($request->token){
                $response = $provider->capturePaymentOrder($request->token);
                $error = $response['error'] ?? null;
            }

            // find order
            $paypalkey = 'paypal_id_'.Auth::id();
            $orderKey = 'order_id_'.Auth::id();
            $order = Order::where('id', session($orderKey))->first();

            if($order){
                $order->update([
                    'payment_status' => 'Declined',
                    'status' => 'canceled',
                ]);

                // create order track
                $order->tracks()->create([
                    'status' => 'canceled',
                    'message' => 'Order is canceled due to payment failure. Please try again.',
                ]);
            }

            // update paypal where paypal_id = $response['id']
            Paypal::where('token', session($paypalkey))->update([
                'error' => $response['error'] ?? null,
                'error_message' => $error['message'] ?? null,
                'status' => $response['status'] ?? 'CANCELLED',
            ]);

            session()->forget($paypalkey);
            session()->forget($orderKey);

        }catch(\Exception $e){
            $error = $e->getMessage();
        }

        return view('Frontend.Checkout.cancel', [
            'error' => $error,
            'data' => $data
        ]);

    }

    private function calculateCartSubtotal($cartId)
    {
        $cart = Cart::find($cartId);
        $items = $cart->items ?? collect();

        return $items->sum(function ($item) {
            return $item->quantity * ($item->book->discounted_price ?? $item->book->sale_price);
        });
    }
}
