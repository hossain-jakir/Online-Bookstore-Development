@extends('backend/layouts/master')

@section('title', 'Book List')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Book List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Book List</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        @if ($errors->any() || session('error'))
            @include('backend._partials.errorMsg')
        @endif

        @if (session('success'))
            @include('backend._partials.successMsg')
        @endif

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Book List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="datatables-users" class="table table-bordered table-striped" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Image</th>
                                            <th>Code</th>
                                            <th>Title</th>
                                            <th>Price</th>
                                            <th>Author</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data['rows'] as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <img src="{{ $item['image'] }}" alt="Book Image"
                                                        class="img-thumbnail" width="100">
                                                </td>
                                                <td>
                                                    {{ $item['code'] }}
                                                </td>
                                                <td>
                                                    {{ $item['title'] }}
                                                </td>
                                                <td width="15%">
                                                    Purchase Price: {{ $item['purchase_price'] }}
                                                    <br>
                                                    Sale Price: {{ $item['sale_price'] }}
                                                    <br>
                                                    Discount: {{ $item['discounted_price'] }}
                                                    <br>
                                                    Discount Type: {{ $item['discount_type'] }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('backend.user.index', $item['author']->id) }}">
                                                        {{ $item['author']->first_name . ' ' . $item['author']->last_name }}
                                                    </a>
                                                    <br>
                                                    {{ $item['author']->email }}
                                                </td>
                                                <td class="text-center" width="10%">
                                                    @if ($item['status'] == 'published')
                                                        <span class="badge badge-success">{{ $item['status'] }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ $item['status'] }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center" width="20%">
                                                    <button type="button" class="btn btn-sm btn-info mb-1 mt-1"
                                                        data-toggle="modal" data-target="#viewModal{{ $item['id'] }}"
                                                        title="View">
                                                        <i class="fa fa-eye text-white"></i>
                                                        View
                                                    </button>

                                                    <a href="{{ route('backend.book.edit', $item['id']) }}"
                                                        class="btn btn-sm btn-primary mb-1 mt-1" title="Edit">
                                                        <i class="fa fa-edit text-white"></i>
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('backend.book.delete', $item['id']) }}"
                                                        method="POST" class="d-inline-block">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger mb-1 mt-1"
                                                            onclick="return confirm('Are you sure you want to delete this item?');"
                                                            title="Delete">
                                                            <i class="fa fa-trash text-white"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    <h4>No data found</h4>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{-- paggination --}}
                                <div class="d-flex justify-content-center">
                                    {{ $data['rows']->links() }}
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    {{-- view modal --}}
    @foreach ($data['rows'] as $item)
        <div class="modal fade" id="viewModal{{ $item['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="viewModal{{ $item['id'] }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModal{{ $item['id'] }}Label">View Book Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ $item['image'] }}" alt="Book Image" class="img-thumbnail"
                                    width="100">
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Code</th>
                                        <td>{{ $item['code'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Title</th>
                                        <td>{{ $item['title'] }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $item['description'] }}</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>
                                        Purchase Price: {{ $item['purchase_price'] }}
                                        <br>
                                        Sale Price: {{ $item['sale_price'] }}
                                        <br>
                                        Discount: {{ $item['discounted_price'] }}
                                        <br>
                                        Discount Type: {{ $item['discount_type'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Publication</th>
                                    <td>
                                        {{ $item['publisher'] }} <br>
                                        Date : {{ $item['publication_date'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Author</th>
                                    <td>
                                        {{ $item['author']->first_name . ' ' . $item['author']->last_name }}
                                        <br>
                                        {{ $item['author']->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Isbn</th>
                                    <td>{{ $item['isbn'] }}</td>
                                </tr>
                                {{-- edition_language --}}
                                <tr>
                                    <th>Edition Language</th>
                                    <td>
                                       {{ $item['edition_language'] }}
                                    </td>
                                </tr>
                                {{-- pages --}}
                                <tr>
                                    <th>Pages</th>
                                    <td>
                                        {{ $item['pages'] }}
                                    </td>
                                </tr>
                                {{-- tags --}}
                                <tr>
                                    <th>Tags</th>
                                    <td>
                                        @foreach ($item['tag'] as $tag)
                                            <span class="badge badge-primary">{{ $tag['name'] }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                {{-- rating --}}
                                <tr>
                                    <th>Rating</th>
                                    <td>
                                        {{-- show with star --}}
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $item['rating'])
                                                <i class="fa fa-star text-warning"></i>
                                            @else
                                                <i class="fa fa-star text-secondary"></i>
                                            @endif
                                        @endfor
                                        {{-- sow only one value after decimal --}}
                                        {{ number_format($item['rating'], 1) }}
                                    </td>
                                </tr>
                                {{-- min_age --}}
                                <tr>
                                    <th>Min Age</th>
                                    <td>
                                        {{ $item['min_age'] }}
                                    </td>
                                </tr>
                                {{-- quantity --}}
                                <tr>
                                    <th>Quantity</th>
                                    <td>
                                        {{ $item['quantity'] }}
                                    </td>
                                </tr>
                                {{-- availability --}}
                                <tr>
                                    <th>Availability</th>
                                    <td>
                                        @if ($item['availability'] == '1')
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                                {{-- featured --}}
                                <tr>
                                    <th>Featured</th>
                                    <td>
                                        @if ($item['featured'] == '1')
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                                {{-- on_sale	 --}}
                                <tr>
                                    <th>On Sale</th>
                                    <td>
                                        @if ($item['on_sale'] == '1')
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                                {{-- free_delivery --}}
                                <tr>
                                    <th>Free Delivery</th>
                                    <td>
                                        @if ($item['free_delivery'] == '1')
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($item['status'] == 'published')
                                            <span class="badge badge-success">{{ $item['status'] }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $item['status'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @include('backend.pages.user.role_update')

@endsection

@section('addScript')
    <script>

    </script>
@endsection
