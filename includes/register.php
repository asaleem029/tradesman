<?php
include_once '../init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST) && $_POST['action_type'] == 'REGISTER_NEW_USER') {

    $errors = array();
    $user_obj = new User();

    //Name
    if (empty($_POST['name'])) {
        $errors[] = 'Enter your name.';
    } else {
        $name = $db->real_escape_string(trim($_POST['name']));
    }

    //Email
    if (empty($_POST['email'])) {
        $errors[] = 'Enter your email';
    } else {
        $email = $db->real_escape_string(trim($_POST['email']));
    }

    //Password1 and password2 check 
    if (!empty($_POST['password'])) {
        if ($_POST['password'] != $_POST['c_password']) {
            $errors[] = 'Passwords do not match.';
        } else {
            $password = $db->real_escape_string(trim($_POST['password']));
        }
    } else {
        $errors[] = 'Enter your password.';
    }

    //check errors and if email already exists
    if (empty($errors)) {

        $email_result = $user_obj->checkEmail($db, $email);

        if ($email_result != 0) {
            $errors[] = "Email address already registered. <a href='../login.php'>Login</a>";
        }
    }

    // check errors and insert data into database, otherwise throw error.
    if (empty($errors)) {
        $user_obj->registerNewUser($db, $_POST);
    } else {
        echo '<h1>Error!</h1>
	         <p id="err_msg">The following error(s) occurred:<br>';
        foreach ($errors as $msg) {
            echo " - $msg<br>";
        }
        echo 'Please try again.</p>';
        exit;
    }
}
