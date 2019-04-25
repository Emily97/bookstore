@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <p id="alert-message" class="alert collapse"></p>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Books

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-link btn-book-add">
                      Add
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="modal-book-heading"></h4>
                                </div>
                                <div class="modal-body">
                                    <form id="form-book">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" value="" />
                                            <span class="error" id="error-title"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="author">Author</label>
                                            <input type="text" class="form-control" id="author" name="author" value="" />
                                            <span class="error" id="error-author"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="publisher">Publisher</label>
                                            <input type="text" class="form-control" id="publisher" name="publisher" value="" />
                                            <span class="error" id="error-publisher"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="year">Year</label>
                                            <input type="number" class="form-control" id="year" name="year" value="" />
                                            <span class="error" id="error-year"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="isbn">ISBN</label>
                                            <input type="text" class="form-control" id="isbn" name="isbn" value="" />
                                            <span class="error" id="error-isbn"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="number" class="form-control" id="price" name="price" value="" />
                                            <span class="error" id="error-price"></span>
                                        </div>
                                    </form>
                              </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="btn-submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        <button type="button" class="btn btn-default btn-book-view">View</button>
                                        <button type="button" class="btn btn-warning btn-book-edit">Edit</button>
                                        <button type="button" class="btn btn-danger btn-book-delete">Delete</button>
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
