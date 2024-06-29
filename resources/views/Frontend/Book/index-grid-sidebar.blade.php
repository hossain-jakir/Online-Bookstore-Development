@extends('Frontend/Main/index')

@section('title', 'Books')

@section('content')

<div class="page-content bg-grey">
    <div class="content-inner border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xl-3">
                    <div class="shop-filter">
                        <div class="d-flex justify-content-between">
                            <h4 class="title">Filter Option</h4>
                            <a href="javascript:void(0);" class="panel-close-btn"><i class="flaticon-close"></i></a>
                        </div>
                        <div class="accordion accordion-filter" id="accordionExample">
                            <div class="accordion-item">
                                <button class="accordion-button" id="headingFive" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Price Range
                                </button>
                                <div id="collapseFive" class="accordion-collapse collapse accordion-body show" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                    <div class="range-slider style-1">
                                        <div id="slider-tooltips"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                              <button class="accordion-button" id="headingOne" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Shop by Category</button>
                                <div id="collapseOne" class="accordion-collapse collapse show accordion-body" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="widget dz-widget_services d-flex justify-content-between">
                                        <div class="category-column-1">
                                            {{-- categories will be rendered here --}}
                                        </div>
                                        <div class="category-column-2">
                                            {{-- categories will be rendered here --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" id="headingTwo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Choose Publisher
                                </button>
                                <div id="collapseTwo" class="accordion-collapse collapse accordion-body" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="widget dz-widget_services">
                                        {{-- Publishers will be rendered here --}}
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" id="headingThree" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Select Year
                                </button>
                                <div id="collapseThree" class="accordion-collapse collapse accordion-body" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="widget dz-widget_services col d-flex justify-content-between">
                                        <div class="year-column-1 year-column">
                                            {{-- Years will be rendered here --}}
                                        </div>
                                        <div class="year-column-2 year-column">
                                            {{-- Years will be rendered here --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion accordion-inner" id="filter-inner">
                                <div class="accordion-item">
                                      <button class="accordion-button collapsed" id="headingFour_inner" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour_inner" aria-expanded="false" aria-controls="collapseFour_inner">
                                        Featured (<span id="featured-count">0</span>)
                                      </button>
                                    <div id="collapseFour_inner" class="accordion-collapse collapse accordion-body" aria-labelledby="headingFour_inner" data-bs-parent="#filter-inner">
                                        <ul id="featured-books-list">
                                            <!-- Featured books will be rendered here -->
                                        </ul>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" id="headingSix_inner" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix_inner" aria-expanded="false" aria-controls="collapseSix_inner">
                                        Best Books (<span id="best-books-count">0</span>)
                                    </button>
                                    <div id="collapseSix_inner" class="accordion-collapse collapse accordion-body" aria-labelledby="headingSix_inner" data-bs-parent="#filter-inner">
                                        <ul id="best-books-list">
                                            <!-- Best books will be rendered here -->
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row filter-buttons">
                            <div>
                                <a href="javascript:void(0);" class="btn btn-secondary btnhover mt-4 d-block" id="refineSearchBtn">Refine Search</a>
                                <a href="javascript:void(0);" class="btn btn-outline-secondary btnhover mt-3 d-block" id="resetFilterBtn">Reset Filter</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="title">Books</h4>
                        <a href="javascript:void(0);" class="btn btn-primary panel-btn">Filter</a>
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
                                    @if (!Route::currentRouteName() == 'book.index')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('book.index') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 22H21C21.2652 22 21.5196 21.8946 21.7071 21.7071C21.8946 21.5196 22 21.2652 22 21V3C22 2.73478 21.8946 2.48043 21.7071 2.29289C21.5196 2.10536 21.2652 2 21 2H3C2.73478 2 2.48043 2.10536 2.29289 2.29289C2.10536 2.48043 2 2.73478 2 3V21C2 21.2652 2.10536 21.5196 2.29289 21.7071C2.48043 21.8946 2.73478 22 3 22ZM13 4H20V11H13V4ZM13 13H20V20H13V13ZM4 4H11V20H4V4Z" fill="#AAAAAA"></path>
                                            </svg>
                                        </a>
                                    </li>
                                    @endif
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
                    filter(data.filter, clientFilters);

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

        // Event listener for 'Refine Search' button
        $('#refineSearchBtn').click(function() {
            // Replace with your actual refine search logic
            console.log('Refining search...');
            // Call a function to apply filters or perform additional actions
            applyFilters();
        });

        // Event listener for 'Reset Filter' button
        $('#resetFilterBtn').click(function() {
            // Replace with your actual reset filter logic
            console.log('Resetting filters...');
            // Call a function to reset filters to their initial state
            resetFilters();
        });

        // Function to apply filters
        function applyFilters() {
            // Capture selected filter values from the UI
            var selectedCategories = [];
            $('.category-column-1 input:checked, .category-column-2 input:checked').each(function() {
                selectedCategories.push($(this).val());
            });

            var priceRangeValues =
                document.getElementById('slider-tooltips').noUiSlider.get(); // Get the selected price range
            var selectedPublishers = [];
            $('#collapseTwo .widget.dz-widget_services input:checked').each(function() {
                selectedPublishers.push($(this).val());
            });

            var selectedYears = [];
            $('.year-column-1 input:checked, .year-column-2 input:checked').each(function() {
                selectedYears.push($(this).val());
            });

            var selectedFeaturedBooks = [];
            $('#collapseFour_inner input:checked').each(function() {
                selectedFeaturedBooks.push($(this).val());
            });

            var selectedBestBooks = [];
            $('#collapseSix_inner input:checked').each(function() {
                selectedBestBooks.push($(this).val());
            });


            // Prepare filter object to send to backend or manipulate data locally
            var filters = {
                categories: selectedCategories,
                price_range: {
                    min: priceRangeValues[0],
                    max: priceRangeValues[1]
                },
                publishers: selectedPublishers,
                years: selectedYears,
                featured: selectedFeaturedBooks,
                best_sellers: selectedBestBooks
            };

            console.log('Applying filters:', filters);

            // Call a function to fetch data based on the applied filters
            fetchData(currentPage, filters);
        }

        // Function to reset filters
        function resetFilters() {
            // Uncheck all checkboxes
            $('.category-column-1 input:checked, .category-column-2 input:checked').prop('checked', false);
            $('#collapseTwo .widget.dz-widget_services input:checked').prop('checked', false);
            $('.year-column-1 input:checked, .year-column-2 input:checked').prop('checked', false);
            $('#collapseFour_inner input:checked').prop('checked', false);
            $('#collapseSix_inner input:checked').prop('checked', false);

            // Reset price range slider
            var tooltipSlider = document.getElementById('slider-tooltips');
            tooltipSlider.noUiSlider.set([0, 1000]); // Set the default price range

            // Reset pagination to first page
            fetchData(currentPage, filters);
        }

        function filter(filter, clientFilters){
            console.log(filter);

            priceRange(filter.price_range, clientFilters.price_range);
            shopByCategory(filter.categories, clientFilters.categories);
            generatePublisherHtml(filter.publishers, clientFilters.publishers);
            generateYearHtml(filter.years, clientFilters.years);
            renderFeaturedBooks(filter.featured, clientFilters.featured);
            renderBestBooks(filter.best_sellers, clientFilters.best_sellers);
        }

        function renderBestBooks(best_sellers, clientFiltersBest_sellers) {

            // Ensure best_sellers is defined and is an array
            clientFiltersBest_sellers = clientFiltersBest_sellers || [];

            // Extract values from clientFiltersCategories and convert them to strings
            var filterIds = [];

            for (var key in clientFiltersBest_sellers) {
                filterIds.push(String(clientFiltersBest_sellers[key])); // Convert each value to string
            }

            var html = '';
            if (Array.isArray(best_sellers)) {
                best_sellers.forEach(function(book) {
                    var isChecked = filterIds.includes(String(book.id)); // Ensure book.id is treated as a string
                    html += `<li>
                                <div class="form-check search-content">
                                    <input class="form-check-input" type="checkbox" value="${book.id}" id="bestBooksCheckBox-${book.id}" ${isChecked ? 'checked' : ''}>
                                    <label class="form-check-label" for="bestBooksCheckBox-${book.id}">
                                        ${book.title}
                                    </label>
                                </div>
                            </li>`;
                });

                $('#best-books-list').html(html);
                $('#best-books-count').text(best_sellers.length);
            }
        }

        function renderFeaturedBooks(featured, clientFiltersFeatured) {

            // Ensure featured is defined and is an array
            clientFiltersFeatured = clientFiltersFeatured || [];

            // Extract values from clientFiltersCategories and convert them to strings
            var filterIds = [];

            for (var key in clientFiltersFeatured) {
                filterIds.push(String(clientFiltersFeatured[key])); // Convert each value to string
            }

            var html = '';

            // Check if featured is an array
            if (Array.isArray(featured)) {
                featured.forEach(function(book) {
                    var isChecked = filterIds.includes(String(book.id)); // Ensure book.id is treated as a string
                    html += '<li>';
                    html += '<div class="form-check search-content">';
                    html += '<input class="form-check-input" type="checkbox" value="' + book.id + '" id="featuredCheckBox-' + book.id + '" ' + (isChecked ? 'checked' : '') + '>';
                    html += '<label class="form-check-label" for="featuredCheckBox-' + book.id + '">';
                    html += book.title;
                    html += '</label>';
                    html += '</div>';
                    html += '</li>';
                });

                $('#featured-books-list').html(html);
                $('#featured-count').text(featured.length);
            }
        }

        function generateYearHtml(years, clientFiltersYears) {

            // Ensure years is defined and is an array
            clientFiltersYears = clientFiltersYears || [];

            // Extract unique years from the dates
            var years = years.map(date => date.split('-')[0]);
            var uniqueYears = Array.from(new Set(years)).sort((a, b) => b - a); // Sort in descending order

            // Split the years into two columns
            var midIndex = Math.ceil(uniqueYears.length / 2);
            var firstColumnYears = uniqueYears.slice(0, midIndex);
            var secondColumnYears = uniqueYears.slice(midIndex);

            // Generate the year HTML for both columns
            var firstColumnHtml = generateYear_Html(firstColumnYears, clientFiltersYears);
            var secondColumnHtml = generateYear_Html(secondColumnYears, clientFiltersYears);

            // Insert the generated HTML into the respective columns
            $('.year-column-1').html(firstColumnHtml);
            $('.year-column-2').html(secondColumnHtml);
        }

        // Function to generate HTML for years
        function generateYear_Html(years, clientFiltersYears) {
            var filterIds = [];

            // Extract values from clientFiltersCategories and convert them to strings
            for (var key in clientFiltersYears) {
                filterIds.push(String(clientFiltersYears[key])); // Convert each value to string
            }

            console.log('Filter Year:', filterIds);

            var html = '';
            years.forEach((year, index) => {
                var isChecked = filterIds.includes(String(year)); // Ensure year is treated as a string
                var checkboxId = 'yearCheckBox' + (index + 1); // Generate unique ID for each checkbox
                html += '<div class="form-check search-content">';
                html += '<input class="form-check-input" type="checkbox" value="' + year + '" id="' + checkboxId + '" ' + (isChecked ? 'checked' : '') + '>';
                html += '<label class="form-check-label" for="' + checkboxId + '">';
                html += year;
                html += '</label>';
                html += '</div>';
            });
            return html;
        }

        function generatePublisherHtml(publishers, clientFiltersPublishers) {
            // Ensure publishers is defined and is an array
            clientFiltersPublishers = clientFiltersPublishers || [];
            publishers = publishers || [];

            var filterIds = [];

            // Extract values from clientFiltersCategories and convert them to strings
            for (var key in clientFiltersPublishers) {
                filterIds.push(String(clientFiltersPublishers[key])); // Convert each value to string
            }

            var html = '';
            publishers.forEach(function(publisher, index) {

                var isChecked = filterIds.includes(String(publisher));

                var checkboxId = 'publisherCheckBox' + (index + 1); // Generate unique ID for each checkbox
                html += '<div class="form-check search-content">';
                html += '<input class="form-check-input" type="checkbox" value="' + publisher + '" id="' + checkboxId + '" ' + (isChecked ? 'checked' : '') + '>';
                html += '<label class="form-check-label" for="' + checkboxId + '">';
                html += publisher;
                html += '</label>';
                html += '</div>';
            });

            $('#collapseTwo .widget.dz-widget_services').html(html);
        }

        function shopByCategory(categories, clientFiltersCategories) {
            // Ensure clientFiltersCategories is defined and is an array
            clientFiltersCategories = clientFiltersCategories || [];

            var html = '';
            var count = categories.length;
            var firstColumn = categories.slice(0, Math.ceil(count / 2));
            var secondColumn = categories.slice(Math.ceil(count / 2), count);

            // Generate HTML for each column
            var firstColumnHtml = generateCategoryHtml(firstColumn, clientFiltersCategories);
            var secondColumnHtml = generateCategoryHtml(secondColumn, clientFiltersCategories);

            // Insert HTML into the appropriate container
            $('.category-column-1').html(firstColumnHtml);
            $('.category-column-2').html(secondColumnHtml);
        }

        function generateCategoryHtml(column, clientFiltersCategories) {
            var html = '';
            var filterIds = [];

            // Extract values from clientFiltersCategories and convert them to strings
            for (var key in clientFiltersCategories) {
                filterIds.push(String(clientFiltersCategories[key])); // Convert each value to string
            }

            column.forEach(function(category) {
                var isChecked = filterIds.includes(String(category.id)); // Ensure category.id is treated as a string

                html += '<div class="form-check search-content">';
                html += '<input class="form-check-input" type="checkbox" value="' + category.id + '" id="productCheckBox-' + category.id + '" ' + (isChecked ? 'checked' : '') + '>';
                html += '<label class="form-check-label" for="productCheckBox-' + category.id + '">';
                html += category.name;
                html += '</label>';
                html += '</div>';
            });

            return html;
        }

        function priceRange(price_range, clientFiltersPrice_range){
            var tooltipSlider = document.getElementById('slider-tooltips');

            // Check if slider element exists and if it's already initialized
            if (tooltipSlider && tooltipSlider.noUiSlider) {
                tooltipSlider.noUiSlider.destroy(); // Destroy existing slider instance
            }

            var max = clientFiltersPrice_range.max == '0' ? price_range.max : clientFiltersPrice_range.max;
            var min = clientFiltersPrice_range.min == '0' ? price_range.min : clientFiltersPrice_range.min;
            // Create new slider instance
            noUiSlider.create(tooltipSlider, {
                start: [min, max],
                connect: true,
                tooltips: [wNumb({ decimals: 1 }), true],
                range: {
                    'min': price_range.min,
                    'max': price_range.max
                }
            });
        }

        // Function to render books in HTML
        function renderBook(books) {
            var html = '';

            books.forEach(function(book) {
                var encodedId = btoa(book.id);

                html += '<div class="col-book style-2">';
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
