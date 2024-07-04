@extends('Frontend/Main/index')

@section('title', 'Authors')

@section('content')

<div class="page-content">


    <!-- FAQ Content Start -->
    <div class="page-content bg-grey">
		<section class="content-inner border-bottom">
			<div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="title">Authors</h4>
                </div>
                <hr>
                <div class="row book-grid-row">
                    @forelse ($data['AllAuthors'] as $allAuthor)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <a href="{{ route('author.show', $allAuthor->id) }}" class="d-block">
                                <div class="d-flex align-items-center" style="border: 1px solid #ddd; padding: 10px; border-radius: 10px; background-color: #fff;">
                                    <div style="flex-shrink: 0; margin-right: 15px;">
                                        <img src="{{ $allAuthor->image }}" alt="author image"
                                            style="border-radius: 50%; width: 100px; height: 100px; object-fit: cover;">
                                    </div>
                                    <div>
                                        <h5 class="mb-0">{{ $allAuthor->first_name }} {{ $allAuthor->last_name }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <div class="alert alert-danger"> No Authors Found! </div>
                        </div>
                    @endforelse
                </div>

                <div class="row page mt-0">
                    {!! $data['AllAuthors']->withQueryString()->links('pagination::default') !!}
                </div>

            </div>
        </section>
    </div>
    <!-- FAQ Content End -->

</div>

@endsection
