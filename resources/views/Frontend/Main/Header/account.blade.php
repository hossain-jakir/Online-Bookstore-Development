<li class="nav-item dropdown profile-dropdown  ms-4">
    @if (Auth::check())
        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ \App\Services\ServeImage::image(Auth::user()->image,'default') }}" alt="">
            <div class="profile-info">
                <h6 class="title">{{ Auth::user()->last_name }}</h6>
                <span>{{ Auth::user()->email }}</span>
            </div>
        </a>

        <div class="dropdown-menu py-0 dropdown-menu-end">
            <div class="dropdown-header">
                <h6 class="m-0">Hello, {{ Auth::user()->last_name }}</h6>
                <span>{{ Auth::user()->email }}</span>
            </div>
            <div class="dropdown-body">
                <a href="{{ route('profile.index') }}" class="dropdown-item d-flex justify-content-between align-items-center ai-icon">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 24 24" width="20px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2m0 10c2.7 0 5.8 1.29 6 2H6c.23-.72 3.31-2 6-2m0-12C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        <span class="ms-2">Profile</span>
                    </div>
                </a>
                <a href="{{ route('profile.orders')}}" class="dropdown-item d-flex justify-content-between align-items-center ai-icon">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 24 24" width="20px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
                        <span class="ms-2">My Order</span>
                    </div>
                </a>
                <a href="{{ route('cart.index')}}" class="dropdown-item d-flex justify-content-between align-items-center ai-icon">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 24 24" width="20px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 14H4V8h16v9zm-8-2c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                        <span class="ms-2">My Cart</span>
                    </div>
                </a>
                <a href="{{ route('wishlist.index')}}" class="dropdown-item d-flex justify-content-between align-items-center ai-icon">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 24 24" width="20px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg>
                        <span class="ms-2">Wishlist</span>
                    </div>
                </a>

            </div>
            <div class="dropdown-footer">
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                    <a class="btn btn-primary w-100 btnhover btn-sm" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Sign Out</a>
                </form>
            </div>
        </div>
    @else
        <a class="btn btn-primary btnhover" href="{{ route('login') }}" role="button">Login</a>

    @endif


</li>
