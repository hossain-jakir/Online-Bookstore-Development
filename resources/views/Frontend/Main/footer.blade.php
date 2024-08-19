<!-- Footer -->
<footer class="site-footer style-1">
    <!-- Footer Category -->
    <div class="footer-category">
        <div class="container">
            <div class="category-toggle">
                <a href="javascript:void(0);" class="toggle-btn">Books categories</a>
                <div class="toggle-items row">
                    <div class="footer-col-book">
                        <ul>
                            @foreach ($data['categories'] as $footerCategory)
                                @if ($loop->index < 24)
                                    <li>
                                        <a href="{{ URL::to($footerCategory->slug) }}">
                                            {{ $footerCategory->name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Category End -->

    <!-- Footer Top -->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="widget widget_about">
                        <div class="footer-logo logo-white">
                            <a href="{{ route('home') }}"><img src="{{ Storage::url($data['shop']->logo) }}" alt="{{ $data['shop']->name }}"></a>
                        </div>
                        <p class="text">
                            {{ $data['shop']->short_description }}
                        </p>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="widget widget_services">
                        <h5 class="footer-title">Our Links</h5>
                        <ul>
                            <li><a href="{{ route('about-us') }}">About us</a></li>
                            <li><a href="{{ route('contact-us') }}">Contact us</a></li>
                            <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-sm-4 col-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="widget widget_services">
                        <h5 class="footer-title">Bookland ?</h5>
                        <ul>
                            <li><a href="{{ route('home') }}">Bookland</a></li>
                            <li><a href="{{ route('book.index') }}">Shop</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-4 wow fadeInUp" data-wow-delay="0.4s">
                    {{-- <div class="widget widget_services">
                        <h5 class="footer-title">Resources</h5>
                        <ul>
                            <li><a href="services.html">Download</a></li>
                            <li><a href="help-desk.html">Help Center</a></li>
                            <li><a href="shop-cart.html">Shop Cart</a></li>
                            <li><a href="shop-login.html">Login</a></li>
                            <li><a href="about-us.html">Partner</a></li>
                        </ul>
                    </div> --}}
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="widget widget_getintuch">
                        <h5 class="footer-title">Get in Touch With Us</h5>
                        <ul>
                            <li>
                                <i class="flaticon-placeholder"></i>
                                <span>{{ $data['shop']->address }}</span>
                            </li>
                            <li>
                                <i class="flaticon-phone"></i>
                                <span>
                                    {{ $data['shop']->phone }}
                                </span>
                            </li>
                            <li>
                                <i class="flaticon-email"></i>
                                <span>
                                    {{ $data['shop']->email }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Top End -->

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row fb-inner">
                <div class="col-lg-6 col-md-12 text-start">
                    <p class="copyright-text">{{ $data['shop']->name }} - © {{ date('Y') }} All Rights Reserved</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Bottom End -->

</footer>
<!-- Footer End -->
