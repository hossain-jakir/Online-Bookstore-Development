@extends('Backend/layouts/master')

@section('title', 'User Details')

@section('page-script')
    <script src="{{ asset('assets/frontend/js/jquery.min.js')}}"></script><!-- JQUERY MIN JS -->
    <script src="{{ asset('assets/frontend/vendor/wow/wow.min.js')}}"></script><!-- WOW JS -->
    <script src="{{ asset('assets/frontend/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script><!-- BOOTSTRAP MIN JS -->
    <script src="{{ asset('assets/frontend/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script><!-- BOOTSTRAP SELECT MIN JS -->
    <script src="{{ asset('assets/frontend/vendor/counter/waypoints-min.js')}}"></script><!-- WAYPOINTS JS -->
    <script src="{{ asset('assets/frontend/vendor/counter/counterup.min.js')}}"></script><!-- COUNTERUP JS -->
    <script src="{{ asset('assets/frontend/vendor/swiper/swiper-bundle.min.js')}}"></script><!-- SWIPER JS -->
    <script src="{{ asset('assets/frontend/js/dz.carousel.js')}}"></script><!-- DZ CAROUSEL JS -->
    <script src="{{ asset('assets/frontend/js/dz.ajax.js')}}"></script><!-- AJAX -->
    <script src="{{ asset('assets/frontend/js/custom.js')}}"></script><!-- CUSTOM JS -->
@endsection

@section('page-style')
<!-- STYLESHEETS -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/icons/fontawesome/css/all.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/swiper/swiper-bundle.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/animate/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/style.css')}}">

<!-- GOOGLE FONTS-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User Details</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.user.index') }}">User</a></li>
                            <li class="breadcrumb-item active">User Details</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        @if ($errors->any() || session('error'))
            @include('Backend._partials.errorMsg')
        @endif

        @if (session('success'))
            @include('Backend._partials.successMsg')
        @endif

        <!-- Main content -->
        <!-- Browse Jobs -->
        <section class="content-inner bg-white" style="padding-top: 50px !important;">
            <div class="container">
                <div class="row">
                    @include('Backend/pages/user/profile-menu')
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
                                            <a href="{{ route('backend.order.track', ['id' => $order->id]) }}" class="btn btn-outline-primary btn-sm">Track Order</a>
                                        @endif
                                        <a href="{{ route('backend.order.show', ['id' => $order->id]) }}" class="btn btn-primary btn-sm">Order Details</a>
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
        <!-- Browse Jobs END -->
        <!-- /.content -->
    </div>

@endsection
