@extends('Frontend/Main/index')

@section('title', 'Privacy Policy')

@section('content')

<div class="page-content">
    <!-- inner page banner -->
    <div class="dz-bnr-inr overlay-secondary-dark dz-bnr-inr-sm" style="background-image:url(images/background/bg3.jpg);">
        <div class="container">
            <div class="dz-bnr-inr-entry">
                <h1>Privacy Policy</h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> Home</a></li>
                        <li class="breadcrumb-item">Privacy Policy</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- inner page banner End-->

    <!-- contact area -->
    <section class="content-inner-1 shop-account">
        <div class="container">
            <div class="row">
                <!-- Left part start -->
                <div class="col-lg-8 col-md-7 col-sm-12 inner-text">
                    <h4 class="title">The BookLand Privacy Policy was updated on {{ date('j F Y', strtotime('20 June 2024')) }}.</h4>
                    <p class="m-b30">Welcome to the Privacy Policy of BookLand. This Privacy Policy describes how BookLand collects, uses, shares, and protects your information when you use our website. By accessing or using our services, you agree to the terms of this Privacy Policy.</p>
                    <div class="dlab-divider bg-gray-dark"></div>
                    <h4 class="title">What Information We Collect</h4>
                    <p class="m-b30">We may collect personal information such as your name, email address, phone number, and payment details when you place an order or register on our website. We also collect non-personal information such as your browser type, IP address, and browsing behavior to improve our services.</p>

                    <h4 class="title">How We Use Your Information</h4>
                    <p class="m-b30">We use your information to process your orders, communicate with you, improve our website, and personalize your experience. We may also use your information for marketing purposes, with your consent where required by law.</p>

                    <h4 class="title">Sharing Your Information</h4>
                    <p class="m-b30">We do not sell, trade, or otherwise transfer your personal information to outside parties unless we provide you with advance notice. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, as long as those parties agree to keep this information confidential.</p>

                    <h4 class="title">Security of Your Information</h4>
                    <p class="m-b30">We implement a variety of security measures to maintain the safety of your personal information when you place an order or enter, submit, or access your personal information.</p>

                    <h4 class="title">Changes to Our Privacy Policy</h4>
                    <p class="m-b30">BookLand reserves the right to modify or update this Privacy Policy at any time. Any changes will be effective immediately upon posting the updated Privacy Policy on our website.</p>
                </div>
                <div class="col-lg-4 col-md-5 col-sm-12 m-b30 mt-md-0 mt-4">
                    <aside class="side-bar sticky-top right">
                        <div class="service_menu_nav widget style-1">
                            <ul class="menu">
                                <li class="menu-item"><a href="{{ route('about-us')}}">About Us</a></li>
                                <li class="menu-item active"><a href="javascript:void(0);">Privacy Policy</a></li>
                                <li class="menu-item"><a href="{{ route('contact-us')}}">Contact Us</a></li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!-- Privacy Policy END -->
</div>

@endsection
