<!-- STYLESHEETS -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/icons/fontawesome/css/all.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/swiper/swiper-bundle.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/animate/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/style.css')}}">

<!-- GOOGLE FONTS-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
    const csrfToken = "{{ csrf_token() }}";
    const wishlistRoute = "{{ route('wishlist.store') }}";
    const cartItemsRoute = "{{ route('cart.get-cart-items') }}";
    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
</script>
<style>

    .search-input {
        position: relative;
    }

    #search-results {
        position: absolute;
        top: 100%; /* Position it directly below the input field */
        left: 0;
        width: 100%;
        max-height: 400px; /* Adjust as needed */
        overflow-y: auto;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        z-index: 1000; /* Ensure it appears above other content */
        display: none; /* Hidden by default */
    }

    .search-result-item {
        padding: 10px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
    }

    .search-result-item img {
        width: 50px; /* Adjust as needed */
        height: auto;
        margin-right: 10px;
        vertical-align: middle;
    }

    .search-result-item a {
        text-decoration: none;
        color: #333;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .search-result-item h5 {
        margin: 0;
        font-size: 16px;
    }

    .search-result-item p {
        margin: 5px 0 0;
        font-size: 14px;
    }
</style>

@yield('addStyle')
