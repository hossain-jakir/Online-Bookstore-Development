<!--Recommend Section Start-->
<section class="content-inner-1 bg-grey reccomend">

    <div class="container">
        <div class="section-head text-center">
            <h2 class="title">Recomended For You</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris</p>
        </div>
        <!-- Swiper -->
        <div class="swiper-container swiper-two">
            <div class="swiper-wrapper">
                @foreach ($data['recommended'] as $recommended)
                    <div class="swiper-slide">
                        <div class="books-card style-1 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="dz-media">
                                <img src="{{ $recommended->image_path }}" alt="book" style="height: 300px;">
                            </div>
                            <div class="dz-content">
                                <h4 class="title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; font-size: 14px; line-height: 1.2;">
                                    {{ $recommended->title }}
                                </h4>

                                <span class="price">
                                    @if ($recommended->discounted_price)
                                        £{{ $recommended->discounted_price }}
                                    @else
                                        £{{ $recommended->sale_price }}
                                    @endif
                                </span>
                                <!-- Love Icon -->
                                <a href="javascript:void(0);" class="btn btn-outline-danger btnhover add-to-wishlist @if($recommended->isInWishlist) active @endif" data-id="{{ $recommended->id }}" data-type="large">
                                    <i class="flaticon-heart"></i>
                                </a>
                                <!-- Love Icon -->
                                <a href="shop-cart.html" class="btn btn-secondary btnhover2"><i class="flaticon-shopping-cart-1 m-r10"></i> Add to cart</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
