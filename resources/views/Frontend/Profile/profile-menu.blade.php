<div class="col-xl-3 col-lg-4 m-b30">
    <div class="sticky-top">
        <div class="shop-account">
            <div class="account-detail text-center">
                <div class="my-image">
                    <img alt="" src="{{ $data['user']->image }}" style="width: 250px !important; height: 147px !important;">
                </div>
                <div class="account-title">
                    <div class="">
                        <h4 class="m-b5">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</hjson></h4>
                    </div>
                </div>
            </div>
            <ul>
                <li>
                    <a href="{{ route('profile.index') }}" @if (Route::currentRouteName() == 'profile.index') class="active" @endif>
                        <i class="far fa-user" aria-hidden="true"></i>
                    <span>Profile</span></a>
                </li>
                <li>
                    <a href="{{ route('profile.orders') }}" @if (Route::currentRouteName() == 'profile.orders' || Route::currentRouteName() == 'profile.order.show') class="active" @endif>
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    <span>My Order</span></a>
                </li>
                <li>
                    <a href="{{ route('profile.address') }}" @if (Route::currentRouteName() == 'profile.address') class="active" @endif>
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <span>My Address</span></a>
                </li>
                <li>
                    <a href="{{ route('cart.index')}}"><i class="flaticon-shopping-cart-1"></i>
                    <span>My Cart</span></a>
                </li>
                <li>
                    <a href="{{ route('wishlist.index')}}"><i class="far fa-heart" aria-hidden="true"></i>
                    <span>Wishlist</span></a>
                </li>
                <li>
                    <a href="{{ route('privacy-policy') }}"><i class="fa fa-key" aria-hidden="true"></i>
                    <span>Privacy Policy</span></a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a onclick="event.preventDefault(); this.closest('form').submit();"><i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                            <span style="color: black; cursor: pointer;">Log Out</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
