@extends('Frontend/Main/index')

@section('title', 'Cart')

@section('content')

<div class="page-content">
    <!-- inner page banner -->
    <div class="dz-bnr-inr overlay-secondary-dark dz-bnr-inr-sm" style="background-image:url({{ asset('assets/frontend/images/background/bg3.jpg') }});">
        <div class="container">
            <div class="dz-bnr-inr-entry">
                <h1>Cart</h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cart</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- inner page banner End-->

    <!-- contact area -->
    <section class="content-inner shop-account">
        <!-- Product -->
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table check-tbl">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Product name</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th class="text-end">Close</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['cartList']['items'] as $cart)
                                    <tr data-cart-id="{{ $cart['cart_id'] }}">
                                        <td class="product-item-img"><img src="{{ $cart['image'] }}" alt=""></td>
                                        <td class="product-item-name">{{ $cart['title'] }}</td>
                                        <td class="product-item-price">
                                            <span class="price">
                                                @if ($cart['discounted_price'])
                                                    £{{ $cart['discounted_price'] }}
                                                    <br>
                                                    <del style="color: red;">
                                                        £{{ $cart['sale_price'] }}
                                                    </del>
                                                @else
                                                    £{{ $cart['sale_price'] }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="product-item-quantity">
                                            <div class="quantity btn-quantity style-1 me-3">
												<input class="cart-quantity-input" id="cart-quantity-input" type="number" value="{{ $cart['quantity'] }}" name="demo_vertical2" data-cart-id="{{ $cart['cart_id'] }}" min="1" step="1"/>
											</div>
                                        </td>
                                        <td class="product-item-total">${{ $cart['total_price'] }}</td>
                                        <td class="product-item-close"><a href="javascript:void(0);" class="ti-close remove-cart-item" data-cart-id="{{ $cart['cart_id'] }}"></a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No items in cart</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Update Cart Summary -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="widget">
                        <form class="shop-form">
                            <h4 class="widget-title">Calculate Shipping</h4>
                            <div class="form-group">
                                <select class="default-select">
                                    <option selected>Shipping Method</option>
                                    <option value="1">Standard Shipping</option>
                                    <option value="2">Express Shipping</option>
                                    <option value="3">Overnight Shipping</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" class="form-control" placeholder="Postal Code">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" class="form-control" placeholder="Country">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Coupon Code">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btnhover" type="button">Apply Coupon</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="widget">
                        <h4 class="widget-title">Cart Subtotal</h4>
                        <table class="table-bordered check-tbl mb-25">
                            <tbody>
                                <tr>
                                    <td>Order Subtotal</td>
                                    <td id="order-subtotal">${{ $data['cartList']['totalPrice'] }}</td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>Free Shipping</td>
                                </tr>
                                <tr>
                                    <td>Coupon</td>
                                    <td>$0.00</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td id="order-total">${{ $data['cartList']['totalPrice'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group mb-25">
                            <a href="{{ url('shop-checkout') }}" class="btn btn-primary btnhover" type="button">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product END -->
    </section>
    <!-- contact area End-->

</div>

@endsection

@section('addScript')
<script src="{{ asset('assets/frontend/vendor/bootstrap-touchspin/bootstrap-touchspin.js') }}"></script>
<script src="{{ asset('assets/frontend/vendor/countdown/counter.js') }}"></script>
<script>
    $(document).ready(function() {
        // Handle quantity change
        $('.cart-quantity-input').on('change', function() {
            console.log('change');
            let cartId = $(this).data('cart-id');
            let newQuantity = $(this).val();
            updateCartQuantity(cartId, newQuantity);
        });

        // demo_vertical2
        $("input[name='demo_vertical2']").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus',
            min: 1,
            max: 100,
            step: 1,
            decimals: 0,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '',
        });

        // Function to update cart quantity
        function updateCartQuantity(cartId, quantity) {
            $.ajax({
                url: "{{ route('update-cart') }}", // Update this with your route to update cart quantity
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cart_id: cartId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        // Update the total price for the item
                        let row = $('tr[data-cart-id="' + cartId + '"]');
                        row.find('.product-item-total').text('$' + response.item_total_price);

                        // Update the cart summary
                        $('#order-subtotal').text('$' + response.cart_subtotal);
                        $('#order-total').text('$' + response.cart_total);

                        // Optionally, show a toast notification
                        showToast('success', 'Cart updated successfully!');
                    } else {
                        showToast('error', 'Failed to update the cart.');
                    }
                },
                error: function() {
                    showToast('error', 'An error occurred while updating the cart.');
                }
            });
        }

        // Function to show a toast notification
        function showToast(type, message) {
            toastr[type](message);
        }
    });
</script>
@endsection

@section('addStyle')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/icons/themify/themify-icons.css') }}">
@endsection
