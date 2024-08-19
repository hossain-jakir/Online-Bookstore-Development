@extends('Backend.layouts.master')

@section('title', 'Monthly Sales Report')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sales Report for {{ $year }} - {{ $month }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Reports</li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.report.salesReport', ['year' => $year]) }}">Yearly Report</a></li>
                        <li class="breadcrumb-item active">Monthly Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any() || session('error'))
        @include('Backend._partials.errorMsg')
    @endif

    @if (session('success'))
        @include('Backend._partials.successMsg')
    @endif

    <section class="content mb-5">
        <div class="container-fluid mb-2">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('backend.report.salesReport', ['year' => $year, 'month' => $month - 1]) }}" class="btn btn-primary {{ $month == 1 ? 'disabled' : '' }}">Previous Month</a>
                        <a href="{{ route('backend.report.salesReport', ['year' => $year]) }}" class="btn btn-secondary">Back to Yearly Report</a>
                        <a href="{{ route('backend.report.salesReport', ['year' => $year, 'month' => $month + 1]) }}" class="btn btn-primary {{ $month == 12 ? 'disabled' : '' }}">Next Month</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mb-2">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Sales Summary</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Total Sales:</strong> £{{ number_format($salesData->total_sales, 2) }}</p>
                            <p><strong>Total Discount:</strong> £{{ number_format($salesData->total_discount, 2) }}</p>
                            <p><strong>Total Coupon Discount:</strong> £{{ number_format($salesData->total_coupon_discount, 2) }}</p>
                            <p><strong>Total Shipping:</strong> £{{ number_format($salesData->total_shipping, 2) }}</p>
                            <p><strong>Grand Total:</strong> £{{ number_format($salesData->grand_total, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title">Financial Summary</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Total Paid:</strong> £{{ number_format($salesData->total_paid, 2) }}</p>
                            <p><strong>Total Due:</strong> £{{ number_format($salesData->total_due, 2) }}</p>
                            <p><strong>Total Refund:</strong> £{{ number_format($salesData->total_refund, 2) }}</p>
                            <p><strong>Total Profit:</strong> £{{ number_format($salesData->total_profit, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h3 class="card-title">Transaction Summary</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Total Transactions:</strong> £{{ number_format($transactionData->total_transactions, 2) }}</p>
                            <p><strong>Total Credits:</strong> £{{ number_format($transactionData->total_credits, 2) }}</p>
                            <p><strong>Total Debits:</strong> £{{ number_format($transactionData->total_debits, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            <h3 class="card-title">Additional Information</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Total Orders:</strong> {{ $orderCount }}</p>
                            <p><strong>Year:</strong> {{ $year }}</p>
                            <p><strong>Month:</strong> {{ $month }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection
