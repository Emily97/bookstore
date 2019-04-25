$(document).ready(function(){
    
    var modalBookId = null;
    var modalState = "closed";
    
    $('#modal-form').on('hidden.bs.modal', function (e) {
        $(this)
            .find("h4#modal-book-heading")
                .text('')
                .end()
            .find("input,textarea,select")
                .val('')
                .prop('disabled', false)
                .removeClass('error')
                .end()
            .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .prop('disabled', false)
                .removeClass('error')
                .end()
            .find("span.error")
                .text('')
                .end();
        
        modalBookId = null;
        modalState = "closed";
    });
    
    $('#btn-submit').on('click', function(){
        if (modalState === "add") {
            storeBook();
        }
        else if (modalState === "edit") {
            updateBook();
        }
        else if (modalState === "delete") {
            deleteBook();
        }
    });
    
    $('.btn-book-add').on('click', function() {
        modalState = "add";
        $('#modal-book-heading').text("Add new book");
        $('#btn-submit').show();
        $('#btn-submit').text("Store");
        $('#modal-form').modal('show');
    });
    
    $("#table-books").on('click', '.btn-book-view', function() {
        modalBookId = $(this).closest('tr').data('id');
        modalState = "view";
        $.ajax("api/books/" + modalBookId, {
            contentType: 'application/json',
            method: 'GET',
            success: function (response) {
                // if the book was retrieve ok, display in the modal with form controls disabled
                if (response.status === 200) {
                    var book = response.data;
                    populateForm(book, true);
                    $('#modal-book-heading').text("View book details");
                    $('#btn-submit').hide();
                    $('#modal-form').modal('show');
                }
                // if the  book was not found, display an error message
                else if (response.status === 404) {
                    showMessage("Book not found", "alert-warning");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                showMessage("Server error: " + textStatus, "alert-warning");}
        });
    });
    
    $('#table-books').on('click', '.btn-book-edit', function() {
        modalBookId = $(this).closest('tr').data('id');
        modalState = "edit";
        // send a GET request to the URL 'api/books'
        $.ajax("api/books/" + modalBookId, {
            contentType: 'application/json',
            method: 'GET',
            // if the AJAX request is successful, execute this function
            success: function (response) {
                // if the book was retrieve ok, display in the modal with form controls enabled
                if (response.status === 200) {
                    var book = response.data;
                    populateForm(book, false);
                    $('#modal-book-heading').text("Edit book details");
                    $('#btn-submit').text("Update").show();
                    $('#modal-form').modal('show');
                }
                // if the  book was not found, display an error message
                else if (response.status === 404) {
                    showMessage("Book not found", "alert-warning");
                }
            },
            // if there is an error with the AJAX request, execute this function
            error: function (jqXHR, textStatus, errorThrown) {
                showMessage("Server error: " + textStatus, "alert-warning");
            }
        });
    });
    
    $('#table-books').on('click', '.btn-book-delete', function() {
        modalState = "delete";
        modalBookId = $(this).closest('tr').data('id');
        // send a GET request to the URL 'api/books/{id}'
        $.ajax("api/books/" + modalBookId, {
            contentType: 'application/json',
            method: 'GET',
            // if the AJAX request is successful, execute this function
            success: function (response) {
                // if the book was retrieve ok, display in the modal with form controls disabled
                if (response.status === 200) {
                    var book = response.data;
                    populateForm(book, true);
                    $('#modal-book-heading').text("Confirm book deletion");
                    $('#btn-submit').text("Delete").show();
                    $('#modal-form').modal('show');
                }
                // if the  book was not found, display an error message
                else if (response.status === 404) {
                    showMessage("Book not found", "alert-warning");
                }
            },
            // if there is an error with the AJAX request, execute this function
            error: function (jqXHR, textStatus, errorThrown) {
                showMessage("Server error: " + textStatus, "alert-warning");}
        });
        $('#btn-submit').show();
        $('#modal-form').modal('show');
    });
    
    function storeBook() {
        var form = $('#form-book').get(0);
        var formData = $(form).serializeArray();
        var data = {};
        formData.map(function(x){
            data[x.name] = x.value;
        });
        // send a POST request to the URL 'api/books' with the details of the new book encoded as
        // a JSON string in the body of the request
        $.ajax('api/books', {
            contentType: 'application/json',
            dataType: 'json',
            method: 'POST',
            data: JSON.stringify(data),
            // if the AJAX request is successful, execute this function
            success: function (response) {
                // if the book was stored ok, dismiss the modal, add the book to the table, and
                // display a message
                if (response.status === 200) {
                    var book = response.data;
                    $('#modal-form').modal('hide');
                    addTableRow(book);
                    showMessage("Book added successfully", "alert-success");
                }
                // if there was validation errors with the book data, display the error messages
                else if (response.status === 422) {
                    var errors = response.data;
                    for (var prop in errors) {
                        var message = errors[prop][0];
                        $('#error-' + prop, form).text(message);
                    }
                }
            },
            // if there is an error with the AJAX request, execute this function
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    }

    function updateBook() {
        var form = $('#form-book').get(0);
        var formData = $(form).serializeArray();
        var data = {};
        formData.map(function(x){
            data[x.name] = x.value;
        });
        data.id = modalBookId;
        // send a PUT request to the URL 'api/books/{id}' with the updated details of the book
        // encoded as a JSON string in the body of the request
        $.ajax('api/books/' + modalBookId, {
            contentType: 'application/json',
            dataType: 'json',
            method: 'PUT',
            data: JSON.stringify(data),
            // if the AJAX request is successful, execute this function
            success: function (response) {
                // if the book was updated ok, dismiss the modal, update the book in the table,
                // and display a message
                if (response.status === 200) {
                    var book = response.data;
                    $('#modal-form').modal('hide');
                    updateTableRow(book);
                    showMessage("Book updated successfully", "alert-success");
                }
                // if the book could not be found, dismiss the modal and display an error message
                else if (response.status === 404) {
                    $('#modal-form').modal('hide');
                    showMessage("Book could not be found", "alert-warning");
                }
                // if there was validation errors with the book data, display the error messages
                else if (response.status === 422) {
                    var errors = response.data;
                    for (var prop in errors) {
                        var message = errors[prop][0];
                        $('#error-' + prop, form).text(message);
                    }
                }
            },
            // if there is an error with the AJAX request, execute this function
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    }
    
    function deleteBook() {
        // send a DELETE request to the URL 'api/books/{id}'
        $.ajax('api/books/' + modalBookId, {
            method: 'DELETE',
            // if the AJAX request is successful, execute this function
            success: function (response) {
                // if the book was deleted ok, dismiss the modal, delete the book from the table,
                // and display a message
                if (response.status === 200) {
                    $('#modal-form').modal('hide');
                    deleteTableRow(modalBookId);
                    showMessage("Book deleted successfully", "alert-success");
                }
                // if the book could not be found, dismiss the modal and display an error message
                else if (response.status === 404) {
                    $('#modal-form').modal('hide');
                    showMessage("Book could not be found", "alert-warning");
                }
            },
            // if there is an error with the AJAX request, execute this function
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    }
    
    function populateForm(book, disabled) {
        var form = $('#form-book').get(0);
        $('#title', form).val(book.title).prop("disabled", disabled);
        $('#author', form).val(book.author).prop("disabled", disabled);
        $('#publisher', form).val(book.publisher).prop("disabled", disabled);
        $('#year', form).val(book.year).prop("disabled", disabled);
        $('#isbn', form).val(book.isbn).prop("disabled", disabled);
        $('#price', form).val(book.price).prop("disabled", disabled);
    }
    
    function addTableRow(book) {
        var row = '<tr data-id="' + book.id + '">' +
                      '<td>' + book.title + '</td>' +
                      '<td>' + book.author + '</td>' +
                      '<td>' + book.publisher + '</td>' +
                      '<td>' + book.year + '</td>' +
                      '<td>' + book.isbn + '</td>' +
                      '<td>' + book.price + '</td>' +
                      '<td>' +
                          '<button type="button" class="btn btn-default btn-book-view">View</button> ' +
                          '<button type="button" class="btn btn-warning btn-book-edit">Edit</button> ' +
                          '<button type="button" class="btn btn-danger btn-book-delete">Delete</button> ' +
                      '</td>' +
                  '</tr>';

        $('#table-books tbody').append(row);
    }
    
    function updateTableRow(book) {
        var tableRow = $('tr[data-id="' + modalBookId + '"]');
        var tableCells = $('td', tableRow);
        $(tableCells[0]).text(book.title);
        $(tableCells[1]).text(book.author);
        $(tableCells[2]).text(book.publisher);
        $(tableCells[3]).text(book.year);
        $(tableCells[4]).text(book.isbn);
        $(tableCells[5]).text(book.price);
    }
    
    function deleteTableRow($id) {
        var tableRow = $('tr[data-id="' + modalBookId + '"]');
        tableRow.remove();
    }
    
    function showMessage(message, type) {
        // config the message and display it
        $('#alert-message').text(message);
        $('#alert-message').addClass(type);
        $('#alert-message').show();
        // set a timeout function to remove the message in 5 seconds
        setTimeout(function () {
            $('#alert-message').hide();
            $('#alert-message').removeClass(type);
        }, 5000);
    }
});
