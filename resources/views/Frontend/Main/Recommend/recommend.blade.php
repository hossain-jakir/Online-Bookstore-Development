<!--Recommend Section Start-->
<section class="content-inner-1 bg-grey reccomend">

    <div class="container">
        <div class="section-head text-center">
            <h2 class="title">Recomended For You</h2>
            <p>
                We have a wide range of books for you to choose from. Here are some of the books that we recommend for you.
            </p>
        </div>
        <!-- Swiper -->
        <div class="swiper-container swiper-two">
            <div class="swiper-wrapper">
                @foreach ($data['recommended'] as $recommended)
                    <div class="swiper-slide">
                        <div class="books-card style-1 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="dz-media">
                                <a href="{{ route('book.show', ['id' => base64_encode($recommended->id)]) }}">
                                    <img src="{{ $recommended->image_path }}" alt="book" style="height: 300px;">
                                </a>
                            </div>
                            <div class="dz-content">
                                <h4 class="title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; font-size: 14px; line-height: 1.2;">
                                    <a href="{{ route('book.show', ['id' => base64_encode($recommended->id)]) }}">{{ $recommended->title }}</a>

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
                                <button class="btn btn-secondary btnhover2 add-to-cart" data-id="{{ base64_encode($recommended->id) }}">
                                    <i class="flaticon-shopping-cart-1 m-r10"></i>
                                    Add To Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
