<!-- JAVASCRIPT FILES ========================================= -->
<script src="{{ asset('assets/frontend/js/jquery.min.js')}}"></script><!-- JQUERY MIN JS -->
<script src="{{ asset('assets/frontend/vendor/wow/wow.min.js')}}"></script><!-- WOW JS -->
<script src="{{ asset('assets/frontend/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script><!-- BOOTSTRAP MIN JS -->
<script src="{{ asset('assets/frontend/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script><!-- BOOTSTRAP SELECT MIN JS -->
<script src="{{ asset('assets/frontend/vendor/counter/waypoints-min.js')}}"></script><!-- WAYPOINTS JS -->
<script src="{{ asset('assets/frontend/vendor/counter/counterup.min.js')}}"></script><!-- COUNTERUP JS -->
<script src="{{ asset('assets/frontend/vendor/swiper/swiper-bundle.min.js')}}"></script><!-- SWIPER JS -->
<script src="{{ asset('assets/frontend/js/dz.carousel.js')}}"></script><!-- DZ CAROUSEL JS -->
<script src="{{ asset('assets/frontend/js/dz.ajax.js')}}"></script><!-- AJAX -->
<script src="{{ asset('assets/frontend/js/custom.js')}}"></script><!-- CUSTOM JS -->

<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

{{-- <script>
    const csrfToken = "{{ csrf_token() }}";
    const wishlistRoute = "{{ route('wishlist.store') }}";
    const cartItemsRoute = "{{ route('cart.get-cart-items') }}";
    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
</script> --}}

<script>

    @if (session('success') || session('error'))
        const message = "{{ session('success') ?? session('error') }}";
        const type = "{{ session('success') ? 'success' : 'error' }}";
        showToast(type, message);
    @endif

    function showToast(type, message) {
        // Ensure the type is valid
        const validTypes = ['success', 'error', 'info', 'warning'];
        if (!validTypes.includes(type)) {
            console.error(`Invalid toast type: ${type}`);
            return;
        }

        // Display the toast
        toastr[type](message);
    }

    // Optional: Customize Toastr settings (if needed)
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right", // Change position here
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.add-to-wishlist').forEach(button => {
            button.addEventListener('click', function () {
                const bookId = this.getAttribute('data-id');

                fetch('{{ route('wishlist.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ book_id: bookId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('success', data.message);
                        if (this.classList.contains('active')) {
                            this.classList.remove('active');
                        } else {
                            this.classList.add('active');
                        }
                    } else {
                        showToast('error', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });

        function addToWishListFunction(bookId) {
            fetch('{{ route('wishlist.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ book_id: bookId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('success', data.message);
                    if (this.classList.contains('active')) {
                        this.classList.remove('active');
                    } else {
                        this.classList.add('active');
                    }
                } else {
                    showToast('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Handle Add to Cart
        document.querySelectorAll('.add-to-cart').forEach(button => {
            $(button).on('click', function() {
                const bookId = $(this).data('id');
                const quantity = 1; // Default quantity, adjust as needed

                $.ajax({
                    url: '/cart/store',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        book_id: bookId,
                        quantity: quantity
                    }),
                    success: function(data) {
                        if (data.success) {
                            showToast('success', data.message);
                            getCartDetails(); // Update cart details in UI
                        } else {
                            showToast('error', data.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                        showToast('error', 'An error occurred while adding to cart.');
                    }
                });
            });
        });

        // Remove cart item
        $('.remove-cart-item').on('click', function() {
            let cartId = $(this).data('cart-id');
            // let user confirm before removing the item
            if (!confirm('Are you sure you want to remove this item from cart?')) {
                return false;
            }
            removeCartItem(cartId);
        });

        function removeCartItem(cartId) {
            console.log('Removing cart item:', cartId);
            $.ajax({
                url: "{{ route('remove-cart-item') }}", // Update this with your route to remove cart item
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cart_id: cartId
                },
                success: function(response) {
                    if (response.success) {
                        // Remove the item row from the table
                        $('tr[data-cart-id="' + cartId + '"]').remove();

                        // Update the cart summary
                        $('#order-subtotal').text('$' + response.cart_subtotal);
                        $('#order-total').text('$' + response.cart_total);

                        try {
                            $('item-close').closest('.cart-item').hide('500');

                        } catch (error) {
                            console.error('Error updating cart count:', error);
                        }

                        updatedCartSummary();

                        // Optionally, show a toast notification
                        showToast('success', 'Item removed from cart.');
                        getCartDetails();
                    } else {
                        showToast('error', 'Failed to remove the item from cart.');
                    }
                },
                error: function() {
                    showToast('error', 'An error occurred while removing the item.');
                }
            });
        }

        function updatedCartSummary() {
            console.log('Updating cart summary');
            let deliveryFee = parseFloat($('#deliveryFeeSelect option:selected').data('fee'));
            // Count all the prices from elements with class="product-item-total"
            let total = 0;
            $('.product-item-total').each(function() {
                total += parseFloat($(this).text().replace('£', ''));
            });

            // Update the total price
            $('#orderSubtotal').text('£' + total.toFixed(2));

            // Ensure deliveryFee is a valid number before performing addition
            if (!isNaN(deliveryFee)) {
                let orderTotal = total + deliveryFee;
                $('#orderTotal').text('£' + orderTotal.toFixed(2));
            } else {
                $('#orderTotal').text('£' + total.toFixed(2)); // Fallback if deliveryFee is NaN
            }
        }

        // Function to get and update cart details
        function getCartDetails() {
            fetch('{{ route('cart.get-cart-items') }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector('.cart-item-total').textContent = data.data.count;

                        // Check if .cart-item-total-price exists before updating its textContent
                        let totalPriceElement = document.querySelector('.cart-item-total-price');
                        if (totalPriceElement) {
                            totalPriceElement.textContent = 'Total = £' + data.data.totalPrice;
                        } else {
                            console.error('.cart-item-total-price element not found in the DOM');
                        }

                        // Prepare the cart items dropdown
                        let cartDropdown = document.querySelector('.cart-list');
                        cartDropdown.innerHTML = ''; // Clear existing items

                        if (data.data.items.length === 0) {
                            // Display no items message if cart is empty
                            cartDropdown.innerHTML = '<li class="cart-item text-center"><h6 class="text-secondary" style="font-weight: 400;">No items in cart</h6></li>';
                        } else {
                            // Loop through cart items and append them to the dropdown
                            data.data.items.slice(0, 3).forEach(item => {
                                let listItem = document.createElement('li');
                                listItem.classList.add('cart-item');

                                listItem.innerHTML = `
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="books-detail.html">
                                                <img alt="" class="media-object" src="${item.image}">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="dz-title"><a href="books-detail.html" class="media-heading">${item.title}</a></h6>
                                            <span class="dz-price">
                                                ${item.quantity} x £${item.price}
                                            </span>
                                            <span class="item-close remove-cart-item" data-cart-id="${item.cart_item_id}">&times;</span>
                                        </div>
                                    </div>
                                `;
                                cartDropdown.appendChild(listItem);

                                // Add event listener to the remove button
                                listItem.querySelector('.remove-cart-item').addEventListener('click', function() {
                                    let cartItemId = item.cart_item_id;
                                    removeCartItem(cartItemId); // Call function to remove the item from cart
                                });
                            });

                            // Display a message if there are more than 3 items
                            if (data.data.items.length > 3) {
                                let moreItems = data.data.count - 3;
                                let moreItemsElement = document.createElement('li');
                                moreItemsElement.classList.add('cart-item', 'text-center');
                                moreItemsElement.innerHTML = `<h6 class="text-secondary" style="font-weight: 400;">And ${moreItems} more items</h6>`;
                                cartDropdown.appendChild(moreItemsElement);
                            }

                            // Add the total price and action buttons
                            let totalPriceElement = document.createElement('li');
                            totalPriceElement.classList.add('cart-item', 'text-center', 'cart-item-total-price'); // Ensure cart-item-total-price class
                            totalPriceElement.innerHTML = `<h6 class="text-secondary">Total = £${data.data.totalPrice}</h6>`;
                            cartDropdown.appendChild(totalPriceElement);

                            let actionButtonsElement = document.createElement('li');
                            actionButtonsElement.classList.add('text-center', 'd-flex');
                            actionButtonsElement.innerHTML = `
                                <a href="cart" class="btn btn-sm btn-primary me-2 btnhover w-100">View Cart</a>
                                <a href="{{route('checkout.index')}}" class="btn btn-sm btn-outline-primary btnhover w-100">Checkout</a>
                            `;
                            cartDropdown.appendChild(actionButtonsElement);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Initialize cart details when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            getCartDetails();
        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');
        const searchResultsContainer = document.getElementById('search-results');
        let debounceTimer;

        // Debounce function to limit the number of times the search function is called
        function debounce(func, delay) {
            return function(...args) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func.apply(this, args), delay);
            };
        }

        // Function to perform the search
        function performSearch() {
            const query = searchInput.value.trim();

            if (query.length > 0) {
                // Make an AJAX request to the search route
                fetch(`/book/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        // Clear previous results
                        searchResultsContainer.innerHTML = '';
                        searchResultsContainer.style.display = 'block'; // Show results

                        if (data.success && data.data.length > 0) {
                            // Populate results
                            data.data.forEach(book => {
                                const bookElement = document.createElement('div');
                                bookElement.classList.add('search-result-item');

                                let priceDisplay = '';
                                if (book.discount_amount > 0) {
                                    if (book.discount_type === 'percentage') {
                                        priceDisplay = `<p>£${book.price_display}</p>`;
                                    } else {
                                        priceDisplay = `<p>£${book.price_display}</p>`;
                                    }
                                } else {
                                    priceDisplay = `<p>£${book.price_display}</p>`;
                                }

                                bookElement.innerHTML = `
                                    <a href="${book.url}">
                                        <img src="${book.image}" alt="${book.title}" />
                                        <h5>${book.title}</h5>
                                        <h6 class="float-right" style="color: #f91942; margin-left: 10px; font-size: 16px;">${priceDisplay}</h6>
                                    </a>
                                `;
                                searchResultsContainer.appendChild(bookElement);
                            });
                        } else {
                            // Show no results message
                            searchResultsContainer.innerHTML = '<p>No books found.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        searchResultsContainer.innerHTML = '<p>Error fetching results.</p>';
                    });
            } else {
                // Clear results if input is empty
                searchResultsContainer.innerHTML = '';
                searchResultsContainer.style.display = 'none'; // Hide results
            }
        }

        // Attach the debounced search function to input changes
        searchInput.addEventListener('input', debounce(performSearch, 300)); // Adjust debounce delay as needed (300ms here)

        // Hide search results when clicking outside
        document.addEventListener('click', function(event) {
            if (!searchResultsContainer.contains(event.target) && event.target !== searchInput) {
                searchResultsContainer.style.display = 'none';
            }
        });
    });
</script>


@yield('addScript')

