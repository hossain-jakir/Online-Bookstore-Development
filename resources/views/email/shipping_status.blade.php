<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            margin: 0 auto;
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
        }
        .content {
            font-size: 16px;
        }
        .content p {
            margin-bottom: 15px;
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
            <h1>Order Status Update</h1>
        </div>

        <div class="content">
            <p>Hello {{ $order->user->first_name }},</p>
            <p>Your order with the number <strong>{{ $order->order_number }}</strong> shipping status has been updated to <strong>{{ $order->shipping_status }}</strong>.</p>
            <p><strong>Message:</strong> {{ $shippingMessage }}</p>
            <p>Thank you for shopping with us. You can track your order status in your account.</p>
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
