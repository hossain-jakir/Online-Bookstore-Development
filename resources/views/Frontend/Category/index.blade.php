@extends('Frontend/Main/index')

@section('title', 'Categories')

@section('content')

<div class="page-content">


    <!-- FAQ Content Start -->
    <div class="page-content bg-grey">
		<section class="content-inner border-bottom">
			<div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="title">Categories</h4>
                </div>
                <hr>
                <div class="row book-grid-row">
                    @forelse ($data['AllCategories'] as $allCategory)
                        <div class="col-book style-1">
                            <div class="dz-shop-card style-1">
                                <a href="{{ URL::TO($allCategory->slug) }}">
                                    <h5 class="title" style="text-align: center; ">{{ $allCategory->name }}</h5>
                                    <p class="category-description" style="text-align: center;">
                                        {{ substr($allCategory->description, 0, 50) }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <div class="alert alert-danger">No Category Found!</div>
                        </div>
                    @endforelse
                </div>

                <div class="row page mt-0">
                    {!! $data['AllCategories']->withQueryString()->links('pagination::default') !!}
                </div>

            </div>
        </section>
    </div>
    <!-- FAQ Content End -->

</div>

@endsection
