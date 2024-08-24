<div class="col-xl-3 col-lg-4 m-b30">
    <div class="sticky-top">
        <div class="shop-account">
            <div class="account-detail text-center">
                <div class="my-image">
                    <img alt="" src="{{ $data['user']->image }}" style="width: 250px !important; height: 147px !important;">
                </div>
                <div class="account-title">
                    <div class="">
                        <h4 class="m-b5">{{ $data['user']->first_name }} {{ $data['user']->last_name }}</hjson></h4>
                    </div>
                </div>
            </div>
            <ul>
                <li>
                    <a href="{{ route('backend.user.details',$data['user']->id) }}" @if (Route::currentRouteName() == 'backend.user.details') class="active" @endif>
                        <i class="far fa-user" aria-hidden="true"></i>
                    <span>Profile</span></a>
                </li>
                <li>
                    <a href="{{ route('backend.user.details.order',$data['user']->id) }}" @if (Route::currentRouteName() == 'backend.user.details.order') class="active" @endif>
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    <span>Order</span></a>
                </li>
                <li>
                    <a href="{{ route('backend.user.details.address', $data['user']->id) }}" @if (Route::currentRouteName() == 'profile.address') class="active" @endif>
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <span>Address</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
