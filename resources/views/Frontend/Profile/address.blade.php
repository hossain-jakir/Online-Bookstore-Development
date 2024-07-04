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
                                <h5 class="text-uppercase">My Addresses</h5>
                            </div>
                            <div class="address-bx">
                                @forelse ($data['address'] as $address)
                                    <div class="address-info border p-3 mb-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5>Title</h5>
                                                <p>{{ $address->title }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>First Name</h5>
                                                <p>{{ $address->first_name }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>Last Name</h5>
                                                <p>{{ $address->last_name }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Address Line 1</h5>
                                                <p>{{ $address->address_line_1 }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>Address Line 2</h5>
                                                <p>{{ $address->address_line_2 ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>City</h5>
                                                <p>{{ $address->city }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>State</h5>
                                                <p>{{ $address->state }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Zip Code</h5>
                                                <p>{{ $address->zip_code }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>Country</h5>
                                                <p>{{ $address->country }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Phone</h5>
                                                <p>{{ $address->phone_number }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>Type</h5>
                                                <p>{{ ucfirst($address->type) }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Default Address</h5>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="default_address" id="default_{{ $address->id }}" value="{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="default_{{ $address->id }}">
                                                        {{ $address->is_default ? 'Yes' : 'No' }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <form method="POST" action="{{ route('profile.address.delete', $address->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-danger btnhover" onclick="return confirm('Are you sure you want to delete this address?')">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-warning">
                                        No addresses found. Please add a new address.
                                    </div>
                                @endforelse
                            </div>

                            <div class="shop-bx-title clearfix">
                                <h5 class="text-uppercase">Add New Address</h5>
                            </div>
                            <form method="POST" action="{{ route('profile.address.store') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="title" name="title" required placeholder="Home, Office, etc." value="{{ old('title') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" required placeholder="First name" value="{{ old('first_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" required placeholder="Last name" value="{{ old('last_name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="address_line_1" class="form-label">Address Line 1: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="address_line_1" name="address_line_1" required placeholder="House number, street name, etc." value="{{ old('address_line_1') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="address_line_2" class="form-label">Address Line 2:</label>
                                            <input type="text" class="form-control" id="address_line_2" name="address_line_2" placeholder="Apartment, suite, unit, etc." value="{{ old('address_line_2') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="city" class="form-label">City: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="city" name="city" required placeholder="City, town, etc." value="{{ old('city') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="state" class="form-label">State: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="state" name="state" required placeholder="State, province, etc." value="{{ old('state') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="zip_code" class="form-label">Zip Code: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="zip_code" name="zip_code" required placeholder="Postal code, ZIP code, etc." value="{{ old('zip_code') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Country: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="country" name="country" required placeholder="Country name" value="{{ old('country') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone_number" class="form-label">Phone Number: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="phone_number" name="phone_number" required placeholder="Phone number" value="{{ old('phone_number') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Type: <span class="text-danger">*</span></label>
                                            <select class="form-control" id="type" name="type" required>
                                                <option value="shipping" @if (old('type') == 'shipping') selected @endif>Shipping</option>
                                                <option value="billing" @if (old('type') == 'billing') selected @endif>Billing</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-check mb-3">
                                            <input type="checkbox" class="form-check-input" id="is_default" name="is_default" value="1" @if (old('is_default')) checked @endif>
                                            <label for="is_default" class="form-check-label">Set as default address</label>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btnhover">Add Address</button>
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

@section('addScript')
<script>
    $(document).ready(function() {
        $('input[type=radio][name=default_address]').change(function() {
            var addressId = $(this).val();
            $.ajax({
                url: "{{ route('profile.address.default') }}",
                type: 'POST',
                data: {
                    address_id: addressId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == 'success') {
                        toastr.success(response.message);

                        // Update the UI for the radio buttons
                        $('input[type=radio][name=default_address]').each(function() {
                            if ($(this).val() == addressId) {
                                $(this).prop('checked', true);
                                $(this).closest('.address-info').find('.form-check-label').text('Yes');
                            } else {
                                $(this).prop('checked', false);
                                $(this).closest('.address-info').find('.form-check-label').text('No');
                            }
                        });

                        // Select the previous default address if exists
                        var previousDefaultId = response.previous_default_id;
                        if (previousDefaultId !== null) {
                            $('input[type=radio][name=default_address][value="' + previousDefaultId + '"]')
                                .prop('checked', true)
                                .closest('.address-info')
                                .find('.form-check-label')
                                .text('No');
                        }
                    } else {
                        toastr.error(response.message);
                        // Handle error case if needed
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while updating the default address.');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

@endsection
