<!-- Main Header -->
<div class="sticky-header main-bar-wraper navbar-expand-lg">
    <div class="main-bar clearfix">
        <div class="container clearfix">
            <!-- Website Logo -->
            <div class="logo-header logo-dark">
                <a href="{{ route('home') }}"><img src="{{ asset('assets/frontend/images/logo.png')}}" alt="logo"></a>
            </div>

            <!-- Nav Toggle Button -->
            <button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- EXTRA NAV -->
            <div class="extra-nav">
                <div class="extra-cell">
                    <a href="{{ route('contact-us') }}" class="btn btn-primary btnhover">Get In Touch</a>
                </div>
            </div>

            <!-- Main Nav -->
            <div class="header-nav navbar-collapse collapse justify-content-start" id="navbarNavDropdown">
                <div class="logo-header logo-dark">
                    <a href="{{ route('home') }}"><img src="{{ asset('assets/frontend/images/logo.png')}}" alt=""></a>
                </div>
                <div class="search-input">
                    <div class="input-group">
                        <input type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Search Books Here">
                        <button class="btn" type="button"><i class="flaticon-loupe"></i></button>
                    </div>
                </div>
                <ul class="nav navbar-nav">
                    <li>
                        <a href="/">
                            <span>Home</span>
                        </a>
                    </li>
                    <li><a href="{{ route('book.index') }}"><span>Books</span></a></li>
                    <li class="sub-menu-down"><a href="javascript:void(0);"><span>Categories</span></a>
                        <ul class="sub-menu">
                            @foreach($data['categories'] as $category)
                                @if ($loop->index < 5)
                                    <li><a href="{{ URL::TO($category->slug) }}">{{ $category->name }}</a></li>
                                @endif
                                @if ($loop->index == 5)
                                    <li><a href="{{ route('category.all') }}">Show More...</a></li>

                                @endif
                            @endforeach
                        </ul>
                    </li>
                    <li class="sub-menu-down"><a href="javascript:void(0);"><span>Authors</span></a>
                        <ul class="sub-menu">
                            @foreach($data['authors'] as $menuAuthor)
                                @if ($loop->index < 5)
                                    <li><a href="{{ route('author.show', $menuAuthor->id) }}">{{ $menuAuthor->first_name }} {{ $menuAuthor->last_name }}</a></li>
                                @endif
                                @if ($loop->index == 5)
                                    <li><a href="{{ route('author.all') }}">Show More...</a></li>

                                @endif
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{ route('about-us') }}"><span>About Us</span></a></li>
                    <li class="sub-menu-down"><a href="javascript:void(0);"><span>Others</span></a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('faq')}}">FAQ's</a></li>
                            <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="dz-social-icon">
                    <ul>
                        <li><a class="fab fa-facebook-f" target="_blank" href="https://www.facebook.com/dexignzone"></a></li>
                        <li><a class="fab fa-twitter" target="_blank" href="https://twitter.com/dexignzones"></a></li>
                        <li><a class="fab fa-linkedin-in" target="_blank" href="https://www.linkedin.com/showcase/3686700/admin/"></a></li>
                        <li><a class="fab fa-instagram" target="_blank" href="https://www.instagram.com/website_templates__/"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Header End -->
