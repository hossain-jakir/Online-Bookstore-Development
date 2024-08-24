@extends('Backend.layouts.master')

@section('title', 'Edit Coupon')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Coupon</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Coupon</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('backend.coupon.update', $coupon->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Coupon Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="code">Coupon Code</label>
                                    <input type="text" class="form-control" name="code" id="code" value="{{ $coupon->code }}">
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="value">Value</label>
                                    <input type="number" class="form-control" name="value" id="value" value="{{ $coupon->value }}">
                                </div>
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="datetime-local" class="form-control" name="start_date" id="start_date" value="{{ $coupon->start_date }}">
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="datetime-local" class="form-control" name="end_date" id="end_date" value="{{ $coupon->end_date }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="4">{{ $coupon->description }}</textarea>
                                </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="active" {{ $coupon->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $coupon->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Update Coupon</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
