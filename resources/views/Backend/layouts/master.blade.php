@extends('Backend/layouts/app')

@section('layoutContent')

    <div class="wrapper">
        @php
            $shop = DB::table('shops')->first();
        @endphp
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ Storage::url($shop->logo) }}" alt="{{ $shop->name }}" height="80px" width="auto">
        </div>

        @include('Backend/layouts/sections/navbar/navbar')

        @include('Backend/layouts/sections/sidebar/sidebar')

        @yield('content')

        @include('Backend/layouts/sections/footer/footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

    </div>
@endsection
