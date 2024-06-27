<!-- Special Offer -->
<section class="content-inner-2">
    <div class="container">
        <div class="section-head book-align">
            <h2 class="title mb-0">Special Offers</h2>
            <div class="pagination-align style-1">
                <div class="book-button-prev swiper-button-prev"><i class="fa-solid fa-angle-left"></i></div>
                <div class="book-button-next swiper-button-next"><i class="fa-solid fa-angle-right"></i></div>
            </div>
        </div>
        <div class="swiper-container book-swiper">
            <div class="swiper-wrapper">
                @foreach ($data['offer'] as $offer)
                    <div class="swiper-slide">
                        <div class="dz-card style-2 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="dz-media">
                                <a href="books-detail.html"><img src="{{ $offer->image_path }}" alt="/" style="height: 222px;"></a>
                                <a href="javascript:void(0);" class="btn-outline-danger btnhover add-to-wishlist @if($offer->isInWishlist) active @endif" data-id="{{ $offer->id }}" data-type="offer">
                                    <i class="flaticon-heart"></i>
                                </a>
                            </div>
                            <div class="dz-info">
                                <h4 class="dz-title"><a href="books-detail.html">{{ $offer->title }}</a></h4>
                                <div class="dz-meta">
                                    <ul class="dz-tags">
                                        @foreach ($offer->category as $category)
                                            <li><a href="books-detail.html">{{ $category->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <p style="height: 77px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 1.5;">
                                    {{ Str::limit($offer->description, 200) }}
                                </p>
                                <div class="bookcard-footer">
                                    <a href="shop-cart.html" class="btn btn-primary m-t15 btnhover2"><i class="flaticon-shopping-cart-1 m-r10"></i> Add to cart</a>
                                    <div class="price-details">
                                        @if ($offer->discounted_price)
                                            £{{ $offer->discounted_price }} <del>${{ $offer->sale_price }}</del>
                                        @else
                                            £{{ $offer->sale_price }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Special Offer End -->
