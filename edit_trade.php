<?php
include 'header.php';

if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['user']['id'])) {
	require('includes/helper.php');
	load();
}

include 'connect_db.php';
include 'classes/trade.php';

$trade = new Trade();
$trade_detail = $trade->getTrade($db, $_GET['id']);
?>

<!-- Display body section with sticky form. -->
<form action="includes/trade.php" method="post" class="form-signin" role="form">
	<h3 class="form-signin-heading">Update Details</h3>
	<input type="hidden" id="action_type" name="action_type" value="UPDATE_TRADE_DETAILS">

	<div class="form-group">
		<div class="row">
			<div class="col">
				<label for="id">ID</label>
				<input class="form-control" type="text" name="id" size="20" value="<?php if (isset($trade_detail['id'])) echo $trade_detail['id']; ?>" readonly>
			</div>

			<div class="col">
				<label for="name">Name</label>
				<input class="form-control" type="text" name="name" size="20" value="<?php if (isset($trade_detail['name'])) echo $trade_detail['name']; ?>" placeholder="Enter Name">
			</div>
		</div>
	</div>

	<a class="btn btn-primary" href="view_users.php">
		<i class="fa fa-arrow-left" aria-hidden="true"></i>
		Back
	</a>
	<button class="btn btn-primary" name="submit" type="submit">Update</button>
</form>

<?php include('footer.php') ?>