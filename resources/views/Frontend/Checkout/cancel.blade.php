@extends('Frontend/Main/index')

@section('title', 'Payment Cancelled')

@section('content')

    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h3>Payment Cancelled</h3>
            </div>
            <div class="card-body">
                <p>Your payment process was cancelled. No charges have been made.</p>
                <p>If you wish to continue shopping, you can return to your cart and try again.</p>
                <a href="{{ route('cart.index') }}" class="btn btn-primary">Return to Cart</a>
            </div>
        </div>
    </div>
@endsection

