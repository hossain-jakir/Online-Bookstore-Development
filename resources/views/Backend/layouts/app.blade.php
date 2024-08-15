<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title') | Online Book Store</title>

        <link rel="icon" type="image/x-icon" href="{{ asset('assets/frontend/images/favicon.png')}}" />

        <!-- Include Styles -->
        @include('Backend/layouts/sections/styles')

    </head>

    <body class="hold-transition sidebar-mini layout-fixed">

        @yield('layoutContent')

        <!-- Include Scripts -->
        @include('Backend/layouts/sections/scripts')

    </body>

</html>
