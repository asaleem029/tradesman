<?php
if (!isset($_SESSION)) {
	session_start();
}

require('includes/helper.php');
if (!isset($_SESSION['user']['id'])) {
	load();
}

include 'connect_db.php';
include 'classes/trade.php';

$trade = new Trade();
$trade_detail = $trade->getTrade($db, $_GET['id']);

if (!empty($trade_detail['id'])) {
	$trade_deleted = $trade->deletetrade($db, $trade_detail['id']);
	myAlert($trade_deleted, "trades_list.php");
} else {
	load("trades_list.php");
}
?>

<?php include 'footer.php' ?>