<?php

namespace App\Http\Controllers\Backend;

use App\Models\Tag;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Services\ServeImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Backend\BookRequest;

class BookController extends Controller
{
    protected $thumbnails = [
        '_default' => ['width' => 398, 'height' => 572],
        '_grid' =>['width' => 250, 'height' => 357],
        '_large' =>['width' => 640, 'height' => 900],
        '_small' =>['width' => 150, 'height' => 150],
        '_banner' =>['width' => 758, 'height' => 774],
        '_offer' =>['width' => 511, 'height' => 307],
    ];

    public function index(){
        $data=[];

        $data['rows'] = Book::with('author')->with('tag')->where('isDeleted', 'no')->latest('id')->paginate(20);
        foreach ($data['rows'] as $row) {
            $row->categories = $row->category()->get();
            $tag = $row->tag()->get();
            $row->tags = $tag->pluck('name')->toArray();

            // Get the first image of the book
            $row->image = ServeImage::image($row->image, 'small');
        }

        return view('Backend.pages.book.index')->with('data', $data);
    }

    public function list()
    {
        $books = Book::available()->get(['id', 'title', 'sale_price', 'image']);
        foreach ($books as $book) {
            $book->image = ServeImage::image($book->image, 'small');
        }
        return response()->json($books);
    }


    public function create(){
        $data = [];

        // Get users who have the role 'author'
        $data['authors'] = User::role('author')->where('isDeleted', 'no')->get();

        // Get All Categories
        $data['categories'] = Category::where('isDeleted', 'no')->get();

        return view('Backend.pages.book.create')->with('data', $data);
    }

    public function store(BookRequest $request){
        // Retrieve the book ID (assuming it's available in the request)
        $bookId = Book::max('id') + 1; // Generate unique ID for book

        // Handle file upload (if image is present in the request)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_ext = $file->getClientOriginalExtension();
            $file_name = date('YmdHis').rand(1000, 9999);
            $file_full_name = $file_name.'.'.$file_ext;
            $upload_path = 'images/books/'.$bookId.'/'. $file_full_name;
            Storage::disk('public')->put($upload_path, file_get_contents($file));

            // Create thumbnails
            $thumbnails = [
                '_default' => ['width' => 398, 'height' => 572],
                '_grid' =>['width' => 250, 'height' => 357],
                '_large' =>['width' => 640, 'height' => 900],
                '_small' =>['width' => 150, 'height' => 150],
            ];

            foreach ($thumbnails as $key => $thumbnail) {

                $thumbnailUploadPath = 'images/books/' . $bookId . '/' .$file_name . $key . '.' .$file_ext;

                $photo = Image::make($file)
                        ->resize($thumbnail['width'], $thumbnail['height'], function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->save(storage_path("app/public/".'images/books/'.$bookId.'/'.$file_name.$key.'.'.$file_ext));

                Storage::disk('public')->put( $thumbnailUploadPath, $photo );
            }

            $imageName = $upload_path; // Store the filename in the database
        } else {
            $imageName = null; // Handle if no image is uploaded
        }

        // make barcode for book
        $code = $bookId . '-' . time();

        // make unique Isbn code
        $isbn = '978-3-' . $bookId . '-' . time();

        // Create new Book instance
        $book = new Book([
            'code' => $code,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'author_id' => $request->input('author_id'),
            'isbn' => $isbn,
            'edition_language' => $request->input('edition_language'),
            'publication_date' => $request->input('publication_date'),
            'publisher' => $request->input('publisher'),
            'pages' => $request->input('pages'),
            'lessons' => $request->input('lessons'),
            'rating' => $request->input('rating'),
            'min_age' => $request->input('min_age'),
            'quantity' => $request->input('quantity'),
            'purchase_price' => $request->input('purchase_price'),
            'sale_price' => $request->input('sale_price'),
            'discounted_price' => $request->input('discounted_price'),
            'discount_type' => $request->input('discount_type'),
            'image' => $imageName,
            'availability' => $request->input('availability'),
            'featured' => $request->input('featured'),
            'on_sale' => $request->input('on_sale'),
            'free_delivery' => $request->input('free_delivery'),
            'status' => $request->input('status'),
            'quantity' => '0',
        ]);

        // Save the book
        $saved = $book->save();

        // Attach categories
        $book->category()->attach($request->input('categories'));

        if ($saved) {
            return redirect()->route('backend.book.index')->with('success', 'Book added successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to add book');
        }

    }

    public function edit($id){
        $data = [];

        // Get the book
        $data['book'] = Book::with('category')->with('tag')->find($id);

        // Get users who have the role 'author'
        $data['authors'] = User::role('author')->where('isDeleted', 'no')->get();

        // Get All Categories
        $data['categories'] = Category::where('isDeleted', 'no')->get();

        return view('Backend.pages.book.edit')->with('data', $data);
    }

    public function update(BookRequest $request, $id){
        // Retrieve the book
        $book = Book::find($id);

        // Handle file upload (if image is present in the request)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_ext = $file->getClientOriginalExtension();
            $file_name = date('YmdHis').rand(1000, 9999);
            $file_full_name = $file_name.'.'.$file_ext;
            $upload_path = 'images/books/'.$id.'/'. $file_full_name;
            Storage::disk('public')->put($upload_path, file_get_contents($file));

            // Create thumbnails
            $thumbnails = [
                '_default' => ['width' => 398, 'height' => 572],
                '_grid' =>['width' => 250, 'height' => 357],
                '_large' =>['width' => 640, 'height' => 900],
                '_small' =>['width' => 150, 'height' => 150],
            ];

            foreach ($thumbnails as $key => $thumbnail) {

                $thumbnailUploadPath = 'images/books/' . $id . '/' .$file_name . $key . '.' .$file_ext;

                $photo = Image::make($file)
                        ->resize($thumbnail['width'], $thumbnail['height'], function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->save(storage_path("app/public/".'images/books/'.$id.'/'.$file_name.$key.'.'.$file_ext));

                Storage::disk('public')->put( $thumbnailUploadPath, $photo );
            }

            $imageName = $upload_path; // Store the filename in the database
        } else {
            $imageName = $book->image; // Handle if no image is uploaded
        }

        // Update the book
        $book->code = $book->code;
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->author_id = $request->input('author_id');
        $book->isbn = $book->isbn;
        $book->edition_language = $request->input('edition_language');
        $book->publication_date = $request->input('publication_date');
        $book->publisher = $request->input('publisher');
        $book->pages = $request->input('pages');
        $book->lessons = $request->input('lessons');
        $book->rating = $request->input('rating');
        $book->min_age = $request->input('min_age');
        $book->quantity = $request->input('quantity') ?? 0;
        $book->purchase_price = $request->input('purchase_price');
        $book->sale_price = $request->input('sale_price');
        $book->discounted_price = $request->input('discounted_price');
        $book->discount_type = $request->input('discount_type');
        $book->image = $imageName;
        $book->availability = $request->input('availability');
        $book->featured = $request->input('featured');
        $book->on_sale = $request->input('on_sale');
        $book->free_delivery = $request->input('free_delivery');
        $book->status = $request->input('status');

        $saved = $book->save();

        // Attach categories
        $book->category()->sync($request->input('categories'));

        if ($saved) {
            return redirect()->route('backend.book.index')->with('success', 'Book updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update book');
        }
    }

    public function destroy($id){
        $book = Book::find($id);
        if (!$book) {
            return redirect()->back()->with('error', 'Book not found');
        }
        $book->isDeleted = 'yes';
        $book->save();

        return redirect()->route('backend.book.index')->with('success', 'Book deleted successfully');
    }

}
