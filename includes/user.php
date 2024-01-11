<?php
include_once '../init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_type']) && $_POST['action_type'] == 'ADD_NEW_USER') {

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

    //user_type_id
    if (empty($_POST['user_type_id'])) {
        $errors[] = 'Enter your user_type_id';
    } else {
        $user_type_id = $db->real_escape_string(trim($_POST['user_type_id']));
    }

    //status
    if (empty($_POST['status'])) {
        $errors[] = 'Enter your status';
    } else {
        $status = $db->real_escape_string(trim($_POST['status']));
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
            myAlert("Email already registered", '../add_new_user.php');
        }
    }

    // check errors and insert data into database, otherwise throw error.
    if (empty($errors)) {
        $result = $user_obj->addNewUser($db, $_POST);

        if ($result) {
            myAlert("User Created Successfully", '../view_users.php');
        }

        exit();
    } else {
        echo '<h1>Error!</h1>
	         <p id="err_msg">The following error(s) occurred:<br>';
        foreach ($errors as $msg) {
            echo " - $msg<br>";
        }
        echo 'Please try again.</p>' .
            '<a href="../add_new_user.php"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>';
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_type']) && $_POST['action_type'] == 'UPDATE_USER_DETAILS') {

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

    //user_type_id
    if (empty($_POST['user_type_id'])) {
        $errors[] = 'Enter your user_type_id';
    } else {
        $user_type_id = $db->real_escape_string(trim($_POST['user_type_id']));
    }

    //status
    if (empty($_POST['status'])) {
        $errors[] = 'Enter your status';
    } else {
        $status = $db->real_escape_string(trim($_POST['status']));
    }

    //check errors and if email already exists
    if (empty($errors)) {
        $email_result = $user_obj->getUserEmail($db, $_POST['id']);

        if ($email_result != $_POST['email']) {
            $email_result = $user_obj->getUserEmail($db, $email);

            if ($email_result != 0) {
                myAlert("Email already registered", '../edit_user.php?id=' . $_POST['id']);
            }
        }
    }

    // check errors and insert data into database, otherwise throw error.
    if (empty($errors)) {
        $result = $user_obj->updateUserDetails($db, $_POST);

        if ($result) {
            myAlert($result, '../view_users.php');
        }

        exit();
    } else {
        echo '<h1>Error!</h1>
                 <p id="err_msg">The following error(s) occurred:<br>';
        foreach ($errors as $msg) {
            echo " - $msg<br>";
        }
        echo 'Please try again.</p>' .
            '<a href="../edit_user.php?id=' . $_POST['id'] . '">Back</a>';
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_type']) && $_POST['action_type'] == 'EDIT_PROFILE') {
    $user_obj = new User();
    $result = $user_obj->updateProfile($db, $_POST);

    // if ($result) {
    //     myAlert($result, "../view_profile.php?id={$_POST['id']}");
    // }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_type']) && $_POST['action_type'] == 'UPDATE_USER_STATUS') {
    $user_obj = new User();
    $result = $user_obj->updateUserStatus($db, $_POST);

    if ($result) {
        echo $result;
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_type']) && $_POST['action_type'] == 'RATE_TRADEMAN') {
    $user_obj = new User();
    $result = $user_obj->addRating($db, $_POST);

    if ($result) {
        myAlert($result, '../index.php');
    }
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_type']) && $_POST['action_type'] == 'ADD_AVAILABILITY') {

    if (isset($_POST['available_from']) && !empty($_POST['available_from']) && isset($_POST['available_to']) && !empty($_POST['available_to'])) {
        $user_obj = new User();
        $result = $user_obj->addAvailability($db, $_POST);

        if ($result) {
            myAlert($result, '../index.php');
        }
    } else {
        myAlert("Please Add Dates", '../add_tradesman_availability.php?id=' . $_SESSION['user']['id']);
    }
    exit;
}
