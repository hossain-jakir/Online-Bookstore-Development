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
        <form action="{{ route('checkout.process')}}" method="POST">
            @csrf
            <div class="container">
                <div class="shop-form">
                    <!-- Address Form -->
                    <div class="row">
                        <!-- Billing & Shipping Address Form -->
                        <div class="col-lg-6 col-md-6">
                            <div class="widget">
                                <h4 class="widget-title">Shipping Address</h4>

                                @if (!auth()->user())
                                    <div class="form-group">
                                        {{-- Login and Register buttons --}}
                                        <a href="{{ route('login') }}" class="btn btn-primary btnhover mb-3">Login</a>
                                        <a href="{{ route('register') }}" class="btn btn-primary btnhover mb-3">Register</a>

                                    </div>

                                    <div class="form-group">
                                        <select class="default-select" name="country_id">
                                            @foreach ($data['Countries'] as $country)
                                                <option value="{{ $country->id }}"
                                                    @if(old('country_id') == $country->id)
                                                        selected
                                                    @endif
                                                >
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Address" name="address_line_1" value="{{ old('address_line_1') }}" required>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" placeholder="Apartment, suite, unit etc." name="address_line_2" value="{{ old('address_line_2') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" placeholder="Town / City" name="city" value="{{ old('city') }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" placeholder="State / County" name="state" value="{{ old('state') }}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" placeholder="Postcode / Zip" name="zip_code" value="{{ old('zip_code') }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" placeholder="Phone" required name="phone" value="{{ old('phone') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Email" name="email" required value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                                        </div>
                                    </div>
                                @else
                                <h5>Select a Shipping Address</h5>
                                @forelse ($data['addresses'] as $address)
                                    <div class="form-group mb-3">
                                        <input type="radio" id="address{{ $address->id }}" name="address_id" value="{{ $address->id }}"
                                            @if($address->is_default == 1 || count($data['addresses']) == 1)
                                                checked
                                            @endif
                                        >
                                        <label for="address{{ $address->id }}">
                                            {{ $address->address_line_1 }}, {{ $address->city }}, {{ $address->state }}, {{ $address->zip_code }}
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary btnhover" onclick="location.href='{{ route('profile.address') }}'">Add New Address</button>
                                    </div>
                                @empty
                                    <div class="form-group mb-3">
                                        <p>No address found. Please add a new address.</p>
                                    </div>
                                    <div class="form-group">
                                        <select class="default-select" name="country_id">
                                            @foreach ($data['Countries'] as $country)
                                                <option value="{{ $country->id }}"
                                                    @if(old('country_id') == $country->id)
                                                        selected
                                                    @endif
                                                >
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Address" name="address_line_1" value="{{ old('address_line_1') }}" required>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" placeholder="Apartment, suite, unit etc." name="address_line_2" value="{{ old('address_line_2') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" placeholder="Town / City" name="city" value="{{ old('city') }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" placeholder="State / County" name="state" value="{{ old('state') }}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" placeholder="Postcode / Zip" name="zip_code" value="{{ old('zip_code') }}" required>
                                        </div>
                                    </div>
                                @endforelse


                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">

                        </div>
                    </div>
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
                                        <th>PRICE</th>
                                        <th>QUANTITY</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data['cartList']['items'] as $cart)

                                    <tr>
                                        <td class="product-item-img"><img src="{{ $cart['image'] }}" alt="{{ $cart['title'] }}"></td>
                                        <td class="product-item-name">{{ $cart['title'] }}</td>
                                        <td class="product-price">
                                            £{{ $cart['price'] }}
                                        </td>
                                        <td class="product-quantity text-center">
                                            {{ $cart['quantity'] }}
                                        </td>
                                        <td class="product-item-total">£{{ number_format($cart['total_price'], 2) }}</td>

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
                        <h4 class="widget-title">Order Total</h4>
                        <table class="table-bordered check-tbl mb-4">
                            <tbody>
                                <tr>
                                    <td>Order Subtotal</td>
                                    <td id="orderSubtotal">£{{ number_format($data['cartList']['subTotalPrice'], 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td id="shippingFee">£{{ number_format($data['cartList']['deliveryFee'],2) }}</td>
                                </tr>
                                <tr>
                                    <td>Coupon</td>
                                    <td id="couponDiscount">£{{ number_format($data['cartList']['couponDiscount'], 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Tax ({{ $data['cartList']['tax'] }}%)</td>
                                    <td id="taxAmount">£{{ number_format($data['cartList']['taxAmount'], 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td id="orderTotal">£{{ number_format($data['cartList']['totalPrice'], 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="amount" value="{{ $data['cartList']['totalPrice'] }}">
                        <button type="submit" class="btn btn-primary">
                            Place Order <i class="ti-arrow-right"></i>
                        </button>
                        <div id="paypal-button-container mt-3">
                            <img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png" border="0" alt="PayPal Logo">
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
