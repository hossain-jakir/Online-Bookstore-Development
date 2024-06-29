<!-- Header -->
<header class="site-header mo-left header style-1">
    <!-- Main Header -->
    <div class="header-info-bar">
        <div class="container clearfix">
            <!-- Website Logo -->
            <div class="logo-header logo-dark">
                <a href="{{ route('home') }}"><img src="{{ asset('assets/frontend/images/logo.png')}}" alt="logo"></a>
            </div>

            <!-- EXTRA NAV -->
            <div class="extra-nav">
                <div class="extra-cell">
                    <ul class="navbar-nav header-right">

                        <!-- Header Wishlist -->
                        @include('Frontend/Main/Header/wishlist')
                        <!-- Header Wishlist -->

                        <!-- Header Cart -->
                        @include('Frontend/Main/Header/cart')
                        <!-- Header Cart -->

                        <!-- Header Account -->
                        @include('Frontend/Main/Header/account')
                        <!-- Header Account -->
                    </ul>
                </div>
            </div>

            <!-- header search nav -->
            <div class="header-search-nav">
                <div class="header-item-search">
                    <div class="input-group search-input">
                        <select class="default-select">
                            <option>Category</option>
                            @foreach ( $data['categories'] as $category )
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Search Books Here">
                        <button class="btn" type="button"><i class="flaticon-loupe"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Header End -->

    <!-- Main Header -->
    @include('Frontend/Main/Menu/menu')
    <!-- Main Header End -->

</header>
<!-- Header End -->
