<!-- Feature Product -->
<section class="content-inner-1 bg-grey reccomend">
    <div class="container">
        <div class="section-head text-center">
            <div class="circle style-1"></div>
            <h2 class="title">Featured Product</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris </p>
        </div>
    </div>
    <div class="container">
        <div class="swiper-container books-wrapper-2 swiper-three">
            <div class="swiper-wrapper">
                @foreach ($data['featured'] as $feature)
                <div class="swiper-slide">
                    <div class="books-card style-2">
                        <div class="dz-media">
                            <img src="{{ $feature->image_path }}" alt="book" style="height: 471px;">
                        </div>
                        <div class="dz-content">
                            <h6 class="sub-title">BEST SELLER</h6>
                            <h2 class="title" style="font-size: -webkit-xxx-large;">
                                {{ $feature->title }}
                            </h2>
                            <ul class="dz-tags">
                                @foreach ($feature->category as $category)
                                    {{-- max 3 categories --}}
                                    @if ($loop->index < 3)
                                        <li>{{ $category->name }}</li>
                                    @endif
                                @endforeach
                            </ul>
                            <p class="text">
                                {{ Str::limit($feature->description, 200) }}
                            </p>
                            <div class="price">
                                @if ($feature->discounted_price)
                                    <span class="price-num">£{{ $feature->discounted_price }}</span>
                                    <del>£{{ $feature->sale_price }}</del>
                                    <span class="badge badge-danger">
                                        @if ($feature->discount_type == 'percentage')
                                            {{-- Calculate and display percentage discount --}}
                                            @php
                                                $discountPercentage = 100 - (($feature->discounted_price / $feature->sale_price) * 100);
                                            @endphp
                                            {{ round($discountPercentage, 2) }}% OFF
                                        @elseif ($feature->discount_type == 'fixed')
                                            {{-- Calculate and display fixed discount --}}
                                            @php
                                                $discountAmount = $feature->sale_price - $feature->discounted_price;
                                            @endphp
                                            £{{ number_format($discountAmount, 2) }} OFF
                                        @endif
                                    </span>
                                @else
                                    <span class="price-num">£{{ $feature->sale_price }}</span>
                                @endif
                            </div>
                            <div class="bookcard-footer">
                                <a href="shop-cart.html" class="btn btn-primary btnhover m-t15 m-r10">Buy Now</a>
                                <a href="{{ route('book.show', ['id' => base64_encode($feature->id)]) }}" class="btn btn-outline-secondary btnhover m-t15">See Details</a>

                                <!-- Love Icon -->
                                <a href="javascript:void(0);" class="btn btn-outline-danger btnhover add-to-wishlist @if($feature->isInWishlist) active @endif" data-id="{{ $feature->id }}" data-type="large" style="margin-top: 15px;">
                                    <i class="flaticon-heart"></i>
                                </a>
                                <!-- Love Icon -->
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            <div class="pagination-align style-2">
                <div class="swiper-button-prev"><i class="fa-solid fa-angle-left"></i></div>
                <div class="swiper-pagination-three"></div>
                <div class="swiper-button-next"><i class="fa-solid fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</section>
<!-- Feature Product End -->
