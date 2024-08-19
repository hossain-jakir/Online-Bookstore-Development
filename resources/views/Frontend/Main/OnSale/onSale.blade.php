<!-- Book Sale -->
<section class="content-inner-1">
    <div class="container">
        <div class="section-head book-align">
            <h2 class="title mb-0">Books on Sale</h2>
            <div class="pagination-align style-1">
                <div class="swiper-button-prev"><i class="fa-solid fa-angle-left"></i></div>
                <div class="swiper-pagination-two"></div>
                <div class="swiper-button-next"><i class="fa-solid fa-angle-right"></i></div>
            </div>
        </div>
        <div class="swiper-container books-wrapper-3 swiper-four">
            <div class="swiper-wrapper">
                @foreach ($data['onSale'] as $onSale)
                    <div class="swiper-slide">
                        <div class="books-card style-3 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="dz-media">
                                <a href="{{ route('book.show', ['id' => base64_encode($onSale->id)]) }}">
                                    <img src="{{ $onSale->image_path }}" alt="book" style="height: 300px; ">
                                </a>
                            </div>
                            <div class="dz-content">
                                <h5 class="title" style="font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; display: block;">
                                    <a href="{{ route('book.show', ['id' => base64_encode($onSale->id)]) }}" style="text-decoration: none; color: inherit;">{{ $onSale->title }}</a>
                                </h5>

                                <ul class="dz-tags">
                                    @foreach ($onSale->category as $category)
                                        {{-- max 3 categories --}}
                                        @if ($loop->index < 3)
                                            <li><a href="{{ URL::to($category->slug) }}">{{ $category->name }},</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                                <div class="book-footer">
                                    <div class="rate">
                                        <i class="flaticon-star"></i> {{ $onSale->rating ?? 0 }}
                                    </div>
                                    <div class="price" style="font-family: Arial, sans-serif; display: flex; align-items: center; gap: 10px;">
                                        <!-- Display the discounted price if available -->
                                        @if ($onSale->discounted_price)
                                            <span class="price-num" style="font-size: 18px; font-weight: bold; color: #e74c3c;">
                                                £{{ $onSale->discounted_price }}
                                            </span>
                                            <del style="font-size: 16px; color: #7f8c8d;">£{{ $onSale->sale_price }}</del>
                                        @else
                                            <!-- Display only the sale price if no discount is available -->
                                            <span class="price-num" style="font-size: 18px; font-weight: bold; color: #34495e;">
                                                £{{ $onSale->sale_price }}
                                            </span>
                                        @endif
                                    </div>

                                </div>
                                <!-- Love Icon -->
                                <a href="javascript:void(0);" class="btn btn-outline-danger btnhover add-to-wishlist @if($onSale->isInWishlist) active @endif" data-id="{{ $onSale->id }}" data-type="large">
                                    <i class="flaticon-heart"></i>
                                </a>
                                <!-- Love Icon -->
                                <button class="btn btn-secondary btnhover2 add-to-cart" data-id="{{ base64_encode($onSale->id) }}">
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
<!-- Book Sale End -->
