@extends('Backend.layouts.master')

@section('title', 'Best Selling Authors')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Top 10 Best Selling Authors</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Reports</li>
                        <li class="breadcrumb-item active">Best Selling Authors</li>
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
                            <th>Author</th>
                            <th>Total Books Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bestSellingAuthors as $author)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $author->author_name }}</td>
                                <td>{{ $author->total_sold }}</td>
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
