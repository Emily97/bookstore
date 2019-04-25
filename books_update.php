<?php
require_once 'classes/Book.php';
require_once 'classes/Publisher.php';
require_once 'classes/Gump.php';

try {
    $validator = new GUMP();

    $_POST = $validator->sanitize($_POST);

    $validation_rules = array(
        'id' => 'required|integer|min_numeric,1',
        'title' => 'required|min_len,1|max_len,100',
        'author' => 'required|min_len,1|max_len,50',
        'isbn' => 'required|numeric|exact_len,13|min_numeric,0',
        'year' => 'required|numeric|exact_len,4|min_numeric,1900',
        'price' => 'required|float|min_numeric,0',
        'publisher_id' => 'required|integer|min_numeric,1'
    );
    $filter_rules = array(
    	'id' => 'trim|sanitize_numbers',
        'title' => 'trim|sanitize_string',
        'author' => 'trim|sanitize_string',
        'isbn' => 'trim|sanitize_numbers',
        'year' => 'trim|sanitize_numbers',
        'price' => 'trim|sanitize_floats',
        'publisher_id' => 'trim|sanitize_numbers'
    );

    $validator->validation_rules($validation_rules);
    $validator->filter_rules($filter_rules);

    $validated_data = $validator->run($_POST);

    if($validated_data === false) {
        $errors = $validator->get_errors_array();
    }
    else {
        $errors = array();

        $publisher_id = $validated_data['publisher_id'];
        $publisher = Publisher::find($publisher_id);
        if ($publisher === false) {
            $errors['publisher_id'] = "Invalid publisher";
        }
    }

    if (!empty($errors)) {
        throw new Exception("There were errors. Please fix them.");
    }

    $id = $validated_data['id'];
    $book = Book::find($id);
    $book->title = $validated_data['title'];
    $book->author = $validated_data['author'];
    $book->isbn = $validated_data['isbn'];
    $book->year = $validated_data['year'];
    $book->price = $validated_data['price'];
    $book->publisher_id = $validated_data['publisher_id'];
    $book->save();

    header("Location: books_index.php");
}
catch (Exception $ex) {
    require 'books_edit.php';
}
?>
