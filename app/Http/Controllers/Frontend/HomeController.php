<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Book;
use App\Models\Category;
use App\Models\Wishlist;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class HomeController extends MainController{

    public function index(){
        $data = [];
        $data = array_merge($data, $this->frontendItems());

        // Fetch banner books
        $data['banner'] = $this->getBooks('banner', 5, 'banner');

        // Fetch bannerSmall books
        $data['bannerSmall'] = $this->getBooks('bannerSmall', 3, 'grid');

        // Fetch recommended books
        $data['recommended'] = $this->getBooks('recommended', 10, 'grid');

        // Fetch onSale books
        $data['onSale'] = $this->getBooks('onSale', 10, 'grid', ['on_sale' => 1]);

        // Fetch featured books
        $data['featured'] = $this->getBooks('featured', 10, 'large', ['featured' => 1]);

        // Fetch offer books
        $data['offer'] = $this->getBooks('offer', 10, 'offer', ['on_sale' => 1]);

        // Fetch latest books
        $data['latest'] = $this->getBooks('latest', 10, 'grid');

        // Fetch bestSeller books
        $data['bestSeller'] = $this->getBooks('bestSeller', 10, 'grid');

        // Check if user is authenticated
        if (Auth::check()) {
            $this->checkWishlist($data);
        }

        return view('Frontend.Home.index', compact('data'));
    }

    /**
     * Fetch books with image path based on criteria
     */
    private function getBooks($key, $limit, $imageType, $additionalConditions = []){

        $query = Book::with(['category', 'tag', 'author'])
            ->where('isDeleted', 'no')
            ->where('status', 'published')
            ->latest('id')
            ->limit($limit);

        foreach ($additionalConditions as $field => $value) {
            $query->where($field, $value);
        }

        $books = $query->get();

        foreach ($books as $book) {
            $book->image_path = ImageHelper::generateImage($book->image, $imageType);
        }

        return $books;
    }

    /**
     * Check if books are in the user's wishlist
     */
    private function checkWishlist(&$data){
        // Get user ID
        $userId = Auth::id();

        // Example: assuming books are stored in $data['banner'], $data['bannerSmall'], etc.
        $booksCollections = [
            'banner', 'bannerSmall', 'recommended', 'onSale', 'featured', 'offer', 'latest', 'bestSeller'
        ];

        foreach ($booksCollections as $collectionKey) {
            if (isset($data[$collectionKey])) {
                foreach ($data[$collectionKey] as $book) {
                    $book->isInWishlist = $this->isBookInWishlist($book->id, $userId);
                }
            }
        }
    }

    /**
     * Check if a book is in the user's wishlist
     */
    private function isBookInWishlist($bookId, $userId){
        // Check if the book ID exists in the user's wishlist
        return Wishlist::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->where('status', 'active')
            ->where('isDeleted', 'no')
            ->exists();
    }
}
