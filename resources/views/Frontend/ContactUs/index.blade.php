@extends('Frontend/Main/index')

@section('title', 'Contact Us')

@section('content')

<div class="page-content">
    <!-- inner page banner -->
    <div class="dz-bnr-inr overlay-secondary-dark dz-bnr-inr-sm" style="background-image:url({{asset('assets/frontend/images/background/bg3.jpg')}});">
        <div class="container">
            <div class="dz-bnr-inr-entry">
                <h1>Contact</h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> Home</a></li>
                        <li class="breadcrumb-item">Contact</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="content-inner-2 pt-0">
        <div class="map-iframe">
            @php
                $latitude = $data['shop']->latitude ?? 51.4835532;
                $longitude = $data['shop']->longitude ?? -3.1672832;
                $iframe = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6305.217186520197!2d$longitude!3d$latitude!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTHCNDgzNTUzLTIuMTY3MjgzMjUgMTnCsDUzJzQ4LjIwMDEyLCBOQkUgTMOqcmnFnw!5e0!3m2!1sen!2suk!4v1625045835101";
            @endphp
            <iframe src="{{ $iframe }}" style="border:0; width:100%; min-height:100%; margin-bottom: -8px;" allowfullscreen></iframe>
        </div>
    </div>

    <section class="contact-wraper1" style="background-image: url({{asset('assets/frontend/images/background/bg2.jpg')}});">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="contact-info">
                        <div class="section-head text-white style-1">
                            <h3 class="title text-white">Get In Touch</h3>
                            <p>If you are interested in working with us, please get in touch.</p>
                        </div>
                        <ul class="no-margin">
                            <li class="icon-bx-wraper text-white left m-b30">
                                <div class="icon-md">
                                    <span class="icon-cell text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    </span>
                                </div>
                                <div class="icon-content">
                                    <h5 class=" dz-tilte text-white">Our Address</h5>
                                    <p>{{ $data['shop']->address }}</p>
                                </div>
                            </li>
                            <li class="icon-bx-wraper text-white left m-b30">
                                <div class="icon-md">
                                    <span class="icon-cell text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    </span>
                                </div>
                                <div class="icon-content">
                                    <h5 class="dz-tilte text-white">Our Email</h5>
                                    <p>{{ $data['shop']->email }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7 m-b40">
                    <div class="contact-area1 m-r20 m-md-r0">
                        <div class="section-head style-1">
                            <h6 class="sub-title text-primary">CONTACT US</h6>
                            <h3 class="title m-b20">Get In Touch With Us</h3>
                        </div>
                        <form class="" method="POST" action="{{ route('contact-us.send') }}">
                            @csrf
                            <div class="dzFormMsg">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                            </div>
                            <div class="input-group">
                                <input required type="text" class="form-control" name="name" placeholder="Full Name" value="{{ old('name', auth()->user() ? auth()->user()->first_name . ' ' . auth()->user()->last_name : '') }}">
                            </div>
                            <div class="input-group">
                                <input required type="text" class="form-control" name="email" placeholder="Email Adress" value="{{ old('email', auth()->user() ? auth()->user()->email : '') }}">
                            </div>
                            <div class="input-group">
                                <input required type="text" class="form-control" name="phone" placeholder="Phone No." value="{{ old('phone', auth()->user() ? auth()->user()->phone ?? '' : '') }}">
                            </div>
                            <div class="input-group">
                                <textarea required name="message" rows="5" class="form-control" placeholder="Message">{{ old('message') }}</textarea>
                            </div>
                            <div>
                                <button type="submit" class="btn w-100 btn-primary btnhover">SUBMIT</button>
                            </div>
                        </form>
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
