@extends('Backend.layouts.master')

@section('title', 'Shop')

@section('content')
<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Shop </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Shop</li>
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
    <section class="content mb-5">
        <div class="container-fluid mb-2">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('backend.shop.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Shop Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $shop->name) }}">
                        </div>

                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control-file" id="logo" name="logo">
                            @if($shop->logo)
                                <img src="{{ Storage::url($shop->logo) }}" alt="{{ $shop->name }} Logo" style="max-width: 100px;">
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="favicon">Favicon</label>
                            <input type="file" class="form-control-file" id="favicon" name="favicon">
                            @if($shop->favicon)
                                <img src="{{ Storage::url($shop->favicon) }}" alt="{{ $shop->name }} Favicon" style="max-width: 50px;">
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $shop->address) }}">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $shop->phone) }}">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $shop->email) }}">
                        </div>

                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude', $shop->latitude) }}">
                        </div>

                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude', $shop->longitude) }}">
                        </div>

                        <div class="form-group">
                            <label for="short_description">Short Description</label>
                            <textarea class="form-control" id="short_description" name="short_description">{{ old('short_description', $shop->short_description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="url" class="form-control" id="website" name="website" value="{{ old('website', $shop->website) }}">
                        </div>

                        <div class="form-group">
                            <label for="facebook">Facebook</label>
                            <input type="url" class="form-control" id="facebook" name="facebook" value="{{ old('facebook', $shop->facebook) }}">
                        </div>

                        <div class="form-group">
                            <label for="twitter">Twitter</label>
                            <input type="url" class="form-control" id="twitter" name="twitter" value="{{ old('twitter', $shop->twitter) }}">
                        </div>

                        <div class="form-group">
                            <label for="instagram">Instagram</label>
                            <input type="url" class="form-control" id="instagram" name="instagram" value="{{ old('instagram', $shop->instagram) }}">
                        </div>

                        <div class="form-group">
                            <label for="linkedin">LinkedIn</label>
                            <input type="url" class="form-control" id="linkedin" name="linkedin" value="{{ old('linkedin', $shop->linkedin) }}">
                        </div>

                        <div class="form-group">
                            <label for="whatsapp">WhatsApp</label>
                            <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $shop->whatsapp) }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Shop</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@endsection
