<?php
include_once 'header.php';
include_once 'connect_db.php';
include_once 'classes/user.php';
include_once 'classes/trade.php';

$user = new User();

$trade = new Trade();
$trades = $trade->getTradesList($db);
$tradesman_list = array();

// FIND TRADESMAN
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_type']) && $_POST['action_type'] == 'FIND_TRADEMAN') {
	$user_obj = new User();
	$tradesman_list = $user_obj->getTradesman($db, $_POST);
}
?>

<form action="find_trademan.php" method="post">
	<input type="hidden" name="action_type" value="FIND_TRADEMAN">

	<div class="form-group">
		<div class="row">
			<div class="input-group tm-search-bar">
				<input type="text" class="form-control m-1" name="city" placeholder="City...">

				<select class="form-control m-1" name="trade_id" id="">
					<option value="">-- Select Trade --</option>
					<?php foreach ($trades as $trade) { ?>
						<option value="<?= $trade['id'] ?>"><?= $trade['name'] ?></option>
					<?php } ?>
				</select>

				<input type="date" class="form-control m-1" name="date" placeholder="Search...">

				<div class="input-group-prepend m-1">
					<button class="btn btn-primary" type="submit">
						<i class="fas fa-search"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
</form>

<?php

if (isset($tradesman_list) && !empty($tradesman_list)) {
	echo '<pre>' . print_r($tradesman_list, true) . '</pre>';
}
?>


<?php include 'footer.php' ?>