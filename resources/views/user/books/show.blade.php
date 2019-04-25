@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Book: {{ $book->title }}
                </div>

                <div class="panel-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>Title</td>
                                <td>{{ $book->title }}</td>
                            </tr>
                            <tr>
                                <td>Author</td>
                                <td>{{ $book->author }}</td>
                            </tr>
                            <tr>
                                <td>Publisher</td>
                                <td>{{ $book->publisher }}</td>
                            </tr>
                            <tr>
                                <td>Year</td>
                                <td>{{ $book->year }}</td>
                            </tr>
                            <tr>
                                <td>ISBN</td>
                                <td>{{ $book->isbn }}</td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td>{{ $book->price }}</td>
                            </tr>
                        </tbody>
                    </table>
                          
                    <a href="{{ route('user.books.index') }}" class="btn btn-default">Back</a>
                    
                    <h2>
                        Comments 
                        <a href="{{ route('user.comments.create', $book->id) }}" class="btn btn-link btn-book-add">Add</a>
                    </h2>
                    @if (count($book->comments()->get()) == 0)
                    <p>There are no comments for this book.</p>
                    @else
                    <table class="table">
                        <thead>
                            <th>Title</th>
                            <th>Body</th>
                        </thead>
                        <tbody>
                            @foreach ($book->comments()->get() as $comment)
                            <tr>
                                <th>{{ $comment->title }}</th>
                                <th>{{ $comment->body }}</th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
