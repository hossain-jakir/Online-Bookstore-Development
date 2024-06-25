@extends('Frontend/Main/index')

@section('title', 'About Us')

@section('content')

<div class="page-content bg-white">
    <!--banner-->
    <div class="dz-bnr-inr overlay-secondary-dark dz-bnr-inr-sm" style="background-image:url({{ asset('assets/frontend/images/background/bg3.jpg')}});">
        <div class="container">
            <div class="dz-bnr-inr-entry">
                <h1>About us</h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"> Home</a></li>
                        <li class="breadcrumb-item">About us</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!--Our Mission Section-->
    <section class="content-inner overlay-white-middle">
        <div class="container">
            <div class="row about-style1 align-items-center">
                <div class="col-lg-6 m-b30">
                    <div class="row sp10 about-thumb">
                        <div class="col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                            <div class="split-box">
                                <div>
                                    <img class="m-b30" src="{{ asset('assets/frontend/images/about/about1.jpg')}}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="split-box ">
                                <div>
                                    <img class="m-b20 aos-item" src="{{ asset('assets/frontend/images/about/about2.jpg')}}" alt="" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                                </div>
                            </div>
                            <div class="exp-bx aos-item"  data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                                <div class="exp-head">
                                    <div class="counter-num">
                                        <h2><span class="counter">50</span><small>+</small></h2>
                                    </div>
                                    <h6 class="title">Years of Experience</h6>
                                </div>
                                <div class="exp-info">
                                    <ul class="list-check primary">
                                        <li>Comics & Graphics</li>
                                        <li>Biography</li>
                                        <li>Literary Collections</li>
                                        <li>Children Fiction</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 m-b30 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                    <div class="about-content px-lg-4">
                        <div class="section-head style-1">
                            <h2 class="title">Bookland Is Best Choice For Learners</h2>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration which don’t look even slightly believable. It Is A Long Established Fact That A Reader Will Be Distracted</p>
                        </div>
                        <a href="contact-us.html" class="btn btn-primary btnhover shadow-primary">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--icon-box3 section-->
    <section class="content-inner-1 bg-light">
        <div class="container">
            <div class="section-head text-center">
                <h2 class="title">Our Mission</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="icon-bx-wraper style-3 m-b30">
                        <div class="icon-lg m-b20">
                            <i class="flaticon-open-book-1 icon-cell"></i>
                        </div>
                        <div class="icon-content">
                            <h4 class="title">Best Bookstore</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                            <a href="about-us.html">Learn More <i class="fa-solid fa-angles-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="icon-bx-wraper style-3 m-b30">
                        <div class="icon-lg m-b20">
                            <i class="flaticon-exclusive icon-cell"></i>
                        </div>
                        <div class="icon-content">
                            <h4 class="title">Trusted Seller</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                            <a href="about-us.html">Learn More <i class="fa-solid fa-angles-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="icon-bx-wraper style-3 m-b30">
                        <div class="icon-lg m-b20">
                            <i class="flaticon-store icon-cell"></i>
                        </div>
                        <div class="icon-content">
                            <h4 class="title">Expand Store</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                            <a href="about-us.html">Learn More <i class="fa-solid fa-angles-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial -->
    <!-- Testimonial End -->

    <!-- Feature Box -->
    @include('Frontend/Main/HappyCustomer/happyCustomer')
    <!-- Feature Box End -->

    <!-- Newsletter -->
    @include('Frontend/Main/Newsletter/newsLetter')
    <!-- Newsletter End -->

</div>

@endsection
