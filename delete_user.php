<?php
include 'home.php';
include 'connect_db.php';
include 'classes/user.php';
include 'includes/helper.php';

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