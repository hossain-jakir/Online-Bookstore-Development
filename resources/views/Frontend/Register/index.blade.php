@extends('Frontend/Main/index')

@section('title', 'Registration')

@section('content')

<div class="page-content">
    <!-- inner page banner -->
    <div class="dz-bnr-inr overlay-secondary-dark dz-bnr-inr-sm" style="background-image:url({{ asset('assets/frontend/images//background/bg3.jpg')}});">
        <div class="container">
            <div class="dz-bnr-inr-entry">
                <h1>Registration</h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"> Home</a></li>
                        <li class="breadcrumb-item">Registration</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- inner page banner End-->

    <!-- contact area -->
    <section class="content-inner shop-account">
        <!-- Product -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-6 mb-4">
                    <div class="login-area">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <h4 class="text-secondary">Registration</h4>
                            <p class="font-weight-600">If you don't have an account with us, please Registration.</p>
                            <div class="mb-4">
                                <label class="label-title">First Name <span class="text-danger">*</span></label>
                                <input name="first_name"  class="form-control" placeholder="First Name" type="text" value="{{ old('first_name') }}" required autofocus autocomplete="first_name">

                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <label class="label-title">Last Name <span class="text-danger">*</span></label>
                                <input name="last_name" class="form-control" placeholder="Last Name" type="text" value="{{ old('last_name') }}" required autofocus autocomplete="last_name">

                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <label class="label-title">Email address <span class="text-danger">*</span></label>
                                <input name="email" class="form-control" placeholder="Type Email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email">

                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <label class="label-title">Date of Birth <span class="text-danger">*</span></label>
                                <input name="dob" class="form-control" placeholder="Date of Birth" type="date" value="{{ old('dob') }}" required autofocus autocomplete="dob">

                                <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <label class="label-title">Password <span class="text-danger">*</span></label>
                                <input name="password" class="form-control" placeholder="Password" type="password" required autocomplete="new-password">

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <label class="label-title">Confirm Password <span class="text-danger">*</span></label>
                                <input name="password_confirmation" class="form-control" placeholder="Confirm Password" type="password" required autocomplete="new-password">

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <div class="mb-5">
                                <small>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="{{ route('privacy-policy')}}">privacy policy</a>.</small>
                            </div>
                            <div class="text-left">
                                <button class="btn btn-primary btnhover w-100 me-2">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product END -->
    </section>
    <!-- contact area End-->
</div>

@endsection
