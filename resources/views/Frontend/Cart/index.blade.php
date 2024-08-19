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
                                    <tr data-cart-id="{{ $cart['cart_item_id'] }}">
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
                                                <input class="cart-quantity-input" id="cart-quantity-input" type="number" value="{{ $cart['quantity'] }}" name="demo_vertical2" data-cart-id="{{ $cart['cart_item_id'] }}" min="1" step="1"/>
                                            </div>
                                        </td>
                                        <td class="product-item-total">£{{ number_format($cart['total_price'], 2) }}</td>
                                        <td class="product-item-close"><a href="javascript:void(0);" class="ti-close remove-cart-item" data-cart-id="{{ $cart['cart_item_id'] }}" data-type="cartPage"></a></td>
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
                        <div class="shop-form">
                            <h4 class="widget-title">Calculate Shipping</h4>
                            <div class="form-group">
                                <select class="form-control" id="deliveryFeeSelect">
                                    @foreach ($data['DeliveryFees'] as $deliveryFee)

                                        @php
                                            if($data['cartList']['cart'] && $data['cartList']['cart']->delivery_fee_id != null){
                                                $deliveryFeeId = $data['cartList']['cart']->delivery_fee_id;
                                            }else{
                                                $deliveryFeeId = $data['DeliveryFees'][0]->id;
                                            }
                                        @endphp
                                        <option value="{{ $deliveryFee->id }}" @if($deliveryFee->id == $deliveryFeeId) selected @endif
                                            data-fee="{{ $deliveryFee->price }}">{{ $deliveryFee->name }} - £{{ $deliveryFee->price }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Coupon Code" id="couponCode" name="couponCode"
                                    @if(isset($data['cartList']['couponDiscount']) && $data['cartList']['couponDiscount'] > 0) disabled @endif>
                            </div>
                            <div class="form-group">

                                @if(isset($data['cartList']['couponDiscount']) && $data['cartList']['couponDiscount'] > 0)
                                    <button class="btn btn-primary btnhover" type="button" id="applyCoupon" style="display: none;">Apply Coupon</button>
                                    <button class="btn btn-secondary btnhover" type="button" id="removeCoupon">Remove Coupon</button>
                                @else
                                    <button class="btn btn-primary btnhover" type="button" id="applyCoupon">Apply Coupon</button>
                                    <button class="btn btn-secondary btnhover" type="button" id="removeCoupon" style="display: none;">Remove Coupon</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="widget">
                        <h4 class="widget-title">Cart Subtotal</h4>
                        <table class="table-bordered check-tbl mb-25">
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
                                    <td>Coupon Discount</td>
                                    <td id="couponDiscount">£{{ number_format($data['cartList']['couponDiscount'], 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td id="orderTotal">£{{ number_format($data['cartList']['totalPrice'], 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group mb-25 mt-3">
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btnhover" type="button">Proceed to Checkout</a>
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
            let cartItemId = $(this).data('cart-id'); // Updated here
            let newQuantity = $(this).val();
            let deliveryFee = $('#deliveryFeeSelect option:selected').data('fee');
            updateCartQuantity(cartItemId, newQuantity, deliveryFee); // Updated here
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

        // Handle shipping method change
        $('#deliveryFeeSelect').change(function() {
            var selectedOption = $(this).find(':selected');
            var shippingFee = parseFloat(selectedOption.data('fee')); // Parse as float
            var deliveryFeeId = selectedOption.val(); // Get selected delivery fee ID

            // Check if shippingFee is a number before proceeding
            if (!isNaN(shippingFee)) {
                // $('#shippingFee').text('£' + shippingFee.toFixed(2)); // Format with toFixed
                // $('#orderTotal').text('£' + (parseFloat($('#orderSubtotal').text().replace('£', '')) + shippingFee).toFixed(2)); // Update total amount

                // Update the delivery fee in the database
                updateDeliveryFee(deliveryFeeId, shippingFee);
            } else {
                $('#shippingFee').text('Unknown'); // Handle if shippingFee is not a number
            }
        });

        // Function to update the delivery fee
        function updateDeliveryFee(deliveryFeeId, deliveryFee) {
            $.ajax({
                url: "{{ route('update-delivery-fee') }}", // Update this with your route to update delivery fee
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    delivery_fee_id: deliveryFeeId, // Updated here
                    delivery_fee: deliveryFee
                },
                success: function(response) {
                if (response.success) {
                        $('#orderTotal').text('£' + parseFloat(response.cart_total).toFixed(2));
                        $('#shippingFee').text('£' + parseFloat(response.delivery_fee).toFixed(2));
                        showToast('success', response.message);
                    } else {
                        showToast('error', response.message);
                    }
                },
                error: function() {
                    showToast('error', 'An error occurred while updating the delivery fee.');
                }
            });
        }

        // Function to update cart quantity
        function updateCartQuantity(cartItemId, quantity, deliveryFee) { // Updated here
            $.ajax({
                url: "{{ route('update-cart') }}", // Update this with your route to update cart quantity
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cart_item_id: cartItemId, // Updated here
                    quantity: quantity,
                    delivery_fee: deliveryFee
                },
                success: function(response) {
                    if (response.success) {
                        // Update the total price for the item
                        let row = $('tr[data-cart-id="' + cartItemId + '"]'); // Updated here
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

        // Handle coupon application
        $('#applyCoupon').click(function() {
            let couponCode = $('#couponCode').val();
            let deliveryFee = parseFloat($('#deliveryFeeSelect option:selected').data('fee'));

            $.ajax({
                url: "{{ route('apply-coupon') }}", // Update this route as needed
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    couponCode: couponCode,
                    deliveryFee: deliveryFee
                },
                success: function(response) {
                    if (response.success) {
                        var totalPrice = parseFloat(response.totalPrice); // Convert response.totalPrice to a number
                        if (isNaN(totalPrice)) {
                            showToast('error', 'Invalid total price received.');
                            return;
                        }

                        $('#couponDiscount').text('£' + parseFloat(response.couponDiscount).toFixed(2));
                        $('#orderTotal').text('£' + totalPrice.toFixed(2));
                        $('#couponCode').val(''); // Clear the coupon code input
                        $('#couponCode').prop('disabled', true); // Disable the coupon code input
                        $('#applyCoupon').hide(); // Hide apply coupon button
                        $('#removeCoupon').show(); // Hide remove coupon button
                        showToast('success', response.message);
                    } else {
                        showToast('error', response.message);
                    }
                },
                error: function() {
                    showToast('error', 'An error occurred while applying the coupon.');
                }
            });
        });

        // Handle coupon removal
        $('#removeCoupon').click(function() {
            $.ajax({
                url: "{{ route('remove-coupon') }}", // Update this route as needed
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        var totalPrice = parseFloat(response.totalPrice); // Convert response.totalPrice to a number
                        if (isNaN(totalPrice)) {
                            showToast('error', 'Invalid total price received.');
                            return;
                        }

                        $('#couponDiscount').text('£' + parseFloat(response.couponDiscount).toFixed(2));
                        $('#orderTotal').text('£' + totalPrice.toFixed(2));
                        $('#couponCode').val(''); // Clear the coupon code input
                        $('#couponCode').prop('disabled', false); // Enable the coupon code input
                        $('#applyCoupon').show(); // Show apply coupon button
                        $('#removeCoupon').hide(); // Hide remove coupon button
                        showToast('success', response.message);
                    } else {
                        showToast('error', response.message);
                    }
                },
                error: function() {
                    showToast('error', 'An error occurred while removing the coupon.');
                }
            });
        });

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
