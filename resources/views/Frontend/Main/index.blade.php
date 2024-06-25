<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="keywords" content="" />
        <meta name="author" content="DexignZone" />
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

            <!-- Preloader -->
            @include('Frontend/Main/preloader')
            <!-- Preloader -->

            <!-- Header -->
            @include('Frontend/Main/Header/header')
            <!-- Header -->

            <div class="page-content bg-white">

                @yield('content')

            </div>

            <!-- Footer -->
            @include('Frontend/Main/footer')
            <!-- Footer -->

            <button class="scroltop" type="button"><i class="fas fa-arrow-up"></i></button>
        </div>

        <!-- Include Scripts -->
        @include('Frontend/Main/scripts')

    </body>

</html>

