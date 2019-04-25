<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Validator;
use App\Book;

class BookController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('role:user');
    }
        
    public function index()
    {
        $books = Book::all();

        return view('user.books.index2')->with(array(
            'books' => $books
        ));
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        
        return view('user.books.show')->with(array(
            'book' => $book
        ));
    }
}
