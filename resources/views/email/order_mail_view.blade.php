<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            margin: auto;
            width: 600px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #007bff;
            font-size: 24px;
        }
        .content {
            margin-bottom: 20px;
        }
        .content h2 {
            color: #333;
            font-size: 20px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
        }
        .order-details {
            margin-top: 20px;
        }
        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-details th, .order-details td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .order-details th {
            background-color: #f8f8f8;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                @if ($type == 1)
                    Order Confirmation
                @elseif ($type == 2)
                    Payment Received
                @elseif ($type == 3)
                    Order Payment Failed
                @endif
            </h1>
        </div>

        <div class="content">
            <h2>Hello {{ $data->user->first_name }} {{ $data->user->last_name }},</h2>

            @if ($type == 1)
                <p>Thank you for your order! Your order number is <strong>{{ $data->order_number }}</strong>.</p>
                <p>Here are the details of your order:</p>

                <div class="order-details">
                    <table>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->orderItems as $item)
                                <tr>
                                    <td>{{ $item->book->title }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>£{{ number_format($item->price, 2) }}</td>
                                    <td>£{{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" style="text-align:right;">Subtotal:</th>
                                <td>£{{ number_format($data->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3" style="text-align:right;">Coupon:</th>
                                <td>£{{ number_format($data->coupon_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3" style="text-align:right;">Tax:</th>
                                <td>£{{ number_format($data->tax_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3" style="text-align:right;">Shipping:</th>
                                <td>£{{ number_format($data->shipping_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3" style="text-align:right;">Discount:</th>
                                <td>£{{ number_format($data->discount_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3" style="text-align:right;">Grand Total:</th>
                                <td>£{{ number_format($data->grand_total, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3" style="text-align:right;">Paid Amount:</th>
                                <td>£{{ number_format($data->paid_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3" style="text-align:right;">Due Amount:</th>
                                <td>£{{ number_format($data->due_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <p>We will notify you once your order has been shipped. You can track your order through your account.</p>

            @elseif ($type == 2)
                <p>Thank you for completing the payment for your order <strong>{{ $data->order_number }}</strong>.</p>
                <p>We have successfully received your payment of <strong>£{{ number_format($data->paid_amount, 2) }}</strong>.</p>
                <p>Your order is now fully paid, and we will process it shortly.</p>

            @elseif ($type == 3)
                <p>Unfortunately, your payment for order number <strong>{{ $data->order_number }}</strong> has failed.</p>
                <p>Please try again or contact support if the issue persists.</p>
            @endif

            <p>If you have any questions, feel free to contact our support team.</p>
        </div>

        <div class="footer">
            @php
                $shop = \App\Models\Shop::first();
            @endphp
            <p><strong>{{ $shop->name }}</strong> | {{ $shop->address }} | {{ $shop->phone }} | <a href="mailto:{{ $shop->email }}">{{ $shop->email }}</a></p>
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
