@extends('Frontend/Main/index')

@section('title', auth()->user()->first_name . ' ' . auth()->user()->last_name . ' - Orders')

@section('content')

<!-- Content -->
<div class="page-content bg-white">
    <!-- Orders area -->
    <div class="content-block">
        <section class="content-inner bg-white">
            <div class="container">
                <div class="row">
                    @include('Frontend/Profile/profile-menu')
                    <div class="col-xl-9 col-lg-8 mb-30">
                        <h2 class="mb-4">My Orders</h2>

                        <!-- Check if there are any orders -->
                        @forelse($data['orders'] as $order)
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">Order #{{ $order->order_number }}</h5>
                                        <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                                    </div>
                                    <div>
                                        @if($order->shipping_status != 'delivered')
                                            <a href="{{ route('profile.order.track', ['id' => $order->id, 'order_number' => $order->order_number]) }}" class="btn btn-outline-primary btn-sm">Track Order</a>
                                        @endif
                                        <a href="{{ route('profile.order.show', ['id' => $order->id, 'order_number' => $order->order_number]) }}" class="btn btn-primary btn-sm">Order Details</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p><strong>Total Amount:</strong><br>£{{ number_format($order->grand_total, 2) }}</p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Payment Status:</strong><br>{{ ucfirst($order->payment_status) }}</p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Order Status:</strong><br>{{ ucfirst($order->status) }}</p>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <strong>Shipping Status:</strong><br>
                                            <span class="badge badge-{{ $order->shipping_status == 'delivered' ? 'success' : ($order->shipping_status == 'shipped' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($order->shipping_status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p><strong>Paid:</strong> £{{ number_format($order->paid_amount, 2) }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><strong>Due:</strong> £{{ number_format($order->due_amount, 2) }}</p>
                                        </div>
                                        <div class="col-md-4 text-right">
                                            @if ($order->due_amount > 0)
                                                <a href="{{ route('checkout.paypal.form.due', ['order_id' => $order->id, 'order_number' => $order->order_number]) }}" class="btn btn-primary btn-sm">Pay Due</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info" role="alert">
                                No orders found.
                            </div>
                        @endforelse

                        <!-- Pagination -->
                        <div class="d-flex justify-content-end mt-4">
                            {{ $data['orders']->links() }}
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

@section('addStyle')
@endsection
