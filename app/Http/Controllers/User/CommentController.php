<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware('auth');
        $this->middleware('role:user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $book = Book::findOrFail($id);
        
        return view('user.books.comments.create')->with(array(
            'book' => $book
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $comment = new Comment();
        $comment->title = $request->input('title');
        $comment->body = $request->input('body');
        $comment->book_id = $id;
        
        $comment->save();
        
        $session = $request->session()->flash('message', 'Comment added successfully!');

        return redirect()->route('user.books.show', $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $cid)
    {
        $book = Book::findOrFail($id);
        $comment = Comment::findOrFail($cid);
        
        return view('user.books.comments.edit')->with(array(
            'book' => $book,
            'comment' => $comment
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $cid)
    {
        $comment = Comment::findOrFail($cid);
        $comment->title = $request->input('title');
        $comment->body = $request->input('body');
        
        $comment->save();
        
        $session = $request->session()->flash('message', 'Comment updated successfully!');

        return redirect()->route('user.books.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id, $cid)
    {
        $comment = Comment::findOrFail($cid);
        
        $comment->delete();
        
        $session = $request->session()->flash('message', 'Comment deleted successfully!');

        return redirect()->route('user.books.show', $id);
    }
}
