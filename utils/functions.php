<?php
function is_logged_in() {
    start_session();
    return (isset($_SESSION['user']));
}

function start_session() {
    $id = session_id();
    if ($id === "") {
        session_start();
    }
}

function old($index, $default = null) {
    if (isset($_POST) && is_array($_POST) && array_key_exists ($index, $_POST)) {
        echo $_POST[$index];
    }
    else if ($default !== null) {
        echo $default;
    }
}

function error($index) {
    global $errors;

    if (isset($errors) && is_array($errors) && array_key_exists ($index, $errors)) {
        echo $errors[$index];
    }
}
?>
