@extends('Frontend/Main/index')

@section('title', 'Order Tracking - ' . $order->order_number)

@section('content')

<!-- Content -->
<div class="page-content bg-white">
    <!-- Order Tracking area -->
    <div class="content-block">
        <section class="content-inner bg-white">
            <div class="container">
                <div class="row">
                    @include('Frontend/Profile/profile-menu')
                    <div class="col-xl-9 col-lg-8 mb-30">
                        <h2 class="mb-4">Order Tracking</h2>

                        <!-- Basic Order Info -->
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <strong>Order Info</strong>
                                <a href="{{ route('profile.order.show', ['id' => $order->id, 'order_number' => $order->order_number]) }}" class="btn btn-secondary">Order Details</a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                                        <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Status:</strong>
                                            <span class="badge badge-{{ $order->shipping_status == 'delivered' ? 'success' : ($order->shipping_status == 'canceled' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($order->shipping_status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tracking Progress -->
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-info text-white">
                                <strong>Tracking Progress</strong>
                            </div>
                            <div class="card-body">
                                <div class="progress mb-4">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated {{ $order->shipping_status == 'canceled' ? 'bg-danger' : 'bg-success' }}" role="progressbar" style="width: {{ $progressWidth }}%;" aria-valuenow="{{ $progressWidth }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ ucfirst($order->shipping_status) }} ({{ $progressWidth }}%)
                                    </div>
                                </div>
                                <div class="tracking-steps">
                                    <div class="row text-center">
                                        <div class="col-3">
                                            <span class="step-icon {{ $order->shipping_status === 'pending' ? 'active' : '' }}">&#x1F4E6;</span>
                                            <p class="{{ $order->shipping_status === 'pending' ? 'font-weight-bold' : '' }}">Pending</p>
                                        </div>
                                        <div class="col-3">
                                            <span class="step-icon {{ $order->shipping_status === 'processing' ? 'active' : '' }}">&#x2699;</span>
                                            <p class="{{ $order->shipping_status === 'processing' ? 'font-weight-bold' : '' }}">Processing</p>
                                        </div>
                                        <div class="col-3">
                                            <span class="step-icon {{ $order->shipping_status === 'shipped' ? 'active' : '' }}">&#x1F69A;</span>
                                            <p class="{{ $order->shipping_status === 'shipped' ? 'font-weight-bold' : '' }}">Shipped</p>
                                        </div>
                                        <div class="col-3">
                                            <span class="step-icon {{ $order->shipping_status === 'delivered' ? 'active' : '' }} {{ $order->shipping_status === 'canceled' ? 'text-danger' : '' }}">&#x1F4E4;</span>
                                            <p class="{{ $order->shipping_status === 'delivered' || $order->shipping_status === 'canceled' ? 'font-weight-bold' : '' }}">
                                                {{ $order->shipping_status === 'canceled' ? 'Canceled' : 'Delivered' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tracking History -->
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
                                            <small class="text">{{ $track->created_at->format('d M Y, H:i') }}</small>
                                        </li>
                                    @endforeach
                                </ul>
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
<!-- Additional scripts if needed -->
@endsection
