@extends('Backend.layouts.master')

@section('title', 'Manage Orders')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Orders</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Manage Orders</li>
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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Orders table -->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Orders List</h3>
                                <!-- Search form -->
                                <form action="{{ route('backend.order.index') }}" method="GET" class="form-inline">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by Order Number or Customer Name" value="{{ request()->get('search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if($orders->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order Number</th>
                                                <th>Customer Name</th>
                                                <th>Amount</th>
                                                <th>Payment Status</th>
                                                <th>Order Status</th>
                                                <th>Shipping Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('backend.order.show', ['id' => $order->id]) }}" class="btn btn-info btn-sm">
                                                            {{ $order->order_number }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $order->user->full_name }}</td>
                                                    <td>
                                                        <strong>Total: </strong>£{{ number_format($order->grand_total, 2) }}<br>
                                                        <strong>Paid: </strong>£{{ number_format($order->paid_amount, 2) }}<br>
                                                        <strong>Due: </strong>£{{ number_format($order->due_amount, 2) }}
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-{{ $order->payment_status == 'completed' ? 'success' : 'warning' }}">
                                                            {{ ucfirst($order->payment_status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-{{ $order->status == 'completed' ? 'success' : ($order->status == 'processing' ? 'warning' : 'secondary') }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-{{ $order->shipping_status == 'delivered' ? 'success' : ($order->shipping_status == 'shipped' ? 'warning' : 'secondary') }}">
                                                            {{ ucfirst($order->shipping_status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('backend.order.show', ['id' => $order->id]) }}" class="btn btn-info btn-sm">View</a>
                                                        @can('edit order')
                                                        <a href="{{ route('backend.order.edit', ['id' => $order->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        @endcan
                                                        @can('delete order')
                                                        <form action="{{ route('backend.order.destroy', ['id' => $order->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Pagination -->
                                <div class="d-flex justify-content-end mt-4">
                                    {{ $orders->links('pagination::bootstrap-4') }}
                                </div>
                            @else
                                <div class="alert alert-info" role="alert">
                                    No orders found.
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
