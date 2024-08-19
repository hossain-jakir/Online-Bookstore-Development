@extends('Backend.layouts.master')

@section('title', 'Best Seller Books')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Top 10 Best Seller Books</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Reports</li>
                        <li class="breadcrumb-item active">Best Seller Books</li>
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
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Book Title</th>
                            <th>Author</th>
                            <th>Total Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bestSellers as $index => $bestSeller)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $bestSeller->book->title }}</td>
                                <td>{{ $bestSeller->book->author->first_name . ' ' . $bestSeller->book->author->last_name }}</td>
                                <td>{{ $bestSeller->total_sold }}</td>
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
