<?php

include '../connect_db.php';
include '../classes/user.php';
include '../classes/reset_password.php';
include '../includes/helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST) && $_POST['action_type'] == 'RESET_PASSWORD') {

    $errors = array();

    if (empty($_POST['email'])) {
        $errors[] = 'You forgot to enter your email address.';
    } else {
        $e = $db->real_escape_string(trim($_POST['email']));

        $user_obj = new User();

        $user_email = $user_obj->checkEmail($db, $e);

        if (empty($user_email)) {
            myAlert("Email Not Found", '../reset_password.php');
        }
    }

    if (empty($_POST['new_password'])) {
        $errors[] = 'You forgot to enter your new password.';
    }

    if ($_POST['new_password'] != $_POST['c_password']) {
        $errors[] = 'Your new password did not match the confirmed password.';
    } else {
        $np = $db->real_escape_string(trim($_POST['new_password']));
    }

    if (empty($errors)) {
        $reset_password_obj = new ResetPassword();
        $reset_password_obj->reset_password($db, $_POST);
    } else {
        echo '<h1>Error!</h1>
    		<p class="error">The following error(s) occurred:<br />';
        foreach ($errors as $msg) {
            echo " - $msg<br />\n";
        }

        load('../reset_password.php');
    }
}
