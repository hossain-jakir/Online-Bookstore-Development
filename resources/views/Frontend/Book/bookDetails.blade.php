@extends('Frontend/Main/index')

@section('title', $data['book']->title)

@section('content')

<div class="page-content bg-grey">
    <section class="content-inner-1">
        <div class="container">
            <div class="row book-grid-row style-4 m-b60">
                <div class="col">
                    <div class="dz-box">
                        <div class="dz-media">
                            <img src="{{ $data['book']->image }}" alt="book">
                        </div>
                        <div class="dz-content">
                            <div class="dz-header">
                                <h3 class="title">{{ $data['book']->title }}</h3>
                                <div class="shop-item-rating">
                                    <div class="d-lg-flex d-sm-inline-flex d-flex align-items-center">
                                        <ul class="dz-rating">
                                            @for ($i = 0; $i < 5; $i++)
                                                @if ($i < $data['book']->rating)
                                                    <li><i class="flaticon-star text-yellow"></i></li>
                                                @else
                                                    <li><i class="flaticon-star text-muted"></i></li>
                                                @endif
                                            @endfor
                                        </ul>
                                        <h6 class="m-b0">{{$data['book']->rating ?? 0}}</h6>
                                    </div>
                                    <div class="social-area">
                                        <ul class="dz-social-icon style-3">
                                            {{-- <li><a href="https://www.facebook.com/dexignzone" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                                            <li><a href="https://twitter.com/dexignzones" target="_blank"><i class="fa-brands fa-twitter"></i></a></li>
                                            <li><a href="https://www.whatsapp.com/" target="_blank"><i class="fa-brands fa-whatsapp"></i></a></li>
                                            <li><a href="https://www.google.com/intl/en-GB/gmail/about/" target="_blank"><i class="fa-solid fa-envelope"></i></a></li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="dz-body">
                                <div class="book-detail">
                                    <ul class="book-info">
                                        <li>
                                            <div class="writer-info">
                                                <img src="{{$data['book']->author->image}}" alt="book">
                                                <div>
                                                    <span>Writen by</span> {{ $data['book']->author->first_name }} {{ $data['book']->author->last_name }}
                                                </div>
                                            </div>
                                        </li>
                                        <li><span>Publisher</span>{{ $data['book']->publisher }}</li>
                                        <li><span>Year</span>
                                            {{-- showing year from published date --}}
                                            {{ date('Y', strtotime($data['book']->published_date)) }}
                                        </li>
                                    </ul>
                                </div>
                                <p class="text-1">{{ $data['book']->description }}</p>
                                <div class="book-footer">
                                    <div class="price">
                                        @if ($data['book']->discounted_price)
                                            <h5>£{{ $data['book']->discounted_price }}</h5>
                                            <p class="p-lr10">£{{ $data['book']->sale_price }}</p>
                                        @else
                                            <h5>£{{ $data['book']->sale_price }}</h5>
                                        @endif
                                    </div>
                                    <div class="product-num">
                                        <button class="btn btn-primary btnhover2 add-to-cart" data-id="{{ base64_encode($data['book']->id) }}"><i class="flaticon-shopping-cart-1"></i> <span>Add to cart</span></button>

                                        <div class="bookmark-btn style-1 d-none d-sm-block">
                                            <input class="form-check-input add-to-wishlist" data-id="{{ $data['book']->id }}" type="checkbox" id="flexCheckDefault1" @if ($data['book']->isWishlisted) checked @endif>
                                            <label class="form-check-label" for="flexCheckDefault1">
                                                <i class="flaticon-heart"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8">
                    <div class="product-description tabs-site-button">
                        <ul class="nav nav-tabs">
                            <li><a data-bs-toggle="tab" href="#graphic-design-1" class="active">Details Product</a></li>
                            <li><a data-bs-toggle="tab" href="#developement-1">Customer Reviews</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="graphic-design-1" class="tab-pane show active">
                                <table class="table border book-overview">
                                    <tr>
                                        <th>Book Title</th>
                                        <td>{{ $data['book']->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Author</th>
                                        <td>{{ $data['book']->author->first_name }} {{ $data['book']->author->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>ISBN</th>
                                        <td>{{ $data['book']->isbn }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ediiton Language</th>
                                        <td>{{ $data['book']->edition_language }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date Published</th>
                                        <td>{{ date('d M, Y', strtotime($data['book']->published_date)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Publisher</th>
                                        <td>{{ $data['book']->publisher }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pages</th>
                                        <td>{{ $data['book']->pages }} Pages</td>
                                    </tr>
                                    <tr>
                                        <th>Minimum Age</th>
                                        <td>{{ $data['book']->min_age }} Years</td>
                                    </tr>
                                    <tr class="tags">
                                        <th>Categoty</th>
                                        <td>
                                            @foreach ($data['book']->category as $category)
                                                <a href="{{URL::to($category->slug)}}" class="badge">{{ $category->name }}</a>
                                            @endforeach
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div id="developement-1" class="tab-pane">
                                <div class="clear" id="comment-list">
                                    <div class="post-comments comments-area style-1 clearfix">
                                        <h4 class="comments-title">
                                            {{ $data['book']->reviews->count() }} Reviews
                                        </h4>
                                        <div id="comment">
                                            <ol class="comment-list">
                                                @forelse ($data['book']->reviews as $review)
                                                    <li class="comment even thread-odd thread-alt depth-1 comment" id="comment-{{ $review->id }}">
                                                        <div class="comment-body" id="div-comment-{{ $review->id }}">
                                                            <div class="comment-author vcard">
                                                                <!-- User's avatar with fallback to a default image if not available -->
                                                                <img src="{{ $review->user->image ?? asset('path/to/default-avatar.png') }}" alt="" class="avatar"/>

                                                                <!-- User's full name and "says" text -->
                                                                <cite class="fn">{{ $review->user->first_name }} {{ $review->user->last_name }}</cite>
                                                                <span class="says">says:</span>

                                                                <!-- Display rating with stars and rating value -->
                                                                <div class="shop-item-rating">
                                                                    <div class="d-lg-flex d-sm-inline-flex d-flex align-items-center dlab-page-text" style="font-size: 15px; margin-top: -10px;">
                                                                        <ul class="dz-rating">

                                                                                <li><i class="flaticon-star text-yellow {{ $i < $review->rating ? '' : 'text-gray' }}"></i></li>

                                                                        </ul>
                                                                        <h6 class="m-b0" style="font-size: 15px"> {{ $review->rating ?? 0 }} | {{ date('d M, Y', strtotime($review->created_at)) }}</h6>
                                                                    </div>
                                                                </div>

                                                                <!-- Display review creation date -->
                                                                <div class="comment-meta">
                                                                    <a href="javascript:void(0);">{{ date('d M, Y', strtotime($review->created_at)) }}</a>
                                                                </div>
                                                            </div>

                                                            <!-- Display review content -->
                                                            <div class="comment-content dlab-page-text">
                                                                <p>{{ $review->review }}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @empty
                                                    <!-- Display message if there are no reviews -->
                                                    <li class="comment even thread-odd thread-alt depth-1 comment">
                                                        <div class="comment-body">
                                                            <div class="comment-content dlab-page-text">
                                                                <p>No review found</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforelse
                                            </ol>

                                        </div>
                                        {{-- <div class="default-form comment-respond style-1" id="respond">
                                            <h4 class="comment-reply-title" id="reply-title">LEAVE A REPLY <small> <a rel="nofollow" id="cancel-comment-reply-link" href="javascript:void(0)" style="display:none;">Cancel reply</a> </small></h4>
                                            <div class="clearfix">
                                                <form method="post" id="comments_form" class="comment-form" novalidate>
                                                    <p class="comment-form-author"><input id="name" placeholder="Author" name="author" type="text" value=""></p>
                                                    <p class="comment-form-email"><input id="email" required="required" placeholder="Email" name="email" type="email" value=""></p>
                                                    <p class="comment-form-comment"><textarea id="comments" placeholder="Type Comment Here" class="form-control4" name="comment" cols="45" rows="3" required="required"></textarea></p>
                                                    <p class="col-md-12 col-sm-12 col-xs-12 form-submit">
                                                        <button id="submit" type="submit" class="submit btn btn-primary filled">
                                                            Submit Now <i class="fa fa-angle-right m-l10"></i>
                                                        </button>
                                                    </p>
                                                </form>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 mt-5 mt-xl-0">
                    @if ($data['relatedBooks']->count() > 0)
                        <div class="widget">
                            <h4 class="widget-title">Related Books</h4>
                            <div class="row">
                                @forelse ($data['relatedBooks'] as $relatedBook)
                                    <div class="col-xl-12 col-lg-6">
                                        <div class="dz-shop-card style-5">
                                            <div class="dz-media">
                                                <a href="{{ route('book.show', base64_encode($relatedBook->id)) }}">
                                                    <img src="{{ $relatedBook->image}}" alt="">
                                                </a>
                                            </div>
                                            <div class="dz-content">
                                                <h5 class="subtitle">
                                                    <a href="{{ route('book.show', base64_encode($relatedBook->id)) }}" class="text-black">
                                                    {{ $relatedBook->title }}
                                                    </a>
                                                </h5>
                                                <ul class="dz-tags">
                                                    @foreach ($relatedBook->category as $relatedCategory)
                                                        @if ($loop->index < 3)
                                                        @if ($loop->last)
                                                            <li>{{ $relatedCategory->name }}</li>
                                                        @else
                                                            <li>{{ $relatedCategory->name }},</li>
                                                        @endif
                                                        @endif
                                                    @endforeach
                                                </ul>
                                                <div class="price">
                                                    @if ($relatedBook->discounted_price)
                                                        <span class="price-num">£{{ $relatedBook->discounted_price }}</span>
                                                        <del>£{{ $relatedBook->sale_price }}</del>
                                                    @else
                                                        <span class="price-num">£{{ $relatedBook->sale_price }}</h5>
                                                    @endif
                                                </div>
                                                <button class="btn btn-outline-primary btn-sm btnhover2 add-to-cart" data-id="{{ base64_encode($relatedBook->id) }}"><i class="flaticon-shopping-cart-1 me-2"></i> Add to cart</button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-xl-12 col-lg-6">
                                        <div class="dz-shop-card style-5">
                                            <div class="dz-media">
                                                <img src="images/books/grid/book15.jpg" alt="">
                                            </div>
                                            <div class="dz-content text-center">
                                                <h5 class="subtitle">No related books found</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('Frontend.Main.Recommend.recommend')

    <!-- Feature Box -->
    @include('Frontend.Main.HappyCustomer.happyCustomer')
    <!-- Feature Box End -->

    <!-- Newsletter -->
    @include('Frontend.Main.Newsletter.newsLetter')
    <!-- Newsletter End -->
</div>

@endsection

@section('addScript')
    <script src="{{ asset('assets/frontend/vendor/bootstrap-touchspin/bootstrap-touchspin.js') }}"></script>
    <script src="{{ asset('assets/frontend/vendor/countdown/counter.js') }}"></script>

    <script>
    $(document).ready(function() {
        $("input[name='demo_vertical2']").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus',
            min: 1,
            max: 100,
            step: 1,
            decimals: 0,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '',
        });
    });
</script>
@endsection

@section('addStyle')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/icons/themify/themify-icons.css') }}">
@endsection
