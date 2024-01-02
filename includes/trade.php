<?php
if (!isset($_SESSION)) {
    session_start();
}

require('../connect_db.php');
include '../classes/trade.php';
include 'helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST) && $_POST['action_type'] == 'ADD_NEW_TRADE') {

    $errors = array();
    $trade_obj = new Trade();

    //Name
    if (empty($_POST['name'])) {
        $errors[] = 'Enter name.';
    } else {
        $name = $db->real_escape_string(trim($_POST['name']));
    }

    // check errors and insert data into database, otherwise throw error.
    if (empty($errors)) {
        $result = $trade_obj->addNewTrade($db, $_POST);

        if ($result) {
            myAlert("Trade Created Successfully", '../trades_list.php');
        }

        exit();
    } else {
        echo '<h1>Error!</h1>
	         <p id="err_msg">The following error(s) occurred:<br>';
        foreach ($errors as $msg) {
            echo " - $msg<br>";
        }
        echo 'Please try again.</p>' .
            '<a href="../add_new_trade.php">Back</a>';
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST) && $_POST['action_type'] == 'UPDATE_TRADE_DETAILS') {

    $errors = array();
    $trade_obj = new Trade();

    //Name
    if (empty($_POST['name'])) {
        $errors[] = 'Enter your name.';
    } else {
        $name = $db->real_escape_string(trim($_POST['name']));
    }

    // check errors and insert data into database, otherwise throw error.
    if (empty($errors)) {
        $result = $trade_obj->updateTrade($db, $_POST);

        if ($result) {
            myAlert($result, '../trades_list.php');
        }

        exit();
    } else {
        echo '<h1>Error!</h1>
                 <p id="err_msg">The following error(s) occurred:<br>';
        foreach ($errors as $msg) {
            echo " - $msg<br>";
        }
        echo 'Please try again.</p>' .
            '<a href="../edit_trade.php?id=' . $_POST['id'] . '"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>';
        exit;
    }
}
