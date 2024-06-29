@extends('Frontend/Main/index')

@section('title', 'Wishlist')

@section('content')
<div class="page-content">
    <!-- inner page banner -->
    <div class="dz-bnr-inr overlay-secondary-dark dz-bnr-inr-sm" style="background-image:url({{ asset('assets/frontend/images//background/bg3.jpg')}});">
        <div class="container">
            <div class="dz-bnr-inr-entry">
                <h1>Wishlist</h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Wishlist</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- inner page banner End -->

    <div class="content-inner-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table check-tbl">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Product name</th>
                                    <th>Unit Price</th>
                                    <th>Add to cart</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse  ($data['wishlist'] as $wishlist)
                                    <tr id="wishlist-item-{{ $wishlist->id }}">
                                        <td class="product-item-img"><img src="{{ $wishlist->book->image }}" alt=""></td>
                                        <td class="product-item-name">{{ $wishlist->book->title }}</td>
                                        <td class="product-item-price">
                                            @if ($wishlist->book->discounted_price)
                                                £{{ $wishlist->book->discounted_price }}
                                                <br>
                                                <del style="color: red;">
                                                    £{{ $wishlist->book->sale_price }}
                                                </del>
                                            @else
                                                £{{ $wishlist->book->sale_price }}
                                            @endif
                                        </td>
                                        <td class="product-item-totle">
                                            <button class="btn btn-primary btnhover add-to-cart" data-id="{{ base64_encode($wishlist->book->id) }}">Add To Cart</button>
                                        </td>
                                        <td class="product-item-close" style="text-align: center;">
                                            <button type="button" class="btn btn-danger delete-wishlist-item" data-id="{{ $wishlist->id }}">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center;">No items found in wishlist.</td>
                                    </tr>
                                @endforelse
                                @if ($data['wishlist']->count() > 0)
                                    <tr>
                                        <td colspan="5" style="text-align: right;">
                                            {{-- delete all button at right side--}}
                                            <form action="{{ route('wishlist.delete.all') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">
                                                    Delete All
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('addScript')
<script src="{{ asset('assets/frontend/vendor/bootstrap-touchspin/bootstrap-touchspin.js')}}"></script>
<script src="{{ asset('assets/frontend/vendor/countdown/counter.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Delete Wishlist Item
        document.querySelectorAll('.delete-wishlist-item').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this item?')) {
                    fetch(`/wishlist/delete/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`wishlist-item-${itemId}`).remove();
                            showToast('success', 'Item deleted successfully.');
                        } else {
                            showToast('error', 'Failed to delete item.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
        });
    });

    function showToast(type, message) {
        // Show toast message (using a library like toastr)
        if (type === 'success') {
            toastr.success(message);
        } else if (type === 'error') {
            toastr.error(message);
        }
    }
</script>
@endsection

@section('addStyle')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/icons/themify/themify-icons.css')}}">
@endsection
