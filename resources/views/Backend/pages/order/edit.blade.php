@extends('Backend.layouts.master')

@section('title', 'Edit Order - ' . $order->order_number)

@section('content')
<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Order</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.order.index') }}">Manage Orders</a></li>
                        <li class="breadcrumb-item active">Edit Order</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    @if ($errors->any() || session('error'))
        @include('Backend._partials.errorMsg')
    @endif

    @if (session('success'))
        @include('Backend._partials.successMsg')
    @endif

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Shipping Address -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-warning text-white" id="headingShippingAddress">
                            <h5 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseShippingAddress" aria-expanded="true" aria-controls="collapseShippingAddress">
                                    <strong>Shipping Address</strong>
                                </button>
                            </h5>
                        </div>
                        <div id="collapseShippingAddress" class="collapse show" aria-labelledby="headingShippingAddress">
                            <div class="card-body">
                                <form action="{{ route('backend.order.updateShippingAddress', ['id' => $order->id]) }}" method="POST" class="form-inline">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mb-2">
                                        <label for="first_name" class="sr-only">First Name</label>
                                        <input type="text" id="first_name" name="first_name" value="{{ $order->shippingAddress->first_name }}" class="form-control form-control-sm" placeholder="First Name">
                                    </div>
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="last_name" class="sr-only">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" value="{{ $order->shippingAddress->last_name }}" class="form-control form-control-sm" placeholder="Last Name">
                                    </div>
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="address_line_1" class="sr-only">Address Line 1</label>
                                        <input type="text" id="address_line_1" name="address_line_1" value="{{ $order->shippingAddress->address_line_1 }}" class="form-control form-control-sm" placeholder="Address Line 1">
                                    </div>
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="address_line_2" class="sr-only">Address Line 2</label>
                                        <input type="text" id="address_line_2" name="address_line_2" value="{{ $order->shippingAddress->address_line_2 }}" class="form-control form-control-sm" placeholder="Address Line 2">
                                    </div>
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="city" class="sr-only">City</label>
                                        <input type="text" id="city" name="city" value="{{ $order->shippingAddress->city }}" class="form-control form-control-sm" placeholder="City">
                                    </div>
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="state" class="sr-only">State</label>
                                        <input type="text" id="state" name="state" value="{{ $order->shippingAddress->state }}" class="form-control form-control-sm" placeholder="State">
                                    </div>
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="country_id" class="sr-only">Country</label>
                                        <select id="country_id" name="country_id" class="form-control form-control-sm">
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ $order->shippingAddress->country_id == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="zip_code" class="sr-only">Zip Code</label>
                                        <input type="text" id="zip_code" name="zip_code" value="{{ $order->shippingAddress->zip_code }}" class="form-control form-control-sm" placeholder="Zip Code">
                                    </div>
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="phone_number" class="sr-only">Phone Number</label>
                                        <input type="text" id="phone_number" name="phone_number" value="{{ $order->shippingAddress->phone_number }}" class="form-control form-control-sm" placeholder="Phone Number">
                                    </div>
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="email" class="sr-only">Email</label>
                                        <input type="email" id="email" name="email" value="{{ $order->shippingAddress->email }}" class="form-control form-control-sm" placeholder="Email">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm mb-2">Update Address</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Management -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <strong>Order Items</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="orderItemsTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Image</th>
                                        <th>Book Title</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="orderItemsBody">
                                    <!-- Existing items will be inserted here by JavaScript -->
                                </tbody>
                            </table>

                            <button type="button" class="btn btn-primary mt-3" id="addItemBtn" style="width: -webkit-fill-available;">Add Item</button>

                            <!-- Price Breakdown Section -->
                            <div class="card mt-3">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Price Breakdown</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <p class="mb-1 font-weight-bold">Total Amount</p>
                                            <p id="total_amount" class="mb-0">£0.00</p>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <p class="mb-1 font-weight-bold">Discount Amount</p>
                                            <input type="number" id="discount_amount_input" name="discount_amount" value="0.00" class="form-control" step="1" min="0" max="999999">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <p class="mb-1 font-weight-bold">Coupon Amount</p>
                                            <p id="coupon_amount" class="mb-0">£0.00</p>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <p class="mb-1 font-weight-bold">Tax Amount</p>
                                            <p id="tax_amount_input" class="mb-0">£0.00</p>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <p class="mb-1 font-weight-bold">Shipping Amount</p>
                                            <p id="shipping_amount">£0.00</p>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <p class="mb-1 font-weight-bold">Grand Total</p>
                                            <p id="grand_total" class="mb-0">£0.00</p>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <p class="mb-1 font-weight-bold">Paid Amount</p>
                                            <p id="paid_amount">£0.00</p>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <p class="mb-1 font-weight-bold">Due Amount</p>
                                            <p id="due_amount">£0.00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @can('edit order')
                            <button type="submit" class="btn btn-success" id="submitOrderBtn" style="width: -webkit-fill-available;">Update Items</button>
                            @endcan
                        </div>
                    </div>

                    <!-- Delivery Method -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <strong>Delivery Method</strong>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('backend.order.updateDeliveryFee', ['id' => $order->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="delivery_fee">Delivery Fee</label>
                                    <select id="delivery_fee" name="delivery_fee" class="form-control">
                                        @foreach($deliveryFees as $fee)
                                            <option value="{{ $fee->id }}" {{ $order->delivery_method_id == $fee->id ? 'selected' : '' }}>
                                                {{ $fee->name }} - £{{ number_format($fee->price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Delivery Fee</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Add Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="bookSelect">Select Book</label>
                    <select id="bookSelect" class="form-control">
                        <option value="">Select a book</option>
                        <!-- Options will be dynamically populated -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="bookQuantity">Quantity</label>
                    <input type="number" id="bookQuantity" class="form-control" min="1" value="1">
                </div>
                <div class="form-group">
                    <label for="bookPrice">Price</label>
                    <input type="number" id="bookPrice" class="form-control" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="addBookToOrderBtn" class="btn btn-primary">Add to Order</button>
            </div>
        </div>
    </div>
</div>

<!-- /.content-wrapper -->
@endsection

@section('page-script')
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Popper.js (needed for Bootstrap 4) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function() {
    // Initialize order data
    let orderData = {
        items: [],
        total_amount: parseFloat("{{ $order->total_amount }}"),
        discount_amount: parseFloat("{{ $order->discount_amount }}"),
        coupon_amount: parseFloat("{{ $order->coupon_amount }}"),
        tax_amount: parseFloat("{{ $order->tax_amount }}"),
        shipping_amount: parseFloat("{{ $order->shipping_amount }}"),
        grand_total: parseFloat("{{ $order->grand_total }}"),
        paid_amount: parseFloat("{{ $order->paid_amount }}"),
        due_amount: parseFloat("{{ $order->due_amount }}"),
    };

    console.log('Initial order data:', orderData);

    // Populate order data items from backend
    @foreach($order->orderItems as $item)
        orderData.items.push({
            id: {{ $item->id }},
            book_id: {{ $item->book_id }},
            book_title: "{{ $item->book->title }}",
            quantity: {{ $item->quantity }},
            price: {{ $item->price }},
            total: {{ $item->total }},
            image: "{{ $item->book->image }}"
        });
    @endforeach

    function renderOrderItems() {
        console.log('Rendering order items:', orderData.items);
        const tbody = document.getElementById('orderItemsBody');
        tbody.innerHTML = ''; // Clear existing rows

        orderData.items.forEach(item => {
            const row = tbody.insertRow();
            row.innerHTML = `
                <td><img src="${item.image}" alt="${item.book_title}" style="width: 60px; height: auto;"></td>
                <td>${item.book_title}</td>
                <td><input type="number" name="items[${item.id}][quantity]" value="${item.quantity}" class="form-control" min="1"></td>
                <td>£${item.price.toFixed(2)}</td>
                <td>£${item.total.toFixed(2)}</td>
                <td>
                    <input type="hidden" name="items[${item.id}][book_id]" value="${item.book_id}">
                    <button type="button" class="btn btn-danger btn-sm remove-item" data-id="${item.id}">Remove</button>
                </td>
            `;
        });

        updatePriceBreakdown(); // Update the price breakdown after rendering items
    }

    function updateOrderItems() {
        console.log('Updating order items...', orderData.items);
        const rows = document.querySelectorAll('#orderItemsTable tbody tr');
        orderData.items = Array.from(rows).map(row => {
            const quantity = parseFloat(row.querySelector('input[name$="[quantity]"]').value) || 0;
            const price = parseFloat(row.querySelector('td:nth-child(4)').textContent.replace('£', '')) || 0;
            const total = quantity * price;
            return {
                id: row.querySelector('button.remove-item').dataset.id,
                book_id: row.querySelector('input[name$="[book_id]"]').value, // Ensure book_id is set
                book_title: row.querySelector('td:nth-child(2)').textContent,
                quantity: quantity,
                price: price,
                total: total,
                image: row.querySelector('img').src
            };
        });
        updatePriceBreakdown(); // Update price breakdown after updating items
    }

    function updatePriceBreakdown() {
        orderData.total_amount = orderData.items.reduce((sum, item) => sum + item.total, 0);
        orderData.grand_total = orderData.total_amount - orderData.discount_amount - orderData.coupon_amount + orderData.tax_amount + orderData.shipping_amount;
        orderData.due_amount = orderData.grand_total - orderData.paid_amount;

        document.getElementById('total_amount').textContent = `£${orderData.total_amount.toFixed(2)}`;
        document.getElementById('coupon_amount').textContent = `£${orderData.coupon_amount.toFixed(2)}`;
        document.getElementById('discount_amount_input').value = orderData.discount_amount.toFixed(2);
        document.getElementById('tax_amount_input').value = orderData.tax_amount.toFixed(2);
        document.getElementById('shipping_amount').textContent = `£${orderData.shipping_amount.toFixed(2)}`;
        document.getElementById('grand_total').textContent = `£${orderData.grand_total.toFixed(2)}`;
        document.getElementById('paid_amount').textContent = `£${orderData.paid_amount.toFixed(2)}`;
        document.getElementById('due_amount').textContent = `£${orderData.due_amount.toFixed(2)}`;
    }

    document.getElementById('addItemBtn').addEventListener('click', function() {
        $('#addItemModal').modal('show');
        fetchBooks();
    });

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-item')) {
            const id = event.target.dataset.id;
            orderData.items = orderData.items.filter(item => item.id != id);
            renderOrderItems();
        }
    });

    document.getElementById('orderItemsBody').addEventListener('change', function(event) {
        if (event.target.name.includes('quantity')) {
            updateOrderItems();
            renderOrderItems();
        }
    });

    function fetchBooks() {
        fetch("{{ route('backend.book.list') }}")
            .then(response => response.json())
            .then(books => {
                const bookSelect = document.getElementById('bookSelect');
                bookSelect.innerHTML = '<option value="">Select a book</option>';

                books.forEach(book => {
                    const option = document.createElement('option');
                    option.value = book.id;
                    option.setAttribute('data-price', book.sale_price);
                    option.setAttribute('data-image', book.image);
                    option.textContent = book.title;
                    bookSelect.appendChild(option);
                });

                bookSelect.addEventListener('change', function() {
                    const selectedOption = bookSelect.options[bookSelect.selectedIndex];
                    const priceInput = document.getElementById('bookPrice');
                    priceInput.value = selectedOption.getAttribute('data-price');
                });
            })
            .catch(error => console.error('Error fetching books:', error));
    }

    document.getElementById('addBookToOrderBtn').addEventListener('click', function() {
        const bookSelect = document.getElementById('bookSelect');
        const bookQuantity = document.getElementById('bookQuantity').value;
        const bookPrice = document.getElementById('bookPrice').value;

        if (bookSelect.value === '' || bookQuantity <= 0) {
            alert('Please select a valid book and quantity.');
            return;
        }

        const selectedOption = bookSelect.options[bookSelect.selectedIndex];
        const total = bookQuantity * bookPrice;

        const newItem = {
            id: 'new_' + Math.random().toString(36).substr(2, 9),
            book_id: selectedOption.value, // Ensure book_id is set
            book_title: selectedOption.textContent,
            quantity: parseFloat(bookQuantity),
            price: parseFloat(bookPrice),
            total: total,
            image: selectedOption.getAttribute('data-image')
        };

        console.log('Adding new item:', newItem);

        orderData.items.push(newItem);
        renderOrderItems();
        $('#addItemModal').modal('hide');
    });

    document.getElementById('discount_amount_input').addEventListener('input', function() {
        orderData.discount_amount = parseFloat(this.value) || 0;
        updatePriceBreakdown();
    });

    function submitOrder() {
        orderData.items = gatherOrderData(); // Ensure the latest items data is included

        fetch('{{ route("backend.order.update", ["id" => $order->id]) }}', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(orderData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Handle success (e.g., show a success message or redirect)
                alert('Order updated successfully!');
            } else {
                // Handle error (e.g., show an error message)
                alert('Error updating order. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating order. Please try again.');
        });
    }

    function gatherOrderData() {
        const rows = document.querySelectorAll('#orderItemsTable tbody tr');
        const items = Array.from(rows).map(row => {
            const id = row.querySelector('button.remove-item').dataset.id;
            const quantity = parseFloat(row.querySelector('input[name$="[quantity]"]').value) || 0;
            const price = parseFloat(row.querySelector('td:nth-child(4)').textContent.replace('£', '')) || 0;
            const bookId = row.querySelector('input[name$="[book_id]"]').value; // Ensure this input exists

            const total = quantity * price;
            return {
                id: id,
                book_id: bookId, // Ensure book_id is included
                quantity: quantity,
                price: price,
                total: total
            };
        });
        return items;
    }


    document.getElementById('submitOrderBtn').addEventListener('click', function() {
        submitOrder();
    });

    renderOrderItems();
});

</script>

@endsection

