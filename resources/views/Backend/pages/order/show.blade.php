@extends('Backend.layouts.master')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')
<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Order Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.order.index') }}">Manage Orders</a></li>
                        <li class="breadcrumb-item active">Order Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    {{-- made a bar to show button for tracking order and print invoice --}}
                    <div class="btn-toolbar mb-4" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="First group">
                            @if($order->shipping_status != 'delivered')
                                <a href="{{ route('backend.order.track', ['id' => $order->id]) }}" class="btn btn-primary">Track Order</a>
                            @endif
                        </div>
                        <div class="btn-group mr-2" role="group" aria-label="Second group">
                            <a href="{{ route('backend.order.invoice', ['id' => $order->id]) }}" class="btn btn-primary" target="_blank">Print Invoice</a>
                        </div>
                        {{-- edit --}}
                        <div class="btn-group mr-2" role="group" aria-label="Third group">
                            <a href="{{ route('backend.order.edit', ['id' => $order->id]) }}" class="btn btn-primary">Edit Order</a>
                        </div>
                    </div>

                    <!-- Delivery Status Update -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <strong>Update Delivery Status</strong>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('backend.order.updateStatus', ['id' => $order->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="status">Delivery Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="pending" {{ $order->shipping_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->shipping_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->shipping_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->shipping_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="canceled" {{ $order->shipping_status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="message">Update Message</label>
                                    <textarea id="message" name="message" class="form-control" rows="3" placeholder="Enter update message..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </form>
                        </div>
                    </div>

                    <!-- Tracking Progress -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <strong>Tracking History</strong>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($order->tracks as $track)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Status:</strong> {{ ucfirst($track->status) }} <br>
                                            <strong>Message:</strong> {{ $track->message }}
                                        </div>
                                        <small class="text-muted">{{ $track->created_at->format('d M Y, H:i') }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Acoount Information -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-warning text-white">
                            <strong>Account Information</strong>
                        </div>
                        <div class="card-body">
                            <p><strong>Customer Name:</strong> {{ $order->user->first_name }} {{ $order->user->last_name }}</p>
                            <p><strong>Email:</strong> {{ $order->user->email }}</p>
                            <p><strong>Phone:</strong> {{ $order->user->phone }}</p>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <strong>Order Summary</strong>
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
                                                <img src="{{ $item->book->image }}" alt="{{ $item->book->title }}" style="width: 60px; height: auto;">
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
                                    <td>£{{ number_format($order->due_amount, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <strong>Transaction History</strong>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>Payment Method</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->type }}</td>
                                            <td>{{ $transaction->gateway }}</td>
                                            <td>{{$transaction->currency}} {{ number_format($transaction->amount, 2) }}</td>
                                            <td>{{ $transaction->description }}</td>
                                            <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('page-script')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        var statusSelect = document.getElementById('status');
        var messageTextarea = document.getElementById('message');

        var statusMessages = {
            'pending': 'The order is pending and has not been processed yet.',
            'processing': 'The order is currently being processed.',
            'shipped': 'The order has been shipped and is on its way.',
            'delivered': 'The order has been delivered successfully.',
            'canceled': 'The order has been canceled.'
        };

        if (statusSelect && messageTextarea) {
            statusSelect.addEventListener('change', function() {
                var selectedStatus = this.value;
                console.log("Selected Status: " + selectedStatus);
                messageTextarea.value = statusMessages[selectedStatus] || '';
            });

            // Set initial message if a status is already selected
            var initialStatus = statusSelect.value;
            messageTextarea.value = statusMessages[initialStatus] || '';
        } else {
            console.error("Elements not found");
        }
    });
</script>
@endsection
