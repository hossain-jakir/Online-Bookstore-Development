@extends('Frontend/Main/index')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')

<!-- Content -->
<div class="page-content bg-white">
    <!-- Order Details area -->
    <div class="content-block">
        <section class="content-inner bg-white">
            <div class="container">
                <div class="row">
                    @include('Frontend/Profile/profile-menu')
                    <div class="col-xl-9 col-lg-8 mb-30">
                        <h2 class="mb-4">Order Details</h2>

                        <!-- Order Summary -->
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <strong>Order Summary</strong>
                                <div class="float-right">
                                    @if($order->shipping_status != 'delivered')
                                        <a href="{{ route('profile.order.track', ['id' => $order->id, 'order_number' => $order->order_number]) }}" class="btn btn-secondary">Track Order</a>
                                    @endif
                                    <a href="{{ route('profile.order.invoice', ['id' => $order->id, 'order_number' => $order->order_number]) }}" class="btn btn-secondary" target="_blank">Print Invoice</a>
                                    @if ($order->due_amount > 0)
                                        <a href="{{ route('checkout.paypal.form.due', ['order_id' => $order->id, 'order_number' => $order->order_number]) }}" class="btn btn-danger">Pay Due</a>
                                    @endif

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                                        <p><strong>Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                                        <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Total Amount:</strong> £{{ number_format($order->grand_total, 2) }}</p>
                                        <p><strong>Status:</strong> <span class="badge badge-{{ $order->status == 'completed' ? 'success' : 'warning' }}">{{ ucfirst($order->status) }}</span></p>
                                        <p><strong>Shipping Status:</strong> <span class="badge badge-{{ $order->shipping_status == 'delivered' ? 'success' : 'info' }}">{{ ucfirst($order->shipping_status) }}</span></p>
                                    </div>
                                </div>
                                @if ($order->notes)
                                    <p><strong>Notes:</strong> {{ $order->notes }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-secondary text-white">
                                <strong>Shipping Address</strong>
                            </div>
                            <div class="card-body">
                                @if ($order->shippingAddress)
                                    <p><strong>{{ $order->shippingAddress->first_name }} {{ $order->shippingAddress->last_name }}</strong></p>
                                    <p>{{ $order->shippingAddress->address_line_1 }}</p>
                                    @if ($order->shippingAddress->address_line_2)
                                        <p>{{ $order->shippingAddress->address_line_2 }}</p>
                                    @endif
                                    <p>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->zip_code }}</p>
                                    <p>{{ $order->shippingAddress->country->name }}</p>
                                    <p><strong>Phone:</strong> {{ $order->shippingAddress->phone_number }}</p>
                                    @if ($order->shippingAddress->email)
                                        <p><strong>Email:</strong> {{ $order->shippingAddress->email }}</p>
                                    @endif
                                @else
                                    <p>No shipping address available.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-info text-white">
                                <strong>Order Items</strong>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Image</th>
                                            <th>Book Title</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                            <tr>
                                                <td>
                                                    <img src="{{ $item->book->image }}" alt="{{ $item->book->title }}" style="width: 50px; height: auto;">
                                                </td>
                                                <td>
                                                    <a href="{{ route('book.show', ['id' => base64_encode($item->book->id)]) }}">
                                                        {{ $item->book->title }}
                                                    </a>
                                                </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>£{{ number_format($item->price, 2) }}</td>
                                                <td>£{{ number_format($item->total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-success text-white">
                                <strong>Price Breakdown</strong>
                            </div>
                            <div class="card-body">
                                <table class="table">
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
                                        <td><strong>£{{ number_format($order->grand_total, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Paid Amount:</strong></td>
                                        <td>£{{ number_format($order->paid_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Due Amount:</strong></td>
                                        <td><strong>£{{ number_format($order->due_amount, 2) }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- Content END-->

@endsection

@section('addScript')
@endsection
