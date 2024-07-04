@extends('Frontend/Main/index')

@section('title', isset($data['title']) ? $data['title'] : 'Books')

@section('content')

<div class="page-content bg-grey">
    <section class="content-inner border-bottom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="title">
                    @if(Route::currentRouteName() == 'category')
                        Books by {{ $data['title'] }}
                    @else
                        Books
                    @endif
                </h4>
            </div>
            <div class="filter-area m-b30">
                <div class="grid-area">
                    <div class="shop-tab">
                        <ul class="nav text-center product-filter justify-content-end" role="tablist">
                            @if (!Route::currentRouteName() == 'book.list')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('book.list') }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 5H21C21.2652 5 21.5196 4.89464 21.7071 4.7071C21.8946 4.51957 22 4.26521 22 4C22 3.73478 21.8946 3.48043 21.7071 3.29289C21.5196 3.10536 21.2652 3 21 3H3C2.73478 3 2.48043 3.10536 2.29289 3.29289C2.10536 3.48043 2 3.73478 2 4C2 4.26521 2.10536 4.51957 2.29289 4.7071C2.48043 4.89464 2.73478 5 3 5Z" fill="#AAAAAA"></path>
                                    <path d="M3 13H21C21.2652 13 21.5196 12.8947 21.7071 12.7071C21.8946 12.5196 22 12.2652 22 12C22 11.7348 21.8946 11.4804 21.7071 11.2929C21.5196 11.1054 21.2652 11 21 11H3C2.73478 11 2.48043 11.1054 2.29289 11.2929C2.10536 11.4804 2 11.7348 2 12C2 12.2652 2.10536 12.5196 2.29289 12.7071C2.48043 12.8947 2.73478 13 3 13Z" fill="#AAAAAA"></path>
                                    <path d="M3 21H21C21.2652 21 21.5196 20.8947 21.7071 20.7071C21.8946 20.5196 22 20.2652 22 20C22 19.7348 21.8946 19.4804 21.7071 19.2929C21.5196 19.1054 21.2652 19 21 19H3C2.73478 19 2.48043 19.1054 2.29289 19.2929C2.10536 19.4804 2 19.7348 2 20C2 20.2652 2.10536 20.5196 2.29289 20.7071C2.48043 20.8947 2.73478 21 3 21Z" fill="#AAAAAA"></path>
                                    </svg>
                                </a>
                            </li>
                            @endif

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
                        <select class="default-select" id="day-filter">
                            <option value="newest">Newest</option>
                            <option value="1_day" {{ request()->day_filter == '1_day' ? 'selected' : '' }}>1 Day</option>
                            <option value="1_week" {{ request()->day_filter == '1_week' ? 'selected' : '' }}>1 Week</option>
                            <option value="3_weeks" {{ request()->day_filter == '3_weeks' ? 'selected' : '' }}>3 Weeks</option>
                            <option value="1_month" {{ request()->day_filter == '1_month' ? 'selected' : '' }}>1 Month</option>
                            <option value="3_months" {{ request()->day_filter == '3_months' ? 'selected' : '' }}>3 Months</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row row-book">
                @forelse ($data['data']['books'] as $book)
                    <div class="col-md-12 col-sm-12">
                        <div class="dz-shop-card style-2">
                            <div class="dz-media">
                                <img src="{{ $book->image}}" alt="book">
                            </div>
                            <div class="dz-content">
                                <div class="dz-header">
                                    <div>
                                        <ul class="dz-tags">
                                            @foreach ($book->category as $category)
                                                @if ($loop->last)
                                                    <li><a href="{{ URL::to($category->slug) }}">
                                                        {{ $category->name }}
                                                    </a></li>
                                                @else
                                                    <li><a href="{{ URL::to($category->slug) }}">
                                                        {{ $category->name }},
                                                    </a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        <h4 class="title mb-0"><a href="{{ route('book.show', ['id' => base64_encode($book->id)]) }}">{{ $book->title }}</a></h4>
                                    </div>
                                    <div class="price">
                                        @if ($book->discounted_price)
                                            <span class="price-num text-primary">£{{ $book->discounted_price }}</span>
                                            <del>£{{ $book->sale_price }}</del>
                                        @else
                                            <span class="price-num text-primary">£{{ $book->sale_price }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="dz-body">
                                    <div class="dz-rating-box">
                                        <div>
                                            <p class="dz-para" style="max-height: 100px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; text-align: justify;">
                                                {{ $book->description }}
                                            </p>
                                            <div>
                                                {{-- <a href="pricing.html" class="badge">Get 20% Discount for today</a>
                                                <a href="pricing.html" class="badge">50% OFF Discount</a>
                                                <a href="pricing.html" class="badge next-badge">See 2+ promos</a> --}}
                                            </div>
                                        </div>
                                        <div class="review-num">
                                            <h4>{{ $book->rating }}</h4>
                                            <ul class="dz-rating">
                                                @for ($i = 0; $i < 5; $i++)
                                                    @if ($i < $book->rating)
                                                        <li class="active">
                                                            <i class="flaticon-star text-yellow"></i>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <i class="flaticon-star text-muted"></i>
                                                        </li>
                                                    @endif
                                                @endfor


                                            </ul>
                                            <span>
                                                {{ $book->reviews->count() }} @if ($book->reviews->count() > 1) reviews @else review @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="rate">
                                        <ul class="book-info">
                                            <li><span>Writen by</span> {{ $book->author->first_name }} {{ $book->author->last_name }}</li>
                                            <li><span>Publisher</span>{{ $book->publisher }}</li>
                                            <li><span>Year</span>
                                                {{ date('Y', strtotime($book->published_date)) }}
                                            </li>
                                        </ul>
                                        <div class="d-flex">
                                            <button class="btn btn-secondary btnhover2 add-to-cart" data-id="{{ base64_encode($book->id) }}"><i class="flaticon-shopping-cart-1 m-r10"></i>Add To Cart</button>
                                            <!-- Love Icon -->
                                            <button class="btn btn-outline-danger btnhover add-to-wishlist @if($book->isInWishlist) active @endif" data-id="{{ $book->id }}" data-type="large" style="margin-left: 5px;">
                                                <i class="flaticon-heart"></i>
                                            </button>
                                            <!-- Love Icon -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="alert alert-info text-center" role="alert">
                            No books found.
                        </div>
                    </div>
                @endforelse

            </div>
            <div class="row page mt-0">
                {!! $data['data']['books']->withQueryString()->links('pagination::default') !!}
            </div>
        </div>
    </section>

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
        let per_Page; // Number of items per page
        var filters ={
            categories: [],
            price_range: {
                min: 0,
                max: 0,
            },
            publishers: [],
            years: [],
            featured: [],
            best_sellers: [],
            day_filter: 'newest'
        };

        // Initialize data if provided in page load
        var initialData = {!! json_encode($data) !!};
        if (initialData && initialData.data) {
            console.log('Initial data:', initialData);
            console.log('Initial books:', initialData.data.books);
            // renderBook(initialData.data.books.data);
            // updatePagination(initialData.data.books);
        } else {
            console.error('No initial data found!');
            fetchData(currentPage, filters);
        }

        // Function to update URL without refreshing the page
        function updateURL(filters) {
            var queryParams = new URLSearchParams();
            if (filters) {
                if (filters.day_filter) {
                    queryParams.set('day_filter', encodeURIComponent(filters.day_filter));
                }

                var newUrl = window.location.pathname + '?' + queryParams.toString();
                history.pushState(null, '', newUrl);

                console.log('Updated URL:', newUrl);

                //refresh the page
                window.location.reload();

            }
        }

        // Event listener for day filter changes
        document.getElementById('day-filter').addEventListener('change', function() {
            // Update the day_filter in the filters object
            filters.day_filter = this.value;

            // Call a function to apply filters or perform additional actions
            applyFilters();
        });

        // Function to apply filters
        function applyFilters() {
            //day filter
            var dayFilter = $('#day-filter').val();


            // Prepare filter object to send to backend or manipulate data locally
            var filters = {
                day_filter: dayFilter
            };

            console.log('Applying filters:', filters);

            // Call a function to fetch data based on the applied filters
            // fetchData(currentPage, filters);

            //Update the URL
            updateURL(filters);
        }

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
