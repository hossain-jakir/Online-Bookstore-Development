@extends('Frontend/Main/index')

@section('title', 'Checkout')

@section('content')

<div class="page-content">
    <!-- inner page banner -->
    <div class="dz-bnr-inr overlay-secondary-dark dz-bnr-inr-sm" style="background-image:url({{ asset('assets/frontend/images/background/bg3.jpg') }});">
        <div class="container">
            <div class="dz-bnr-inr-entry">
                <h1>Checkout</h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
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
            <form class="shop-form">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="widget">
                            <h4 class="widget-title">Billing & Shipping Address</h4>
                            <div class="form-group">
                                <select class="default-select">
                                    @foreach ($data['Countries'] as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="First Name" value="{{ auth()->user()->first_name ?? '' }}" required name="first_name">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="Last Name" value="{{ auth()->user()->last_name ?? '' }}" required name="last_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Address" value="{{ isset($address) ? $address->address_line_1 : ''  }}" name="address_line_1">
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="Apartment, suite, unit etc."  value="{{ isset($address) ? $address->address_line_2 : '' }}" name="address_line_2">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="Town / City" value="{{ isset($address) ? $address->city : '' }}" name="city">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="State / County" value="{{ isset($address) ? $address->state : '' }}" name="state">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="Postcode / Zip" value="{{ isset($address) ? $address->zip_code : '' }}" name="zip_code">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="email" class="form-control" placeholder="Email" value="{{ auth()->user()->email ?? '' }}" required name="email">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="Phone" value="{{ auth()->user()->phone ?? '' }}" required name="phone">
                                </div>
                            </div>
                            @if (!auth()->user())
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <button class="btn btn-primary btnhover mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#different-address">Ship to a different address <i class="fa fa-arrow-circle-o-down"></i></button>
                        <div id="different-address" class="collapse">
                            <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new customer please proceed to the Billing & Shipping section.</p>
                            <div class="form-group">
                                <select class="default-select">
                                    @foreach ($data['Countries'] as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="First Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Company Name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Address">
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="Apartment, suite, unit etc.">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="Town / City">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="State / County">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="Postcode / Zip">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="Phone">
                                </div>
                            </div>
                            <p>Create an account by entering the information below. If you are a returning customer please login at the top of the page.</p>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                        </div>

                    </div>
                </div>
            </form>
            <div class="dz-divider bg-gray-dark text-gray-dark icon-center  my-5"><i class="fa fa-circle bg-white text-gray-dark"></i></div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="widget">
                        <h4 class="widget-title">Your Order</h4>
                        <table class="table-bordered check-tbl">
                            <thead class="text-center">
                                <tr>
                                    <th>IMAGE</th>
                                    <th>PRODUCT NAME</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['cartList']['items'] as $cart)
                                <tr>
                                    <td class="product-item-img"><img src="{{ $cart['image'] }}" alt="{{ $cart['title'] }}"></td>
                                    <td class="product-item-name">{{ $cart['title'] }}</td>
                                    <td class="product-price">
                                        @if ($cart['discounted_price'])
                                            £{{ $cart['discounted_price'] }}
                                            <br>
                                            <del style="color: red;">
                                                £{{ $cart['sale_price'] }}
                                            </del>
                                        @else
                                            £{{ $cart['sale_price'] }}
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">No items in cart</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form class="shop-form widget">
                        <h4 class="widget-title">Order Total</h4>
                        <table class="table-bordered check-tbl mb-4">
                            <tbody>
                                <tr>
                                    <td>Order Subtotal</td>
                                    <td class="product-price">$125.96</td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>Free Shipping</td>
                                </tr>
                                <tr>
                                    <td>Coupon</td>
                                    <td class="product-price">$28.00</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td class="product-price-total">$506.00</td>
                                </tr>
                            </tbody>
                        </table>
                        <h4 class="widget-title">Payment Method</h4>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Name on Card">
                        </div>
                        <div class="form-group">
                            <select class="default-select">
                                <option value="">Credit Card Type</option>
                                <option value="">Another option</option>
                                <option value="">A option</option>
                                <option value="">Potato</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Credit Card Number">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Card Verification Number">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btnhover" type="button">Place Order Now </button>
                        </div>
                    </form>
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
            let cartId = $(this).data('cart-id');
            let newQuantity = $(this).val();
            let deliveryFee = $('#deliveryFeeSelect option:selected').data('fee');
            updateCartQuantity(cartId, newQuantity, deliveryFee);
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

        $('#deliveryFeeSelect').change(function() {
            var selectedOption = $(this).find(':selected');
            var shippingFee = parseFloat(selectedOption.data('fee')); // Parse as float

            // Check if shippingFee is a number before proceeding
            if (!isNaN(shippingFee)) {
                $('#shippingFee').text('£' + shippingFee.toFixed(2)); // Format with toFixed
                $('#orderTotal').text('£' + (parseFloat($('#orderSubtotal').text().replace('£', '')) + shippingFee).toFixed(2)); // Update total amount
            } else {
                $('#shippingFee').text('Unknown'); // Handle if shippingFee is not a number
            }

        });

        // Function to update cart quantity
        function updateCartQuantity(cartId, quantity, deliveryFee) {
            $.ajax({
                url: "{{ route('update-cart') }}", // Update this with your route to update cart quantity
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cart_id: cartId,
                    quantity: quantity,
                    delivery_fee: deliveryFee
                },
                success: function(response) {
                    if (response.success) {
                        // Update the total price for the item
                        let row = $('tr[data-cart-id="' + cartId + '"]');
                        row.find('.product-item-total').text('£' + response.item_total_price);

                        // Update the cart summary
                        $('#orderSubtotal').text('£' + response.cart_subtotal);
                        $('#orderTotal').text('£' + response.cart_total);
                        $('#shippingFee').text('£' + response.delivery_fee);

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
