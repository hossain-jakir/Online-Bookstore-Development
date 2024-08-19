<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Book;
use App\Models\Category;
use App\Models\Wishlist;
use App\Services\ServeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends MainController
{

    public function showAllCategories(Request $request) {

        $data = parent::frontendItems($request);

        $data['AllCategories'] = Category::select('categories.id', 'categories.name', 'categories.slug', 'categories.description', 'categories.status', 'categories.isDeleted', 'categories.created_at', 'categories.updated_at', DB::raw('COUNT(book_categories.book_id) as book_count'))
                            ->join('book_categories', 'categories.id', '=', 'book_categories.category_id')
                            ->where('categories.isDeleted', 'no')
                            ->where('categories.status', 'active')
                            ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.description', 'categories.status', 'categories.isDeleted', 'categories.created_at', 'categories.updated_at')
                            ->orderBy('book_count', 'desc')
                            ->paginate(20);

        // Return the view with the data
        return view('Frontend.Category.index')->with('data', $data);
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

        // Fetch all books with their associated categories
        $data['books'] = Book::with('category', 'author', 'reviews')
                            ->where('isDeleted', 'no')
                            ->where('status', 'published')
                            ->whereHas('category', function ($query) use ($category) {
                                $query->where('categories.id', $category->id);
                            })
                            ->latest('id')
                            ->paginate(12);

        // Generate image paths for each book
        foreach ($data['books'] as $book) {
            $book->image = ServeImage::image($book->image, 'grid');
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

        // Return the view with the data
        return view('Frontend.Book.index-list')->with('data', $data);
    }
}
