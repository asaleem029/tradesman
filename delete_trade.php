<?php
include 'home.php';
include 'connect_db.php';
include 'classes/trade.php';
include 'includes/helper.php';

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