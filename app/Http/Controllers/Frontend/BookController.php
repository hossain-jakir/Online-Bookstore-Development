<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Book;
use App\Models\Category;
use App\Models\Wishlist;
use App\Services\ServeImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends MainController
{
    public function index(Request $request){
        // Fetch frontend items from the parent controller
        $data = parent::frontendItems($request);

        // Extract filters from the request URL
        $filters = [
            'price_range' => [
                'min' => $request->get('price_min', 0),
                'max' => $request->get('price_max', 999999),
            ],
            'categories' => $request->has('categories') ? explode(',', $request->get('categories')) : [],
            'authors' => $request->has('authors') ? array_filter(explode(',', $request->get('authors'))) : [],
            'publishers' => $request->has('publishers') ? array_map('urldecode', explode(',', $request->get('publishers'))) : [],
            'years' => $request->has('years') ? explode(',', $request->get('years')) : [],
            'featured' => $request->get('featured') ? array_map('urldecode', explode(',', $request->get('featured'))) : [],
            'best_sellers' => $request->get('best_sellers') ? array_map('trim', explode(',', urldecode($request->get('best_sellers')))): [],
            'day_filter' => $request->get('day_filter', null),
            'q' => urldecode($request->get('q', null)),
        ];
        $data['filters'] = $filters;
        // dd($filters);

        $data['data'] = $this->processBookList($request, $filters);
        // dd($data['books']);

        // dd($data['data']['books']);

        // Return the view with the data
        if (route('book.grid') == request()->url()) {
            return view('Frontend.Book.index-grid')->with('data', $data);
        }
        if (route('book.list') == request()->url()) {
            return view('Frontend.Book.index-list')->with('data', $data);
        }
        return view('Frontend.Book.index-grid-sidebar')->with('data', $data);
    }

    public function bookList(Request $request){

        $data = [];
        $data = $this->processBookList($request, $request->filters);

        return response()->json([
            'success' => true,
            'message' => 'Books fetched successfully',
            'data' => $data,
            'filter' => $request->filters
        ]);
    }

    protected function processBookList($request, $filters){
        $data = [];

        // Initialize the query with basic conditions
        $booksQuery = Book::with('category', 'author')
            ->where('isDeleted', 'no')
            ->where('status', 'published');

        if ($request->has('q')) {
            $decodedQuery = urldecode($request->get('q'));
            $search = $decodedQuery;
            $booksQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('isbn', 'like', '%' . $search . '%')
                    ->orWhere('publisher', 'like', '%' . $search . '%')
                    ->orWhere('publication_date', 'like', '%' . $search . '%')
                    ->orWhere('pages', 'like', '%' . $search . '%')
                    ->orWhere('lessons', 'like', '%' . $search . '%')
                    ->orWhere('edition_language', 'like', '%' . $search . '%');
            });
        }

        // Check if there are filters
        if ($filters) {
            // Handle price range filter
            if (isset($filters['price_range'])) {
                $filters['price_range']['max'] == 0 ? $filters['price_range']['max'] = 999999 : $filters['price_range']['max'];
                $booksQuery->whereBetween('sale_price', [$filters['price_range']['min'], $filters['price_range']['max']]);
            }

            // Handle categories filter
            if (isset($filters['categories']) && !empty($filters['categories'])) {
                $booksQuery->whereHas('category', function ($query) use ($filters) {
                    $query->whereIn('categories.id', $filters['categories']);
                });
            }

            // Handle publishers filter
            if (isset($filters['publishers']) && !empty($filters['publishers'])) {
                $booksQuery->whereIn('publisher', $filters['publishers']);
            }

            // Handle years filter
            if (isset($filters['years']) && !empty($filters['years'])) {
                $years = $filters['years'];
                $dateRanges = [];
                foreach ($years as $year) {
                    $startDate = $year . '-01-01';
                    $endDate = $year . '-12-31';
                    $dateRanges[] = [$startDate, $endDate];
                }
                $booksQuery->where(function ($query) use ($dateRanges) {
                    foreach ($dateRanges as $range) {
                        $query->orWhereBetween('publication_date', $range);
                    }
                });
            }

            // Handle featured filter
            if (isset($filters['featured']) && !empty($filters['featured'])) {
                // Ensure $filters['featured'] is an array
                if (!is_array($filters['featured'])) {
                    $filters['featured'] = explode(',', $filters['featured']);
                }

                // Make sure it is countable now
                if (count($filters['featured']) > 0) {
                    $booksQuery->whereIn('id', $filters['featured']);
                }
            }

            // Handle best sellers filter
            if (isset($filters['best_sellers']) && !empty($filters['best_sellers'])) {
                // dd($filters['best_sellers']);
                // Ensure $filters['best_sellers'] is an array
                if (!is_array($filters['best_sellers'])) {
                    $filters['best_sellers'] = explode(',', $filters['best_sellers']);
                }

                // dd($filters['best_sellers']);

                // Make sure it is countable now
                if (count($filters['best_sellers']) > 0) {
                    $booksQuery->whereIn('id', $filters['best_sellers']);
                }

                // dd($booksQuery->get());
            }

            // Handle authors filter
            if (isset($filters['authors']) && !empty($filters['authors'])) {
                // dd($filters['authors']);
                if (!is_array($filters['authors'])) {
                    $filters['authors'] = explode(',', $filters['authors']);
                }
                if (count($filters['authors']) > 0) {
                    $booksQuery->whereIn('author_id', $filters['authors']);
                }
            }

            // Handle day filter based on created_at
            if (isset($filters['day_filter'])) {
                $dayFilter = $filters['day_filter'];
                $currentDate = date('Y-m-d H:i:s');

                switch ($dayFilter) {
                    case 'newest':
                        // No additional filtering for 'newest'
                        break;

                    case '1_day':
                        $booksQuery->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 day', strtotime($currentDate))));
                        break;

                    case '1_week':
                        $booksQuery->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 week', strtotime($currentDate))));
                        break;

                    case '3_weeks':
                        $booksQuery->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-3 weeks', strtotime($currentDate))));
                        break;

                    case '1_month':
                        $booksQuery->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 month', strtotime($currentDate))));
                        break;

                    case '3_months':
                        $booksQuery->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-3 months', strtotime($currentDate))));
                        break;

                    default:
                        // Handle other cases or invalid input
                        break;
                }
            }
        }

        $data['books'] = $booksQuery->latest('id')->paginate($request->per_page ?? 12);

        // Generate image paths for each book
        foreach ($data['books'] as $book) {
            $book->image = ServeImage::image($book->image, 'grid');
            $book->url = route('book.show', base64_encode($book->id));
            $book->isWishlisted = auth()->check() ?
                Wishlist::where('book_id', $book->id)
                    ->where('user_id', auth()->user()->id)
                    ->where('isDeleted', 'no')
                    ->where('status', 'active')
                    ->exists()
                : false;
        }

        $FilterBooks = Book::with('category', 'author')
            ->where('isDeleted', 'no')
            ->where('status', 'published')
            ->latest('id')->get();

        // Prepare filter data for the frontend
        $data['filter'] = [
            'price_range' => [
                'min' => $FilterBooks->min('sale_price') - 100 > 0 ? $FilterBooks->min('sale_price') - 100 : 0,
                'max' => $FilterBooks->max('sale_price') + 100,
            ],
            'categories' => $FilterBooks->pluck('category')->flatten()->unique()->values(),
            'authors' => $FilterBooks->pluck('author')->unique()->values(),
            'ratings' => [
                '1' => '1 Star',
                '2' => '2 Stars',
                '3' => '3 Stars',
                '4' => '4 Stars',
                '5' => '5 Stars',
            ],
            'publishers' => $FilterBooks->pluck('publisher')->unique()->values(),
            'languages' => $FilterBooks->pluck('edition_language')->unique()->values(),
            'years' => $FilterBooks->pluck('publication_date')->map(function ($item) {
                return date('Y', strtotime($item));
            })->unique()->sortDesc()->values()->all(),
            'best_sellers' => $FilterBooks->sortByDesc('reviews_count')->take(5),
            'featured' => $FilterBooks->where('featured', 1)->take(5),
        ];

        return $data;
    }

    public function show(Request $request, $id){

        $data = [];
        $data = parent::frontendItems($request);

        $bookId = base64_decode($id);

        $data['book'] = Book::with('author', 'category', 'reviews')
            ->where('id', $bookId)
            ->where('isDeleted', 'no')
            ->where('status', 'published')
            ->first();

        if (!$data['book']) {
            return redirect()->route('book.index');
        }

        $data['title'] = $data['book']->title;

        if(auth()->user()) {
            $data['book']->isWishlisted = Wishlist::where('book_id', $data['book']->id)
                ->where('user_id', auth()->user()->id)
                ->where('isDeleted', 'no')
                ->where('status', 'active')
                ->first();
        }else {
            $data['book']->isWishlisted = null;
        }

        foreach ($data['book']->reviews as $review) {
            $review->user->image = ServeImage::image($review->user->image, 'main');
        }

        $data['book']->image = ServeImage::image($data['book']->image, 'default');
        if ($data['book']->author) {
            $data['book']->author->image = ServeImage::image($data['book']->author->image, 'main');
        }

        // Fetch related books
        $data['relatedBooks'] = Book::whereHas('category', function ($query) use ($data) {
            $query->whereIn('categories.id', $data['book']->category->pluck('id'));
        })
            ->where('id', '!=', $data['book']->id) // Exclude the current book
            ->where('isDeleted', 'no') // Only fetch books that are not deleted
            ->where('status', 'published') // Only fetch published books
            ->with('author', 'category') // Load related models if needed
            ->take(5) // Limit the number of related books
            ->inRandomOrder() // Randomize the order of related books
            ->get();

        foreach ($data['relatedBooks'] as $relatedBook) {
            $relatedBook->image = ServeImage::image($relatedBook->image, 'grid');
            if ($relatedBook->author) {
                $relatedBook->author->image = ServeImage::image($relatedBook->author->image, 'main');
            }
        }

        $data['recommended'] = Book::where('isDeleted', 'no')
            ->where('status', 'published')
            ->with('author', 'category')
            ->where('id', '!=', $data['book']->id)
            ->inRandomOrder()
            ->take(10)
            ->inRandomOrder()
            ->latest('id') // Order by latest 'id
            ->get();

        foreach ($data['recommended'] as $recommended) {
            $recommended->image_path = ServeImage::image($recommended->image, 'grid');
            if ($recommended->author) {
                $recommended->author->image = ServeImage::image($recommended->author->image, 'main');
            }
        }


        // dd($data);

        return view('Frontend.Book.bookDetails')->with('data', $data);
    }

    public function showByCategory(Request $request, $slug) {

        $data = parent::frontendItems($request);

        $data['title'] = $slug;

        // Correct the slug format if necessary
        $slug = 'category/' . $slug;

        // Find the category by slug
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return redirect()->route('book.index');
        }

        $filters = [
            'price_range' => [
                'min' => $request->get('price_min', 0),
                'max' => $request->get('price_max', 999999),
            ],
            'categories' => $request->has('categories') ? array_unique(array_merge(explode(',', $request->get('categories')), [$category->id])) : [$category->id],
            'authors' => $request->has('authors') ? array_filter(explode(',', $request->get('authors'))) : [],
            'publishers' => $request->has('publishers') ? array_map('urldecode', explode(',', $request->get('publishers'))) : [],
            'years' => $request->has('years') ? explode(',', $request->get('years')) : [],
            'featured' => $request->get('featured') ? array_map('urldecode', explode(',', $request->get('featured'))) : [],
            'best_sellers' => $request->get('best_sellers') ? array_map('trim', explode(',', urldecode($request->get('best_sellers')))): [],
            'day_filter' => $request->get('day_filter', null),
        ];

        $data['filters'] = $filters;

        $data['data'] = $this->processBookList($request, $filters);


        // Return the view with the data
        return view('Frontend.Book.index-grid-sidebar')->with('data', $data);
    }

    public function showByAuthor(Request $request, $authorId){

        $data = parent::frontendItems($request);

        $data['title'] = 'Author';

        $filters = [
            'price_range' => [
                'min' => $request->get('price_min', 0),
                'max' => $request->get('price_max', 999999),
            ],
            'categories' => $request->has('categories') ? explode(',', $request->get('categories')) : [],
            'authors' => $request->has('authors') ? array_unique(array_merge(explode(',', $request->get('authors')), [$authorId])) : [$authorId],
            'publishers' => $request->has('publishers') ? array_map('urldecode', explode(',', $request->get('publishers'))) : [],
            'years' => $request->has('years') ? explode(',', $request->get('years')) : [],
            'featured' => $request->get('featured') ? array_map('urldecode', explode(',', $request->get('featured'))) : [],
            'best_sellers' => $request->get('best_sellers') ? array_map('trim', explode(',', urldecode($request->get('best_sellers')))): [],
            'day_filter' => $request->get('day_filter', null),
        ];

        $data['filters'] = $filters;

        $data['data'] = $this->processBookList($request, $filters);

        // Return the view with the data
        return view('Frontend.Book.index-grid-sidebar')->with('data', $data);

    }

    public function search(Request $request) {
        $q = $request->q ?? '';

        $booksQuery = Book::where('isDeleted', 'no')
            ->where('status', 'published')
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', '%' . $q . '%')
                    ->orWhere('description', 'like', '%' . $q . '%')
                    ->orWhere('isbn', 'like', '%' . $q . '%')
                    ->orWhere('publisher', 'like', '%' . $q . '%')
                    ->orWhere('publication_date', 'like', '%' . $q . '%')
                    ->orWhere('pages', 'like', '%' . $q . '%')
                    ->orWhere('lessons', 'like', '%' . $q . '%')
                    ->orWhere('edition_language', 'like', '%' . $q . '%');
            })->limit(10)->get();

        foreach ($booksQuery as $book) {
            $book->image = ServeImage::image($book->image, 'grid');
            $book->url = route('book.show', base64_encode($book->id));

            // Add price details
            $book->price_display = $book->discounted_price > 0 ? $book->discounted_price : $book->sale_price;
            $book->price_display = number_format($book->price_display, 2);

            if ($book->discounted_price > 0) {
                $discount = $book->sale_price - $book->discounted_price;
                $book->discount_amount = $discount;
                $book->discount_type = $book->discount_type; // 'fixed' or 'percentage'
            } else {
                $book->discount_amount = 0;
                $book->discount_type = 'none';
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Books fetched successfully',
            'isBookFound' => $booksQuery->count() > 0 ? true : false,
            'count' => $booksQuery->count(),
            'data' => $booksQuery,
        ]);
    }


}
