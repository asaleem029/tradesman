<?php
require('../connect_db.php');
include '../classes/user.php';
include 'helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST) && $_POST['action_type'] == 'ADD_NEW_USER') {

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

    //Phone
    if (empty($_POST['phone'])) {
        $errors[] = 'Enter your phone';
    } else {
        $phone = $db->real_escape_string(trim($_POST['phone']));
    }

    //hourly_rate
    if (empty($_POST['hourly_rate'])) {
        $errors[] = 'Enter your hourly_rate';
    } else {
        $hourly_rate = $db->real_escape_string(trim($_POST['hourly_rate']));
    }

    //city
    if (empty($_POST['city'])) {
        $errors[] = 'Enter your city';
    } else {
        $city = $db->real_escape_string(trim($_POST['city']));
    }

    //country
    if (empty($_POST['country'])) {
        $errors[] = 'Enter your country';
    } else {
        $country = $db->real_escape_string(trim($_POST['country']));
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

    //summary
    if (empty($_POST['summary'])) {
        $errors[] = 'Enter your summary';
    } else {
        $summary = $db->real_escape_string(trim($_POST['summary']));
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
            '<a href="../add_new_user.php">Back</a>';
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST) && $_POST['action_type'] == 'UPDATE_USER_DETAILS') {

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

    //Phone
    if (empty($_POST['phone'])) {
        $errors[] = 'Enter your phone';
    } else {
        $phone = $db->real_escape_string(trim($_POST['phone']));
    }

    //hourly_rate
    if (empty($_POST['hourly_rate'])) {
        $errors[] = 'Enter your hourly_rate';
    } else {
        $hourly_rate = $db->real_escape_string(trim($_POST['hourly_rate']));
    }

    //city
    if (empty($_POST['city'])) {
        $errors[] = 'Enter your city';
    } else {
        $city = $db->real_escape_string(trim($_POST['city']));
    }

    //country
    if (empty($_POST['country'])) {
        $errors[] = 'Enter your country';
    } else {
        $country = $db->real_escape_string(trim($_POST['country']));
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

    //summary
    if (empty($_POST['summary'])) {
        $errors[] = 'Enter your summary';
    } else {
        $summary = $db->real_escape_string(trim($_POST['summary']));
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
            '<a href="../add_new_users.php">Back</a>';
        exit;
    }
}
