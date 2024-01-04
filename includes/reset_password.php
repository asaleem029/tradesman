<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once '../init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST) && $_POST['action_type'] == 'RESET_PASSWORD') {

    $errors = array();
    $user = '';

    if (empty($_POST['email'])) {
        $errors[] = 'You forgot to enter your email address.';
    } else {
        $e = $db->real_escape_string(trim($_POST['email']));

        $user_obj = new User();
        $user = $user_obj->checkEmail($db, $e);

        if (empty($user)) {
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
        $_SESSION['reset_password']['new_password'] = $_POST['new_password'];
        $_SESSION['reset_password']['email'] = $_POST['email'];
        $verify_otp_obj = new VerifyOTP();
        $verify_otp_obj->getOTP($user, $_POST['email'], 'RESET_PASSWORD');
    } else {
        echo '<h1>Error!</h1>
    		<p class="error">The following error(s) occurred:<br />';
        foreach ($errors as $msg) {
            echo " - $msg<br />\n";
        }

        load('../reset_password.php');
    }
}
