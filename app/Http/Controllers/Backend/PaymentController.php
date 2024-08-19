<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Models\Paypal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    public function refundPayment(Request $request, $orderId, $refundAmount = null){
        // Find the order
        $order = Order::findOrFail($orderId);

        // Find the PayPal transaction related to this order
        $paypal = Paypal::where('order_id', $order->id)->first();

        if (!$paypal) {
            return response()->json(['message' => 'PayPal transaction not found'], 404);
        }

        // Initialize PayPal provider
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        // dd($paypal->paypal_id);
        $response = $provider->showCapturedPaymentDetails('1LP04695RG6452904');
        dd($response);

        // Refund the payment
        $refundAmount = $refundAmount ?? $paypal->amount;
        $response = $response = $provider->refundCapturedPayment(
            $paypal->paypal_id,
            $order->order_number,
            $refundAmount,
            'Refund for order ' . $order->order_number,
        );

        dd($response);

        DB::beginTransaction();
        // Handle response
        if ($response['status'] === 'COMPLETED') {
            // Update the order status and due amount
            $order->update([
                'due_amount' => $order->due_amount + $refundAmount,
                'payment_status' => 'refunded',
                'status' => 'refunded',
            ]);

            // Update the PayPal record to include refund info
            $paypal->update([
                'refund_id' => $response['id'],
                'refund_status' => $response['status'],
                'refund_amount' => $refundAmount,
                'refund_currency' => $response['amount']['currency_code'],
            ]);

            // Create a transaction record for the refund
            Transaction::create([
                'type' => 'debit',
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'gateway' => 'paypal',
                'status' => 'completed',
                'currency' => $response['amount']['currency_code'],
                'amount' => $refundAmount,
                'reference' => $response['id'],
                'description' => 'Refund for order ' . $order->order_number,
                'billed_at' => now(),
            ]);

            DB::commit();

            return response()->json(['message' => 'Payment refunded successfully']);
        } else {
            DB::rollBack();
            return response()->json(['message' => 'Refund failed', 'error' => $response], 500);
        }
    }
}
