<?php
if (!isset($_SESSION)) {
	session_start();
}

include_once '../init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST) && $_POST['action_type'] == 'LOGIN') {

	$login = new Login();

	list($check, $data) = $login->validate($db, $_POST['email'], $_POST['pass']);

	if ($check) {
		unset($_SESSION['users']);
		$_SESSION['user'] = $data;

		if ($data['user_type_id'] == 2) {
			myAlert("LoggedIn Successfully", '../complete_profile.php?id=' . $data['id']);
		} else {
			myAlert("LoggedIn Successfully", '../home.php');
		}
	} else {
		myAlert($data, '../login.php');
	}

	$db->close();
}
