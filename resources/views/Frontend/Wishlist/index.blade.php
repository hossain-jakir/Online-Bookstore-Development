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
                                @foreach ($data['wishlist'] as $wishlist)
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
                                        <td class="product-item-totle"><a href="shop-cart.html" class="btn btn-primary btnhover">Add To Cart</a></td>
                                        <td class="product-item-close" style="text-align: center;">
                                            <button type="button" class="btn btn-danger delete-wishlist-item" data-id="{{ $wishlist->id }}">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
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
                            alert(data.message);
                        } else {
                            alert('An error occurred while trying to delete the item.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
        });
    });
</script>
@endsection

@section('addStyle')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/icons/themify/themify-icons.css')}}">
@endsection
