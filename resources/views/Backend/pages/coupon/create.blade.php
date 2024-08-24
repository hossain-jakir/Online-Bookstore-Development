@extends('Backend.layouts.master')

@section('title', 'Create Coupon')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Coupon</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Create Coupon</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('backend.coupon.store') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Coupon Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="code">Coupon Code</label>
                                    <input type="text" class="form-control" name="code" id="code" placeholder="Enter Coupon Code">
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="fixed">Fixed</option>
                                        <option value="percentage">Percentage</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="value">Value</label>
                                    <input type="number" class="form-control" name="value" id="value" placeholder="Enter Coupon Value">
                                </div>
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date">
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Save Coupon</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
