@extends('Backend.layouts.master')

@section('title', 'Edit Book')

@section('page-script')
    <script src="{{ asset('assets/backend/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.7.2/tagify.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.7.2/jQuery.tagify.min.js"></script>

    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();

            // Initialize Select2 for categories
            $('#categories').select2({
                placeholder: 'Select categories',
                allowClear: true,
                multiple: true
            });

            // Initialize Select2 for authors
            $('#author_id').select2({
                templateResult: formatAuthorOption,
                templateSelection: formatAuthorOption
            });

            function formatAuthorOption(author) {
                if (!author.id) {
                    return author.text;
                }
                var imgSrc = $(author.element).data('img-src');
                if (imgSrc) {
                    var $author = $(
                        '<span class="author-option">' +
                        '<img src="' + imgSrc + '" alt="Author Image" />' +
                        author.text +
                        '</span>'
                    );
                    return $author;
                }
                return author.text;
            }
        });
    </script>
    <style>
        .author-option {
            display: flex;
            align-items: center;
        }
        .author-option img {
            border-radius: 50%;
            margin-right: 10px;
            width: 30px;
            height: 30px;
        }
        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 42px; /* Change height to 40px */
            user-select: none;
            -webkit-user-select: none;
            padding: 5px 0; /* Adjust padding to align text vertically */
            line-height: 30px; /* Ensure text is vertically centered */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px; /* Ensure text is vertically centered */
            padding-left: 10px; /* Add padding for a better look */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px; /* Match the height of the select box */
            top: 0px; /* Align arrow vertically */
            right: 5px; /* Adjust positioning of the arrow */
            display: flex;
            align-items: center; /* Center the arrow vertically */
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Book</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Book</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any() || session('error'))
            @include('Backend._partials.errorMsg')
        @endif

        @if (session('success'))
            @include('Backend._partials.successMsg')
        @endif

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Book Information</h3>
                        </div>
                        <!-- form start -->
                        <form role="form" action="{{ route('backend.book.update', $data['book']->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Enter title" value="{{ old('title', $data['book']->title) }}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Enter description">{{ old('description', $data['book']->description) }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="author_id">Author <span class="text-danger">*</span></label>
                                    <select class="form-control @error('author_id') is-invalid @enderror" id="author_id" name="author_id" required>
                                        <option value="">Select Author</option>
                                        @foreach ($data['authors'] as $author)
                                            <option value="{{ $author->id }}" data-img-src="{{ Storage::url($author->image) }}" {{ $author->id == old('author_id', $data['book']->author_id) ? 'selected' : '' }}>
                                                {{ $author->first_name }} {{ $author->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('author_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="isbn">ISBN <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn" placeholder="Enter ISBN" value="{{ old('isbn', $data['book']->isbn) }}" required>
                                    @error('isbn')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="edition_language">Edition Language <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('edition_language') is-invalid @enderror" id="edition_language" name="edition_language" placeholder="Enter edition language" value="{{ old('edition_language', $data['book']->edition_language) }}" required>
                                    @error('edition_language')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="publication_date">Publication Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('publication_date') is-invalid @enderror" id="publication_date" name="publication_date" value="{{ old('publication_date', $data['book']->publication_date) }}" required>
                                    @error('publication_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="publisher">Publisher <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('publisher') is-invalid @enderror" id="publisher" name="publisher" placeholder="Enter publisher" value="{{ old('publisher', $data['book']->publisher) }}" required>
                                    @error('publisher')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="pages">Pages</label>
                                    <input type="number" class="form-control @error('pages') is-invalid @enderror" id="pages" name="pages" placeholder="Enter number of pages" value="{{ old('pages', $data['book']->pages) }}">
                                    @error('pages')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="lessons">Lessons</label>
                                    <input type="number" class="form-control @error('lessons') is-invalid @enderror" id="lessons" name="lessons" placeholder="Enter number of lessons" value="{{ old('lessons', $data['book']->lessons) }}">
                                    @error('lessons')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="min_age">Minimum Age <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('min_age') is-invalid @enderror" id="min_age" name="min_age" placeholder="Enter minimum age" value="{{ old('min_age', $data['book']->min_age) }}">
                                    @error('min_age')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="purchase_price">Purchase Price <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('purchase_price') is-invalid @enderror" id="purchase_price" name="purchase_price" placeholder="Enter purchase price" value="{{ old('purchase_price', $data['book']->purchase_price) }}" required>
                                    @error('purchase_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="sale_price">Sale Price <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" placeholder="Enter sale price" value="{{ old('sale_price', $data['book']->sale_price) }}" required>
                                    @error('sale_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="discounted_price">Discounted Price</label>
                                    <input type="number" step="0.01" class="form-control @error('discounted_price') is-invalid @enderror" id="discounted_price" name="discounted_price" placeholder="Enter discounted price" value="{{ old('discounted_price', $data['book']->discounted_price) }}">
                                    @error('discounted_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="discount_type">Discount Type</label>
                                    <select class="form-control @error('discount_type') is-invalid @enderror" id="discount_type" name="discount_type">
                                        <option value="fixed" {{ old('discount_type', $data['book']->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        <option value="percentage" {{ old('discount_type', $data['book']->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    </select>
                                    @error('discount_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="availability">Availability <span class="text-danger">*</span></label>
                                    <select class="form-control @error('availability') is-invalid @enderror" id="availability" name="availability">
                                        <option value="0" {{ old('availability', $data['book']->availability) == '0' ? 'selected' : '' }}>Unavailable</option>
                                        <option value="1" {{ old('availability', $data['book']->availability) == '1' ? 'selected' : '' }}>Available</option>
                                    </select>
                                    @error('availability')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="featured">Featured</label>
                                    <select class="form-control @error('featured') is-invalid @enderror" id="featured" name="featured">
                                        <option value="0" {{ old('featured', $data['book']->featured) == '0' ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('featured', $data['book']->featured) == '1' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @error('featured')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="on_sale">On Sale</label>
                                    <select class="form-control @error('on_sale') is-invalid @enderror" id="on_sale" name="on_sale">
                                        <option value="0" {{ old('on_sale', $data['book']->on_sale) == '0' ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('on_sale', $data['book']->on_sale) == '1' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @error('on_sale')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="free_delivery">Free Delivery</label>
                                    <select class="form-control @error('free_delivery') is-invalid @enderror" id="free_delivery" name="free_delivery">
                                        <option value="0" {{ old('free_delivery', $data['book']->free_delivery) == '0' ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('free_delivery', $data['book']->free_delivery) == '1' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @error('free_delivery')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="categories">Categories <span class="text-danger">*</span></label>
                                    <select class="form-control @error('categories') is-invalid @enderror" id="categories" name="categories[]" multiple="multiple" required>
                                        @foreach ($data['categories'] as $category)
                                            <option value="{{ $category->id }}" {{ $data['book']->category->contains($category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('categories')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="image">Image <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    <!-- Display image preview below file input -->
                                    @if ($data['book']->image)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($data['book']->image) }}" alt="Book Image" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    @endif
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="draft" {{ old('status', $data['book']->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $data['book']->status) == 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="archived" {{ old('status', $data['book']->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
