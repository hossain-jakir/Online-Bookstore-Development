@extends('Backend/layouts/master')

@section('title', 'User Details')

@section('page-script')
    <script src="{{ asset('assets/frontend/js/jquery.min.js')}}"></script><!-- JQUERY MIN JS -->
    <script src="{{ asset('assets/frontend/vendor/wow/wow.min.js')}}"></script><!-- WOW JS -->
    <script src="{{ asset('assets/frontend/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script><!-- BOOTSTRAP MIN JS -->
    <script src="{{ asset('assets/frontend/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script><!-- BOOTSTRAP SELECT MIN JS -->
    <script src="{{ asset('assets/frontend/vendor/counter/waypoints-min.js')}}"></script><!-- WAYPOINTS JS -->
    <script src="{{ asset('assets/frontend/vendor/counter/counterup.min.js')}}"></script><!-- COUNTERUP JS -->
    <script src="{{ asset('assets/frontend/vendor/swiper/swiper-bundle.min.js')}}"></script><!-- SWIPER JS -->
    <script src="{{ asset('assets/frontend/js/dz.carousel.js')}}"></script><!-- DZ CAROUSEL JS -->
    <script src="{{ asset('assets/frontend/js/dz.ajax.js')}}"></script><!-- AJAX -->
    <script src="{{ asset('assets/frontend/js/custom.js')}}"></script><!-- CUSTOM JS -->
@endsection

@section('page-style')
<!-- STYLESHEETS -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/icons/fontawesome/css/all.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/swiper/swiper-bundle.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/animate/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/style.css')}}">

<!-- GOOGLE FONTS-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User Details</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.user.index') }}">User</a></li>
                            <li class="breadcrumb-item active">User Details</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        @if ($errors->any() || session('error'))
            @include('Backend._partials.errorMsg')
        @endif

        @if (session('success'))
            @include('Backend._partials.successMsg')
        @endif

        <!-- Main content -->
        <section class="content-inner bg-white" style="padding-top: 50px !important;">
            <div class="container">
                <div class="row">
                    @include('Backend/pages/user/profile-menu')
                    <div class="col-xl-9 col-lg-8 m-b30">
                        <div class="shop-bx shop-profile">
                            <div class="shop-bx-title clearfix">
                                <h5 class="text-uppercase">Basic Information</h5>
                            </div>
                            <form method="POST" action="{{ route('backend.user.details.update', $data['user']->id) }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $data['user']->id }}">
                                <div class="row m-b30">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="formcontrolinput1" class="form-label">First Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="first_name" id="formcontrolinput1" placeholder="First Name" value="{{ $data['user']->first_name }}" autocomplete="first_name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="formcontrolinput2" class="form-label">Last Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="last_name" id="formcontrolinput2" placeholder="Last Name" value="{{ $data['user']->last_name }}" autocomplete="last_name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="formcontrolinput3" class="form-label">Age: <span class="text-danger">*</span></label>
                                            <input class="form-control" id="formcontrolinput3" placeholder="Age" value="{{ $data['user']->dob }}" type="date" name="dob" required max="{{ date('Y-m-d') }}" min="1900-01-01">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="formcontrolinput4" class="form-label">Contact Number: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="formcontrolinput4" placeholder="Contact Number" value="{{ $data['user']->phone }}" name="phone" autocomplete="phone" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="formcontrolinput5" class="form-label">Email Address: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="formcontrolinput5" placeholder="Email Address" value="{{ $data['user']->email }}" name="email" autocomplete="email" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="formcontrolinput6" class="form-label">Image:</label>
                                            <input type="file" class="form-control" id="formcontrolinput6" id="image" name="image">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btnhover">Save Setting</button>
                            </form>
                            @if($data['user']->id == Auth::user()->id)
                            <div class="shop-bx-title clearfix">
                                <h5 class="text-uppercase">Password Change</h5>
                            </div>
                            <form method="POST" action="{{ route('backend.user.details.update.password', $data['user']->id) }}">
                                @csrf
                                <div class="row m-b30">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="formcontrolinput7" class="form-label">Current Password: <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="formcontrolinput7" placeholder="Current Password" name="current_password" autocomplete="current_password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="formcontrolinput8" class="form-label">New Password: <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="formcontrolinput8" placeholder="New Password" name="password" autocomplete="password" required>
                                            <small class="text-muted">Password must be at least 6 characters long</small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="formcontrolinput9" class="form-label">Confirm Password: <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="formcontrolinput9" placeholder="Confirm Password" name="password_confirmation" autocomplete="password_confirmation" required>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btnhover">Change Password</button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Browse Jobs END -->
        <!-- /.content -->
    </div>

@endsection
