@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <p id="alert-message" class="alert collapse"></p>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Books
                </div>

                <div class="panel-body">
                    @if (count($books) === 0)
                        <p>There are no books!</p>
                    @else
                        <table id="table-books" class="table table-hover">
                            <thead>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Publisher</th>
                                <th>Year</th>
                                <th>ISBN</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                        @foreach ($books as $book)
                                <tr data-id="{{ $book->id }}">
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ $book->publisher }}</td>
                                    <td>{{ $book->year }}</td>
                                    <td>{{ $book->isbn }}</td>
                                    <td>{{ $book->price }}</td>
                                    <td>
                                        <a href="{{ route('user.books.show', $book->id) }}" class="btn btn-default btn-book-view">View</a>
                                   </td>
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
