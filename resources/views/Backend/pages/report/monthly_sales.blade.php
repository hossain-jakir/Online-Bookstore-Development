<!-- resources/views/Backend/pages/report/monthly_sales.blade.php -->

@extends('Backend.layouts.master')

@section('title', 'Yearly Sales Report')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Yearly Sales Report for {{ $currentYear }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Sales Report</li>
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
            <div class="row mb-3">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('backend.report.monthlySales', ['year' => $previousYear]) }}" class="btn btn-primary">Previous Year</a>
                        <a href="{{ route('backend.report.monthlySales', ['year' => $nextYear]) }}" class="btn btn-primary">Next Year</a>
                    </div>
                </div>
            </div>

            <!-- Monthly Sales Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Credit</th>
                            <th>Debit</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $month => $amounts)
                            <tr>
                                <td>{{ Carbon\Carbon::create($year, $month, 1)->format('F') }}</td>
                                <td>£{{ number_format($amounts['credit'], 2) }}</td>
                                <td>£{{ number_format($amounts['debit'], 2) }}</td>
                                <td>£{{ number_format($amounts['total'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@section('page-script')
<style>
    .table th, .table td {
        text-align: center;
    }
    .table {
        margin-top: 20px;
    }
</style>
@endsection
