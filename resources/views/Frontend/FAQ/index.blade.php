@extends('Frontend/Main/index')

@section('title', "FAQ's")

@section('content')

<div class="page-content">
    <!-- inner page banner -->
    <div class="dz-bnr-inr overlay-secondary-dark dz-bnr-inr-sm" style="background-image:url({{asset('assets/frontend/images/background/bg3.jpg')}});">
        <div class="container">
            <div class="dz-bnr-inr-entry">
                <h1>FAQ's</h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">FAQ's</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- inner page banner End-->

    <!-- FAQ Content Start -->
    <section class="main-faq-content content-inner">
        <div class="container">
            <div class="row">
                <!-- About Bookland -->
                <div class="col-lg-6 align-self-center mb-4">
                    <div class="faq-content-box">
                        <div class="section-head">
                            <h2 class="title">What Is Bookland?</h2>
                            <p>Bookland is your one-stop destination for a diverse collection of books across all genres. We aim to provide book lovers with access to a wide range of titles, from the latest bestsellers to timeless classics, all at competitive prices.</p>
                        </div>
                        <div class="faq-accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h3 class="title" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            <span>How do I place an order?</span>
                                            <span class="icon"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                                        </h3>
                                    </div>
                                    <div id="collapseOne" class="collapse accordion-collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="card-body">
                                            <p>To place an order, simply browse our collection, select the books you wish to purchase, and add them to your cart. Proceed to checkout, where you can enter your shipping details and payment information. Once your order is confirmed, you'll receive a confirmation email with your order details.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h3 class="title" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <span>What payment methods do you accept?</span>
                                            <span class="icon"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                                        </h3>
                                    </div>
                                    <div id="collapseTwo" class="collapse accordion-collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="card-body">
                                            <p>We accept a variety of payment methods, including major credit and debit cards (Visa, MasterCard, American Express), PayPal, and other secure online payment options. Rest assured that all transactions are encrypted and secure.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingThree">
                                        <h3 class="title" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <span>How can I track my order?</span>
                                            <span class="icon"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                                        </h3>
                                    </div>
                                    <div id="collapseThree" class="collapse accordion-collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="card-body">
                                            <p>Once your order is shipped, you'll receive a tracking number via email. You can use this number to track your order on our website or through the shipping carrier's tracking service. If you have any questions or issues, our customer support team is here to help.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FAQ Image -->
                <div class="col-lg-6 order-lg-2 order-1 mb-4">
                    <div class="faq-img-box wow left-animation rounded-md" data-wow-delay="0.2s">
                        <img src="{{asset('assets/frontend/images/about/pic1.jpg')}}" alt="FAQ Image">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="main-faq-content bg-light content-inner">
        <div class="container">
            <div class="row">
                <!-- FAQ Image -->
                <div class="col-lg-6 mb-4">
                    <div class="faq-img-box rounded-md">
                        <img src="{{asset('assets/frontend/images/about/pic2.jpg')}}" alt="FAQ Image">
                    </div>
                </div>
                <!-- Managing Books -->
                <div class="col-lg-6 align-self-center mb-4">
                    <div class="faq-content-box">
                        <div class="section-head">
                            <h2 class="title">Managing Books</h2>
                            <p>Our extensive collection is carefully curated to cater to all reading preferences. Whether you're looking for fiction, non-fiction, academic resources, or children's books, we have something for everyone.</p>
                        </div>
                        <div class="faq-accordion">
                            <div class="accordion" id="accordionExample2">
                                <div class="card">
                                    <div class="card-header" id="headingFour">
                                        <h3 class="title" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            <span>How often do you update your collection?</span>
                                            <span class="icon"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                                        </h3>
                                    </div>
                                    <div id="collapseFour" class="collapse accordion-collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample2">
                                        <div class="card-body">
                                            <p>We update our collection regularly to include the latest releases and trending titles. Our team of book enthusiasts is constantly on the lookout for new and exciting books to add to our shelves.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingFive">
                                        <h3 class="title" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            <span>Can I suggest a book for your collection?</span>
                                            <span class="icon"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                                        </h3>
                                    </div>
                                    <div id="collapseFive" class="collapse accordion-collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample2">
                                        <div class="card-body">
                                            <p>Yes, we welcome suggestions from our customers! If there's a particular book you think should be part of our collection, feel free to reach out to us through our contact form. We'll do our best to add it to our inventory.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingSix">
                                        <h3 class="title" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                            <span>Do you offer discounts on bulk purchases?</span>
                                            <span class="icon"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                                        </h3>
                                    </div>
                                    <div id="collapseSix" class="collapse accordion-collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample2">
                                        <div class="card-body">
                                            <p>We do offer discounts on bulk purchases. For more details on bulk pricing and special offers, please contact our sales team. We're happy to provide customized quotes for schools, libraries, and other institutions.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FAQ Content End -->

    <!-- Feature Box -->
    @include('Frontend/Main/HappyCustomer/happyCustomer')
    <!-- Feature Box End -->

    <!-- Newsletter -->
    @include('Frontend/Main/Newsletter/newsLetter')
    <!-- Newsletter End -->
</div>

@endsection
