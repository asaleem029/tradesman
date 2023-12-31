<?php
session_start();
require('../connect_db.php');
require('../classes/login.php');
include 'helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST) && $_POST['action_type'] == 'LOGIN') {

	$login = new Login();

	list($check, $data) = $login->validate($db, $_POST['email'], $_POST['pass']);

	if ($check) {
		$_SESSION['id'] = $data['id'];
		$_SESSION['name'] = $data['name'];
		$_SESSION['email'] = $data['email'];

		load('../home.php');
	} else {
		myAlert($data, '../login.php');
	}

	$db->close();
}
