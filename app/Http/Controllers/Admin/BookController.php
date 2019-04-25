<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Validator;
use App\Book;

class BookController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
        
    public function index()
    {
        $books = Book::all();

        return view('admin.books.index2')->with(array(
            'books' => $books
        ));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:191',
            'author' => 'required|max:191',
            'publisher' => 'required|max:191',
            'year' => 'required|integer|min:1900',
            'isbn' => 'required|alpha_num|size:13|unique:books',
            'price' => 'required|numeric|min:0'
        ]);

        $book = new Book();
        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->publisher = $request->input('publisher');
        $book->year = $request->input('year');
        $book->isbn = $request->input('isbn');
        $book->price = $request->input('price');
        $book->save();

        $session = $request->session()->flash('message', 'Book added successfully!');

        return redirect()->route('admin.books.index2');
        
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);

        return view('admin.books.show')->with(array(
            'book' => $book
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);

        return view('admin.books.edit')->with(array(
            'book' => $book
        ));   
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required|max:191',
            'author' => 'required|max:191',
            'publisher' => 'required|max:191',
            'year' => 'required|integer|min:1900',
            'isbn' => 'required|alpha_num|size:13|unique:books,isbn,' . $book->id,
            'price' => 'required|numeric|min:0'
        ]);

        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->publisher = $request->input('publisher');
        $book->year = $request->input('year');
        $book->isbn = $request->input('isbn');
        $book->price = $request->input('price');
        $book->save();

        $session = $request->session()->flash('message', 'Book updated successfully!');

        return redirect()->route('admin.books.index2');   
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        $book->delete();

        Session::flash('message', 'Book deleted successfully!');

        return redirect()->route('admin.books.index2');   
    }
}
