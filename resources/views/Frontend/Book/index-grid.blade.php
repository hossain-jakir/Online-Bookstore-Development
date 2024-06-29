@extends('Frontend/Main/index')

@section('title', 'Books')

@section('content')

<div class="page-content bg-grey">
    <div class="content-inner border-bottom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="title">Books</h4>
            </div>
            <div class="filter-area m-b30">
                <div class="grid-area">
                    <div class="shop-tab">
                        <ul class="nav text-center product-filter justify-content-end" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('book.list') }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 5H21C21.2652 5 21.5196 4.89464 21.7071 4.7071C21.8946 4.51957 22 4.26521 22 4C22 3.73478 21.8946 3.48043 21.7071 3.29289C21.5196 3.10536 21.2652 3 21 3H3C2.73478 3 2.48043 3.10536 2.29289 3.29289C2.10536 3.48043 2 3.73478 2 4C2 4.26521 2.10536 4.51957 2.29289 4.7071C2.48043 4.89464 2.73478 5 3 5Z" fill="#AAAAAA"></path>
                                    <path d="M3 13H21C21.2652 13 21.5196 12.8947 21.7071 12.7071C21.8946 12.5196 22 12.2652 22 12C22 11.7348 21.8946 11.4804 21.7071 11.2929C21.5196 11.1054 21.2652 11 21 11H3C2.73478 11 2.48043 11.1054 2.29289 11.2929C2.10536 11.4804 2 11.7348 2 12C2 12.2652 2.10536 12.5196 2.29289 12.7071C2.48043 12.8947 2.73478 13 3 13Z" fill="#AAAAAA"></path>
                                    <path d="M3 21H21C21.2652 21 21.5196 20.8947 21.7071 20.7071C21.8946 20.5196 22 20.2652 22 20C22 19.7348 21.8946 19.4804 21.7071 19.2929C21.5196 19.1054 21.2652 19 21 19H3C2.73478 19 2.48043 19.1054 2.29289 19.2929C2.10536 19.4804 2 19.7348 2 20C2 20.2652 2.10536 20.5196 2.29289 20.7071C2.48043 20.8947 2.73478 21 3 21Z" fill="#AAAAAA"></path>
                                    </svg>
                                </a>
                            </li>
                            @if (!Route::currentRouteName() == 'book.grid')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('book.grid') }}">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 11H10C10.2652 11 10.5196 10.8946 10.7071 10.7071C10.8946 10.5196 11 10.2652 11 10V3C11 2.73478 10.8946 2.48043 10.7071 2.29289C10.5196 2.10536 10.2652 2 10 2H3C2.73478 2 2.48043 2.10536 2.29289 2.29289C2.10536 2.48043 2 2.73478 2 3V10C2 10.2652 2.10536 10.5196 2.29289 10.7071C2.48043 10.8946 2.73478 11 3 11ZM4 4H9V9H4V4Z" fill="#AAAAAA"></path>
                                        <path d="M14 11H21C21.2652 11 21.5196 10.8946 21.7071 10.7071C21.8946 10.5196 22 10.2652 22 10V3C22 2.73478 21.8946 2.48043 21.7071 2.29289C21.5196 2.10536 21.2652 2 21 2H14C13.7348 2 13.4804 2.10536 13.2929 2.29289C13.1054 2.48043 13 2.73478 13 3V10C13 10.2652 13.1054 10.5196 13.2929 10.7071C13.4804 10.8946 13.7348 11 14 11ZM15 4H20V9H15V4Z" fill="#AAAAAA"></path>
                                        <path d="M3 22H10C10.2652 22 10.5196 21.8946 10.7071 21.7071C10.8946 21.5196 11 21.2652 11 21V14C11 13.7348 10.8946 13.4804 10.7071 13.2929C10.5196 13.1054 10.2652 13 10 13H3C2.73478 13 2.48043 13.1054 2.29289 13.2929C2.10536 13.4804 2 13.7348 2 14V21C2 21.2652 2.10536 21.5196 2.29289 21.7071C2.48043 21.8946 2.73478 22 3 22ZM4 15H9V20H4V15Z" fill="#AAAAAA"></path>
                                        <path d="M14 22H21C21.2652 22 21.5196 21.8946 21.7071 21.7071C21.8946 21.5196 22 21.2652 22 21V14C22 13.7348 21.8946 13.4804 21.7071 13.2929C21.5196 13.1054 21.2652 13 21 13H14C13.7348 13 13.4804 13.1054 13.2929 13.2929C13.1054 13.4804 13 13.7348 13 14V21C13 21.2652 13.1054 21.5196 13.2929 21.7071C13.4804 21.8946 13.7348 22 14 22ZM15 15H20V20H15V15Z" fill="#AAAAAA"></path>
                                        </svg>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('book.index') }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 22H21C21.2652 22 21.5196 21.8946 21.7071 21.7071C21.8946 21.5196 22 21.2652 22 21V3C22 2.73478 21.8946 2.48043 21.7071 2.29289C21.5196 2.10536 21.2652 2 21 2H3C2.73478 2 2.48043 2.10536 2.29289 2.29289C2.10536 2.48043 2 2.73478 2 3V21C2 21.2652 2.10536 21.5196 2.29289 21.7071C2.48043 21.8946 2.73478 22 3 22ZM13 4H20V11H13V4ZM13 13H20V20H13V13ZM4 4H11V20H4V4Z" fill="#AAAAAA"></path>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="category">
                    <div class="form-group">
                        <i class="fas fa-sort-amount-down me-2 text-secondary"></i>
                        <select class="default-select">
                            <option>Newest</option>
                            <option>1 Day</option>
                            <option>1 Week</option>
                            <option>3 Weeks</option>
                            <option>1 Month</option>
                            <option>3 Months</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row book-grid-row">
                {{-- Books data will be rendered here --}}
            </div>
            <div class="row page mt-0">
                <div class="col-md-6">
                    <p class="page-text">Showing 12 from 50 data</p>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Blog Pagination">
                        <ul class="pagination style-1 p-t20">
                            <!-- Pagination links will be dynamically generated here -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Box -->
    @include('Frontend.Main.HappyCustomer.happyCustomer')
    <!-- Feature Box End -->

    <!-- Newsletter -->
    @include('Frontend.Main.Newsletter.newsLetter')
    <!-- Newsletter End -->

</div>

@endsection

@section('addStyle')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/nouislider/nouislider.min.css')}}">
@endsection

@section('addScript')
<script src="{{ asset('assets/frontend/vendor/countdown/counter.js')}}"></script><!-- CUSTOM JS -->
<script src="{{ asset('assets/frontend/vendor/wnumb/wNumb.js')}}"></script>
<script src="{{ asset('assets/frontend/vendor/nouislider/nouislider.min.js')}}"></script>

<script>
    $(document).ready(function() {
        var currentPage = 1; // Initialize current page
        var filters ={
            categories: [],
            price_range: {
                min: 0,
                max: 0,
            },
            publishers: [],
            years: [],
            featured: [],
            best_sellers: []
        };
        // Function to fetch data based on page number
        function fetchData(page, filters) {
            $.ajax({
                url: "{{ route('book.bookList') }}",
                type: 'GET',
                data: {
                    page: page,      // Current page number
                    per_page: 12,     // Number of items per page (adjust as per your requirement)
                    filters: filters // Send filters object to the backend
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Data fetched successfully:', response);
                    var data = response.data; // Assuming 'data' contains your fetched data
                    var clientFilters = response.filter;

                    // Render books in the HTML
                    renderBook(data.books.data);

                    // Update pagination controls based on response
                    updatePagination(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching book data:', error);
                }
            });
        }

        // Initial data fetch on page load
        fetchData(currentPage, filters);

        // Function to update pagination controls
        function updatePagination(response) {
            var currentPage = response.data.books.current_page;
            var lastPage = response.data.books.last_page;

            // Update 'Showing X from Y data' text
            var totalRecords = response.data.books.total;
            var perPage = response.data.books.per_page;
            var startRecord = (currentPage - 1) * perPage + 1;
            var endRecord = Math.min(currentPage * perPage, totalRecords);
            $('.page-text').text('Showing ' + startRecord + ' to ' + endRecord + ' of ' + totalRecords + ' data');

            // Update pagination links
            var paginationHtml = '';
            if (currentPage > 1) {
                paginationHtml += '<li class="page-item"><a class="page-link prev" href="javascript:void(0);" data-page="' + (currentPage - 1) + '">Prev</a></li>';
            } else {
                paginationHtml += '<li class="page-item disabled"><a class="page-link prev" href="#">Prev</a></li>';
            }

            for (var i = 1; i <= lastPage; i++) {
                if (i === currentPage) {
                    paginationHtml += '<li class="page-item active"><a class="page-link" href="javascript:void(0);" style="color: #ffffff;background-color: #1a1668;border-color: #1a1668;">' + i + '</a></li>';
                } else {
                    paginationHtml += '<li class="page-item"><a class="page-link" href="javascript:void(0);" data-page="' + i + '">' + i + '</a></li>';
                }
            }

            if (currentPage < lastPage) {
                paginationHtml += '<li class="page-item"><a class="page-link next" href="javascript:void(0);" data-page="' + (currentPage + 1) + '">Next</a></li>';
            } else {
                paginationHtml += '<li class="page-item disabled"><a class="page-link next" href="#">Next</a></li>';
            }

            $('.pagination').html(paginationHtml);
        }

        // Event delegation for pagination links
        $(document).on('click', '.pagination .page-link', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            if (page) {
                fetchData(page);
            }
        });

        // Function to render books in HTML
        function renderBook(books) {
            var html = '';

            books.forEach(function(book) {
                var encodedId = btoa(book.id);

                html += '<div class="col-book style-grid-view">';
                html += '<div class="dz-shop-card style-1">';
                html += '<div class="dz-media">';
                html += '<a href="' + book.url + '">';
                html += '<img src="' + book.image + '" alt="book" style="height: 250px;">';
                html += '</a>';
                html += '</div>';
                html += '<div class="dz-content">';
                html += '<h5 class="title" style="display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis; font-size: larger"><a href="' + book.url + '">' + book.title + '</a></h5>';
                html += '<ul class="dz-tags">';

                if (book.category && Array.isArray(book.category)) {
                    book.category.slice(0, 3).forEach(function(category) {
                        html += '<li>' + category.name + '</li>';
                    });
                } else {
                    console.warn('Invalid or empty categories for book:', book);
                }

                html += '</ul>';
                html += '<ul class="dz-rating">';
                for (var i = 0; i < 5; i++) {
                    if (i < book.rating) {
                        html += '<li><i class="flaticon-star text-yellow"></i></li>';
                    } else {
                        html += '<li><i class="flaticon-star text-muted"></i></li>';
                    }
                }
                html += '</ul>';
                html += '<div class="book-footer">';
                html += '<div class="price">';
                if (book.discounted_price) {
                    html += '<span class="price-num">£' + book.discounted_price + '</span>';
                    html += '<del>£' + book.sale_price + '</del>';
                } else {
                    html += '<span class="price-num">£' + book.sale_price + '</span>';
                }
                html += '</div>';
                html += '<button id="flexCheckDefault1" class="btn btn-outline-danger btnhover add-to-wishlist ' + (book.isWishlisted ? 'active' : '') + '" data-id="' + book.id + '" data-type="large" style="margin-right: 5px;">';
                html += '<i class="flaticon-heart"></i>';
                html += '</button>';
                html += '<a class="btn btn-secondary box-btn btnhover2 add-to-cart" data-id="'
                    + encodedId + '" data-type="large">';
                html += '<i class="flaticon-shopping-cart-1 m-r10"></i> Add to cart';
                html += '</a>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            });

            $('.book-grid-row').html(html);
        }

        // Event listener for 'Add to Wishlist' button
        $(document).on('click', '.add-to-wishlist', function(e) {
            e.preventDefault();
            var bookId = $(this).data('id');
            var button = $(this);

            @if (!auth()->check())
                showToast('error', 'Please login to add this book to your wishlist.');
            @endif

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
                    if (button.hasClass('active')) {
                        button.removeClass('active');
                    } else {
                        button.addClass('active');
                    }
                } else {
                    showToast('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // Event listener for 'Add to Cart' button
        $(document).on('click', '.add-to-cart', function(e) {
            e.preventDefault();
            @if (!auth()->check())
                button.addEventListener('click', function() {
                    showToast('error', 'Please login to add this book to your cart.');
                });
                return;
            @endif

            const bookId = $(this).data('id');
            const quantity = 1;

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

        // get new cart details
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
                                        <span class="item-close remove-cart-item" data-cart-id="${item.cart_id}">&times;</span>
                                    </div>
                                </div>
                            `;
                            cartDropdown.appendChild(listItem);

                            // Add event listener to the remove button
                            listItem.querySelector('.remove-cart-item').addEventListener('click', function() {
                                let cartItemId = item.cart_id;
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
                            <a href="shop-checkout.html" class="btn btn-sm btn-outline-primary btnhover w-100">Checkout</a>
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

@endsection
