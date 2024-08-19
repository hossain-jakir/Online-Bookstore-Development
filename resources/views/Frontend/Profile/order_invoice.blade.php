<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .invoice-container {
            padding: 20px;
            max-width: 100%; /* Ensure full width */
            margin: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            box-sizing: border-box; /* Include padding and border in element's total width and height */
            page-break-inside: avoid; /* Prevent page break inside container */
        }
        .invoice-header h2 {
            margin: 0;
        }
        .invoice-header small {
            display: block;
            margin-top: 5px;
            color: #777;
        }
        .company-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .company-info h2 {
            margin: 0;
        }
        .company-info p {
            margin: 5px 0;
        }
        .invoice-table, .invoice-summary {
            margin-top: 20px;
        }
        .invoice-table table, .invoice-summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-table th, .invoice-summary th, .invoice-table td, .invoice-summary td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .invoice-table th, .invoice-summary th {
            background-color: #f4f4f4;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .billing-shipping-row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            box-sizing: border-box; /* Ensure box-sizing includes padding */
        }
        .billing-shipping-column {
            flex: 1;
            margin-right: 20px;
        }
        .billing-shipping-column:last-child {
            margin-right: 0;
        }
        .invoice-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            .invoice-container, .invoice-container * {
                visibility: visible;
            }
            .invoice-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0 !important;
                padding: 0 !important;
                border: none; /* Remove border for print */
            }
            .text-right {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Company Information -->
        <div class="company-info">
            <img src="{{ Storage::url($data['shop']->logo) }}" alt="{{ $data['shop']->name }}" style="max-width: 200px;">
            <h2>{{ $data['shop']->name }}</h2>
            <p>
                {{ $data['shop']->address }} <br>
                Phone: {{ $data['shop']->phone }} <br>
                Email: {{ $data['shop']->email }} <br>
                {{ $data['shop']->website ? 'Website: ' . $data['shop']->website : '' }}
            </p>
        </div>

        <div class="invoice-header">
            <h2 class="mb-0">Invoice</h2>
            <small>Order Number: {{ $order->order_number }}</small>
            <small>Date: {{ $order->created_at->format('d M Y') }}</small>
        </div>
        <hr>

        <div class="billing-shipping-row">
            <div class="billing-shipping-column">
                <h5>Billing Information</h5>
                <p>
                    <strong>{{ $order->user->name }}</strong><br>
                    {{ $order->address->address_line_1 }}<br>
                    @if($order->address->address_line_2)
                        {{ $order->address->address_line_2 }}<br>
                    @endif
                    {{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->zip_code }}<br>
                    {{ $order->address->country->name }}<br>
                    <strong>Phone:</strong> {{ $order->address->phone_number }}<br>
                    <strong>Email:</strong> {{ $order->user->email }}
                </p>
            </div>
            <div class="billing-shipping-column">
                <h5>Shipping Information</h5>
                <p>
                    <strong>{{ $order->shippingAddress->first_name }} {{ $order->shippingAddress->last_name }}</strong><br>
                    {{ $order->shippingAddress->address_line_1 }}<br>
                    @if($order->shippingAddress->address_line_2)
                        {{ $order->shippingAddress->address_line_2 }}<br>
                    @endif
                    {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->zip_code }}<br>
                    {{ $order->shippingAddress->country->name }}<br>
                    <strong>Phone:</strong> {{ $order->shippingAddress->phone_number }}<br>
                    @if($order->shippingAddress->email)
                        <strong>Email:</strong> {{ $order->shippingAddress->email }}
                    @endif
                </p>
            </div>
        </div>

        <div class="invoice-table">
            <h5>Order Summary</h5>
            <table>
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->book->title }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>£{{ number_format($item->price, 2) }}</td>
                            <td>£{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="invoice-summary">
            <h5>Price Breakdown</h5>
            <table>
                <tr>
                    <td><strong>Product Cost:</strong></td>
                    <td>£{{ number_format($order->orderItems->sum('total'), 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Coupon Discount:</strong></td>
                    <td>- £{{ number_format($order->coupon_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Tax:</strong></td>
                    <td>£{{ number_format($order->tax_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Shipping:</strong></td>
                    <td>£{{ number_format($order->shipping_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Discount Amount:</strong></td>
                    <td>- £{{ number_format($order->discount_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Grand Total:</strong></td>
                    <td>£{{ number_format($order->grand_total, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Paid Amount:</strong></td>
                    <td>£{{ number_format($order->paid_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Due Amount:</strong></td>
                    <td>£{{ number_format($order->due_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="text-right mt-4">
            <button onclick="window.print();">Print Invoice</button>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <p>This is a computer-generated invoice and does not require a signature. Thank you for shopping with us!</p>
        </div>
    </div>
</body>
<script>
    window.onload = function() {
        window.print();
    }
</script>
</html>
