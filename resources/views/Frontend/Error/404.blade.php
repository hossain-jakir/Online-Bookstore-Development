<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="keywords" content="book, book store, book shop, ecommerce, online book store, online book shop, book website, book ecommerce website, book online store, book online shop, book ecommerce website"/>
        <meta name="author" content="Jakir Hossain" />
        <meta name="robots" content="" />
        <meta name="description" content="Bookland-Book Store Ecommerce Website"/>
        <meta property="og:title" content="Bookland-Book Store Ecommerce Website"/>
        <meta property="og:description" content="Bookland-Book Store Ecommerce Website"/>
        <meta property="og:image" content="https://makaanlelo.com/tf_products_007/bookland/xhtml/social-image.png"/>
        <meta name="format-detection" content="telephone=no">

        <!-- FAVICONS ICON -->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/frontend/images/favicon.png')}}"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- PAGE TITLE HERE -->
        <title>@yield('title') | Online Book Store</title>

        <!-- MOBILE SPECIFIC -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Include Styles -->
        @include('Frontend/Main/styles')
    </head>
<body>
<div class="page-wraper">
	<div class="error-page overlay-secondary-dark" style="background-image: url({{ asset('assets/frontend/images/background/bg3.jpg')}});">
		<div class="error-inner text-center">
			<div class="dz_error" data-text="404">404</div>
			<h2 class="error-head">We are sorry. But the page you are looking for cannot be found.</h2>
			<a href="{{route('home')}}" class="btn btn-primary btn-border btnhover white-border">BACK TO HOMEPAGE</a>
		</div>
	</div>
</div>

<!-- JAVASCRIPT FILES ========================================= -->
    @include('Frontend/Main/scripts')

</body>
</html>
