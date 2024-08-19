@extends('Backend.layouts.master')

@section('title', 'Order Tracking - ' . $order->order_number)

@section('content')
<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Order Tracking</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.order.index') }}">Manage Orders</a></li>
                        <li class="breadcrumb-item active">Order Tracking</li>
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
                    <!-- Basic Order Info -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <strong>Order Info</strong>
                            <a href="{{ route('backend.order.show', ['id' => $order->id, 'order_number' => $order->order_number]) }}" class="btn btn-secondary btn-sm float-right">Order Details</a>
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
                                        <span class="step-icon {{ $order->shipping_status === 'pending' ? 'text-primary' : 'text-muted' }}">&#x1F4E6;</span>
                                        <p class="{{ $order->shipping_status === 'pending' ? 'font-weight-bold' : 'text-muted' }}">Pending</p>
                                    </div>
                                    <div class="col-3">
                                        <span class="step-icon {{ $order->shipping_status === 'processing' ? 'text-primary' : 'text-muted' }}">&#x2699;</span>
                                        <p class="{{ $order->shipping_status === 'processing' ? 'font-weight-bold' : 'text-muted' }}">Processing</p>
                                    </div>
                                    <div class="col-3">
                                        <span class="step-icon {{ $order->shipping_status === 'shipped' ? 'text-primary' : 'text-muted' }}">&#x1F69A;</span>
                                        <p class="{{ $order->shipping_status === 'shipped' ? 'font-weight-bold' : 'text-muted' }}">Shipped</p>
                                    </div>
                                    <div class="col-3">
                                        <span class="step-icon {{ $order->shipping_status === 'delivered' ? 'text-primary' : ($order->shipping_status === 'canceled' ? 'text-danger' : 'text-muted') }}">&#x1F4E4;</span>
                                        <p class="{{ $order->shipping_status === 'delivered' || $order->shipping_status === 'canceled' ? 'font-weight-bold' : 'text-muted' }}">
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
                                        <small class="text-muted">{{ $track->created_at->format('d M Y, H:i') }}</small>
                                    </li>
                                @endforeach
                            </ul>
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

@section('addScript')
@endsection
