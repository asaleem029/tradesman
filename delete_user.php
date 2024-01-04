<?php
if (!isset($_SESSION)) {
	session_start();
}

require('includes/helper.php');

if (!isset($_SESSION['user']['id'])) {
	load();
}
include 'connect_db.php';
include 'classes/user.php';

$user = new User();
$user_detail = $user->getUser($db, $_GET['id']);

if (!empty($user_detail['id'])) {
	$user_deleted = $user->deleteUser($db, $user_detail['id']);
	myAlert($user_deleted, "view_users.php");
} else {
	load("view_users.php");
}
?>

<?php include 'footer.php' ?>