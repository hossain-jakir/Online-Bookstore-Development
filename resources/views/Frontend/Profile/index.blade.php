@extends('Frontend/Main/index')

@section('title', auth()->user()->first_name . ' ' . auth()->user()->last_name)

@section('content')

<!-- Content -->
<div class="page-content bg-white">
    <!-- contact area -->
    <div class="content-block">
        <!-- Browse Jobs -->
        <section class="content-inner bg-white">
            <div class="container">
                <div class="row">
                    @include('Frontend/Profile/profile-menu')
                    <div class="col-xl-9 col-lg-8 m-b30">
                        <div class="shop-bx shop-profile">
                            <div class="shop-bx-title clearfix">
                                <h5 class="text-uppercase">Basic Information</h5>
                            </div>
                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row m-b30">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="formcontrolinput1" class="form-label">First Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="first_name" id="formcontrolinput1" placeholder="First Name" value="{{ Auth::user()->first_name }}" autocomplete="first_name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="formcontrolinput2" class="form-label">Last Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="last_name" id="formcontrolinput2" placeholder="Last Name" value="{{ Auth::user()->last_name }}" autocomplete="last_name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="formcontrolinput3" class="form-label">Age: <span class="text-danger">*</span></label>
                                            <input class="form-control" id="formcontrolinput3" placeholder="Age" value="{{ Auth::user()->dob }}" type="date" name="dob" required max="{{ date('Y-m-d') }}" min="1900-01-01">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="formcontrolinput4" class="form-label">Contact Number: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="formcontrolinput4" placeholder="Contact Number" value="{{ Auth::user()->phone }}" name="phone" autocomplete="phone" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="formcontrolinput5" class="form-label">Email Address: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="formcontrolinput5" placeholder="Email Address" value="{{ Auth::user()->email }}" name="email" autocomplete="email" required>
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
                            <div class="shop-bx-title clearfix">
                                <h5 class="text-uppercase">Password Change</h5>
                            </div>
                            <form method="POST" action="{{ route('profile.password.update') }}">
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Browse Jobs END -->
    </div>
</div>
<!-- Content END-->

@endsection
