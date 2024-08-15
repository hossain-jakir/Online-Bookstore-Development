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
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends MainController
{
    public function showPaymentForm(Request $request)
    {
        $order_id = session('order_id');
        return view('Frontend.Checkout.paypal_form', compact('order_id'));
    }


    public function paypal(Request $request){
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
                        "value"=> $order->grand_total
                    ],
                    "reference_id" => $order->id,
                ]
            ]
        ]);

        if(isset($response['id']) && $response['id'] !=null){
            foreach($response['links'] as $link){

                if($link['rel'] == 'self'){
                    Paypal::UpdateOrCreate([
                        'token' => $response['id'] ?? null,
                        'paypal_id' => $response['id'] ?? null,
                        'status' => $response['status'] ?? null,
                    ]);
                }

                if($link['rel'] == 'approve'){
                    return redirect()->away($link['href']);
                }
            }
        }else{
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

        // update paypal where paypal_id = $response['id']
        Paypal::where('paypal_id', $response['id'])->update([
            'payer_id' => $response['payer']['payer_id'] ?? null,
            'payer_first_name' => $response['payer']['name']['given_name'] ?? null,
            'payer_last_name' => $response['payer']['name']['surname'] ?? null,
            'payer_email' => $response['payer']['email_address'] ?? null,
            'status' => $response['status'] ?? null,
            'amount' => $response['purchase_units'][0]['amount']['value'] ?? null,
            'currency' => $response['purchase_units'][0]['amount']['currency_code'] ?? null,
            'paypal_fee' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value'] ?? null,
            'paypal_fee_currency' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['currency_code'] ?? null,
            'net_amount' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value'] ?? null,
            'net_amount_currency' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['currency_code'] ?? null,

            'payment_source' => $response['payment_source'] ? json_encode($response['payment_source']) : null,
            'purchase_units' => $response['purchase_units'] ? json_encode($response['purchase_units']) : null,
            'payer' => $response['payer'] ? json_encode($response['payer']) : null,
            'order_id' => null,
            'user_id' => auth()->id() ?? null,
        ]);

        // find order
        $order = Order::where('id', $response['purchase_units'][0]['reference_id'])->first();

        $order->update([
            'payment_status' => 'paid',
            'status' => 'completed',
            'payment_id' => $response['id'],
            'paid_at' => now(),
        ]);

        Cart::where('user_id', Auth::id())->latest('id')->first()->update([
            'isCheckedOut' => 1,
            'status' => 'completed',
        ]);

        CartItem::where('cart_id', Cart::where('user_id', Auth::id())->latest('id')->first()->id)->update([
            'status' => 'completed',
            'isCheckedOut' => 1,
        ]);

        session()->forget('order_id');

        return view('Frontend.Checkout.success', [
            'order' => $order,
            'response' => $response,
            'data' => $data
        ]);
    }

    public function paypalCancel(Request $request){
        $data = [];
        $data = array_merge($data, $this->frontendItems($request));
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        $error = $response['error'] ?? null;

        // update paypal where paypal_id = $response['id']
        Paypal::where('token', $request->token)->update([
            'error' => $response['error'] ?? null,
            'error_message' => $error['message'] ?? null,
            'status' => $response['status'] ?? 'CANCELLED',
        ]);

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
