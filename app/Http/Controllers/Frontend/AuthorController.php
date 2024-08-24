<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Services\ServeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\MainController;

class AuthorController extends MainController
{
    public function index(Request $request){

        $data = parent::frontendItems($request);

        $data['AllAuthors'] = User::select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.phone','users.image', 'users.status', 'users.isDeleted', 'users.created_at', 'users.updated_at', DB::raw('COUNT(books.author_id) as book_count'))
            ->join('books', 'users.id', '=', 'books.author_id')
            ->where('users.isDeleted', 'no')
            ->where('users.status', 'active')
            ->groupBy('users.id', 'users.first_name' , 'users.last_name' , 'users.email', 'users.phone', 'users.image', 'users.status', 'users.isDeleted', 'users.created_at', 'users.updated_at')
            ->orderBy('book_count', 'desc')
            ->paginate(20);

        foreach($data['AllAuthors'] as $author){
            $author->image = ServeImage::image($author->image);
        }

        return view('Frontend.Authors.index', compact('data'));

    }

    public function showAllAuthors(){

    }
}
