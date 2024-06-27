
<!--Swiper Banner Start -->
<div class="main-slider style-1">
    <div class="main-swiper">
        <div class="swiper-wrapper">
            @foreach ($data['banner'] as $banner)
                <div class="swiper-slide bg-blue" style="background-image: url({{ asset('assets/frontend/images/background/waveElement.png')}});">
                    <div class="container">
                        <div class="banner-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="swiper-content">
                                        <div class="content-info">
                                            <h6 class="sub-title" data-swiper-parallax="-10">BEST MANAGEMENT </h6>
                                            <h1 class="title mb-0" data-swiper-parallax="-20">{{$banner->title}}</h1>
                                            <ul class="dz-tags" data-swiper-parallax="-30">
                                                @foreach ($banner->category as $cat)
                                                    {{-- show max 3 tags --}}
                                                    @if ($loop->index < 3)
                                                        <li><a href="javascript:void(0);">{{$cat->name}}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <p class="text mb-0" data-swiper-parallax="-40">
                                                {{ Str::limit($banner->description, 200) }}
                                            </p>
                                            <div class="price" data-swiper-parallax="-50">
                                                @if ($banner->discounted_price)
                                                    <span class="price-num">£{{ $banner->discounted_price }}</span>
                                                    <del>£{{ $banner->sale_price }}</del>
                                                    <span class="badge badge-danger">
                                                        @if ($banner->discount_type == 'percentage')
                                                            {{-- Calculate and display percentage discount --}}
                                                            @php
                                                                $discountPercentage = 100 - (($banner->discounted_price / $banner->sale_price) * 100);
                                                            @endphp
                                                            {{ round($discountPercentage, 2) }}% OFF
                                                        @elseif ($banner->discount_type == 'fixed')
                                                            {{-- Calculate and display fixed discount --}}
                                                            @php
                                                                $discountAmount = $banner->sale_price - $banner->discounted_price;
                                                            @endphp
                                                            £{{ number_format($discountAmount, 2) }} OFF
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="price-num">£{{ $banner->sale_price }}</span>
                                                @endif

                                            </div>
                                            <div class="content-btn" data-swiper-parallax="-60">
                                                <a class="btn btn-primary btnhover" href="books-grid-view.html">Buy Now</a>
                                                <a class="btn border btnhover ms-4 text-white" href="books-detail.html">See Details</a>

                                                <!-- Love Icon -->
                                                <a href="javascript:void(0);" class="btn btn-outline-danger btnhover add-to-wishlist @if($banner->isInWishlist) active @endif" data-id="{{ $banner->id }}" data-type="large">
                                                    <i class="flaticon-heart"></i>
                                                </a>
                                                <!-- Love Icon -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="banner-media" data-swiper-parallax="-100">
                                        <img src="{{ $banner->image_path }}" alt="banner-media" style=" height: 735px; ">
                                    </div>
                                    <img class="pattern" src="{{ asset('assets/frontend/images/Group.png')}}" data-swiper-parallax="-100" alt="dots">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="container swiper-pagination-wrapper">
            <div class="swiper-pagination-five"></div>
        </div>
    </div>
    <div class="swiper main-swiper-thumb">
        <div class="swiper-wrapper">
            @foreach ($data['bannerSmall'] as $bannerSmall)
                <div class="swiper-slide">
                    <div class="books-card">
                        <div class="dz-media">
                            <img src="{{ $bannerSmall->image_path }}" alt="book" style="width: 250px; height: 110px !important;">
                        </div>
                        <div class="dz-content">
                            <h5 class="title mb-0">{{ $bannerSmall->title }}</h5>
                            <div class="dz-meta">
                                <ul>
                                    <li>
                                        {{ $bannerSmall->author->first_name }} {{ $bannerSmall->author->last_name }}
                                    </li>
                                </ul>
                            </div>
                            <div class="book-footer">
                                <div class="price">
                                    <span class="price-num">
                                        @if ($bannerSmall->discounted_price)
                                            £{{ $bannerSmall->discounted_price }}
                                        @else
                                            £{{ $bannerSmall->sale_price }}
                                        @endif
                                    </span>
                                </div>
                                <div class="rate">
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < $bannerSmall->rating)
                                            <i class="flaticon-star text-yellow"></i>
                                        @else
                                            <i class="flaticon-star text-muted"></i>
                                        @endif
                                    @endfor
                                </div>
                                <!-- Love Icon -->
                                <a href="javascript:void(0);" class="btn-outline-danger btnhover add-to-wishlist @if($bannerSmall->isInWishlist) active @endif"
                                    data-id="{{ $bannerSmall->id }}">
                                    <i class="flaticon-heart"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!--Swiper Banner End-->
