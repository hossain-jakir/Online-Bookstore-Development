@extends('Frontend/Main/index')

@section('title', 'About Us')

@section('content')

<div class="page-content">

    <!-- inner page banner -->
    <div class="dz-bnr-inr overlay-secondary-dark dz-bnr-inr-sm" style="background-image:url({{ asset('assets/frontend/images//background/bg3.jpg')}});">
        <div class="container">
            <div class="dz-bnr-inr-entry">
                <h1>Wishlist</h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"> Home</a></li>
                        <li class="breadcrumb-item">Wishlist</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- inner page banner End-->

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
                                    <th>Quantity</th>
                                    <th>Add to cart </th>
                                    <th>Close</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="product-item-img"><img src="{{ asset('assets/frontend/images//books/grid/book6.jpg')}}" alt=""></td>
                                    <td class="product-item-name">Prduct Item 6</td>
                                    <td class="product-item-price">$28.00</td>
                                    <td class="product-item-quantity">
                                        <div class="quantity btn-quantity style-1 me-3">
                                            <input id="demo_vertical7" type="text" value="1" name="demo_vertical2"/>
                                        </div>
                                    </td>
                                    <td class="product-item-totle"><a href="shop-cart.html" class="btn btn-primary btnhover">Add To Cart</a></td>
                                    <td class="product-item-close"><a href="javascript:void(0);" class="ti-close"></a></td>
                                </tr>
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
@endsection
