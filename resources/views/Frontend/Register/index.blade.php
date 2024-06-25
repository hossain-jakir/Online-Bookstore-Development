@extends('Frontend/Main/index')

@section('title', 'About Us')

@section('content')

<div class="page-content">
    <!-- inner page banner -->
    <div class="dz-bnr-inr overlay-secondary-dark dz-bnr-inr-sm" style="background-image:url({{ asset('assets/frontend/images//background/bg3.jpg')}});">
        <div class="container">
            <div class="dz-bnr-inr-entry">
                <h1>Registration</h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"> Home</a></li>
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
                        <form>
                            <h4 class="text-secondary">Registration</h4>
                            <p class="font-weight-600">If you don't have an account with us, please Registration.</p>
                            <div class="mb-4">
                                <label class="label-title">First Name <span class="text-danger">*</span></label>
                                <input name="first_name" required="" class="form-control" placeholder="First Name" type="text">
                            </div>
                            <div class="mb-4">
                                <label class="label-title">Last Name <span class="text-danger">*</span></label>
                                <input name="last_name" required="" class="form-control" placeholder="Last Name" type="text">
                            </div>
                            <div class="mb-4">
                                <label class="label-title">Email address <span class="text-danger">*</span></label>
                                <input name="email" required="" class="form-control" placeholder="Type Email" type="email">
                            </div>
                            <div class="mb-4">
                                <label class="label-title">Password <span class="text-danger">*</span></label>
                                <input name="password" required="" class="form-control" placeholder="Password" type="password">
                            </div>
                            <div class="mb-4">
                                <label class="label-title">Confirm Password <span class="text-danger">*</span></label>
                                <input name="confirm_password" required="" class="form-control" placeholder="Confirm Password" type="password">
                            </div>
                            <div class="mb-5">
                                <small>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="privacy-policy.html">privacy policy</a>.</small>
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
