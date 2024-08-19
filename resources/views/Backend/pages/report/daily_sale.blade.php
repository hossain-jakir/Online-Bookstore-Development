<!-- resources/views/Backend/pages/report/daily_sale.blade.php -->
@extends('Backend.layouts.master')

@section('title', 'Daily Sales Report')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daily Sales Report for {{ $currentMonth }}</h1>
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
                        <a href="{{ route('backend.report.dailySales', ['year' => explode('/', $previousMonth)[0], 'month' => explode('/', $previousMonth)[1]]) }}" class="btn btn-primary">Previous Month</a>
                        <a href="{{ route('backend.report.dailySales', ['year' => explode('/', $nextMonth)[0], 'month' => explode('/', $nextMonth)[1]]) }}" class="btn btn-primary">Next Month</a>
                    </div>
                </div>
            </div>

            <!-- Calendar -->
            <div class="calendar">
                @php
                    $start = Carbon\Carbon::create($year, $month, 1);
                    $end = $start->copy()->endOfMonth();
                    $today = Carbon\Carbon::today()->format('Y-m-d');
                @endphp

                <div class="row">
                    @foreach (range(1, $end->day) as $day)
                        @php
                            $currentDate = $start->copy()->day($day);
                            $formattedDate = $currentDate->format('Y-m-d');
                            $dayName = $currentDate->format('l');
                            $salesAmount = $sales[$formattedDate] ?? ['credit' => 0, 'debit' => 0];
                            $isToday = $formattedDate == $today ? 'today' : '';
                        @endphp
                        <div class="col-2 text-center">
                            <div class="day-box {{ $isToday }}">
                                <strong>{{ $day }}</strong>
                                <br>
                                <small>{{ $dayName }}</small>
                                <hr>
                                <div>
                                    <span class="badge badge-success">Credit: £{{ number_format($salesAmount['credit'], 2) }}</span>
                                    <br>
                                    <span class="badge badge-danger">Debit: £{{ number_format($salesAmount['debit'], 2) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('page-script')
<style>
    .calendar {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -5px;
    }
    .day-box {
        border: 1px solid #ddd;
        padding: 5px;
        margin: 5px;
        min-height: 120px;
        box-sizing: border-box;
        position: relative;
        text-align: center;
        background-color: #fff;
        border-radius: 4px;
    }
    .day-box.today {
        border-color: #007bff;
        background-color: #e3f2fd;
    }
    .badge-success {
        background-color: #28a745;
        color: #fff;
    }
    .badge-danger {
        background-color: #dc3545;
        color: #fff;
    }
</style>
@endsection
