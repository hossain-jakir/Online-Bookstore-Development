@extends('Frontend/Main/index')

@section('title', 'Home')

@section('content')

    <!--Swiper Banner Start -->
    @include('Frontend/Main/Slider/Slider')
    <!--Swiper Banner End -->

    <!--Recommend Section Start-->
    @include('Frontend/Main/Recommend/recommend')
    <!--Recommend Section End-->

    <!--About Section Start-->
    @include('Frontend/Main/SiteShortInfo/deliveryAndSafe')
    <!--About Section End-->

    <!-- Book Sale Start -->
    @include('Frontend/Main/OnSale/onSale')
    <!-- Book Sale End -->

    <!-- Feature Section Start -->
    @include('Frontend/Main/Feature/feature')
    <!-- Feature Section End -->

    <!-- Special Offer Start -->
    @include('Frontend/Main/SpecialOffer/specialOffer')
    <!-- Special Offer End -->

    <!-- Feature Box -->
    @include('Frontend/Main/HappyCustomer/happyCustomer')
    <!-- Feature Box End -->

    <!-- Newsletter -->
    @include('Frontend/Main/Newsletter/newsLetter')
    <!-- Newsletter End -->

@endsection
