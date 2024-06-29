<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Book;
use App\Models\Category;
use App\Models\Wishlist;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends MainController
{
    public function index(){
        // Fetch frontend items from the parent controller
        $data = parent::frontendItems();

        // Fetch all books with their associated categories
        $data['books'] = Book::with('category', 'author', 'reviews')
                            ->where('isDeleted', 'no')
                            ->where('status', 'published')
                            ->latest('id')
                            ->paginate(12);

        // Generate image paths for each book
        foreach ($data['books'] as $book) {
            $book->image = ImageHelper::generateImage($book->image, 'grid');
            if(auth()->user()) {
                $book->isWishlisted = Wishlist::where('book_id', $book->id)
                    ->where('user_id', auth()->user()->id)
                    ->where('isDeleted', 'no')
                    ->where('status', 'active')
                    ->first() ? true : false;
            }else {
                $book->isWishlisted = null;
            }
        }

        $data['filter'] =[
            'price_range' => [
                'min' => $data['books']->min('sale_price') - 100 > 0 ? $data['books']->min('sale_price') - 100 : 0,
                'max' => $data['books']->max('sale_price') + 100,
            ],
            'categories' => $data['books']->pluck('category')->flatten()->unique()->values(), // 'flatten()' is used to flatten the collection of categories
            'authors' => $data['books']->pluck('author')->unique()->values(),
            'ratings' => [
                '1' => '1 Star',
                '2' => '2 Stars',
                '3' => '3 Stars',
                '4' => '4 Stars',
                '5' => '5 Stars',
            ],
            'publishers' => $data['books']->pluck('publisher')->unique()->values(),
            'languages' => $data['books']->pluck('edition_language')->unique()->values(),
            'years' => $data['books']->pluck('publication_date')->unique()->values(),
            'most_comment' => $data['books']->sortByDesc('reviews_count')->take(5),
        ];
        // dd($data);

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

        $booksQuery = Book::with('category', 'author')
                    ->where('isDeleted', 'no')
                    ->where('status', 'published');

        if ($filters) {

            if (isset($filters['price_range'])) {
                $filters['price_range']['max'] == 0 ? $filters['price_range']['max'] = 999999 : $filters['price_range']['max'];
                $booksQuery->whereBetween('sale_price', [$filters['price_range']['min'], $filters['price_range']['max']]);
            }

            if (isset($filters['categories'])) {
                // Apply category filter using whereHas
                $booksQuery->whereHas('category', function ($query) use ($filters) {
                    $query->whereIn('categories.id', $filters['categories']);
                });
            }

            if (isset($filters['publishers'])) {
                // Apply category filter using whereHas
                $booksQuery->whereIn('publisher', $filters['publishers']);
            }

            if (isset($filters['years'])) {
                // Extract years from filters and convert them to date ranges
                $years = $filters['years'];

                // Create date ranges for start and end of each year
                $dateRanges = [];
                foreach ($years as $year) {
                    $startDate = $year . '-01-01';
                    $endDate = $year . '-12-31';
                    $dateRanges[] = [$startDate, $endDate];
                }

                // Apply where clause for publication_date within any of the selected years
                $booksQuery->where(function ($query) use ($dateRanges) {
                    foreach ($dateRanges as $range) {
                        $query->orWhereBetween('publication_date', $range);
                    }
                });
            }

            if (isset($filters['featured'])) {
                // Apply category filter using whereHas
                $booksQuery->whereIn('id', $filters['featured']);
            }

            if (isset($filters['best_sellers'])) {
                // Apply category filter using whereHas
                $booksQuery->whereIn('id', $filters['best_sellers']);
            }

        }

        $data['books'] = $booksQuery->latest('id')->paginate($request->per_page);

        // Fetch all books with their associated categories
        // $data['books'] = Book::with('category')
        //                     ->where('isDeleted', 'no')
        //                     ->where('status', 'published')
        //                     ->latest('id')
        //                     ->paginate($request->per_page);

        // Generate image paths for each book
        foreach ($data['books'] as $book) {
            $book->image = ImageHelper::generateImage($book->image, 'grid');
            $book->url = route('book.show', base64_encode($book->id));
            $book->isWishlisted = auth()->check() ?
                Wishlist::where('book_id', $book->id)
                    ->where('user_id', auth()->user()->id)
                    ->where('isDeleted', 'no')
                    ->where('status', 'active')
                    ->exists()
                : false; // Explicitly set to false when user is not authenticated
        }

        $FilterBooks = Book::with('category', 'author')->where('isDeleted', 'no')->where('status', 'published')->latest('id')->get();

        $data['filter'] =[
            'price_range' => [
                'min' => $FilterBooks->min('sale_price') - 100 > 0 ? $FilterBooks->min('sale_price') - 100 : 0,
                'max' => $FilterBooks->max('sale_price') + 100,
            ],
            'categories' => $FilterBooks->pluck('category')->flatten()->unique()->values(), // 'flatten()' is used to flatten the collection of categories
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
            'years' => $FilterBooks->pluck('publication_date')->map(function($item) {
                            return date('Y', strtotime($item));
                        })->unique()->sortDesc()->values()->all(),
            'best_sellers' => $FilterBooks->sortByDesc('reviews_count')->take(5),
            'featured' => $FilterBooks->where('featured', 1)->take(5),
        ];

        return $data;
    }

    public function show($id){

        $data = [];
        $data = parent::frontendItems();

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
            $review->user->image = ImageHelper::generateImage($review->user->image, 'main');
        }

        $data['book']->image = ImageHelper::generateImage($data['book']->image, 'default');
        if ($data['book']->author) {
            $data['book']->author->image = ImageHelper::generateImage($data['book']->author->image, 'main');
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
            $relatedBook->image = ImageHelper::generateImage($relatedBook->image, 'grid');
            if ($relatedBook->author) {
                $relatedBook->author->image = ImageHelper::generateImage($relatedBook->author->image, 'main');
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
            $recommended->image_path = ImageHelper::generateImage($recommended->image, 'grid');
            if ($recommended->author) {
                $recommended->author->image = ImageHelper::generateImage($recommended->author->image, 'main');
            }
        }


        // dd($data);

        return view('Frontend.Book.bookDetails')->with('data', $data);
    }

    public function showByCategory(Request $request, $slug){
        $slug ='category/'.$slug;

        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return redirect()->route('book.index');
        }
        $Id = $category->id;
        $filters = [
            'categories' => [$Id],
            'price_range' => [
                'min' => 0,
                'max' => 999999,
            ],
            'publishers' => [],
            'years' => [],
            'featured' => [],
            'best_sellers' => []
        ];
        // dd($filters);

        $data = $this->processBookList($request, $filters);

        return response()->json([
            'success' => true,
            'message' => 'Books fetched successfully',
            'data' => $data,
            'filter' => $filters
        ]);
    }
}
