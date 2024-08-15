@extends('Frontend/Main/index')

@section('title', 'Payment Successful')

@section('content')

    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3>Payment Successful</h3>
            </div>
            <div class="card-body">
                <p>Thank you for your purchase! Your payment has been processed successfully.</p>
                <p><strong>Order Number:</strong> {{ $order->order_number}}</p>
                <p><strong>Total Amount:</strong> £{{ number_format($order->grand_total, 2) }}</p>
                <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
            </div>
        </div>
    </div>

@endsection
