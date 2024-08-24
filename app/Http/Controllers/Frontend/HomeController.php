<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\ContactUs;
use App\Models\Subscriber;
use App\Services\ServeImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HomeController extends MainController{

    public function index(Request $request){
        $data = [];
        $data = array_merge($data, $this->frontendItems($request));

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

    public function aboutUs(Request $request){
        $data = [];
        $data = parent::frontendItems($request);
        // dd($data);
        return view('Frontend.About.index')->with('data', $data);
    }

    public function privacyPolicy(Request $request){
        $data = [];
        $data = parent::frontendItems($request);
        return view('Frontend.PrivacyPolicy.index')->with('data', $data);
    }

    public function contactUs(Request $request){
        $data = [];
        $data = parent::frontendItems($request);
        return view('Frontend.ContactUs.index')->with('data', $data);
    }

    public function sendContactUs(Request $request){
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'message' => 'required'
            ]
        );

        if ($validator->fails()) {
            Session::flash('error', 'Please fill all the fields.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $contactUs = new ContactUs();
        $contactUs->name = $request->name;
        $contactUs->email = $request->email;
        $contactUs->phone = $request->phone;
        $contactUs->message = $request->message;
        $save = $contactUs->save();
        if (!$save) {
            Session::flash('error', 'Failed to send message. Please try again.');
            return redirect()->back();
        }

        Session::flash('success', 'Message sent successfully.');
        return redirect()->back();
    }

    public function subscribe(Request $request){
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email|unique:subscribers,email'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ]);
        }

        // Save email to database
        $subscribe = new Subscriber();
        $subscribe->email = $request->email;
        $subscribe->is_subscribed = 1;
        $subscribe->subscribed_at = now();
        $save = $subscribe->save();

        // Check if saving to database fails
        if (!$save) {
            return response()->json([
                'status' => 0,
                'msg' => 'Failed to subscribe. Please try again.'
            ]);
        }

        // If successfully saved to database
        return response()->json([
            'status' => 1,
            'msg' => 'Subscribed successfully.'
        ]);
    }

    public function unsubscribe(Request $request)
    {
        $email = urldecode($request->input('email'));
        $subscriber = Subscriber::where('email', $email)->first();

        if ($subscriber) {
            $subscriber->delete(); // Remove the subscriber from the list
            return redirect('/')->with('success', 'You have successfully unsubscribed from our mailing list.');
        } else {
            return redirect('/')->with('error', 'Subscriber not found.');
        }
    }

    public function faq(Request $request){
        $data = [];
        $data = parent::frontendItems($request);
        return view('Frontend.FAQ.index')->with('data', $data);
    }

    /**
     * Fetch books with image path based on criteria
     */
    private function getBooks($key, $limit, $imageType, $additionalConditions = []){

        $query = Book::with(['category', 'tag', 'author'])
            ->where('isDeleted', 'no')
            ->where('status', 'published')
            ->where('availability', 1)
            ->latest('id')
            ->limit($limit);

        foreach ($additionalConditions as $field => $value) {
            $query->where($field, $value);
        }

        $books = $query->get();

        foreach ($books as $book) {
            $book->image_path = ServeImage::image($book->image, $imageType);
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
