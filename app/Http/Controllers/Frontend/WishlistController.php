<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Book;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishlistController extends MainController{

    public function index(){
        $data =[];
        $data = array_merge($data, $this->frontendItems());
        $data['wishlist'] = Wishlist::where('user_id', auth()->user()->id)->where('status', 'active')->where('isDeleted', 'no')->latest('id')->get();
        foreach($data['wishlist'] as $row){
            $row->book->image = $row->getBookImageAttribute('grid');
        }

        $data['wishlistCount'] = Wishlist::where('user_id', auth()->id())->where('status', 'active')->where('isDeleted', 'no')->count() ?? 0;

        return view('Frontend.Wishlist.index')->with('data', $data);
    }

    public function store(Request $request){

        $book = Book::where('id', $request->book_id)->where('isDeleted', 'no')->first();
        if(!$book){
            return response()->json(['success' => false, 'message' => 'Book not found']);
        }

        $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('book_id', $request->book_id)->where('status', 'active')->where('isDeleted', 'no')->first();
        if($wishlist){
            $wishlist->isDeleted = 'yes';
            $wishlist->save();
            return response()->json(['success' => true, 'message' => $book->title.' removed from wishlist']);
        }else{

            $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('book_id', $request->book_id)->first();
            if($wishlist){
                $wishlist->isDeleted = 'no';
                $wishlist->status = 'active';
                $wishlist->save();
                return response()->json(['success' => true, 'message' => $book->title.' added to wishlist']);
            }

            $wishlist = new Wishlist();
            $wishlist->user_id = auth()->user()->id;
            $wishlist->book_id = $request->book_id;
            $wishlist->save();
            return response()->json(['success' => true, 'message' => 'Book added to wishlist']);
        }
    }

    public function delete(Request $request, $id){
        $wishlist = Wishlist::where('id', $id)->where('user_id', auth()->user()->id)->where('status', 'active')->where('isDeleted', 'no')->first();
        if($wishlist){
            $wishlist->isDeleted = 'yes';
            $wishlist->save();
            return response()->json(['success' => true, 'message' => 'Book removed from wishlist']);
        }else{
            return response()->json(['success' => false, 'message' => 'Book not found in wishlist']);
        }
    }

    public function deleteAll(Request $request){
        $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('status', 'active')->where('isDeleted', 'no')->get();
        foreach($wishlist as $row){
            $row->isDeleted = 'yes';
            $row->save();
        }

        return response()->json(['success' => true, 'message' => 'All books removed from wishlist']);
    }
}
