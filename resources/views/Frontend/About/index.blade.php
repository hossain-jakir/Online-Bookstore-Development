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
                        <li class="breadcrumb-item"><a href="{{ route('home')}}"> Home</a></li>
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
                                        <h2><span class="counter">1</span><small>+</small></h2>
                                    </div>
                                    <h6 class="title">Years of Experience</h6>
                                </div>
                                <div class="exp-info">
                                    <ul class="list-check primary">
                                        @foreach ($data['categories'] as $category)
                                            @if ($loop->index < 5)
                                                <li>{{ $category->name }}</li>
                                            @endif
                                            @if ($loop->last && $loop->count > 5)
                                                and more {{ $loop->count - 5 }} categories
                                            @endif
                                        @endforeach
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
                            <p>
                                We are a team of book lovers who want to share our passion with the world. We believe that books are the best way to learn and grow. That's why we created Bookland, a place where you can find all the books you need to succeed.
                            </p>
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
                <p>
                    Our mission is to provide the best books at the best prices. We want to make learning accessible to everyone, no matter where they are or what their budget is. That's why we offer a wide selection of books at affordable prices. We also want to make it easy for people to find the books they need, which is why we have a user-friendly website that makes it easy to search for books by category, author, or title. We believe that everyone should have the opportunity to learn and grow, and we're here to help make that happen.
                </p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="icon-bx-wraper style-3 m-b30">
                        <div class="icon-lg m-b20">
                            <i class="flaticon-open-book-1 icon-cell"></i>
                        </div>
                        <div class="icon-content">
                            <h4 class="title">Best Bookstore</h4>
                            <p style="text-align: justify; text-justify: inter-word;">
                                Welcome to our esteemed and diverse bookstore! Discover an extensive range of books catering to all ages and interests. Whether you seek classic novels, children's stories, or insightful self-help guides, we have precisely what you're looking for.
                            </p>
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
                            <p style="text-align: justify; text-justify: inter-word;">
                                As a trusted book retailer with years of experience, we pride ourselves on offering top-quality books at affordable prices. Our commitment to customer satisfaction is unwavering; we strive to meet all your literary needs reliably and affordably.
                            </p>
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
                            <p style="text-align: justify; text-justify: inter-word;">
                                Looking to expand our store continually, we delight in enhancing our collection with fresh titles across various genres. Our dedication to diversity ensures we introduce new authors and genres regularly, enriching your browsing experience with every visit.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Box -->
    @include('Frontend/Main/HappyCustomer/happyCustomer')
    <!-- Feature Box End -->

    <!-- Newsletter -->
    @include('Frontend/Main/Newsletter/newsLetter')
    <!-- Newsletter End -->

</div>

@endsection
