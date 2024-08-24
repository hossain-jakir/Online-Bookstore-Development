@extends('Backend.layouts.master')

@section('title', 'Coupons')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Coupons</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Coupons</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if ($errors->any() || session('error'))
                @include('Backend._partials.errorMsg')
            @endif

            @if (session('success'))
                @include('Backend._partials.successMsg')
            @endif

            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('backend.coupon.create') }}" class="btn btn-primary mb-3">Add Coupon</a>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Coupons List</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Value</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $coupon->code }}</td>
                                            <td>{{ ucfirst($coupon->type) }}</td>
                                            <td>{{ $coupon->value }}</td>
                                            <td>Start from: {{ date('d-m-Y', strtotime($coupon->start_date)) }} <br> End at: {{ date('d-m-Y', strtotime($coupon->end_date)) }}</td>
                                            <td>{{ ucfirst($coupon->status) }}</td>
                                            <td>
                                                <a href="{{ route('backend.coupon.edit', $coupon->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('backend.coupon.destroy', $coupon->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $coupons->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
