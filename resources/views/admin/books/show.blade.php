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
                          
                    <a href="{{ route('admin.books.index2') }}" class="btn btn-default">Back</a>
                    <a href="{{ route('admin.books.edit', array('book' => $book)) }}"
                       class="btn btn-warning">Edit</a>
                    <form style="display:inline-block" method="POST" action="{{ route('admin.books.destroy', array('book' => $book)) }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="form-control btn btn-danger">Delete</button>
                    </form>
                    
                    <h2>
                        Comments 
                    </h2>
                    @if (count($book->comments()->get()) == 0)
                    <p>There are no comments for this book.</p>
                    @else
                    <table class="table">
                        <thead>
                            <th>Title</th>
                            <th>Body</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @foreach ($book->comments()->get() as $comment)
                            <tr>
                                <th>{{ $comment->title }}</th>
                                <th>{{ $comment->body }}</th>
                                <th>
                                    <form style="display:inline-block" method="POST" action="{{ route('admin.comments.destroy', array('id' => $book->id, 'cid' => $comment->id)) }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="form-control btn btn-danger">Delete</a>
                                    </form>
                                </th>
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
